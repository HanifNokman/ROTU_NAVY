<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

class AdminController extends Controller
{
    public function userManagement(Request $request)
    {
        // Fetch cadets with user data, filtered by intake if provided, sorted by service_number ascending
        $cadetsQuery = Cadet::with('user');
        if ($request->has('intake') && $request->intake == 'no_intake') {
            $cadetsQuery->whereNull('intake_year');
        } elseif ($request->has('intake') && $request->intake) {
            $cadetsQuery->where('intake_year', $request->intake);
        }
        $cadets = $cadetsQuery->orderBy('service_number')->get();

        // Define rank hierarchy for instructors
        $rankOrder = [
            'Kpt' => 1,
            'Kdr' => 2,
            'Lt.Kdr' => 3,
            'Lt' => 4,
            'Lt.Dya' => 5,
            'Lt.M' => 6,
            'PWI' => 7,
            'PWII' => 8,
            'BK' => 9,
            'BM' => 10,
            'LK' => 11,
            'LKI' => 12,
            'LKII' => 13,
        ];

        // Fetch instructors with user data, filtered by status if provided, sorted by rank hierarchy then service_number
        $instructorsQuery = Instructor::with('user');
        if ($request->has('status') && $request->status) {
            $instructorsQuery->where('status', $request->status);
        }
        $instructors = $instructorsQuery
            ->orderByRaw("FIELD(rank, '" . implode("','", array_keys($rankOrder)) . "')")
            ->orderBy('service_number')
            ->get();

        // Get distinct intakes for cadets filter, ordered ascending for lowest first
        $intakes = Cadet::select('intake_year')->distinct()->orderBy('intake_year', 'asc')->pluck('intake_year');

        // Status options for instructors
        $statuses = ['Active', 'Relocated', 'Retired'];

        // Summary statistics
        $totalUsers = User::count();
        $totalActiveCadets = Cadet::where('cadet_status', 'Active')->count();
        $totalActiveInstructors = Instructor::where('status', 'Active')->count();

        return view('admin.user_management', compact('cadets', 'instructors', 'intakes', 'statuses', 'request', 'totalUsers', 'totalActiveCadets', 'totalActiveInstructors'));
    }

    public function dataManagement(Request $request)
    {
        // Define models (removed: learning_material_categories, cadet_sizes, training_attendances, content_settings, gallery_categories)
        $models = [
            'learning_materials' => ['model' => LearningMaterial::class, 'name' => 'Learning Materials'],
            'uniform_types' => ['model' => UniformType::class, 'name' => 'Uniform Types'],
            'inventory_items' => ['model' => InventoryItem::class, 'name' => 'Inventory Items'],
            'uniform_components' => ['model' => UniformComponent::class, 'name' => 'Uniform Components'],
            'equipment_loans' => ['model' => EquipmentLoan::class, 'name' => 'Equipment Loans'],
            'galleries' => ['model' => Gallery::class, 'name' => 'Galleries'],
            'trainings' => ['model' => Training::class, 'name' => 'Trainings'],
            'quiz_questions' => ['model' => QuizQuestion::class, 'name' => 'Quiz Questions'],
        ];

        // Get counts for summary
        $counts = [];
        foreach ($models as $key => $info) {
            $counts[$key] = $info['model']::count();
        }

        // Selected model
        $selectedModel = $request->get('model', 'learning_materials');
        if (!isset($models[$selectedModel])) {
            $selectedModel = 'learning_materials';
        }

        // Fetch data for selected model with relationships
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

    public function accessManagement()
    {
        return view('admin.access_management');
    }

    public function getUser($id)
    {
        $user = User::with('cadet', 'instructor')->findOrFail($id);
        return response()->json([
            'user' => $user,
            'cadet' => $user->cadet,
            'instructor' => $user->instructor,
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate user fields
        $userValidated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,instructor,cadet',
        ]);

        // Update user fields
        $user->update($userValidated);

        // Update related model
        if ($user->role === 'cadet' && $user->cadet) {
            $cadetValidated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'nullable|in:Male,Female',
                'bank_account_number' => 'nullable|string|max:15',
                'rank' => 'nullable|string',
                'position' => 'nullable|string',
                'profile_pic' => 'nullable|string',
                'intake_year' => 'nullable|digits:4',
                'matric_no' => 'nullable|string|max:11',
                'current_cgpa' => 'nullable|numeric|between:0,4.00',
                'past_cgpa' => 'nullable|numeric|between:0,4.00',
                'ic_number' => 'nullable|string|max:15',
                'BMI' => 'nullable|numeric',
                'BMI_update_date' => 'nullable|date',
                'swimming_qualification' => 'nullable|string',
                'service_number' => 'nullable|string|max:10',
            ]);
            $user->cadet->update($cadetValidated);
        } elseif ($user->role === 'instructor' && $user->instructor) {
            $instructorValidated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'rank' => 'nullable|string',
                'profile_pic' => 'nullable|string',
                'position' => 'nullable|string|max:20',
                'expertise' => 'nullable|string',
                'time_in_service' => 'nullable|integer|min:0',
                'ttp' => 'nullable|date',
                'status' => 'nullable|string',
                'service_number' => 'nullable|string|max:10',
                'past_unit' => 'nullable|array',
            ]);
            // Handle past_unit array - filter out empty values and encode as JSON
            if (isset($instructorValidated['past_unit'])) {
                $instructorValidated['past_unit'] = json_encode(array_filter($instructorValidated['past_unit'], function($value) {
                    return !empty(trim($value));
                }));
            }
            $user->instructor->update($instructorValidated);
        }

        return response()->json(['success' => true]);
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
        ];

        if (!isset($models[$model])) {
            return response()->json(['error' => 'Invalid model'], 400);
        }

        $instance = $models[$model]::findOrFail($id);

        // Basic validation - adjust as needed
        $validated = $request->validate($this->getValidationRules($model));

        $instance->update($validated);

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
        ];

        if (!isset($models[$model])) {
            return response()->json(['error' => 'Invalid model'], 400);
        }

        $instance = $models[$model]::findOrFail($id);
        $instance->delete();

        return response()->json(['success' => true]);
    }

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
        ];

        return $rules[$model] ?? [];
    }
}