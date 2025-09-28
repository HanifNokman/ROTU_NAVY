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

        // Get questions based on difficulty
        $query = QuizQuestion::query()
            ->active();

        if ($categoryId) {
            $query->byCategory($categoryId);
        }


        // Apply difficulty-based filtering, fallback to all available if not enough
        switch ($difficulty) {
            case 'easy':
                $questions = $query->mcq()->inRandomOrder()->limit(5)->get();
                $timeLimit = 300; // 5 minutes
                if ($questions->count() < 5) {
                    // Fallback: get all MCQ questions (even if less than 5)
                    $questions = $query->mcq()->inRandomOrder()->get();
                }
                break;
            case 'medium':
                $mcqQuestions = $query->mcq()->inRandomOrder()->limit(3)->get();
                $subjectiveQuestions = $query->subjective()->inRandomOrder()->limit(2)->get();
                if ($mcqQuestions->count() + $subjectiveQuestions->count() < 5) {
                    // Fallback: get all available questions (MCQ + Subjective)
                    $questions = $query->inRandomOrder()->get();
                } else {
                    $questions = $mcqQuestions->merge($subjectiveQuestions)->shuffle();
                }
                $timeLimit = 600; // 10 minutes
                break;
            case 'hard':
                $mcqQuestions = $query->mcq()->inRandomOrder()->limit(2)->get();
                $subjectiveQuestions = $query->subjective()->inRandomOrder()->limit(5)->get();
                if ($mcqQuestions->count() + $subjectiveQuestions->count() < 7) {
                    // Fallback: get all available questions (MCQ + Subjective)
                    $questions = $query->inRandomOrder()->get();
                } else {
                    $questions = $mcqQuestions->merge($subjectiveQuestions)->shuffle();
                }
                $timeLimit = 900; // 15 minutes
                break;
        }

        if ($questions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No questions available for the selected category and difficulty.'
            ], 404);
        }

        // Shuffle MCQ options for each question
        $questions->transform(function ($question) {
            if ($question->question_type === 'MCQ') {
                $options = collect([
                    'A' => $question->option_a,
                    'B' => $question->option_b,
                    'C' => $question->option_c,
                    'D' => $question->option_d
                ])->shuffle();

                $question->shuffled_options = $options;
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
                    'correct_answer' => $q->correct_answer
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
            $correctAnswer = $question['correct_answer'];

            $isCorrect = false;
            if ($question['question_type'] === 'MCQ') {
                $isCorrect = strtolower($correctAnswer) === strtolower($userAnswer);
            } elseif ($question['question_type'] === 'Subjective') {
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
                'correct_answer' => $correctAnswer,
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
