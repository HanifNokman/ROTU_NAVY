<?php

namespace Database\Seeders;

use App\Models\UniformType;
use Illuminate\Database\Seeder;

class UniformCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'type_name' => 'One Dress',
                'description' => 'Formal service dress uniform',
            ],
            [
                'type_name' => '3A',
                'description' => 'Combat uniform for field operations',
            ],
            [
                'type_name' => 'PT Uniform',
                'description' => 'Physical training uniform',
            ],
        ];

        foreach ($categories as $category) {
            UniformType::create($category);
        }
    }
}
