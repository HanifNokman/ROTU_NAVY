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

        // Intake options for both duty leaderboard and CGPA comparison
        $intakeOptions = collect(range($currentYear, $minYear))->map(fn($year) => [
            'year' => $year,
            'label' => 'Intake - ' . ($year - 2011),
        ]);

        // Separate filters for duty ranking and CGPA comparison
        $selectedDutyIntakeYear = $request->get('duty_intake_year', $currentYear);
        $selectedCgpaIntakeYear = $request->get('cgpa_intake_year', $currentYear);
        $sortOrder = $request->get('sort_order', 'desc');
        $cgpaSortOrder = $request->get('cgpa_sort_order', 'desc');

        // Duty ranking data
        $cadets = \DB::table('cadets')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->where('cadets.intake_year', $selectedDutyIntakeYear)
            ->orderBy('cadets.daily_duty_count', $sortOrder)
            ->select('users.name', 'cadets.daily_duty_count', 'cadets.current_cgpa', 'cadets.past_cgpa')
            ->get();

        $cadetList = \App\Models\Cadet::with('user')
            ->where('intake_year', $selectedDutyIntakeYear)
            ->orderBy('service_number', 'asc') // sort by seniority
            ->get();

        // CGPA comparison data
        $cgpaCadets = \DB::table('cadets')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->where('cadets.intake_year', $selectedCgpaIntakeYear)
            ->whereNotNull('cadets.current_cgpa')
            ->whereNotNull('cadets.past_cgpa')
            ->orderBy('cadets.current_cgpa', $cgpaSortOrder)
            ->select(
                'users.name', 
                'cadets.current_cgpa', 
                'cadets.past_cgpa',
                'cadets.service_number'
            )
            ->get();

        return view('instructor.dashboard', [
            'user' => $user,
            'instructor' => $instructor,
            'intakeOptions' => $intakeOptions,
            'selectedDutyIntakeYear' => $selectedDutyIntakeYear,
            'selectedCgpaIntakeYear' => $selectedCgpaIntakeYear,
            'sortOrder' => $sortOrder,
            'cgpaSortOrder' => $cgpaSortOrder,
            'cadets' => $cadets,
            'cadetList' => $cadetList,
            'cgpaCadets' => $cgpaCadets,
        ]);
    }

    public function incrementDuty(Request $request)
    {
        $request->validate([
            'cadet_ids' => 'required|array',
            'cadet_ids.*' => 'exists:cadets,id',
        ]);

        foreach ($request->cadet_ids as $cadetId) {
            \App\Models\Cadet::where('id', $cadetId)->increment('daily_duty_count');
        }

        return response()->json(['message' => 'Duty count updated.']);
    }
}