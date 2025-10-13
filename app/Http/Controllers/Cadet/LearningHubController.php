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
    // ================================================================
    // DISPLAY LEARNING HUB INDEX
    // ================================================================
    
    public function index(Request $request)
    {
        $categories = LearningMaterialCategory::whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('quiz_questions')
                  ->whereColumn('quiz_questions.category_id', 'learning_material_categories.id')
                  ->where('status', 'active');
        })->get();

        $materials = collect();
        if ($request->filled('category')) {
            $materials = LearningMaterial::where('learning_material_category_id', $request->category)
                ->latest()
                ->get();
        }

        $instructorQuery = Instructor::with('user')
            ->whereHas('user', function ($query) {
                $query->where('status', 'accepted');
            });

        if ($request->filled('instructor_status')) {
            $instructorQuery->where('status', $request->instructor_status);
        } else {
            $instructorQuery->whereIn('status', ['Active', 'Relocated', 'Retired']);
        }

        $instructors = $instructorQuery->get();

        $rankOrder = [
            'Kpt',    // Highest
            'Kdr',
            'Lt.Kdr',
            'Lt',
            'Lt.Dya',
            'Lt.M',
            'PWII',
            'PWI',
            'BK',
            'BM',
            'LK',
            'LKI',
            'LKII'    // Lowest
        ];

        $instructors = $instructors->sortBy(function($instructor) use ($rankOrder) {
            $rank = $instructor->rank ?? '';
            $index = array_search($rank, $rankOrder);
            return $index !== false ? $index : count($rankOrder);
        });

        return view('cadet.learning_hub', [
            'categories' => $categories,
            'materials' => $materials,
            'instructors' => $instructors,
            'selectedCategory' => $request->get('category'),
            'selectedInstructorStatus' => $request->get('instructor_status')
        ]);
    }

    // ================================================================
    // GET INSTRUCTOR DETAILS
    // ================================================================
    
    public function getInstructor(Instructor $instructor)
    {
        $instructor->load('user');

        return response()->json($instructor);
    }

    // ================================================================
    // GET MATERIALS BY CATEGORY (AJAX)
    // ================================================================
    
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

    // ================================================================
    // GET INSTRUCTORS BY STATUS (AJAX)
    // ================================================================
    
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

        $rankOrder = [
            'Kpt',    // Highest
            'Kdr',
            'Lt.Kdr',
            'Lt',
            'Lt.Dya',
            'Lt.M',
            'PWII',
            'PWI',
            'BK',
            'BM',
            'LK',
            'LKI',
            'LKII'    // Lowest
        ];

        $instructors = $instructors->sortBy(function($instructor) use ($rankOrder) {
            $rank = $instructor->rank ?? '';
            $index = array_search($rank, $rankOrder);
            return $index !== false ? $index : count($rankOrder);
        })->values();

        return response()->json($instructors);
    }

    // ================================================================
    // START QUIZ SESSION
    // ================================================================
    
    public function startQuiz(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:learning_material_categories,id',
            'difficulty' => 'required|in:easy,medium,hard'
        ]);

        $categoryId = $request->category_id;
        $difficulty = $request->difficulty;

        $query = QuizQuestion::query()->active();

        if ($categoryId) {
            $query->byCategory($categoryId);
        }

        $allQuestions = $query->get();
        $mcqQuestions = $allQuestions->where('question_type', 'MCQ');
        $subjectiveQuestions = $allQuestions->where('question_type', 'Subjective');

        if ($allQuestions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No questions available for the selected category.'
            ], 404);
        }

        $questions = collect();
        $timeLimit = 300;

        switch ($difficulty) {
            case 'easy':
                $timeLimit = 60;
                if ($mcqQuestions->count() >= 5) {
                    $questions = $mcqQuestions->shuffle()->take(5);
                } elseif ($mcqQuestions->count() > 0) {
                    $questions = $mcqQuestions->shuffle();
                } else {
                    $questions = $allQuestions->shuffle()->take(5);
                }
                break;

            case 'medium':
                $timeLimit = 120;
                $targetMcq = 3;
                $targetSubjective = 2;
                
                if ($mcqQuestions->count() >= $targetMcq && $subjectiveQuestions->count() >= $targetSubjective) {
                    $selectedMcq = $mcqQuestions->shuffle()->take($targetMcq);
                    $selectedSubjective = $subjectiveQuestions->shuffle()->take($targetSubjective);
                    $questions = $selectedMcq->merge($selectedSubjective)->shuffle();
                } else {
                    $availableMcq = min($mcqQuestions->count(), $targetMcq);
                    $availableSubjective = min($subjectiveQuestions->count(), $targetSubjective);
                    
                    $selectedMcq = $mcqQuestions->shuffle()->take($availableMcq);
                    $selectedSubjective = $subjectiveQuestions->shuffle()->take($availableSubjective);
                    $questions = $selectedMcq->merge($selectedSubjective);
                    
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
                $timeLimit = 180;
                $targetMcq = 2;
                $targetSubjective = 5;
                
                if ($mcqQuestions->count() >= $targetMcq && $subjectiveQuestions->count() >= $targetSubjective) {
                    $selectedMcq = $mcqQuestions->shuffle()->take($targetMcq);
                    $selectedSubjective = $subjectiveQuestions->shuffle()->take($targetSubjective);
                    $questions = $selectedMcq->merge($selectedSubjective)->shuffle();
                } else {
                    $availableMcq = min($mcqQuestions->count(), $targetMcq);
                    $availableSubjective = min($subjectiveQuestions->count(), $targetSubjective);
                    
                    $selectedMcq = $mcqQuestions->shuffle()->take($availableMcq);
                    $selectedSubjective = $subjectiveQuestions->shuffle()->take($availableSubjective);
                    $questions = $selectedMcq->merge($selectedSubjective);
                    
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

        if ($questions->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No questions available for the selected category and difficulty.'
            ], 404);
        }

        $questions->transform(function ($question) {
            if ($question->question_type === 'MCQ') {
                $originalOptions = [
                    'A' => $question->option_a,
                    'B' => $question->option_b,
                    'C' => $question->option_c,
                    'D' => $question->option_d
                ];
                
                $optionValues = collect($originalOptions)->filter()->values();
                $shuffledValues = $optionValues->shuffle();
                
                $shuffledOptions = [];
                $keys = ['A', 'B', 'C', 'D'];
                $shuffledValues->each(function ($value, $index) use (&$shuffledOptions, $keys) {
                    if (isset($keys[$index])) {
                        $shuffledOptions[$keys[$index]] = $value;
                    }
                });

                $question->shuffled_options = $shuffledOptions;
                
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
                
                $question->correct_answer_text = $correctAnswerText;
            }
            return $question;
        });

        $quizSession = [
            'questions' => $questions->map(function ($q) {
                return [
                    'id' => $q->id,
                    'question_text' => $q->question_text,
                    'question_type' => $q->question_type,
                    'file_url' => $q->file_url,
                    'shuffled_options' => $q->shuffled_options ?? null,
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
        Cache::put($sessionKey, $quizSession, now()->addMinutes(30));

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

    // ================================================================
    // IMPROVED ANSWER COMPARISON METHOD
    // ================================================================
    
    /**
     * Compare answers with fuzzy matching for subjective questions
     * 
     * @param string $correctAnswer The correct answer
     * @param string $userAnswer The user's answer
     * @param string $questionType The type of question (MCQ or Subjective)
     * @return bool Whether the answer is correct
     */
    private function compareAnswers($correctAnswer, $userAnswer, $questionType)
    {
        // Handle empty answers
        if (empty($userAnswer)) {
            return false;
        }

        // For MCQ, use exact comparison (case-insensitive)
        if ($questionType === 'MCQ') {
            return strtolower(trim($correctAnswer)) === strtolower(trim($userAnswer));
        }

        // For Subjective questions, use fuzzy matching
        return $this->fuzzyCompare($correctAnswer, $userAnswer);
    }

    /**
     * Fuzzy comparison for subjective answers
     * 
     * @param string $correctAnswer
     * @param string $userAnswer
     * @return bool
     */
    private function fuzzyCompare($correctAnswer, $userAnswer)
    {
        // Normalize both answers
        $normalized_correct = $this->normalizeAnswer($correctAnswer);
        $normalized_user = $this->normalizeAnswer($userAnswer);

        // 1. Exact match after normalization
        if ($normalized_correct === $normalized_user) {
            return true;
        }

        // 2. Check if user answer contains all key numbers from correct answer
        if ($this->numbersMatch($correctAnswer, $userAnswer)) {
            // If numbers match, check for partial text match
            if ($this->partialTextMatch($normalized_correct, $normalized_user)) {
                return true;
            }
        }

        // 3. Calculate similarity percentage using Levenshtein distance
        $similarity = $this->calculateSimilarity($normalized_correct, $normalized_user);
        
        // Accept if similarity is >= 85%
        if ($similarity >= 85) {
            return true;
        }

        // 4. Check for common abbreviations and variations
        if ($this->checkCommonVariations($normalized_correct, $normalized_user)) {
            return true;
        }

        return false;
    }

    /**
     * Normalize answer for comparison
     */
    private function normalizeAnswer($answer)
    {
        $answer = strtolower(trim($answer));
        
        // Remove extra whitespace
        $answer = preg_replace('/\s+/', ' ', $answer);
        
        // Remove common punctuation
        $answer = preg_replace('/[.,;:!?\'"]/', '', $answer);
        
        return $answer;
    }

    /**
     * Check if all numbers in correct answer appear in user answer
     */
    private function numbersMatch($correctAnswer, $userAnswer)
    {
        // Extract all numbers from both answers
        preg_match_all('/\d+\.?\d*/', $correctAnswer, $correctNumbers);
        preg_match_all('/\d+\.?\d*/', $userAnswer, $userNumbers);

        if (empty($correctNumbers[0])) {
            return true; // No numbers to match
        }

        if (empty($userNumbers[0])) {
            return false; // User answer has no numbers but correct answer does
        }

        // Check if all correct numbers are in user answer
        foreach ($correctNumbers[0] as $num) {
            if (!in_array($num, $userNumbers[0])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check for partial text match (for cases like "7 minutes" vs "7 min")
     */
    private function partialTextMatch($correctAnswer, $userAnswer)
    {
        // Remove numbers for text comparison
        $correctText = preg_replace('/\d+\.?\d*/', '', $correctAnswer);
        $userText = preg_replace('/\d+\.?\d*/', '', $userAnswer);
        
        $correctText = trim($correctText);
        $userText = trim($userText);

        if (empty($correctText) || empty($userText)) {
            return true;
        }

        // Check if one is contained in the other
        if (strpos($correctText, $userText) !== false || strpos($userText, $correctText) !== false) {
            return true;
        }

        // Check for common word stems (e.g., "minute" and "min")
        $correctWords = explode(' ', $correctText);
        $userWords = explode(' ', $userText);

        foreach ($correctWords as $correctWord) {
            foreach ($userWords as $userWord) {
                if ($this->wordsAreSimilar($correctWord, $userWord)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Calculate similarity percentage between two strings
     */
    private function calculateSimilarity($str1, $str2)
    {
        $maxLength = max(strlen($str1), strlen($str2));
        
        if ($maxLength === 0) {
            return 100;
        }

        $distance = levenshtein($str1, $str2);
        $similarity = (1 - ($distance / $maxLength)) * 100;

        return $similarity;
    }

    /**
     * Check if two words are similar (handles abbreviations)
     */
    private function wordsAreSimilar($word1, $word2)
    {
        // Direct match
        if ($word1 === $word2) {
            return true;
        }

        // Check if one is abbreviation of the other (min length 3)
        if (strlen($word1) >= 3 && strlen($word2) >= 3) {
            if (strpos($word1, $word2) === 0 || strpos($word2, $word1) === 0) {
                return true;
            }
        }

        // Calculate similarity for individual words
        $similarity = $this->calculateSimilarity($word1, $word2);
        return $similarity >= 80;
    }

    /**
     * Check for common variations and abbreviations
     */
    private function checkCommonVariations($correctAnswer, $userAnswer)
    {
        $variations = [
            // Time units
            'minutes' => ['minute', 'min', 'mins'],
            'seconds' => ['second', 'sec', 'secs'],
            'hours' => ['hour', 'hr', 'hrs'],
            'days' => ['day'],
            
            // Distance units
            'kilometers' => ['kilometer', 'km', 'kms'],
            'meters' => ['meter', 'metre', 'm'],
            'miles' => ['mile', 'mi'],
            
            // Weight units
            'kilograms' => ['kilogram', 'kg', 'kgs'],
            'grams' => ['gram', 'g', 'gms'],
            'pounds' => ['pound', 'lb', 'lbs'],
            
            // Common words
            'approximately' => ['approx', 'around', 'about'],
            'percentage' => ['percent', '%'],
        ];

        foreach ($variations as $full => $abbrevs) {
            // Check if full form is in correct answer and any abbreviation is in user answer
            if (strpos($correctAnswer, $full) !== false) {
                foreach ($abbrevs as $abbrev) {
                    if (strpos($userAnswer, $abbrev) !== false) {
                        // Found a matching variation, check the rest
                        $tempCorrect = str_replace($full, $abbrev, $correctAnswer);
                        if ($this->calculateSimilarity($tempCorrect, $userAnswer) >= 85) {
                            return true;
                        }
                    }
                }
            }
            
            // Check reverse (abbreviation in correct, full form in user)
            foreach ($abbrevs as $abbrev) {
                if (strpos($correctAnswer, $abbrev) !== false && strpos($userAnswer, $full) !== false) {
                    $tempCorrect = str_replace($abbrev, $full, $correctAnswer);
                    if ($this->calculateSimilarity($tempCorrect, $userAnswer) >= 85) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    // ================================================================
    // SUBMIT QUIZ ANSWERS (UPDATED)
    // ================================================================
    
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

        $questions = collect($quizSession['questions']);
        $totalQuestions = $questions->count();
        $correctAnswers = 0;
        $results = [];

        foreach ($questions as $question) {
            $questionId = $question['id'];
            $userAnswer = $userAnswers[$questionId] ?? null;
            $correctAnswer = $question['correct_answer'];

            // Use improved comparison method
            $isCorrect = $this->compareAnswers(
                $correctAnswer,
                $userAnswer,
                $question['question_type']
            );

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

        $resultKey = 'quiz_result_' . auth()->id() . '_' . time();
        Cache::put($resultKey, [
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'results' => $results,
            'category_id' => $quizSession['category_id'],
            'difficulty' => $quizSession['difficulty'],
            'completed_at' => now()
        ], now()->addHours(24));

        Cache::forget($sessionKey);

        return response()->json([
            'success' => true,
            'result_key' => $resultKey,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers
        ]);
    }

    // ================================================================
    // GET QUIZ RESULTS
    // ================================================================
    
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