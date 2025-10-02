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
    // ================================================================
    // GALLERY ITEM METHODS
    // ================================================================

    public function index(Request $request)
    {
        $instructorId = Auth::id();
        
        $categories = GalleryCategory::where('instructor_id', $instructorId)->get();
        
        $query = Gallery::where('instructor_id', $instructorId)
                       ->with(['category', 'instructor'])
                       ->orderBy('created_at', 'desc');
        
        if ($request->filled('category')) {
            $query->where('gallery_category_id', $request->category);
        }
        
        $galleries = $query->get();
        
        return view('instructor.gallery', compact('galleries', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
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

    public function update(Request $request, Gallery $gallery)
    {
        if ($gallery->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'gallery_category_id' => 'required|exists:gallery_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'gallery_category_id' => $request->gallery_category_id,
        ];

        if ($request->hasFile('image')) {
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

    public function destroy(Gallery $gallery)
    {
        if ($gallery->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($gallery->image_path && file_exists(public_path($gallery->image_path))) {
            unlink(public_path($gallery->image_path));
        }

        $gallery->delete();

        return redirect()->route('instructor.gallery')
                        ->with('success', 'Gallery item deleted successfully!');
    }

    // ================================================================
    // GALLERY CATEGORY METHODS
    // ================================================================

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

    public function destroyCategory(GalleryCategory $category)
    {
        if ($category->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $galleries = Gallery::where('gallery_category_id', $category->id)->get();
        foreach ($galleries as $gallery) {
            if ($gallery->image_path && file_exists(public_path($gallery->image_path))) {
                unlink(public_path($gallery->image_path));
            }
        }

        Gallery::where('gallery_category_id', $category->id)->delete();
        
        $category->delete();

        return redirect()->route('instructor.gallery')
                        ->with('success', 'Gallery category and all associated items deleted successfully!');
    }
}