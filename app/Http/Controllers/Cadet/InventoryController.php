<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\CadetSize;
use App\Models\EquipmentLoan;
use App\Models\InventoryItem;
use App\Models\UniformComponent;
use App\Models\UniformType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return redirect()->back()->with('error', 'Cadet profile not found.');
        }

        $selectedUniformType = $request->get('uniform_type');

        // Get all uniform types
        $uniformTypes = UniformType::orderBy('type_name')->get();

        // Get uniform components related to selected uniform type
        $uniformComponents = collect();
        if ($selectedUniformType) {
            $uniformComponents = UniformComponent::where('uniform_type_id', $selectedUniformType)
                ->orderBy('component_name')
                ->get();
        }

        // Get cadet's uniform sizes for components of selected uniform type
        $uniformSizes = collect();
        if ($selectedUniformType) {
            $uniformSizes = CadetSize::with('uniformComponent')
                ->where('cadet_id', $cadet->id)
                ->whereIn('component_id', $uniformComponents->pluck('id'))
                ->get()
                ->keyBy('component_id');
        }

        // Get past equipment loans
        $pastLoans = $cadet->pastLoans()->with('inventoryItem')->paginate(10, ['*'], 'past_page');

        // Get active equipment loans
        $activeLoans = $cadet->activeLoans()->with('inventoryItem')->get();

        // Get available items for borrowing - BOTH Equipment and Uniform
        $availableItems = InventoryItem::whereIn('category', ['equipment', 'uniform'])
            ->where('available_quantity', '>', 0)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        // Debug log
        \Log::info('Index method - Available items: ', [
            'total_inventory_items' => InventoryItem::count(),
            'equipment_items' => InventoryItem::where('category', 'equipment')->count(),
            'uniform_items' => InventoryItem::where('category', 'uniform')->count(),
            'available_borrowable_items' => $availableItems->count(),
            'available_items_by_category' => $availableItems->groupBy('category')->map->count(),
            'all_categories' => InventoryItem::distinct('category')->pluck('category')->toArray()
        ]);

        return view('cadet.inventory', compact(
            'cadet',
            'uniformSizes',
            'uniformComponents',
            'pastLoans',
            'activeLoans',
            'availableItems',
            'uniformTypes',
            'selectedUniformType'
        ));
    }

    public function getComponentsByType($uniformTypeId)
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return response()->json(['error' => 'Cadet profile not found.'], 404);
        }

        // Get uniform components for the selected type
        $uniformComponents = UniformComponent::where('uniform_type_id', $uniformTypeId)
            ->orderBy('component_name')
            ->get();

        // Get cadet's existing sizes for these components
        $uniformSizes = CadetSize::where('cadet_id', $cadet->id)
            ->whereIn('component_id', $uniformComponents->pluck('id'))
            ->get()
            ->keyBy('component_id');

        // Prepare the response data
        $components = $uniformComponents->map(function ($component) use ($uniformSizes) {
            $sizeEntry = $uniformSizes->get($component->id);
            return [
                'id' => $component->id,
                'name' => $component->component_name,
                'size' => $sizeEntry ? $sizeEntry->size : '',
                'is_issued' => $sizeEntry ? $sizeEntry->is_issued : false,
                'can_delete' => $sizeEntry && !$sizeEntry->is_issued,
                'size_entry_id' => $sizeEntry ? $sizeEntry->id : null
            ];
        });

        return response()->json([
            'components' => $components
        ]);
    }

    public function updateUniformSize(Request $request)
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return redirect()->back()->with('error', 'Cadet profile not found.');
        }

        // Validate all the components and sizes at once
        $request->validate([
            'component_id' => 'required|array',
            'component_id.*' => 'required|exists:uniform_components,id',
            'size' => 'required|array',
            'size.*' => [
                'required',
                'string',
                'max:10'
            ]
        ]);

        $componentIds = $request->input('component_id');
        $sizes = $request->input('size');
        $updatedCount = 0;

        // Process each component-size pair
        foreach ($componentIds as $index => $componentId) {
            $size = $sizes[$index] ?? null;
            
            if (!$size || trim($size) === '') {
                continue; // Skip if no size provided
            }

            // Validate size format based on component
            $component = UniformComponent::find($componentId);
            if (!$component) {
                continue;
            }

            $name = strtolower($component->component_name);
            $isValidSize = $this->validateSizeFormat($name, $size);

            if (!$isValidSize) {
                return redirect()->back()->with('error', "Invalid size format for {$component->component_name}. Please check the format requirements.");
            }

            // Check if this component already has an issued uniform
            $existingSize = CadetSize::where('cadet_id', $cadet->id)
                ->where('component_id', $componentId)
                ->first();

            if ($existingSize && $existingSize->is_issued) {
                continue; // Skip updating issued uniforms
            }

            // Update or create the size entry
            CadetSize::updateOrCreate(
                [
                    'cadet_id' => $cadet->id,
                    'component_id' => $componentId
                ],
                [
                    'size' => trim($size),
                    'is_issued' => false // Reset issued status when size changes
                ]
            );

            $updatedCount++;
        }

        if ($updatedCount > 0) {
            return redirect()->back()->with('success', "Successfully updated {$updatedCount} uniform size(s).");
        } else {
            return redirect()->back()->with('info', 'No uniform sizes were updated.');
        }
    }

    private function validateSizeFormat($componentName, $size)
    {
        $size = strtoupper(trim($size)); // Normalize to uppercase

        if (strpos($componentName, 'hat') !== false || strpos($componentName, 'cap') !== false) {
            // Hat sizes: e.g. 6 3/4, 7 1/2, 7
            return preg_match('/^\d{1,2}( \d\/\d)?$/', $size);
        } elseif (strpos($componentName, 'boot') !== false || strpos($componentName, 'shoe') !== false) {
            // Boot/shoe sizes: 6, 7.5, 10, etc.
            return preg_match('/^\d{1,2}(\.\d)?$/', $size);
        } elseif (strpos($componentName, 'shirt') !== false || strpos($componentName, 'jacket') !== false || 
                strpos($componentName, 'uniform') !== false || strpos($componentName, 'blouse') !== false) {
            // Only allow XS, S, M, L, XL, XXL, XXXL (uppercase only)
            return preg_match('/^X{0,3}(S|M|L)$/', $size);
        } elseif (strpos($componentName, 'trouser') !== false || strpos($componentName, 'pant') !== false) {
            return preg_match('/^\d{1,2}$/', $size);
        } else {
            // General fallback rule
            return preg_match('/^(X{0,3}(S|M|L)|\d{1,2}|\d{1,3}(\.\d)?|\d{1,2} \d\/\d)$/', $size);
        }
    }

    public function createLoan(Request $request)
    {
        \Log::info('=== LOAN CREATION DEBUG START ===');
        \Log::info('Request Data: ', $request->all());

        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return redirect()->back()->with('error', 'Cadet profile not found.');
        }

        // Check if we're handling multiple items or a single item
        if ($request->has('item_ids')) {
            // Handle multiple items
            return $this->createMultipleLoans($request, $cadet);
        } else {
            // Handle single item (existing functionality)
            return $this->createSingleLoan($request, $cadet);
        }
    }

    private function createSingleLoan(Request $request, $cadet)
    {
        // Debug the specific item being requested
        $requestedItem = InventoryItem::find($request->item_id);
        \Log::info('Requested Item Details: ', [
            'item' => $requestedItem?->toArray(),
            'item_exists' => $requestedItem ? 'Yes' : 'No',
            'item_category' => $requestedItem?->category ?? 'N/A'
        ]);

        $request->validate([
            'item_id' => [
                'required',
                'exists:inventory_items,id',
                function ($attribute, $value, $fail) {
                    $item = InventoryItem::find($value);
                    \Log::info('Validation check for item: ', [
                        'item_id' => $value,
                        'item_found' => $item ? 'Yes' : 'No',
                        'item_category' => $item?->category ?? 'N/A',
                        'is_borrowable' => $item && in_array($item->category, ['equipment', 'uniform']) ? 'Yes' : 'No'
                    ]);
                    
                    // Updated validation - allow both Equipment and Uniform
                    if ($item && !in_array($item->category, ['equipment', 'uniform'])) {
                        $fail("Only equipment and uniform items can be borrowed. This item is categorized as: {$item->category}");
                    }
                }
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $item = InventoryItem::find($request->item_id);
                    if ($item && $value > $item->available_quantity) {
                        $fail("Only {$item->available_quantity} items are available.");
                    }
                }
            ],
            'borrow_date' => 'required|date|before_or_equal:today'
        ]);

        $item = InventoryItem::find($request->item_id);
        
        if (!$item) {
            \Log::error('Item not found: ' . $request->item_id);
            return redirect()->back()->with('error', 'Item not found.');
        }

        \Log::info('Item found: ', [
            'item_id' => $item->id,
            'item_name' => $item->name,
            'available_quantity' => $item->available_quantity,
            'category' => $item->category
        ]);

        // Check if cadet already has an active loan for this item
        $existingLoan = EquipmentLoan::where('cadet_id', $cadet->id)
            ->where('item_id', $request->item_id)
            ->where('status', 'Borrowed')
            ->first();

        if ($existingLoan) {
            \Log::warning('Existing active loan found: ', ['existing_loan_id' => $existingLoan->id]);
            return redirect()->back()->with('error', 'You already have an active loan for this item.');
        }

        \Log::info('No existing active loan found');

        try {
            // Start database transaction
            \DB::beginTransaction();
            \Log::info('Database transaction started');

            // Prepare loan data
            $loanData = [
                'cadet_id' => $cadet->id,
                'item_id' => (int)$request->item_id,
                'quantity' => (int)$request->quantity,
                'borrow_date' => $request->borrow_date,
                'status' => 'Borrowed'
            ];

            \Log::info('Loan data prepared: ', $loanData);

            // Create the loan
            $loan = EquipmentLoan::create($loanData);
            
            \Log::info('Loan created successfully: ', [
                'loan_id' => $loan->id,
                'loan_data' => $loan->toArray()
            ]);

            // Update available quantity
            $oldQuantity = $item->available_quantity;
            $item->decrement('available_quantity', $request->quantity);
            $item->refresh();
            
            \Log::info('Inventory updated: ', [
                'old_quantity' => $oldQuantity,
                'new_quantity' => $item->available_quantity,
                'decremented_by' => $request->quantity
            ]);

            // Commit transaction
            \DB::commit();
            \Log::info('Database transaction committed successfully');

            // Verify the loan was actually saved
            $savedLoan = EquipmentLoan::find($loan->id);
            if ($savedLoan) {
                \Log::info('Loan verification successful: ', $savedLoan->toArray());
            } else {
                \Log::error('Loan verification failed - loan not found in database');
            }

            \Log::info('=== LOAN CREATION DEBUG END - SUCCESS ===');
            return redirect()->back()->with('success', 'Item borrowed successfully.');

        } catch (\Exception $e) {
            \DB::rollback();
            
            \Log::error('=== LOAN CREATION DEBUG END - ERROR ===');
            \Log::error('Exception occurred: ', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to create loan: ' . $e->getMessage());
        }
    }

    private function createMultipleLoans(Request $request, $cadet)
    {
        \Log::info('Creating multiple loans', ['item_ids' => $request->item_ids, 'quantities' => $request->quantities]);

        // Validate the request
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:inventory_items,id',
            'quantities' => 'required|array',
            'borrow_date' => 'required|date|before_or_equal:today'
        ]);

        // Validate each item and quantity
        foreach ($request->item_ids as $itemId) {
            $item = InventoryItem::find($itemId);
            $quantity = (int)($request->quantities[$itemId] ?? 0);

            if (!$item) {
                return redirect()->back()->with('error', "Item with ID {$itemId} not found.");
            }

            if (!in_array($item->category, ['equipment', 'uniform'])) {
                return redirect()->back()->with('error', "Only equipment and uniform items can be borrowed. {$item->name} is categorized as: {$item->category}");
            }

            if ($quantity < 1) {
                return redirect()->back()->with('error', "Quantity for {$item->name} must be at least 1.");
            }

            if ($quantity > $item->available_quantity) {
                return redirect()->back()->with('error', "Only {$item->available_quantity} {$item->name} items are available.");
            }

            // Check if cadet already has an active loan for this item
            $existingLoan = EquipmentLoan::where('cadet_id', $cadet->id)
                ->where('item_id', $itemId)
                ->where('status', 'Borrowed')
                ->first();

            if ($existingLoan) {
                return redirect()->back()->with('error', "You already have an active loan for {$item->name}.");
            }
        }

        try {
            // Start database transaction
            \DB::beginTransaction();
            \Log::info('Database transaction started for multiple loans');

            $loanCount = 0;

            // Create loans for each item
            foreach ($request->item_ids as $itemId) {
                $item = InventoryItem::find($itemId);
                $quantity = (int)($request->quantities[$itemId] ?? 0);

                if ($quantity > 0) {
                    // Prepare loan data
                    $loanData = [
                        'cadet_id' => $cadet->id,
                        'item_id' => $itemId,
                        'quantity' => $quantity,
                        'borrow_date' => $request->borrow_date,
                        'status' => 'Borrowed'
                    ];

                    \Log::info('Loan data prepared: ', $loanData);

                    // Create the loan
                    $loan = EquipmentLoan::create($loanData);
                    $loanCount++;

                    \Log::info('Loan created successfully: ', [
                        'loan_id' => $loan->id,
                        'loan_data' => $loan->toArray()
                    ]);

                    // Update available quantity
                    $oldQuantity = $item->available_quantity;
                    $item->decrement('available_quantity', $quantity);
                    $item->refresh();
                    
                    \Log::info('Inventory updated: ', [
                        'item_id' => $itemId,
                        'item_name' => $item->name,
                        'old_quantity' => $oldQuantity,
                        'new_quantity' => $item->available_quantity,
                        'decremented_by' => $quantity
                    ]);
                }
            }

            // Commit transaction
            \DB::commit();
            \Log::info('Database transaction committed successfully for multiple loans');

            \Log::info('=== MULTIPLE LOANS CREATION DEBUG END - SUCCESS ===');
            return redirect()->back()->with('success', "{$loanCount} item(s) borrowed successfully.");

        } catch (\Exception $e) {
            \DB::rollback();
            
            \Log::error('=== MULTIPLE LOANS CREATION DEBUG END - ERROR ===');
            \Log::error('Exception occurred: ', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Failed to create loans: ' . $e->getMessage());
        }
    }

    public function returnLoan(Request $request, EquipmentLoan $loan)
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet || $loan->cadet_id !== $cadet->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($loan->status === 'Returned') {
            return redirect()->back()->with('error', 'This loan has already been returned.');
        }

        $request->validate([
            'return_date' => 'nullable|date|after_or_equal:' . $loan->borrow_date->format('Y-m-d') . '|before_or_equal:today'
        ]);

        $loan->update([
            'status' => 'Returned',
            'return_date' => $request->return_date ?? now()->toDateString()
        ]);

        // Update available quantity
        $loan->inventoryItem->increment('available_quantity', $loan->quantity);

        return redirect()->back()->with('success', 'Equipment returned successfully.');
    }

    public function deleteUniformSize(CadetSize $cadetSize)
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet || $cadetSize->cadet_id !== $cadet->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($cadetSize->is_issued) {
            return redirect()->back()->with('error', 'Cannot delete size for issued uniform item.');
        }

        $componentName = $cadetSize->uniformComponent->component_name;
        $cadetSize->delete();

        return redirect()->back()->with('success', "Uniform size for {$componentName} removed successfully.");
    }

    private function getCurrentCadet()
    {
        return Cadet::where('user_id', Auth::id())->first();
    }

    public function myProfile()
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return redirect()->back()->with('error', 'Cadet profile not found.');
        }

        $totalLoans = $cadet->equipmentLoans()->count();
        $activeLoans = $cadet->activeLoans()->count();
        $overdueLoans = $cadet->activeLoans()->get()->filter(function($loan) {
            return $loan->isOverdue();
        })->count();

        $uniformComponentsCount = $cadet->cadetSizes()->count();
        $issuedUniformsCount = $cadet->cadetSizes()->where('is_issued', true)->count();

        return view('cadet.inventory.profile', compact(
            'cadet',
            'totalLoans',
            'activeLoans',
            'overdueLoans',
            'uniformComponentsCount',
            'issuedUniformsCount'
        ));
    }
}