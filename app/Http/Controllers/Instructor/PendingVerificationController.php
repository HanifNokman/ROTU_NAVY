<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAcceptedMail;
use Illuminate\Support\Facades\DB;

class PendingVerificationController extends Controller
{
    /* ================================================================ */
    /* DISPLAY PENDING USERS */
    /* ================================================================ */

    public function index()
    {
        $pendingCadets = User::where('status', 'pending')
            ->where('role', 'cadet')
            ->get();

        $pendingInstructors = User::where('status', 'pending')
            ->where('role', 'instructor')
            ->get();

        return view('instructor.pending-verification', compact('pendingCadets', 'pendingInstructors'));
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
}