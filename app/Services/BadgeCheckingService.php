<?php

namespace App\Services;

use App\Models\Cadet;
use App\Models\Badge;
use App\Models\CadetBadge;
use App\Models\PerformanceRating;
use App\Models\CadetQuizScore;
use App\Models\LearningMaterialCategory;
use App\Helpers\BadgeHelper;

class BadgeCheckingService
{
    /**
     * Check and unlock badges for a cadet
     * This runs on every page load to ensure badges are awarded as soon as criteria are met
     */
    public function checkAndUnlockBadges(Cadet $cadet)
    {
        // Get all active badges
        $allBadges = Badge::active()->get();

        // Get already unlocked badges
        $existingBadges = CadetBadge::where('cadet_id', $cadet->id)
            ->get()
            ->keyBy('badge_id');

        $performanceRating = $cadet->performanceRating;

        foreach ($allBadges as $badge) {
            // Skip if already unlocked
            if (isset($existingBadges[$badge->id])) {
                continue;
            }

            $shouldUnlock = false;

            // Check if badge uses dynamic criteria
            if ($badge->criteria_type === 'dynamic') {
                $shouldUnlock = $badge->evaluateCriteria($cadet);
            } else {
                // Use hardcoded criteria for backward compatibility
                $shouldUnlock = $this->evaluateHardcodedCriteria($badge, $cadet, $performanceRating);
            }

            if ($shouldUnlock) {
                // Use BadgeHelper to award badge - this will trigger the modal automatically
                BadgeHelper::awardBadge($cadet->id, $badge->id);
            }
        }
    }

    /**
     * Evaluate hardcoded criteria (legacy support)
     */
    private function evaluateHardcodedCriteria($badge, $cadet, $performanceRating)
    {
        $shouldUnlock = false;

        switch ($badge->category) {
                case 'overall':
                    // Auto-unlock welcome badge for all cadets
                    if ($badge->name === 'Cadet Induction') {
                        $shouldUnlock = true;
                    }
                    // Swimming qualification badge
                    elseif ($badge->name === 'Aquatic Warrior' && $cadet->swimming_qualification === 'Pass') {
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
                            // Check if all categories passed at hard difficulty with 80%+
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
                            // Check if all categories passed at medium OR hard difficulty with 80%+
                            // (Hard difficulty qualifies for medium badge too)
                            foreach ($categories as $category) {
                                $qualifyingScore = CadetQuizScore::where('cadet_id', $cadet->id)
                                    ->where('learning_material_category_id', $category->id)
                                    ->whereIn('difficulty', ['medium', 'hard'])
                                    ->where('score_percentage', '>=', 80)
                                    ->first();
                                if (!$qualifyingScore) {
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

        return $shouldUnlock;
    }
}
