<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use App\Models\LearningMaterialCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = LearningMaterialCategory::all();
        $users = User::all();

        $questions = [
            'Drills' => [
                // 3 MCQ
                [
                    'question_text' => 'What is the command to start marching?',
                    'question_type' => 'MCQ',
                    'option_a' => 'Forward March',
                    'option_b' => 'Halt',
                    'option_c' => 'About Turn',
                    'option_d' => 'Left Turn',
                    'correct_answer' => 'A',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'Which foot do you start marching with?',
                    'question_type' => 'MCQ',
                    'option_a' => 'Left',
                    'option_b' => 'Right',
                    'option_c' => 'Both',
                    'option_d' => 'None',
                    'correct_answer' => 'A',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'What is the length of a standard marching step?',
                    'question_type' => 'MCQ',
                    'option_a' => '24 inches',
                    'option_b' => '30 inches',
                    'option_c' => '18 inches',
                    'option_d' => '36 inches',
                    'correct_answer' => 'A',
                    'status' => 'active',
                ],
                // 2 Subjective
                [
                    'question_text' => 'What is the command for halt?',
                    'question_type' => 'Subjective',
                    'correct_answer' => 'Halt',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'What is the standard marching step length?',
                    'question_type' => 'Subjective',
                    'correct_answer' => '24 inches',
                    'status' => 'active',
                ],
            ],
            'Physical Training' => [
                // 3 MCQ
                [
                    'question_text' => 'What is the recommended duration for a warm-up session?',
                    'question_type' => 'MCQ',
                    'option_a' => '5 minutes',
                    'option_b' => '10 minutes',
                    'option_c' => '15 minutes',
                    'option_d' => '20 minutes',
                    'correct_answer' => 'B',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'Which exercise is best for cardiovascular fitness?',
                    'question_type' => 'MCQ',
                    'option_a' => 'Push-ups',
                    'option_b' => 'Running',
                    'option_c' => 'Sit-ups',
                    'option_d' => 'Squats',
                    'correct_answer' => 'B',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'What is the primary benefit of stretching?',
                    'question_type' => 'MCQ',
                    'option_a' => 'Increase strength',
                    'option_b' => 'Improve flexibility',
                    'option_c' => 'Build endurance',
                    'option_d' => 'Burn calories',
                    'correct_answer' => 'B',
                    'status' => 'active',
                ],
                // 2 Subjective
                [
                    'question_text' => 'What is the recommended warm-up duration?',
                    'question_type' => 'Subjective',
                    'correct_answer' => '10 minutes',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'What exercise is best for cardio?',
                    'question_type' => 'Subjective',
                    'correct_answer' => 'Running',
                    'status' => 'active',
                ],
            ],
            'Naval Knowledge' => [
                // 3 MCQ
                [
                    'question_text' => 'What does RMN stand for?',
                    'question_type' => 'MCQ',
                    'option_a' => 'Royal Malaysian Navy',
                    'option_b' => 'Royal Marine Navy',
                    'option_c' => 'Royal Maritime Navy',
                    'option_d' => 'Royal Military Navy',
                    'correct_answer' => 'A',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'Which rank is higher: Lieutenant or Sub-Lieutenant?',
                    'question_type' => 'MCQ',
                    'option_a' => 'Lieutenant',
                    'option_b' => 'Sub-Lieutenant',
                    'option_c' => 'Both are equal',
                    'option_d' => 'None of the above',
                    'correct_answer' => 'A',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'What is the primary function of a frigate?',
                    'question_type' => 'MCQ',
                    'option_a' => 'Anti-submarine warfare',
                    'option_b' => 'Aircraft carrier',
                    'option_c' => 'Patrol',
                    'option_d' => 'Transport',
                    'correct_answer' => 'A',
                    'status' => 'active',
                ],
                // 2 Subjective
                [
                    'question_text' => 'What does RMN stand for?',
                    'question_type' => 'Subjective',
                    'correct_answer' => 'Royal Malaysian Navy',
                    'status' => 'active',
                ],
                [
                    'question_text' => 'What is the higher rank: Lieutenant or Sub-Lieutenant?',
                    'question_type' => 'Subjective',
                    'correct_answer' => 'Lieutenant',
                    'status' => 'active',
                ],
            ],
        ];

        foreach ($questions as $categoryName => $questionList) {
            $category = $categories->where('name', $categoryName)->first();

            if ($category) {
                foreach ($questionList as $questionData) {
                    $creator = $users->random();

                    QuizQuestion::create([
                        'category_id' => $category->id,
                        'question_text' => $questionData['question_text'],
                        'file_url' => $questionData['file_url'] ?? null,
                        'question_type' => $questionData['question_type'],
                        'option_a' => $questionData['option_a'] ?? null,
                        'option_b' => $questionData['option_b'] ?? null,
                        'option_c' => $questionData['option_c'] ?? null,
                        'option_d' => $questionData['option_d'] ?? null,
                        'correct_answer' => $questionData['correct_answer'] ?? null,
                        'created_by' => 1,
                        'status' => $questionData['status'],
                    ]);
                }
            }
        }
    }
}
