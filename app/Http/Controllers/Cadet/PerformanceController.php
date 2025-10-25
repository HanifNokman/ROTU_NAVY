<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerformanceRating;
use App\Models\Cadet;
use App\Models\Badge;
use App\Models\CadetBadge;
use App\Models\CadetQuizScore;
use App\Models\LearningMaterialCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\BadgeHelper;

class PerformanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->first();

        if (!$cadet) {
            return redirect()->route('cadet.dashboard')->with('error', 'Cadet profile not found.');
        }

        // Get performance ratings for the cadet
        $performanceRatings = PerformanceRating::where('cadet_id', $cadet->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate user's total points and latest overall rating
        $userTotalPoints = $performanceRatings->sum('total_points');
        $userOverallRating = $performanceRatings->first()->rating ?? 'N/A';

        // Get leaderboard data
        $leaderboards = $this->getLeaderboards($cadet->intake_year);

        // Get badges data
        $badgesData = $this->getBadgesData($cadet);

        return view('cadet.performance', compact('performanceRatings', 'cadet', 'leaderboards', 'badgesData', 'userTotalPoints', 'userOverallRating'));
    }

    private function getLeaderboards($cadetIntakeYear)
    {
        $leaderboards = [];

        // Overall Performance Leaderboard
        $leaderboards['overall'] = PerformanceRating::with('cadet.user')
            ->join('cadets', 'performance_ratings.cadet_id', '=', 'cadets.id')
            ->where('cadets.intake_year', $cadetIntakeYear)
            ->select('performance_ratings.cadet_id', DB::raw('SUM(total_points) as total_points'))
            ->groupBy('performance_ratings.cadet_id')
            ->orderBy('total_points', 'desc')
            ->get()
            ->map(function ($rating) {
                return [
                    'cadet' => $rating->cadet,
                    'score' => $rating->total_points,
                ];
            });

        // Attendance Leaderboard
        $leaderboards['attendance'] = PerformanceRating::with('cadet.user')
            ->join('cadets', 'performance_ratings.cadet_id', '=', 'cadets.id')
            ->where('cadets.intake_year', $cadetIntakeYear)
            ->select('performance_ratings.cadet_id', DB::raw('SUM(attendance_points) as attendance_points'))
            ->groupBy('performance_ratings.cadet_id')
            ->orderBy('attendance_points', 'desc')
            ->get()
            ->map(function ($rating) {
                return [
                    'cadet' => $rating->cadet,
                    'score' => $rating->attendance_points,
                ];
            });

        // Quiz Overall Leaderboard (sorted by score then by earliest completion time)
        $leaderboards['quiz_overall'] = CadetQuizScore::with('cadet.user')
            ->join('cadets', 'cadet_quiz_scores.cadet_id', '=', 'cadets.id')
            ->where('cadets.intake_year', $cadetIntakeYear)
            ->select(
                'cadet_quiz_scores.cadet_id',
                DB::raw('AVG(score_percentage) as avg_score'),
                DB::raw('MIN(cadet_quiz_scores.created_at) as earliest_completion')
            )
            ->groupBy('cadet_quiz_scores.cadet_id')
            ->orderBy('avg_score', 'desc')
            ->orderBy('earliest_completion', 'asc')
            ->get()
            ->map(function ($score) {
                return [
                    'cadet' => $score->cadet,
                    'score' => round($score->avg_score, 1),
                    'completed_at' => $score->earliest_completion,
                ];
            });

        // Quiz by Category Leaderboard (sorted by score then by earliest completion time)
        $categories = LearningMaterialCategory::all();
        $leaderboards['quiz_categories'] = [];
        foreach ($categories as $category) {
            $categoryLeaderboard = CadetQuizScore::with('cadet.user')
                ->join('cadets', 'cadet_quiz_scores.cadet_id', '=', 'cadets.id')
                ->where('cadet_quiz_scores.learning_material_category_id', $category->id)
                ->where('cadets.intake_year', $cadetIntakeYear)
                ->select(
                    'cadet_quiz_scores.cadet_id',
                    DB::raw('MAX(score_percentage) as max_score'),
                    DB::raw('MIN(cadet_quiz_scores.created_at) as earliest_completion')
                )
                ->groupBy('cadet_quiz_scores.cadet_id')
                ->orderBy('max_score', 'desc')
                ->orderBy('earliest_completion', 'asc')
                ->get()
                ->map(function ($score) {
                    return [
                        'cadet' => $score->cadet,
                        'score' => $score->max_score,
                        'completed_at' => $score->earliest_completion,
                    ];
                });

            $leaderboards['quiz_categories'][$category->name] = $categoryLeaderboard;
        }

        // Duty Count Leaderboard
        $leaderboards['duty'] = Cadet::with('user')
            ->whereHas('user')
            ->where('intake_year', $cadetIntakeYear)
            ->whereNotNull('daily_duty_count')
            ->orderBy('daily_duty_count', 'desc')
            ->get()
            ->map(function ($cadet) {
                return [
                    'cadet' => $cadet,
                    'score' => $cadet->daily_duty_count,
                ];
            });

        // Learning Progress Leaderboard
        $leaderboards['learning'] = Cadet::with('user', 'categoryProgress')
            ->whereHas('user')
            ->where('intake_year', $cadetIntakeYear)
            ->withCount(['categoryProgress as avg_progress' => function ($query) {
                $query->select(DB::raw('AVG(progress_percentage)'));
            }])
            ->orderBy('avg_progress', 'desc')
            ->get()
            ->map(function ($cadet) {
                return [
                    'cadet' => $cadet,
                    'score' => round($cadet->avg_progress ?? 0, 1),
                ];
            });

        return $leaderboards;
    }

    private function getBadgesData($cadet)
    {
        // Get all active badges
        $allBadges = Badge::active()->get();

        // Get cadet's unlocked badges
        $unlockedBadges = CadetBadge::with('badge')
            ->where('cadet_id', $cadet->id)
            ->get()
            ->keyBy('badge_id');

        // Get display badges for this cadet
        $displayBadges = CadetBadge::with('badge')
            ->where('cadet_id', $cadet->id)
            ->where('is_displayed', true)
            ->get();

        // Note: Badge checking is now handled by CheckCadetBadges middleware on every page load
        // No need to check here anymore - middleware already did it before this controller ran

        // Calculate unlock percentages for all badges
        $totalCadets = Cadet::count();
        $badgeUnlockCounts = CadetBadge::select('badge_id', DB::raw('count(*) as unlock_count'))
            ->groupBy('badge_id')
            ->pluck('unlock_count', 'badge_id');

        // Separate unlocked and unlockable badges
        $unlocked = [];
        $unlockable = [];

        foreach ($allBadges as $badge) {
            $unlockCount = $badgeUnlockCounts[$badge->id] ?? 0;
            $unlockPercentage = $totalCadets > 0 ? round(($unlockCount / $totalCadets) * 100, 1) : 0;

            if (isset($unlockedBadges[$badge->id])) {
                $unlocked[] = [
                    'badge' => $badge,
                    'unlocked_at' => $unlockedBadges[$badge->id]->unlocked_at,
                    'is_displayed' => $unlockedBadges[$badge->id]->is_displayed,
                    'unlock_percentage' => $unlockPercentage,
                    'unlock_count' => $unlockCount,
                    'rarity_level' => $badge->rarity_level
                ];
            } else {
                $unlockable[] = $badge;
                $badge->unlock_percentage = $unlockPercentage;
                $badge->unlock_count = $unlockCount;
            }
        }

        // Sort unlocked badges: Rarest first (5 -> 1)
        usort($unlocked, function($a, $b) {
            return $b['rarity_level'] <=> $a['rarity_level'];
        });

        // Sort unlockable badges: Least rare first (1 -> 5)
        usort($unlockable, function($a, $b) {
            return $a->rarity_level <=> $b->rarity_level;
        });

        // Limit displayed badges to maximum 8, sorted by rarity (rarest first)
        $displayedBadges = collect($displayBadges)
            ->sortByDesc(function($cadetBadge) {
                return $cadetBadge->badge->rarity_level;
            })
            ->take(8)
            ->values()
            ->all();

        return [
            'unlocked' => $unlocked,
            'unlockable' => $unlockable,
            'display' => $displayedBadges
        ];
    }

    // Badge checking is now handled by BadgeCheckingService via CheckCadetBadges middleware
    // This method has been moved to app/Services/BadgeCheckingService.php
    // It runs automatically on every page load, so badges are always up-to-date

    public function toggleBadgeDisplay(Request $request)
    {
        $request->validate([
            'badge_id' => 'required|exists:badges,id',
        ]);

        $cadet = Cadet::where('user_id', Auth::id())->first();

        if (!$cadet) {
            return response()->json(['error' => 'Cadet not found'], 404);
        }

        $cadetBadge = CadetBadge::where('cadet_id', $cadet->id)
            ->where('badge_id', $request->badge_id)
            ->first();

        if (!$cadetBadge) {
            return response()->json(['error' => 'Badge not unlocked'], 404);
        }

        // Check if trying to display but already at 8 badge limit
        if (!$cadetBadge->is_displayed) {
            $currentDisplayedCount = CadetBadge::where('cadet_id', $cadet->id)
                ->where('is_displayed', true)
                ->count();

            if ($currentDisplayedCount >= 8) {
                return response()->json([
                    'success' => false,
                    'error' => 'limit_reached',
                    'message' => 'You can only display a maximum of 8 badges. Please disable one before adding another.'
                ], 400);
            }
        }

        $cadetBadge->toggleDisplay();

        // Get updated count
        $displayedCount = CadetBadge::where('cadet_id', $cadet->id)
            ->where('is_displayed', true)
            ->count();

        return response()->json([
            'success' => true,
            'is_displayed' => $cadetBadge->is_displayed,
            'displayed_count' => $displayedCount
        ]);
    }
}