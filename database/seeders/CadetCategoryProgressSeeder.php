<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CadetCategoryProgressSeeder extends Seeder
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

        $progressRecords = [];

        foreach ($cadets as $cadet) {
            foreach ($categories as $category) {
                // Get total materials in category
                $totalMaterials = \App\Models\LearningMaterial::where('learning_material_category_id', $category->id)->count();

                if ($totalMaterials > 0) {
                    // Random progress for each category
                    $completedMaterials = rand(0, $totalMaterials);
                    $progressPercentage = $totalMaterials > 0 ? ($completedMaterials / $totalMaterials) * 100 : 0;

                    $progressRecords[] = [
                        'cadet_id' => $cadet->id,
                        'learning_material_category_id' => $category->id,
                        'completed_materials' => $completedMaterials,
                        'total_materials' => $totalMaterials,
                        'progress_percentage' => round($progressPercentage, 2),
                    ];
                }
            }
        }

        foreach ($progressRecords as $record) {
            \App\Models\CadetCategoryProgress::create($record);
        }
    }
}
