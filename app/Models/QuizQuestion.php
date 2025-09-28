<?php

// File: app/Models/QuizQuestion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuizQuestion extends Model
{
    protected $fillable = [
        'category_id',
        'question_text',
        'file_url',
        'question_type',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'created_by',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
        'question_type' => 'string'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(LearningMaterialCategory::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function answer(): HasOne
    {
        return $this->hasOne(QuizAnswer::class, 'question_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeMcq($query)
    {
        return $query->where('question_type', 'MCQ');
    }

    public function scopeSubjective($query)
    {
        return $query->where('question_type', 'Subjective');
    }
}