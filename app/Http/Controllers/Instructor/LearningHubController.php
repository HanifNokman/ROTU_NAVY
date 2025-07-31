<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;

class LearningHubController extends Controller
{
    public function index(Request $request)
    {
        $query = LearningMaterial::with('category');

        // Apply category filter if present
        if ($request->filled('category')) {
            $query->where('learning_material_category_id', $request->category);
        }

        $materials = $query->get();

        // Get all categories for the dropdown
        $categories = LearningMaterialCategory::all();

        return view('instructor.learning_hub', compact('materials', 'categories'));
    }

    public function create()
    {
        $categories = LearningMaterialCategory::all();
        return view('instructor.learning_hub', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'learning_material_category_id' => 'required|exists:learning_material_categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('learning_materials', $fileName, 'public');
        }

        LearningMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'learning_material_category_id' => $request->learning_material_category_id,
            'file_url' => $filePath ? 'storage/' . $filePath : null,
            'instructor_id' => auth()->id(), 
        ]);

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Learning material created successfully.');
    }

    public function edit(LearningMaterial $material)
    {
        $categories = LearningMaterialCategory::all();
        return view('instructor.learning_materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, LearningMaterial $material)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'learning_material_category_id' => 'required|exists:learning_material_categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description, // Changed from 'content' to 'description' to match model
            'learning_material_category_id' => $request->learning_material_category_id,
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($material->file_url && file_exists(public_path($material->file_url))) {
                unlink(public_path($material->file_url));
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('learning_materials', $fileName, 'public');
            $data['file_url'] = 'storage/' . $filePath;
        }

        $material->update($data);

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Learning material updated successfully.');
    }

    public function destroy(LearningMaterial $material)
    {
        // Delete associated file
        if ($material->file_url && file_exists(public_path($material->file_url))) {
            unlink(public_path($material->file_url));
        }
        
        $material->delete();

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Learning material deleted successfully.');
    }

    // Category management methods
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:learning_material_categories,name',
        ]);

        LearningMaterialCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Category created successfully.');
    }
}