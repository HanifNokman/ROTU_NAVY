<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\Cadet;
use App\Models\TrainingAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AllowanceController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Get year and month from request or use current
        $selectedYear = $request->get('year', $currentYear);
        $selectedMonth = $request->get('month', $currentMonth);

        // Generate year options (current year and past 3 years)
        $years = [];
        for ($i = 0; $i < 4; $i++) {
            $years[] = $currentYear - $i;
        }

        // Get months that have trainings in the selected year
        $monthsWithTrainings = Training::whereYear('start_datetime', $selectedYear)
            ->selectRaw('MONTH(start_datetime) as month')
            ->groupBy('month')
            ->pluck('month')
            ->toArray();

        // Month names
        $allMonths = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        // Only show months with trainings
        $months = [];
        foreach ($monthsWithTrainings as $monthNum) {
            $months[$monthNum] = $allMonths[$monthNum];
        }

        // If no months found, show all months (fallback)
        if (empty($months)) {
            $months = $allMonths;
        }

        // Get trainings for selected month/year
        $trainings = Training::whereYear('start_datetime', $selectedYear)
            ->whereMonth('start_datetime', $selectedMonth)
            ->orderBy('start_datetime', 'desc')
            ->get();

        // Handle AJAX request for filtered content
        if ($request->ajax() || $request->get('ajax')) {
            return $this->renderTrainingListContent($trainings, $months, $selectedYear, $selectedMonth);
        }

        return view('instructor.allowance', compact(
            'trainings',
            'years',
            'months',
            'selectedYear',
            'selectedMonth'
        ));
    }

    /**
     * Render only the training list content for AJAX requests
     */
    private function renderTrainingListContent($trainings, $months, $selectedYear, $selectedMonth)
    {
        $html = '<h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Trainings for <span id="selected-month" class="text-blue-600">' . $months[$selectedMonth] . '</span> <span id="selected-year" class="text-blue-600">' . $selectedYear . '</span>
                </h3>
                
                <div id="training-list-inner">';

        if ($trainings->count() > 0) {
            $html .= '<div class="space-y-4">';
            
            foreach ($trainings as $training) {
                $html .= '<div class="border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                            <!-- Training Header (Clickable) -->
                            <div class="p-4 bg-gradient-to-r from-gray-50 to-blue-50 cursor-pointer hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 training-header" 
                                 data-training-id="' . $training->id . '">
                                <div class="flex justify-between items-center">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 text-base mb-1">' . e($training->title) . '</h4>
                                        <div class="flex items-center text-xs text-gray-600 mb-1">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            ' . $training->start_datetime->format('M d, Y') . ' at ' . $training->start_datetime->format('h:i A') . '
                                        </div>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            ' . e($training->location) . '
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full mr-2">
                                            View Details
                                        </span>
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300 training-arrow" 
                                             id="arrow-' . $training->id . '">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        
                            <!-- Training Details (Hidden by default) -->
                            <div class="hidden training-details" id="details-' . $training->id . '">
                                <!-- Intake Filter Row -->
                                <div class="px-4 py-3 bg-white border-b border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <label for="intake-' . $training->id . '" class="text-xs font-medium text-gray-700 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                            </svg>
                                            Filter by Intake:
                                        </label>
                                        <select id="intake-' . $training->id . '" 
                                                class="text-xs border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 px-2 py-1"
                                                onchange="filterByIntake(' . $training->id . ')">
                                            <option value="">All Intakes</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <!-- Cadet List -->
                                <div class="p-4 bg-white">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden" id="cadets-table-' . $training->id . '">
                                            <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        Service Number
                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        Rank
                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        Name
                                                    </th>
                                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                                        Bank Account
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <!-- Cadets will be loaded here via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                
                                    <!-- Allowance Summary -->
                                    <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200" id="summary-' . $training->id . '">
                                        <!-- Summary will be loaded here via AJAX -->
                                    </div>
                                </div>
                            </div>
                        </div>';
            }
            
            $html .= '</div>';
        } else {
            $html .= '<div class="text-center py-12">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No trainings found</h3>
                            <p class="text-sm text-gray-500">
                                No trainings found for <span id="selected-month-empty" class="font-medium text-blue-600">' . $months[$selectedMonth] . '</span> <span id="selected-year-empty" class="font-medium text-blue-600">' . $selectedYear . '</span>.
                            </p>
                        </div>
                      </div>';
        }

        $html .= '</div>';

        return $html;
    }
    
    public function getTrainingDetails(Request $request, $trainingId)
    {
        $training = Training::with(['attendances.cadet.user'])->findOrFail($trainingId);
        $selectedIntake = $request->get('intake');
        
        // Get present attendances
        $query = $training->attendances()->where('present', true)->with(['cadet.user']);
        
        // Filter by intake if selected
        if ($selectedIntake) {
            $query->whereHas('cadet', function($q) use ($selectedIntake) {
                $intakeYear = $this->parseIntakeToYear($selectedIntake);
                if ($intakeYear) {
                    $q->where('intake_year', $intakeYear);
                }
            });
        }
        
        $presentAttendances = $query->get();
        
        // Get available intakes from present cadets
        // Get present attendances
        $presentAttendances = $training->attendances()->where('present', true)->with(['cadet.user'])->get();

        // Get available intakes and their years
        $intakeData = $presentAttendances->map(function($attendance) {
            if ($attendance->cadet && $attendance->cadet->intake_year) {
                $intakeNum = $attendance->cadet->intake_year - 2011;
                $label = 'Intake - ' . $intakeNum;
                return [
                    'label' => $label,
                    'year' => $attendance->cadet->intake_year
                ];
            }
            return null;
        })->filter();

        // Unique intakes by label
        $availableIntakes = $intakeData->unique('label')->sortBy('year')->values()->pluck('label');

        // Default intake: lowest intake_year
        $defaultIntake = $intakeData->sortBy('year')->first();
        $defaultIntakeLabel = $defaultIntake ? $defaultIntake['label'] : null;
        
        // Calculate allowance based on training type
        $allowanceRate = ($training->allowance_type === 'daily') ? 50 : 8; // RM 50 for daily, RM 8 for hourly
        $totalCadets = $presentAttendances->count();
        $totalAllowance = $totalCadets * $allowanceRate;
        
        return response()->json([
            'cadets' => $presentAttendances->map(function($attendance) {
                $intakeNum = $attendance->cadet && $attendance->cadet->intake_year ? $attendance->cadet->intake_year - 2011 : null;
                $intakeLabel = $attendance->cadet && $attendance->cadet->intake_year ? 'Intake - ' . $intakeNum : 'N/A';
                return [
                    'service_number' => $attendance->cadet->service_number ?? 'N/A',
                    'rank' => $attendance->cadet->rank ?? 'N/A',
                    'name' => $attendance->cadet->user->name ?? 'N/A',
                    'bank_account' => $attendance->cadet->bank_account_number ?? 'N/A',
                    'intake' => $intakeLabel
                ];
            }),
            'summary' => [
                'total_cadets' => $totalCadets,
                'allowance_rate' => $allowanceRate,
                'total_allowance' => $totalAllowance
            ],
            'available_intakes' => $availableIntakes,
            'default_intake' => $defaultIntakeLabel,
            'training' => [
                'title' => $training->title,
                'date' => $training->start_datetime->format('M d, Y'),
                'time' => $training->start_datetime->format('h:i A')
            ]
        ]);
    }
    
    private function parseIntakeToYear($intakeLabel)
    {
        // Extract number from "Intake - 14" format and convert to year
        if (preg_match('/Intake - (\d+)/', $intakeLabel, $matches)) {
            return (int)$matches[1] + 2011; // Convert intake number to year
        }
        return null;
    }
}