<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class TrainingController extends Controller
{
    // ================================================================
    // MAIN VIEW
    // ================================================================

    public function index(Request $request)
    {
        $this->updateExpiredTrainings();
        
        // Get filter parameters
        $filterYear = $request->get('year');
        $filterMonth = $request->get('month');

        // Get status filter - handle empty string as "show all"
        if ($request->has('status')) {
            $filterStatus = $request->get('status');
            // If status is empty string, treat it as null (show all)
            if ($filterStatus === '') {
                $filterStatus = null;
            }
        } else {
            // Only default to Active on initial page load with no filters
            $filterStatus = $request->hasAny(['year', 'month', 'ajax']) ? null : 'Active';
        }

        // Build query for all trainings
        $query = Training::with('trainingAttendances');

        // Apply year filter
        if ($filterYear) {
            $query->whereYear('start_datetime', $filterYear);
        }

        // Apply month filter
        if ($filterMonth) {
            $query->whereMonth('start_datetime', $filterMonth);
        }

        // Apply status filter (only if not null and not empty string)
        if ($filterStatus !== null && $filterStatus !== '') {
            $query->where('status', $filterStatus);
        }

        $trainings = $query->orderBy('start_datetime', 'asc')
            ->get()
            ->map(function($training) {
                // Format dates
                $training->formatted_start_date = $training->start_datetime ? 
                    $training->start_datetime->format('M d, Y') : 'N/A';
                $training->formatted_start_time = $training->start_datetime ? 
                    $training->start_datetime->format('h:i A') : 'N/A';
                
                // Add status badge color
                $training->status_badge_color = match($training->status) {
                    'Active' => 'bg-green-100 text-green-800',
                    'Completed' => 'bg-gray-100 text-gray-800',
                    'Cancelled' => 'bg-red-100 text-red-800',
                    default => 'bg-blue-100 text-blue-800',
                };
                
                return $training;
            });
        
        // Get today's trainings (unfiltered)
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
        
        // Get calendar events (based on filtered trainings)
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

        // Get available years and months for filter dropdown (from all trainings)
        $availableYearsMonths = Training::selectRaw('DISTINCT YEAR(start_datetime) as year, MONTH(start_datetime) as month')
            ->whereNotNull('start_datetime')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'asc')
            ->get()
            ->groupBy('year')
            ->map(function ($items) {
                return $items->pluck('month')->unique()->values();
            });

        $availableYears = $availableYearsMonths->keys();

        // If AJAX request, return JSON
        if ($request->ajax() || $request->get('ajax')) {
            return response()->json([
                'trainings' => $trainings->map(function ($training) {
                    return [
                        'id' => $training->id,
                        'title' => $training->title,
                        'description' => $training->description,
                        'location' => $training->location,
                        'involvement' => $training->involvement,
                        'formatted_start_date' => $training->formatted_start_date,
                        'formatted_start_time' => $training->formatted_start_time,
                        'status' => $training->status,
                        'status_badge_color' => $training->status_badge_color,
                        'duration_hours' => $training->duration_hours,
                        'allowance_type' => $training->allowance_type,
                    ];
                }),
                'calendarEvents' => $calendarEvents
            ]);
        }

        return view('instructor.training', compact(
            'trainings', 
            'calendarEvents', 
            'todaysTrainings',
            'availableYears',
            'availableYearsMonths',
            'filterYear',
            'filterMonth',
            'filterStatus'
        ));
    }

    public function show(Training $training): JsonResponse
    {
        $this->updateTrainingStatus($training);
        $training = $training->fresh();

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

    // ================================================================
    // TRAINING CRUD OPERATIONS
    // ================================================================

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

        if ($validated['status'] !== 'Cancelled') {
            $validated['status'] = $this->determineAutoStatus(
                $validated['start_datetime'], 
                $validated['end_datetime'] ?? null
            );
        }

        $this->calculateDurationAndAllowance($validated);

        $training = Training::create($validated);
        $this->populateAttendanceForTraining($training);

        return response()->json([
            'success' => true,
            'message' => 'Training session created successfully!',
            'training' => $training
        ]);
    }

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

        $involvementChanged = $training->involvement !== $validated['involvement'];

        if ($validated['status'] !== 'Cancelled') {
            $validated['status'] = $this->determineAutoStatus(
                $validated['start_datetime'], 
                $validated['end_datetime'] ?? null
            );
        }

        $this->calculateDurationAndAllowance($validated);

        $training->update($validated);

        if ($involvementChanged) {
            TrainingAttendance::where('training_id', $training->id)->delete();
            $this->populateAttendanceForTraining($training->fresh());
        }

        return response()->json([
            'success' => true,
            'message' => 'Training session updated successfully!',
            'training' => $training->fresh()
        ]);
    }

    public function destroy(Training $training): JsonResponse
    {
        $training->delete();

        return response()->json([
            'success' => true,
            'message' => 'Training session deleted successfully!'
        ]);
    }

    public function endTraining(Training $training): JsonResponse
    {
        if ($training->end_datetime) {
            return response()->json([
                'success' => false,
                'message' => 'Training session has already ended.'
            ]);
        }

        $training->end_datetime = Carbon::now();
        $training->status = 'Completed';
        
        $start = $training->start_datetime;
        $end = $training->end_datetime;
        $isSingleDay = $start->toDateString() === $end->toDateString();
        
        if ($isSingleDay) {
            $calculatedHours = (int) round($start->diffInHours($end, false));
            $hours = max(2, min(10, $calculatedHours));
            
            $training->duration_hours = $hours;
            $training->allowance_amount = $hours * 8;
            $training->allowance_type = 'hourly';
        } else {
            $days = $start->diffInDays($end) + 1;

            $training->duration_hours = $days;
            $training->allowance_amount = (int)($days * 50);
            $training->allowance_type = 'daily';
        }
        
        $training->save();

        return response()->json([
            'success' => true,
            'message' => 'Training session ended successfully!',
            'training' => $training->fresh()
        ]);
    }

    // ================================================================
    // ATTENDANCE MANAGEMENT
    // ================================================================

    public function getCadetsForAttendance(Training $training): JsonResponse
    {
        if (!$training->involvement) {
            return response()->json([
                'success' => false,
                'message' => 'No involvement specified for this training'
            ]);
        }

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

        usort($intakeNumbers, function($a, $b) { 
            return $a['year'] <=> $b['year']; 
        });

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
            $affectedCadetIds = [];

            foreach ($validated['attendance'] as $record) {
                $updateData = [
                    'present' => $record['present'],
                    'method' => 'manual',
                    'marked_at' => Carbon::now()
                ];

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

                $affectedCadetIds[] = $record['cadet_id'];
            }

            // Update performance ratings for affected cadets
            $service = new \App\Services\PerformanceCalculationService();
            foreach (array_unique($affectedCadetIds) as $cadetId) {
                $service->handleTrainingAttendanceChange($cadetId);
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

    // ================================================================
    // ATTENDANCE LIST & FILTERS
    // ================================================================

    public function getYears(Request $request): JsonResponse
    {
        $currentYear = Carbon::now()->year;
        $years = [];
        
        for ($i = 0; $i < 4; $i++) {
            $years[] = $currentYear - $i;
        }
        
        return response()->json([
            'success' => true,
            'years' => $years
        ]);
    }

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

        $query = Training::whereYear('start_datetime', $year)
            ->whereMonth('start_datetime', $month);

        $trainings = $query->orderBy('start_datetime', 'desc')->get();

        $result = $trainings->map(function($training) use ($status, $intake) {
            $attendanceQuery = $training->trainingAttendances()
                ->with(['cadet.user'])
                ->join('cadets', 'training_attendances.cadet_id', '=', 'cadets.id')
                ->join('users', 'cadets.user_id', '=', 'users.id');

            if ($intake && preg_match('/Intake - (\d+)/', $intake, $matches)) {
                $intakeNumber = (int) $matches[1];
                $intakeYear = 2011 + $intakeNumber;
                $attendanceQuery->where('cadets.intake_year', $intakeYear);
            }

            if ($status && in_array($status, ['present', 'absent'])) {
                $attendanceQuery->where('training_attendances.present', $status === 'present');
            }

            $attendances = $attendanceQuery
                ->select('training_attendances.*')
                ->orderByRaw('CAST(cadets.service_number AS UNSIGNED) ASC')
                ->get();

            $cadets = $attendances->map(function($attendance) {
                $cadet = $attendance->cadet;
                $user = $cadet->user;
                
                $intakeNumber = $cadet->intake_year - 2011;
                $intakeLabel = "Intake - " . $intakeNumber;
                
                $fileUrl = null;
                if ($attendance->file_url) {
                    if (str_starts_with($attendance->file_url, 'http')) {
                        $fileUrl = $attendance->file_url;
                    } else {
                        $cleanPath = str_replace('public/', '', $attendance->file_url);
                        $fileUrl = asset('storage/' . $cleanPath);
                    }
                }
                
                return [
                    'id' => $cadet->id,
                    'service_number' => $cadet->service_number ?? '',
                    'rank' => $cadet->rank ?? '',
                    'name' => $user->name ?? 'Unknown',
                    'matric_no' => $cadet->matric_no ?? '',
                    'intake_label' => $intakeLabel,
                    'intake_year' => $cadet->intake_year,
                    'present' => $attendance->present,
                    'absence_reason' => $attendance->absence_reason,
                    'file_url' => $fileUrl,
                    'marked_at' => $attendance->marked_at ? $attendance->marked_at->format('H:i') : null,
                    'method' => $attendance->method
                ];
            });

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

        if ($intake) {
            $result = $result->filter(function($training) {
                return $training['cadets']->count() > 0;
            });
        } else {
            if ($status) {
                $result = $result->filter(function($training) {
                    return $training['cadets']->count() > 0;
                });
            }
        }

        return response()->json([
            'success' => true,
            'trainings' => $result->values()
        ]);
    }

    public function getAllAttendanceList(Request $request): JsonResponse
    {
        return $this->getCadetAttendanceList($request);
    }

    // ================================================================
    // PRIVATE HELPER METHODS
    // ================================================================

    private function populateAttendanceForTraining(Training $training): void
    {
        if (!$training->involvement) {
            return;
        }

        $involvements = explode(', ', $training->involvement);
        $cadetIds = collect();

        foreach ($involvements as $involvement) {
            if (preg_match('/Intake - (\d+)/', $involvement, $matches)) {
                $intakeNumber = (int) $matches[1];
                $intakeYear = 2011 + $intakeNumber;

                $intakeCadets = \App\Models\Cadet::where('intake_year', $intakeYear)->pluck('id');
                $cadetIds = $cadetIds->merge($intakeCadets);
            }
        }

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

        TrainingAttendance::insert($attendanceRecords->toArray());
    }

    private function calculateDurationAndAllowance(array &$validated): void
    {
        if (isset($validated['end_datetime'])) {
            $start = Carbon::parse($validated['start_datetime']);
            $end = Carbon::parse($validated['end_datetime']);
            
            $isSingleDay = $start->toDateString() === $end->toDateString();
            
            if ($isSingleDay) {
                $calculatedHours = (int) round($start->diffInHours($end, false));
                $hours = max(2, min(10, $calculatedHours));
                
                $validated['duration_hours'] = $hours;
                $validated['allowance_amount'] = $hours * 8;
                $validated['allowance_type'] = 'hourly';
        } else {
            $days = $start->diffInDays($end) + 1;
            $validated['duration_hours'] = $days;
            $validated['allowance_amount'] = (int)($days * 50);
            $validated['allowance_type'] = 'daily';
        }
        } else {
            $validated['duration_hours'] = null;
            $validated['allowance_amount'] = null;
            $validated['allowance_type'] = null;
        }
    }

    private function updateExpiredTrainings(): void
    {
        Training::where('status', 'Active')
            ->whereNotNull('end_datetime')
            ->where('end_datetime', '<', Carbon::now())
            ->update(['status' => 'Completed']);
    }

    private function updateTrainingStatus(Training $training): void
    {
        if ($training->status === 'Active' && $training->end_datetime) {
            $now = Carbon::now();
            if ($training->end_datetime < $now) {
                $training->update(['status' => 'Completed']);
            }
        }
    }

    private function determineAutoStatus(string $startDateTime, ?string $endDateTime = null): string
    {
        $now = Carbon::now();
        $start = Carbon::parse($startDateTime);
        $end = $endDateTime ? Carbon::parse($endDateTime) : null;

        if ($end && $end < $now) {
            return 'Completed';
        }

        return 'Active';
    }

    private function getStatusColor(string $status): string
    {
        return match($status) {
            'Active' => '#10B981',
            'Completed' => '#6B7280',
            'Cancelled' => '#EF4444',
            default => '#3B82F6'
        };
    }
}