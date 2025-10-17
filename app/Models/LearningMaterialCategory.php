<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Learning materials in this category
     */
    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class, 'learning_material_category_id');
    }

    /**
     * Cadet progress for this category
     */
    public function cadetProgress()
    {
        return $this->hasMany(CadetCategoryProgress::class, 'learning_material_category_id');
    }

    /**
     * Quiz questions for this category
     */
    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class, 'category_id');
    }

    /**
     * Get total number of materials in this category
     */
    public function getTotalMaterialsCount()
    {
        return $this->learningMaterials()->count();
    }

    /**
     * Get completed materials count for a specific cadet
     */
    public function getCompletedMaterialsCount($cadetId)
    {
        return CadetLearningMaterialProgress::where('cadet_id', $cadetId)
            ->where('is_completed', true)
            ->whereHas('learningMaterial', function ($query) {
                $query->where('learning_material_category_id', $this->id);
            })
            ->count();
    }

    /**
     * Get progress percentage for a specific cadet
     */
    public function getProgressPercentage($cadetId)
    {
        $total = $this->getTotalMaterialsCount();
        
        if ($total === 0) {
            return 0;
        }

        $completed = $this->getCompletedMaterialsCount($cadetId);
        
        return round(($completed / $total) * 100, 2);
    }
}