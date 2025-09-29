<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;
use App\Models\Instructor;
use App\Models\User;
use App\Models\QuizQuestion;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LearningHubController extends Controller
{
    public function index(Request $request)
    {
        $categories = LearningMaterialCategory::whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('quiz_questions')
                  ->whereColumn('quiz_questions.category_id', 'learning_material_categories.id')
                  ->where('status', 'active');
        })->get();

        // Only get materials if a category filter is applied
        $materials = collect(); // Empty collection by default
        if ($request->filled('category')) {
            $materials = LearningMaterial::where('learning_material_category_id', $request->category)
                ->latest()
                ->get();
        }

        // Get instructors based on status filter, default to all statuses if none selected
        $instructorQuery = Instructor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'accepted');
            });

        // Apply status filter if provided
        if ($request->filled('instructor_status')) {
            $instructorQuery->where('status', $request->instructor_status);
        } else {
            // If no filter selected, show Active, Relocated, and Retired instructors
            $instructorQuery->whereIn('status', ['Active', 'Relocated', 'Retired']);
        }

        $instructors = $instructorQuery->get();

        return view('cadet.learning_hub', [
            'categories' => $categories,
            'materials' => $materials,
            'instructors' => $instructors,
            'selectedCategory' => $request->get('category'),
            'selectedInstructorStatus' => $request->get('instructor_status')
        ]);
    }

    public function getInstructor(Instructor $instructor)
    {
        // Load the instructor with user relationship
        $instructor->load('user');

        return response()->json($instructor);
    }

    // API endpoint for getting materials via AJAX
    public function getMaterials(Request $request)
    {
        if (!$request->filled('category')) {
            return response()->json([]);
        }

        $materials = LearningMaterial::where('learning_material_category_id', $request->category)
            ->latest()
            ->get();

        return response()->json($materials);
    }

    // API endpoint for getting instructors via AJAX
    public function getInstructors(Request $request)
    {
        $instructorQuery = Instructor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'accepted');
            });

        if ($request->filled('status')) {
            $instructorQuery->where('status', $request->status);
        } else {
            $instructorQuery->whereIn('status', ['Active', 'Relocated', 'Retired']);
        }

        $instructors = $instructorQuery->get();

        return response()->json($instructors);
    }

    // Quiz methods
    public function startQuiz(Request $request)
{
    $request->validate([
        'category_id' => 'nullable|exists:learning_material_categories,id',
        'difficulty' => 'required|in:easy,medium,hard'
    ]);

    $categoryId = $request->category_id;
    $difficulty = $request->difficulty;

    // Get base query for questions
    $query = QuizQuestion::query()->active();

    if ($categoryId) {
        $query->byCategory($categoryId);
    }

    // Get all available questions first
    $allQuestions = $query->get();
    $mcqQuestions = $allQuestions->where('question_type', 'MCQ');
    $subjectiveQuestions = $allQuestions->where('question_type', 'Subjective');

    if ($allQuestions->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No questions available for the selected category.'
        ], 404);
    }

    // Initialize variables
    $questions = collect();
    $timeLimit = 300; // Default 5 minutes

    // Apply difficulty-based selection with fallbacks
    switch ($difficulty) {
        case 'easy':
            $timeLimit = 300; // 5 minutes
            if ($mcqQuestions->count() >= 5) {
                // Ideal case: get 5 MCQ questions
                $questions = $mcqQuestions->shuffle()->take(5);
            } elseif ($mcqQuestions->count() > 0) {
                // Fallback: get all available MCQ questions
                $questions = $mcqQuestions->shuffle();
            } else {
                // Final fallback: get any available questions (up to 5)
                $questions = $allQuestions->shuffle()->take(5);
            }
            break;

        case 'medium':
            $timeLimit = 300; // 5 minutes
            $targetMcq = 3;
            $targetSubjective = 2;
            
            // Try to get ideal distribution
            if ($mcqQuestions->count() >= $targetMcq && $subjectiveQuestions->count() >= $targetSubjective) {
                $selectedMcq = $mcqQuestions->shuffle()->take($targetMcq);
                $selectedSubjective = $subjectiveQuestions->shuffle()->take($targetSubjective);
                $questions = $selectedMcq->merge($selectedSubjective)->shuffle();
            } else {
                // Fallback: get what we can, prioritizing the mix
                $availableMcq = min($mcqQuestions->count(), $targetMcq);
                $availableSubjective = min($subjectiveQuestions->count(), $targetSubjective);
                
                $selectedMcq = $mcqQuestions->shuffle()->take($availableMcq);
                $selectedSubjective = $subjectiveQuestions->shuffle()->take($availableSubjective);
                $questions = $selectedMcq->merge($selectedSubjective);
                
                // If we don't have enough, fill with any remaining questions
                $totalSelected = $questions->count();
                if ($totalSelected < 5) {
                    $remaining = $allQuestions->whereNotIn('id', $questions->pluck('id'))
                                           ->shuffle()
                                           ->take(5 - $totalSelected);
                    $questions = $questions->merge($remaining);
                }
                $questions = $questions->shuffle();
            }
            break;

        case 'hard':
            $timeLimit = 420; // 7 minutes
            $targetMcq = 2;
            $targetSubjective = 5;
            
            // Try to get ideal distribution
            if ($mcqQuestions->count() >= $targetMcq && $subjectiveQuestions->count() >= $targetSubjective) {
                $selectedMcq = $mcqQuestions->shuffle()->take($targetMcq);
                $selectedSubjective = $subjectiveQuestions->shuffle()->take($targetSubjective);
                $questions = $selectedMcq->merge($selectedSubjective)->shuffle();
            } else {
                // Fallback: get what we can, prioritizing subjective questions for hard difficulty
                $availableMcq = min($mcqQuestions->count(), $targetMcq);
                $availableSubjective = min($subjectiveQuestions->count(), $targetSubjective);
                
                $selectedMcq = $mcqQuestions->shuffle()->take($availableMcq);
                $selectedSubjective = $subjectiveQuestions->shuffle()->take($availableSubjective);
                $questions = $selectedMcq->merge($selectedSubjective);
                
                // If we don't have enough, fill with any remaining questions
                $totalSelected = $questions->count();
                if ($totalSelected < 7) {
                    $remaining = $allQuestions->whereNotIn('id', $questions->pluck('id'))
                                           ->shuffle()
                                           ->take(7 - $totalSelected);
                    $questions = $questions->merge($remaining);
                }
                $questions = $questions->shuffle();
            }
            break;
    }

    // Final check - if we still don't have any questions, return error
    if ($questions->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'No questions available for the selected category and difficulty.'
        ], 404);
    }

        // Shuffle MCQ options for each question
        $questions->transform(function ($question) {
        if ($question->question_type === 'MCQ') {
            // Create original options mapping
            $originalOptions = [
                'A' => $question->option_a,
                'B' => $question->option_b,
                'C' => $question->option_c,
                'D' => $question->option_d
            ];
            
            // Filter out empty options and get the values
            $optionValues = collect($originalOptions)->filter()->values();
            
            // Shuffle the values
            $shuffledValues = $optionValues->shuffle();
            
            // Reassign to A, B, C, D structure
            $shuffledOptions = [];
            $keys = ['A', 'B', 'C', 'D'];
            $shuffledValues->each(function ($value, $index) use (&$shuffledOptions, $keys) {
                if (isset($keys[$index])) {
                    $shuffledOptions[$keys[$index]] = $value;
                }
            });

            $question->shuffled_options = $shuffledOptions;
            
            // Get the correct answer text based on the original letter
            $correctAnswerText = '';
            switch(strtoupper($question->correct_answer)) {
                case 'A':
                    $correctAnswerText = $question->option_a;
                    break;
                case 'B':
                    $correctAnswerText = $question->option_b;
                    break;
                case 'C':
                    $correctAnswerText = $question->option_c;
                    break;
                case 'D':
                    $correctAnswerText = $question->option_d;
                    break;
                default:
                    $correctAnswerText = $question->correct_answer;
            }
            
            // Store the actual option text as correct answer
            $question->correct_answer_text = $correctAnswerText;
        }
        return $question;
    });

    // Store quiz session
    $quizSession = [
        'questions' => $questions->map(function ($q) {
            return [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'question_type' => $q->question_type,
                'file_url' => $q->file_url,
                'shuffled_options' => $q->shuffled_options ?? null,
                // Use the option text instead of letter for MCQ
                'correct_answer' => $q->question_type === 'MCQ' ? $q->correct_answer_text : $q->correct_answer
            ];
        }),
        'category_id' => $categoryId,
        'difficulty' => $difficulty,
        'time_limit' => $timeLimit,
        'start_time' => now()->timestamp,
        'user_id' => auth()->id()
    ];

    $sessionKey = 'quiz_' . auth()->id() . '_' . time();
    Cache::put($sessionKey, $quizSession, now()->addMinutes(30)); // Cache for 30 minutes

    return response()->json([
        'success' => true,
        'session_key' => $sessionKey,
        'questions' => $questions->map(function ($q) {
            return [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'question_type' => $q->question_type,
                'file_url' => $q->file_url,
                'shuffled_options' => $q->shuffled_options ?? null
            ];
        }),
        'time_limit' => $timeLimit,
        'total_questions' => $questions->count()
    ]);
}

    public function submitQuiz(Request $request)
    {
        $request->validate([
            'session_key' => 'required|string',
            'answers' => 'required|array',
            'answers.*' => 'nullable|string'
        ]);

        $sessionKey = $request->session_key;
        $userAnswers = $request->answers;

        $quizSession = Cache::get($sessionKey);

        if (!$quizSession || $quizSession['user_id'] !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz session not found or expired.'
            ], 404);
        }

        // Calculate score
        $questions = collect($quizSession['questions']);
        $totalQuestions = $questions->count();
        $correctAnswers = 0;
        $results = [];

        foreach ($questions as $question) {
            $questionId = $question['id'];
            $userAnswer = $userAnswers[$questionId] ?? null;
            $correctAnswer = $question['correct_answer']; // This is now option text for MCQ

            $isCorrect = false;
            if ($question['question_type'] === 'MCQ') {
                // Compare option text directly (case-insensitive, trimmed)
                $isCorrect = strtolower(trim($correctAnswer)) === strtolower(trim($userAnswer ?? ''));
            } elseif ($question['question_type'] === 'Subjective') {
                // For subjective, do case-insensitive comparison after trimming whitespace
                $isCorrect = strtolower(trim($correctAnswer)) === strtolower(trim($userAnswer ?? ''));
            }

            if ($isCorrect) {
                $correctAnswers++;
            }

            $results[] = [
                'question_id' => $questionId,
                'question_text' => $question['question_text'],
                'question_type' => $question['question_type'],
                'user_answer' => $userAnswer,
                'correct_answer' => $correctAnswer, // This will now show the option text
                'is_correct' => $isCorrect
            ];
        }

        $score = round(($correctAnswers / $totalQuestions) * 100, 2);

        // Store results in cache for review
        $resultKey = 'quiz_result_' . auth()->id() . '_' . time();
        Cache::put($resultKey, [
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'results' => $results,
            'category_id' => $quizSession['category_id'],
            'difficulty' => $quizSession['difficulty'],
            'completed_at' => now()
        ], now()->addHours(24)); // Keep results for 24 hours

        // Clear quiz session
        Cache::forget($sessionKey);

        return response()->json([
            'success' => true,
            'result_key' => $resultKey,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers
        ]);
    }

    public function getQuizResults(Request $request)
    {
        $request->validate([
            'result_key' => 'required|string'
        ]);

        $resultKey = $request->result_key;
        $results = Cache::get($resultKey);

        if (!$results) {
            return response()->json([
                'success' => false,
                'message' => 'Quiz results not found or expired.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }
}
