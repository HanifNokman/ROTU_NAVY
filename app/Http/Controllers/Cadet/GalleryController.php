<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of all gallery items from all instructors.
     */
    public function index(Request $request)
    {
        // Check if user is authenticated and accepted (matching your other controllers)
        $user = auth()->user();
        if (!$user || $user->status !== 'accepted') {
            abort(403, 'Your account is not accepted.');
        }
        
        // Optional: Restrict to cadets only (remove this if you want instructors to access too)
        if ($user->role !== 'cadet') {
            abort(403, 'Unauthorized access.');
        }
        // Get all categories from all instructors with their creators
        $categories = GalleryCategory::with(['instructor'])
                                   ->orderBy('name', 'asc')
                                   ->get();
        
        // Build query for all gallery items
        $query = Gallery::with(['category', 'instructor'])
                       ->orderBy('created_at', 'desc');
        
        // Apply category filter if specified (for direct URL access)
        if ($request->filled('category')) {
            $query->where('gallery_category_id', $request->category);
        }
        
        // Apply instructor filter if specified (for direct URL access)
        if ($request->filled('instructor')) {
            $query->where('instructor_id', $request->instructor);
        }
        
        $galleries = $query->get();
        
        // Get all instructors who have gallery items
        $instructors = \App\Models\User::whereHas('galleries')
                                     ->where('role', 'instructor')
                                     ->get();
        
        return view('cadet.gallery', compact('galleries', 'categories', 'instructors'));
    }

    /**
     * Get gallery items for a specific category (AJAX endpoint)
     */
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

    /**
     * Get all categories with photo counts (AJAX endpoint)
     */
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