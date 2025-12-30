<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class LearningHubController extends Controller
{
    // ================================================================
    // MAIN INDEX & FILTERING
    // ================================================================

    public function index(Request $request)
    {
        $query = LearningMaterial::with('category');

        if ($request->filled('category')) {
            $query->where('learning_material_category_id', $request->category);
            $materials = $query->latest()->get();
        } else {
            $materials = collect();
        }

        $categories = LearningMaterialCategory::withCount('learningMaterials')
            ->orderBy('name')
            ->get();

        $quizQuestions = QuizQuestion::with(['category'])
            ->where('created_by', auth()->id())
            ->latest()
            ->get();

        return view('instructor.learning_hub', compact('materials', 'categories', 'quizQuestions'));
    }

    public function getFilteredMaterials(Request $request)
    {
        $query = LearningMaterial::with('category');

        if ($request->filled('category')) {
            $query->where('learning_material_category_id', $request->category);
        }

        $materials = $query->latest()->get();

        return response()->json([
            'materials' => $materials->map(function ($material) {
                return [
                    'id' => $material->id,
                    'title' => $material->title,
                    'description' => $material->description ?? '',
                    'category_name' => $material->category->name ?? 'N/A',
                    'file_url' => $material->file_url,
                    'learning_material_category_id' => $material->learning_material_category_id,
                    'escaped_title' => addslashes($material->title),
                    'escaped_description' => addslashes($material->description ?? ''),
                ];
            })
        ]);
    }

    // ================================================================
    // LEARNING MATERIAL CRUD
    // ================================================================

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
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov,wmv,flv,webm,mkv|max:51200',
            'youtube_url' => 'nullable|url',
        ]);

        $filePath = null;

        // Check if YouTube URL is provided
        if ($request->filled('youtube_url')) {
            $filePath = $request->youtube_url;
        }
        // Otherwise check for uploaded file
        elseif ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('learning_materials', $fileName, 'public');
            $filePath = 'storage/' . $filePath;
        }

        LearningMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'learning_material_category_id' => $request->learning_material_category_id,
            'file_url' => $filePath,
            'instructor_id' => auth()->user()->instructor->id,
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
        // Allow instructors with Admin expertise to edit any material, others can only edit their own
        if (auth()->user()->instructor->expertise !== 'Admin' && $material->instructor_id && $material->instructor_id !== auth()->user()->instructor->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'learning_material_category_id' => 'required|exists:learning_material_categories,id',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov,wmv,flv,webm,mkv|max:51200',
            'youtube_url' => 'nullable|url',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'learning_material_category_id' => $request->learning_material_category_id,
        ];

        // Check if YouTube URL is provided
        if ($request->filled('youtube_url')) {
            // Delete old file if it exists and is not a YouTube link
            if ($material->file_url && !$material->isYouTubeLink()) {
                $oldFilePath = str_replace('storage/', '', $material->file_url);
                if (Storage::disk('public')->exists($oldFilePath)) {
                    Storage::disk('public')->delete($oldFilePath);
                }
            }
            $data['file_url'] = $request->youtube_url;
        }
        // Otherwise check for uploaded file
        elseif ($request->hasFile('file')) {
            // Delete old file if it exists and is not a YouTube link
            if ($material->file_url && !$material->isYouTubeLink()) {
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
        // Allow instructors with Admin expertise to delete any material, others can only delete their own
        if (auth()->user()->instructor->expertise !== 'Admin' && $material->instructor_id && $material->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($material->file_url) {
            $filePath = str_replace('storage/', '', $material->file_url);
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
        }
        
        $material->delete();

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Learning material deleted successfully.');
    }

    // ================================================================
    // CATEGORY MANAGEMENT
    // ================================================================

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:learning_material_categories,name',
        ]);

        LearningMaterialCategory::create([
            'name' => $request->name,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Category created successfully.');
    }

    public function destroyCategory(LearningMaterialCategory $category)
    {
        $materialCount = $category->learningMaterials()->count();
        
        if ($materialCount > 0) {
            return redirect()->route('instructor.learning_hub')
                ->with('error', "Cannot delete category '{$category->name}' because it contains {$materialCount} material(s). Please move or delete the materials first.");
        }

        $categoryName = $category->name;
        $category->delete();

        return redirect()->route('instructor.learning_hub')
            ->with('success', "Category '{$categoryName}' deleted successfully.");
    }

    // ================================================================
    // QUIZ QUESTION CRUD
    // ================================================================

    public function storeQuiz(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:learning_material_categories,id',
            'question_text' => 'required|string',
            'question_type' => 'required|in:MCQ,Subjective',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov,wmv,flv,webm,mkv|max:51200',
            'option_a' => 'required_if:question_type,MCQ|string|nullable',
            'option_b' => 'required_if:question_type,MCQ|string|nullable',
            'option_c' => 'required_if:question_type,MCQ|string|nullable',
            'option_d' => 'required_if:question_type,MCQ|string|nullable',
            'correct_answer' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $filePath = null;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_quiz_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('quiz_files', $fileName, 'public');
                $filePath = 'storage/' . $filePath;
            }

            QuizQuestion::create([
                'category_id' => $request->category_id,
                'question_text' => $request->question_text,
                'question_type' => $request->question_type,
                'file_url' => $filePath,
                'option_a' => $request->question_type === 'MCQ' ? $request->option_a : null,
                'option_b' => $request->question_type === 'MCQ' ? $request->option_b : null,
                'option_c' => $request->question_type === 'MCQ' ? $request->option_c : null,
                'option_d' => $request->question_type === 'MCQ' ? $request->option_d : null,
                'correct_answer' => $request->correct_answer,
                'created_by' => auth()->id(),
                'status' => 'active'
            ]);
        });

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Quiz question created successfully.');
    }

    public function getQuizQuestions(Request $request)
    {
        $query = QuizQuestion::with(['category', 'creator'])
            ->where('created_by', auth()->id());

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('type') && in_array($request->type, ['MCQ', 'Subjective'])) {
            $query->where('question_type', $request->type);
        }

        $questions = $query->latest()->get();

        $formattedQuestions = $questions->map(function ($question) {
            $questionPreview = $question->question_text;
            if (strlen($question->question_text) > 100) {
                $questionPreview = substr($question->question_text, 0, 100) . '...';
            }

            return [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_type' => $question->question_type,
                'category_id' => $question->category_id,
                'category_name' => $question->category->name ?? 'Unknown',
                'status' => $question->status,
                'file_url' => $question->file_url,
                'option_a' => $question->option_a ?? '',
                'option_b' => $question->option_b ?? '',
                'option_c' => $question->option_c ?? '',
                'option_d' => $question->option_d ?? '',
                'correct_answer' => $question->correct_answer ?? '',
                'question_preview' => $questionPreview,
                'escaped_question_text' => addslashes($question->question_text),
                'escaped_option_a' => addslashes($question->option_a ?? ''),
                'escaped_option_b' => addslashes($question->option_b ?? ''),
                'escaped_option_c' => addslashes($question->option_c ?? ''),
                'escaped_option_d' => addslashes($question->option_d ?? ''),
                'escaped_correct_answer' => addslashes($question->correct_answer ?? ''),
                'escaped_question_preview' => addslashes($questionPreview),
                'created_at' => $question->created_at->format('M d, Y'),
            ];
        });

        return response()->json($formattedQuestions);
    }

    public function updateQuiz(Request $request, QuizQuestion $question)
    {
        $request->validate([
            'category_id' => 'required|exists:learning_material_categories,id',
            'question_text' => 'required|string',
            'question_type' => 'required|in:MCQ,Subjective',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,gif,mp4,avi,mov,wmv,flv,webm,mkv|max:51200',
            'option_a' => 'required_if:question_type,MCQ|nullable|string',
            'option_b' => 'required_if:question_type,MCQ|nullable|string',
            'option_c' => 'required_if:question_type,MCQ|nullable|string',
            'option_d' => 'required_if:question_type,MCQ|nullable|string',
            'correct_answer' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        \Log::info('QuizQuestion update request', $request->all());

        DB::transaction(function () use ($request, $question) {
            $filePath = $question->file_url;

            if ($request->hasFile('file')) {
                if ($question->file_url) {
                    $oldFilePath = str_replace('storage/', '', $question->file_url);
                    if (Storage::disk('public')->exists($oldFilePath)) {
                        Storage::disk('public')->delete($oldFilePath);
                    }
                }

                $file = $request->file('file');
                $fileName = time() . '_quiz_' . $file->getClientOriginalName();
                $storedPath = $file->storeAs('quiz_files', $fileName, 'public');
                $filePath = 'storage/' . $storedPath;
            }

            $question->update([
                'category_id' => $request->category_id,
                'question_text' => $request->question_text,
                'question_type' => $request->question_type,
                'file_url' => $filePath,
                'option_a' => $request->question_type === 'MCQ' ? $request->option_a : null,
                'option_b' => $request->question_type === 'MCQ' ? $request->option_b : null,
                'option_c' => $request->question_type === 'MCQ' ? $request->option_c : null,
                'option_d' => $request->question_type === 'MCQ' ? $request->option_d : null,
                'correct_answer' => $request->correct_answer,
                'status' => $request->status
            ]);
        });

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Quiz question updated successfully.');
    }

    public function destroyQuiz(QuizQuestion $question)
    {
        DB::transaction(function () use ($question) {
            if ($question->file_url) {
                $filePath = str_replace('storage/', '', $question->file_url);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            $question->delete();
        });

        return redirect()->route('instructor.learning_hub')
                        ->with('success', 'Quiz question deleted successfully.');
    }

    // ================================================================
    // UTILITY METHODS
    // ================================================================

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