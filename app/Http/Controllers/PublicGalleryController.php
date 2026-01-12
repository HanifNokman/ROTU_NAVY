<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\Request;

class PublicGalleryController extends Controller
{
    /**
     * Display the public gallery page
     */
    public function index(Request $request)
    {
        $categories = GalleryCategory::with(['instructor'])
                                     ->withCount('galleries')
                                     ->orderBy('galleries_count', 'desc')
                                     ->get();

        // Group galleries by category for "all" view
        $galleriesByCategory = [];
        foreach ($categories as $category) {
            $categoryGalleries = Gallery::with(['category', 'instructor'])
                                       ->where('gallery_category_id', $category->id)
                                       ->orderBy('created_at', 'desc')
                                       ->get();
            if ($categoryGalleries->count() > 0) {
                $galleriesByCategory[$category->id] = [
                    'category' => $category,
                    'galleries' => $categoryGalleries
                ];
            }
        }

        return view('public_gallery', compact('galleriesByCategory', 'categories'));
    }

    /**
     * Get gallery items by category (AJAX)
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
}
