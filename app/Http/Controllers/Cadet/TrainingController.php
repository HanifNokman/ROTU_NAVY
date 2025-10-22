<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Cadet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    // ================================================================
    // DISPLAY TRAINING INDEX
    // ================================================================
    
    public function index(Request $request)
    {
        $cadet = Cadet::where('user_id', auth()->id())->first();
        
        if (!$cadet) {
            return view('cadet.training', [
                'trainings' => collect([]),
                'calendarEvents' => [],
                'cadetIntake' => null,
                'availableYears' => collect([]),
                'availableYearsMonths' => [],
                'filterYear' => null,
                'filterMonth' => null,
                'filterStatus' => null,
                'error' => 'Cadet profile not found. Please contact your administrator.'
            ]);
        }

        $intakeNumber = $cadet->intake_year - 2011;
        $cadetIntake = "Intake - {$intakeNumber}";

        $this->updateExpiredTrainings();

        // Get filter parameters
        $filterYear = $request->get('year');
        $filterMonth = $request->get('month');
        // Only default to Active on initial page load (no query parameters at all)
        $filterStatus = $request->has('status') ? $request->get('status') : ($request->hasAny(['year', 'month']) ? null : 'Active');

        // Build query
        $query = Training::where(function ($query) use ($cadetIntake) {
                $query->where('involvement', 'like', "%{$cadetIntake}%")
                      ->orWhereNull('involvement')
                      ->orWhere('involvement', '');
            });

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

        $trainings = $query->orderBy('start_datetime', 'asc')->get();

        // Prepare trainings data with formatted fields for both view and AJAX
        $formattedTrainings = $trainings->map(function ($training) {
            return [
                'id' => $training->id,
                'title' => $training->title,
                'description' => $training->description,
                'location' => $training->location,
                'formatted_start_date' => $training->formatted_start_date,
                'formatted_start_time' => $training->formatted_start_time,
                'formatted_duration' => $training->formatted_duration,
                'status' => $training->status,
            ];
        });

        $calendarEvents = $trainings->map(function ($training) {
            return [
                'id' => $training->id,
                'title' => $training->title,
                'start' => $training->start_datetime->format('Y-m-d H:i:s'),
                'end' => $training->end_datetime ? $training->end_datetime->format('Y-m-d H:i:s') : null,
                'backgroundColor' => $this->getStatusColor($training->status),
                'borderColor' => $this->getStatusColor($training->status),
                'textColor' => '#ffffff'
            ];
        });

        // Get available years and months for filter dropdown (from cadet's intake trainings only)
        $availableYearsMonths = Training::selectRaw('DISTINCT YEAR(start_datetime) as year, MONTH(start_datetime) as month')
            ->whereNotNull('start_datetime')
            ->where(function ($query) use ($cadetIntake) {
                $query->where('involvement', 'like', "%{$cadetIntake}%")
                      ->orWhereNull('involvement')
                      ->orWhere('involvement', '');
            })
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
                'trainings' => $formattedTrainings,
                'calendarEvents' => $calendarEvents
            ]);
        }

        return view('cadet.training', array_merge(compact(
            'trainings',
            'calendarEvents',
            'cadetIntake',
            'availableYears',
            'availableYearsMonths',
            'filterYear',
            'filterMonth',
            'filterStatus'
        ), ['formattedTrainings' => $formattedTrainings]));
    }

    // ================================================================
    // SHOW TRAINING DETAILS (READ-ONLY)
    // ================================================================
    
    public function show(Training $training)
    {
        $cadet = Cadet::where('user_id', auth()->id())->first();
        
        if (!$cadet) {
            return response()->json(['error' => 'Cadet profile not found'], 404);
        }

        $intakeNumber = $cadet->intake_year - 2011;
        $cadetIntake = "Intake - {$intakeNumber}";

        $isInvolved = str_contains($training->involvement ?? '', $cadetIntake) || 
                     empty($training->involvement);

        if (!$isInvolved) {
            return response()->json(['error' => 'Training not accessible'], 403);
        }

        $this->updateTrainingStatus($training);

        $freshTraining = $training->fresh();
        $startDate = $freshTraining->start_datetime ? $freshTraining->start_datetime->format('Y-m-d') : null;
        $startTime = $freshTraining->start_datetime ? $freshTraining->start_datetime->format('H:i') : null;
        $endDate = $freshTraining->end_datetime ? $freshTraining->end_datetime->format('Y-m-d') : null;
        $endTime = $freshTraining->end_datetime ? $freshTraining->end_datetime->format('H:i') : null;
        $statusBadgeColor = match($freshTraining->status) {
            'Active' => 'bg-green-100 text-green-800',
            'Completed' => 'bg-gray-100 text-gray-800',
            'Cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-blue-100 text-blue-800',
        };

        $durationHours = null;
        if ($freshTraining->start_datetime && $freshTraining->end_datetime) {
            $durationHours = $freshTraining->start_datetime->diffInHours($freshTraining->end_datetime);
        }

        $allowanceType = $freshTraining->allowance_type ?? ($durationHours && $durationHours >= 8 ? 'daily' : 'hourly');
        $allowanceAmount = $freshTraining->allowance_amount ?? null;

        return response()->json([
            'id' => $freshTraining->id,
            'title' => $freshTraining->title,
            'description' => $freshTraining->description,
            'location' => $freshTraining->location,
            'involvement' => $freshTraining->involvement,
            'start_datetime' => $freshTraining->start_datetime ? $freshTraining->start_datetime->format('Y-m-d H:i:s') : null,
            'end_datetime' => $freshTraining->end_datetime ? $freshTraining->end_datetime->format('Y-m-d H:i:s') : null,
            'formatted_start_date' => $startDate,
            'formatted_start_time' => $startTime,
            'formatted_end_date' => $endDate,
            'formatted_end_time' => $endTime,
            'status' => $freshTraining->status,
            'status_badge_color' => $statusBadgeColor,
            'duration_hours' => $durationHours,
            'allowance_type' => $allowanceType,
            'allowance_amount' => $allowanceAmount,
        ]);
    }

    // ================================================================
    // UPDATE EXPIRED TRAININGS TO COMPLETED STATUS
    // ================================================================
    
    private function updateExpiredTrainings(): void
    {
        Training::where('status', 'Active')
            ->where(function ($query) {
                $query->where('end_datetime', '<', Carbon::now())
                      ->orWhere(function ($subQuery) {
                          $subQuery->whereNull('end_datetime')
                                   ->where('start_datetime', '<', Carbon::now()->subHours(2));
                      });
            })
            ->update(['status' => 'Completed']);
    }

    // ================================================================
    // UPDATE SPECIFIC TRAINING STATUS IF EXPIRED
    // ================================================================
    
    private function updateTrainingStatus(Training $training): void
    {
        if ($training->status === 'Active') {
            $now = Carbon::now();
            $isExpired = false;

            if ($training->end_datetime) {
                $isExpired = $training->end_datetime < $now;
            } else {
                $isExpired = $training->start_datetime->addHours(2) < $now;
            }

            if ($isExpired) {
                $training->update(['status' => 'Completed']);
            }
        }
    }

    // ================================================================
    // GET STATUS COLOR FOR CALENDAR EVENTS
    // ================================================================
    
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