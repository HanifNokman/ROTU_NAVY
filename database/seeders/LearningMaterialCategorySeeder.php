<?php

namespace Database\Seeders;

use App\Models\LearningMaterialCategory;
use Illuminate\Database\Seeder;

class LearningMaterialCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Drills'],
            ['name' => 'Physical Training'],
            ['name' => 'Naval Knowledge'],
        ];

        foreach ($categories as $category) {
            LearningMaterialCategory::create($category);
        }
    }
}
