<?php

namespace Database\Seeders;

use App\Models\Cadet;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainings = Training::all();

        foreach ($trainings as $training) {
            // Parse the involvement field to extract intake numbers
            // Example: "Intake - 11, Intake - 12, Intake - 13"
            $involvedIntakes = $this->parseInvolvement($training->involvement);

            if (empty($involvedIntakes)) {
                // If no involvement specified, skip this training
                continue;
            }

            // Convert intake numbers to intake years
            // Intake 11 = 2022 (2011 + 11)
            // Intake 12 = 2023 (2011 + 12)
            // Intake 13 = 2024 (2011 + 13)
            $involvedYears = array_map(function($intakeNum) {
                return 2011 + $intakeNum;
            }, $involvedIntakes);

            // Get ALL cadets from the involved intakes
            $involvedCadets = Cadet::whereIn('intake_year', $involvedYears)->get();

            // Create attendance records for ALL cadets in the involved intakes
            foreach ($involvedCadets as $cadet) {
                TrainingAttendance::create([
                    'training_id' => $training->id,
                    'cadet_id' => $cadet->id,
                    'present' => (bool)random_int(0, 1), // Randomly assign present/absent
                ]);
            }
        }
    }

    /**
     * Parse the involvement string to extract intake numbers
     *
     * @param string|null $involvement
     * @return array
     */
    private function parseInvolvement(?string $involvement): array
    {
        if (empty($involvement)) {
            return [];
        }

        // Match patterns like "Intake - 11", "Intake - 12", etc.
        preg_match_all('/Intake\s*-\s*(\d+)/i', $involvement, $matches);

        if (empty($matches[1])) {
            return [];
        }

        // Convert to integers and return
        return array_map('intval', $matches[1]);
    }
}
