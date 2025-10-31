<?php

namespace App\Helpers;

use App\Models\Badge;
use App\Models\CadetBadge;
use App\Models\Cadet;
use Illuminate\Support\Facades\Auth;

class BadgeHelper
{
    /**
     * Unlock a badge for a cadet
     *
     * @param int $cadetId
     * @param int $badgeId
     * @return CadetBadge|null
     */
    public static function unlockBadge($cadetId, $badgeId)
    {
        // Check if badge already exists
        $existingBadge = CadetBadge::where('cadet_id', $cadetId)
            ->where('badge_id', $badgeId)
            ->first();

        if ($existingBadge) {
            return null; // Badge already unlocked
        }

        // Create new badge unlock
        $cadetBadge = CadetBadge::create([
            'cadet_id' => $cadetId,
            'badge_id' => $badgeId,
            'unlocked_at' => now(),
            'is_displayed' => false, // For profile display preference
            'modal_shown' => false, // Will be shown via modal
        ]);

        return $cadetBadge;
    }

    /**
     * Get all badges where unlock modal hasn't been shown yet
     *
     * @param int|null $cadetId
     * @return \Illuminate\Support\Collection
     */
    public static function getPendingBadges($cadetId = null)
    {
        if (!$cadetId) {
            $user = Auth::user();
            if ($user->role !== 'cadet') {
                return collect([]);
            }

            $cadet = Cadet::where('user_id', $user->id)->first();
            if (!$cadet) {
                return collect([]);
            }

            $cadetId = $cadet->id;
        }

        $pendingBadges = CadetBadge::where('cadet_id', $cadetId)
            ->where('modal_shown', false)
            ->with('badge')
            ->orderBy('unlocked_at', 'asc')
            ->get();

        return $pendingBadges->map(function ($cadetBadge) {
            $badge = $cadetBadge->badge;
            return [
                'id' => $cadetBadge->id,
                'badge_id' => $badge->id,
                'name' => $badge->name,
                'description' => $badge->description,
                'unlock_criteria' => $badge->unlock_criteria,
                'category' => $badge->category,
                'rarity_level' => $badge->rarity_level,
                'rarity_label' => $badge->rarity_label,
                'rarity_color' => $badge->rarity_color,
                'icon' => $badge->icon,
                'icon_url' => $badge->icon_url,
                'unlocked_at' => $cadetBadge->unlocked_at->toISOString(),
            ];
        });
    }

    /**
     * Mark a badge modal as shown
     *
     * @param int $cadetBadgeId
     * @return bool
     */
    public static function markAsDisplayed($cadetBadgeId)
    {
        $cadetBadge = CadetBadge::find($cadetBadgeId);

        if (!$cadetBadge) {
            return false;
        }

        $cadetBadge->modal_shown = true;
        $cadetBadge->save();

        return true;
    }

    /**
     * Trigger a badge unlock event (for use in views/JavaScript)
     *
     * @param array $badgeData
     * @return string JavaScript code to trigger the badge modal
     */
    public static function triggerBadgeUnlock($badgeData)
    {
        $json = json_encode($badgeData);
        return "<script>window.dispatchEvent(new CustomEvent('badge-unlocked', { detail: {$json} }));</script>";
    }

    /**
     * Check and award attendance-based badges
     *
     * @param int $cadetId
     * @return array Array of newly unlocked badge IDs
     */
    public static function checkAttendanceBadges($cadetId)
    {
        $cadet = Cadet::find($cadetId);
        if (!$cadet) {
            return [];
        }

        $unlockedBadges = [];

        // Get attendance percentage (you'll need to implement this based on your attendance tracking)
        // Example: 100% attendance, 90% attendance, etc.

        return $unlockedBadges;
    }

