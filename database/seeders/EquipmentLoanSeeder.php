<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cadets = \App\Models\Cadet::all();
        $inventoryItems = \App\Models\InventoryItem::all();

        if ($cadets->isEmpty() || $inventoryItems->isEmpty()) {
            return; // Skip if no cadets or inventory items exist
        }

        $statuses = ['Borrowed', 'Returned'];
        $loans = [];

        foreach ($cadets as $cadet) {
            // Each cadet has 1-5 loans
            $numLoans = rand(1, 5);

            for ($i = 0; $i < $numLoans; $i++) {
                $item = $inventoryItems->random();
                $quantity = rand(1, min(5, $item->available_quantity ?: 10));
                $borrowDate = now()->subDays(rand(0, 365));
                $status = $statuses[array_rand($statuses)];
                $returnDate = $status === 'Returned' ? $borrowDate->copy()->addDays(rand(1, 30)) : null;

                $loans[] = [
                    'cadet_id' => $cadet->id,
                    'item_id' => $item->id,
                    'quantity' => $quantity,
                    'borrow_date' => $borrowDate,
                    'return_date' => $returnDate,
                    'status' => $status,
                ];
            }
        }

        foreach ($loans as $loan) {
            \App\Models\EquipmentLoan::create($loan);
        }
    }
}
