<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AllowanceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'cadet') {
            abort(403, 'You are not authorized to view this page.');
        }

        $cadet = $user->cadet;
        if (!$cadet) {
            return response()->view('cadet.allowance_missing', [], 403);
        }

        // Validate intake year exists and is reasonable
        $intakeYear = $cadet->intake_year;
        if (!$intakeYear || $intakeYear < 2000 || $intakeYear > Carbon::now()->year + 1) {
            // Handle invalid intake year - set to current year as fallback
            $intakeYear = Carbon::now()->year;
        }

        $currentYear = Carbon::now()->year;
        
        // Year filtering logic: max 3 years after intake or current year, whichever comes first
        $maxYear = min($intakeYear + 3, $currentYear);
        $years = range($intakeYear, $maxYear);

        // Determine selected year
        $selectedYear = (int) $request->get('year', $intakeYear);
        if (!in_array($selectedYear, $years)) {
            $selectedYear = $intakeYear;
        }

        // Get all attended trainings for this cadet (all years)
        $allAttendances = TrainingAttendance::where('cadet_id', $cadet->id)
            ->where('present', true)
            ->with('training')
            ->get();

        // Get months with attended trainings for selected year using DB query
        $monthsWithTrainings = TrainingAttendance::where('cadet_id', $cadet->id)
            ->where('present', true)
            ->whereHas('training', function($q) use ($selectedYear) {
                $q->whereYear('start_datetime', $selectedYear);
            })
            ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
            ->selectRaw('DISTINCT MONTH(trainings.start_datetime) as month')
            ->orderBy('month', 'asc')
            ->pluck('month')
            ->toArray();

        // Month names
        $allMonths = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        // Only show months with actual attendance
        $months = [];
        foreach ($monthsWithTrainings as $monthNum) {
            if (isset($allMonths[$monthNum])) {
                $months[$monthNum] = $allMonths[$monthNum];
            }
        }

        // Improved month selection logic
        $selectedMonth = (int) $request->get('month');

        // If no month specified or month not available, select first available
        if (!$selectedMonth || !array_key_exists($selectedMonth, $months)) {
            $selectedMonth = !empty($months) ? array_key_first($months) : null;
        }

        // Handle case where no months are available
        if (empty($months) || $selectedMonth === null) {
            $trainings = collect(); // Empty collection
            $totalHours = 0;
            $totalDays = 0;
            $hourlyAllowance = 0;
            $dailyAllowance = 0;
            $totalAllowance = 0;
        } else {
            // Get attended trainings for this cadet in selected year/month
            $attendances = $allAttendances->filter(function($attendance) use ($selectedYear, $selectedMonth) {
                $dt = Carbon::parse($attendance->training->start_datetime);
                return $dt->year == $selectedYear && $dt->month == $selectedMonth;
            });

            $trainings = $attendances->map(function($attendance) {
                $training = $attendance->training;
                $duration = '';
                
                if ($training->end_datetime) {
                    $start = Carbon::parse($training->start_datetime);
                    $end = Carbon::parse($training->end_datetime);
                    $diffInMinutes = $start->diffInMinutes($end);
                    $hours = floor($diffInMinutes / 60);
                    $minutes = $diffInMinutes % 60;
                    
                    if ($hours > 0 && $minutes > 0) {
                        $duration = $hours . 'h ' . $minutes . 'm';
                    } elseif ($hours > 0) {
                        $duration = $hours . 'h';
                    } else {
                        $duration = $minutes . 'm';
                    }
                } else {
                    $duration = 'N/A';
                }

                return [
                    'id' => $training->id,
                    'title' => $training->title,
                    'date' => $training->start_datetime->format('d/m/Y'),
                    'location' => $training->location,
                    'duration' => $duration,
                    'type' => $training->allowance_type,
                    'hours' => $training->allowance_type === 'hourly' ? 
                        ($training->end_datetime ? Carbon::parse($training->start_datetime)->diffInHours(Carbon::parse($training->end_datetime)) : 0) : 0,
                    'days' => $training->allowance_type === 'daily' ? 
                        ($training->end_datetime ? Carbon::parse($training->start_datetime)->diffInDays(Carbon::parse($training->end_datetime)) + 1 : 1) : 0,
                ];
            });

            // Calculate totals
            $totalHours = $trainings->where('type', 'hourly')->sum('hours');
            $totalDays = $trainings->where('type', 'daily')->sum('days');
            $hourlyAllowance = $totalHours * 8;
            $dailyAllowance = $totalDays * 50;
            $totalAllowance = $hourlyAllowance + $dailyAllowance;
        }

        // If AJAX request, return only the table and calculation section
        if ($request->ajax()) {
            $html = view('cadet.allowance', compact(
                'trainings',
                'years',
                'months',
                'selectedYear',
                'selectedMonth',
                'totalHours',
                'totalDays',
                'hourlyAllowance',
                'dailyAllowance',
                'totalAllowance'
            ))->render();
            
            // Improved regex to extract allowance-content div with nested content
            if (preg_match('/<div id="allowance-content">(.*?)<\/div>\s*<script/s', $html, $matches)) {
                return response()->json([
                    'html' => $matches[1]
                ]);
            }
            
            // Fallback: try to find the div without script tag
            if (preg_match('/<div id="allowance-content">(.*?)<\/div>(?:\s*<\/div>)*\s*$/s', $html, $matches)) {
                return response()->json([
                    'html' => $matches[1]
                ]);
            }
            
            // If regex fails, return error
            return response()->json([
                'html' => '<div class="text-center py-8 text-red-600"><p>Error loading content. Please refresh the page.</p></div>'
            ], 500);
        }

        return view('cadet.allowance', compact(
            'trainings',
            'years',
            'months',
            'selectedYear',
            'selectedMonth',
            'totalHours',
            'totalDays',
            'hourlyAllowance',
            'dailyAllowance',
            'totalAllowance'
        ));
    }
}