    /**
     * Check and award quiz-based badges
     *
     * @param int $cadetId
     * @return array Array of newly unlocked badge IDs
     */
    public static function checkQuizBadges($cadetId)
    {
        $cadet = Cadet::find($cadetId);
        if (!$cadet) {
            return [];
        }

        $unlockedBadges = [];

        // Implement quiz badge logic based on quiz scores

        return $unlockedBadges;
    }

    /**
     * Award a specific badge to a cadet and return badge data for modal
     *
     * @param int $cadetId
     * @param int $badgeId
     * @return array|null Badge data if newly unlocked, null if already had it
     */
    public static function awardBadge($cadetId, $badgeId)
    {
        $cadetBadge = self::unlockBadge($cadetId, $badgeId);

        if (!$cadetBadge) {
            return null; // Already unlocked
        }

        $badge = Badge::find($badgeId);

        return [
            'id' => $cadetBadge->id,
            'badge_id' => $badge->id,
            'name' => $badge->name,
            'description' => $badge->description,
            'unlock_criteria' => $badge->unlock_criteria,
            'category' => $badge->category,
            'rarity_level' => $badge->rarity_level,
            'rarity_label' => $badge->rarity_label,
            'rarity_color' => $badge->rarity_color,
            'icon' => $badge->icon,
            'icon_url' => $badge->icon_url,
            'unlocked_at' => $cadetBadge->unlocked_at->toISOString(),
        ];
    }

    /**
     * Get badge progress for badges nearing completion (>=50% progress)
     * Only returns badges that are not yet unlocked
     *
     * @param int $cadetId
     * @param int $minProgressPercentage Minimum progress to show (default 50%)
     * @return array Array of badge progress data
     */
    public static function getBadgeProgress($cadetId, $minProgressPercentage = 50)
    {
        $cadet = Cadet::with(['performanceRating', 'trainingAttendances'])->find($cadetId);
        if (!$cadet) {
            return [];
        }

        // Get already unlocked badge IDs
        $unlockedBadgeIds = CadetBadge::where('cadet_id', $cadetId)
            ->pluck('badge_id')
            ->toArray();

        // Get all active badges not yet unlocked
        $availableBadges = Badge::active()
            ->whereNotIn('id', $unlockedBadgeIds)
            ->get();

        $badgeProgress = [];
        $performanceRating = $cadet->performanceRating;

        foreach ($availableBadges as $badge) {
            $progress = self::calculateBadgeProgress($cadet, $badge, $performanceRating);

            // Only include badges with progress >= minimum threshold
            if ($progress && isset($progress['progress']['percentage']) && $progress['progress']['percentage'] >= $minProgressPercentage) {
                $badgeProgress[] = $progress;
            }
        }

        // Sort by progress percentage (highest first)
        usort($badgeProgress, function ($a, $b) {
            return $b['progress']['percentage'] <=> $a['progress']['percentage'];
        });

        return $badgeProgress;
    }

