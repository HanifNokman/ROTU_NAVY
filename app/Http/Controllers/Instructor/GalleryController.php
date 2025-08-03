<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class GalleryController extends Controller
{
    /**
     * Display a listing of the gallery items.
     */
    public function index(Request $request)
    {
        $instructorId = Auth::id();
        
        // Get categories for the current instructor
        $categories = GalleryCategory::where('instructor_id', $instructorId)->get();
        
        // Build query for gallery items
        $query = Gallery::where('instructor_id', $instructorId)
                       ->with('category')
                       ->orderBy('created_at', 'desc');
        
        // Apply category filter if specified
        if ($request->filled('category')) {
            $query->where('gallery_category_id', $request->category);
        }
        
        $galleries = $query->get();
        
        return view('instructor.gallery', compact('galleries', 'categories'));
    }

    /**
     * Store a newly created gallery item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath ? 'storage/' . $imagePath : null,
            'gallery_category_id' => $request->gallery_category_id,
            'instructor_id' => Auth::id(),
        ]);

        return redirect()->route('instructor.gallery')
                        ->with('success', 'Gallery item added successfully!');
    }

    /**
     * Update the specified gallery item.
     */
    public function update(Request $request, Gallery $gallery)
    {
        // Check if the gallery belongs to the current instructor
        if ($gallery->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'gallery_category_id' => $request->gallery_category_id,
        ];

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($gallery->image_path && file_exists(public_path($gallery->image_path))) {
                unlink(public_path($gallery->image_path));
            }
            
            $imagePath = $request->file('image')->store('gallery', 'public');
            $updateData['image_path'] = 'storage/' . $imagePath;
        }

        $gallery->update($updateData);

        return redirect()->route('instructor.gallery')
                        ->with('success', 'Gallery item updated successfully!');
    }

    /**
     * Remove the specified gallery item.
     */
    public function destroy(Gallery $gallery)
    {
        // Check if the gallery belongs to the current instructor
        if ($gallery->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the image file if exists
        if ($gallery->image_path && file_exists(public_path($gallery->image_path))) {
            unlink(public_path($gallery->image_path));
        }

        $gallery->delete();

        return redirect()->route('instructor.gallery')
                        ->with('success', 'Gallery item deleted successfully!');
    }

    /**
     * Store a newly created gallery category.
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('gallery_categories')->where(function ($query) {
                    return $query->where('instructor_id', Auth::id());
                }),
            ],
        ]);

        GalleryCategory::create([
            'name' => $request->name,
            'instructor_id' => Auth::id(),
        ]);

        return redirect()->route('instructor.gallery')
                        ->with('success', 'Gallery category added successfully!');
    }

    /**
     * Remove the specified gallery category.
     */
    public function destroyCategory(GalleryCategory $category)
    {
        // Check if the category belongs to the current instructor
        if ($category->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete all gallery items in this category and their images
        $galleries = Gallery::where('gallery_category_id', $category->id)->get();
        foreach ($galleries as $gallery) {
            if ($gallery->image_path && file_exists(public_path($gallery->image_path))) {
                unlink(public_path($gallery->image_path));
            }
        }

        // Delete all galleries in this category
        Gallery::where('gallery_category_id', $category->id)->delete();
        
        // Delete the category
        $category->delete();

        return redirect()->route('instructor.gallery')
                        ->with('success', 'Gallery category and all associated items deleted successfully!');
    }
}