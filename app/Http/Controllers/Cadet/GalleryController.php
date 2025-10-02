<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // ================================================================
    // DISPLAY GALLERY INDEX
    // ================================================================
    
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Your account is not accepted.');
        }
        
        if ($user->role !== 'cadet') {
            abort(403, 'Unauthorized access.');
        }
        
        $categories = GalleryCategory::with(['instructor'])
                                     ->orderBy('name', 'asc')
                                     ->get();
        
        $query = Gallery::with(['category', 'instructor'])
                        ->orderBy('created_at', 'desc');
        
        if ($request->filled('category')) {
            $query->where('gallery_category_id', $request->category);
        }
        
        if ($request->filled('instructor')) {
            $query->where('instructor_id', $request->instructor);
        }
        
        $galleries = $query->get();
        
        $instructors = \App\Models\User::whereHas('galleries')
                                       ->where('role', 'instructor')
                                       ->get();
        
        return view('cadet.gallery', compact('galleries', 'categories', 'instructors'));
    }

    // ================================================================
    // GET GALLERY ITEMS BY CATEGORY (AJAX)
    // ================================================================
    
    public function getByCategory(Request $request, $categoryId)
    {
        if ($categoryId === 'all') {
            $galleries = Gallery::with(['category', 'instructor'])
                                ->orderBy('created_at', 'desc')
                                ->get();
        } else {
            $galleries = Gallery::with(['category', 'instructor'])
                                ->where('gallery_category_id', $categoryId)
                                ->orderBy('created_at', 'desc')
                                ->get();
        }

        return response()->json([
            'success' => true,
            'galleries' => $galleries,
            'count' => $galleries->count()
        ]);
    }

    // ================================================================
    // GET ALL CATEGORIES WITH PHOTO COUNTS (AJAX)
    // ================================================================
    
    public function getCategories()
    {
        $categories = GalleryCategory::with(['instructor'])
                                     ->withCount('galleries')
                                     ->orderBy('name', 'asc')
                                     ->get();

        return response()->json([
            'success' => true,
            'categories' => $categories
        ]);
    }
}