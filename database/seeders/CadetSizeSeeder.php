<?php

namespace Database\Seeders;

use App\Models\Cadet;
use App\Models\CadetSize;
use App\Models\UniformComponent;
use Illuminate\Database\Seeder;

class CadetSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL'];

        $cadets = Cadet::all();
        $components = UniformComponent::all();

        foreach ($cadets as $cadet) {
            // Assign random sizes for each component for the cadet
            foreach ($components as $component) {
                CadetSize::create([
                    'cadet_id' => $cadet->id,
                    'component_id' => $component->id,
                    'size' => $sizes[array_rand($sizes)],
                    'is_issued' => (bool)random_int(0, 1),
                ]);
            }
        }
    }
}
