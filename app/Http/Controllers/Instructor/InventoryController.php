<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\CadetSize;
use App\Models\EquipmentLoan;
use App\Models\InventoryItem;
use App\Models\UniformComponent;
use App\Models\UniformType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // Get intake years from current year (2025) down to 4 years back (2022)
        $currentYear = date('Y');
        $intakeYears = [];
        for ($i = 0; $i < 4; $i++) {
            $year = $currentYear - $i;
            $intakeNumber = 14 - $i;
            $intakeYears[] = [
                'year' => $year,
                'label' => "Intake - {$intakeNumber}"
            ];
        }

        // Get selected intake year (default to latest)
        $selectedIntakeYear = $request->get('intake_year', $intakeYears[0]['year']);
        $selectedUniformType = $request->get('uniform_type');
        $selectedUniformComponent = $request->get('uniform_component');
        $selectedLoanIntake = $request->get('loan_intake_year', $selectedIntakeYear);
        $selectedCategory = $request->get('equipment_category');

        // Get uniform types and components for dropdowns
        $uniformTypes = UniformType::all();
        $uniformComponents = UniformComponent::when($selectedUniformType, function($query) use ($selectedUniformType) {
            return $query->where('uniform_type_id', $selectedUniformType);
        })->get();

        // Get uniform size summary for selected intake year
        $uniformSizeSummary = $this->getUniformSizeSummary($selectedIntakeYear, $selectedUniformType, $selectedUniformComponent);

        // Get equipment loan records
        $equipmentLoans = $this->getEquipmentLoans($selectedLoanIntake, $selectedCategory);

        // Get inventory summary
        $inventorySummary = $this->getInventorySummary();

        return view('instructor.inventory', compact(
            'intakeYears',
            'selectedIntakeYear',
            'selectedUniformType',
            'selectedUniformComponent',
            'selectedLoanIntake',
            'selectedCategory',
            'uniformTypes',
            'uniformComponents',
            'uniformSizeSummary',
            'equipmentLoans',
            'inventorySummary'
        ));
    }

    private function getUniformSizeSummary($intakeYear, $uniformType = null, $uniformComponent = null)
    {
        $query = DB::table('cadet_sizes')
            ->join('cadets', 'cadet_sizes.cadet_id', '=', 'cadets.id')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->join('uniform_components', 'cadet_sizes.component_id', '=', 'uniform_components.id')
            ->leftJoin('uniform_types', 'uniform_components.uniform_type_id', '=', 'uniform_types.id')
            ->select(
                'uniform_components.component_name',
                'cadet_sizes.size',
                DB::raw('COUNT(*) as cadet_count')
            )
            ->where('cadets.intake_year', $intakeYear)
            ->whereNotNull('cadet_sizes.size');

        if ($uniformType) {
            $query->where('uniform_components.uniform_type_id', $uniformType);
        }

        if ($uniformComponent) {
            $query->where('uniform_components.id', $uniformComponent);
        }

        $results = $query->groupBy('uniform_components.component_name', 'cadet_sizes.size')
            ->orderBy('uniform_components.component_name')
            ->orderBy('cadet_sizes.size')
            ->get();

        // Ensure we always return a collection, even if empty
        return $results->isNotEmpty() ? $results->groupBy('component_name') : collect();
    }

    private function getEquipmentLoans($intakeYear = null, $category = null)
    {
        $query = EquipmentLoan::with(['cadet.user', 'inventoryItem'])
            ->join('cadets', 'equipment_loans.cadet_id', '=', 'cadets.id')
            ->join('inventory_items', 'equipment_loans.item_id', '=', 'inventory_items.id')
            ->select('equipment_loans.*');

        if ($intakeYear) {
            $query->where('cadets.intake_year', $intakeYear);
        }

        if ($category) {
            $query->where('inventory_items.category', $category);
        }

        return $query->orderBy('equipment_loans.borrow_date', 'desc')
            ->paginate(20);
    }

    private function getInventorySummary()
    {
        return InventoryItem::select(
                'id',
                'name',
                'category',
                'total_quantity',
                'available_quantity',
                DB::raw('(total_quantity - available_quantity) as borrowed_quantity')
            )
            ->orderBy('category')
            ->orderBy('name')
            ->get();
    }

    // Uniform Type Methods
    public function storeUniformType(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255|unique:uniform_types,type_name',
            'description' => 'nullable|string|max:500'
        ]);

        UniformType::create([
            'type_name' => $request->type_name,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Uniform type added successfully!'
        ]);
    }

    public function getUniformTypes()
    {
        $uniformTypes = UniformType::orderBy('type_name')->get();
        
        return response()->json([
            'success' => true,
            'data' => $uniformTypes
        ]);
    }

    public function deleteUniformType($id)
    {
        try {
            $uniformType = UniformType::findOrFail($id);
            
            // Check if uniform type has components
            if ($uniformType->uniformComponents()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete uniform type. It has associated components.'
                ], 400);
            }

            $uniformType->delete();

            return response()->json([
                'success' => true,
                'message' => 'Uniform type deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting uniform type.'
            ], 500);
        }
    }

    // Uniform Component Methods
    public function storeUniformComponent(Request $request)
    {
        $request->validate([
            'component_name' => 'required|string|max:255',
            'uniform_type_id' => 'required|exists:uniform_types,id'
        ]);

        // Check for duplicate component name within the same uniform type
        $exists = UniformComponent::where('component_name', $request->component_name)
            ->where('uniform_type_id', $request->uniform_type_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This component already exists for the selected uniform type.'
            ], 400);
        }

        UniformComponent::create([
            'component_name' => $request->component_name,
            'uniform_type_id' => $request->uniform_type_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Uniform component added successfully!'
        ]);
    }

    public function getUniformComponents()
    {
        $uniformComponents = UniformComponent::with('uniformType')
            ->orderBy('component_name')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $uniformComponents
        ]);
    }

    public function deleteUniformComponent($id)
    {
        try {
            $uniformComponent = UniformComponent::findOrFail($id);
            
            // Check if component has cadet sizes
            if ($uniformComponent->cadetSizes()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete component. It has associated cadet size records.'
                ], 400);
            }

            $uniformComponent->delete();

            return response()->json([
                'success' => true,
                'message' => 'Uniform component deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting uniform component.'
            ], 500);
        }
    }

    // Equipment Methods
    public function storeEquipment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:inventory_items,name',
            'category' => 'required|in:equipment,uniform',
            'total_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500'
        ]);

        InventoryItem::create([
            'name' => $request->name,
            'category' => $request->category,
            'total_quantity' => $request->total_quantity,
            'available_quantity' => $request->total_quantity, // Initially all available
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Equipment added successfully!'
        ]);
    }

    public function getEquipment()
    {
        $equipment = InventoryItem::orderBy('category')
            ->orderBy('name')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $equipment
        ]);
    }

    public function deleteEquipment($id)
    {
        try {
            $equipment = InventoryItem::findOrFail($id);
            
            // Check if equipment has active loans
            if ($equipment->activeLoans()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete equipment. It has active loans.'
                ], 400);
            }

            $equipment->delete();

            return response()->json([
                'success' => true,
                'message' => 'Equipment deleted successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting equipment.'
            ], 500);
        }
    }

    // Get components by uniform type (for dynamic dropdown)
    public function getComponentsByType($uniformTypeId)
    {
        $components = UniformComponent::where('uniform_type_id', $uniformTypeId)
            ->orderBy('component_name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $components
        ]);
    }

    public function updateLoanStatus(Request $request, EquipmentLoan $loan)
    {
        $request->validate([
            'status' => 'required|in:Borrowed,Returned',
            'return_date' => 'nullable|date'
        ]);

        $loan->update([
            'status' => $request->status,
            'return_date' => $request->status === 'Returned' ? 
                ($request->return_date ?? now()->toDateString()) : null
        ]);

        // Update inventory available quantity
        if ($request->status === 'Returned') {
            $loan->inventoryItem->increment('available_quantity', $loan->quantity);
        } elseif ($loan->getOriginal('status') === 'Returned') {
            $loan->inventoryItem->decrement('available_quantity', $loan->quantity);
        }

        return redirect()->back()->with('success', 'Loan status updated successfully.');
    }

    public function exportUniformSizes(Request $request)
    {
        $intakeYear = $request->get('intake_year');
        
        $data = DB::table('cadet_sizes')
            ->join('cadets', 'cadet_sizes.cadet_id', '=', 'cadets.id')
            ->join('users', 'cadets.user_id', '=', 'users.id')
            ->join('uniform_components', 'cadet_sizes.component_id', '=', 'uniform_components.id')
            ->select(
                'users.name as cadet_name',
                'uniform_components.component_name',
                'cadet_sizes.size',
                'cadet_sizes.is_issued'
            )
            ->where('cadets.intake_year', $intakeYear)
            ->orderBy('users.name')
            ->orderBy('uniform_components.component_name')
            ->get();

        $filename = "uniform_sizes_intake_{$intakeYear}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Cadet Name', 'Component', 'Size', 'Issued']);
            
            foreach ($data as $row) {
                fputcsv($file, [
                    $row->cadet_name,
                    $row->component_name,
                    $row->size,
                    $row->is_issued ? 'Yes' : 'No'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportEquipmentLoans(Request $request)
    {
        $intakeYear = $request->get('intake_year');
        
        $query = EquipmentLoan::with(['cadet.user', 'inventoryItem'])
            ->join('cadets', 'equipment_loans.cadet_id', '=', 'cadets.id')
            ->select('equipment_loans.*');

        if ($intakeYear) {
            $query->where('cadets.intake_year', $intakeYear);
        }

        $data = $query->orderBy('equipment_loans.borrow_date', 'desc')->get();

        $filename = $intakeYear ? 
            "equipment_loans_intake_{$intakeYear}.csv" : 
            "equipment_loans_all.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Cadet Name', 'Item Name', 'Quantity', 'Borrow Date', 'Return Date', 'Status', 'Days Overdue']);
            
            foreach ($data as $loan) {
                fputcsv($file, [
                    $loan->cadet->user->name,
                    $loan->inventoryItem->name,
                    $loan->quantity,
                    $loan->borrow_date->format('Y-m-d'),
                    $loan->return_date ? $loan->return_date->format('Y-m-d') : '',
                    $loan->status,
                    $loan->isOverdue() ? $loan->days_overdue : 0
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}