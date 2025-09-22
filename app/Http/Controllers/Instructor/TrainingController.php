<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TrainingController extends Controller
{
    /**
     * Get available years for attendance list filter
     */
    public function getYears(Request $request): JsonResponse
    {
        $currentYear = Carbon::now()->year;
        $years = [];
        
        // Current year and 3 previous years
        for ($i = 0; $i < 4; $i++) {
            $year = $currentYear - $i;
            $years[] = $year;
        }
        
        return response()->json([
            'success' => true,
            'years' => $years
        ]);
    }

    /**
     * Get available months for a specific year
     */
    public function getMonths(Request $request): JsonResponse
    {
        $year = $request->input('year');
        
        if (!$year) {
            return response()->json([
                'success' => false,
                'message' => 'Year is required'
            ]);
        }

        $months = Training::whereYear('start_datetime', $year)
            ->selectRaw('DISTINCT MONTH(start_datetime) as month')
            ->orderBy('month', 'desc')
            ->pluck('month')
            ->toArray();

        return response()->json([
            'success' => true,
            'months' => $months
        ]);
    }

    /**
     * AJAX endpoint for attendance list modal - Enhanced version
     */
    public function getCadetAttendanceList(Request $request): JsonResponse
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $intake = $request->input('intake');
        $status = $request->input('status');

        if (!$year || !$month) {
            return response()->json([
                'success' => false,
                'message' => 'Year and month are required'
            ]);
        }

        // Get all trainings for the specified year and month
        $query = Training::whereYear('start_datetime', $year)
            ->whereMonth('start_datetime', $month);

        // Filter by intake if specified
        if ($intake) {
            $query->where('involvement', 'LIKE', "%$intake%");
        }

        $trainings = $query->orderBy('start_datetime', 'desc')->get();

        $result = $trainings->map(function($training) use ($status, $intake) {
            // Get attendance records with cadet and user information
            $attendanceQuery = $training->trainingAttendances()
                ->with(['cadet.user'])
                ->join('cadets', 'training_attendances.cadet_id', '=', 'cadets.id')
                ->join('users', 'cadets.user_id', '=', 'users.id');

            // Apply status filter if specified
            if ($status && in_array($status, ['present', 'absent'])) {
                $attendanceQuery->where('training_attendances.present', $status === 'present');
            }

            // Apply intake filter if specified
            if ($intake && preg_match('/Intake - (\d+)/', $intake, $matches)) {
                $intakeNumber = (int) $matches[1];
                $intakeYear = 2011 + $intakeNumber;
                $attendanceQuery->where('cadets.intake_year', $intakeYear);
            }

            $attendances = $attendanceQuery
                ->select('training_attendances.*')
                ->orderByRaw('CAST(cadets.service_number AS UNSIGNED) ASC')
                ->get();

            $cadets = $attendances->map(function($attendance) {
                $cadet = $attendance->cadet;
                $user = $cadet->user;
                
                return [
                    'id' => $cadet->id,
                    'service_number' => $cadet->service_number ?? '',
                    'rank' => $cadet->rank ?? '',
                    'name' => $user->name ?? 'Unknown',
                    'matric_no' => $cadet->matric_no ?? '',
                    'present' => $attendance->present,
                    'absence_reason' => $attendance->absence_reason,
                    'file_url' => $attendance->file_url,
                    'marked_at' => $attendance->marked_at ? $attendance->marked_at->format('H:i') : null,
                    'method' => $attendance->method
                ];
            });

            // Get available intakes for this training
            $availableIntakes = [];
            if ($training->involvement) {
                $involvements = explode(', ', $training->involvement);
                foreach ($involvements as $involvement) {
                    if (preg_match('/Intake - (\d+)/', $involvement, $matches)) {
                        $availableIntakes[] = $involvement;
                    }
                }
            }

            return [
                'id' => $training->id,
                'title' => $training->title,
                'location' => $training->location,
                'start_datetime' => $training->start_datetime->format('d M Y, H:i'),
                'involvement' => $training->involvement,
                'available_intakes' => $availableIntakes,
                'cadets' => $cadets,
                'summary' => [
                    'total' => $cadets->count(),
                    'present' => $cadets->where('present', true)->count(),
                    'absent' => $cadets->where('present', false)->count()
                ]
            ];
        });

        // Filter out trainings with no cadets (if status filter applied)
        $result = $result->filter(function($training) {
            return $training['cadets']->count() > 0;
        });

        return response()->json([
            'success' => true,
            'trainings' => $result->values()
        ]);
    }

    /**
     * Get all attendance list data for the modal
     */
    public function getAllAttendanceList(Request $request): JsonResponse
    {
        // This method can be used for any additional functionality needed
        return $this->getCadetAttendanceList($request);
    }

    // ... rest of your existing methods remain unchanged ...

    /**
     * Display the training schedule page
     */
    public function index()
    {
        // Update statuses before displaying
        $this->updateExpiredTrainings();
        
        $trainings = Training::with('trainingAttendances')->orderBy('start_datetime', 'asc')->get();
        
        // Get today's trainings
        $todaysTrainings = Training::where(function ($query) {
            $now = Carbon::now();
            $today = $now->toDateString();
            $yesterday = $now->copy()->subDay()->toDateString();
            
            $query->whereDate('start_datetime', $today)
                  ->orWhere(function ($q) use ($today, $yesterday) {
                      $q->whereDate('start_datetime', $yesterday)
                        ->where('status', 'Active');
                  })
                  ->orWhere(function ($q) use ($now) {
                      $q->where('start_datetime', '<=', $now)
                        ->where(function ($subQ) use ($now) {
                            $subQ->whereNull('end_datetime')
                                 ->orWhere('end_datetime', '>=', $now->copy()->subDay());
                        });
                  });
        })->orderBy('start_datetime', 'asc')->get();
        
        // Format trainings for calendar
        $calendarEvents = $trainings->map(function ($training) {
            return [
                'id' => $training->id,
                'title' => $training->title,
                'start' => $training->start_datetime->format('Y-m-d H:i:s'),
                'end' => $training->end_datetime ? $training->end_datetime->format('Y-m-d H:i:s') : null,
                'backgroundColor' => $this->getStatusColor($training->status),
                'borderColor' => $this->getStatusColor($training->status),
            ];
        });

        return view('instructor.training', compact('trainings', 'calendarEvents', 'todaysTrainings'));
    }

    /**
     * Get cadets for attendance by training involvement
     */
    public function getCadetsForAttendance(Training $training): JsonResponse
    {
        if (!$training->involvement) {
            return response()->json([
                'success' => false,
                'message' => 'No involvement specified for this training'
            ]);
        }

        // Only show involved intakes (from training->involvement)
        $involvements = explode(', ', $training->involvement);
        $intakeNumbers = [];
        foreach ($involvements as $involvement) {
            if (preg_match('/Intake - (\d+)/', $involvement, $matches)) {
                $intakeNumber = (int) $matches[1];
                $intakeYear = 2011 + $intakeNumber;
                $intakeNumbers[] = [
                    'number' => $intakeNumber,
                    'year' => $intakeYear,
                    'label' => $involvement
                ];
            }
        }
        // Sort intakeNumbers by year ascending
        usort($intakeNumbers, function($a, $b) { return $a['year'] <=> $b['year']; });

        // Get cadets for each intake with existing attendance data
        $cadetsByIntake = [];
        foreach ($intakeNumbers as $intake) {
            $intakeCadets = \App\Models\Cadet::with(['user', 'trainingAttendances' => function($query) use ($training) {
                $query->where('training_id', $training->id);
            }])
                ->byIntake($intake['year'])
                ->get()
                ->map(function ($cadet) use ($intake) {
                    $attendance = $cadet->trainingAttendances->first();
                    return [
                        'id' => $cadet->id,
                        'name' => trim(($cadet->rank ? $cadet->rank . ' ' : '') . ($cadet->user->name ?? 'Unknown')),
                        'matric_no' => $cadet->matric_no,
                        'service_number' => $cadet->service_number,
                        'rank' => $cadet->rank,
                        'position' => $cadet->position,
                        'intake_label' => $intake['label'],
                        'present' => $attendance ? $attendance->present : false,
                        'attendance_method' => $attendance ? $attendance->method : null,
                        'marked_at' => $attendance ? $attendance->marked_at : null,
                        'absence_reason' => $attendance ? $attendance->absence_reason : null,
                        'file_url' => $attendance ? $attendance->file_url : null
                    ];
                });
            if ($intakeCadets->count() > 0) {
                $cadetsByIntake[] = [
                    'intake' => $intake,
                    'cadets' => $intakeCadets
                ];
            }
        }

        return response()->json([
            'success' => true,
            'cadets_by_intake' => $cadetsByIntake,
            'training' => $training
        ]);
    }

    /**
     * Save attendance data
     */
    public function saveAttendance(Request $request, Training $training): JsonResponse
    {
        $validated = $request->validate([
            'attendance' => 'required|array',
            'attendance.*.cadet_id' => 'required|integer|exists:cadets,id',
            'attendance.*.present' => 'required|boolean',
            'attendance.*.absence_reason' => 'nullable|string',
            'attendance.*.file_url' => 'nullable|string',
        ]);

        try {
            $presentCount = 0;
            foreach ($validated['attendance'] as $record) {
                $updateData = [
                    'present' => $record['present'],
                    'method' => 'manual',
                    'marked_at' => Carbon::now()
                ];
                // Only update absence_reason and file_url if absent
                if (!$record['present']) {
                    $updateData['absence_reason'] = $record['absence_reason'] ?? null;
                    $updateData['file_url'] = $record['file_url'] ?? null;
                } else {
                    $updateData['absence_reason'] = null;
                    $updateData['file_url'] = null;
                }
                $training->trainingAttendances()->updateOrCreate([
                    'cadet_id' => $record['cadet_id']
                ], $updateData);
                if ($record['present']) {
                    $presentCount++;
                }
            }
            return response()->json([
                'success' => true,
                'message' => 'Attendance saved successfully',
                'total_cadets' => count($validated['attendance']),
                'present_count' => $presentCount,
                'absent_count' => count($validated['attendance']) - $presentCount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save attendance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new training session
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'nullable|date|after:start_datetime',
            'involvement' => 'nullable|string|max:255',
            'duration_hours' => 'nullable|integer|min:2|max:10',
            'status' => 'required|in:Active,Completed,Cancelled'
        ]);

        // Auto-set status based on dates if not manually set to Cancelled
        if ($validated['status'] !== 'Cancelled') {
            $validated['status'] = $this->determineAutoStatus($validated['start_datetime'], $validated['end_datetime'] ?? null);
        }

        // Calculate duration and allowance if end_datetime is provided
if (isset($validated['end_datetime'])) {
    $start = Carbon::parse($validated['start_datetime']);
    $end = Carbon::parse($validated['end_datetime']);
    
    // Check if it's single-day or multi-day training
    $isSingleDay = $start->toDateString() === $end->toDateString();
    
    if ($isSingleDay) {
        // Single-day training: calculate hours with min 2, max 10 (rounded to nearest integer)
        $calculatedHours = (int) round($start->diffInHours($end, false));
        $hours = max(2, min(10, $calculatedHours));
        
        $validated['duration_hours'] = $hours;
        $validated['allowance_amount'] = $hours * 8;
        $validated['allowance_type'] = 'hourly';
    } else {
        // Multi-day training: calculate days and daily allowance
        $days = $start->diffInDays($end) + 1;
        $validated['duration_hours'] = null; // No duration for multi-day
        $validated['allowance_amount'] = $days * 50;
        $validated['allowance_type'] = 'daily';
    }
} else {
    // No end date specified
    $validated['duration_hours'] = null;
    $validated['allowance_amount'] = null;
    $validated['allowance_type'] = null;
}

        $training = Training::create($validated);

        // Automatically populate attendance for involved cadets
        $this->populateAttendanceForTraining($training);

        return response()->json([
            'success' => true,
            'message' => 'Training session created successfully!',
            'training' => $training
        ]);
    }

    /**
     * Update an existing training session
     */
    public function update(Request $request, Training $training): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'required|string|max:255',
            'start_datetime' => 'required|date',
            'end_datetime' => 'nullable|date|after:start_datetime',
            'involvement' => 'nullable|string|max:255',
            'duration_hours' => 'nullable|integer|min:2|max:10',
            'status' => 'required|in:Active,Completed,Cancelled'
        ]);

        // Check if involvement has changed
        $involvementChanged = $training->involvement !== $validated['involvement'];

        // Auto-set status based on dates if not manually set to Cancelled
        if ($validated['status'] !== 'Cancelled') {
            $validated['status'] = $this->determineAutoStatus($validated['start_datetime'], $validated['end_datetime'] ?? null);
        }

