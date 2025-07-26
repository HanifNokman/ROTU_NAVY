<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Instructor;

class InstructorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $instructor = Instructor::where('user_id', $user->id)->first();

        if ($instructor && $instructor->past_unit) {
            $decoded = json_decode($instructor->past_unit, true);
            $instructor->past_unit = json_last_error() === JSON_ERROR_NONE
                ? (is_array($decoded) ? $decoded : [$decoded])
                : [$instructor->past_unit];
        }

        $currentYear = now()->year;
        $minYear = $currentYear - 3;

        $selectedIntakeYear = $request->get('intake_year', $currentYear);
        $sortOrder = $request->get('sort_order', 'desc'); // default to descending

        $intakeOptions = collect(range($currentYear, $minYear))
            ->map(function ($year) {
                return [
                    'year' => $year,
                    'label' => 'Intake - ' . ($year - 2011)
                ];
            });

        $cadets = \DB::table('cadets')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->where('cadets.intake_year', $selectedIntakeYear)
            ->orderBy('cadets.daily_duty_count', $sortOrder)
            ->select('users.name', 'cadets.daily_duty_count')
            ->get();

        return view('instructor.dashboard', [
            'user' => $user,
            'instructor' => $instructor,
            'cadets' => $cadets,
            'intakeOptions' => $intakeOptions,
            'selectedIntakeYear' => $selectedIntakeYear,
            'sortOrder' => $sortOrder,
        ]);
    }
}
