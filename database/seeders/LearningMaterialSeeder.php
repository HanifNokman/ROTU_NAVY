<?php

namespace Database\Seeders;

use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;
use App\Models\Instructor;
use Illuminate\Database\Seeder;

class LearningMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = LearningMaterialCategory::all();
        $instructors = Instructor::all();

        $materials = [
            'Drills' => [
                [
                    'title' => 'Basic Marching Drills',
                    'description' => 'Step-by-step guide to basic marching drills.',
                    'file_url' => 'materials/drills/basic_marching.jpg',
                ],
                [
                    'title' => 'Parade Formation Techniques',
                    'description' => 'Techniques for forming parade lines and formations.',
                    'file_url' => 'materials/drills/parade_formation.mp4',
                ],
                [
                    'title' => 'Drill Commands Reference',
                    'description' => 'Complete reference of drill commands and responses.',
                    'file_url' => 'materials/drills/drill_commands.png',
                ],
                [
                    'title' => 'Precision Movement Training',
                    'description' => 'Training manual for precision movements in drills.',
                    'file_url' => 'materials/drills/precision_movement.mp4',
                ],
                [
                    'title' => 'Squad Drill Exercises',
                    'description' => 'Exercises for squad-level drill training.',
                    'file_url' => 'materials/drills/squad_drill.jpg',
                ],
            ],
            'Physical Training' => [
                [
                    'title' => 'Cardiovascular Fitness Guide',
                    'description' => 'Guide to improving cardiovascular fitness.',
                    'file_url' => 'materials/pt/cardio_fitness.mp4',
                ],
                [
                    'title' => 'Strength Training Basics',
                    'description' => 'Basic strength training exercises and routines.',
                    'file_url' => 'materials/pt/strength_training.jpg',
                ],
                [
                    'title' => 'Flexibility and Stretching',
                    'description' => 'Stretching routines for improved flexibility.',
                    'file_url' => 'materials/pt/flexibility.mp4',
                ],
                [
                    'title' => 'Running Techniques',
                    'description' => 'Proper running techniques and training plans.',
                    'file_url' => 'materials/pt/running_techniques.png',
                ],
                [
                    'title' => 'Injury Prevention in PT',
                    'description' => 'Preventing injuries during physical training.',
                    'file_url' => 'materials/pt/injury_prevention.mp4',
                ],
            ],
            'Naval Knowledge' => [
                [
                    'title' => 'History of the Royal Malaysian Navy',
                    'description' => 'Overview of the history and development of RMN.',
                    'file_url' => 'materials/naval/history_rmn.jpg',
                ],
                [
                    'title' => 'Naval Ranks and Structure',
                    'description' => 'Understanding naval ranks and organizational structure.',
                    'file_url' => 'materials/naval/naval_ranks.mp4',
                ],
                [
                    'title' => 'Ship Types and Functions',
                    'description' => 'Different types of ships and their functions.',
                    'file_url' => 'materials/naval/ship_types.png',
                ],
                [
                    'title' => 'Naval Terminology',
                    'description' => 'Common naval terms and their meanings.',
                    'file_url' => 'materials/naval/terminology.mp4',
                ],
                [
                    'title' => 'Maritime Law Basics',
                    'description' => 'Introduction to maritime law and regulations.',
                    'file_url' => 'materials/naval/maritime_law.jpg',
                ],
            ],
        ];

        foreach ($materials as $categoryName => $materialList) {
            $category = $categories->where('name', $categoryName)->first();

            if ($category) {
                foreach ($materialList as $materialData) {
                    $instructor = $instructors->random();

                    LearningMaterial::create([
                        'title' => $materialData['title'],
                        'instructor_id' => $instructor->id,
                        'description' => $materialData['description'],
                        'learning_material_category_id' => $category->id,
                        'file_url' => $materialData['file_url'],
                    ]);
                }
            }
        }
    }
}
