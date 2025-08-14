<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->first();

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
            'todaysTrainings' => $todaysTrainings, // Add this line if it's missing
        ]);
    }

    // Mark present manually or via QR
    public function markPresent(Request $request)
    {
        try {
            $user = Auth::user();
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
            $trainingId = $request->input('training_id');
            $method = $request->input('method', 'manual');

            // Validate training exists and is accessible to cadet
            $training = Training::findOrFail($trainingId);
            
            $attendance = TrainingAttendance::firstOrNew([
                'training_id' => $trainingId,
                'cadet_id' => $cadet->id,
            ]);
            
            $attendance->present = true;
            $attendance->method = $method;
            $attendance->marked_at = Carbon::now();
            
            // Clear any previous absence data when marking present
            $attendance->absence_reason = null;
            $attendance->file_url = null;
            $attendance->save();

            $message = $method === 'qr' ? 'Attendance marked as present via QR scan!' : 'Attendance marked as present!';
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->back()->with('success', $message);
            
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to mark attendance. Please try again.'
                ], 400);
            }
            
            return redirect()->back()->with('error', 'Failed to mark attendance. Please try again.');
        }
    }

    // Submit absence reason and file
    public function submitAbsence(Request $request, $attendanceId)
    {
        try {
            $user = Auth::user();
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
            
            $attendance = TrainingAttendance::where('id', $attendanceId)
                ->where('cadet_id', $cadet->id)
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

            // Handle file upload with better naming
            $file = $request->file('supporting_file');
            $fileName = time() . '_' . $cadet->id . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('absences', $fileName, 'public');
            
            // Update attendance record
            $attendance->absence_reason = $request->input('absence_reason');
            $attendance->file_url = $path;
            $attendance->updated_at = Carbon::now();
            $attendance->save();

            return redirect()->back()->with('success', 'Absence reason and supporting file submitted successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to submit absence information. Please try again.')
                ->withInput();
        }
    }

    // QR Code verification endpoint
    public function verifyQR(Request $request)
    {
        try {
            $qrData = $request->input('qr_data');
            $user = Auth::user();
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();

            // Parse QR data (expecting format: training_id:timestamp:hash)
            $qrParts = explode(':', $qrData);
            
            if (count($qrParts) !== 3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code format.'
                ], 400);
            }

            $trainingId = $qrParts[0];
            $timestamp = $qrParts[1];
            $hash = $qrParts[2];

            // Verify QR code is not expired (valid for 30 minutes)
            $qrTime = Carbon::createFromTimestamp($timestamp);
            if ($qrTime->diffInMinutes(Carbon::now()) > 30) {
                return response()->json([
                    'success' => false,
                    'message' => 'QR code has expired. Please request a new one from your instructor.'
                ], 400);
            }

            // Verify hash (simple verification - you might want to enhance this)
            $expectedHash = hash('sha256', $trainingId . $timestamp . config('app.key'));
            if ($hash !== $expectedHash) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid QR code.'
                ], 400);
            }

            // Mark attendance
            $attendance = TrainingAttendance::firstOrNew([
                'training_id' => $trainingId,
                'cadet_id' => $cadet->id,
            ]);
            
            $attendance->present = true;
            $attendance->method = 'qr';
            $attendance->marked_at = Carbon::now();
            $attendance->absence_reason = null;
            $attendance->file_url = null;
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Attendance marked successfully via QR scan!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify QR code. Please try again.'
            ], 500);
        }
    }
}