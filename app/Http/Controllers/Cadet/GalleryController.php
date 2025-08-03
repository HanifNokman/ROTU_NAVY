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
        // Get all categories from all instructors
        $categories = GalleryCategory::with('instructor')->get();
        
        // Build query for all gallery items
        $query = Gallery::with(['category', 'instructor'])
                       ->orderBy('created_at', 'desc');
        
        // Apply category filter if specified
        if ($request->filled('category')) {
            $query->where('gallery_category_id', $request->category);
        }
        
        // Apply instructor filter if specified
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
}