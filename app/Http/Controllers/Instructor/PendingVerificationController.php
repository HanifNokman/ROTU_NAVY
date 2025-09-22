<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserAcceptedMail;

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
        $user->status = 'rejected';
        $user->save();
        return back()->with('success', 'User rejected.');
    }
}
