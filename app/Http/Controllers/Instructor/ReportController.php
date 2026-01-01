<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\EquipmentLoan;
use App\Models\Training;
use App\Models\TrainingAttendance;
use App\Models\PerformanceRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index()
    {
        return view('instructor.reports.index');
    }

    /**
     * Generate Training Report
     */
    public function trainingReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'intake_year' => 'nullable|integer',
        ]);

        $query = Training::with(['trainingAttendances.cadet.user']);

        if ($request->start_date) {
            $query->whereDate('start_datetime', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('start_datetime', '<=', $request->end_date);
        }

        $trainings = $query->orderBy('start_datetime', 'desc')->get();

        // Calculate statistics
        $stats = [
            'total_trainings' => $trainings->count(),
            'total_attendances' => TrainingAttendance::whereIn('training_id', $trainings->pluck('id'))->where('present', true)->count(),
            'average_attendance_rate' => 0,
        ];

        if ($trainings->count() > 0) {
            $totalAttendance = 0;
            foreach ($trainings as $training) {
                $present = $training->trainingAttendances->where('present', true)->count();
                $total = $training->trainingAttendances->count();
                if ($total > 0) {
                    $totalAttendance += ($present / $total) * 100;
                }
            }
            $stats['average_attendance_rate'] = round($totalAttendance / $trainings->count(), 1);
        }

        return view('instructor.reports.training', compact('trainings', 'stats', 'request'));
    }

    /**
     * Export Training Report to CSV
     */
    public function exportTrainingReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $query = Training::with(['trainingAttendances.cadet.user']);

        if ($request->start_date) {
            $query->whereDate('start_datetime', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('start_datetime', '>=', $request->end_date);
        }

        $trainings = $query->orderBy('start_datetime', 'desc')->get();

        $filename = 'training_report_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($trainings) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 support
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, ['Date', 'Title', 'Location', 'Start Time', 'End Time', 'Total Cadets', 'Present', 'Absent', 'Attendance Rate (%)']);

            // Data rows
            foreach ($trainings as $training) {
                $total = $training->trainingAttendances->count();
                $present = $training->trainingAttendances->where('present', true)->count();
                $absent = $total - $present;
                $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;

                fputcsv($file, [
                    $training->start_datetime->format('d/m/Y'),
                    $training->title,
                    $training->location,
                    $training->start_datetime->format('H:i'),
                    $training->end_datetime && $training->start_datetime->isSameDay($training->end_datetime) ? $training->end_datetime->format('H:i') : '-',
                    $total,
                    $present,
                    $absent,
                    $rate
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate Attendance Report
     */
    public function attendanceReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'intake_year' => 'nullable|integer',
        ]);

        $query = Cadet::with(['user', 'trainingAttendances.training']);

        if ($request->intake_year) {
            $query->where('intake_year', $request->intake_year);
        }

        $cadets = $query->get();

        // Calculate attendance statistics for each cadet
        $attendanceData = $cadets->map(function ($cadet) use ($request) {
            $attendances = $cadet->trainingAttendances();

            if ($request->start_date) {
                $attendances->whereHas('training', function ($q) use ($request) {
                    $q->where('date', '>=', $request->start_date);
                });
            }

            if ($request->end_date) {
                $attendances->whereHas('training', function ($q) use ($request) {
                    $q->where('date', '<=', $request->end_date);
                });
            }

            $total = $attendances->count();
            $present = $attendances->where('present', true)->count();
            $absent = $total - $present;
            $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;

            return [
                'cadet' => $cadet,
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'rate' => $rate,
            ];
        })->sortByDesc('rate');

        $intakeYears = Cadet::distinct('intake_year')->pluck('intake_year')->sort()->values();

        return view('instructor.reports.attendance', compact('attendanceData', 'intakeYears', 'request'));
    }

    /**
     * Export Attendance Report to CSV
     */
    public function exportAttendanceReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'intake_year' => 'nullable|integer',
        ]);

        $query = Cadet::with(['user', 'trainingAttendances.training']);

        if ($request->intake_year) {
            $query->where('intake_year', $request->intake_year);
        }

        $cadets = $query->get();

        $attendanceData = $cadets->map(function ($cadet) use ($request) {
            $attendances = $cadet->trainingAttendances();

            if ($request->start_date) {
                $attendances->whereHas('training', function ($q) use ($request) {
                    $q->whereDate('start_datetime', '>=', $request->start_date);
                });
            }

            if ($request->end_date) {
                $attendances->whereHas('training', function ($q) use ($request) {
                    $q->whereDate('start_datetime', '<=', $request->end_date);
                });
            }

            $total = $attendances->count();
            $present = $attendances->where('present', true)->count();
            $absent = $total - $present;
            $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;

            return [
                'cadet' => $cadet,
                'total' => $total,
                'present' => $present,
                'absent' => $absent,
                'rate' => $rate,
            ];
        })->sortByDesc('rate');

        $filename = 'attendance_report_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($attendanceData) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['Service No.', 'Name', 'Intake Year', 'Total Sessions', 'Present', 'Absent', 'Attendance Rate (%)', 'Status']);

            foreach ($attendanceData as $data) {
                $cadet = $data['cadet'];
                $rate = $data['rate'];
                $status = $rate >= 80 ? 'Excellent' : ($rate >= 60 ? 'Fair' : 'Poor');

                fputcsv($file, [
                    $cadet->service_number ?? 'N/A',
                    $cadet->user->name ?? 'Unknown',
                    $cadet->intake_year,
                    $data['total'],
                    $data['present'],
                    $data['absent'],
                    $rate,
                    $status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate Inventory Report
     */
    public function inventoryReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:all,active,returned',
        ]);

        $query = EquipmentLoan::with(['cadet.user', 'inventoryItem']);

        if ($request->start_date) {
            $query->where('borrow_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('borrow_date', '<=', $request->end_date);
        }

        if ($request->status === 'active') {
            $query->whereIn('status', ['Borrowed', 'Pending Return']);
        } elseif ($request->status === 'returned') {
            $query->where('status', 'Returned');
        }

        $loans = $query->orderBy('borrow_date', 'desc')->get();

        // Calculate statistics
        $stats = [
            'total_loans' => $loans->count(),
            'active_loans' => $loans->whereIn('status', ['Borrowed', 'Pending Return'])->count(),
            'returned_loans' => $loans->where('status', 'Returned')->count(),
            'overdue_loans' => $loans->filter(fn($loan) => $loan->isOverdue())->count(),
            'pending_returns' => $loans->where('status', 'Pending Return')->count(),
        ];

        return view('instructor.reports.inventory', compact('loans', 'stats', 'request'));
    }

    /**
     * Export Inventory Report to CSV
     */
    public function exportInventoryReport(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:all,active,returned',
        ]);

        $query = EquipmentLoan::with(['cadet.user', 'inventoryItem']);

        if ($request->start_date) {
            $query->where('borrow_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('borrow_date', '<=', $request->end_date);
        }

        if ($request->status === 'active') {
            $query->whereIn('status', ['Borrowed', 'Pending Return']);
        } elseif ($request->status === 'returned') {
            $query->where('status', 'Returned');
        }

        $loans = $query->orderBy('borrow_date', 'desc')->get();

        $filename = 'inventory_report_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($loans) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['Service No.', 'Cadet Name', 'Item Name', 'Quantity', 'Borrow Date', 'Return Date', 'Days Held', 'Status']);

            foreach ($loans as $loan) {
                $daysHeld = $loan->status === 'Returned'
                    ? \Carbon\Carbon::parse($loan->borrow_date)->diffInDays(\Carbon\Carbon::parse($loan->return_date))
                    : \Carbon\Carbon::parse($loan->borrow_date)->diffInDays(now());

                $status = $loan->status === 'Returned' ? 'Returned' :
                         ($loan->status === 'Pending Return' ? 'Pending Return' :
                         ($loan->isOverdue() ? 'Overdue' : 'Borrowed'));

                fputcsv($file, [
                    $loan->cadet->service_number ?? 'N/A',
                    $loan->cadet->user->name ?? 'Unknown',
                    $loan->inventoryItem->name ?? 'Unknown Item',
                    $loan->quantity,
                    \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y'),
                    $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') : '-',
                    $daysHeld,
                    $status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate Cadet Performance Report
     */
    public function performanceReport(Request $request)
    {
        $request->validate([
            'intake_year' => 'nullable|integer',
            'min_rating' => 'nullable|integer|min:0|max:5',
        ]);

        $query = Cadet::with(['user', 'performanceRating', 'quizScores', 'trainingAttendances']);

        if ($request->intake_year) {
            $query->where('intake_year', $request->intake_year);
        }

        $cadets = $query->get();

        // Calculate performance data
        $performanceData = $cadets->map(function ($cadet) {
            $rating = $cadet->performanceRating;
            $stars = $rating ? substr_count($rating->rating, '⭐') : 0;

            return [
                'cadet' => $cadet,
                'rating' => $rating,
                'stars' => $stars,
                'total_points' => $rating->total_points ?? 0,
                'attendance_points' => $rating->attendance_points ?? 0,
                'quiz_points' => $rating->quiz_points ?? 0,
                'learning_progress_points' => $rating->learning_progress_points ?? 0,
            ];
        })->sortByDesc('total_points');

        if ($request->min_rating) {
            $performanceData = $performanceData->filter(fn($data) => $data['stars'] >= $request->min_rating);
        }

        $intakeYears = Cadet::distinct('intake_year')->pluck('intake_year')->sort()->values();

        return view('instructor.reports.performance', compact('performanceData', 'intakeYears', 'request'));
    }

    /**
     * Export Performance Report to CSV
     */
    public function exportPerformanceReport(Request $request)
    {
        $request->validate([
            'intake_year' => 'nullable|integer',
            'min_rating' => 'nullable|integer|min:0|max:5',
        ]);

        $query = Cadet::with(['user', 'performanceRating', 'quizScores', 'trainingAttendances']);

        if ($request->intake_year) {
            $query->where('intake_year', $request->intake_year);
        }

        $cadets = $query->get();

        $performanceData = $cadets->map(function ($cadet) {
            $rating = $cadet->performanceRating;
            $stars = $rating ? substr_count($rating->rating, '⭐') : 0;

            return [
                'cadet' => $cadet,
                'rating' => $rating,
                'stars' => $stars,
                'total_points' => $rating->total_points ?? 0,
                'attendance_points' => $rating->attendance_points ?? 0,
                'quiz_points' => $rating->quiz_points ?? 0,
                'learning_progress_points' => $rating->learning_progress_points ?? 0,
            ];
        })->sortByDesc('total_points');

        if ($request->min_rating) {
            $performanceData = $performanceData->filter(fn($data) => $data['stars'] >= $request->min_rating);
        }

        $filename = 'performance_report_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($performanceData) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['Rank', 'Service No.', 'Name', 'Intake Year', 'Stars', 'Total Points', 'Attendance Points', 'Quiz Points', 'Learning Points']);

            $rank = 1;
            foreach ($performanceData as $data) {
                $cadet = $data['cadet'];

                fputcsv($file, [
                    $rank++,
                    $cadet->service_number ?? 'N/A',
                    $cadet->user->name ?? 'Unknown',
                    $cadet->intake_year,
                    $data['stars'],
                    $data['total_points'],
                    $data['attendance_points'],
                    $data['quiz_points'],
                    $data['learning_progress_points']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate Financial (Allowance) Report
     */
    public function financialReport(Request $request)
    {
        $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020',
            'intake_year' => 'nullable|integer',
        ]);

        // For now, this will be a placeholder as allowance data structure needs to be defined
        // You can expand this based on your allowance system implementation

        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $query = Cadet::with(['user']);

        if ($request->intake_year) {
            $query->where('intake_year', $request->intake_year);
        }

        $cadets = $query->get();

        // Placeholder allowance data - modify based on your actual implementation
        $allowanceData = $cadets->map(function ($cadet) use ($month, $year) {
            return [
                'cadet' => $cadet,
                'base_allowance' => 200.00, // Example base allowance
                'training_bonus' => 50.00,  // Example bonus
                'performance_bonus' => 30.00, // Example bonus
                'total' => 280.00,
            ];
        });

        $intakeYears = Cadet::distinct('intake_year')->pluck('intake_year')->sort()->values();
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        return view('instructor.reports.financial', compact('allowanceData', 'intakeYears', 'months', 'month', 'year', 'request'));
    }

    /**
     * Export Financial Report to CSV
     */
    public function exportFinancialReport(Request $request)
    {
        $request->validate([
            'month' => 'nullable|integer|min:1|max:12',
            'year' => 'nullable|integer|min:2020',
            'intake_year' => 'nullable|integer',
        ]);

        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        $query = Cadet::with(['user']);

        if ($request->intake_year) {
            $query->where('intake_year', $request->intake_year);
        }

        $cadets = $query->get();

        $allowanceData = $cadets->map(function ($cadet) use ($month, $year) {
            return [
                'cadet' => $cadet,
                'base_allowance' => 200.00,
                'training_bonus' => 50.00,
                'performance_bonus' => 30.00,
                'total' => 280.00,
            ];
        });

        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        $filename = 'financial_report_' . $months[$month] . '_' . $year . '_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($allowanceData, $months, $month, $year) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Report header
            fputcsv($file, ['Financial Report (Allowance Summary)']);
            fputcsv($file, ['Period: ' . $months[$month] . ' ' . $year]);
            fputcsv($file, []);

            fputcsv($file, ['Service No.', 'Name', 'Intake Year', 'Base Allowance (RM)', 'Training Bonus (RM)', 'Performance Bonus (RM)', 'Total (RM)']);

            $totalBase = 0;
            $totalTraining = 0;
            $totalPerformance = 0;
            $grandTotal = 0;

            foreach ($allowanceData as $data) {
                $cadet = $data['cadet'];

                fputcsv($file, [
                    $cadet->service_number ?? 'N/A',
                    $cadet->user->name ?? 'Unknown',
                    $cadet->intake_year,
                    number_format($data['base_allowance'], 2),
                    number_format($data['training_bonus'], 2),
                    number_format($data['performance_bonus'], 2),
                    number_format($data['total'], 2)
                ]);

                $totalBase += $data['base_allowance'];
                $totalTraining += $data['training_bonus'];
                $totalPerformance += $data['performance_bonus'];
                $grandTotal += $data['total'];
            }

            fputcsv($file, []);
            fputcsv($file, ['TOTAL', '', '',
                number_format($totalBase, 2),
                number_format($totalTraining, 2),
                number_format($totalPerformance, 2),
                number_format($grandTotal, 2)
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display Analytics Dashboard
     */
    public function analytics()
    {
        // Overall statistics
        $stats = [
            'total_cadets' => Cadet::count(),
            'total_trainings' => Training::count(),
            'total_loans' => EquipmentLoan::count(),
            'active_loans' => EquipmentLoan::whereIn('status', ['Borrowed', 'Pending Return'])->count(),
            'average_attendance' => $this->calculateAverageAttendance(),
            'average_performance' => $this->calculateAveragePerformance(),
        ];

        // Recent trainings
        $recentTrainings = Training::with('trainingAttendances')
            ->orderBy('start_datetime', 'desc')
            ->take(5)
            ->get();

        // Top performers
        $topPerformers = Cadet::with(['user', 'performanceRating'])
            ->whereHas('performanceRating')
            ->get()
            ->sortByDesc(fn($cadet) => $cadet->performanceRating->total_points)
            ->take(10);

        // Attendance trends (last 6 months)
        $attendanceTrends = $this->getAttendanceTrends();

        return view('instructor.reports.analytics', compact('stats', 'recentTrainings', 'topPerformers', 'attendanceTrends'));
    }

    /**
     * Helper: Calculate average attendance rate
     */
    private function calculateAverageAttendance()
    {
        $totalAttendances = TrainingAttendance::count();
        $presentAttendances = TrainingAttendance::where('present', true)->count();

        return $totalAttendances > 0 ? round(($presentAttendances / $totalAttendances) * 100, 1) : 0;
    }

    /**
     * Helper: Calculate average performance points
     */
    private function calculateAveragePerformance()
    {
        return round(PerformanceRating::avg('total_points') ?? 0, 1);
    }

    /**
     * Helper: Get attendance trends for last 6 months
     */
    private function getAttendanceTrends()
    {
        $trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('m/Y');

            $trainings = Training::whereYear('start_datetime', $date->year)
                ->whereMonth('start_datetime', $date->month)
                ->pluck('id');

            $total = TrainingAttendance::whereIn('training_id', $trainings)->count();
            $present = TrainingAttendance::whereIn('training_id', $trainings)->where('present', true)->count();

            $trends[] = [
                'month' => $month,
                'rate' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
            ];
        }

        return $trends;
    }
}