    /**
     * Calculate progress for a specific badge
     *
     * @param Cadet $cadet
     * @param Badge $badge
     * @param mixed $performanceRating
     * @return array|null Progress data or null if not applicable
     */
    private static function calculateBadgeProgress(Cadet $cadet, Badge $badge, $performanceRating)
    {
        $current = 0;
        $target = 0;
        $criteriaText = '';
        $percentage = 0;

        switch ($badge->category) {
            case 'overall':
                if ($badge->name === 'Cadet Induction') {
                    return null; // Auto-unlocked, no progress needed
                } elseif ($badge->name === 'Aquatic Warrior') {
                    // Swimming badge - binary, no progress
                    return null;
                } elseif ($badge->name === 'Midshipman') {
                    // Rank-based - binary, no progress
                    return null;
                } elseif ($badge->name === 'Commissioned Officer') {
                    // Rank-based - binary, no progress
                    return null;
                } elseif ($badge->name === 'Best Cadet') {
                    // Best cadet flag - binary, no progress
                    return null;
                } elseif ($performanceRating) {
                    $current = $performanceRating->total_points;
                    if ($badge->name === 'Naval Excellence') {
                        $target = 800;
                        $criteriaText = 'Earn 800 total points';
                    } elseif ($badge->name === 'Command Excellence') {
                        $target = 700;
                        $criteriaText = 'Earn 700 total points';
                    } elseif ($badge->name === 'Rising Officer') {
                        $target = 500;
                        $criteriaText = 'Earn 500 total points';
                    }
                }
                break;

            case 'attendance':
                $totalTrainings = $cadet->trainingAttendances()->count();
                $presentCount = $cadet->presentAttendances()->count();
                $attendancePercentage = $totalTrainings > 0 ? ($presentCount / $totalTrainings) * 100 : 0;
                $minTrainingsRequired = 5;

                if ($totalTrainings >= $minTrainingsRequired) {
                    if ($badge->name === 'Parade Perfect') {
                        $current = round($attendancePercentage, 1);
                        $target = 100;
                        $criteriaText = "Achieve 100% attendance (min {$minTrainingsRequired} trainings)";
                    } elseif ($badge->name === 'Reliable Sailor') {
                        $current = round($attendancePercentage, 1);
                        $target = 90;
                        $criteriaText = "Achieve 90% attendance (min {$minTrainingsRequired} trainings)";
                    } elseif ($badge->name === 'Punctual Cadet') {
                        $current = round($attendancePercentage, 1);
                        $target = 75;
                        $criteriaText = "Achieve 75% attendance (min {$minTrainingsRequired} trainings)";
                    }
                } else {
                    // Show training count progress if minimum not met
                    $current = $totalTrainings;
                    $target = $minTrainingsRequired;
                    $criteriaText = "Attend {$minTrainingsRequired} trainings to unlock attendance badges";
                }
                break;

            case 'quiz':
                $quizScores = \App\Models\CadetQuizScore::where('cadet_id', $cadet->id)->get();
                $totalQuizAttempts = $quizScores->count();
                $minQuizAttemptsRequired = 5;

                if ($quizScores->isNotEmpty()) {
                    $avgScore = $quizScores->avg('score_percentage');

                    if ($badge->name === 'Strategic Mind' || $badge->name === 'Tactical Expert') {
                        // Category-based badges
                        $categories = \App\Models\LearningMaterialCategory::all();
                        $difficulty = $badge->name === 'Strategic Mind' ? 'hard' : 'medium';
                        $passedCategories = 0;

                        foreach ($categories as $category) {
                            $hasScore = \App\Models\CadetQuizScore::where('cadet_id', $cadet->id)
                                ->where('learning_material_category_id', $category->id)
                                ->where('difficulty', $difficulty)
                                ->where('score_percentage', '>=', 80)
                                ->exists();
                            if ($hasScore) {
                                $passedCategories++;
                            }
                        }

                        $current = $passedCategories;
                        $target = $categories->count();
                        $criteriaText = "Pass all {$target} categories at {$difficulty} difficulty with 80%+";
                    } elseif ($badge->name === 'Quick Study') {
                        $current = min($totalQuizAttempts, $minQuizAttemptsRequired);
                        $target = $minQuizAttemptsRequired;
                        $criteriaText = "Complete {$target} quizzes with 80%+ average score";

                        // If attempts requirement met, show score progress
                        if ($totalQuizAttempts >= $minQuizAttemptsRequired) {
                            $current = round($avgScore, 1);
                            $target = 80;
                            $criteriaText = "Achieve 80% average quiz score ({$totalQuizAttempts} quizzes completed)";
                        }
                    } elseif ($badge->name === 'Knowledgeable Cadet') {
                        $current = min($totalQuizAttempts, $minQuizAttemptsRequired);
                        $target = $minQuizAttemptsRequired;
                        $criteriaText = "Complete {$target} quizzes with 70%+ average score";

                        // If attempts requirement met, show score progress
                        if ($totalQuizAttempts >= $minQuizAttemptsRequired) {
                            $current = round($avgScore, 1);
                            $target = 70;
                            $criteriaText = "Achieve 70% average quiz score ({$totalQuizAttempts} quizzes completed)";
                        }
                    }
                } else {
                    // No quizzes taken yet
                    return null;
                }
                break;

            case 'learning':
                $learningProgress = $cadet->getLearningProgressPercentage();
                $completedMaterials = $cadet->getCompletedMaterialsCount();
                $totalMaterials = $cadet->getTotalAvailableMaterialsCount();
                $minMaterialsRequired = 5;

                if ($totalMaterials >= $minMaterialsRequired) {
                    if ($badge->name === 'Master Navigator') {
                        $current = round($learningProgress, 1);
                        $target = 100;
                        $criteriaText = "Complete 100% of learning materials";
                    } elseif ($badge->name === 'Dedicated Scholar') {
                        $current = round($learningProgress, 1);
                        $target = 90;
                        $criteriaText = "Complete 90% of learning materials";
                    } elseif ($badge->name === 'Knowledge Seeker') {
                        $current = round($learningProgress, 1);
                        $target = 75;
                        $criteriaText = "Complete 75% of learning materials";
                    }
                } else {
                    // Show materials count progress
                    $current = $totalMaterials;
                    $target = $minMaterialsRequired;
                    $criteriaText = "Need {$minMaterialsRequired} learning materials available";
                }
                break;

            case 'duty':
                $dutyCount = $cadet->daily_duty_count ?? 0;
                if ($badge->name === 'Duty Commander') {
                    $current = $dutyCount;
                    $target = 20;
                    $criteriaText = 'Complete 20 duty days';
                } elseif ($badge->name === 'Watch Officer') {
                    $current = $dutyCount;
                    $target = 15;
                    $criteriaText = 'Complete 15 duty days';
                } elseif ($badge->name === 'Deckhand') {
                    $current = $dutyCount;
                    $target = 10;
                    $criteriaText = 'Complete 10 duty days';
                } elseif ($badge->name === 'Seaman Recruit') {
                    $current = $dutyCount;
                    $target = 5;
                    $criteriaText = 'Complete 5 duty days';
                }
                break;

            case 'academic':
                if ($badge->name === 'Best Academic') {
                    // Best academic flag - binary, no progress
                    return null;
                } else {
                    $cgpa = $cadet->current_cgpa ?? 0;
                    if ($badge->name === 'Admiral Scholar') {
                        $current = $cgpa;
                        $target = 3.75;
                        $criteriaText = 'Achieve CGPA of 3.75 or higher';
                    } elseif ($badge->name === 'Captain Scholar') {
                        $current = $cgpa;
                        $target = 3.50;
                        $criteriaText = 'Achieve CGPA of 3.50 or higher';
                    } elseif ($badge->name === 'Officer Scholar') {
                        $current = $cgpa;
                        $target = 3.00;
                        $criteriaText = 'Achieve CGPA of 3.00 or higher';
                    }
                }
                break;
        }

        // Calculate percentage
        if ($target > 0) {
            $percentage = min(($current / $target) * 100, 100);
        }

        // Return null if no progress to show
        if ($target === 0 || $percentage === 0) {
            return null;
        }

        return [
            'badge_id' => $badge->id,
            'name' => $badge->name,
            'description' => $badge->description,
            'unlock_criteria' => $badge->unlock_criteria,
            'category' => $badge->category,
            'rarity_level' => $badge->rarity_level,
            'rarity_label' => $badge->rarity_label,
            'rarity_color' => $badge->rarity_color,
            'icon' => $badge->icon,
            'icon_url' => $badge->icon_url,
            'icon_path' => $badge->icon_path ?? null,
            'progress' => [
                'current' => $current,
                'target' => $target,
                'percentage' => round($percentage, 1),
                'criteria_text' => $criteriaText,
            ],
        ];
    }
}
