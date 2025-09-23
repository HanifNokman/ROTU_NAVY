<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->first();

        if (!$cadet) {
            return redirect()->route('dashboard')->with('error', 'Cadet profile not found.');
        }

        // Calculate intake label using the same logic as Cadet model
        $intakeNumber = $cadet->intake_year - 2011;
        $intakeStr = "Intake - " . $intakeNumber;

        // Enhanced training visibility logic - show training until next day
        $now = Carbon::now();
        $today = $now->toDateString();
        $yesterday = $now->copy()->subDay()->toDateString();
        
        $todaysTrainings = Training::where(function ($query) use ($intakeStr) {
            // Intake matching - handle both exact and partial matches
            $query->where('involvement', 'LIKE', "%{$intakeStr}%")
                ->orWhereNull('involvement')
                ->orWhere('involvement', '');
        })
        ->where(function ($q) use ($today, $yesterday, $now) {
            $q->where(function ($subQ) use ($today) {
                // Show training scheduled for today
                $subQ->whereDate('start_datetime', $today);
            })
            ->orWhere(function ($subQ) use ($yesterday) {
                // Show yesterday's training (show until end of today)
                $subQ->whereDate('start_datetime', $yesterday);
            })
            ->orWhere(function ($subQ) use ($now) {
                // Show multi-day trainings that started before today and are still ongoing
                $subQ->where('start_datetime', '<', $now->copy()->startOfDay())
                    ->where(function ($endQ) use ($now) {
                        $endQ->whereNull('end_datetime')
                            ->orWhere('end_datetime', '>=', $now->copy()->startOfDay());
                    });
            });
        })
        ->orderBy('start_datetime', 'asc')
        ->get();

        // For backward compatibility, keep the first training as $todaysTraining
        $todaysTraining = $todaysTrainings->first();

        // Ensure we have a collection even if empty
        if (!$todaysTrainings) {
            $todaysTrainings = collect();
        }

        // Get attendance record for today's training (keep for backward compatibility)
        $attendance = null;
        if ($todaysTraining) {
            $attendance = TrainingAttendance::where('training_id', $todaysTraining->id)
                ->where('cadet_id', $cadet->id)
                ->first();
        }

        // Enhanced absence section: completed trainings where cadet was absent and has NOT submitted both reason and file
        $absentAttendances = TrainingAttendance::where('cadet_id', $cadet->id)
            ->where('present', false)
            ->whereHas('training', function($q) {
                $q->where('status', 'Completed');
            })
            ->where(function($q) {
                // Must be missing either absence reason OR file (or both)
                $q->whereNull('absence_reason')
                ->orWhereNull('file_url')
                ->orWhere('absence_reason', '')
                ->orWhere('file_url', '');
            })
            ->with(['training' => function($q) {
                $q->orderBy('start_datetime', 'desc');
            }])
            ->get()
            ->sortByDesc(function($attendance) {
                return $attendance->training->start_datetime;
            });

        return view('cadet.attendance', [
            'cadet' => $cadet,
            'todaysTraining' => $todaysTraining,
            'attendance' => $attendance,
            'absentAttendances' => $absentAttendances,
            'todaysTrainings' => $todaysTrainings,
        ]);
    }

    /**
     * Mark attendance as present manually
     */
    public function markPresent(Request $request)
    {
        try {
            $user = Auth::user();
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
            
            $request->validate([
                'training_id' => 'required|exists:trainings,id',
                'method' => 'in:manual'
            ]);
            
            $trainingId = $request->input('training_id');
            $method = $request->input('method', 'manual');

            // Validate training exists and is accessible to cadet
            $training = Training::findOrFail($trainingId);
            
            // Check if cadet is eligible for this training
            $intakeNumber = $cadet->intake_year - 2011;
            $intakeStr = "Intake - " . $intakeNumber;
            
            if ($training->involvement && !str_contains($training->involvement, $intakeStr)) {
                return redirect()->back()->with('error', 'You are not eligible for this training session.');
            }
            
            // Check if training is still active or recent
            $now = Carbon::now();
            $trainingDate = $training->start_datetime;
            $daysDiff = $now->diffInDays($trainingDate, false);
            
            if ($daysDiff > 1) {
                return redirect()->back()->with('error', 'This training session is too old to mark attendance.');
            }
            
            $attendance = TrainingAttendance::firstOrNew([
                'training_id' => $trainingId,
                'cadet_id' => $cadet->id,
            ]);
            
            if ($attendance->exists && $attendance->present) {
                return redirect()->back()->with('error', 'You have already marked attendance for this training.');
            }
            
            $attendance->present = true;
            $attendance->method = $method;
            $attendance->marked_at = Carbon::now();
            
            // Clear any previous absence data when marking present
            $attendance->absence_reason = null;
            $attendance->file_url = null;
            $attendance->save();

            return redirect()->back()->with('success', 'Attendance marked as present successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Error marking attendance: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark attendance. Please try again.');
        }
    }

    /**
     * Submit absence reason and supporting file
     */
    public function submitAbsence(Request $request, $attendanceId)
    {
        try {
            $user = Auth::user();
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
            
            $attendance = TrainingAttendance::where('id', $attendanceId)
                ->where('cadet_id', $cadet->id)
                ->where('present', false)
                ->firstOrFail();

            $request->validate([
                'absence_reason' => 'required|string|min:10|max:500',
                'supporting_file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // 5MB max
            ], [
                'absence_reason.required' => 'Please provide a reason for your absence.',
                'absence_reason.min' => 'The absence reason must be at least 10 characters.',
                'absence_reason.max' => 'The absence reason cannot exceed 500 characters.',
                'supporting_file.required' => 'Please upload a supporting file.',
                'supporting_file.mimes' => 'File must be: JPG, PNG, PDF, DOC, or DOCX.',
                'supporting_file.max' => 'File size cannot exceed 5MB.',
            ]);

            // Handle file upload with better naming and validation
            $file = $request->file('supporting_file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            
            // Clean filename and add timestamp
            $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $originalName);
            $fileName = time() . '_cadet_' . $cadet->id . '_' . $cleanName . '.' . $extension;
            
            // Store file in the absences directory
            $path = $file->storeAs('absences', $fileName, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to upload file.');
            }
            
            // Update attendance record
            $attendance->absence_reason = $request->input('absence_reason');
            $attendance->file_url = $path;
            $attendance->updated_at = Carbon::now();
            $attendance->save();

            return redirect()->back()->with('success', 'Absence reason and supporting documentation submitted successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Error submitting absence: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to submit absence information. Please try again.')
                ->withInput();
        }
    }

    /**
     * Get training details for cadet verification
     */
    private function isTrainingAccessible(Training $training, Cadet $cadet): bool
    {
        // If no involvement specified, training is open to all
        if (!$training->involvement) {
            return true;
        }

        // Check if cadet's intake is in the involvement list
        $intakeNumber = $cadet->intake_year - 2011;
        $intakeStr = "Intake - " . $intakeNumber;
        
        return str_contains($training->involvement, $intakeStr);
    }

    /**
     * Check if training is within acceptable time range for attendance
     */
    private function isTrainingTimeValid(Training $training): bool
    {
        $now = Carbon::now();
        $trainingStart = $training->start_datetime;
        
        // Allow attendance from training start time up to 24 hours after
        $allowedUntil = $trainingStart->copy()->addHours(24);
        
        return $now->between($trainingStart, $allowedUntil);
    }
}