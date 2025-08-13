<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Cadet;
use Carbon\Carbon;

class TrainingController extends Controller
{
    public function index()
    {
        // Get the current cadet
        $cadet = Cadet::where('user_id', auth()->id())->first();
        
        if (!$cadet) {
            return view('cadet.training', [
                'trainings' => collect([]),
                'calendarEvents' => [],
                'cadetIntake' => null,
                'error' => 'Cadet profile not found. Please contact your administrator.'
            ]);
        }

        // Calculate cadet's intake label based on 2022 = Intake - 11
        $intakeNumber = $cadet->intake_year - 2011;
        $cadetIntake = "Intake - {$intakeNumber}";

        // Update expired trainings first
        $this->updateExpiredTrainings();

        // Get trainings where the cadet's intake is involved
        $trainings = Training::where(function ($query) use ($cadetIntake) {
                $query->where('involvement', 'like', "%{$cadetIntake}%")
                      ->orWhereNull('involvement')  // Include trainings with no specific involvement
                      ->orWhere('involvement', '');  // Include trainings with empty involvement
            })
            ->orderBy('start_datetime', 'asc')
            ->get();

        // Format trainings for calendar
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

        return view('cadet.training', compact('trainings', 'calendarEvents', 'cadetIntake'));
    }

    /**
     * Get training details for viewing (read-only)
     */
    public function show(Training $training)
    {
        // Get the current cadet
        $cadet = Cadet::where('user_id', auth()->id())->first();
        
        if (!$cadet) {
            return response()->json(['error' => 'Cadet profile not found'], 404);
        }

        // Calculate cadet's intake label
        $intakeNumber = $cadet->intake_year - 2011;
        $cadetIntake = "Intake - {$intakeNumber}";

        // Check if this training involves the cadet's intake
        $isInvolved = str_contains($training->involvement ?? '', $cadetIntake) || 
                     empty($training->involvement);

        if (!$isInvolved) {
            return response()->json(['error' => 'Training not accessible'], 403);
        }

        // Update status if needed
        $this->updateTrainingStatus($training);

        // Prepare formatted fields for frontend
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

        // Duration calculation (hours)
        $durationHours = null;
        if ($freshTraining->start_datetime && $freshTraining->end_datetime) {
            $durationHours = $freshTraining->start_datetime->diffInHours($freshTraining->end_datetime);
        }

        // Allowance type and amount
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

    /**
     * Update expired trainings to completed status
     */
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

    /**
     * Update a specific training's status if expired
     */
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
