<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadet_id',
        'attendance_points',
        'quiz_points',
        'learning_progress_points',
        'duty_points',
        'academic_points',
        'total_points',
        'rating',
        'updated_at'
    ];

    protected $casts = [
        'attendance_points' => 'decimal:2',
        'quiz_points' => 'decimal:2',
        'learning_progress_points' => 'decimal:2',
        'duty_points' => 'decimal:2',
        'academic_points' => 'decimal:2',
        'total_points' => 'decimal:2',
        'updated_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    /**
     * Calculate total points and update rating
     */
    public function calculateAndUpdateTotal()
    {
        $this->total_points = $this->attendance_points +
                             $this->quiz_points +
                             $this->learning_progress_points +
                             $this->duty_points +
                             $this->academic_points;

        $this->rating = $this->calculateRating();
        $this->updated_at = now();

        $this->save();
    }

    /**
     * Calculate rating based on total points
     */
    private function calculateRating()
    {
        $points = $this->total_points;

        if ($points >= 700) {
            return '⭐⭐⭐⭐⭐';
        } elseif ($points >= 500) {
            return '⭐⭐⭐⭐☆';
        } elseif ($points >= 250) {
            return '⭐⭐⭐☆☆';
        } elseif ($points >= 100) {
            return '⭐⭐☆☆☆';
        } else {
            return '⭐☆☆☆☆';
        }
    }

    /**
     * Update attendance points based on training attendance
     * Full points if present, half points if absent with reasoning and supporting file (only if they attended at least one training)
     */
    public function updateAttendancePoints()
    {
        $attendances = $this->cadet->trainingAttendances;
        $totalTrainings = $attendances->count();
        $hasAttendedAny = $attendances->where('present', true)->count() > 0;

        if ($totalTrainings > 0) {
            $effectiveAttendancePoints = 0;

            foreach ($attendances as $attendance) {
                if ($attendance->present) {
                    $effectiveAttendancePoints += 1; // Full points for present
                } elseif ($attendance->absence_reason && $attendance->file_url && $hasAttendedAny) {
                    $effectiveAttendancePoints += 0.5; // Half points for excused absence (only if attended at least one training)
                }
                // No points for unexcused absences or excused absences without any attendance
            }

            $attendancePercentage = ($effectiveAttendancePoints / $totalTrainings) * 100;

            // Full points (480) if perfect effective attendance, scaled down otherwise (60% weight)
            $this->attendance_points = ($attendancePercentage / 100) * 480;
        } else {
            $this->attendance_points = 0;
        }

        $this->calculateAndUpdateTotal();
    }
    
    /**
     * Update quiz points based on quiz performance
     * Points awarded for each difficulty level, but full 40 points only if 
     * ALL categories are passed at hard difficulty with 80%+
     */
    public function updateQuizPoints()
    {
        // Get total number of categories in the system
        $totalCategories = \App\Models\LearningMaterialCategory::count();
        
        if ($totalCategories === 0) {
            $this->quiz_points = 0;
            $this->calculateAndUpdateTotal();
            return;
        }

        // Get all quiz scores for this cadet with passing grade (60%+)
        $quizScores = CadetQuizScore::where('cadet_id', $this->cadet_id)
            ->where('score_percentage', '>=', 60)
            ->get();

        // Group by category and get the best score per category
        $bestScoresByCategory = $quizScores->groupBy('learning_material_category_id')
            ->map(function ($categoryScores) {
                return $categoryScores->sortByDesc(function ($score) {
                    // Sort by difficulty first (hard > medium > easy), then by percentage
                    $difficultyWeight = ['hard' => 3, 'medium' => 2, 'easy' => 1];
                    return ($difficultyWeight[$score->difficulty] ?? 0) * 1000 + $score->score_percentage;
                })->first();
            });

        $totalQuizPoints = 0;

        foreach ($bestScoresByCategory as $bestScore) {
            // Calculate points based on difficulty and score
            $basePoints = $this->calculateDifficultyPoints($bestScore->difficulty);
            
            // Bonus multiplier for excellence (80%+ gets full points, 60-79% gets proportional)
            if ($bestScore->score_percentage >= 80) {
                $multiplier = 1.0;
            } else {
                // Scale between 0.5 and 1.0 for scores 60-79%
                $multiplier = 0.5 + (($bestScore->score_percentage - 60) / 20) * 0.5;
            }
            
            $totalQuizPoints += $basePoints * $multiplier;
        }

        // Calculate the maximum possible points if all categories were completed at hard with 80%+
        $maxPossiblePoints = $totalCategories * 24; // 24 points per category at hard difficulty
        
        // Scale to 40 points max
        $this->quiz_points = min(($totalQuizPoints / $maxPossiblePoints) * 40, 40);
        
        $this->calculateAndUpdateTotal();
    }

    /**
     * Calculate base points for difficulty level per category
     */
    private function calculateDifficultyPoints($difficulty)
    {
        switch ($difficulty) {
            case 'easy':
                return 8;   // Easy difficulty
            case 'medium':
                return 16;  // Medium difficulty
            case 'hard':
                return 24;  // Hard difficulty (full points per category)
            default:
                return 0;
        }
    }
    
    /**
     * Update learning progress points based on completed materials
     * Maximum 40 points (5% weight)
     */
    public function updateLearningProgressPoints()
    {
        $totalCategories = \App\Models\LearningMaterialCategory::count();
        
        if ($totalCategories === 0) {
            $this->learning_progress_points = 0;
            $this->calculateAndUpdateTotal();
            return;
        }

        // Get all category progress for this cadet
        $categoryProgresses = CadetCategoryProgress::where('cadet_id', $this->cadet_id)->get();
        
        // Calculate average progress across all categories
        $totalProgress = $categoryProgresses->sum('progress_percentage');
        $averageProgress = $totalProgress / $totalCategories;
        
        // Scale to 40 points max (5% of 800)
        $this->learning_progress_points = ($averageProgress / 100) * 40;
        
        $this->calculateAndUpdateTotal();
    }

    /**
     * Update duty points based on duty count
     */
    public function updateDutyPoints()
    {
        $dutyCount = $this->cadet->daily_duty_count ?? 0;
        $this->duty_points = min($dutyCount * 5, 160); // +5 per duty, max 20% of 800 (160 points)
        $this->calculateAndUpdateTotal();
    }

    /**
     * Update academic points based on CGPA
     */
    public function updateAcademicPoints()
    {
        $cgpa = $this->cadet->current_cgpa ?? 0;

        if ($cgpa >= 3.50) {
            $this->academic_points = 80; // 10% weight for excellent CGPA
        } elseif ($cgpa >= 3.00) {
            $this->academic_points = 60; // Good CGPA
        } elseif ($cgpa >= 2.50) {
            $this->academic_points = 40; // Satisfactory CGPA
        } elseif ($cgpa >= 2.00) {
            $this->academic_points = 20; // Minimum passing CGPA
        } else {
            $this->academic_points = 0; // Below minimum
        }

        $this->calculateAndUpdateTotal();
    }

    /**
     * Update all points and recalculate total
     */
    public function updateAllPoints()
    {
        $this->updateAttendancePoints();
        $this->updateQuizPoints();
        $this->updateLearningProgressPoints();
        $this->updateDutyPoints();
        $this->updateAcademicPoints();
    }

    /**
     * Get or create performance rating for a cadet
     */
    public static function getOrCreateForCadet($cadetId)
    {
        return static::firstOrCreate(
            ['cadet_id' => $cadetId],
            [
                'attendance_points' => 0,
                'quiz_points' => 0,
                'learning_progress_points' => 0,
                'duty_points' => 0,
                'academic_points' => 0,
                'total_points' => 0,
                'rating' => '⭐☆☆☆☆',
                'updated_at' => now()
            ]
        );
    }
}
