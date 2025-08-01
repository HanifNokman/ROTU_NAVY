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
        $infoType = $request->get('info_type', 'seniority');
        $intakeYear = $request->get('intake_year', now()->year);
        $sortBy = $request->get('sort_by', 'asc');
        $filterBy = $request->get('filter_by', 'all');

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
                $cadets = collect()->paginate(20);
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
                        if (\Schema::hasColumn('cadets', 'ic_number')) {
                            $query->orderBy('ic_number', $sortBy);
                        }
                        break;
                    case 'position':
                        if ($filterBy === 'rank_holders' && \Schema::hasColumn('cadets', 'position')) {
                            $query->whereNotNull('position')
                                  ->where('position', '!=', 'Normal Cadet');
                        }
                        break;
                    case 'gender':
                        if (in_array($filterBy, ['male', 'female']) && \Schema::hasColumn('cadets', 'gender')) {
                            $query->where('gender', ucfirst($filterBy));
                        }
                        break;
                    case 'cgpa':
                        if (\Schema::hasColumn('cadets', 'current_cgpa')) {
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
                                case 'high_bmi':
                                    $query->where('BMI', '>', 26.9);
                                    break;
                                case 'low_bmi':
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
            $cadets = collect()->paginate(20);
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