<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Database\Seeder;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = [
            [
                'user_id' => User::where('email', 'ahmad.abdullah@rotunavy.com')->first()->id,
                'phone_number' => '60123456789',
                'rank' => 'Lt.Dya',
                'position' => 'Senior Instructor',
                'expertise' => 'PKOR',
                'time_in_service' => 15,
                'status' => 'Active',
                'service_number' => 'N/404123',
                'past_unit' => 'Naval Academy',
            ],
            [
                'user_id' => User::where('email', 'siti.aminah@rotunavy.com')->first()->id,
                'phone_number' => '60123456790',
                'rank' => 'BK',
                'position' => 'Training Officer',
                'expertise' => 'JJM',
                'time_in_service' => 10,
                'status' => 'Active',
                'service_number' => '123456',
                'past_unit' => 'Training Division',
            ],
            [
                'user_id' => User::where('email', 'muhammad.razak@rotunavy.com')->first()->id,
                'phone_number' => '60123456791',
                'rank' => 'LK',
                'position' => 'Drill Instructor',
                'expertise' => 'PAP',
                'time_in_service' => 8,
                'status' => 'Active',
                'service_number' => '789012',
                'past_unit' => 'Drill Team',
            ],
        ];

        foreach ($instructors as $instructor) {
            Instructor::create($instructor);
        }
    }
}
