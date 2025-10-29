<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DOMDocument;

class AllowanceController extends Controller
{
    // ================================================================
    // DISPLAY ALLOWANCE INDEX
    // ================================================================
    
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

        $intakeYear = $cadet->intake_year;
        if (!$intakeYear || $intakeYear < 2000 || $intakeYear > Carbon::now()->year + 1) {
            $intakeYear = Carbon::now()->year;
        }

        $currentYear = Carbon::now()->year;
        $maxYear = min($intakeYear + 3, $currentYear);
        $years = range($intakeYear, $maxYear);

        $selectedYear = (int) $request->get('year', $currentYear);
        if (!in_array($selectedYear, $years)) {
            $selectedYear = $currentYear;
        }

        $allAttendances = TrainingAttendance::where('cadet_id', $cadet->id)
            ->where('present', true)
            ->with('training')
            ->get();

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

        $allMonths = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        $months = [];
        foreach ($monthsWithTrainings as $monthNum) {
            if (isset($allMonths[$monthNum])) {
                $months[$monthNum] = $allMonths[$monthNum];
            }
        }

        $selectedMonth = (int) $request->get('month');

        if (!$selectedMonth || !array_key_exists($selectedMonth, $months)) {
            $selectedMonth = !empty($months) ? array_key_first($months) : null;
        }

        if (empty($months) || $selectedMonth === null) {
            $trainings = collect();
            $totalHours = 0;
            $totalDays = 0;
            $hourlyAllowance = 0;
            $dailyAllowance = 0;
            $totalAllowance = 0;
        } else {
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

                $startDate = Carbon::parse($training->start_datetime);
                $endDate = $training->end_datetime ? Carbon::parse($training->end_datetime) : null;

                if ($endDate && $startDate->format('Y-m-d') !== $endDate->format('Y-m-d')) {
                    $date = $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y');
                } else {
                    $date = $startDate->format('d/m/Y');
                }

                return [
                    'id' => $training->id,
                    'title' => $training->title,
                    'date' => $date,
                    'location' => $training->location,
                    'duration' => $duration,
                    'type' => $training->allowance_type,
                    'hours' => $training->allowance_type === 'hourly' ?
                        ($training->end_datetime ? intval(Carbon::parse($training->start_datetime)->diffInHours(Carbon::parse($training->end_datetime))) : 0) : 0,
                    'days' => $training->allowance_type === 'daily' ?
                        ($training->end_datetime ? Carbon::parse($training->start_datetime)->diffInDays(Carbon::parse($training->end_datetime)) + 1 : 1) : 0,
                ];
            });

            $totalHours = $trainings->where('type', 'hourly')->sum('hours');
            $totalDays = floor($trainings->where('type', 'daily')->sum('days'));
            $hourlyAllowance = $totalHours * 8;
            $dailyAllowance = $totalDays * 50;
            $totalAllowance = $hourlyAllowance + $dailyAllowance;
        }

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

            $dom = new DOMDocument();
            @$dom->loadHTML($html);
            $div = $dom->getElementById('allowance-content');
            if ($div) {
                $innerHTML = '';
                foreach ($div->childNodes as $child) {
                    $innerHTML .= $dom->saveHTML($child);
                }
                return response()->json([
                    'html' => $innerHTML
                ]);
            }

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