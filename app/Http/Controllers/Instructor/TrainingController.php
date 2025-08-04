<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

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

        return view('instructor.training', compact('trainings', 'calendarEvents'));
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
            'status' => 'required|in:Active,Completed,Cancelled'
        ]);

        // Auto-set status based on dates if not manually set to Cancelled
        if ($validated['status'] !== 'Cancelled') {
            $validated['status'] = $this->determineAutoStatus($validated['start_datetime'], $validated['end_datetime'] ?? null);
        }

        $training = Training::create($validated);

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
            'status' => 'required|in:Active,Completed,Cancelled'
        ]);

        // Auto-set status based on dates if not manually set to Cancelled
        if ($validated['status'] !== 'Cancelled') {
            $validated['status'] = $this->determineAutoStatus($validated['start_datetime'], $validated['end_datetime'] ?? null);
        }

        $training->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Training session updated successfully!',
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
        
        return response()->json($training->fresh());
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
                          // If no end_datetime, check if start_datetime + 2 hours has passed
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
                // If no end time, assume training is 2 hours long
                $isExpired = $training->start_datetime->addHours(2) < $now;
            }

            if ($isExpired) {
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

        // If training has ended
        if ($end && $end < $now) {
            return 'Completed';
        }

        // If no end time specified, assume 2 hours duration
        if (!$end && $start->copy()->addHours(2) < $now) {
            return 'Completed';
        }

        // If training hasn't started yet or is currently active
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