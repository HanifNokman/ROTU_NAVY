<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\Training;
use App\Models\TrainingAttendance;
use App\Models\PerformanceRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class AttendanceController extends Controller
{
    // Geofence configuration (meetup location)
    private const GEOFENCE_LATITUDE = 6.044440;
    private const GEOFENCE_LONGITUDE = 116.129260;
    private const GEOFENCE_RADIUS = 100; // Radius in meters

    // 6.044440, 116.129260 Palapes UMS
    // 6.027834, 116.143001 Angkasa Apartment

    /**
     * Helper method to safely log data without binary content
     * Writes to separate attendance.log file to avoid Laravel's default request logging
     */
    private function safeLog($level, $message, $context = [])
    {
        try {
            // Write directly to custom file - bypasses all Laravel logging
            $timestamp = now()->format('Y-m-d H:i:s');
            $logMessage = "[{$timestamp}] [{$level}] {$message}";
            
            if (!empty($context)) {
                $safeContext = $this->sanitizeForLog($context);
                $contextStr = is_array($safeContext) ? json_encode($safeContext, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : $safeContext;
                $logMessage .= " | Context: {$contextStr}";
            }
            
            $logMessage .= PHP_EOL;
            
            // Write to custom log file
            $logPath = storage_path('logs/attendance_debug.log');
            
            // Create file if it doesn't exist
            if (!file_exists($logPath)) {
                file_put_contents($logPath, "=== ATTENDANCE DEBUG LOG ===" . PHP_EOL);
                chmod($logPath, 0664);
            }
            
            file_put_contents($logPath, $logMessage, FILE_APPEND | LOCK_EX);
            
        } catch (\Exception $e) {
            // Fallback - don't let logging errors break the app
            error_log("Logging failed: " . $e->getMessage());
        }
    }

    /**
     * Sanitize data for logging - removes binary content
     */
    private function sanitizeForLog($data)
    {
        if (is_null($data)) {
            return 'NULL';
        }
        
        if (is_bool($data)) {
            return $data ? 'TRUE' : 'FALSE';
        }
        
        if (is_scalar($data)) {
            return $data;
        }
        
        if (is_array($data)) {
            $sanitized = [];
            foreach ($data as $key => $value) {
                if (is_object($value)) {
                    $sanitized[$key] = get_class($value);
                } elseif (is_array($value)) {
                    $sanitized[$key] = $this->sanitizeForLog($value);
                } elseif (is_resource($value)) {
                    $sanitized[$key] = 'RESOURCE';
                } else {
                    $sanitized[$key] = $value;
                }
            }
            return $sanitized;
        }
        
        if (is_object($data)) {
            return get_class($data);
        }
        
        return 'UNKNOWN_TYPE';
    }

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

    public function markPresent(Request $request)
    {
        try {
            $this->safeLog('info', '======================================== START');
            $this->safeLog('info', 'ATTENDANCE MARKING ATTEMPT');
            $this->safeLog('info', 'Timestamp: ' . Carbon::now()->toDateTimeString());
            
            // Log authenticated user
            $user = Auth::user();
            $this->safeLog('info', 'User ID: ' . $user->id);
            $this->safeLog('info', 'User Email: ' . $user->email);
            
            // Log ONLY the specific inputs we need
            $this->safeLog('info', 'Training ID: ' . $request->input('training_id', 'MISSING'));
            $this->safeLog('info', 'Latitude: ' . $request->input('latitude', 'MISSING'));
            $this->safeLog('info', 'Longitude: ' . $request->input('longitude', 'MISSING'));
            $this->safeLog('info', 'Has Latitude: ' . ($request->has('latitude') ? 'YES' : 'NO'));
            $this->safeLog('info', 'Has Longitude: ' . ($request->has('longitude') ? 'YES' : 'NO'));
            
            // Get cadet record
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
            $this->safeLog('info', 'Cadet ID: ' . $cadet->id);
            $this->safeLog('info', 'Cadet Intake Year: ' . $cadet->intake_year);
            
            // VALIDATION
            $this->safeLog('info', 'Starting validation...');
            try {
                $validated = $request->validate([
                    'training_id' => 'required|exists:trainings,id',
                    'latitude' => 'required|numeric|between:-90,90',
                    'longitude' => 'required|numeric|between:-180,180',
                ]);
                $this->safeLog('info', 'VALIDATION PASSED');
                $this->safeLog('info', 'Validated Training ID: ' . $validated['training_id']);
                $this->safeLog('info', 'Validated Latitude: ' . $validated['latitude']);
                $this->safeLog('info', 'Validated Longitude: ' . $validated['longitude']);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $this->safeLog('error', 'VALIDATION FAILED');
                foreach ($e->errors() as $field => $errors) {
                    $this->safeLog('error', 'Field: ' . $field . ' - ' . implode(', ', $errors));
                }
                throw $e;
            }
            
            $trainingId = $request->input('training_id');
            $latitude = floatval($request->input('latitude'));
            $longitude = floatval($request->input('longitude'));
            
            $this->safeLog('info', 'Parsed latitude: ' . $latitude);
            $this->safeLog('info', 'Parsed longitude: ' . $longitude);

            // GEOFENCE VALIDATION
            $this->safeLog('info', 'Starting geofence validation...');
            $this->safeLog('info', 'Geofence center: ' . self::GEOFENCE_LATITUDE . ', ' . self::GEOFENCE_LONGITUDE);
            $this->safeLog('info', 'Geofence radius: ' . self::GEOFENCE_RADIUS . 'm');
            
            $distance = $this->calculateDistance(
                self::GEOFENCE_LATITUDE,
                self::GEOFENCE_LONGITUDE,
                $latitude,
                $longitude
            );
            
            $this->safeLog('info', 'Distance from center: ' . round($distance, 2) . 'm');
            $this->safeLog('info', 'Within geofence: ' . ($distance <= self::GEOFENCE_RADIUS ? 'YES' : 'NO'));
            
            if (!$this->isWithinGeofence($latitude, $longitude)) {
                $this->safeLog('warning', 'GEOFENCE CHECK FAILED');
                $this->safeLog('warning', 'User is ' . round($distance - self::GEOFENCE_RADIUS, 2) . 'm outside allowed zone');
                
                return redirect()->back()->with('error', 
                    sprintf('You must be at the designated location. You are %.0fm away (need to be within %dm).', 
                    $distance, self::GEOFENCE_RADIUS)
                );
            }
            
            $this->safeLog('info', 'Geofence validation PASSED');

            // GET TRAINING RECORD
            $this->safeLog('info', 'Fetching training record...');
            $training = Training::findOrFail($trainingId);
            $this->safeLog('info', 'Training ID: ' . $training->id);
            $this->safeLog('info', 'Training Title: ' . $training->title);
            $this->safeLog('info', 'Training Location: ' . $training->location);
            $this->safeLog('info', 'Training Status: ' . $training->status);
            
            // CHECK INTAKE ELIGIBILITY
            $this->safeLog('info', 'Checking intake eligibility...');
            $intakeNumber = $cadet->intake_year - 2011;
            $intakeStr = "Intake - " . $intakeNumber;
            
            $this->safeLog('info', 'Cadet intake string: ' . $intakeStr);
            $this->safeLog('info', 'Training involvement: ' . ($training->involvement ?? 'NULL'));
            
            if ($training->involvement && !str_contains($training->involvement, $intakeStr)) {
                $this->safeLog('warning', 'INTAKE CHECK FAILED - Not eligible');
                return redirect()->back()->with('error', 'You are not eligible for this training session.');
            }
            
            $this->safeLog('info', 'Intake eligibility check PASSED');
            
            // CHECK TIMING VALIDITY
            $this->safeLog('info', 'Checking timing validity...');
            $now = Carbon::now();
            $trainingDate = $training->start_datetime;
            $daysDiff = $now->diffInDays($trainingDate, false);
            
            $this->safeLog('info', 'Days difference: ' . $daysDiff);
            
            if ($daysDiff > 1) {
                $this->safeLog('warning', 'TIMING CHECK FAILED - Training too old');
                return redirect()->back()->with('error', 'This training session is too old to mark attendance.');
            }
            
            $this->safeLog('info', 'Timing validation PASSED');
            
            // CHECK EXISTING ATTENDANCE
            $this->safeLog('info', 'Checking for existing attendance...');
            $attendance = TrainingAttendance::where('training_id', $trainingId)
                ->where('cadet_id', $cadet->id)
                ->first();
            
            if ($attendance) {
                $this->safeLog('info', 'Existing attendance found - ID: ' . $attendance->id);
                $this->safeLog('info', 'Present status: ' . ($attendance->present ? 'TRUE' : 'FALSE'));
                
                if ($attendance->present) {
                    $this->safeLog('warning', 'DUPLICATE ATTENDANCE - Already marked');
                    return redirect()->back()->with('error', 'You have already marked attendance for this training.');
                }
                
                $this->safeLog('info', 'Will update existing ABSENT record to PRESENT');
            } else {
                $this->safeLog('info', 'No existing record - will create new');
                $attendance = new TrainingAttendance([
                    'training_id' => $trainingId,
                    'cadet_id' => $cadet->id,
                ]);
            }
            
            // PREPARE ATTENDANCE DATA
            $this->safeLog('info', 'Preparing attendance data...');
            $attendance->present = true;
            $attendance->method = 'geofence';
            $attendance->marked_at = Carbon::now();
            $attendance->latitude = $latitude;
            $attendance->longitude = $longitude;
            $attendance->absence_reason = null;
            $attendance->file_url = null;
            
            $this->safeLog('info', 'Attendance present: TRUE');
            $this->safeLog('info', 'Attendance method: geofence');
            $this->safeLog('info', 'Attendance latitude: ' . $latitude);
            $this->safeLog('info', 'Attendance longitude: ' . $longitude);
            
            // SAVE TO DATABASE
            $this->safeLog('info', 'Attempting to save to database...');
            try {
                $saved = $attendance->save();
                
                if ($saved) {
                    $this->safeLog('info', '========================================');
                    $this->safeLog('info', 'SUCCESS - ATTENDANCE SAVED');
                    $this->safeLog('info', 'Record ID: ' . $attendance->id);

                    // Update performance rating after attendance is marked
                    $performanceRating = PerformanceRating::getOrCreateForCadet($cadet->id);
                    $performanceRating->updateAttendancePoints();
                    $this->safeLog('info', 'Performance rating updated');

                    $this->safeLog('info', '======================================== END');

                    return redirect()->back()->with('success',
                        'Attendance marked successfully! Location verified within ' . self::GEOFENCE_RADIUS . 'm radius.'
                    );
                } else {
                    $this->safeLog('error', 'Database save returned FALSE');
                    throw new \Exception('Database save operation returned false');
                }
            } catch (\Exception $dbException) {
                $this->safeLog('error', 'DATABASE EXCEPTION');
                $this->safeLog('error', 'Message: ' . $dbException->getMessage());
                $this->safeLog('error', 'File: ' . $dbException->getFile());
                $this->safeLog('error', 'Line: ' . $dbException->getLine());
                throw $dbException;
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->safeLog('error', '======================================== ERROR');
            $this->safeLog('error', 'VALIDATION EXCEPTION');
            foreach ($e->errors() as $field => $errors) {
                $this->safeLog('error', $field . ': ' . implode(', ', $errors));
            }
            
            return redirect()->back()
                ->with('error', 'Location data is required. Please enable location access.')
                ->withErrors($e->validator);
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->safeLog('error', '======================================== ERROR');
            $this->safeLog('error', 'MODEL NOT FOUND EXCEPTION');
            $this->safeLog('error', 'Message: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Record not found. Please try again.');
            
        } catch (\Exception $e) {
            $this->safeLog('error', '======================================== ERROR');
            $this->safeLog('error', 'GENERAL EXCEPTION');
            $this->safeLog('error', 'Type: ' . get_class($e));
            $this->safeLog('error', 'Message: ' . $e->getMessage());
            $this->safeLog('error', 'File: ' . $e->getFile());
            $this->safeLog('error', 'Line: ' . $e->getLine());
            
            return redirect()->back()->with('error', 'Failed to mark attendance. Please try again.');
        }
    }

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

    public function submitAbsence(Request $request, $attendanceId)
    {
        try {
            $this->safeLog('info', '======================================== START');
            $this->safeLog('info', 'ABSENCE SUBMISSION ATTEMPT');
            $this->safeLog('info', 'Attendance ID: ' . $attendanceId);
            
            $user = Auth::user();
            $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
            
            $this->safeLog('info', 'User ID: ' . $user->id);
            $this->safeLog('info', 'Cadet ID: ' . $cadet->id);
            
            $attendance = TrainingAttendance::where('id', $attendanceId)
                ->where('cadet_id', $cadet->id)
                ->where('present', false)
                ->firstOrFail();

            $this->safeLog('info', 'Attendance record found');
            $this->safeLog('info', 'Training ID: ' . $attendance->training_id);

            $this->safeLog('info', 'Has absence_reason: ' . ($request->has('absence_reason') ? 'YES' : 'NO'));
            $this->safeLog('info', 'Has supporting_file: ' . ($request->hasFile('supporting_file') ? 'YES' : 'NO'));

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

            $this->safeLog('info', 'Validation passed');

            $file = $request->file('supporting_file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            
            $cleanName = preg_replace('/[^A-Za-z0-9\-_]/', '_', $originalName);
            $fileName = time() . '_cadet_' . $cadet->id . '_' . $cleanName . '.' . $extension;
            
            $this->safeLog('info', 'File name: ' . $fileName);
            $this->safeLog('info', 'File size: ' . $file->getSize() . ' bytes');
            $this->safeLog('info', 'File mime: ' . $file->getMimeType());
            
            $path = $file->storeAs('absences', $fileName, 'public');
            
            if (!$path) {
                $this->safeLog('error', 'File upload failed');
                throw new \Exception('Failed to upload file.');
            }
            
            $this->safeLog('info', 'File uploaded: ' . $path);
            
            $attendance->absence_reason = $request->input('absence_reason');
            $attendance->file_url = $path;
            $attendance->updated_at = Carbon::now();
            
            $saved = $attendance->save();
            
            if ($saved) {
                $this->safeLog('info', 'SUCCESS - ABSENCE SUBMITTED');
                $this->safeLog('info', '======================================== END');
                return redirect()->back()->with('success', 'Absence reason and supporting documentation submitted successfully!');
            } else {
                $this->safeLog('error', 'Database save returned FALSE');
                throw new \Exception('Failed to save absence data');
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->safeLog('error', 'VALIDATION EXCEPTION');
            foreach ($e->errors() as $field => $errors) {
                $this->safeLog('error', $field . ': ' . implode(', ', $errors));
            }
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            $this->safeLog('error', 'EXCEPTION: ' . $e->getMessage());
            $this->safeLog('error', 'File: ' . $e->getFile() . ' Line: ' . $e->getLine());
            return redirect()->back()
                ->with('error', 'Failed to submit absence information. Please try again.')
                ->withInput();
        }
    }
}