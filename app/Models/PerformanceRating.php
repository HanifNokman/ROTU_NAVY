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

        if ($points >= 800) {
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

            // Full points (100) if perfect attendance, scaled down otherwise
            $this->attendance_points = ($attendancePercentage / 100) * 100;
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
        // This would need to be implemented based on quiz results
        // For now, placeholder - assuming quiz results are stored elsewhere
        $this->quiz_points = 0; // To be implemented
        $this->calculateAndUpdateTotal();
    }

    /**
     * Update learning progress points based on completed materials
     */
    public function updateLearningProgressPoints()
    {
        // This would need to be implemented based on learning material completion
        // For now, placeholder
        $this->learning_progress_points = 0; // To be implemented
        $this->calculateAndUpdateTotal();
    }

    /**
     * Update duty points based on duty count
     */
    public function updateDutyPoints()
    {
        $dutyCount = $this->cadet->daily_duty_count ?? 0;
        $this->duty_points = $dutyCount * 5; // +5 per duty
        $this->calculateAndUpdateTotal();
    }

    /**
     * Update academic points based on CGPA
     */
    public function updateAcademicPoints()
    {
        $cgpa = $this->cadet->current_cgpa ?? 0;
        $this->academic_points = ($cgpa >= 3.50) ? 10 : 0; // +10 for CGPA >= 3.50
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
