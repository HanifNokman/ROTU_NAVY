<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GalleryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructors = \App\Models\User::where('role', 'instructor')->get();

        if ($instructors->isEmpty()) {
            return; // Skip if no instructors exist
        }

        $categories = [
            [
                'name' => 'Training Sessions',
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'name' => 'Graduation Ceremony',
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'name' => 'Field Exercises',
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'name' => 'Parade Events',
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'name' => 'Community Service',
                'instructor_id' => $instructors->random()->id,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\GalleryCategory::create($category);
        }
    }
}
