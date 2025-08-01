<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\User;
use Illuminate\Http\Request;

class CadetManagementController extends Controller
{
    public function index(Request $request)
    {
        // Debug: Add logging to see what's happening
        \Log::info('Cadet Management Index called', [
            'request_params' => $request->all()
        ]);

        // Initialize ALL variables with safe defaults - be very explicit
        $infoType = $request->get('info_type', 'cgpa');
        $intakeYear = $request->get('intake_year', Cadet::max('intake_year') ?? now()->year);
if ($infoType === 'seniority') {
    $sortBy = 'asc';
    $filterBy = 'all';
} else {
    if ($infoType === 'cgpa') {
        $sortBy = 'asc'; // fixed ascending sort order for CGPA
    } else {
        $sortBy = $request->get('sort_by', 'asc');
    }
    $filterBy = $request->get('filter_by', 'all');
}

        // Debug: Log the variables
        \Log::info('Variables set', [
            'infoType' => $infoType,
            'intakeYear' => $intakeYear,
            'sortBy' => $sortBy,
            'filterBy' => $filterBy
        ]);

        // Create fallback recent intakes
        $currentYear = now()->year;
        $recentIntakes = [];
        for ($i = 0; $i < 4; $i++) {
            $year = $currentYear - $i;
            $intakeNumber = 14 - $i;
            $recentIntakes[] = [
                'year' => $year,
                'label' => "Intake - {$intakeNumber} ({$year})"
            ];
        }

        // Basic query - check if Cadet model exists and has data
        try {
            // Check if Cadet table exists and has User relationship
                if (!\Schema::hasTable('cadets')) {
                \Log::warning('Cadets table does not exist');
                $cadets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20, 1);
            } else {
                $query = Cadet::query();
                
                // Check if User relationship exists
                if (\Schema::hasTable('users')) {
                    $query = $query->with('user');
                }
                
                // Apply basic filtering
                if ($intakeYear && \Schema::hasColumn('cadets', 'intake_year')) {
                    $query->where('intake_year', $intakeYear);
                }

                // Simple sorting based on info type
                switch ($infoType) {
                    case 'seniority':
                        if (\Schema::hasColumn('cadets', 'service_number')) {
                            $query->orderBy('service_number', $sortBy);
                        }
                        break;
                    case 'position':
                        if ($filterBy === 'rank_holders' && \Schema::hasColumn('cadets', 'position')) {
                            $query->whereIn('position', ['CO', 'Thana', 'Zayn', 'PMC'])
                                  ->orderByRaw("FIELD(position, 'CO', 'Thana', 'Zayn', 'PMC')");
                        }
                        break;
                    case 'gender':
                        if (in_array($filterBy, ['male', 'female']) && \Schema::hasColumn('cadets', 'gender')) {
                            $query->where('gender', ucfirst($filterBy));
                        }
                        break;
case 'cgpa':
    if (\Schema::hasColumn('cadets', 'current_cgpa')) {
        switch ($filterBy) {
            case '3.67_and_above':
                $query->where('current_cgpa', '>=', 3.67);
                break;
            case '3.00_to_3.66':
                $query->whereBetween('current_cgpa', [3.00, 3.66]);
                break;
            case '2.50_to_2.99':
                $query->whereBetween('current_cgpa', [2.50, 2.99]);
                break;
            case '2.49_and_below':
                $query->where('current_cgpa', '<=', 2.49);
                break;
            case 'all':
            default:
                // no filter
                break;
        }
        $query->orderBy('current_cgpa', $sortBy);
    }
    break;
                    case 'swimming':
                        if (in_array($filterBy, ['pass', 'in_progress', 'fail']) && \Schema::hasColumn('cadets', 'swimming_qualification')) {
                            $status = str_replace('_', ' ', ucwords($filterBy, '_'));
                            $query->where('swimming_qualification', $status);
                        }
                        break;
                    case 'bmi':
                        if (\Schema::hasColumn('cadets', 'BMI')) {
                            switch ($filterBy) {
                                case 'overweight':
                                    $query->where('BMI', '>', 26.9);
                                    break;
                                case 'underweight':
                                    $query->where('BMI', '<', 18.0);
                                    break;
                            }
                            $query->orderBy('BMI', $sortBy);
                        }
                        break;
                }

                $cadets = $query->paginate(20);
            }
            
        } catch (\Exception $e) {
            // If there's an error, return empty collection
            \Log::error('Error in Cadet Management: ' . $e->getMessage());
            $cadets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20, 1);
        }

        // Prepare data array with ALL required variables
        $viewData = [
            'cadets' => $cadets,
            'infoType' => $infoType,
            'intakeYear' => $intakeYear,
            'sortBy' => $sortBy,
            'filterBy' => $filterBy,
            'recentIntakes' => $recentIntakes
        ];

        // Debug: Log what we're sending to the view
        \Log::info('Sending to view', array_keys($viewData));

        // Make sure to return the correct view path that matches your file structure
        return view('instructor.cadet_management', $viewData);
    }

    public function show($cadetId)
    {
        try {
            $cadet = Cadet::with('user')->findOrFail($cadetId);
            return response()->json([
                'success' => true,
                'cadet' => $cadet,
                'user' => $cadet->user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cadet not found'
            ], 404);
        }
    }

    public function updatePositions(Request $request)
    {
        $request->validate([
            'positions' => 'required|array',
            'intake_year' => 'required|integer'
        ]);

        try {
            $positions = $request->positions;
            $intakeYear = $request->intake_year;
            
            foreach ($positions as $cadetId => $position) {
                // Map "Normal Cadet" to "Normal" to match enum values in DB
                if ($position === 'Normal Cadet') {
                    $position = 'Normal';
                }
                Cadet::where('id', $cadetId)
                     ->where('intake_year', $intakeYear)
                     ->update(['position' => $position]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Positions updated successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update positions: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $cadetId)
    {
        $request->validate([
            'confirmation_name' => 'required|string'
        ]);

        try {
            $cadet = Cadet::with('user')->findOrFail($cadetId);
            $fullName = $cadet->user->name ?? 'Unknown';
            
            if (strtolower(trim($request->confirmation_name)) !== strtolower(trim($fullName))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Name confirmation does not match.'
                ], 422);
            }

            $cadet->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Cadet removed successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove cadet: ' . $e->getMessage()
            ], 500);
        }
    }
}