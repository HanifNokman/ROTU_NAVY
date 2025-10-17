<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CadetLearningMaterialProgress extends Model
{
    use HasFactory;

    protected $table = 'cadet_learning_material_progress';

    protected $fillable = [
        'cadet_id',
        'learning_material_id',
        'is_completed',
        'started_at',
        'completed_at',
        'time_spent_seconds'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'time_spent_seconds' => 'integer'
    ];

    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    public function learningMaterial()
    {
        return $this->belongsTo(LearningMaterial::class);
    }

    /**
     * Mark material as started
     */
    public function markAsStarted()
    {
        if (!$this->started_at) {
            $this->started_at = now();
            $this->save();
        }
    }

    /**
     * Mark material as completed
     */
    public function markAsCompleted()
    {
        if (!$this->is_completed) {
            $this->is_completed = true;
            $this->completed_at = now();
            $this->save();

            // Update category progress
            $this->updateCategoryProgress();
        }
    }

    /**
     * Update time spent
     */
    public function updateTimeSpent($seconds)
    {
        $this->time_spent_seconds = $seconds;
        $this->save();
    }

    /**
     * Update category progress when material is completed
     */
    private function updateCategoryProgress()
    {
        $material = $this->learningMaterial;
        if (!$material || !$material->learning_material_category_id) {
            return;
        }

        $categoryProgress = CadetCategoryProgress::firstOrCreate(
            [
                'cadet_id' => $this->cadet_id,
                'learning_material_category_id' => $material->learning_material_category_id
            ],
            [
                'completed_materials' => 0,
                'total_materials' => 0,
                'progress_percentage' => 0
            ]
        );

        $categoryProgress->updateProgress();
    }
}