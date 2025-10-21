<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\GalleryCategory::all();
        $instructors = \App\Models\User::where('role', 'instructor')->get();

        if ($categories->isEmpty() || $instructors->isEmpty()) {
            return; // Skip if no categories or instructors exist
        }

        $galleries = [
            [
                'title' => 'Basic Training Drill',
                'description' => 'Cadets performing basic military drills during training session.',
                'image_path' => 'gallery/training_drill_1.jpg',
                'gallery_category_id' => $categories->where('name', 'Training Sessions')->first()?->id ?? $categories->first()->id,
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'title' => 'Graduation Parade',
                'description' => 'Proud moment as cadets graduate from the ROTU Navy program.',
                'image_path' => 'gallery/graduation_parade.jpg',
                'gallery_category_id' => $categories->where('name', 'Graduation Ceremony')->first()?->id ?? $categories->first()->id,
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'title' => 'Field Exercise',
                'description' => 'Cadets navigating obstacle course during field training.',
                'image_path' => 'gallery/field_exercise.jpg',
                'gallery_category_id' => $categories->where('name', 'Field Exercises')->first()?->id ?? $categories->first()->id,
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'title' => 'Independence Day Parade',
                'description' => 'Cadets marching in the national independence day parade.',
                'image_path' => 'gallery/parade_independence.jpg',
                'gallery_category_id' => $categories->where('name', 'Parade Events')->first()?->id ?? $categories->first()->id,
                'instructor_id' => $instructors->random()->id,
            ],
            [
                'title' => 'Community Service Project',
                'description' => 'Cadets participating in beach cleanup community service.',
                'image_path' => 'gallery/community_service.jpg',
                'gallery_category_id' => $categories->where('name', 'Community Service')->first()?->id ?? $categories->first()->id,
                'instructor_id' => $instructors->random()->id,
            ],
        ];

        foreach ($galleries as $gallery) {
            \App\Models\Gallery::create($gallery);
        }
    }
}
