<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CadetQuizScore extends Model
{
    protected $fillable = [
        'cadet_id',
        'learning_material_category_id',
        'score_percentage',
        'difficulty',
        'total_questions',
        'correct_answers',
        'completed_at'
    ];

    protected $casts = [
        'score_percentage' => 'decimal:2',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'completed_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    public function cadet(): BelongsTo
    {
        return $this->belongsTo(Cadet::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LearningMaterialCategory::class, 'learning_material_category_id');
    }

    /**
     * Scopes
     */
    public function scopeByCategory($query, $categoryId)
    {
        if ($categoryId === null) {
            return $query->whereNull('learning_material_category_id');
        }
        return $query->where('learning_material_category_id', $categoryId);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    public function scopePassed($query, $passingScore = 60)
    {
        return $query->where('score_percentage', '>=', $passingScore);
    }

    /**
     * Get the best score for a cadet in a specific category and difficulty
     */
    public static function getBestScore($cadetId, $categoryId, $difficulty)
    {
        return static::where('cadet_id', $cadetId)
            ->byCategory($categoryId)
            ->byDifficulty($difficulty)
            ->orderBy('score_percentage', 'desc')
            ->first();
    }

    /**
     * Get average score for a cadet across all quizzes
     */
    public static function getAverageScore($cadetId)
    {
        return static::where('cadet_id', $cadetId)
            ->avg('score_percentage') ?? 0;
    }
}
