<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\CadetSize;
use App\Models\EquipmentLoan;
use App\Models\InventoryItem;
use App\Models\UniformComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    public function index()
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return redirect()->back()->with('error', 'Cadet profile not found.');
        }

        // Get cadet's uniform sizes
        $uniformSizes = CadetSize::with('uniformComponent')
            ->where('cadet_id', $cadet->id)
            ->get()
            ->keyBy('component_id');

        // Get all uniform components
        $uniformComponents = UniformComponent::orderBy('component_name')->get();

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
            'availableItems'
        ));
    }

    public function updateUniformSize(Request $request)
    {
        $cadet = $this->getCurrentCadet();
        
        if (!$cadet) {
            return redirect()->back()->with('error', 'Cadet profile not found.');
        }

        $request->validate([
            'component_id' => [
                'required',
                'exists:uniform_components,id'
            ],
            'size' => 'required|string|max:10'
        ]);

        CadetSize::updateOrCreate(
            [
                'cadet_id' => $cadet->id,
                'component_id' => $request->component_id
            ],
            [
                'size' => $request->size,
                'is_issued' => false // Reset issued status when size changes
            ]
        );

        return redirect()->back()->with('success', 'Uniform size updated successfully.');
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
            'return_date' => 'nullable|date|after_or_equal:' . $loan->borrow_date->format('Y-m-d')
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

        $cadetSize->delete();

        return redirect()->back()->with('success', 'Uniform size removed successfully.');
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