<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CadetLearningMaterialProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cadets = \App\Models\Cadet::all();
        $materials = \App\Models\LearningMaterial::all();

        if ($cadets->isEmpty() || $materials->isEmpty()) {
            return; // Skip if no cadets or materials exist
        }

        $progressRecords = [];

        foreach ($cadets as $cadet) {
            // Each cadet gets progress for random materials
            $assignedMaterials = $materials->random(rand(1, min(10, $materials->count())));

            foreach ($assignedMaterials as $material) {
                $isCompleted = (bool)rand(0, 1);
                $startedAt = now()->subDays(rand(1, 365));
                $completedAt = $isCompleted ? $startedAt->copy()->addMinutes(rand(30, 480)) : null;
                $timeSpent = rand(0, 3600); // 0 to 1 hour in seconds

                $progressRecords[] = [
                    'cadet_id' => $cadet->id,
                    'learning_material_id' => $material->id,
                    'is_completed' => $isCompleted,
                    'started_at' => $startedAt,
                    'completed_at' => $completedAt,
                    'time_spent_seconds' => $timeSpent,
                ];
            }
        }

        foreach ($progressRecords as $record) {
            \App\Models\CadetLearningMaterialProgress::create($record);
        }
    }
}
