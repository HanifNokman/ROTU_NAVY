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

    public function accept(User $user)
    {
        $user->status = 'accepted';
        $user->save();

        // Automatically create Cadet or Instructor record if not exists
        if ($user->role === 'cadet') {
            $cadet = \App\Models\Cadet::firstOrCreate(
                ['user_id' => $user->id]
            );
            $cadet->daily_duty_count = 0;
            $cadet->save();
        } elseif ($user->role === 'instructor') {
            \App\Models\Instructor::firstOrCreate(['user_id' => $user->id]);
        }

        // Send acceptance email to the user
        try {
            Mail::to($user->email)->send(new UserAcceptedMail($user));
        } catch (\Exception $e) {
            // Log the error but don't fail the acceptance process
            \Log::error('Failed to send acceptance email to user ' . $user->id . ': ' . $e->getMessage());
        }

        return back()->with('success', 'User accepted and notification email sent.');
    }

    public function reject(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                // Store user details for logging before deletion
                $userEmail = $user->email;
                $userName = $user->name;
                $userRole = $user->role;
                
                // Delete any related records first (if they exist)
                if ($user->role === 'cadet') {
                    // Delete cadet record if it exists
                    \App\Models\Cadet::where('user_id', $user->id)->delete();
                } elseif ($user->role === 'instructor') {
                    // Delete instructor record if it exists
                    \App\Models\Instructor::where('user_id', $user->id)->delete();
                }
                
                // Delete the user completely from the database
                $user->delete();
                
                // Log the rejection for audit purposes
                \Log::info("User rejected and deleted: {$userName} ({$userEmail}) - Role: {$userRole}");
            });

            return back()->with('success', 'User rejected and removed from the system. They can now register again with the same email if needed.');
            
        } catch (\Exception $e) {
            \Log::error('Failed to reject and delete user ' . $user->id . ': ' . $e->getMessage());
            return back()->with('error', 'Failed to reject user. Please try again.');
        }
    }
}