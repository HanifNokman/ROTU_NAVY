<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PendingVerificationController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'pending')->get();
        return view('instructor.pending-verification', compact('users'));
    }

    public function accept(User $user)
    {
        $user->status = 'accepted';
        $user->save();
        return back()->with('success', 'User accepted.');
    }

    public function reject(User $user)
    {
        $user->status = 'rejected';
        $user->save();
        return back()->with('success', 'User rejected.');
    }
}
