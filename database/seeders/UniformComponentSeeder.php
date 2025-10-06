<?php

namespace Database\Seeders;

use App\Models\UniformComponent;
use App\Models\UniformType;
use Illuminate\Database\Seeder;

class UniformComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $components = [
            'One Dress' => [
                'Jacket',
                'Trousers',
                'Shirt',
                'Peak Cap',
            ],
            '3A' => [
                'Camouflage Shirt',
                'Camouflage Pants',
                'Boots',
            ],
            'PT Uniform' => [
                'T-shirt',
                'Shorts',
                'Running Shoes',
            ],
        ];

        foreach ($components as $categoryName => $componentNames) {
            $uniformType = UniformType::where('type_name', $categoryName)->first();

            if ($uniformType) {
                foreach ($componentNames as $componentName) {
                    UniformComponent::create([
                        'uniform_type_id' => $uniformType->id,
                        'component_name' => $componentName,
                    ]);
                }
            }
        }
    }
}
