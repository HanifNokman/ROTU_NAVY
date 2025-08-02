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

        // Get available equipment items for borrowing
        $availableItems = InventoryItem::where('category', 'Equipment')
            ->where('available_quantity', '>', 0)
            ->orderBy('name')
            ->get();

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
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return redirect()->back()->with('error', 'Cadet profile not found.');
        }

        $request->validate([
            'item_id' => [
                'required',
                'exists:inventory_items,id',
                function ($attribute, $value, $fail) {
                    $item = InventoryItem::find($value);
                    if ($item && $item->category !== 'Equipment') {
                        $fail('Only equipment items can be borrowed.');
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
        
        // Check if cadet already has an active loan for this item
        $existingLoan = EquipmentLoan::where('cadet_id', $cadet->id)
            ->where('item_id', $request->item_id)
            ->where('status', 'Borrowed')
            ->first();

        if ($existingLoan) {
            return redirect()->back()->with('error', 'You already have an active loan for this item.');
        }

        // Create the loan
        EquipmentLoan::create([
            'cadet_id' => $cadet->id,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'borrow_date' => $request->borrow_date,
            'status' => 'Borrowed'
        ]);

        // Update available quantity
        $item->decrement('available_quantity', $request->quantity);

        return redirect()->back()->with('success', 'Equipment loan created successfully.');
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