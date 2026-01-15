<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use App\Models\ContentSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAcceptedMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Notifications\WelcomeNotification;
use App\Notifications\SelectionCompleteNotification;
use Illuminate\Support\Facades\Notification;

class PendingVerificationController extends Controller
{
    /* ================================================================ */
    /* DISPLAY PENDING USERS */
    /* ================================================================ */

    public function index()
    {
        // Check if 1 week has passed since selection completion and delete applications
        $selectionCompletedAt = ContentSetting::get('selection_completed_at');
        if ($selectionCompletedAt) {
            $completionDate = Carbon::parse($selectionCompletedAt);
            $oneWeekLater = $completionDate->addWeek();

            if (Carbon::now()->greaterThanOrEqualTo($oneWeekLater)) {
                Application::truncate();
                ContentSetting::where('key', 'selection_completed_at')->delete();
                \Log::info("Applications deleted automatically 1 week after selection process completion.");
            }
        }

        $pendingCadets = User::where('status', 'pending')
            ->where('role', 'cadet')
            ->get();

        $pendingInstructors = User::where('status', 'pending')
            ->where('role', 'instructor')
            ->get();

        // Only show applications that have at least 1 pending test result
        $applications = Application::where(function($query) {
            $query->where('attendance', 'pending')
                ->orWhere('drill_test', 'pending')
                ->orWhere('physical_test', 'pending')
                ->orWhere('medical_test', 'pending')
                ->orWhere('interview', 'pending')
                ->orWhere('final_evaluation', 'pending');
        })->get();

        return view('instructor.pending-verification', compact('pendingCadets', 'pendingInstructors', 'applications'));
    }

    /* ================================================================ */
    /* ACCEPT USER VERIFICATION */
    /* ================================================================ */

    public function accept(User $user)
    {
        $user->status = 'accepted';
        $user->save();

        if ($user->role === 'cadet') {
            $cadet = \App\Models\Cadet::firstOrCreate(['user_id' => $user->id]);
            $cadet->daily_duty_count = 0;
            $cadet->save();
        } elseif ($user->role === 'instructor') {
            \App\Models\Instructor::firstOrCreate(['user_id' => $user->id]);
        }

        try {
            Mail::to($user->email)->send(new UserAcceptedMail($user));
        } catch (\Exception $e) {
            \Log::error('Failed to send acceptance email to user ' . $user->id . ': ' . $e->getMessage());
        }

        return back()->with('success', 'User accepted and notification email sent.');
    }

    /* ================================================================ */
    /* REJECT USER VERIFICATION */
    /* ================================================================ */

