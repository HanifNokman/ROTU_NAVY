<?php

namespace App\Services;

use App\Models\Cadet;
use App\Models\PerformanceRating;
use App\Models\TrainingAttendance;
use Illuminate\Support\Facades\DB;

class PerformanceCalculationService
{
    /**
     * Calculate and update performance for a specific cadet
     */
    public function calculateCadetPerformance($cadetId)
    {
        $performanceRating = PerformanceRating::getOrCreateForCadet($cadetId);
        $performanceRating->updateAllPoints();

        return $performanceRating;
    }

    /**
     * Calculate and update performance for all cadets
     */
    public function calculateAllCadetsPerformance()
    {
        $cadets = Cadet::all();

        foreach ($cadets as $cadet) {
            $this->calculateCadetPerformance($cadet->id);
        }
    }

    /**
     * Calculate and update performance for cadets in a specific intake
     */
    public function calculateIntakePerformance($intakeYear)
    {
        $cadets = Cadet::where('intake_year', $intakeYear)->get();

        foreach ($cadets as $cadet) {
            $this->calculateCadetPerformance($cadet->id);
        }
    }

    /**
     * Update attendance points for all cadets after training attendance changes
     */
    public function updateAllAttendancePoints()
    {
        $performanceRatings = PerformanceRating::all();

        foreach ($performanceRatings as $rating) {
            $rating->updateAttendancePoints();
        }
    }

    /**
     * Update duty points for all cadets after duty count changes
     */
    public function updateAllDutyPoints()
    {
        $performanceRatings = PerformanceRating::all();

        foreach ($performanceRatings as $rating) {
            $rating->updateDutyPoints();
        }
    }

    /**
     * Update academic points for all cadets after CGPA changes
     */
    public function updateAllAcademicPoints()
    {
        $performanceRatings = PerformanceRating::all();

        foreach ($performanceRatings as $rating) {
            $rating->updateAcademicPoints();
        }
    }

    /**
     * Get performance statistics for dashboard
     */
    public function getPerformanceStats($intakeYear = null)
    {
        $query = PerformanceRating::with('cadet.user');

        if ($intakeYear) {
            $query->whereHas('cadet', function($q) use ($intakeYear) {
                $q->where('intake_year', $intakeYear);
            });
        }

        $ratings = $query->get();

        $stats = [
            'total_cadets' => $ratings->count(),
            'rating_distribution' => [
                '⭐⭐⭐⭐⭐' => $ratings->where('rating', '⭐⭐⭐⭐⭐')->count(),
                '⭐⭐⭐⭐☆' => $ratings->where('rating', '⭐⭐⭐⭐☆')->count(),
                '⭐⭐⭐☆☆' => $ratings->where('rating', '⭐⭐⭐☆☆')->count(),
                '⭐⭐☆☆☆' => $ratings->where('rating', '⭐⭐☆☆☆')->count(),
                '⭐☆☆☆☆' => $ratings->where('rating', '⭐☆☆☆☆')->count(),
            ],
            'average_total_points' => $ratings->avg('total_points'),
            'top_performers' => $ratings->sortByDesc('total_points')->take(5),
            'needs_improvement' => $ratings->where('rating', '⭐☆☆☆☆')->sortBy('total_points')
        ];

        return $stats;
    }

    /**
     * Automatically update performance when training attendance changes
     */
    public function handleTrainingAttendanceChange($cadetId)
    {
        $this->calculateCadetPerformance($cadetId);
    }

    /**
     * Automatically update performance when duty count changes
     */
    public function handleDutyCountChange($cadetId)
    {
        $performanceRating = PerformanceRating::where('cadet_id', $cadetId)->first();
        if ($performanceRating) {
            $performanceRating->updateDutyPoints();
        }
    }

    /**
     * Automatically update performance when CGPA changes
     */
    public function handleCgpaChange($cadetId)
    {
        $performanceRating = PerformanceRating::where('cadet_id', $cadetId)->first();
        if ($performanceRating) {
            $performanceRating->updateAcademicPoints();
        }
    }
}
