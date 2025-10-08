<?php

namespace Database\Seeders;

use App\Models\Cadet;
use App\Models\Instructor;
use App\Models\Training;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainings = [
            // 7 single-day trainings (hourly sessions)
            [
                'title' => 'Basic Drill Training',
                'description' => 'Introduction to basic military drills.',
                'location' => 'Drill Ground',
                'start_datetime' => Carbon::now()->addDays(1)->setTime(8, 0),
                'end_datetime' => Carbon::now()->addDays(1)->setTime(12, 0),
                'involvement' => 'Intake - 11, Intake - 12, Intake - 13',
                'status' => 'Active',
            ],
            [
                'title' => 'Physical Fitness Test',
                'description' => 'Assessment of physical fitness levels.',
                'location' => 'Gymnasium',
                'start_datetime' => Carbon::now()->addDays(3)->setTime(9, 0),
                'end_datetime' => Carbon::now()->addDays(3)->setTime(11, 0),
                'involvement' => 'Intake - 11, Intake - 12',
                'status' => 'Active',
            ],
            [
                'title' => 'Naval Knowledge Seminar',
                'description' => 'Seminar on naval history and operations.',
                'location' => 'Lecture Hall',
                'start_datetime' => Carbon::now()->addDays(5)->setTime(14, 0),
                'end_datetime' => Carbon::now()->addDays(5)->setTime(16, 0),
                'involvement' => 'Intake - 12, Intake - 13',
                'status' => 'Active',
            ],
            [
                'title' => 'First Aid Training',
                'description' => 'Basic first aid and emergency response.',
                'location' => 'Medical Bay',
                'start_datetime' => Carbon::now()->addDays(7)->setTime(10, 0),
                'end_datetime' => Carbon::now()->addDays(7)->setTime(12, 0),
                'involvement' => 'Intake - 11',
                'status' => 'Active',
            ],
            [
                'title' => 'Map Reading and Navigation',
                'description' => 'Training on map reading and navigation skills.',
                'location' => 'Classroom',
                'start_datetime' => Carbon::now()->addDays(9)->setTime(8, 0),
                'end_datetime' => Carbon::now()->addDays(9)->setTime(10, 0),
                'involvement' => 'Intake - 13',
                'status' => 'Active',
            ],
            [
                'title' => 'Weapon Handling Basics',
                'description' => 'Introduction to safe weapon handling.',
                'location' => 'Armory',
                'start_datetime' => Carbon::now()->addDays(11)->setTime(13, 0),
                'end_datetime' => Carbon::now()->addDays(11)->setTime(15, 0),
                'involvement' => 'Intake - 11, Intake - 12, Intake - 13',
                'status' => 'Active',
            ],
            [
                'title' => 'Team Building Exercises',
                'description' => 'Exercises to improve teamwork and communication.',
                'location' => 'Outdoor Field',
                'start_datetime' => Carbon::now()->addDays(13)->setTime(9, 0),
                'end_datetime' => Carbon::now()->addDays(13)->setTime(11, 0),
                'involvement' => 'Intake - 12',
                'status' => 'Active',
            ],

            // 3 multi-day trainings (daily sessions)
            [
                'title' => 'Advanced Combat Training',
                'description' => 'Multi-day combat training sessions.',
                'location' => 'Training Camp',
                'start_datetime' => Carbon::now()->addDays(15)->setTime(8, 0),
                'end_datetime' => Carbon::now()->addDays(17)->setTime(17, 0),
                'involvement' => 'Intake - 12, Intake - 13',
                'status' => 'Active',
            ],
            [
                'title' => 'Survival Skills Camp',
                'description' => 'Training on survival skills in the field.',
                'location' => 'Forest Area',
                'start_datetime' => Carbon::now()->addDays(20)->setTime(7, 0),
                'end_datetime' => Carbon::now()->addDays(22)->setTime(18, 0),
                'involvement' => 'Intake - 11, Intake - 12',
                'status' => 'Active',
            ],
            [
                'title' => 'Leadership Development Program',
                'description' => 'Program to develop leadership skills.',
                'location' => 'Conference Room',
                'start_datetime' => Carbon::now()->addDays(25)->setTime(9, 0),
                'end_datetime' => Carbon::now()->addDays(27)->setTime(16, 0),
                'involvement' => 'Intake - 13',
                'status' => 'Active',
            ],
        ];

        foreach ($trainings as $trainingData) {
            $training = Training::create($trainingData);

            // Update duration and allowance
            $training->updateDurationAndAllowance();
        }
    }
}