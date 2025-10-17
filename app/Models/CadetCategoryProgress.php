<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CadetCategoryProgress extends Model
{
    use HasFactory;

    protected $table = 'cadet_category_progress';

    protected $fillable = [
        'cadet_id',
        'learning_material_category_id',
        'completed_materials',
        'total_materials',
        'progress_percentage'
    ];

    protected $casts = [
        'completed_materials' => 'integer',
        'total_materials' => 'integer',
        'progress_percentage' => 'decimal:2'
    ];

    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    public function category()
    {
        return $this->belongsTo(LearningMaterialCategory::class, 'learning_material_category_id');
    }

    /**
     * Update progress based on completed materials
     */
    public function updateProgress()
    {
        // Get total materials in category
        $this->total_materials = LearningMaterial::where(
            'learning_material_category_id',
            $this->learning_material_category_id
        )->count();

        // Get completed materials count
        $this->completed_materials = CadetLearningMaterialProgress::where('cadet_id', $this->cadet_id)
            ->where('is_completed', true)
            ->whereHas('learningMaterial', function ($query) {
                $query->where('learning_material_category_id', $this->learning_material_category_id);
            })
            ->count();

        // Calculate percentage
        if ($this->total_materials > 0) {
            $this->progress_percentage = ($this->completed_materials / $this->total_materials) * 100;
        } else {
            $this->progress_percentage = 0;
        }

        $this->save();

        // Update cadet's performance rating
        $performanceRating = PerformanceRating::getOrCreateForCadet($this->cadet_id);
        $performanceRating->updateLearningProgressPoints();
    }
}