<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Cadet;
use App\Models\User;
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
            'filterBy' => $filterBy
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
                
                if ($intakeYear && Schema::hasColumn('cadets', 'intake_year')) {
                    $query->where('intake_year', $intakeYear);
                }

                $this->applyFiltersAndSorting($query, $infoType, $filterBy, $sortBy);

                $cadets = $query->paginate(20);
            }
            
        } catch (\Exception $e) {
            Log::error('Error in Cadet Management: ' . $e->getMessage());
            $cadets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20, 1);
        }

        $viewData = [
            'cadets' => $cadets,
            'infoType' => $infoType,
            'intakeYear' => $intakeYear,
            'sortBy' => $sortBy,
            'filterBy' => $filterBy,
            'recentIntakes' => $recentIntakes
        ];

        Log::info('Sending to view', array_keys($viewData));

        return view('instructor.cadet_management', $viewData);
    }

    // ================================================================
    // FILTERS AND SORTING: Apply query filters based on info type
    // ================================================================
    private function applyFiltersAndSorting($query, $infoType, $filterBy, $sortBy)
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
                ->update(['swimming_qualification' => 'Pass']);

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
            Log::error('Error updating positions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update positions: ' . $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // DESTROY: Remove cadet and associated user
    // ================================================================
    public function destroy(Request $request, $cadetId)
    {
        $request->validate([
            'confirmation_name' => 'required|string'
        ]);

        try {
            $cadet = Cadet::with('user')->findOrFail($cadetId);
            $fullName = $cadet->user->name ?? 'Unknown';
            $user = $cadet->user;
            
            if (strtolower(trim($request->confirmation_name)) !== strtolower(trim($fullName))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Name confirmation does not match.'
                ], 422);
            }

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