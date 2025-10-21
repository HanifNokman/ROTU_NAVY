<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InventoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // Equipment items
            [
                'name' => 'Combat Boots',
                'category' => 'equipment',
                'description' => 'Military combat boots for field operations',
                'total_quantity' => 100,
                'available_quantity' => 85,
                'size' => null,
                'condition' => 'good',
            ],
            [
                'name' => 'Field Backpack',
                'category' => 'equipment',
                'description' => 'Standard issue field backpack',
                'total_quantity' => 50,
                'available_quantity' => 42,
                'size' => null,
                'condition' => 'excellent',
            ],
            [
                'name' => 'Tactical Vest',
                'category' => 'equipment',
                'description' => 'Tactical load-bearing vest',
                'total_quantity' => 30,
                'available_quantity' => 25,
                'size' => null,
                'condition' => 'good',
            ],
            // Uniform items
            [
                'name' => 'White Service Shirt',
                'category' => 'uniform',
                'description' => 'Formal white service shirt',
                'total_quantity' => 200,
                'available_quantity' => 180,
                'size' => 'M',
                'condition' => 'excellent',
            ],
            [
                'name' => 'Navy Blue Trousers',
                'category' => 'uniform',
                'description' => 'Standard navy blue service trousers',
                'total_quantity' => 200,
                'available_quantity' => 175,
                'size' => 'L',
                'condition' => 'good',
            ],
            [
                'name' => 'PT Shorts',
                'category' => 'uniform',
                'description' => 'Physical training shorts',
                'total_quantity' => 150,
                'available_quantity' => 140,
                'size' => 'M',
                'condition' => 'excellent',
            ],
        ];

        foreach ($items as $item) {
            \App\Models\InventoryItem::create($item);
        }
    }
}
