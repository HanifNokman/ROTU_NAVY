<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Models\LearningMaterial;
use App\Models\UniformType;
use App\Models\InventoryItem;
use App\Models\UniformComponent;
use App\Models\EquipmentLoan;
use App\Models\Gallery;
use App\Models\Training;
use App\Models\QuizQuestion;
use App\Models\Badge;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // ============================================================================
    // USER MANAGEMENT
    // ============================================================================

    public function userManagement(Request $request)
    {
        $cadetsQuery = Cadet::with('user');

        // Default to "No Intake Year" if no filter is selected
        $intakeFilter = $request->get('intake', 'no_intake');

        if ($intakeFilter == 'no_intake') {
            $cadetsQuery->whereNull('intake_year');
        } elseif ($intakeFilter) {
            $cadetsQuery->where('intake_year', $intakeFilter);
        }

        $cadets = $cadetsQuery->orderBy('service_number')->get();

        $rankOrder = [
            'Kpt' => 1,
            'Kdr' => 2,
            'Lt Kdr' => 3,
            'Lt' => 4,
            'Lt Dya' => 5,
            'Lt M' => 6,
            'PWI' => 7,
            'PWII' => 8,
            'BK' => 9,
            'BM' => 10,
            'LK' => 11,
            'LKI' => 12,
            'LKII' => 13,
        ];

        $instructorsQuery = Instructor::with('user');

        if ($request->has('status') && $request->status) {
            $instructorsQuery->where('status', $request->status);
        }

        $instructors = $instructorsQuery
            ->orderBy('service_number')
            ->get()
            ->sortBy(function ($instructor) use ($rankOrder) {
                return $rankOrder[$instructor->rank] ?? 999;
            })
            ->values();

        // For Admin: Show all intake years from Intake 11 (2022) onwards to current year
        // Example: In 2025, show Intake 11 (2022), Intake 12 (2023), Intake 13 (2024), Intake 14 (2025)
        // Example: In 2026, show Intake 11 (2022), Intake 12 (2023), Intake 13 (2024), Intake 14 (2025), Intake 15 (2026)
        $currentYear = now()->year;
        $startYear = 2022; // Intake 11 (2022)
        $intakeYears = collect(range($startYear, $currentYear));

        $intakes = $intakeYears->map(function($year) {
            $intakeNumber = $year - 2011;
            return [
                'year' => $year,
                'label' => 'Intake - ' . $intakeNumber . ' (' . $year . ')',
            ];
        })->values();

        $statuses = ['Active', 'Relocated', 'Retired'];

        $totalUsers = User::count();
        $totalActiveCadets = Cadet::where('cadet_status', 'Active')->count();
        $totalCommissionedCadets = Cadet::where('cadet_status', 'Completed')->count();
        $totalActiveInstructors = Instructor::where('status', 'Active')->count();

        return view('admin.user_management', compact(
            'cadets',
            'instructors',
            'intakes',
            'statuses',
            'request',
            'totalUsers',
            'totalActiveCadets',
            'totalCommissionedCadets',
            'totalActiveInstructors'
        ));
    }

    // ============================================================================
    // NEW: AJAX SEARCH FOR CADETS
    // ============================================================================
    public function searchCadets(Request $request)
    {
        $search = $request->get('search', '');
        $intake = $request->get('intake', '');

        $cadetsQuery = Cadet::with('user');
        
        // Apply intake filter
        if ($intake == 'no_intake') {
            $cadetsQuery->whereNull('intake_year');
        } elseif ($intake) {
            $cadetsQuery->where('intake_year', $intake);
        }
        
        // Apply search filter
        if ($search) {
            $cadetsQuery->where(function($query) use ($search) {
                $query->where('service_number', 'like', "%{$search}%")
                      ->orWhere('rank', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%")
                      ->orWhere('matric_no', 'like', "%{$search}%")
                      ->orWhere('ic_number', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%")
                      ->orWhere('bank_account_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
            });
        }
        
        $cadets = $cadetsQuery->orderBy('service_number')->get();

        return response()->json([
            'success' => true,
            'cadets' => $cadets,
            'count' => $cadets->count()
        ]);
    }

    // ============================================================================
    // NEW: AJAX SEARCH FOR INSTRUCTORS
    // ============================================================================
    public function searchInstructors(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $rankOrder = [
            'Kpt' => 1,
            'Kdr' => 2,
            'Lt Kdr' => 3,
            'Lt' => 4,
            'Lt Dya' => 5,
            'Lt M' => 6,
            'PWI' => 7,
            'PWII' => 8,
            'BK' => 9,
            'BM' => 10,
            'LK' => 11,
            'LKI' => 12,
            'LKII' => 13,
        ];

        $instructorsQuery = Instructor::with('user');

        // Apply status filter
        if ($status) {
            $instructorsQuery->where('status', $status);
        }

        // Apply search filter
        if ($search) {
            $instructorsQuery->where(function($query) use ($search) {
                $query->where('service_number', 'like', "%{$search}%")
                      ->orWhere('rank', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%")
                      ->orWhere('expertise', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%")
                      ->orWhereHas('user', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
            });
        }

        $instructors = $instructorsQuery
            ->orderBy('service_number')
            ->get()
            ->sortBy(function ($instructor) use ($rankOrder) {
                return $rankOrder[$instructor->rank] ?? 999;
            })
            ->values();

        return response()->json([
            'success' => true,
            'instructors' => $instructors,
            'count' => $instructors->count()
        ]);
    }

    /**
     * Handle profile picture upload with optimization and error handling.
     */
    private function handleProfilePictureUpload($request, $existingPicture = null)
    {
        if (!$request->hasFile('profile_pic')) {
            return null;
        }

        $image = $request->file('profile_pic');

        // Check if upload was successful
        if (!$image->isValid()) {
            throw new \Exception('File upload failed. The file may be corrupted or too large.');
        }

        try {
            // Optimize and compress the image
            $optimizedImagePath = $this->optimizeImage($image);

            // Delete old profile picture if exists
            if (!empty($existingPicture) && Storage::disk('public')->exists($existingPicture)) {
                Storage::disk('public')->delete($existingPicture);
            }

            return $optimizedImagePath;

        } catch (\Exception $e) {
            Log::error('Profile picture upload failed', [
                'error' => $e->getMessage(),
                'file' => $image->getClientOriginalName(),
                'size' => $image->getSize()
            ]);
            throw new \Exception('Failed to save profile picture. Please try a smaller image (under 2MB).');
        }
    }

    /**
     * Optimize image by resizing and compressing.
     */
    private function optimizeImage($uploadedFile)
    {
        // Create a unique filename
        $filename = time() . '_' . uniqid() . '.jpg';
        $path = 'profile_pics/' . $filename;

        // Get image info
        $imageInfo = getimagesize($uploadedFile->getPathname());
        if (!$imageInfo) {
            throw new \Exception('Invalid image file');
        }

        // Create image resource based on mime type
        $sourceImage = match($imageInfo['mime']) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($uploadedFile->getPathname()),
            'image/png' => imagecreatefrompng($uploadedFile->getPathname()),
            'image/gif' => imagecreatefromgif($uploadedFile->getPathname()),
            default => throw new \Exception('Unsupported image type')
        };

        if (!$sourceImage) {
            throw new \Exception('Failed to process image');
        }

        // Calculate new dimensions (max 800x800, maintain aspect ratio)
        $maxSize = 800;
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        if ($width > $maxSize || $height > $maxSize) {
            if ($width > $height) {
                $newWidth = $maxSize;
                $newHeight = (int)(($height / $width) * $maxSize);
            } else {
                $newHeight = $maxSize;
                $newWidth = (int)(($width / $height) * $maxSize);
            }
        } else {
            $newWidth = $width;
            $newHeight = $height;
        }

        // Create new image with optimized size
        $optimizedImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG
        if ($imageInfo['mime'] === 'image/png') {
            imagealphablending($optimizedImage, false);
            imagesavealpha($optimizedImage, true);
        }

        // Resize image
        imagecopyresampled(
            $optimizedImage,
            $sourceImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );

        // Save optimized image to storage
        $fullPath = storage_path('app/public/' . $path);
        $directory = dirname($fullPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save as JPEG with 85% quality (good balance between quality and size)
        $saved = imagejpeg($optimizedImage, $fullPath, 85);

        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($optimizedImage);

        if (!$saved) {
            throw new \Exception('Failed to save optimized image');
        }

        return $path;
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $userValidated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,instructor,cadet',
        ]);

        $user->update($userValidated);

        if ($user->role === 'cadet' && $user->cadet) {
            $cadetValidated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'nullable|in:Male,Female',
                'bank_account_number' => 'nullable|string|max:15',
                'rank' => 'nullable|string',
                'position' => 'nullable|string',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'intake_year' => 'nullable|digits:4',
                'matric_no' => 'nullable|string|max:11',
                'current_cgpa' => 'nullable|numeric|between:0,4.00',
                'past_cgpa' => 'nullable|numeric|between:0,4.00',
                'ic_number' => 'nullable|string|max:15',
                'BMI' => 'nullable|numeric',
                'BMI_update_date' => 'nullable|date',
                'swimming_qualification' => 'nullable|string',
                'swimming_pass_date' => 'nullable|date',
                'service_number' => 'nullable|string|max:10',
                'cadet_status' => 'nullable|in:Active,Suspended,Completed,Inactive',
            ]);

            // Handle profile picture upload
            try {
                $imagePath = $this->handleProfilePictureUpload($request, $user->cadet->profile_pic);
                if ($imagePath) {
                    $cadetValidated['profile_pic'] = $imagePath;
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 400);
            }

            $dateFields = ['BMI_update_date', 'swimming_pass_date'];
            foreach ($dateFields as $field) {
                if (isset($cadetValidated[$field]) && trim($cadetValidated[$field]) === '') {
                    $cadetValidated[$field] = null;
                }
            }

            $user->cadet->update($cadetValidated);

        } elseif ($user->role === 'instructor' && $user->instructor) {
            $instructorValidated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'rank' => 'nullable|string',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'position' => 'nullable|string|max:20',
                'expertise' => 'nullable|string',
                'time_in_service' => 'nullable|integer|min:0',
                'ttp' => 'nullable|date',
                'status' => 'nullable|string',
                'service_number' => 'nullable|string|max:10',
                'past_unit' => 'nullable|array',
            ]);

            // Handle profile picture upload
            try {
                $imagePath = $this->handleProfilePictureUpload($request, $user->instructor->profile_pic);
                if ($imagePath) {
                    $instructorValidated['profile_pic'] = $imagePath;
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], 400);
            }

            if (isset($instructorValidated['past_unit'])) {
                $instructorValidated['past_unit'] = json_encode(array_filter(
                    $instructorValidated['past_unit'],
                    function($value) {
                        return !empty(trim($value));
                    }
                ));
            }

            $user->instructor->update($instructorValidated);
        }

        return response()->json(['success' => true]);
    }

    public function getUser($id)
    {
        $user = User::with(['cadet', 'instructor'])->findOrFail($id);

        return response()->json([
            'user' => $user,
            'cadet' => $user->cadet,
            'instructor' => $user->instructor,
        ]);
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->confirm_name !== $user->name) {
            return response()->json(['error' => 'Name confirmation does not match.'], 400);
        }

        $user->delete();

        return response()->json(['success' => true]);
    }

    // ============================================================================
    // DATA MANAGEMENT
    // ============================================================================

    public function dataManagement(Request $request)
    {
        $models = [
            'learning_materials' => ['model' => LearningMaterial::class, 'name' => 'Learning Materials'],
            'uniform_types' => ['model' => UniformType::class, 'name' => 'Uniform Types'],
            'inventory_items' => ['model' => InventoryItem::class, 'name' => 'Inventory Items'],
            'uniform_components' => ['model' => UniformComponent::class, 'name' => 'Uniform Components'],
            'equipment_loans' => ['model' => EquipmentLoan::class, 'name' => 'Equipment Loans'],
            'galleries' => ['model' => Gallery::class, 'name' => 'Galleries'],
            'trainings' => ['model' => Training::class, 'name' => 'Trainings'],
            'quiz_questions' => ['model' => QuizQuestion::class, 'name' => 'Quiz Questions'],
            'badges' => ['model' => Badge::class, 'name' => 'Badges'],
        ];

        $counts = [];
        foreach ($models as $key => $info) {
            $counts[$key] = $info['model']::count();
        }

        $selectedModel = $request->get('model', 'learning_materials');
        if (!isset($models[$selectedModel])) {
            $selectedModel = 'learning_materials';
        }

        $data = [];
        switch ($selectedModel) {
            case 'learning_materials':
                $data = LearningMaterial::with('instructor.user', 'category')->get();
                break;
            case 'uniform_components':
                $data = UniformComponent::with('uniformType')->get();
                break;
            case 'equipment_loans':
                $data = EquipmentLoan::with('cadet.user', 'inventoryItem')->get();
                break;
            case 'galleries':
                $data = Gallery::with('category', 'instructor')->get();
                break;
            case 'quiz_questions':
                $data = QuizQuestion::with('category', 'creator')->get();
                break;
            default:
                $data = $models[$selectedModel]['model']::all();
                break;
        }

        return view('admin.data_management', compact('counts', 'models', 'selectedModel', 'data', 'request'));
    }

    // ============================================================================
    // NEW: AJAX SEARCH FOR DATA MANAGEMENT
    // ============================================================================
    public function searchData(Request $request)
    {
        $search = $request->get('search', '');
        $selectedModel = $request->get('model', 'learning_materials');

        $data = [];
        
        switch ($selectedModel) {
            case 'learning_materials':
                $query = LearningMaterial::with('instructor.user', 'category');
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhereHas('instructor.user', function($q2) use ($search) {
                              $q2->where('name', 'like', "%{$search}%");
                          })
                          ->orWhereHas('category', function($q2) use ($search) {
                              $q2->where('name', 'like', "%{$search}%");
                          });
                    });
                }
                $data = $query->get();
                break;

            case 'uniform_types':
                $query = UniformType::query();
                if ($search) {
                    $query->where('type_name', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                }
                $data = $query->get();
                break;

            case 'inventory_items':
                $query = InventoryItem::query();
                if ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('category', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                }
                $data = $query->get();
                break;

            case 'uniform_components':
                $query = UniformComponent::with('uniformType');
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('component_name', 'like', "%{$search}%")
                          ->orWhereHas('uniformType', function($q2) use ($search) {
                              $q2->where('type_name', 'like', "%{$search}%");
                          });
                    });
                }
                $data = $query->get();
                break;

            case 'equipment_loans':
                $query = EquipmentLoan::with('cadet.user', 'inventoryItem');
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('status', 'like', "%{$search}%")
                          ->orWhereHas('cadet.user', function($q2) use ($search) {
                              $q2->where('name', 'like', "%{$search}%");
                          })
                          ->orWhereHas('inventoryItem', function($q2) use ($search) {
                              $q2->where('name', 'like', "%{$search}%");
                          });
                    });
                }
                $data = $query->get();
                break;

            case 'galleries':
                $query = Gallery::with('category', 'instructor');
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%")
                          ->orWhereHas('category', function($q2) use ($search) {
                              $q2->where('name', 'like', "%{$search}%");
                          });
                    });
                }
                $data = $query->get();
                break;

            case 'trainings':
                $query = Training::query();
                if ($search) {
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhere('location', 'like', "%{$search}%")
                          ->orWhere('status', 'like', "%{$search}%");
                }
                $data = $query->get();
                break;

            case 'quiz_questions':
                $query = QuizQuestion::with('category', 'creator');
                if ($search) {
                    $query->where(function($q) use ($search) {
                        $q->where('question_text', 'like', "%{$search}%")
                          ->orWhere('question_type', 'like', "%{$search}%")
                          ->orWhere('status', 'like', "%{$search}%")
                          ->orWhereHas('category', function($q2) use ($search) {
                              $q2->where('name', 'like', "%{$search}%");
                          });
                    });
                }
                $data = $query->get();
                break;

            case 'badges':
                $query = Badge::query();
                if ($search) {
                    $query->where('name', 'like', "%{$search}%")
                          ->orWhere('category', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                }
                $data = $query->get();
                break;

            default:
                $data = [];
                break;
        }

        return response()->json([
            'success' => true,
            'data' => $data,
            'count' => count($data)
        ]);
    }

    public function getData($model, $id)
    {
        $models = [
            'learning_materials' => LearningMaterial::class,
            'uniform_types' => UniformType::class,
            'inventory_items' => InventoryItem::class,
            'uniform_components' => UniformComponent::class,
            'equipment_loans' => EquipmentLoan::class,
            'galleries' => Gallery::class,
            'trainings' => Training::class,
            'quiz_questions' => QuizQuestion::class,
            'badges' => Badge::class,
        ];

        if (!isset($models[$model])) {
            return response()->json(['error' => 'Invalid model'], 400);
        }

        $data = $models[$model]::findOrFail($id);
        return response()->json($data);
    }

    public function updateData(Request $request, $model, $id)
    {
        $models = [
            'learning_materials' => LearningMaterial::class,
            'uniform_types' => UniformType::class,
            'inventory_items' => InventoryItem::class,
            'uniform_components' => UniformComponent::class,
            'equipment_loans' => EquipmentLoan::class,
            'galleries' => Gallery::class,
            'trainings' => Training::class,
            'quiz_questions' => QuizQuestion::class,
            'badges' => Badge::class,
        ];

        if (!isset($models[$model])) {
            return response()->json(['error' => 'Invalid model'], 400);
        }

        $instance = $models[$model]::findOrFail($id);

        if ($model === 'badges') {
            $validated = $request->validate($this->getValidationRules($model));

            if ($request->hasFile('icon_path')) {
                if ($instance->icon_path && Storage::disk('public')->exists('badges/' . $instance->icon_path)) {
                    Storage::disk('public')->delete('badges/' . $instance->icon_path);
                }

                $file = $request->file('icon_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('badges', $filename, 'public');
                $validated['icon_path'] = $filename;
            }

            $instance->update($validated);
        } else {
            $validated = $request->validate($this->getValidationRules($model));
            $instance->update($validated);
        }

        return response()->json(['success' => true]);
    }

    public function deleteData(Request $request, $model, $id)
    {
        $models = [
            'learning_materials' => LearningMaterial::class,
            'uniform_types' => UniformType::class,
            'inventory_items' => InventoryItem::class,
            'uniform_components' => UniformComponent::class,
            'equipment_loans' => EquipmentLoan::class,
            'galleries' => Gallery::class,
            'trainings' => Training::class,
            'quiz_questions' => QuizQuestion::class,
            'badges' => Badge::class,
        ];

        if (!isset($models[$model])) {
            return response()->json(['error' => 'Invalid model'], 400);
        }

        $instance = $models[$model]::findOrFail($id);
        $instance->delete();

        return response()->json(['success' => true]);
    }

    // ============================================================================
    // ACCESS MANAGEMENT
    // ============================================================================

    public function accessManagement()
    {
        $user = auth()->user();
        
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Access denied. Your account must be accepted.');
        }

        $isAdmin = $user->role === 'admin';
        $isAdminInstructor = $user->role === 'instructor' && 
                             $user->instructor && 
                             $user->instructor->expertise === 'Admin';
        
        if (!$isAdmin && !$isAdminInstructor) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $instructors = Instructor::with('user')
            ->whereHas('user', function($query) use ($user) {
                $query->where('id', '!=', $user->id)
                      ->where('role', 'instructor')
                      ->where('status', 'accepted');
            })
            ->where('expertise', '!=', 'Admin')
            ->where('status', 'Active')
            ->orderBy('rank')
            ->get();

        return view('admin.access_management', compact('instructors'));
    }

    public function transferAdmin(Request $request)
    {
        $currentUser = auth()->user();
        
        if (!$currentUser || $currentUser->status !== 'accepted' || $currentUser->role !== 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Access denied. Only Admins can transfer admin role.');
        }

        if (!$currentUser->instructor || $currentUser->instructor->expertise !== 'Admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Access denied. Only instructors with Admin expertise can perform this action.');
        }

        $request->validate([
            'instructor_id' => ['required', 'exists:instructors,id'],
            'password' => ['required', 'string'],
        ]);

        if (!Hash::check($request->password, $currentUser->password)) {
            return back()
                ->withErrors(['password' => 'The provided password is incorrect.'])
                ->withInput($request->except('password'));
        }

        $newAdminInstructor = Instructor::with('user')->findOrFail($request->instructor_id);

        if ($newAdminInstructor->expertise === 'Admin') {
            return back()
                ->with('error', 'The selected instructor already has Admin expertise.')
                ->withInput();
        }

        if ($newAdminInstructor->user_id === $currentUser->id) {
            return back()
                ->with('error', 'You cannot transfer admin role to yourself.')
                ->withInput();
        }

        if ($newAdminInstructor->user->status !== 'accepted' || $newAdminInstructor->user->role !== 'instructor') {
            return back()
                ->with('error', 'The selected instructor must have accepted status and instructor role.')
                ->withInput();
        }

        try {
            DB::transaction(function () use ($currentUser, $newAdminInstructor) {
                $currentAdminInstructor = $currentUser->instructor;
                $previousExpertise = $newAdminInstructor->expertise;

                $newAdminInstructor->expertise = 'Admin';
                $newAdminInstructor->save();

                $currentAdminInstructor->expertise = 'YO';
                $currentAdminInstructor->save();

                Log::info('Admin role transferred', [
                    'previous_admin_id' => $currentUser->id,
                    'previous_admin_name' => $currentUser->name,
                    'new_admin_id' => $newAdminInstructor->user_id,
                    'new_admin_name' => $newAdminInstructor->user->name,
                    'new_admin_previous_expertise' => $previousExpertise,
                    'timestamp' => now(),
                ]);
            });

            return redirect()->route('admin.dashboard')
                ->with('success', 'Admin role has been successfully transferred to ' . $newAdminInstructor->user->name . '. Your expertise has been changed to YO.');

        } catch (\Exception $e) {
            Log::error('Admin transfer failed: ' . $e->getMessage());
            
            return back()
                ->with('error', 'An error occurred while transferring admin role. Please try again.')
                ->withInput();
        }
    }

    // ============================================================================
    // GAMIFICATION MANAGEMENT
    // ============================================================================

    public function gamificationManagement()
    {
        $badges = Badge::withCount('cadetBadges')->orderBy('category')->orderBy('rarity_level', 'desc')->get();

        $categories = [
            'overall' => 'Overall Performance',
            'attendance' => 'Attendance',
            'quiz' => 'Quiz Performance',
            'learning' => 'Learning Progress',
            'duty' => 'Duty',
            'academic' => 'Academic Excellence',
        ];

        $metrics = [
            'attendance_percentage' => 'Attendance Percentage',
            'quiz_average' => 'Quiz Average Score',
            'quiz_count' => 'Total Quiz Attempts',
            'learning_progress' => 'Learning Progress Percentage',
            'duty_count' => 'Daily Duty Count',
            'cgpa' => 'Current CGPA',
            'total_points' => 'Total Performance Points',
            'rank' => 'Cadet Rank',
            'swimming_qualification' => 'Swimming Qualification',
            'is_best_cadet' => 'Best Cadet Status',
            'is_best_academic' => 'Best Academic Status',
            'training_count' => 'Total Training Attendance',
        ];

        $operators = [
            '>=' => 'Greater than or equal to',
            '>' => 'Greater than',
            '<=' => 'Less than or equal to',
            '<' => 'Less than',
            '==' => 'Equal to',
            '!=' => 'Not equal to',
        ];

        $ranks = ['Kpt', 'Kdr', 'Lt Kdr', 'Lt', 'Lt Dya', 'Lt M', 'PWI', 'PWII', 'BK', 'BM', 'LK', 'LKI', 'LKII'];

        return view('admin.gamification_management', compact('badges', 'categories', 'metrics', 'operators', 'ranks'));
    }

    public function storeBadge(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'rarity_level' => 'required|integer|min:1|max:6',
            'criteria_type' => 'required|in:hardcoded,dynamic',
            'unlock_criteria' => 'required|string',
            'criteria_config' => 'nullable|json',
            'icon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('icon_path')) {
            $file = $request->file('icon_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('assets/badges', $filename, 'public');
            $validated['icon_path'] = $filename;
        }

        $validated['is_active'] = $request->has('is_active');

        if ($validated['criteria_type'] === 'dynamic' && !empty($validated['criteria_config'])) {
            $validated['criteria_config'] = json_decode($validated['criteria_config'], true);
        } else {
            $validated['criteria_config'] = null;
        }

        Badge::create($validated);

        return response()->json(['success' => true, 'message' => 'Badge created successfully!']);
    }

    public function updateBadge(Request $request, $id)
    {
        $badge = Badge::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'rarity_level' => 'required|integer|min:1|max:6',
            'criteria_type' => 'required|in:hardcoded,dynamic',
            'unlock_criteria' => 'required|string',
            'criteria_config' => 'nullable|json',
            'icon_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('icon_path')) {
            // Delete old icon if exists
            if ($badge->icon_path && Storage::disk('public')->exists('assets/badges/' . $badge->icon_path)) {
                Storage::disk('public')->delete('assets/badges/' . $badge->icon_path);
            }

            $file = $request->file('icon_path');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('assets/badges', $filename, 'public');
            $validated['icon_path'] = $filename;
        }

        $validated['is_active'] = $request->has('is_active');

        if ($validated['criteria_type'] === 'dynamic' && !empty($validated['criteria_config'])) {
            $validated['criteria_config'] = json_decode($validated['criteria_config'], true);
        } else {
            $validated['criteria_config'] = null;
        }

        $badge->update($validated);

        return response()->json(['success' => true, 'message' => 'Badge updated successfully!']);
    }

    public function deleteBadge($id)
    {
        $badge = Badge::findOrFail($id);

        // Delete icon if exists
        if ($badge->icon_path && Storage::disk('public')->exists('assets/badges/' . $badge->icon_path)) {
            Storage::disk('public')->delete('assets/badges/' . $badge->icon_path);
        }

        $badge->delete();

        return response()->json(['success' => true, 'message' => 'Badge deleted successfully!']);
    }

    public function getBadge($id)
    {
        $badge = Badge::withCount('cadetBadges')->findOrFail($id);
        return response()->json($badge);
    }

    // ============================================================================
    // VALIDATION RULES
    // ============================================================================

    private function getValidationRules($model)
    {
        $rules = [
            'learning_materials' => [
                'instructor_id' => 'required|exists:instructors,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file_url' => 'nullable|string',
                'learning_material_category_id' => 'required|exists:learning_material_categories,id',
            ],
            'uniform_types' => [
                'type_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ],
            'inventory_items' => [
                'name' => 'required|string|max:255',
                'category' => 'required|in:equipment,uniform',
                'total_quantity' => 'required|integer|min:0',
                'available_quantity' => 'required|integer|min:0',
                'description' => 'nullable|string',
            ],
            'uniform_components' => [
                'uniform_type_id' => 'required|exists:uniform_types,id',
                'component_name' => 'required|string|max:255',
            ],
            'equipment_loans' => [
                'cadet_id' => 'required|exists:cadets,id',
                'item_id' => 'required|exists:inventory_items,id',
                'quantity' => 'required|integer|min:1',
                'borrow_date' => 'required|date',
                'return_date' => 'nullable|date|after:borrow_date',
                'status' => 'required|in:Borrowed,Returned',
            ],
            'galleries' => [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image_path' => 'nullable|string',
                'gallery_category_id' => 'required|exists:gallery_categories,id',
                'instructor_id' => 'required|exists:users,id',
            ],
            'trainings' => [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'location' => 'required|string|max:255',
                'start_datetime' => 'required|date',
                'end_datetime' => 'nullable|date|after:start_datetime',
                'involvement' => 'nullable|string',
                'duration_hours' => 'nullable|integer|min:1',
                'allowance_amount' => 'nullable|numeric|min:0',
                'allowance_type' => 'nullable|in:hourly,daily',
                'status' => 'required|in:Active,Completed,Cancelled',
            ],
            'quiz_questions' => [
                'category_id' => 'required|exists:learning_material_categories,id',
                'question_text' => 'required|string',
                'file_url' => 'nullable|string',
                'question_type' => 'required|in:MCQ,Subjective',
                'option_a' => 'nullable|string',
                'option_b' => 'nullable|string',
                'option_c' => 'nullable|string',
                'option_d' => 'nullable|string',
                'correct_answer' => 'required|string',
                'created_by' => 'required|exists:users,id',
                'status' => 'required|in:active,inactive',
            ],
            'badges' => [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'unlock_criteria' => 'required|string',
                'category' => 'required|string|max:255',
                'rarity_level' => 'required|integer|min:1|max:5',
                'is_active' => 'boolean',
            ],
        ];

        return $rules[$model] ?? [];
    }
}