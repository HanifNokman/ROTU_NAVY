<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContentSetting;

class TauliahSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add default Tauliah ceremony date settings
        ContentSetting::updateOrCreate(
            ['key' => 'tauliah_month'],
            [
                'value' => '9',
                'type' => 'text',
                'description' => 'Tauliah ceremony month (1-12). Default is September (9).'
            ]
        );

        ContentSetting::updateOrCreate(
            ['key' => 'tauliah_day'],
            [
                'value' => '15',
                'type' => 'text',
                'description' => 'Tauliah ceremony day (1-31). Default is the 15th.'
            ]
        );

        $this->command->info('Tauliah settings seeded successfully!');
    }
}
