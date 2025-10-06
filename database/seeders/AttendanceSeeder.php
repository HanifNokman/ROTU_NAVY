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
        $cadets = Cadet::all();

        foreach ($trainings as $training) {
            // For each training, randomly assign attendance for cadets involved
            $involvedCadets = $cadets->random(rand(5, 15));

            foreach ($involvedCadets as $cadet) {
                TrainingAttendance::create([
                    'training_id' => $training->id,
                    'cadet_id' => $cadet->id,
                    'present' => (bool)random_int(0, 1),
                ]);
            }
        }
    }
}
