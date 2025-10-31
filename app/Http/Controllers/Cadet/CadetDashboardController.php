<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cadet;
use App\Helpers\BadgeHelper;

class CadetDashboardController extends Controller
{
    // ================================================================
    // DISPLAY CADET DASHBOARD
    // ================================================================
    
    public function index(Request $request)
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)
            ->with([
                'cadetBadges' => function($query) {
                    $query->where('is_displayed', true)
                        ->with('badge');
                }
            ])
            ->firstOrFail();

        // Sort displayed badges by rarity (rarest first) and limit to 12
        $cadet->cadetBadges = $cadet->cadetBadges->sortByDesc(function($cadetBadge) {
            return $cadetBadge->badge->rarity_level;
        })->take(12)->values();

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

        // Get intake cadets with performance data and badges
        // Custom ordering: CO, Thana, Zayn, PMC, then Normal Cadets by service number
        $intakeCadets = Cadet::where('intake_year', $cadet->intake_year)
            ->with([
                'user',
                'performanceRating',
                'cadetBadges' => function($query) {
                    $query->where('is_displayed', true)
                        ->with('badge');
                }
            ])
            ->get()
            ->map(function($intakeCadet) {
                // Sort each cadet's badges by rarity (rarest first) and limit to 12
                $intakeCadet->cadetBadges = $intakeCadet->cadetBadges->sortByDesc(function($cadetBadge) {
                    return $cadetBadge->badge->rarity_level;
                })->take(12)->values();
                return $intakeCadet;
            })
            ->sortBy(function($cadet) {
                // Define position priority
                $positionOrder = [
                    'CO' => 1,
                    'Thana' => 2,
                    'Zayn' => 3,
                    'PMC' => 4,
                    'Normal Cadet' => 5,
                    'Normal' => 5,
                ];
                
                $position = $cadet->position ?? 'Normal';
                $priority = $positionOrder[$position] ?? 5;
                
                // For normal cadets, use service number as secondary sort
                $serviceNumber = $cadet->service_number ?? '9999';
                
                // Return compound sort key: position priority + service number
                return sprintf('%d-%s', $priority, $serviceNumber);
            })
            ->values();

        $absentCadets = [];
        $absenceLeaderboard = [];
        $allowedPositions = ['CO', 'Thana', 'Zayn'];
        $cadetPosition = trim($cadet->position ?? '');

        // Case-insensitive check for allowed positions
        if (in_array(strtolower($cadetPosition), array_map('strtolower', $allowedPositions))) {
            $absentCadets = $this->getAbsenceDataForIntake($cadet->intake_year);
            $absenceLeaderboard = $this->getAbsenceLeaderboardForIntake($cadet->intake_year);
        }

        if ($request->ajax()) {
            return $this->getDutyRankingData($dutyCadets);
        }

        // Get badge progress for badges nearing completion (>=50% progress)
        $badgeProgress = BadgeHelper::getBadgeProgress($cadet->id, 50);

        return view('cadet.dashboard', compact(
            'user',
            'cadet',
            'cadets',
            'sortOrder',
            'dutyCadets',
            'absentCadets',
            'absenceLeaderboard',
            'intakeCadets',
            'badgeProgress'
        ));
    }

    // ================================================================
    // GET CADET DETAILS FOR MODAL (AJAX)
    // ================================================================
    
    public function getCadetDetails($cadetId)
    {
        $cadet = Cadet::with([
            'user',
            'performanceRating',
            'cadetBadges' => function($query) {
                $query->where('is_displayed', true)
                    ->with('badge');
            }
        ])->findOrFail($cadetId);

        // Sort displayed badges by rarity (rarest first) and limit to 12
        $cadet->cadetBadges = $cadet->cadetBadges->sortByDesc(function($cadetBadge) {
            return $cadetBadge->badge->rarity_level;
        })->take(12)->values();

        return response()->json([
            'success' => true,
            'cadet' => [
                'id' => $cadet->id,
                'name' => $cadet->user->name ?? 'N/A',
                'rank' => $cadet->rank ?? 'N/A',
                'service_number' => $cadet->service_number ?? 'N/A',
                'position' => $cadet->position ?? 'Normal Cadet',
                'profile_pic' => $cadet->profile_pic
                    ? asset('storage/' . $cadet->profile_pic)
                    : asset('images/default.png'),
                'matric_no' => $cadet->matric_no ?? 'N/A',
                'faculty' => $cadet->faculty ?? 'N/A',
                'course' => $cadet->course ?? 'N/A',
                'email' => $cadet->user->email ?? 'N/A',
                'phone_number' => $cadet->phone_number ?? 'N/A',
                'rating' => $cadet->performanceRating->rating ?? '⭐☆☆☆☆',
                'total_points' => $cadet->performanceRating->total_points ?? 0,
                'attendance_points' => $cadet->performanceRating->attendance_points ?? 0,
                'quiz_points' => $cadet->performanceRating->quiz_points ?? 0,
                'learning_progress_points' => $cadet->performanceRating->learning_progress_points ?? 0,
                'duty_points' => $cadet->performanceRating->duty_points ?? 0,
                'academic_points' => $cadet->performanceRating->academic_points ?? 0,
                'position_bonus_points' => $cadet->performanceRating->position_bonus_points ?? 0,
                'is_best_cadet' => $cadet->is_best_cadet ?? false,
                'is_best_academic' => $cadet->is_best_academic ?? false,
                'badges' => $cadet->cadetBadges->map(function($cadetBadge) {
                    return [
                        'name' => $cadetBadge->badge->name,
                        'icon_path' => $cadetBadge->badge->icon_path,
                        'description' => $cadetBadge->badge->description,
                        'rarity_level' => $cadetBadge->badge->rarity_level,
                        'rarity_label' => $cadetBadge->badge->rarity_label,
                        'rarity_color' => $cadetBadge->badge->rarity_color,
                        'unlocked_at' => $cadetBadge->formatted_unlock_date
                    ];
                })
            ]
        ]);
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