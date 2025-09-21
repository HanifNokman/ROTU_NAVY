<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContentSetting;

class ContentSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'application_deadline',
                'value' => '2025-03-31',
                'type' => 'date',
                'description' => 'Application deadline date for PALAPES program',
            ],
            [
                'key' => 'application_portal_url',
                'value' => 'https://application.ums.edu.my/palapes',
                'type' => 'url',
                'description' => 'URL for the application portal',
            ],
            [
                'key' => 'qr_code_image',
                'value' => null, // Will be uploaded by instructor
                'type' => 'file',
                'description' => 'QR code image for quick access',
            ],
            [
                'key' => 'hero_title',
                'value' => 'Excellence in Maritime Leadership',
                'type' => 'text',
                'description' => 'Main hero section title',
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'Forge your path as a naval officer through comprehensive training, leadership development, and academic excellence at Universiti Malaysia Sabah',
                'type' => 'text',
                'description' => 'Hero section subtitle',
            ],
            [
                'key' => 'intro_description',
                'value' => 'The Reserve Officer Training Unit (PALAPES) represents Malaysia\'s premier naval leadership development program, combining rigorous academic excellence with comprehensive military training to forge the next generation of maritime leaders.',
                'type' => 'text',
                'description' => 'Introduction section description',
            ],
            [
                'key' => 'about_description',
                'value' => 'With decades of proven success, PALAPES has established itself as the premier institution for developing maritime leaders who serve with distinction in both military and civilian capacities, upholding the highest standards of honor, courage, and commitment.',
                'type' => 'text',
                'description' => 'About section description',
            ],
        ];

        foreach ($settings as $setting) {
            ContentSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'description' => $setting['description'],
                ]
            );
        }

        $this->command->info('Content settings seeded successfully!');
    }
}