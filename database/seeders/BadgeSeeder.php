<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            // Overall Performance Badges
            [
                'id' => 1,
                'name' => 'Naval Excellence',
                'icon_path' => 'Naval Excellence.png',
                'description' => 'Achieved maximum performance rating of 5 stars',
                'unlock_criteria' => 'Earn 800+ total points across all categories',
                'category' => 'overall',
                'rarity_level' => 5,
            ],
            [
                'id' => 2,
                'name' => 'Command Excellence',
                'icon_path' => 'Command Excellence.png',
                'description' => 'Outstanding performance across all areas',
                'unlock_criteria' => 'Earn 700+ total points',
                'category' => 'overall',
                'rarity_level' => 4,
            ],
            [
                'id' => 3,
                'name' => 'Rising Officer',
                'icon_path' => 'Rising Officer.png',
                'description' => 'Showing great potential with consistent performance',
                'unlock_criteria' => 'Earn 500+ total points',
                'category' => 'overall',
                'rarity_level' => 3,
            ],

            // Attendance Badges
            [
                'id' => 4,
                'name' => 'Parade Perfect',
                'icon_path' => 'Parade Perfect.png',
                'description' => 'Never missed a training session',
                'unlock_criteria' => '100% attendance rate',
                'category' => 'attendance',
                'rarity_level' => 4,
            ],
            [
                'id' => 5,
                'name' => 'Reliable Sailor',
                'icon_path' => 'Reliable Sailor.png',
                'description' => 'Consistent attendance record',
                'unlock_criteria' => '90%+ attendance rate',
                'category' => 'attendance',
                'rarity_level' => 2,
            ],
            [
                'id' => 6,
                'name' => 'Punctual Cadet',
                'icon_path' => 'Punctual Cadet.png',
                'description' => 'Good attendance habits',
                'unlock_criteria' => '75%+ attendance rate',
                'category' => 'attendance',
                'rarity_level' => 1,
            ],

            // Quiz Badges
            [
                'id' => 7,
                'name' => 'Strategic Mind',
                'icon_path' => 'Strategic Mind.png',
                'description' => 'Mastered all quiz categories at hard difficulty',
                'unlock_criteria' => 'Pass all categories at hard difficulty with 80%+',
                'category' => 'quiz',
                'rarity_level' => 5,
            ],
            [
                'id' => 8,
                'name' => 'Tactical Expert',
                'icon_path' => 'Tactical Expert.png',
                'description' => 'Excellent performance across all quiz categories',
                'unlock_criteria' => 'Pass all categories at medium difficulty with 80%+',
                'category' => 'quiz',
                'rarity_level' => 4,
            ],
            [
                'id' => 9,
                'name' => 'Quick Study',
                'icon_path' => 'Quick Study.png',
                'description' => 'Strong quiz performance',
                'unlock_criteria' => 'Average 80%+ across all quiz attempts',
                'category' => 'quiz',
                'rarity_level' => 3,
            ],
            [
                'id' => 10,
                'name' => 'Knowledgeable Cadet',
                'icon_path' => 'Knowledgeable Cadet.png',
                'description' => 'Consistent quiz performance',
                'unlock_criteria' => 'Average 70%+ across all quiz attempts',
                'category' => 'quiz',
                'rarity_level' => 2,
            ],

            // Learning Progress Badges
            [
                'id' => 11,
                'name' => 'Master Navigator',
                'icon_path' => 'Master Navigator.png',
                'description' => 'Completed all learning materials',
                'unlock_criteria' => '100% learning progress',
                'category' => 'learning',
                'rarity_level' => 5,
            ],
            [
                'id' => 12,
                'name' => 'Dedicated Scholar',
                'icon_path' => 'Dedicated Scholar.png',
                'description' => 'Excellent learning progress',
                'unlock_criteria' => '90%+ learning progress',
                'category' => 'learning',
                'rarity_level' => 4,
            ],
            [
                'id' => 13,
                'name' => 'Knowledge Seeker',
                'icon_path' => 'Knowledge Seeker.png',
                'description' => 'Strong learning commitment',
                'unlock_criteria' => '75%+ learning progress',
                'category' => 'learning',
                'rarity_level' => 3,
            ],

            // Duty Badges
            [
                'id' => 14,
                'name' => 'Duty Commander',
                'icon_path' => 'Duty Commander.png',
                'description' => 'Exemplary duty performance',
                'unlock_criteria' => 'Complete 50+ duties',
                'category' => 'duty',
                'rarity_level' => 4,
            ],
            [
                'id' => 15,
                'name' => 'Watch Officer',
                'icon_path' => 'Watch Officer.png',
                'description' => 'Consistent duty participation',
                'unlock_criteria' => 'Complete 30+ duties',
                'category' => 'duty',
                'rarity_level' => 3,
            ],
            [
                'id' => 16,
                'name' => 'Deckhand',
                'icon_path' => 'Deckhand.png',
                'description' => 'Active duty participation',
                'unlock_criteria' => 'Complete 20+ duties',
                'category' => 'duty',
                'rarity_level' => 2,
            ],
            [
                'id' => 17,
                'name' => 'Seaman Recruit',
                'icon_path' => 'Seaman Recruit.png',
                'description' => 'Started duty participation',
                'unlock_criteria' => 'Complete 10+ duties',
                'category' => 'duty',
                'rarity_level' => 1,
            ],

            // Academic Badges
            [
                'id' => 18,
                'name' => 'Admiral Scholar',
                'icon_path' => 'Admiral Scholar.png',
                'description' => 'Outstanding academic achievement',
                'unlock_criteria' => 'CGPA 3.75+',
                'category' => 'academic',
                'rarity_level' => 5,
            ],
            [
                'id' => 19,
                'name' => 'Captain Scholar',
                'icon_path' => 'Captain Scholar.png',
                'description' => 'Excellent academic performance',
                'unlock_criteria' => 'CGPA 3.50+',
                'category' => 'academic',
                'rarity_level' => 4,
            ],
            [
                'id' => 20,
                'name' => 'Officer Scholar',
                'icon_path' => 'Officer Scholar.png',
                'description' => 'Strong academic record',
                'unlock_criteria' => 'CGPA 3.00+',
                'category' => 'academic',
                'rarity_level' => 3,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(
                ['id' => $badge['id']],
                $badge
            );
        }
    }
}