<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\User;
use App\Models\PerformanceRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CadetManagementController extends Controller
{
    // ================================================================
    // INDEX: Main Cadet Management View
    // ================================================================
    public function index(Request $request)
    {
        Log::info('Cadet Management Index called', [
            'request_params' => $request->all()
        ]);

        // Initialize variables with defaults
        $infoType = $request->get('info_type', 'seniority');
        $intakeYear = $request->get('intake_year', Cadet::min('intake_year') ?? now()->year);
        $searchQuery = $request->get('search', '');
        
        if ($infoType === 'seniority') {
            $sortBy = 'asc';
            $filterBy = 'all';
        } else {
            if ($infoType === 'cgpa') {
                $sortBy = 'desc';
            } else {
                $sortBy = $request->get('sort_by', 'asc');
            }
            $filterBy = $request->get('filter_by', 'all');
        }

        Log::info('Variables set', [
            'infoType' => $infoType,
            'intakeYear' => $intakeYear,
            'sortBy' => $sortBy,
            'filterBy' => $filterBy,
            'searchQuery' => $searchQuery
        ]);

        // Create recent intakes array
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

        // Build cadet query
        try {
            if (!Schema::hasTable('cadets')) {
                Log::warning('Cadets table does not exist');
                $cadets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20, 1);
            } else {
                $query = Cadet::query();
                
                if (Schema::hasTable('users')) {
                    $query = $query->with('user');
                }
                
                // Filter only active cadets
                $query->where('cadet_status', '!=', 'Suspended');
                
                if ($intakeYear && Schema::hasColumn('cadets', 'intake_year')) {
                    $query->where('intake_year', $intakeYear);
                }

                // Apply search filter
                if ($searchQuery) {
                    $query->where(function($q) use ($searchQuery) {
                        $q->where('service_number', 'like', "%{$searchQuery}%")
                          ->orWhere('matric_no', 'like', "%{$searchQuery}%")
                          ->orWhere('ic_number', 'like', "%{$searchQuery}%")
                          ->orWhereHas('user', function($userQuery) use ($searchQuery) {
                              $userQuery->where('name', 'like', "%{$searchQuery}%");
                          });
                    });
                }

                $this->applyFiltersAndSorting($query, $infoType, $filterBy, $sortBy, $request);

                $cadets = $query->paginate(20);
            }
            
        } catch (\Exception $e) {
            Log::error('Error in Cadet Management: ' . $e->getMessage());
            $cadets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20, 1);
        }

        // Get swimming pass dates for the selected intake if swimming is selected
        $swimmingPassDates = [];
        if ($infoType === 'swimming' && $intakeYear) {
            $swimmingPassDates = Cadet::where('intake_year', $intakeYear)
                ->where('cadet_status', '!=', 'Suspended')
                ->whereNotNull('swimming_pass_date')
                ->where('swimming_qualification', 'Pass')
                ->selectRaw('DATE(swimming_pass_date) as pass_date')
                ->distinct()
                ->orderBy('pass_date', 'desc')
                ->pluck('pass_date')
                ->map(function ($date) {
                    return \Carbon\Carbon::parse($date)->format('d/m/Y');
                })
                ->toArray();
        }

        // Get best cadet suggestions
        $bestCadetIntakeYear = $request->get('best_cadet_intake', $intakeYear);
        $bestCadets = $this->getBestCadets($bestCadetIntakeYear);
        $bestAcademicCadets = $this->getBestAcademicCadets($bestCadetIntakeYear);

        // Get suspended cadets
        $suspendedIntakeYear = $request->get('suspended_intake', $intakeYear);
        $suspendedCadets = Cadet::with(['user', 'performanceRating'])
            ->where('cadet_status', 'Suspended')
            ->where('intake_year', $suspendedIntakeYear)
            ->orderBy('service_number', 'asc')
            ->get();

        $viewData = [
            'cadets' => $cadets,
            'infoType' => $infoType,
            'intakeYear' => $intakeYear,
            'sortBy' => $sortBy,
            'filterBy' => $filterBy,
            'searchQuery' => $searchQuery,
            'recentIntakes' => $recentIntakes,
            'swimmingPassDates' => $swimmingPassDates,
            'bestCadets' => $bestCadets,
            'bestAcademicCadets' => $bestAcademicCadets,
            'bestCadetIntakeYear' => $bestCadetIntakeYear,
            'suspendedCadets' => $suspendedCadets,
            'suspendedIntakeYear' => $suspendedIntakeYear
        ];

        Log::info('Sending to view', array_keys($viewData));

        return view('instructor.cadet_management', $viewData);
    }

    // ================================================================
    // AJAX: Get cadets data for AJAX requests
    // ================================================================
    public function getCadetsAjax(Request $request)
    {
        try {
            $infoType = $request->get('info_type', 'seniority');
            $intakeYear = $request->get('intake_year', Cadet::min('intake_year') ?? now()->year);
            $searchQuery = $request->get('search', '');
            
            if ($infoType === 'seniority') {
                $sortBy = 'asc';
                $filterBy = 'all';
            } else {
                if ($infoType === 'cgpa') {
                    $sortBy = 'desc';
                } else {
                    $sortBy = $request->get('sort_by', 'asc');
                }
                $filterBy = $request->get('filter_by', 'all');
            }

            $query = Cadet::with('user')->where('cadet_status', '!=', 'Suspended');
            
            if ($intakeYear) {
                $query->where('intake_year', $intakeYear);
            }

            // Apply search filter
            if ($searchQuery) {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('service_number', 'like', "%{$searchQuery}%")
                      ->orWhere('matric_no', 'like', "%{$searchQuery}%")
                      ->orWhere('ic_number', 'like', "%{$searchQuery}%")
                      ->orWhereHas('user', function($userQuery) use ($searchQuery) {
                          $userQuery->where('name', 'like', "%{$searchQuery}%");
                      });
                });
            }

            $this->applyFiltersAndSorting($query, $infoType, $filterBy, $sortBy, $request);

            $cadets = $query->paginate(20);

            // Transform cadet data for JSON response
            $transformedCadets = $cadets->map(function($cadet) {
                return [
                    'id' => $cadet->id,
                    'service_number' => $cadet->service_number,
                    'user_name' => $cadet->user->name ?? 'Unknown',
                    'matric_no' => $cadet->matric_no,
                    'ic_number' => $cadet->ic_number,
                    'position' => $cadet->position,
                    'gender' => $cadet->gender,
                    'current_cgpa' => $cadet->current_cgpa,
                    'swimming_qualification' => $cadet->swimming_qualification,
                    'swimming_pass_date' => $cadet->swimming_pass_date ? $cadet->swimming_pass_date->format('d/m/Y') : null,
                    'BMI' => $cadet->BMI,
                    'BMI_update_date' => $cadet->BMI_update_date ? $cadet->BMI_update_date->format('d/m/Y') : null,
                ];
            });

            return response()->json([
                'success' => true,
                'cadets' => $transformedCadets,
                'firstItem' => $cadets->firstItem() ?? 0,
                'pagination' => [
                    'currentPage' => $cadets->currentPage(),
                    'lastPage' => $cadets->lastPage(),
                    'perPage' => $cadets->perPage(),
                    'total' => $cadets->total(),
                    'from' => $cadets->firstItem(),
                    'to' => $cadets->lastItem(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getCadetsAjax: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load cadets'
            ], 500);
        }
    }

    // ================================================================
    // AJAX: Get best cadets
    // ================================================================
    public function getBestCadetsAjax(Request $request)
    {
        try {
            $intakeYear = $request->get('intake_year', now()->year);
            $cadets = $this->getBestCadets($intakeYear);

            $transformedCadets = $cadets->map(function($cadet) {
                return [
                    'id' => $cadet->id,
                    'service_number' => $cadet->service_number,
                    'user_name' => $cadet->user->name ?? 'Unknown',
                    'rank' => $cadet->rank,
                    'profile_pic' => $cadet->profile_pic,
                    'total_points' => $cadet->performanceRating->total_points ?? 0,
                    'rating' => $cadet->performanceRating->rating ?? '⭐☆☆☆☆',
                ];
            });

            return response()->json([
                'success' => true,
                'cadets' => $transformedCadets
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getBestCadetsAjax: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load best cadets'
            ], 500);
        }
    }

    // ================================================================
    // AJAX: Get best academic cadets
    // ================================================================
    public function getBestAcademicCadetsAjax(Request $request)
    {
        try {
            $intakeYear = $request->get('intake_year', now()->year);
            $cadets = $this->getBestAcademicCadets($intakeYear);

            $transformedCadets = $cadets->map(function($cadet) {
                return [
                    'id' => $cadet->id,
                    'service_number' => $cadet->service_number,
                    'user_name' => $cadet->user->name ?? 'Unknown',
                    'rank' => $cadet->rank,
                    'profile_pic' => $cadet->profile_pic,
                    'current_cgpa' => $cadet->current_cgpa,
                    'academic_points' => $cadet->performanceRating->academic_points ?? 0,
                ];
            });

            return response()->json([
                'success' => true,
                'cadets' => $transformedCadets
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getBestAcademicCadetsAjax: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load best academic cadets'
            ], 500);
        }
    }

    // ================================================================
    // AJAX: Get suspended cadets
    // ================================================================
    public function getSuspendedCadetsAjax(Request $request)
    {
        try {
            $intakeYear = $request->get('intake_year', now()->year);
            
            $cadets = Cadet::with(['user', 'performanceRating'])
                ->where('cadet_status', 'Suspended')
                ->where('intake_year', $intakeYear)
                ->orderBy('service_number', 'asc')
                ->get();

            $transformedCadets = $cadets->map(function($cadet) {
                return [
                    'id' => $cadet->id,
                    'service_number' => $cadet->service_number,
                    'user_name' => $cadet->user->name ?? 'Unknown',
                    'matric_no' => $cadet->matric_no,
                ];
            });

            return response()->json([
                'success' => true,
                'cadets' => $transformedCadets
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getSuspendedCadetsAjax: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load suspended cadets'
            ], 500);
        }
    }

    // ================================================================
    // AJAX: Get swimming pass dates
    // ================================================================
    public function getSwimmingPassDates(Request $request)
    {
        try {
            $intakeYear = $request->get('intake_year', now()->year);
            
            $dates = Cadet::where('intake_year', $intakeYear)
                ->where('cadet_status', '!=', 'Suspended')
                ->whereNotNull('swimming_pass_date')
                ->where('swimming_qualification', 'Pass')
                ->selectRaw('DATE(swimming_pass_date) as pass_date')
                ->distinct()
                ->orderBy('pass_date', 'desc')
                ->pluck('pass_date')
                ->map(function ($date) {
                    return \Carbon\Carbon::parse($date)->format('d/m/Y');
                })
                ->toArray();

            return response()->json([
                'success' => true,
                'dates' => $dates
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getSwimmingPassDates: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load swimming pass dates'
            ], 500);
        }
    }

    // ================================================================
    // FILTERS AND SORTING: Apply query filters based on info type
    // ================================================================
    private function applyFiltersAndSorting($query, $infoType, $filterBy, $sortBy, $request = null)
    {
        switch ($infoType) {
            case 'seniority':
                if (Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderBy('service_number', 'asc');
                }
                break;

            case 'position':
                if ($filterBy === 'rank_holders' && Schema::hasColumn('cadets', 'position')) {
                    $query->whereIn('position', ['CO', 'Thana', 'Zayn', 'PMC']);
                }
                
                if (Schema::hasColumn('cadets', 'position') && Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderByRaw("
                        CASE 
                            WHEN position = 'CO' THEN 1
                            WHEN position = 'Thana' THEN 2
                            WHEN position = 'Zayn' THEN 3
                            WHEN position = 'PMC' THEN 4
                            ELSE 5
                        END
                    ")->orderBy('service_number', 'asc');
                }
                break;

            case 'gender':
                if (in_array($filterBy, ['male', 'female']) && Schema::hasColumn('cadets', 'gender')) {
                    $query->where('gender', ucfirst($filterBy));
                }
                
                if (Schema::hasColumn('cadets', 'gender') && Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderBy('gender', 'asc')->orderBy('service_number', 'asc');
                }
                break;

            case 'cgpa':
                if (Schema::hasColumn('cadets', 'current_cgpa')) {
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
                    }
                    
                    if (Schema::hasColumn('cadets', 'service_number')) {
                        $query->orderBy('current_cgpa', 'desc')->orderBy('service_number', 'asc');
                    } else {
                        $query->orderBy('current_cgpa', 'desc');
                    }
                }
                break;

            case 'swimming':
                if (in_array($filterBy, ['pass', 'in_progress', 'fail']) && Schema::hasColumn('cadets', 'swimming_qualification')) {
                    $statusMap = [
                        'pass' => 'Pass',
                        'in_progress' => 'In Progress',
                        'fail' => 'Fail'
                    ];
                    $query->where('swimming_qualification', $statusMap[$filterBy]);
                }

                $swimmingPassDate = $request->get('swimming_pass_date');
                if ($swimmingPassDate && $swimmingPassDate !== 'all' && Schema::hasColumn('cadets', 'swimming_pass_date')) {
                    try {
                        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $swimmingPassDate)->format('Y-m-d');
                        $query->whereDate('swimming_pass_date', $date);
                    } catch (\Exception $e) {
                        // Invalid date format, ignore filter
                    }
                }

                if (Schema::hasColumn('cadets', 'swimming_qualification') && Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderByRaw("
                        CASE swimming_qualification
                            WHEN 'Pass' THEN 1
                            WHEN 'In Progress' THEN 2
                            WHEN 'Fail' THEN 3
                            ELSE 4
                        END
                    ")->orderBy('service_number', 'asc');
                } elseif (Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderBy('service_number', 'asc');
                }
                break;

            case 'bmi':
                if (Schema::hasColumn('cadets', 'BMI')) {
                    switch ($filterBy) {
                        case 'overweight':
                            $query->where('BMI', '>', 26.9);
                            break;
                        case 'underweight':
                            $query->where('BMI', '<', 18.0);
                            break;
                    }
                    
                    if (Schema::hasColumn('cadets', 'service_number')) {
                        $query->orderBy('BMI', 'asc')->orderBy('service_number', 'asc');
                    } else {
                        $query->orderBy('BMI', 'asc');
                    }
                }
                break;

            default:
                if (Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderBy('service_number', 'asc');
                }
                break;
        }
    }

    // ================================================================
    // BEST CADETS: Get top 5 cadets by total points
    // ================================================================
    private function getBestCadets($intakeYear)
    {
        return Cadet::with(['user', 'performanceRating'])
            ->where('intake_year', $intakeYear)
            ->where('cadet_status', '!=', 'Suspended')
            ->whereHas('performanceRating')
            ->join('performance_ratings', 'cadets.id', '=', 'performance_ratings.cadet_id')
            ->orderBy('performance_ratings.total_points', 'desc')
            ->select('cadets.*')
            ->take(5)
            ->get();
    }

    // ================================================================
    // BEST ACADEMIC: Get top 5 cadets by academic points
    // ================================================================
    private function getBestAcademicCadets($intakeYear)
    {
        return Cadet::with(['user', 'performanceRating'])
            ->where('intake_year', $intakeYear)
            ->where('cadet_status', '!=', 'Suspended')
            ->whereHas('performanceRating')
            ->join('performance_ratings', 'cadets.id', '=', 'performance_ratings.cadet_id')
            ->orderBy('cadets.current_cgpa', 'desc')
            ->orderBy('performance_ratings.academic_points', 'desc')
            ->select('cadets.*')
            ->take(5)
            ->get();
    }

    // ================================================================
    // SWIMMING: Mark selected cadets as passed
    // ================================================================
    public function markSwimmingPassed(Request $request)
    {
        $request->validate([
            'cadet_ids' => 'required|array',
            'cadet_ids.*' => 'exists:cadets,id',
            'intake_year' => 'required|integer'
        ]);

        try {
            $updatedCount = Cadet::whereIn('id', $request->cadet_ids)
                ->where('intake_year', $request->intake_year)
                ->where('swimming_qualification', '!=', 'Pass')
                ->update([
                    'swimming_qualification' => 'Pass',
                    'swimming_pass_date' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Swimming qualification updated successfully',
                'updated_count' => $updatedCount
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating swimming qualification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update swimming qualification'
            ], 500);
        }
    }

    // ================================================================
    // SHOW: Get individual cadet profile
    // ================================================================
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

    // ================================================================
    // POSITIONS: Update cadet positions
    // ================================================================
    public function updatePositions(Request $request)
    {
        $request->validate([
            'positions' => 'required|array',
            'intake_year' => 'required|integer'
        ]);

        try {
            $positions = $request->positions;
            $intakeYear = $request->intake_year;
            
            $specialPositions = ['CO', 'Thana', 'Zayn', 'PMC'];
            $positionCounts = array_count_values($positions);
            
            foreach ($specialPositions as $position) {
                if (isset($positionCounts[$position]) && $positionCounts[$position] > 1) {
                    return response()->json([
                        'success' => false,
                        'message' => "Only one cadet per intake can hold the {$position} position."
                    ], 422);
                }
            }
            
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
            Log::error('Error updating positions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update positions: ' . $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // SUSPEND: Suspend cadet
    // ================================================================
    public function suspend(Request $request, $cadetId)
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

            $cadet->cadet_status = 'Suspended';
            $cadet->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Cadet suspended successfully'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error suspending cadet: ' . $e->getMessage(), [
                'cadet_id' => $cadetId,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to suspend cadet: ' . $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // REACTIVATE: Change cadet status back to Active
    // ================================================================
    public function reactivate(Request $request, $cadetId)
    {
        try {
            $cadet = Cadet::findOrFail($cadetId);

            if ($cadet->cadet_status !== 'Suspended') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cadet is not suspended'
                ], 400);
            }

            $cadet->cadet_status = 'Active';
            $cadet->save();

            return response()->json([
                'success' => true,
                'message' => 'Cadet reactivated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error reactivating cadet: ' . $e->getMessage(), [
                'cadet_id' => $cadetId,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to reactivate cadet: ' . $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // DESTROY: Remove cadet and associated user
    // ================================================================
    public function destroy(Request $request, $cadetId)
    {
        try {
            $cadet = Cadet::with('user')->findOrFail($cadetId);
            $user = $cadet->user;

            DB::transaction(function () use ($cadet, $user) {
                $cadet->delete();

                if ($user) {
                    $this->deleteUserCompletely($user);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Cadet and associated user records removed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error removing cadet and user: ' . $e->getMessage(), [
                'cadet_id' => $cadetId,
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove cadet: ' . $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // USER DELETION: Complete user and related records cleanup
    // ================================================================
    private function deleteUserCompletely(User $user)
    {
        try {
            $userId = $user->id;
            
            $relatedTables = [
                'cadets',
                'password_reset_tokens',
                'sessions',
                'personal_access_tokens',
                'notifications',
                'user_preferences',
                'user_profiles',
                'activity_logs',
                'user_roles',
                'user_permissions',
                'audit_logs',
            ];

            foreach ($relatedTables as $table) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'user_id')) {
                    DB::table($table)->where('user_id', $userId)->delete();
                    Log::info("Deleted records from {$table} for user {$userId}");
                }
            }

            $customRelatedTables = [];

            foreach ($customRelatedTables as $table => $column) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
                    DB::table($table)->where($column, $userId)->delete();
                    Log::info("Deleted records from {$table} for user {$userId} using column {$column}");
                }
            }

            $pivotTables = [];

            foreach ($pivotTables as $table) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'user_id')) {
                    DB::table($table)->where('user_id', $userId)->delete();
                    Log::info("Deleted pivot records from {$table} for user {$userId}");
                }
            }

            $this->deleteUserFiles($user);

            $user->delete();
            
            Log::info("Successfully deleted user {$userId} and all associated records");
            
        } catch (\Exception $e) {
            Log::error('Error in deleteUserCompletely: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    // ================================================================
    // FILE DELETION: Remove user-associated files
    // ================================================================
    private function deleteUserFiles(User $user)
    {
        try {
            if (method_exists($user, 'cadet') && $user->cadet && $user->cadet->profile_pic) {
                $profilePicPath = storage_path('app/public/' . $user->cadet->profile_pic);
                if (file_exists($profilePicPath)) {
                    unlink($profilePicPath);
                    Log::info("Deleted profile picture: {$profilePicPath}");
                }
            }

            $avatarPath = storage_path('app/public/avatars/' . $user->id . '.jpg');
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
                Log::info("Deleted avatar: {$avatarPath}");
            }

            $userFolder = storage_path('app/public/users/' . $user->id);
            if (is_dir($userFolder)) {
                $this->deleteDirectory($userFolder);
                Log::info("Deleted user folder: {$userFolder}");
            }

        } catch (\Exception $e) {
            Log::warning('Error deleting user files: ' . $e->getMessage(), [
                'user_id' => $user->id
            ]);
        }
    }

    // ================================================================
    // UTILITY: Recursively delete directory
    // ================================================================
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        
        return rmdir($dir);
    }
}