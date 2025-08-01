<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;
use Illuminate\Support\Facades\Storage;

class LearningHubController extends Controller
{
    public function index(Request $request)
    {
        $query = LearningMaterial::with('category');

        // Apply category filter if present
        if ($request->filled('category')) {
            $query->where('learning_material_category_id', $request->category);
        }

        $materials = $query->latest()->get();

        // Get all categories with material counts for the management section
        $categories = LearningMaterialCategory::withCount('learningMaterials')
            ->orderBy('name')
            ->get();

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
            // Updated to support video files with larger size limit
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov,wmv,flv,webm,mkv|max:51200', // 50MB max
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
        // Check if the material belongs to the authenticated instructor (optional security check)
        if ($material->instructor_id && $material->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'learning_material_category_id' => 'required|exists:learning_material_categories,id',
            // Updated to support video files with larger size limit
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov,wmv,flv,webm,mkv|max:51200', // 50MB max
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'learning_material_category_id' => $request->learning_material_category_id,
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists (improved file deletion)
            if ($material->file_url) {
                // Extract the storage path from the URL
                $oldFilePath = str_replace('storage/', '', $material->file_url);
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
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
        // Check if the material belongs to the authenticated instructor (optional security check)
        if ($material->instructor_id && $material->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated file (improved file deletion)
        if ($material->file_url) {
            // Extract the storage path from the URL
            $filePath = str_replace('storage/', '', $material->file_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
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
            'created_by' => auth()->id(), // Optional: track who created the category
        ]);

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Category created successfully.');
    }

    /**
     * Delete a category (NEW METHOD)
     */
    public function destroyCategory(LearningMaterialCategory $category)
    {
        // Check if category has associated materials
        $materialCount = $category->learningMaterials()->count();
        
        if ($materialCount > 0) {
            return redirect()->route('instructor.learning_hub')
                ->with('error', "Cannot delete category '{$category->name}' because it contains {$materialCount} material(s). Please move or delete the materials first.");
            
            // Alternative approach: Set materials to null category (uncomment if preferred)
            // $category->learningMaterials()->update(['learning_material_category_id' => null]);
            // $successMessage = "Category '{$category->name}' deleted successfully. {$materialCount} material(s) were moved to 'Uncategorized'.";
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()->route('instructor.learning_hub')
            ->with('success', "Category '{$categoryName}' deleted successfully.");
    }

    /**
     * Helper method to get file type icon or class (optional utility method)
     */
    private function getFileTypeIcon($filePath)
    {
        if (!$filePath) return 'file';
        
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $documentExtensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx'];
        
        if (in_array($extension, $videoExtensions)) {
            return 'video';
        } elseif (in_array($extension, $imageExtensions)) {
            return 'image';
        } elseif (in_array($extension, $documentExtensions)) {
            return 'document';
        }
        
        return 'file';
    }
}