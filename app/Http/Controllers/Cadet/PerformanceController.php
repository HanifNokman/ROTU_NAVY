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

        // Check for new badges to unlock
        $this->checkAndUnlockBadges($cadet, $allBadges, $unlockedBadges);

        // Refresh unlocked badges after checking
        $unlockedBadges = CadetBadge::with('badge')
            ->where('cadet_id', $cadet->id)
            ->get()
            ->keyBy('badge_id');

        // Separate unlocked and unlockable badges
        $unlocked = [];
        $unlockable = [];

        foreach ($allBadges as $badge) {
            if (isset($unlockedBadges[$badge->id])) {
                $unlocked[] = [
                    'badge' => $badge,
                    'unlocked_at' => $unlockedBadges[$badge->id]->unlocked_at,
                    'is_displayed' => $unlockedBadges[$badge->id]->is_displayed
                ];
            } else {
                $unlockable[] = $badge;
            }
        }

        return [
            'unlocked' => $unlocked,
            'unlockable' => $unlockable,
            'display' => $displayBadges
        ];
    }

    private function checkAndUnlockBadges($cadet, $allBadges, $existingBadges)
    {
        $performanceRating = $cadet->performanceRating;

        foreach ($allBadges as $badge) {
            // Skip if already unlocked
            if (isset($existingBadges[$badge->id])) {
                continue;
            }

            $shouldUnlock = false;

            switch ($badge->category) {
                case 'overall':
                    // Auto-unlock welcome badge for all cadets
                    if ($badge->name === 'Welcome to ROTU NAVY') {
                        $shouldUnlock = true;
                    }
                    // Promotion badges based on rank
                    elseif ($badge->name === 'Midshipman' && $cadet->rank === 'PKK') {
                        $shouldUnlock = true;
                    } elseif ($badge->name === 'Commissioned Officer' && $cadet->rank === 'Lt.M') {
                        $shouldUnlock = true;
                    }
                    // Best Cadet and Best Academic badges (requires Lt.M rank)
                    elseif ($badge->name === 'Best Cadet' && $cadet->is_best_cadet && $cadet->rank === 'Lt.M') {
                        $shouldUnlock = true;
                    }
                    // Performance badges
                    elseif ($performanceRating) {
                        $totalPoints = $performanceRating->total_points;
                        if ($badge->name === 'Naval Excellence' && $totalPoints >= 800) {
                            $shouldUnlock = true;
                        } elseif ($badge->name === 'Command Excellence' && $totalPoints >= 700) {
                            $shouldUnlock = true;
                        } elseif ($badge->name === 'Rising Officer' && $totalPoints >= 500) {
                            $shouldUnlock = true;
                        }
                    }
                    break;

                case 'attendance':
                    if ($performanceRating) {
                        // Get actual attendance data
                        $totalTrainings = $cadet->trainingAttendances()->count();
                        $presentCount = $cadet->presentAttendances()->count();
                        $attendancePercentage = $totalTrainings > 0 ? ($presentCount / $totalTrainings) * 100 : 0;

                        // Require minimum training sessions to unlock badges
                        $minTrainingsRequired = 5;

                        if ($badge->name === 'Parade Perfect' && $totalTrainings >= $minTrainingsRequired && $attendancePercentage >= 100) {
                            $shouldUnlock = true;
                        } elseif ($badge->name === 'Reliable Sailor' && $totalTrainings >= $minTrainingsRequired && $attendancePercentage >= 90) {
                            $shouldUnlock = true;
                        } elseif ($badge->name === 'Punctual Cadet' && $totalTrainings >= $minTrainingsRequired && $attendancePercentage >= 75) {
                            $shouldUnlock = true;
                        }
                    }
                    break;

                case 'quiz':
                    $quizScores = CadetQuizScore::where('cadet_id', $cadet->id)->get();
                    $totalQuizAttempts = $quizScores->count();
                    $minQuizAttemptsRequired = 5;

                    if ($quizScores->isNotEmpty()) {
                        $avgScore = $quizScores->avg('score_percentage');

                        // Check for all categories passed at difficulty levels
                        $categories = LearningMaterialCategory::all();
                        $allCategoriesPassed = true;

                        if ($badge->name === 'Strategic Mind') {
                            foreach ($categories as $category) {
                                $hardScore = CadetQuizScore::where('cadet_id', $cadet->id)
                                    ->where('learning_material_category_id', $category->id)
                                    ->where('difficulty', 'hard')
                                    ->where('score_percentage', '>=', 80)
                                    ->first();
                                if (!$hardScore) {
                                    $allCategoriesPassed = false;
                                    break;
                                }
                            }
                            // Require minimum quiz attempts for category-based badges
                            $shouldUnlock = $allCategoriesPassed && $totalQuizAttempts >= ($categories->count());
                        } elseif ($badge->name === 'Tactical Expert') {
                            foreach ($categories as $category) {
                                $mediumScore = CadetQuizScore::where('cadet_id', $cadet->id)
                                    ->where('learning_material_category_id', $category->id)
                                    ->where('difficulty', 'medium')
                                    ->where('score_percentage', '>=', 80)
                                    ->first();
                                if (!$mediumScore) {
                                    $allCategoriesPassed = false;
                                    break;
                                }
                            }
                            // Require minimum quiz attempts for category-based badges
                            $shouldUnlock = $allCategoriesPassed && $totalQuizAttempts >= ($categories->count());
                        } elseif ($badge->name === 'Quick Study' && $totalQuizAttempts >= $minQuizAttemptsRequired && $avgScore >= 80) {
                            $shouldUnlock = true;
                        } elseif ($badge->name === 'Knowledgeable Cadet' && $totalQuizAttempts >= $minQuizAttemptsRequired && $avgScore >= 70) {
                            $shouldUnlock = true;
                        }
                    }
                    break;

                case 'learning':
                    $learningProgress = $cadet->getLearningProgressPercentage();
                    $completedMaterials = $cadet->getCompletedMaterialsCount();
                    $totalMaterials = $cadet->getTotalAvailableMaterialsCount();
                    $minMaterialsRequired = 5;

                    // Require minimum materials to be available and completed
                    if ($badge->name === 'Master Navigator' && $totalMaterials >= $minMaterialsRequired && $learningProgress >= 100) {
                        $shouldUnlock = true;
                    } elseif ($badge->name === 'Dedicated Scholar' && $totalMaterials >= $minMaterialsRequired && $learningProgress >= 90) {
                        $shouldUnlock = true;
                    } elseif ($badge->name === 'Knowledge Seeker' && $totalMaterials >= $minMaterialsRequired && $learningProgress >= 75) {
                        $shouldUnlock = true;
                    }
                    break;

                case 'duty':
                    $dutyCount = $cadet->daily_duty_count ?? 0;
                    if ($badge->name === 'Duty Commander' && $dutyCount >= 20) {
                        $shouldUnlock = true;
                    } elseif ($badge->name === 'Watch Officer' && $dutyCount >= 15) {
                        $shouldUnlock = true;
                    } elseif ($badge->name === 'Deckhand' && $dutyCount >= 10) {
                        $shouldUnlock = true;
                    } elseif ($badge->name === 'Seaman Recruit' && $dutyCount >= 5) {
                        $shouldUnlock = true;
                    }
                    break;

                case 'academic':
                    // Best Academic badge (requires Lt.M rank)
                    if ($badge->name === 'Best Academic' && $cadet->is_best_academic && $cadet->rank === 'Lt.M') {
                        $shouldUnlock = true;
                    }
                    // CGPA-based academic badges
                    else {
                        $cgpa = $cadet->current_cgpa ?? 0;
                        if ($badge->name === 'Admiral Scholar' && $cgpa >= 3.75) {
                            $shouldUnlock = true;
                        } elseif ($badge->name === 'Captain Scholar' && $cgpa >= 3.50) {
                            $shouldUnlock = true;
                        } elseif ($badge->name === 'Officer Scholar' && $cgpa >= 3.00) {
                            $shouldUnlock = true;
                        }
                    }
                    break;
            }

            if ($shouldUnlock) {
                CadetBadge::create([
                    'cadet_id' => $cadet->id,
                    'badge_id' => $badge->id,
                    'unlocked_at' => now(),
                    'is_displayed' => false
                ]);
            }
        }
    }

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

        $cadetBadge->toggleDisplay();

        return response()->json([
            'success' => true,
            'is_displayed' => $cadetBadge->is_displayed
        ]);
    }
}