    public function reject(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                $userEmail = $user->email;
                $userName = $user->name;
                $userRole = $user->role;

                if ($user->role === 'cadet') {
                    \App\Models\Cadet::where('user_id', $user->id)->delete();
                } elseif ($user->role === 'instructor') {
                    \App\Models\Instructor::where('user_id', $user->id)->delete();
                }

                $user->delete();

                \Log::info("User rejected and deleted: {$userName} ({$userEmail}) - Role: {$userRole}");
            });

            return back()->with('success', 'User rejected and removed from the system. They can now register again with the same email if needed.');

        } catch (\Exception $e) {
            \Log::error('Failed to reject and delete user ' . $user->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to reject user. Please try again.');
        }
    }

    /* ================================================================ */
    /* ACCEPT ALL USERS BY ROLE */
    /* ================================================================ */

    public function acceptAll(Request $request)
    {
        $request->validate([
            'role' => 'required|in:cadet,instructor'
        ]);

        $role = $request->role;
        $users = User::where('status', 'pending')
            ->where('role', $role)
            ->get();

        if ($users->isEmpty()) {
            return back()->with('error', "No pending {$role}s to accept.");
        }

        $acceptedCount = 0;
        $emailFailures = 0;

        foreach ($users as $user) {
            $user->status = 'accepted';
            $user->save();

            if ($user->role === 'cadet') {
                $cadet = \App\Models\Cadet::firstOrCreate(['user_id' => $user->id]);
                $cadet->daily_duty_count = 0;
                $cadet->save();
            } elseif ($user->role === 'instructor') {
                \App\Models\Instructor::firstOrCreate(['user_id' => $user->id]);
            }

            try {
                Mail::to($user->email)->send(new UserAcceptedMail($user));
            } catch (\Exception $e) {
                \Log::error('Failed to send acceptance email to user ' . $user->id . ': ' . $e->getMessage());
                $emailFailures++;
            }

            $acceptedCount++;
        }

        $message = "Successfully accepted {$acceptedCount} {$role}" . ($acceptedCount > 1 ? 's' : '') . '.';
        if ($emailFailures > 0) {
            $message .= " However, {$emailFailures} email notification(s) failed to send.";
        }

        return back()->with('success', $message);
    }

    /* ================================================================ */
    /* REJECT ALL USERS BY ROLE */
    /* ================================================================ */

    public function rejectAll(Request $request)
    {
        $request->validate([
            'role' => 'required|in:cadet,instructor'
        ]);

        $role = $request->role;
        $users = User::where('status', 'pending')
            ->where('role', $role)
            ->get();

        if ($users->isEmpty()) {
            return back()->with('error', "No pending {$role}s to reject.");
        }

        $rejectedCount = 0;

        try {
            DB::transaction(function () use ($users, &$rejectedCount) {
                foreach ($users as $user) {
                    $userEmail = $user->email;
                    $userName = $user->name;
                    $userRole = $user->role;

                    if ($user->role === 'cadet') {
                        \App\Models\Cadet::where('user_id', $user->id)->delete();
                    } elseif ($user->role === 'instructor') {
                        \App\Models\Instructor::where('user_id', $user->id)->delete();
                    }

                    $user->delete();
                    $rejectedCount++;

                    \Log::info("User rejected and deleted: {$userName} ({$userEmail}) - Role: {$userRole}");
                }
            });

            return back()->with('success', "Successfully rejected and removed {$rejectedCount} {$role}" . ($rejectedCount > 1 ? 's' : '') . " from the system.");

        } catch (\Exception $e) {
            \Log::error('Failed to reject all users: ' . $e->getMessage());
            return back()->with('error', 'Failed to reject users. Please try again.');
        }
    }

    /* ================================================================ */
    /* UPDATE APPLICATION STEP */
    /* ================================================================ */

    public function updateApplicationStep(Request $request)
    {
        $rules = [
            'application_id' => 'required|exists:applications,id',
            'step' => 'required|in:attendance,marching_test,physical_test,medical_test,interview,final_evaluation',
            'status' => 'required|in:passed,failed'
        ];

        // Require reason when marking as failed
        if ($request->status === 'failed') {
            $rules['reason'] = 'required|string|max:500';
        }

        $request->validate($rules);

        try {
            $application = Application::findOrFail($request->application_id);

            // Map step names to database columns
            $columnMap = [
                'attendance' => 'attendance',
                'marching_test' => 'drill_test',
                'physical_test' => 'physical_test',
                'medical_test' => 'medical_test',
                'interview' => 'interview',
                'final_evaluation' => 'final_evaluation'
            ];

            // Map step names to reason columns
            $reasonColumnMap = [
                'attendance' => 'attendance_reason',
                'marching_test' => 'drill_test_reason',
                'physical_test' => 'physical_test_reason',
                'medical_test' => 'medical_test_reason',
                'interview' => 'interview_reason',
                'final_evaluation' => 'final_evaluation_reason'
            ];

            // Define the evaluation order (must match frontend order)
            $evaluationOrder = [
                'attendance',
                'drill_test',
                'physical_test',
                'medical_test',
                'interview',
                'final_evaluation'
            ];

            // Reason column order
            $reasonOrder = [
                'attendance_reason',
                'drill_test_reason',
                'physical_test_reason',
                'medical_test_reason',
                'interview_reason',
                'final_evaluation_reason'
            ];

            $column = $columnMap[$request->step];
            $reasonColumn = $reasonColumnMap[$request->step];
            $application->$column = $request->status;

            // CASCADE FAILURE LOGIC:
            // If this stage is marked as 'failed', mark all subsequent stages as failed with cascade reason
            if ($request->status === 'failed') {
                // Save the instructor's reason for this stage
                $application->$reasonColumn = $request->reason;

                $currentStageIndex = array_search($column, $evaluationOrder);

                // Mark all stages after the failed stage as 'failed' with cascade reason
                for ($i = $currentStageIndex + 1; $i < count($evaluationOrder); $i++) {
                    $subsequentStage = $evaluationOrder[$i];
                    $subsequentReasonColumn = $reasonOrder[$i];
                    $application->$subsequentStage = 'failed';
                    $application->$subsequentReasonColumn = 'Tidak layak - gagal penilaian sebelumnya';
                }

                \Log::info("Cascade failure applied: {$application->name} failed at {$column} with reason: {$request->reason}");
            } else {
                // If marking as passed, clear the reason for this stage
                $application->$reasonColumn = null;
            }

            $application->save();

            return response()->json([
                'success' => true,
                'message' => 'Application updated successfully'
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to update application: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update application'
            ], 500);
        }
    }

    /* ================================================================ */
    /* END SELECTION PROCESS */
    /* ================================================================ */

    public function endSelection(Request $request)
    {
        try {
            $createdCount = 0;
            $failedCreations = [];

            DB::transaction(function () use (&$createdCount, &$failedCreations) {
                // Automatically update final_evaluation to 'passed' for applicants who have all previous evaluations passed
                // This prevents candidates from disappearing before the selection process is officially completed
                $autoPassCount = Application::where('attendance', 'passed')
                    ->where('drill_test', 'passed')
                    ->where('physical_test', 'passed')
                    ->where('medical_test', 'passed')
                    ->where('interview', 'passed')
                    ->where('final_evaluation', 'pending')
                    ->update(['final_evaluation' => 'passed']);

                \Log::info("Auto-passed final_evaluation for {$autoPassCount} qualified applicant(s)");

                // Get all applications that passed all steps
                $passedApplications = Application::where('attendance', 'passed')
                    ->where('drill_test', 'passed')
                    ->where('physical_test', 'passed')
                    ->where('medical_test', 'passed')
                    ->where('interview', 'passed')
                    ->where('final_evaluation', 'passed')
                    ->get();

                if ($passedApplications->isEmpty()) {
                    throw new \Exception('No passed applications found to process.');
                }

                foreach ($passedApplications as $application) {
                    try {
                        // Check if user with this email already exists
                        $existingUser = User::where('email', $application->email)->first();
                        if ($existingUser) {
                            $failedCreations[] = "{$application->name} - Email already exists";
                            \Log::warning("Skipped application for {$application->name} - email {$application->email} already exists");
                            continue;
                        }

                        // Check if matric_no already exists
                        $existingMatric = \App\Models\Cadet::where('matric_no', $application->matric_no)->first();
                        if ($existingMatric) {
                            $failedCreations[] = "{$application->name} - Matric number already exists";
                            \Log::warning("Skipped application for {$application->name} - matric {$application->matric_no} already exists");
                            continue;
                        }

                        // Validate required fields
                        if (empty($application->email) || empty($application->matric_no)) {
                            $failedCreations[] = "{$application->name} - Missing email or matric number";
                            \Log::warning("Skipped application for {$application->name} - missing required fields");
                            continue;
                        }

                        // Create user account
                        $user = User::create([
                            'name' => $application->name,
                            'email' => $application->email,
                            'password' => Hash::make($application->matric_no),
                            'role' => 'cadet',
                            'status' => 'accepted',
                        ]);

                        // Create cadet record
                        \App\Models\Cadet::create([
                            'user_id' => $user->id,
                            'phone_number' => $application->phone_number,
                            'gender' => $application->gender,
                            'ic_number' => $application->ic_number,
                            'matric_no' => $application->matric_no,
                            'faculty' => $application->faculty,
                            'course' => $application->course,
                            'profile_pic' => $application->profile_pic,
                            'BMI' => $application->bmi,
                            'rank' => 'PK',
                            'position' => 'Normal',
                            'cadet_status' => 'Active',
                            'intake_year' => \App\Models\Cadet::getEffectiveIntakeYear(),
                            'daily_duty_count' => 0,
                            'swimming_qualification' => 'In Progress',
                        ]);

                        // Send welcome notification with temporary password
                        try {
                            $user->notify(new WelcomeNotification('cadet', $application->matric_no));
                        } catch (\Exception $e) {
                            \Log::error('Failed to send welcome notification to ' . $user->email . ': ' . $e->getMessage());
                            // Don't fail the whole process if notification fails
                        }

                        $createdCount++;
                        \Log::info("Successfully created cadet account for {$application->name}");

                    } catch (\Exception $e) {
                        $failedCreations[] = "{$application->name} - {$e->getMessage()}";
                        \Log::error("Failed to create cadet account for {$application->name}: " . $e->getMessage());
                        // Continue with next application instead of failing entire transaction
                        continue;
                    }
                }

                // Mark all remaining candidates with pending fields as failed with appropriate reasons
                $pendingApplications = Application::where(function($query) {
                    $query->where('attendance', 'pending')
                        ->orWhere('drill_test', 'pending')
                        ->orWhere('physical_test', 'pending')
                        ->orWhere('medical_test', 'pending')
                        ->orWhere('interview', 'pending')
                        ->orWhere('final_evaluation', 'pending');
                })->get();

                $evaluationOrder = ['attendance', 'drill_test', 'physical_test', 'medical_test', 'interview', 'final_evaluation'];
                $reasonOrder = ['attendance_reason', 'drill_test_reason', 'physical_test_reason', 'medical_test_reason', 'interview_reason', 'final_evaluation_reason'];

                foreach ($pendingApplications as $application) {
                    $firstPendingFound = false;

                    for ($i = 0; $i < count($evaluationOrder); $i++) {
                        $stage = $evaluationOrder[$i];
                        $reasonColumn = $reasonOrder[$i];

                        if ($application->$stage === 'pending') {
                            $application->$stage = 'failed';

                            if (!$firstPendingFound) {
                                // First pending stage gets "Tidak hadir untuk penilaian"
                                $application->$reasonColumn = 'Tidak hadir untuk penilaian';
                                $firstPendingFound = true;
                            } else {
                                // Subsequent stages get cascade reason
                                $application->$reasonColumn = 'Tidak layak - gagal penilaian sebelumnya';
                            }
                        }
                    }

                    $application->save();
                }

                \Log::info("Marked " . $pendingApplications->count() . " application(s) with pending fields as failed with reasons.");

                // Store selection completion date instead of immediately deleting applications
                if ($createdCount > 0) {
                    $completionDate = Carbon::now();
                    ContentSetting::set('selection_completed_at', $completionDate->toDateTimeString(), 'datetime', 'Date when selection process was completed');
                    \Log::info("Selection process completed. Created {$createdCount} cadet accounts. Applications will be deleted after 1 week.");
                }
            });

            // Send selection complete notification to all applicants
            $intakeYear = \App\Models\Cadet::getEffectiveIntakeYear();
            $allApplications = Application::all();
            $emailsSent = 0;
            $emailsFailed = 0;

            foreach ($allApplications as $application) {
                try {
                    // Create a notifiable object with email and name
                    $notifiable = new \stdClass();
                    $notifiable->email = $application->email;
                    $notifiable->name = $application->name;

                    Notification::route('mail', $application->email)
                        ->notify(new SelectionCompleteNotification($intakeYear));

                    $emailsSent++;
                } catch (\Exception $e) {
                    \Log::error("Failed to send selection complete email to {$application->email}: " . $e->getMessage());
                    $emailsFailed++;
                }
            }

            \Log::info("Sent selection complete notification to {$emailsSent} applicant(s). Failed: {$emailsFailed}");

            // Build success message
            $message = "Selection process completed successfully! Created {$createdCount} cadet account" . ($createdCount != 1 ? 's' : '') . '.';
            $message .= " Notification emails sent to {$emailsSent} applicant(s).";

            if (!empty($failedCreations)) {
                $message .= " However, " . count($failedCreations) . " account creation(s) failed: " . implode(', ', $failedCreations);
            }

            return redirect()->route('instructor.pending.verification')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Failed to complete selection process: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->with('error', 'Failed to complete selection process: ' . $e->getMessage());
        }
    }
}