// Calculate duration and allowance if end_datetime is provided
if (isset($validated['end_datetime'])) {
    $start = Carbon::parse($validated['start_datetime']);
    $end = Carbon::parse($validated['end_datetime']);
    
    // Check if it's single-day or multi-day training
    $isSingleDay = $start->toDateString() === $end->toDateString();
    
    if ($isSingleDay) {
        // Single-day training: calculate hours with min 2, max 10 (rounded to nearest integer)
        $calculatedHours = (int) round($start->diffInHours($end, false));
        $hours = max(2, min(10, $calculatedHours));
        
        $validated['duration_hours'] = $hours;
        $validated['allowance_amount'] = $hours * 8;
        $validated['allowance_type'] = 'hourly';
    } else {
        // Multi-day training: calculate days and daily allowance
        $days = $start->diffInDays($end) + 1;
        $validated['duration_hours'] = null; // No duration for multi-day
        $validated['allowance_amount'] = $days * 50;
        $validated['allowance_type'] = 'daily';
    }
} else {
    // No end date specified
    $validated['duration_hours'] = null;
    $validated['allowance_amount'] = null;
    $validated['allowance_type'] = null;
}

        $training->update($validated);

        // If involvement changed, repopulate attendance
        if ($involvementChanged) {
            // Delete existing attendance records
            TrainingAttendance::where('training_id', $training->id)->delete();
            // Populate new attendance records
            $this->populateAttendanceForTraining($training->fresh());
        }

        return response()->json([
            'success' => true,
            'message' => 'Training session updated successfully!',
            'training' => $training->fresh()
        ]);
    }

    /**
     * Automatically populate attendance records for a training
     */
    private function populateAttendanceForTraining(Training $training): void
    {
        if (!$training->involvement) {
            return;
        }

        // Parse involvement to extract intake numbers
        $involvements = explode(', ', $training->involvement);
        $cadetIds = collect();

        foreach ($involvements as $involvement) {
            // Extract intake number from strings like "Intake - 14", "Intake - 13", etc.
            if (preg_match('/Intake - (\d+)/', $involvement, $matches)) {
                $intakeNumber = (int) $matches[1];
                // Intake year is 2011 + intakeNumber
                $intakeYear = 2011 + $intakeNumber;

                // Get all cadets from this intake year
                $intakeCadets = \App\Models\Cadet::where('intake_year', $intakeYear)->pluck('id');
                $cadetIds = $cadetIds->merge($intakeCadets);
            }
        }

        // Remove duplicates and create attendance records
        $cadetIds = $cadetIds->unique();
        
        $attendanceRecords = $cadetIds->map(function ($cadetId) use ($training) {
            return [
                'training_id' => $training->id,
                'cadet_id' => $cadetId,
                'present' => false,
                'method' => 'manual',
                'marked_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        });

        // Bulk insert attendance records
        TrainingAttendance::insert($attendanceRecords->toArray());
    }

    /**
 * End a training session
 */
public function endTraining(Training $training): JsonResponse
{
    if ($training->end_datetime) {
        return response()->json([
            'success' => false,
            'message' => 'Training session has already ended.'
        ]);
    }

    // Set end time to current date and time (no rounding)
    $training->end_datetime = Carbon::now();
    $training->status = 'Completed';
    
    // Calculate duration and allowance
    $start = $training->start_datetime;
    $end = $training->end_datetime;
    
    // Check if training spans multiple days
    $isSingleDay = $start->toDateString() === $end->toDateString();
    
    if ($isSingleDay) {
        // Single-day training: calculate hours with min 2, max 10 (rounded to nearest integer)
        $calculatedHours = (int) round($start->diffInHours($end, false));
        $hours = max(2, min(10, $calculatedHours));
        
        $training->duration_hours = $hours;
        $training->allowance_amount = $hours * 8;
        $training->allowance_type = 'hourly';
    } else {
        // Multi-day training: calculate days
        $days = $start->diffInDays($end) + 1; // +1 to include both start and end days
        
        $training->duration_hours = null;
        $training->allowance_amount = $days * 50;
        $training->allowance_type = 'daily';
    }
    
    $training->save();

    return response()->json([
        'success' => true,
        'message' => 'Training session ended successfully!',
        'training' => $training->fresh()
    ]);
}

    /**
     * Delete a training session
     */
    public function destroy(Training $training): JsonResponse
    {
        $training->delete();

        return response()->json([
            'success' => true,
            'message' => 'Training session deleted successfully!'
        ]);
    }

    /**
     * Get training details for editing
     */
    public function show(Training $training): JsonResponse
    {
        // Update status before showing
        $this->updateTrainingStatus($training);

        $training = $training->fresh();
        // Build a more complete response for frontend
        return response()->json([
            'id' => $training->id,
            'title' => $training->title,
            'description' => $training->description,
            'location' => $training->location,
            'involvement' => $training->involvement,
            'start_datetime' => $training->start_datetime ? $training->start_datetime->format('Y-m-d H:i:s') : null,
            'end_datetime' => $training->end_datetime ? $training->end_datetime->format('Y-m-d H:i:s') : null,
            'duration_hours' => $training->duration_hours,
            'allowance_amount' => $training->allowance_amount,
            'allowance_type' => $training->allowance_type,
            'status' => $training->status,
        ]);
    }

    /**
     * Update expired trainings to completed status
     */
    private function updateExpiredTrainings(): void
    {
        Training::where('status', 'Active')
            ->whereNotNull('end_datetime')
            ->where('end_datetime', '<', Carbon::now())
            ->update(['status' => 'Completed']);
    }

    /**
     * Update a specific training's status if expired
     */
    private function updateTrainingStatus(Training $training): void
    {
        if ($training->status === 'Active' && $training->end_datetime) {
            $now = Carbon::now();
            if ($training->end_datetime < $now) {
                $training->update(['status' => 'Completed']);
            }
        }
    }

    /**
     * Determine status based on current time and training dates
     */
    private function determineAutoStatus(string $startDateTime, ?string $endDateTime = null): string
    {
        $now = Carbon::now();
        $start = Carbon::parse($startDateTime);
        $end = $endDateTime ? Carbon::parse($endDateTime) : null;

        // Only mark as completed if training has explicitly ended (has end_datetime and it's in the past)
        if ($end && $end < $now) {
            return 'Completed';
        }

        // For trainings without end_datetime or that haven't ended yet, keep as Active
        return 'Active';
    }

    /**
     * Get status color for calendar events
     */
    private function getStatusColor(string $status): string
    {
        return match($status) {
            'Active' => '#10B981',     // Green
            'Completed' => '#6B7280',  // Gray
            'Cancelled' => '#EF4444',  // Red
            default => '#3B82F6'       // Blue
        };
    }
}