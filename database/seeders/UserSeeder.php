<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // Instructors
            [
                'name' => 'Ahmad Bin Abdullah',
                'email' => 'ahmad.abdullah@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'instructor',
                'status' => 'accepted',
            ],
            [
                'name' => 'Siti Aminah Binti Ismail',
                'email' => 'siti.aminah@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'instructor',
                'status' => 'accepted',
            ],
            [
                'name' => 'Muhammad Razak',
                'email' => 'muhammad.razak@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'instructor',
                'status' => 'accepted',
            ],

            // Cadets Intake 11
            [
                'name' => 'Nurul Huda',
                'email' => 'nurul.huda11@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Ahmad Faiz',
                'email' => 'ahmad.faiz11@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Siti Sarah',
                'email' => 'siti.sarah11@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Mohd Hafiz',
                'email' => 'mohd.hafiz11@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Aisyah Binti Zainal',
                'email' => 'aisyah.zainal11@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],

            // Cadets Intake 12
            [
                'name' => 'Faridah Binti Omar',
                'email' => 'faridah.omar12@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Zulkifli Bin Hassan',
                'email' => 'zulkifli.hassan12@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Noraini Binti Ahmad',
                'email' => 'noraini.ahmad12@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Ismail Bin Yusof',
                'email' => 'ismail.yusof12@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Hafizah Binti Salleh',
                'email' => 'hafizah.salleh12@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],

            // Cadets Intake 13
            [
                'name' => 'Azman Bin Ali',
                'email' => 'azman.ali13@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Sabrina Binti Mohd',
                'email' => 'sabrina.mohd13@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Faizal Bin Ramli',
                'email' => 'faizal.ramli13@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Nora Binti Iskandar',
                'email' => 'nora.iskandar13@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
            [
                'name' => 'Khairul Bin Zain',
                'email' => 'khairul.zain13@rotunavy.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'cadet',
                'status' => 'accepted',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
