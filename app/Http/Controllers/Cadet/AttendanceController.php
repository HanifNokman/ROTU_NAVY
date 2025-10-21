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
    // Geofence configuration (meetup location)
    private const GEOFENCE_LATITUDE = 3.1390;   // Example: Kuala Lumpur coordinates
    private const GEOFENCE_LONGITUDE = 101.6869;
    private const GEOFENCE_RADIUS = 100; // Radius in meters
    
    // ================================================================
    // DISPLAY ATTENDANCE INDEX
    // ================================================================
    
    public function index()
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->first();

        if (!$cadet) {
            return redirect()->route('dashboard')->with('error', 'Cadet profile not found.');
        }

        $intakeNumber = $cadet->intake_year - 2011;
        $intakeStr = "Intake - " . $intakeNumber;

        $now = Carbon::now();
        $today = $now->toDateString();
        $yesterday = $now->copy()->subDay()->toDateString();
        
        $todaysTrainings = Training::where(function ($query) use ($intakeStr) {
            $query->where('involvement', 'LIKE', "%{$intakeStr}%")
                ->orWhereNull('involvement')
                ->orWhere('involvement', '');
        })
        ->where(function ($q) use ($today, $yesterday, $now) {
            $q->where(function ($subQ) use ($today) {
                $subQ->whereDate('start_datetime', $today);
            })
            ->orWhere(function ($subQ) use ($yesterday) {
                $subQ->whereDate('start_datetime', $yesterday);
            })
            ->orWhere(function ($subQ) use ($now) {
                $subQ->where('start_datetime', '<', $now->copy()->startOfDay())
                    ->where(function ($endQ) use ($now) {
                        $endQ->whereNull('end_datetime')
                            ->orWhere('end_datetime', '>=', $now->copy()->startOfDay());
                    });
            });
        })
        ->orderBy('start_datetime', 'asc')
        ->get();

        $todaysTraining = $todaysTrainings->first();

        if (!$todaysTrainings) {
            $todaysTrainings = collect();
        }

        $attendance = null;
        if ($todaysTraining) {
            $attendance = TrainingAttendance::where('training_id', $todaysTraining->id)
                ->where('cadet_id', $cadet->id)
                ->first();
        }

        $absentAttendances = TrainingAttendance::where('cadet_id', $cadet->id)
            ->where('present', false)
            ->whereHas('training', function($q) {
                $q->where('status', 'Completed');
            })
            ->where(function($q) {
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
            'geofence' => [
                'latitude' => self::GEOFENCE_LATITUDE,
                'longitude' => self::GEOFENCE_LONGITUDE,
                'radius' => self::GEOFENCE_RADIUS,
            ]
        ]);
    }

    // ================================================================
    // MARK ATTENDANCE AS PRESENT (WITH GEOFENCE VALIDATION)
    // ================================================================
    
    public function markPresent(Request $request)
    {
        try {
            $user = Auth::user();
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
            
            $request->validate([
                'training_id' => 'required|exists:trainings,id',
                'method' => 'in:manual',
                'latitude' => 'required|numeric|between:-90,90',
                'longitude' => 'required|numeric|between:-180,180',
            ]);
            
            $trainingId = $request->input('training_id');
            $method = $request->input('method', 'manual');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            // Validate geofence
            if (!$this->isWithinGeofence($latitude, $longitude)) {
                return redirect()->back()->with('error', 'You must be at the designated meetup location to mark attendance.');
            }

            $training = Training::findOrFail($trainingId);
            
            $intakeNumber = $cadet->intake_year - 2011;
            $intakeStr = "Intake - " . $intakeNumber;
            
            if ($training->involvement && !str_contains($training->involvement, $intakeStr)) {
                return redirect()->back()->with('error', 'You are not eligible for this training session.');
            }
            
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
            $attendance->latitude = $latitude;
            $attendance->longitude = $longitude;
            $attendance->absence_reason = null;
            $attendance->file_url = null;
            $attendance->save();

            return redirect()->back()->with('success', 'Attendance marked as present successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Error marking attendance: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to mark attendance. Please try again.');
        }
    }

    // ================================================================
    // CHECK IF LOCATION IS WITHIN GEOFENCE
    // ================================================================
    
    private function isWithinGeofence($latitude, $longitude): bool
    {
        $distance = $this->calculateDistance(
            self::GEOFENCE_LATITUDE,
            self::GEOFENCE_LONGITUDE,
            $latitude,
            $longitude
        );
        
        return $distance <= self::GEOFENCE_RADIUS;
    }

    // ================================================================
    // CALCULATE DISTANCE BETWEEN TWO COORDINATES (Haversine formula)
    // ================================================================
    
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // Earth's radius in meters
        
        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);
        
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDiff / 2) * sin($lonDiff / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c; // Distance in meters
    }

    // ================================================================
    // SUBMIT ABSENCE REASON AND SUPPORTING FILE
    // ================================================================
    
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
                'supporting_file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            ], [
                'absence_reason.required' => 'Please provide a reason for your absence.',
                'absence_reason.min' => 'The absence reason must be at least 10 characters.',
                'absence_reason.max' => 'The absence reason cannot exceed 500 characters.',
                'supporting_file.required' => 'Please upload a supporting file.',
                'supporting_file.mimes' => 'File must be: JPG, PNG, PDF, DOC, or DOCX.',
                'supporting_file.max' => 'File size cannot exceed 5MB.',
            ]);

            $file = $request->file('supporting_file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            
            $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $originalName);
            $fileName = time() . '_cadet_' . $cadet->id . '_' . $cleanName . '.' . $extension;
            
            $path = $file->storeAs('absences', $fileName, 'public');
            
            if (!$path) {
                throw new \Exception('Failed to upload file.');
            }
            
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

    // ================================================================
    // CHECK IF TRAINING IS ACCESSIBLE TO CADET
    // ================================================================
    
    private function isTrainingAccessible(Training $training, Cadet $cadet): bool
    {
        if (!$training->involvement) {
            return true;
        }

        $intakeNumber = $cadet->intake_year - 2011;
        $intakeStr = "Intake - " . $intakeNumber;
        
        return str_contains($training->involvement, $intakeStr);
    }

    // ================================================================
    // CHECK IF TRAINING TIME IS VALID FOR ATTENDANCE
    // ================================================================
    
    private function isTrainingTimeValid(Training $training): bool
    {
        $now = Carbon::now();
        $trainingStart = $training->start_datetime;
        $allowedUntil = $trainingStart->copy()->addHours(24);
        
        return $now->between($trainingStart, $allowedUntil);
    }
}