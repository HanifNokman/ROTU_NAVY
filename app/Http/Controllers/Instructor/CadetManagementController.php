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
    public function index(Request $request)
    {
        // Debug: Add logging to see what's happening
        Log::info('Cadet Management Index called', [
            'request_params' => $request->all()
        ]);

        // Initialize ALL variables with safe defaults - be very explicit
        $infoType = $request->get('info_type', 'seniority');
        $intakeYear = $request->get('intake_year', Cadet::max('intake_year') ?? now()->year);
        
        if ($infoType === 'seniority') {
            $sortBy = 'asc';
            $filterBy = 'all';
        } else {
            if ($infoType === 'cgpa') {
                $sortBy = 'desc'; // CGPA should be descending (highest first)
            } else {
                $sortBy = $request->get('sort_by', 'asc');
            }
            $filterBy = $request->get('filter_by', 'all');
        }

        // Debug: Log the variables
        Log::info('Variables set', [
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
            if (!Schema::hasTable('cadets')) {
                Log::warning('Cadets table does not exist');
                $cadets = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20, 1);
            } else {
                $query = Cadet::query();
                
                // Check if User relationship exists
                if (Schema::hasTable('users')) {
                    $query = $query->with('user');
                }
                
                // Apply basic filtering
                if ($intakeYear && Schema::hasColumn('cadets', 'intake_year')) {
                    $query->where('intake_year', $intakeYear);
                }

                // Apply filters and sorting based on info type
                $this->applyFiltersAndSorting($query, $infoType, $filterBy, $sortBy);

                $cadets = $query->paginate(20);
            }
            
        } catch (\Exception $e) {
            // If there's an error, return empty collection
            Log::error('Error in Cadet Management: ' . $e->getMessage());
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
        Log::info('Sending to view', array_keys($viewData));

        // Make sure to return the correct view path that matches your file structure
        return view('instructor.cadet_management', $viewData);
    }

    /**
     * Apply filters and sorting based on info type with proper service number sorting
     */
    private function applyFiltersAndSorting($query, $infoType, $filterBy, $sortBy)
    {
        switch ($infoType) {
            case 'seniority':
                // Default sorting by service number ascending
                if (Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderBy('service_number', 'asc');
                }
                break;

            case 'position':
                // Apply filter first
                if ($filterBy === 'rank_holders' && Schema::hasColumn('cadets', 'position')) {
                    $query->whereIn('position', ['CO', 'Thana', 'Zayn', 'PMC']);
                }
                
                // Special sorting for positions: CO, Thana, Zayn, PMC, then Normal Cadets
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
                // Apply filter
                if (in_array($filterBy, ['male', 'female']) && Schema::hasColumn('cadets', 'gender')) {
                    $query->where('gender', ucfirst($filterBy));
                }
                
                // Sort by gender, then by service number
                if (Schema::hasColumn('cadets', 'gender') && Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderBy('gender', 'asc')->orderBy('service_number', 'asc');
                }
                break;

            case 'cgpa':
                // Apply CGPA range filter
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
                    
                    // Sort by CGPA descending (highest first), then by service number ascending
                    if (Schema::hasColumn('cadets', 'service_number')) {
                        $query->orderBy('current_cgpa', 'desc')->orderBy('service_number', 'asc');
                    } else {
                        $query->orderBy('current_cgpa', 'desc');
                    }
                }
                break;

            case 'swimming':
                // Apply swimming status filter
                if (in_array($filterBy, ['pass', 'in_progress', 'fail']) && Schema::hasColumn('cadets', 'swimming_qualification')) {
                    $statusMap = [
                        'pass' => 'Pass',
                        'in_progress' => 'In Progress',
                        'fail' => 'Fail'
                    ];
                    $query->where('swimming_qualification', $statusMap[$filterBy]);
                }
                
                // Sort by swimming status (Pass, In Progress, Fail), then by service number
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
                // Apply BMI filter
                if (Schema::hasColumn('cadets', 'BMI')) {
                    switch ($filterBy) {
                        case 'overweight':
                            $query->where('BMI', '>', 26.9);
                            break;
                        case 'underweight':
                            $query->where('BMI', '<', 18.0);
                            break;
                    }
                    
                    // Sort by BMI, then by service number
                    if (Schema::hasColumn('cadets', 'service_number')) {
                        $query->orderBy('BMI', 'asc')->orderBy('service_number', 'asc');
                    } else {
                        $query->orderBy('BMI', 'asc');
                    }
                }
                break;

            default:
                // Default sorting by service number ascending
                if (Schema::hasColumn('cadets', 'service_number')) {
                    $query->orderBy('service_number', 'asc');
                }
                break;
        }
    }

    /**
     * Mark selected cadets as passed in swimming qualification
     */
    public function markSwimmingPassed(Request $request)
    {
        $request->validate([
            'cadet_ids' => 'required|array',
            'cadet_ids.*' => 'exists:cadets,id',
            'intake_year' => 'required|integer'
        ]);

        try {
            // Only update cadets who are not already passed and belong to the specified intake
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
            
            // Validate that special positions are unique within the intake
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
            Log::error('Error updating positions: ' . $e->getMessage());
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
            $user = $cadet->user;
            
            if (strtolower(trim($request->confirmation_name)) !== strtolower(trim($fullName))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Name confirmation does not match.'
                ], 422);
            }

            // Use database transaction to ensure data integrity
            \DB::transaction(function () use ($cadet, $user) {
                // Delete the cadet record first
                $cadet->delete();
                
                // If user exists, delete the user and all related records
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

    /**
     * Completely delete a user and all associated records from all tables
     */
    private function deleteUserCompletely(User $user)
    {
        try {
            $userId = $user->id;
            
            // Define all possible tables that might have user_id foreign key
            // Add or remove tables based on your actual database schema
            $relatedTables = [
                'cadets',                    // Cadet records
                'password_reset_tokens',     // Password reset tokens
                'sessions',                  // User sessions
                'personal_access_tokens',    // API tokens (if using Sanctum)
                'notifications',             // User notifications
                'user_preferences',          // User preferences (if exists)
                'user_profiles',             // Extended user profiles (if exists)
                'activity_logs',             // User activity logs (if exists)
                'user_roles',                // User roles (if using custom role system)
                'user_permissions',          // User permissions (if exists)
                'audit_logs',                // Audit logs (if exists)
                // Add any other tables that reference users
            ];

            // Delete from related tables first (to maintain referential integrity)
            foreach ($relatedTables as $table) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'user_id')) {
                    \DB::table($table)->where('user_id', $userId)->delete();
                    Log::info("Deleted records from {$table} for user {$userId}");
                }
            }

            // Handle tables with different foreign key naming conventions
            $customRelatedTables = [
                // Add tables that use different column names to reference users
                // Example: ['table_name' => 'column_name']
                // 'posts' => 'author_id',
                // 'comments' => 'created_by',
            ];

            foreach ($customRelatedTables as $table => $column) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, $column)) {
                    \DB::table($table)->where($column, $userId)->delete();
                    Log::info("Deleted records from {$table} for user {$userId} using column {$column}");
                }
            }

            // Handle pivot tables (many-to-many relationships)
            $pivotTables = [
                // Add pivot tables that reference users
                // 'user_groups',
                // 'user_courses',
                // 'user_events',
            ];

            foreach ($pivotTables as $table) {
                if (Schema::hasTable($table) && Schema::hasColumn($table, 'user_id')) {
                    \DB::table($table)->where('user_id', $userId)->delete();
                    Log::info("Deleted pivot records from {$table} for user {$userId}");
                }
            }

            // Delete files associated with the user (if any)
            $this->deleteUserFiles($user);

            // Finally, delete the user record
            $user->delete();
            
            Log::info("Successfully deleted user {$userId} and all associated records");
            
        } catch (\Exception $e) {
            Log::error('Error in deleteUserCompletely: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            throw $e; // Re-throw to be caught by the transaction
        }
    }

    /**
     * Delete files associated with the user
     */
    private function deleteUserFiles(User $user)
    {
        try {
            // Delete profile picture if it exists
            if (method_exists($user, 'cadet') && $user->cadet && $user->cadet->profile_pic) {
                $profilePicPath = storage_path('app/public/' . $user->cadet->profile_pic);
                if (file_exists($profilePicPath)) {
                    unlink($profilePicPath);
                    Log::info("Deleted profile picture: {$profilePicPath}");
                }
            }

            // Delete user avatar if stored locally
            $avatarPath = storage_path('app/public/avatars/' . $user->id . '.jpg');
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
                Log::info("Deleted avatar: {$avatarPath}");
            }

            // Delete any other user-specific files
            $userFolder = storage_path('app/public/users/' . $user->id);
            if (is_dir($userFolder)) {
                $this->deleteDirectory($userFolder);
                Log::info("Deleted user folder: {$userFolder}");
            }

        } catch (\Exception $e) {
            Log::warning('Error deleting user files: ' . $e->getMessage(), [
                'user_id' => $user->id
            ]);
            // Don't throw exception for file deletion errors - continue with user deletion
        }
    }

    /**
     * Recursively delete a directory and its contents
     */
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