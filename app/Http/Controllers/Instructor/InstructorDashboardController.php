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
            $intakeOptions = collect(range($currentYear, $minYear))->map(function($year) {
                $intakeNumber = $year - 2011;
                return $intakeNumber > 0 ? [
                    'year' => $year,
                    'label' => 'Intake - ' . $intakeNumber,
                ] : null;
            })->filter()->values();
            
            $latestIntakeYear = $currentYear;
        } else {
            // Take only the 4 most recent intake years
            $recentYears = $cadetYears->take(4);
            $intakeOptions = $recentYears->map(function($year) {
                $intakeNumber = $year - 2011;
                return $intakeNumber > 0 ? [
                    'year' => $year,
                    'label' => 'Intake - ' . $intakeNumber,
                ] : null;
            })->filter()->values();
            
            $latestIntakeYear = $recentYears->first();
        }

        // Fallback if no valid intakes found
        if ($intakeOptions->isEmpty()) {
            $startYear = 2012; // Intake 1
            $endYear = max($currentYear, 2015); // At least until Intake 4
            
            $intakeOptions = collect(range($endYear, $startYear))->map(function($year) {
                return [
                    'year' => $year,
                    'label' => 'Intake - ' . ($year - 2011),
                ];
            });
            
            $latestIntakeYear = $endYear;
        }

        // Separate filters for different sections
        $selectedDutyIntakeYear = $request->get('duty_intake_year', $latestIntakeYear);
        $selectedCgpaIntakeYear = $request->get('cgpa_intake_year', $latestIntakeYear);
        $selectedAbsenceIntake = $request->get('absence_intake_filter', '');
        $sortOrder = $request->get('sort_order', 'desc');
        $cgpaSortOrder = $request->get('cgpa_sort_order', 'desc');

        $cadets = $this->getDutyRankingData($selectedDutyIntakeYear, $sortOrder);
        $cadetList = \App\Models\Cadet::with('user')
            ->where('intake_year', $selectedDutyIntakeYear)
            ->orderBy('service_number', 'asc')
            ->get();
        $cgpaCadets = $this->getCgpaAnalyticsData($selectedCgpaIntakeYear, $cgpaSortOrder);
        $absentCadets = $this->getAbsenceData($selectedAbsenceIntake);
        
        // Get absence leaderboard data - ALWAYS from all intakes for leaderboard
        $absenceLeaderboard = $this->getAllIntakesAbsenceLeaderboard();

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

            // Generate absence HTML if absence filters were changed
            if ($request->has(['absence_intake_filter'])) {
                $response['absence_html'] = $this->generateAbsenceHtml($absentCadets, $selectedAbsenceIntake);
                // Leaderboard always shows all intakes, so regenerate it too
                $response['absence_leaderboard_html'] = $this->generateAbsenceLeaderboardHtml($absenceLeaderboard, '');
            }

            return response()->json($response);
        }

        // Return normal view for non-AJAX requests
        return view('instructor.dashboard', [
            'user' => $user,
            'instructor' => $instructor,
            'intakeOptions' => $intakeOptions,
            'selectedDutyIntakeYear' => $selectedDutyIntakeYear,
            'selectedCgpaIntakeYear' => $selectedCgpaIntakeYear,
            'selectedAbsenceIntake' => $selectedAbsenceIntake,
            'sortOrder' => $sortOrder,
            'cgpaSortOrder' => $cgpaSortOrder,
            'cadets' => $cadets,
            'cadetList' => $cadetList,
            'cgpaCadets' => $cgpaCadets,
            'absentCadets' => $absentCadets,
            'absenceLeaderboard' => $absenceLeaderboard,
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

    private function getAllIntakesAbsenceLeaderboard()
    {
        // Get total trainings and absence count per cadet from ALL intakes (no filtering)
        $absenceData = \DB::table('training_attendances')
            ->join('cadets', 'training_attendances.cadet_id', '=', 'cadets.id')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
            ->where('trainings.status', 'Completed')
            ->select([
                'cadets.id as cadet_id',
                'users.name as cadet_name',
                'cadets.service_number',
                'cadets.intake_year',
                \DB::raw('COUNT(*) as total_trainings'),
                \DB::raw('SUM(CASE WHEN training_attendances.present = false THEN 1 ELSE 0 END) as absence_count')
            ])
            ->groupBy('cadets.id', 'users.name', 'cadets.service_number', 'cadets.intake_year')
            ->having('absence_count', '>', 0)
            ->orderBy('absence_count', 'desc')
            ->orderBy('cadets.intake_year', 'asc')
            ->orderBy('cadets.service_number', 'asc')
            ->get();

        // Group by intake for display
        $groupedData = [];
        foreach ($absenceData as $cadet) {
            $intakeLabel = 'Intake - ' . ($cadet->intake_year - 2011);
            if (!isset($groupedData[$intakeLabel])) {
                $groupedData[$intakeLabel] = [];
            }
            $groupedData[$intakeLabel][] = $cadet;
        }

        return $groupedData;
    }

    private function getAbsenceData($selectedAbsenceIntake)
    {
        // Get cadets with pending absence reasons
        $query = \DB::table('training_attendances')
            ->join('cadets', 'training_attendances.cadet_id', '=', 'cadets.id')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
            ->where('training_attendances.present', false)
            ->where('trainings.status', 'Completed')
            ->where(function($q) {
                // Missing either absence reason OR supporting file (or both)
                $q->whereNull('training_attendances.absence_reason')
                  ->orWhereNull('training_attendances.file_url')
                  ->orWhere('training_attendances.absence_reason', '')
                  ->orWhere('training_attendances.file_url', '');
            });

        // Apply intake filter if specified
        if ($selectedAbsenceIntake && $selectedAbsenceIntake !== '') {
            $query->where('cadets.intake_year', $selectedAbsenceIntake);
        }

        $absences = $query->select([
                'cadets.id as cadet_id',
                'users.name as cadet_name',
                'cadets.service_number',
                'cadets.intake_year',
                'trainings.title as training_title',
                'trainings.location as training_location',
                'trainings.start_datetime',
                'training_attendances.absence_reason',
                'training_attendances.file_url'
            ])
            ->orderBy('cadets.intake_year', 'asc')
            ->orderBy('cadets.service_number', 'asc')
            ->get();

        // Group by cadet and intake
        $groupedData = [];
        
        foreach ($absences as $absence) {
            $intakeLabel = 'Intake - ' . ($absence->intake_year - 2011);
            $cadetId = $absence->cadet_id;
            
            // Initialize intake group if not exists
            if (!isset($groupedData[$intakeLabel])) {
                $groupedData[$intakeLabel] = [];
            }
            
            // Initialize cadet if not exists
            if (!isset($groupedData[$intakeLabel][$cadetId])) {
                $groupedData[$intakeLabel][$cadetId] = (object)[
                    'id' => $cadetId,
                    'name' => $absence->cadet_name,
                    'service_number' => $absence->service_number,
                    'intake_year' => $absence->intake_year,
                    'pending_absences' => []
                ];
            }
            
            // Determine what's missing
            $missingItems = [];
            if (!$absence->absence_reason || trim($absence->absence_reason) === '') {
                $missingItems[] = 'Reason';
            }
            if (!$absence->file_url || trim($absence->file_url) === '') {
                $missingItems[] = 'Supporting File';
            }
            
            // Add absence to cadet
            $groupedData[$intakeLabel][$cadetId]->pending_absences[] = (object)[
                'training_title' => $absence->training_title,
                'training_location' => $absence->training_location,
                'training_date' => \Carbon\Carbon::parse($absence->start_datetime)->format('M d, Y'),
                'missing_items' => implode(', ', $missingItems)
            ];
        }
        
        // Convert to the expected format and remove cadet keys
        $result = [];
        foreach ($groupedData as $intakeLabel => $cadets) {
            $result[$intakeLabel] = array_values($cadets);
        }
        
        return $result;
    }

    private function generateAbsenceLeaderboardHtml($absenceLeaderboard, $selectedAbsenceIntake)
    {
        if (empty($absenceLeaderboard)) {
            return '<div class="text-center py-8">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Perfect Attendance!</h3>
                <p class="text-gray-500">No training absences recorded.</p>
            </div>';
        }

        $html = '';
        $showIntakeGrouping = ($selectedAbsenceIntake === '' || $selectedAbsenceIntake === null);

        if ($showIntakeGrouping && is_array($absenceLeaderboard)) {
            // Show grouped by intake
            foreach ($absenceLeaderboard as $intakeLabel => $cadets) {
                if (empty($cadets)) continue;

                $html .= '<div class="border border-yellow-200 rounded-lg overflow-hidden mb-4">
                    <div class="bg-yellow-50 px-4 py-3 border-b border-yellow-200">
                        <h4 class="font-semibold text-yellow-800 flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            ' . htmlspecialchars($intakeLabel) . '
                            <span class="ml-2 bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                ' . count($cadets) . ' ' . (count($cadets) == 1 ? 'cadet' : 'cadets') . '
                            </span>
                        </h4>
                    </div>
                    <div class="p-4 space-y-3">';

                foreach ($cadets as $index => $cadet) {
                    $html .= $this->generateAbsenceLeaderboardItem($cadet, $index);
                }

                $html .= '</div></div>';
            }
        } else {
            // Show individual cadets
            $cadets = is_array($absenceLeaderboard) ? collect($absenceLeaderboard)->flatten() : $absenceLeaderboard;

            $html .= '<div class="p-4 space-y-3">';
            foreach ($cadets as $index => $cadet) {
                $html .= $this->generateAbsenceLeaderboardItem($cadet, $index);
            }
            $html .= '</div>';
        }

        return $html;
    }

    private function generateAbsenceLeaderboardItem($cadet, $index)
    {
        $attended = $cadet->total_trainings - $cadet->absence_count;

        return '<div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
            <div class="flex-1 w-full">
                <div class="text-sm font-medium mb-1 text-center sm:text-left">
                    #' . ($index + 1) . ' - ' . htmlspecialchars($cadet->cadet_name) . '
                </div>
                <div class="text-center sm:text-left flex flex-col sm:flex-row gap-1 sm:gap-0">
                    <span class="text-sm font-semibold text-gray-800">
                        Training Attended: ' . $attended . ' / ' . $cadet->total_trainings . '
                    </span>
                    <span class="text-sm font-semibold text-red-600 sm:ml-4">
                        Total Absence: ' . $cadet->absence_count . '
                    </span>
                </div>
            </div>
        </div>';
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

    private function generateAbsenceHtml($absentCadets, $selectedAbsenceIntake)
    {
        if (empty($absentCadets)) {
            return '<div class="text-center py-16">
                <div class="mb-6">
                    <svg class="w-20 h-20 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-semibold text-gray-600 mb-3">All Clear!</h3>
                <p class="text-gray-500 text-lg">No pending absence reasons found.</p>
            </div>';
        }

        $html = '';
        
        // Check if we should show intake grouping (when "All Intakes" is selected)
        $showIntakeGrouping = ($selectedAbsenceIntake === '' || $selectedAbsenceIntake === null);
        
        foreach ($absentCadets as $intakeLabel => $cadets) {
            if ($showIntakeGrouping) {
                // Show intake grouping when All Intakes is selected
                $html .= '<div class="border border-red-200 rounded-lg overflow-hidden mb-4">
                    <div class="bg-red-50 px-4 py-3 border-b border-red-200">
                        <h4 class="font-semibold text-red-800 flex items-center">
                            <i class="fas fa-users mr-2"></i>
                            ' . htmlspecialchars($intakeLabel) . '
                            <span class="ml-2 bg-red-200 text-red-800 px-2 py-1 rounded-full text-xs">
                                ' . count($cadets) . ' ' . (count($cadets) == 1 ? 'cadet' : 'cadets') . '
                            </span>
                        </h4>
                    </div>
                    <div class="p-4 space-y-3">';

                foreach ($cadets as $cadet) {
                    $html .= $this->generateCadetDropdownHtml($cadet);
                }

                $html .= '</div></div>';
            } else {
                // Show individual cadets when specific intake is selected (no grouping headers)
                $html .= '<div class="p-4 space-y-3">';
                foreach ($cadets as $cadet) {
                    $html .= $this->generateCadetDropdownHtml($cadet);
                }
                $html .= '</div>';
            }
        }
        
        return $html;
    }

    private function generateCadetDropdownHtml($cadet, $additionalClasses = '')
    {
        $html = '<div class="border border-orange-200 rounded-lg overflow-hidden bg-white' . ($additionalClasses ? ' ' . $additionalClasses : '') . '">
            <button
                onclick="toggleAbsenceDropdown(' . $cadet->id . ')"
                class="w-full flex justify-between items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 transition-colors duration-200"
            >
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="font-semibold text-gray-900">' . htmlspecialchars($cadet->name) . '</p>
                        <p class="text-sm text-gray-600">Service: ' . ($cadet->service_number ?? 'N/A') . '</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                        ' . count($cadet->pending_absences) . ' ' . (count($cadet->pending_absences) == 1 ? 'absence' : 'absences') . '
                    </span>
                    <svg
                        id="absence-icon-' . $cadet->id . '"
                        class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </button>

            <div id="absence-dropdown-' . $cadet->id . '" class="hidden border-t border-orange-200">
                <div class="p-4 space-y-3">
                    <h5 class="font-medium text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-list mr-2 text-red-500"></i>
                        Missing Documentation for:
                    </h5>';

        foreach ($cadet->pending_absences as $absence) {
            $html .= '<div class="bg-red-50 border border-red-200 rounded-lg p-3">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h6 class="font-semibold text-red-900">' . htmlspecialchars($absence->training_title) . '</h6>
                        <div class="text-sm text-red-700 space-y-1 mt-2">
                            <div class="flex items-center">
                                <i class="fas fa-calendar w-4 text-red-500 mr-2"></i>
                                <span>' . $absence->training_date . '</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt w-4 text-red-500 mr-2"></i>
                                <span>' . htmlspecialchars($absence->training_location) . '</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle w-4 text-orange-500 mr-2"></i>
                                <span class="text-xs">
                                    Missing: ' . $absence->missing_items . '
                                </span>
                            </div>
                        </div>
                    </div>
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-medium ml-3">
                        Pending
                    </span>
                </div>
            </div>';
        }

        $html .= '</div></div></div>';

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

        // For AJAX requests, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'Duty count updated.']);
        }

        // For form submissions, redirect back with success message
        return redirect()->back()->with('success', 'Duty count updated successfully.');
    }
}