<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CadetQuizScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cadets = \App\Models\Cadet::all();
        $categories = \App\Models\LearningMaterialCategory::all();

        if ($cadets->isEmpty() || $categories->isEmpty()) {
            return; // Skip if no cadets or categories exist
        }

        $difficulties = ['easy', 'medium', 'hard'];
        $quizScores = [];

        foreach ($cadets as $cadet) {
            // Each cadet takes 1-3 quizzes per category
            foreach ($categories as $category) {
                $numQuizzes = rand(1, 3);

                for ($i = 0; $i < $numQuizzes; $i++) {
                    $difficulty = $difficulties[array_rand($difficulties)];
                    $totalQuestions = rand(10, 20);
                    $correctAnswers = rand(0, $totalQuestions);
                    $scorePercentage = round(($correctAnswers / $totalQuestions) * 100, 2);

                    $quizScores[] = [
                        'cadet_id' => $cadet->id,
                        'learning_material_category_id' => $category->id,
                        'score_percentage' => $scorePercentage,
                        'difficulty' => $difficulty,
                        'total_questions' => $totalQuestions,
                        'correct_answers' => $correctAnswers,
                        'completed_at' => now()->subDays(rand(0, 365)),
                    ];
                }
            }
        }

        foreach ($quizScores as $score) {
            \App\Models\CadetQuizScore::create($score);
        }
    }
}
