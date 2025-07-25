<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Instructor;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $instructor = Instructor::where('user_id', $user->id)->first();

        if ($instructor && $instructor->past_unit) {
            $decoded = json_decode($instructor->past_unit, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $instructor->past_unit = is_array($decoded) ? $decoded : [$instructor->past_unit];
            } else {
                $instructor->past_unit = [$instructor->past_unit];
            }
        }

        return view('instructor.dashboard', [
            'user' => $user,
            'instructor' => $instructor,
        ]);
    }
}
