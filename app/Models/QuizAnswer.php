<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{
    protected $fillable = [
        'question_id',
        'correct_answer'
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    /**
     * Check if the provided answer matches the correct answer (case-insensitive for subjective)
     */
    public function isCorrect(string $userAnswer): bool
    {
        if ($this->question->question_type === 'MCQ') {
            return strtolower($this->correct_answer) === strtolower($userAnswer);
        } elseif ($this->question->question_type === 'Subjective') {
            return strtolower(trim($this->correct_answer)) === strtolower(trim($userAnswer));
        }

        return false;
    }
}