<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone_number' => '0123456789',
                'gender' => 'Male',
                'ic_number' => '900101010101',
                'matric_no' => 'A123456',
                'faculty' => 'FKJ',
                'course' => 'Computer Science',
                'height' => 175.5,
                'weight' => 70.0,
                'bmi' => 22.8,
                'profile_pic' => 'profiles/john_doe.jpg',
                'attendance' => 'passed',
                'drill_test' => 'passed',
                'physical_test' => 'passed',
                'medical_test' => 'passed',
                'interview' => 'passed',
                'final_evaluation' => 'passed',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'phone_number' => '0198765432',
                'gender' => 'Female',
                'ic_number' => '910202020202',
                'matric_no' => 'B234567',
                'faculty' => 'FST',
                'course' => 'Biology',
                'height' => 165.0,
                'weight' => 55.0,
                'bmi' => 20.2,
                'profile_pic' => 'profiles/jane_smith.jpg',
                'attendance' => 'passed',
                'drill_test' => 'passed',
                'physical_test' => 'passed',
                'medical_test' => 'passed',
                'interview' => 'passed',
                'final_evaluation' => 'passed',
            ],
            [
                'name' => 'Ahmad bin Abdullah',
                'email' => 'ahmad.abdullah@example.com',
                'phone_number' => '0135792468',
                'gender' => 'Male',
                'ic_number' => '920303030303',
                'matric_no' => 'C345678',
                'faculty' => 'FSSK',
                'course' => 'History',
                'height' => 170.0,
                'weight' => 65.0,
                'bmi' => 22.5,
                'profile_pic' => 'profiles/ahmad_abdullah.jpg',
                'attendance' => 'passed',
                'drill_test' => 'passed',
                'physical_test' => 'passed',
                'medical_test' => 'passed',
                'interview' => 'passed',
                'final_evaluation' => 'passed',
            ],
        ];

        foreach ($applications as $application) {
            Application::create($application);
        }
    }
}
