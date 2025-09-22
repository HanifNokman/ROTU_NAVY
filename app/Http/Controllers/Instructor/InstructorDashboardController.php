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

        // Get all unique intake years from cadets table, sorted by most recent first
        $cadetYears = \App\Models\Cadet::distinct()->pluck('intake_year')->sort()->reverse()->values();

        // If no cadets exist, use current year and previous 3 years
        if ($cadetYears->isEmpty()) {
            $minYear = $currentYear - 3;
            $intakeOptions = collect(range($currentYear, $minYear))->map(fn($year) => [
                'year' => $year,
                'label' => 'Intake - ' . ($year - 2011),
            ]);
            $latestIntakeYear = $currentYear;
        } else {
            // Take only the 4 most recent intake years (sliding window)
            $recentYears = $cadetYears->take(4);
            $intakeOptions = $recentYears->map(fn($year) => [
                'year' => $year,
                'label' => 'Intake - ' . ($year - 2011),
            ]);
            $latestIntakeYear = $recentYears->first(); // Most recent year
        }

        // Get the most recent intake year that has cadets

        // Separate filters for duty ranking and CGPA comparison
        $selectedDutyIntakeYear = $request->get('duty_intake_year', $latestIntakeYear);
        $selectedCgpaIntakeYear = $request->get('cgpa_intake_year', $latestIntakeYear);
        $sortOrder = $request->get('sort_order', 'desc');
        $cgpaSortOrder = $request->get('cgpa_sort_order', 'desc');

        // Get data
        $cadets = $this->getDutyRankingData($selectedDutyIntakeYear, $sortOrder);
        $cadetList = \App\Models\Cadet::with('user')
            ->where('intake_year', $selectedDutyIntakeYear)
            ->orderBy('service_number', 'asc')
            ->get();
        $cgpaCadets = $this->getCgpaAnalyticsData($selectedCgpaIntakeYear, $cgpaSortOrder);

        // If this is an AJAX request, return JSON with HTML fragments
        if ($request->ajax() || $request->wantsJson()) {
            $response = [];

            // Generate duty ranking HTML if duty filters were changed
            if ($request->has(['duty_intake_year']) || $request->has(['sort_order'])) {
                $response['duty_html'] = $this->generateDutyRankingHtml($cadets);
                $response['cadet_list'] = $cadetList->map(function($cadet) {
                    return [
                        'id' => $cadet->id,
                        'name' => $cadet->user->name,
                        'service_number' => $cadet->service_number
                    ];
                });
            }

            // Generate CGPA analytics HTML if CGPA filters were changed
            if ($request->has(['cgpa_intake_year']) || $request->has(['cgpa_sort_order'])) {
                $response['cgpa_html'] = $this->generateCgpaAnalyticsHtml($cgpaCadets);
            }

            // Always include the data for the view to work properly
            $response['cadets'] = $cadets;
            $response['cgpaCadets'] = $cgpaCadets;

            return response()->json($response);
        }

        // Return normal view for non-AJAX requests
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

    private function getDutyRankingData($selectedDutyIntakeYear, $sortOrder)
    {
        return \DB::table('cadets')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->where('cadets.intake_year', $selectedDutyIntakeYear)
            ->orderBy('cadets.daily_duty_count', $sortOrder)
            ->select('users.name', 'cadets.daily_duty_count', 'cadets.current_cgpa', 'cadets.past_cgpa')
            ->get();
    }

    private function getCgpaAnalyticsData($selectedCgpaIntakeYear, $cgpaSortOrder)
    {
        // For CGPA sorting, we need to sort by improvement/decline
        // desc = most improvement first, asc = most decline first
        return \DB::table('cadets')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->where('cadets.intake_year', $selectedCgpaIntakeYear)
            ->whereNotNull('cadets.current_cgpa')
            ->whereNotNull('cadets.past_cgpa')
            ->selectRaw('
                users.name, 
                cadets.current_cgpa, 
                cadets.past_cgpa,
                cadets.service_number,
                (cadets.current_cgpa - cadets.past_cgpa) as cgpa_change
            ')
            ->orderBy('cgpa_change', $cgpaSortOrder)
            ->get();
    }

    private function generateDutyRankingHtml($cadets)
    {
        if ($cadets->isEmpty()) {
            return '<div class="text-center text-gray-500">No cadets available.</div>';
        }

        $maxCount = $cadets->max('daily_duty_count') ?: 1;
        $html = '';
        
        foreach ($cadets as $index => $cadet) {
            $percentage = ($cadet->daily_duty_count / $maxCount) * 100;
            
            // Calculate RGB color from red → yellow → green based on percentage
            if ($percentage < 50) {
                $ratio = $percentage / 50; // 0 to 1
                $r = 255;
                $g = (int)(180 * $ratio);
            } else {
                $ratio = ($percentage - 50) / 50; // 0 to 1
                $r = (int)(255 * (1 - $ratio));
                $g = 180;
            }
            $bgColor = "rgb($r, $g, 0)";
            
            $dayText = $cadet->daily_duty_count == 1 ? 'Day' : 'Days';
            
            $html .= '
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <div class="text-sm font-medium mb-1 text-center sm:text-left">
                        #' . ($index + 1) . ' - ' . htmlspecialchars($cadet->name) . '
                    </div>
                    <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                        <div class="absolute top-0 left-0 h-full rounded-full flex items-center"
                            style="width: ' . $percentage . '%; background-color: ' . $bgColor . ';">
                            <span class="text-white font-semibold text-sm pl-2 whitespace-nowrap">
                                ' . $cadet->daily_duty_count . ' ' . $dayText . '
                            </span>
                        </div>
                    </div>
                </div>
            </div>';
        }
        
        return $html;
    }

    private function generateCgpaAnalyticsHtml($cgpaCadets)
    {
        if ($cgpaCadets->isEmpty()) {
            return '<div class="text-center text-gray-500">No CGPA data available for this intake.</div>';
        }

        $maxCgpa = max($cgpaCadets->max('current_cgpa'), $cgpaCadets->max('past_cgpa')) ?: 4.0;
        $html = '';
        
        foreach ($cgpaCadets as $index => $cadet) {
            $pastPercentage = ($cadet->past_cgpa / $maxCgpa) * 100;
            $currentPercentage = ($cadet->current_cgpa / $maxCgpa) * 100;
            $cgpaChange = $cadet->current_cgpa - $cadet->past_cgpa;
            
            // Color logic: green if improved, red if declined
            $currentColor = $cgpaChange >= 0 ? '#10b981' : '#ef4444'; // green-500 or red-500
            $pastColor = '#3b82f6'; // blue-500
            
            $changeClass = $cgpaChange >= 0 ? 'text-green-600' : 'text-red-600';
            $changeText = ($cgpaChange >= 0 ? '+' : '') . number_format($cgpaChange, 2);
            
            $html .= '
            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <div class="text-sm font-medium mb-1 text-center sm:text-left flex justify-between items-center">
                        <span>#' . ($index + 1) . ' - ' . htmlspecialchars($cadet->name) . '</span>
                        <span class="text-xs ' . $changeClass . '">' . $changeText . '</span>
                    </div>
                    <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                        <div class="absolute top-0 left-0 h-full rounded-full"
                            style="width: ' . $currentPercentage . '%; background-color: ' . $currentColor . ';">
                        </div>
                        <span class="absolute inset-0 flex items-center justify-start pl-2 text-white font-semibold text-xs">
                            Current: ' . number_format($cadet->current_cgpa, 2) . '
                        </span>
                    </div>
                    <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden mb-1">
                        <div class="absolute top-0 left-0 h-full rounded-full"
                            style="width: ' . $pastPercentage . '%; background-color: ' . $pastColor . ';">
                        </div>
                        <span class="absolute inset-0 flex items-center justify-start pl-2 text-white font-semibold text-xs">
                            Past: ' . number_format($cadet->past_cgpa, 2) . '
                        </span>
                    </div>
                </div>
            </div>';
        }
        
        return $html;
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