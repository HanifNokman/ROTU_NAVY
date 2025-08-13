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
     * Display the training schedule page
     */
    public function index()
    {
        // Update statuses before displaying
        $this->updateExpiredTrainings();
        
        $trainings = Training::orderBy('start_datetime', 'asc')->get();
        
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
                        'marked_at' => $attendance ? $attendance->marked_at : null
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
            'attendance.*.present' => 'required|boolean'
        ]);

        try {
            $presentCount = 0;
            
            foreach ($validated['attendance'] as $record) {
                TrainingAttendance::updateOrCreate([
                    'training_id' => $training->id,
                    'cadet_id' => $record['cadet_id']
                ], [
                    'present' => $record['present'],
                    'method' => 'manual',
                    'marked_at' => Carbon::now()
                ]);
                
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
     * Record QR code attendance
     */
    public function recordQrAttendance(Request $request, Training $training): JsonResponse
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'timestamp' => 'required|integer',
            'cadet_id' => 'required|integer|exists:cadets,id'
        ]);

        // Verify QR code token
        $expectedToken = hash('sha256', $training->id . $validated['timestamp'] . config('app.key'));
        
        if ($validated['token'] !== $expectedToken) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid QR code'
            ], 400);
        }

        // Check if token is still valid (within 60 seconds)
        $currentTimestamp = floor(time() / 30);
        if (abs($currentTimestamp - $validated['timestamp']) > 2) {
            return response()->json([
                'success' => false,
                'message' => 'QR code has expired'
            ], 400);
        }

        try {
            TrainingAttendance::updateOrCreate([
                'training_id' => $training->id,
                'cadet_id' => $validated['cadet_id']
            ], [
                'present' => true,
                'method' => 'qr_code',
                'marked_at' => Carbon::now()
            ]);

            $cadet = \App\Models\Cadet::with('user')->find($validated['cadet_id']);

            return response()->json([
                'success' => true,
                'message' => 'Attendance recorded successfully',
                'cadet' => [
                    'name' => $cadet->user->name ?? 'Unknown',
                    'matric_no' => $cadet->matric_no
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record attendance: ' . $e->getMessage()
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
                // Single-day training: calculate hours and hourly allowance
                $hours = max(2, min(10, $start->diffInHours($end)));
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

        // Recalculate duration and allowance if end_datetime is provided
        if (isset($validated['end_datetime'])) {
            $start = Carbon::parse($validated['start_datetime']);
            $end = Carbon::parse($validated['end_datetime']);
            
            // Check if it's single-day or multi-day training
            $isSingleDay = $start->toDateString() === $end->toDateString();
            
            if ($isSingleDay) {
                // Single-day training: calculate hours and hourly allowance
                $hours = max(2, min(10, $start->diffInHours($end)));
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

        // Use Training model's roundToNearestHour method
        $now = Carbon::now();
        $roundedEnd = \App\Models\Training::roundToNearestHour($now);
        
        // Ensure end time is after start time
        if ($roundedEnd->lte($training->start_datetime)) {
            $roundedEnd = $training->start_datetime->copy()->addHour();
        }

        $training->end_datetime = $roundedEnd;
        $training->status = 'Completed';
        
        // Calculate duration and allowance for single-day training
        $start = $training->start_datetime;
        $end = $training->end_datetime;
        
        // Check if it's single-day training (same date)
        $isSingleDay = $start->toDateString() === $end->toDateString();
        
        if ($isSingleDay) {
            $hours = max(2, min(10, $start->diffInHours($end)));
            $training->duration_hours = $hours;
            $training->allowance_amount = $hours * 8;
            $training->allowance_type = 'hourly';
        }
        
        $training->save();

        return response()->json([
            'success' => true,
            'message' => 'Training session ended successfully!',
            'training' => $training->fresh()
        ]);
    }

    /**
     * Generate QR code for attendance
     */
    public function generateQrCode(Training $training): JsonResponse
    {
        // Generate a unique token that changes every 30 seconds
        $timestamp = floor(time() / 30);
        $token = hash('sha256', $training->id . $timestamp . config('app.key'));
        
        // Create QR data
        $qrData = [
            'training_id' => $training->id,
            'token' => $token,
            'timestamp' => $timestamp
        ];

        return response()->json([
            'success' => true,
            'qr_data' => base64_encode(json_encode($qrData)),
            'expires_in' => 30 - (time() % 30) // Seconds until next refresh
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
        
        return response()->json($training->fresh());
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