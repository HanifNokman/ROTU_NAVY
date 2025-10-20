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
                'name' => 'Naval Excellence',
                'icon_path' => 'fas fa-star',
                'description' => 'Achieved maximum performance rating of 5 stars',
                'unlock_criteria' => 'Earn 800+ total points across all categories',
                'category' => 'overall',
                'rarity_level' => 5,
            ],
            [
                'name' => 'Command Excellence',
                'icon_path' => 'fas fa-trophy',
                'description' => 'Outstanding performance across all areas',
                'unlock_criteria' => 'Earn 700+ total points',
                'category' => 'overall',
                'rarity_level' => 4,
            ],
            [
                'name' => 'Rising Officer',
                'icon_path' => 'fas fa-rocket',
                'description' => 'Showing great potential with consistent performance',
                'unlock_criteria' => 'Earn 500+ total points',
                'category' => 'overall',
                'rarity_level' => 3,
            ],

            // Attendance Badges
            [
                'name' => 'Parade Perfect',
                'icon_path' => 'fas fa-calendar-check',
                'description' => 'Never missed a training session',
                'unlock_criteria' => '100% attendance rate',
                'category' => 'attendance',
                'rarity_level' => 4,
            ],
            [
                'name' => 'Reliable Sailor',
                'icon_path' => 'fas fa-clock',
                'description' => 'Consistent attendance record',
                'unlock_criteria' => '90%+ attendance rate',
                'category' => 'attendance',
                'rarity_level' => 2,
            ],
            [
                'name' => 'Punctual Cadet',
                'icon_path' => 'fas fa-check-circle',
                'description' => 'Good attendance habits',
                'unlock_criteria' => '75%+ attendance rate',
                'category' => 'attendance',
                'rarity_level' => 1,
            ],

            // Quiz Badges
            [
                'name' => 'Strategic Mind',
                'icon_path' => 'fas fa-brain',
                'description' => 'Mastered all quiz categories at hard difficulty',
                'unlock_criteria' => 'Pass all categories at hard difficulty with 80%+',
                'category' => 'quiz',
                'rarity_level' => 5,
            ],
            [
                'name' => 'Tactical Expert',
                'icon_path' => 'fas fa-book-open',
                'description' => 'Excellent performance across all quiz categories',
                'unlock_criteria' => 'Pass all categories at medium difficulty with 80%+',
                'category' => 'quiz',
                'rarity_level' => 4,
            ],
            [
                'name' => 'Quick Study',
                'icon_path' => 'fas fa-lightbulb',
                'description' => 'Strong quiz performance',
                'unlock_criteria' => 'Average 80%+ across all quiz attempts',
                'category' => 'quiz',
                'rarity_level' => 3,
            ],
            [
                'name' => 'Knowledgeable Cadet',
                'icon_path' => 'fas fa-graduation-cap',
                'description' => 'Consistent quiz performance',
                'unlock_criteria' => 'Average 70%+ across all quiz attempts',
                'category' => 'quiz',
                'rarity_level' => 2,
            ],

            // Learning Progress Badges
            [
                'name' => 'Master Navigator',
                'icon_path' => 'fas fa-crown',
                'description' => 'Completed all learning materials',
                'unlock_criteria' => '100% learning progress',
                'category' => 'learning',
                'rarity_level' => 5,
            ],
            [
                'name' => 'Dedicated Scholar',
                'icon_path' => 'fas fa-user-graduate',
                'description' => 'Excellent learning progress',
                'unlock_criteria' => '90%+ learning progress',
                'category' => 'learning',
                'rarity_level' => 4,
            ],
            [
                'name' => 'Knowledge Seeker',
                'icon_path' => 'fas fa-books',
                'description' => 'Strong learning commitment',
                'unlock_criteria' => '75%+ learning progress',
                'category' => 'learning',
                'rarity_level' => 3,
            ],

            // Duty Badges
            [
                'name' => 'Duty Commander',
                'icon_path' => 'fas fa-shield-alt',
                'description' => 'Exemplary duty performance',
                'unlock_criteria' => 'Complete 50+ duties',
                'category' => 'duty',
                'rarity_level' => 4,
            ],
            [
                'name' => 'Watch Officer',
                'icon_path' => 'fas fa-hand-paper',
                'description' => 'Consistent duty participation',
                'unlock_criteria' => 'Complete 30+ duties',
                'category' => 'duty',
                'rarity_level' => 3,
            ],
            [
                'name' => 'Deckhand',
                'icon_path' => 'fas fa-anchor',
                'description' => 'Active duty participation',
                'unlock_criteria' => 'Complete 20+ duties',
                'category' => 'duty',
                'rarity_level' => 2,
            ],
            [
                'name' => 'Seaman Recruit',
                'icon_path' => 'fas fa-compass',
                'description' => 'Started duty participation',
                'unlock_criteria' => 'Complete 10+ duties',
                'category' => 'duty',
                'rarity_level' => 1,
            ],

            // Academic Badges
            [
                'name' => 'Admiral Scholar',
                'icon_path' => 'fas fa-award',
                'description' => 'Outstanding academic achievement',
                'unlock_criteria' => 'CGPA 3.75+',
                'category' => 'academic',
                'rarity_level' => 5,
            ],
            [
                'name' => 'Captain Scholar',
                'icon_path' => 'fas fa-medal',
                'description' => 'Excellent academic performance',
                'unlock_criteria' => 'CGPA 3.50+',
                'category' => 'academic',
                'rarity_level' => 4,
            ],
            [
                'name' => 'Officer Scholar',
                'icon_path' => 'fas fa-certificate',
                'description' => 'Strong academic record',
                'unlock_criteria' => 'CGPA 3.00+',
                'category' => 'academic',
                'rarity_level' => 3,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
