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
     * Update attendance points based on training attendance percentage
     * Full points if they attended all their trainings, regardless of intake
     */
    public function updateAttendancePoints()
    {
        $totalTrainings = $this->cadet->trainingAttendances()->count();
        $attendedCount = $this->cadet->presentAttendances()->count();

        if ($totalTrainings > 0) {
            $attendancePercentage = ($attendedCount / $totalTrainings) * 100;

            // Full points (480) if perfect attendance, scaled down otherwise (60% weight)
            $this->attendance_points = ($attendancePercentage / 100) * 480;
        } else {
            $this->attendance_points = 0;
        }

        $this->calculateAndUpdateTotal();
    }

    /**
     * Update quiz points based on quiz performance
     */
   public function updateQuizPoints()
    {
        // Get the best score for each difficulty level across all categories
        $easyScore = CadetQuizScore::getBestScore($this->cadet_id, null, 'easy');
        $mediumScore = CadetQuizScore::getBestScore($this->cadet_id, null, 'medium');
        $hardScore = CadetQuizScore::getBestScore($this->cadet_id, null, 'hard');

        $totalQuizPoints = 0;

        // Award points based on best scores and difficulty level (5% weight total)
        // Easy: 8 points, Medium: 16 points, Hard: 24 points (only if score >= 60%)
        if ($easyScore && $easyScore->score_percentage >= 60) {
            $totalQuizPoints += 8;
        }
        if ($mediumScore && $mediumScore->score_percentage >= 60) {
            $totalQuizPoints += 16;
        }
        if ($hardScore && $hardScore->score_percentage >= 60) {
            $totalQuizPoints += 24;
        }

        $this->quiz_points = $totalQuizPoints;
        $this->calculateAndUpdateTotal();
    }
    
    /**
     * Update learning progress points based on completed materials
     */
    public function updateLearningProgressPoints()
    {
        // This would need to be implemented based on learning material completion
        // For now, placeholder with 5% weight (40 points max)
        $this->learning_progress_points = 0; // To be implemented
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
