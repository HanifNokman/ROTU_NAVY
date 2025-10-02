<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cadet;

class CadetDashboardController extends Controller
{
    // ================================================================
    // DISPLAY CADET DASHBOARD
    // ================================================================
    
    public function index(Request $request)
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->firstOrFail();

        $intakeYear = $cadet->intake_year ?? now()->year;
        $tauliahDate = \Carbon\Carbon::createFromDate($intakeYear + 3, 9, 15);

        if (now()->greaterThanOrEqualTo($tauliahDate) && $cadet->rank !== 'Lt.M') {
            $cadet->rank = 'Lt.M';
            $cadet->cadet_status = 'Completed';
            $cadet->save();
        }

        $sortOrder = $request->get('sort_order', 'desc');

        $cadets = Cadet::where('intake_year', $cadet->intake_year)
            ->with('user')
            ->orderBy('daily_duty_count', $sortOrder)
            ->get();

        $dutyCadets = Cadet::where('intake_year', $cadet->intake_year)
            ->with('user')
            ->orderBy('daily_duty_count', $sortOrder)
            ->get();

        $absentCadets = [];
        $absenceLeaderboard = [];
        if (in_array($cadet->position ?? '', ['CO', 'Thana', 'Zayn'])) {
            $absentCadets = $this->getAbsenceDataForIntake($cadet->intake_year);
            $absenceLeaderboard = $this->getAbsenceLeaderboardForIntake($cadet->intake_year);
        }

        if ($request->ajax()) {
            return $this->getDutyRankingData($dutyCadets);
        }

        return view('cadet.dashboard', compact('user', 'cadet', 'cadets', 'sortOrder', 'dutyCadets', 'absentCadets', 'absenceLeaderboard'));
    }

    // ================================================================
    // GET ABSENCE DATA FOR INTAKE
    // ================================================================
    
    private function getAbsenceDataForIntake($intakeYear)
    {
        $absences = \DB::table('training_attendances')
            ->join('cadets', 'training_attendances.cadet_id', '=', 'cadets.id')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
            ->where('training_attendances.present', false)
            ->where('trainings.status', 'Completed')
            ->where('cadets.intake_year', $intakeYear)
            ->where(function($q) {
                $q->whereNull('training_attendances.absence_reason')
                  ->orWhereNull('training_attendances.file_url')
                  ->orWhere('training_attendances.absence_reason', '')
                  ->orWhere('training_attendances.file_url', '');
            })
            ->select([
                'cadets.id as cadet_id',
                'users.name as cadet_name',
                'cadets.service_number',
                'trainings.title as training_title',
                'trainings.location as training_location',
                'trainings.start_datetime',
                'training_attendances.absence_reason',
                'training_attendances.file_url'
            ])
            ->orderBy('cadets.service_number', 'asc')
            ->get();

        $groupedData = [];
        
        foreach ($absences as $absence) {
            $cadetId = $absence->cadet_id;
            
            if (!isset($groupedData[$cadetId])) {
                $groupedData[$cadetId] = (object)[
                    'id' => $cadetId,
                    'name' => $absence->cadet_name,
                    'service_number' => $absence->service_number,
                    'pending_absences' => []
                ];
            }
            
            $missingItems = [];
            if (!$absence->absence_reason || trim($absence->absence_reason) === '') {
                $missingItems[] = 'Reason';
            }
            if (!$absence->file_url || trim($absence->file_url) === '') {
                $missingItems[] = 'Supporting File';
            }
            
            $groupedData[$cadetId]->pending_absences[] = (object)[
                'training_title' => $absence->training_title,
                'training_location' => $absence->training_location,
                'training_date' => \Carbon\Carbon::parse($absence->start_datetime)->format('M d, Y'),
                'missing_items' => implode(', ', $missingItems)
            ];
        }
        
        return array_values($groupedData);
    }

    // ================================================================
    // GET ABSENCE LEADERBOARD FOR INTAKE
    // ================================================================
    
    private function getAbsenceLeaderboardForIntake($intakeYear)
    {
        $absenceData = \DB::table('training_attendances')
            ->join('cadets', 'training_attendances.cadet_id', '=', 'cadets.id')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
            ->where('trainings.status', 'Completed')
            ->where('cadets.intake_year', $intakeYear)
            ->select([
                'cadets.id as cadet_id',
                'users.name as cadet_name',
                'cadets.service_number',
                \DB::raw('COUNT(*) as total_trainings'),
                \DB::raw('SUM(CASE WHEN training_attendances.present = false THEN 1 ELSE 0 END) as absence_count')
            ])
            ->groupBy('cadets.id', 'users.name', 'cadets.service_number')
            ->having('absence_count', '>', 0)
            ->orderBy('absence_count', 'desc')
            ->orderBy('cadets.service_number', 'asc')
            ->get();

        return $absenceData;
    }

    // ================================================================
    // GET DUTY RANKING DATA (AJAX)
    // ================================================================
    
    private function getDutyRankingData($dutyCadets)
    {
        $maxCount = $dutyCadets->max('daily_duty_count') ?: 1;
        $html = '';

        if ($dutyCadets->isEmpty()) {
            $html = '<div class="text-center text-gray-500">No cadets available.</div>';
        } else {
            foreach ($dutyCadets as $index => $cadet) {
                $percentage = ($cadet->daily_duty_count / $maxCount) * 100;

                if ($percentage < 50) {
                    $ratio = $percentage / 50;
                    $r = 255;
                    $g = (int)(180 * $ratio);
                } else {
                    $ratio = ($percentage - 50) / 50;
                    $r = (int)(255 * (1 - $ratio));
                    $g = 180;
                }
                $bgColor = "rgb($r, $g, 0)";

                $pluralDays = $cadet->daily_duty_count == 1 ? 'Day' : 'Days';

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
                            #' . ($index + 1) . ' - ' . ($cadet->user->name ?? '-') . '
                        </div>

                        <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                            <div
                                class="absolute top-0 left-0 h-full rounded-full flex items-center"
                                style="width: ' . $percentage . '%; background-color: ' . $bgColor . ';">
                                <span class="text-white font-semibold text-sm pl-2 whitespace-nowrap">
                                    ' . $cadet->daily_duty_count . ' ' . $pluralDays . '
                                </span>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }

        return response()->json(['html' => $html]);
    }
}