<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ContentSettingsSeeder::class,
            BadgeSeeder::class,
            InstructorSeeder::class,
            CadetSeeder::class,
            UniformCategorySeeder::class,
            UniformComponentSeeder::class,
            CadetSizeSeeder::class,
            InventoryItemSeeder::class,
            TrainingSeeder::class,
            LearningMaterialCategorySeeder::class,
            LearningMaterialSeeder::class,
            QuizQuestionSeeder::class,
            AttendanceSeeder::class,
            ApplicationSeeder::class,
            CadetCategoryProgressSeeder::class,
            CadetLearningMaterialProgressSeeder::class,
            CadetQuizScoreSeeder::class,
            EquipmentLoanSeeder::class,
            GalleryCategorySeeder::class,
            GallerySeeder::class,
        ]);
    }
}
