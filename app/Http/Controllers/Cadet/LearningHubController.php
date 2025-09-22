<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;
use App\Models\Instructor;
use App\Models\User;

class LearningHubController extends Controller
{
    public function index(Request $request)
    {
        $categories = LearningMaterialCategory::all();

        // Only get materials if a category filter is applied
        $materials = collect(); // Empty collection by default
        if ($request->filled('category')) {
            $materials = LearningMaterial::where('learning_material_category_id', $request->category)
                ->latest()
                ->get();
        }

        // Get instructors based on status filter, default to all statuses if none selected
        $instructorQuery = Instructor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'accepted');
            });

        // Apply status filter if provided
        if ($request->filled('instructor_status')) {
            $instructorQuery->where('status', $request->instructor_status);
        } else {
            // If no filter selected, show Active, Relocated, and Retired instructors
            $instructorQuery->whereIn('status', ['Active', 'Relocated', 'Retired']);
        }

        $instructors = $instructorQuery->get();

        return view('cadet.learning_hub', [
            'categories' => $categories,
            'materials' => $materials,
            'instructors' => $instructors,
            'selectedCategory' => $request->get('category'),
            'selectedInstructorStatus' => $request->get('instructor_status')
        ]);
    }

    public function getInstructor(Instructor $instructor)
    {
        // Load the instructor with user relationship
        $instructor->load('user');

        return response()->json($instructor);
    }

    // API endpoint for getting materials via AJAX
    public function getMaterials(Request $request)
    {
        if (!$request->filled('category')) {
            return response()->json([]);
        }

        $materials = LearningMaterial::where('learning_material_category_id', $request->category)
            ->latest()
            ->get();

        return response()->json($materials);
    }

    // API endpoint for getting instructors via AJAX
    public function getInstructors(Request $request)
    {
        $instructorQuery = Instructor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'accepted');
            });

        if ($request->filled('status')) {
            $instructorQuery->where('status', $request->status);
        } else {
            $instructorQuery->whereIn('status', ['Active', 'Relocated', 'Retired']);
        }

        $instructors = $instructorQuery->get();

        return response()->json($instructors);
    }
}