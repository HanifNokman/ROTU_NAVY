<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;

class LearningHubController extends Controller
{
    public function index(Request $request)
    {
        $categories = LearningMaterialCategory::all();

        $materials = LearningMaterial::query()
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('learning_material_category_id', $request->category);
            })
            ->latest()
            ->get();

        return view('cadet.learning_hub', [
            'categories' => $categories,
            'materials' => $materials
        ]);
    }
}
