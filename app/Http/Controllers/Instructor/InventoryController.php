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

        // Default to the lowest intake (last in the array)
        $defaultIntakeYear = end($intakeYears)['year'];

        // Get selected intake years for each section
        // For uniform section, default to lowest intake if not provided
        $selectedUniformIntakeYear = $request->get('intake_year', $defaultIntakeYear);
        // For loan section, default to lowest intake if not provided
        $selectedLoanIntakeYear = $request->get('loan_intake_year', $defaultIntakeYear);
        
        $selectedUniformType = $request->get('uniform_type');
        $selectedUniformComponent = $request->get('uniform_component');
        $selectedCategory = $request->get('equipment_category');
        $selectedStatus = $request->get('loan_status', 'active'); // Default to active loans

        // Get uniform types and components for dropdowns
        $uniformTypes = UniformType::all();
        $uniformComponents = UniformComponent::when($selectedUniformType, function($query) use ($selectedUniformType) {
            return $query->where('uniform_type_id', $selectedUniformType);
        })->get();

        // Handle AJAX requests for instant filtering
        if ($request->ajax()) {
            $response = [];
            
            if ($request->has('action')) {
                switch ($request->get('action')) {
                    case 'uniform_summary':
                        $response['uniformSizeSummary'] = $this->getUniformSizeSummaryForAjax($selectedUniformIntakeYear, $selectedUniformType, $selectedUniformComponent);
                        break;
                    case 'equipment_loans':
                        $response['equipmentLoans'] = $this->getEquipmentLoansForAjax($selectedLoanIntakeYear, $selectedCategory, $selectedStatus);
                        break;
                    case 'components_by_type':
                        $response['components'] = $this->getComponentsByTypeForAjax($selectedUniformType);
                        break;
                }
            }
            
            return response()->json($response);
        }

        // Get uniform size summary for selected intake year
        $uniformSizeSummary = $this->getUniformSizeSummary($selectedUniformIntakeYear, $selectedUniformType, $selectedUniformComponent);

        // Get equipment loan records with status filter
        $equipmentLoans = $this->getEquipmentLoans($selectedLoanIntakeYear, $selectedCategory, $selectedStatus);

        // Get inventory summary
        $inventorySummary = $this->getInventorySummary();

        return view('instructor.inventory', compact(
            'intakeYears',
            'selectedUniformIntakeYear',
            'selectedLoanIntakeYear',
            'selectedUniformType',
            'selectedUniformComponent',
            'selectedCategory',
            'selectedStatus',
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

    private function getUniformSizeSummaryForAjax($intakeYear, $uniformType = null, $uniformComponent = null)
    {
        $uniformSizeSummary = $this->getUniformSizeSummary($intakeYear, $uniformType, $uniformComponent);
        
        $html = '';
        if ($uniformSizeSummary->isEmpty()) {
            $html = '<div class="text-center py-8"><div class="text-gray-400 text-5xl mb-4"><i class="fas fa-tshirt"></i></div><p class="text-gray-500 text-lg">No uniform size data available for this intake year.</p></div>';
        } else {
            foreach ($uniformSizeSummary as $componentName => $sizes) {
                $html .= '<div class="mb-8">';
                $html .= '<div class="flex items-center mb-4">';
                $html .= '<div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold mr-3">';
                $html .= '<i class="fas fa-tag mr-1"></i>' . htmlspecialchars($componentName);
                $html .= '</div>';
                $html .= '<div class="h-px bg-gray-200 flex-1"></div>';
                $html .= '</div>';
                $html .= '<div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 border border-gray-100 shadow-sm">';
                $html .= '<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">';
                
                foreach ($sizes as $sizeData) {
                    $html .= '<div class="bg-white rounded-lg p-4 text-center shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">';
                    $html .= '<div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Size</div>';
                    $html .= '<div class="text-2xl font-bold text-blue-600 mb-1">' . htmlspecialchars($sizeData->size) . '</div>';
                    $html .= '<div class="text-lg font-semibold text-gray-800">' . $sizeData->cadet_count . '</div>';
                    $html .= '<div class="text-xs text-gray-500">cadets</div>';
                    $html .= '</div>';
                }
                
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
        }
        
        return $html;
    }

    private function getEquipmentLoans($intakeYear = null, $category = null, $status = null)
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

        // Filter by status if provided
        if ($status) {
            if ($status === 'active') {
                $query->where('equipment_loans.status', 'Borrowed');
            } elseif ($status === 'returned') {
                $query->where('equipment_loans.status', 'Returned');
            }
        }

        return $query->orderBy('equipment_loans.borrow_date', 'desc')
            ->paginate(20);
    }

    private function getEquipmentLoansForAjax($intakeYear = null, $category = null, $status = null)
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

        if ($status) {
            if ($status === 'active') {
                $query->where('equipment_loans.status', 'Borrowed');
            } elseif ($status === 'returned') {
                $query->where('equipment_loans.status', 'Returned');
            }
        }

        $equipmentLoans = $query->orderBy('equipment_loans.borrow_date', 'desc')->get();
        
        $html = '';
        if ($equipmentLoans->isEmpty()) {
            $html = '<div class="text-center py-12"><div class="text-gray-400 text-6xl mb-4"><i class="fas fa-tools"></i></div><p class="text-gray-500 text-lg">No equipment loan records found.</p></div>';
        } else {
            $html .= '<div class="overflow-x-auto">';
            $html .= '<table class="min-w-full divide-y divide-gray-200">';
            $html .= '<thead class="bg-gradient-to-r from-gray-50 to-gray-100">';
            $html .= '<tr>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Cadet</th>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Item</th>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Category</th>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Qty</th>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Borrow Date</th>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Return Date</th>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>';
            $html .= '<th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody class="bg-white divide-y divide-gray-200">';
            
            foreach ($equipmentLoans as $loan) {
                $rowClass = $loan->isOverdue() ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50';
                $html .= '<tr class="' . $rowClass . ' transition-colors duration-150">';
                
                // Cadet name with enhanced styling
                $html .= '<td class="px-6 py-4 whitespace-nowrap">';
                $html .= '<div class="flex items-center">';
                $html .= '<div class="bg-blue-100 rounded-full p-2 mr-3">';
                $html .= '<i class="fas fa-user text-blue-600 text-sm"></i>';
                $html .= '</div>';
                $html .= '<div class="text-sm font-semibold text-gray-900">' . htmlspecialchars($loan->cadet->user->name) . '</div>';
                $html .= '</div>';
                $html .= '</td>';
                
                // Item name with icon
                $html .= '<td class="px-6 py-4 whitespace-nowrap">';
                $html .= '<div class="text-sm font-medium text-gray-900">' . htmlspecialchars($loan->inventoryItem->name) . '</div>';
                $html .= '</td>';
                
                // Category with enhanced badge
                $categoryColor = $loan->inventoryItem->category === 'equipment' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800';
                $categoryIcon = $loan->inventoryItem->category === 'equipment' ? 'fas fa-tools' : 'fas fa-tshirt';
                $html .= '<td class="px-6 py-4 whitespace-nowrap">';
                $html .= '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold ' . $categoryColor . '">';
                $html .= '<i class="' . $categoryIcon . ' mr-1"></i>';
                $html .= ucfirst($loan->inventoryItem->category);
                $html .= '</span>';
                $html .= '</td>';
                
                // Quantity with emphasis
                $html .= '<td class="px-6 py-4 whitespace-nowrap">';
                $html .= '<span class="text-sm font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">' . $loan->quantity . '</span>';
                $html .= '</td>';
                
                // Borrow date with calendar icon
                $html .= '<td class="px-6 py-4 whitespace-nowrap">';
                $html .= '<div class="flex items-center text-sm text-gray-900">';
                $html .= '<i class="fas fa-calendar-alt text-gray-400 mr-2"></i>';
                $html .= $loan->borrow_date->format('M d, Y');
                $html .= '</div>';
                $html .= '</td>';
                
                // Return date
                $html .= '<td class="px-6 py-4 whitespace-nowrap">';
                if ($loan->return_date) {
                    $html .= '<div class="flex items-center text-sm text-gray-900">';
                    $html .= '<i class="fas fa-calendar-check text-green-500 mr-2"></i>';
                    $html .= $loan->return_date->format('M d, Y');
                    $html .= '</div>';
                } else {
                    $html .= '<span class="text-gray-400">-</span>';
                }
                $html .= '</td>';
                
                // Status with enhanced badges
                $html .= '<td class="px-6 py-4 whitespace-nowrap">';
                if ($loan->status === 'Borrowed') {
                    if ($loan->isOverdue()) {
                        $html .= '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">';
                        $html .= '<i class="fas fa-exclamation-triangle mr-1"></i>';
                        $html .= 'Overdue (' . $loan->days_overdue . ' days)';
                        $html .= '</span>';
                    } else {
                        $html .= '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">';
                        $html .= '<i class="fas fa-clock mr-1"></i>';
                        $html .= 'Borrowed';
                        $html .= '</span>';
                    }
                } else {
                    $html .= '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">';
                    $html .= '<i class="fas fa-check-circle mr-1"></i>';
                    $html .= 'Returned';
                    $html .= '</span>';
                }
                $html .= '</td>';
                
                // Actions
                $html .= '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium">';
                if ($loan->status === 'Borrowed') {
                    $html .= '<form method="POST" action="' . route('instructor.inventory.update-loan', $loan) . '" class="inline">';
                    $html .= csrf_field();
                    $html .= method_field('PATCH');
                    $html .= '<input type="hidden" name="status" value="Returned">';
                    $html .= '<button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium transition-colors duration-200">';
                    $html .= '<i class="fas fa-check mr-1"></i>Mark Returned';
                    $html .= '</button>';
                    $html .= '</form>';
                }
                $html .= '</td>';
                
                $html .= '</tr>';
            }
            
            $html .= '</tbody>';
            $html .= '</table>';
            $html .= '</div>';
        }
        
        return $html;
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

    private function getComponentsByTypeForAjax($uniformTypeId)
    {
        if (!$uniformTypeId) {
            return [];
        }
        
        return UniformComponent::where('uniform_type_id', $uniformTypeId)
            ->orderBy('component_name')
            ->get();
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

    public function exportUniformSizeSummary(Request $request)
    {
        $uniformType = $request->get('uniform_type');
        $uniformComponent = $request->get('uniform_component');
        
        // Get all intake years
        $currentYear = date('Y');
        $intakeYears = [];
        for ($i = 0; $i < 4; $i++) {
            $year = $currentYear - $i;
            $intakeNumber = 14 - $i;
            $intakeYears[] = [
                'year' => $year,
                'label' => "Intake {$intakeNumber}"
            ];
        }

        // Build query for summary data
        $query = DB::table('cadet_sizes')
            ->join('cadets', 'cadet_sizes.cadet_id', '=', 'cadets.id')
            ->join('uniform_components', 'cadet_sizes.component_id', '=', 'uniform_components.id')
            ->leftJoin('uniform_types', 'uniform_components.uniform_type_id', '=', 'uniform_types.id')
            ->select(
                'cadets.intake_year',
                'uniform_types.type_name',
                'uniform_components.component_name',
                'cadet_sizes.size',
                DB::raw('COUNT(*) as cadet_count')
            )
            ->whereNotNull('cadet_sizes.size');

        if ($uniformType) {
            $query->where('uniform_components.uniform_type_id', $uniformType);
        }

        if ($uniformComponent) {
            $query->where('uniform_components.id', $uniformComponent);
        }

        $results = $query->groupBy('cadets.intake_year', 'uniform_types.type_name', 'uniform_components.component_name', 'cadet_sizes.size')
            ->orderBy('cadets.intake_year', 'desc')
            ->orderBy('uniform_types.type_name')
            ->orderBy('uniform_components.component_name')
            ->orderBy('cadet_sizes.size')
            ->get();

        // Create filename based on filters
        $filename = 'uniform_size_summary';
        if ($uniformType) {
            $typeName = UniformType::find($uniformType)?->type_name;
            $filename .= '_' . str_replace(' ', '_', strtolower($typeName));
        }
        if ($uniformComponent) {
            $componentName = UniformComponent::find($uniformComponent)?->component_name;
            $filename .= '_' . str_replace(' ', '_', strtolower($componentName));
        }
        $filename .= '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($results, $intakeYears, $uniformType, $uniformComponent) {
            $file = fopen('php://output', 'w');
            
            // Report Header
            fputcsv($file, ['UNIFORM SIZE SUMMARY REPORT']);
            fputcsv($file, ['Generated on: ' . now()->format('F j, Y \a\t g:i A')]);
            fputcsv($file, ['']);

            // Filter information
            if ($uniformType || $uniformComponent) {
                fputcsv($file, ['APPLIED FILTERS:']);
                if ($uniformType) {
                    $typeName = UniformType::find($uniformType)?->type_name;
                    fputcsv($file, ['Uniform Type: ' . $typeName]);
                }
                if ($uniformComponent) {
                    $componentName = UniformComponent::find($uniformComponent)?->component_name;
                    fputcsv($file, ['Component: ' . $componentName]);
                }
                fputcsv($file, ['']);
            }

            // Group data by intake year for better organization
            $dataByIntake = [];
            foreach ($results as $row) {
                $intakeLabel = collect($intakeYears)->firstWhere('year', $row->intake_year)['label'] ?? "Intake {$row->intake_year}";
                $dataByIntake[$intakeLabel][] = $row;
            }

            // Output data by intake year
            foreach ($dataByIntake as $intakeLabel => $intakeData) {
                fputcsv($file, ["=== {$intakeLabel} ({$intakeData[0]->intake_year}) ==="]);
                fputcsv($file, ['']);
                
                // Group by uniform type and component for this intake
                $typeGroups = [];
                foreach ($intakeData as $row) {
                    $typeName = $row->type_name ?? 'Unspecified Type';
                    $typeGroups[$typeName][$row->component_name][] = $row;
                }
                
                foreach ($typeGroups as $typeName => $components) {
                    fputcsv($file, ["UNIFORM TYPE: {$typeName}"]);
                    fputcsv($file, ['']);
                    
                    // Create separate table for each component
                    foreach ($components as $componentName => $sizes) {
                        fputcsv($file, ["Component: {$componentName}"]);
                        
                        // Get all unique sizes for this component
                        $uniqueSizes = [];
                        foreach ($sizes as $sizeData) {
                            $uniqueSizes[$sizeData->size] = $sizeData->cadet_count;
                        }
                        
                        // Sort sizes logically (numbers first, then letters)
                        uksort($uniqueSizes, function($a, $b) {
                            // Check if both are numeric
                            if (is_numeric($a) && is_numeric($b)) {
                                return $a <=> $b;
                            }
                            // Check if both are letters
                            if (!is_numeric($a) && !is_numeric($b)) {
                                $order = ['XXS' => 1, 'XS' => 2, 'S' => 3, 'M' => 4, 'L' => 5, 'XL' => 6, 'XXL' => 7, 'XXXL' => 8];
                                $aVal = $order[strtoupper($a)] ?? 999;
                                $bVal = $order[strtoupper($b)] ?? 999;
                                if ($aVal === 999 && $bVal === 999) {
                                    return strcasecmp($a, $b);
                                }
                                return $aVal <=> $bVal;
                            }
                            // Numbers come before letters
                            return is_numeric($a) ? -1 : 1;
                        });
                        
                        // Create header row with actual sizes
                        $headers = ['Size'];
                        $counts = ['Count'];
                        $total = 0;
                        
                        foreach ($uniqueSizes as $size => $count) {
                            $headers[] = $size;
                            $counts[] = $count;
                            $total += $count;
                        }
                        $headers[] = 'Total';
                        $counts[] = $total;
                        
                        fputcsv($file, $headers);
                        fputcsv($file, $counts);
                        fputcsv($file, ['']);
                    }
                }
                fputcsv($file, ['']);
            }

            // Overall Summary Section
            fputcsv($file, ['=== OVERALL SUMMARY (All Intakes Combined) ===']);
            fputcsv($file, ['']);
            
            // Calculate overall totals by component
            $overallSummary = [];
            foreach ($results as $row) {
                $typeName = $row->type_name ?? 'Unspecified Type';
                $key = $typeName . '|' . $row->component_name . '|' . $row->size;
                
                if (!isset($overallSummary[$key])) {
                    $overallSummary[$key] = [
                        'type' => $typeName,
                        'component' => $row->component_name,
                        'size' => $row->size,
                        'total' => 0
                    ];
                }
                $overallSummary[$key]['total'] += $row->cadet_count;
            }
            
            // Group overall summary by type and component
            $overallByType = [];
            foreach ($overallSummary as $item) {
                $overallByType[$item['type']][$item['component']][$item['size']] = $item['total'];
            }
            
            foreach ($overallByType as $typeName => $components) {
                fputcsv($file, ["UNIFORM TYPE: {$typeName}"]);
                fputcsv($file, ['']);
                
                // Create separate table for each component in overall summary
                foreach ($components as $componentName => $sizes) {
                    fputcsv($file, ["Component: {$componentName}"]);
                    
                    // Sort sizes logically
                    uksort($sizes, function($a, $b) {
                        if (is_numeric($a) && is_numeric($b)) {
                            return $a <=> $b;
                        }
                        if (!is_numeric($a) && !is_numeric($b)) {
                            $order = ['XXS' => 1, 'XS' => 2, 'S' => 3, 'M' => 4, 'L' => 5, 'XL' => 6, 'XXL' => 7, 'XXXL' => 8];
                            $aVal = $order[strtoupper($a)] ?? 999;
                            $bVal = $order[strtoupper($b)] ?? 999;
                            if ($aVal === 999 && $bVal === 999) {
                                return strcasecmp($a, $b);
                            }
                            return $aVal <=> $bVal;
                        }
                        return is_numeric($a) ? -1 : 1;
                    });
                    
                    $headers = ['Size'];
                    $counts = ['Count'];
                    $total = 0;
                    
                    foreach ($sizes as $size => $count) {
                        $headers[] = $size;
                        $counts[] = $count;
                        $total += $count;
                    }
                    $headers[] = 'Total';
                    $counts[] = $total;
                    
                    fputcsv($file, $headers);
                    fputcsv($file, $counts);
                    fputcsv($file, ['']);
                }
            }

            // Quick Statistics
            fputcsv($file, ['=== QUICK STATISTICS ===']);
            fputcsv($file, ['']);
            
            $totalCadets = $results->sum('cadet_count');
            $totalIntakes = count($dataByIntake);
            $totalTypes = count($overallByType);
            $totalComponents = collect($overallSummary)->groupBy('component')->count();
            
            fputcsv($file, ['Total Cadets with Size Data:', $totalCadets]);
            fputcsv($file, ['Number of Intakes:', $totalIntakes]);
            fputcsv($file, ['Number of Uniform Types:', $totalTypes]);
            fputcsv($file, ['Number of Components:', $totalComponents]);
            
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