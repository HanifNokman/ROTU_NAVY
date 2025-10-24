<?php

namespace App\Http\Controllers\Cadet;

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\LearningMaterialCategory;
use App\Models\Instructor;
use App\Models\User;
use App\Models\QuizQuestion;
use App\Models\CadetQuizScore;
use App\Models\PerformanceRating;
use App\Models\CadetLearningMaterialProgress; 
use App\Models\CadetCategoryProgress; 
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

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

        // Only fetch materials if a category is selected
        $materials = collect();
        if ($request->filled('category')) {
            $materials = LearningMaterial::with('category')
                ->where('learning_material_category_id', $request->category)
                ->latest()
                ->get();
        }

        $cadet = auth()->user()->cadet;
        $topScores = [];

        if ($cadet) {
            $topScores = CadetQuizScore::where('cadet_id', $cadet->id)
                ->with('category')
                ->get()
                ->groupBy('learning_material_category_id')
                ->map(function ($scores) {
                    return $scores->sortByDesc('score_percentage')->first();
                })
                ->sortByDesc('score_percentage')
                ->values();
        }

        // Calculate unlocked difficulties for each category
        $unlockedDifficulties = [];
        foreach ($categories as $category) {
            $unlockedDifficulties[$category->id] = $this->getUnlockedDifficulties($cadet->id, $category->id);
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
            'Kpt', 'Kdr', 'Lt.Kdr', 'Lt', 'Lt.Dya', 'Lt.M',
            'PWII', 'PWI', 'BK', 'BM', 'LK', 'LKI', 'LKII'
        ];

        $instructors = $instructors->sortBy(function($instructor) use ($rankOrder) {
            $rank = $instructor->rank ?? '';
            $index = array_search($rank, $rankOrder);
            return $index !== false ? $index : count($rankOrder);
        });

        // Get progress data for the cadet
        $progressData = $this->getProgressData($cadet);

        return view('cadet.learning_hub', [
            'categories' => $categories,
            'materials' => $materials,
            'instructors' => $instructors,
            'selectedCategory' => $request->get('category'),
            'selectedInstructorStatus' => $request->get('instructor_status'),
            'topScores' => $topScores,
            'unlockedDifficulties' => $unlockedDifficulties,
            'progressData' => $progressData
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
    // GET UNLOCKED DIFFICULTIES FOR CATEGORY (AJAX)
    // ================================================================

    public function getUnlockedDifficultiesAjax(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|exists:learning_material_categories,id'
        ]);

        $categoryId = $request->category_id;
        $cadet = auth()->user()->cadet;

        if (!$cadet) {
            return response()->json([
                'success' => false,
                'message' => 'Cadet profile not found.'
            ], 404);
        }

        $unlockedDifficulties = $this->getUnlockedDifficulties($cadet->id, $categoryId);

        return response()->json([
            'success' => true,
            'unlocked_difficulties' => $unlockedDifficulties
        ]);
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

        // Check difficulty progression requirements
        if ($categoryId !== null) {
            $cadet = auth()->user()->cadet;
            if (!$cadet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cadet profile not found.'
                ], 404);
            }

            $unlockedDifficulties = $this->getUnlockedDifficulties($cadet->id, $categoryId);

            if (!in_array($difficulty, $unlockedDifficulties)) {
                $requiredDifficulty = $this->getRequiredDifficulty($difficulty);
                return response()->json([
                    'success' => false,
                    'message' => "You must achieve at least 80% in {$requiredDifficulty} difficulty before accessing {$difficulty} difficulty."
                ], 403);
            }
        }

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
            // Time units (basic - commonly used in military context)
            'minutes' => ['minute', 'min', 'mins'],
            'seconds' => ['second', 'sec', 'secs'],
            'hours' => ['hour', 'hr', 'hrs'],
            
            // Naval distance units
            'nautical miles' => ['nautical mile', 'nm', 'nmi', 'nmile', 'n mile', 'n miles'],
            'kilometers' => ['kilometer', 'kilometre', 'km', 'kms'],
            'meters' => ['meter', 'metre', 'm', 'mtr'],
            'feet' => ['foot', 'ft'],
            
            // Naval speed units
            'knots' => ['knot', 'kn', 'kt', 'kts', 'nautical miles per hour'],
            'kilometers per hour' => ['kilometer per hour', 'kmh', 'km/h', 'kph', 'kmph'],
            
            // Common phrases
            'approximately' => ['approx', 'around', 'about', 'roughly'],
            'percentage' => ['percent', '%', 'pct'],
            
            // ============================================
            // MALAYSIAN NAVY RANKS (OFFICER)
            // ============================================
            'laksamana' => ['laksamana', 'laks', 'admiral'],
            'laksamana madya' => ['laksamana madya', 'laks madya', 'vice admiral'],
            'laksamana muda' => ['laksamana muda', 'laks muda', 'rear admiral'],
            'laksamana pertama' => ['laksamana pertama', 'laks pertama', 'first admiral'],
            'kapten' => ['kapten', 'kpt', 'captain'],
            'komander' => ['komander', 'kdr', 'commander'],
            'leftenant komander' => ['leftenant komander', 'lt kdr', 'lt cdr', 'lieutenant commander'],
            'leftenant' => ['leftenant', 'lt', 'lieutenant'],
            'leftenant madya' => ['leftenant madya', 'lt dya', 'sub lieutenant'],
            'leftenant muda' => ['leftenant muda', 'lt m', 'acting sub lieutenant'],
            
            // MALAYSIAN NAVY RANKS (ENLISTED)
            'pegawai waran satu' => ['pegawai waran satu', 'pw1', 'pwi', 'warrant officer 1'],
            'pegawai waran dua' => ['pegawai waran dua', 'pw2', 'pwii', 'warrant officer 2'],
            'bintara kanan' => ['bk', 'cpo', 'chief petty officer'],
            'bintara muda' => ['bm', 'po', 'petty officer'],
            'laskar kanan' => ['lk', 'leading', 'leading rate'],
            'laskar kelas pertama' => ['laskar kelas satu', 'lk1', 'lki',  'able rate'],
            'laskar kanan kedua' => ['lascar kanan dua', 'lk2', 'lkii', 'ordinary rate'],

            // ============================================
            // MALAYSIAN ARMY RANKS (OFFICER)
            // ============================================
            'jeneral' => ['jeneral', 'jen', 'general'],
            'leftenan jeneral' => ['leftenan jeneral', 'lt jen', 'lieutenant general'],
            'mejar jeneral' => ['mejar jeneral', 'mej jen', 'major general'],
            'brigedier jeneral' => ['brigedier jeneral', 'brig jen', 'brigadier general'],
            'kolonel' => ['kolonel', 'kol', 'colonel'],
            'leftenan kolonel' => ['leftenan kolonel', 'lt kol', 'lieutenant colonel'],
            'mejar' => ['mejar', 'mej', 'major'],
            'kapten (army)' => ['kapten tentera darat', 'capt', 'captain army'],
            'leftenan (army)' => ['leftenan tentera darat', 'lt tentera darat', 'lieutenant army'],
            'leftenan muda (army)' => ['leftenan muda tentera darat', 'lt muda', 'second lieutenant'],

            // MALAYSIAN ARMY RANKS (ENLISTED)
            'sarjan mejar' => ['sarjan mejar', 'sj mej', 'sergeant major'],
            'staf sarjan' => ['staff sarjan', 'sj kanan', 'staff sergeant'],
            'sarjan' => ['sarjan', 'sj', 'sergeant'],
            'koporal' => ['koporal', 'kpl', 'corporal'],
            'lans koporal' => ['lans koporal', 'l/kpl', 'lance corporal'],
            'prebet' => ['prebet', 'pbt', 'private'],

            // ============================================
            // MALAYSIAN AIR FORCE RANKS (OFFICER)
            // ============================================
            'jeneral (air force)' => ['jeneral tudm', 'jen tudm', 'air chief marshal'],
            'leftenan jeneral (air force)' => ['leftenan jeneral tudm', 'lt jen tudm', 'air marshal'],
            'mejar jeneral (air force)' => ['mejar jeneral tudm', 'mej jen tudm', 'air vice marshal'],
            'brigedier jeneral (air force)' => ['brigedier jeneral tudm', 'brig jen tudm', 'air commodore'],
            'kolonel (air force)' => ['kolonel tudm', 'kol tudm', 'group captain'],
            'leftenan kolonel (air force)' => ['leftenan kolonel tudm', 'lt kol tudm', 'wing commander'],
            'mejar (air force)' => ['mejar tudm', 'mej tudm', 'squadron leader'],
            'kapten (air force)' => ['kapten tudm', 'flight lieutenant'],
            'leftenan (air force)' => ['leftenan tudm', 'flying officer'],
            'leftenan muda (air force)' => ['leftenan muda tudm', 'lt muda tudm', 'pilot officer'],

            // MALAYSIAN AIR FORCE RANKS (ENLISTED)
            'pegawai waran (air force)' => ['pegawai waran tudm', 'pw tudm', 'warrant officer tudm'],
            'sarjan mejar (air force)' => ['sarjan mejar tudm', 'sj mej tudm', 'flight sergeant major'],
            'sarjan kanan (air force)' => ['sarjan kanan tudm', 'sj kanan tudm', 'flight sergeant'],
            'sarjan (air force)' => ['sarjan tudm', 'sj tudm', 'sergeant tudm'],
            'koporal (air force)' => ['koporal tudm', 'kpl tudm', 'corporal tudm'],
            'lans koporal (air force)' => ['lans koporal tudm', 'l/kpl tudm', 'lance corporal tudm'],

            // ============================================
            // EXPERTISE BRANCHES
            // ============================================

            // Cawangan Bekalan & Urusetia (Supply & Administrative Branches)
            'juruteknik taktikal peperangan' => ['jtp', 'tactical warfare technician'],
            'komunikasi' => ['kom', 'communications specialist'],
            'hidrografi' => ['hd', 'hydrography', 'hydrographic'],
            'pusat latihan tentera laut' => ['pltl', 'navy training center'],
            'peluru dan ranjau' => ['plm', 'ammunition and mines'],
            'kesihatan jasmani' => ['kjm', 'physical fitness', 'physical training'],
            'perbekalan bawah permukaan senjata' => ['pbs', 'underwater weapons supply'],
            'perbekalan bawah permukaan kawalan' => ['pbk', 'underwater control supply'],
            'perbekalan atas permukaan' => ['pap', 'surface supply'],

            // Cawangan Kejuruteraan (Engineering Branches)
            'teknikal logistik' => ['tnl', 'technical logistics'],
            'pentadbiran dan kewangan' => ['pnk', 'administration and finance'],
            'pancaragam' => ['pgm', 'ceremonial drill', 'marching band'],
            'bendari' => ['bdt', 'supply technician'],
            'petugas wisma pegawai' => ['pwp', 'officers mess attendant'],

            // Cawangan Kejuruteraan (Engineering Technical Branches)
            'teknikal sistem elektrik radio dan radar' => ['tlr', 'electrical radio and radar systems'],
            'teknikal sistem marin srimala' => ['tms', 'marine systems srimala'],
            'teknikal sistem marin kuasa gerak' => ['tmk', 'marine propulsion systems'],
            'teknikal sistem elektrik kuasa dan senjata' => ['tls', 'electrical weapons and power systems'],
            
            // ============================================
            // NAVAL VESSEL TYPES
            // ============================================
            'kapal angkatan tentera laut' => ['kld', 'kd', 'ka', 'royal malaysian ship'],
            'frigate' => ['frig', 'ffg'],
            'corvette' => ['corv', 'fs'],
            'patrol vessel' => ['pv', 'patrol boat', 'pb', 'ngpv'],
            'fast attack craft' => ['fac', 'missile boat'],
            'mine countermeasure vessel' => ['mcmv', 'mine hunter', 'minesweeper'],
            'submarine' => ['sub', 'ss', 'ssk'],
            'auxiliary ship' => ['aux', 'support vessel', 'ka'],
            'landing craft' => ['lc', 'landing ship'],
            
            // ============================================
            // SHIP DIRECTIONS & POSITIONS
            // ============================================
            'starboard' => ['stbd', 'stb', 'right side'],
            'port' => ['port side', 'ps', 'left side'],
            'bow' => ['forward', 'fwd', 'fore', 'front'],
            'stern' => ['aft', 'rear', 'back'],
            'amidships' => ['midship', 'amid', 'center'],
            'forward' => ['fwd', 'fore'],
            'aft' => ['rear', 'astern'],
            
            // ============================================
            // SHIP COMPARTMENTS & AREAS
            // ============================================
            'bridge' => ['brdg', 'command bridge', 'wheelhouse'],
            'engine room' => ['er', 'machinery space'],
            'operations room' => ['ops room', 'or', 'combat information center', 'cic'],
            'mess deck' => ['mess', 'galley area'],
            'quarterdeck' => ['qd', 'quarter deck'],
            'weather deck' => ['upper deck', 'open deck'],
            
            // ============================================
            // NAVAL OPERATIONS & TACTICS
            // ============================================
            'anti-submarine warfare' => ['asw', 'submarine warfare'],
            'anti-air warfare' => ['aaw', 'air defense'],
            'anti-surface warfare' => ['asuw', 'surface warfare'],
            'electronic warfare' => ['ew', 'electronic countermeasures', 'ecm'],
            'mine warfare' => ['mw', 'mine operations'],
            'amphibious warfare' => ['amph ops', 'amphibious operations'],
            'naval gunfire support' => ['ngs', 'ngfs', 'gunfire support'],
            'search and rescue' => ['sar', 'search rescue'],
            'maritime security operations' => ['mso', 'maritime security'],
            'freedom of navigation' => ['fonops', 'fon', 'navigation operations'],
            
            // ============================================
            // NAVIGATION & SEAMANSHIP
            // ============================================
            'navigation' => ['nav', 'navig'],
            'heading' => ['hdg', 'course'],
            'bearing' => ['brg', 'azimuth'],
            'distance' => ['dist', 'range'],
            'latitude' => ['lat'],
            'longitude' => ['long', 'lon'],
            'position' => ['pos', 'location'],
            'chart' => ['nautical chart', 'sea chart'],
            'dead reckoning' => ['dr', 'ded reckoning'],
            'estimated position' => ['ep', 'est pos'],
            
            // ============================================
            // COMMUNICATIONS
            // ============================================
            'communications' => ['comms', 'comm', 'coms'],
            'radio' => ['r/t', 'wireless'],
            'signal' => ['sig', 'sigs'],
            'message' => ['msg', 'mssg'],
            'transmission' => ['xmit', 'tx'],
            'reception' => ['rx', 'receive'],
            'frequency' => ['freq', 'channel', 'ch'],
            
            // ============================================
            // WEAPONS & ARMAMENT
            // ============================================
            'surface-to-air missile' => ['sam', 'surface to air'],
            'surface-to-surface missile' => ['ssm', 'anti-ship missile', 'ashm'],
            'torpedo' => ['torp', 'fish'],
            'depth charge' => ['dc', 'ash can'],
            'naval gun' => ['gun', 'deck gun', 'main gun'],
            'close-in weapon system' => ['ciws', 'point defense'],
            'vertical launch system' => ['vls', 'vertical launcher'],
            
            // ============================================
            // SENSORS & DETECTION
            // ============================================
            'radar' => ['radio detection and ranging'],
            'sonar' => ['sound navigation and ranging', 'asdic'],
            'electronic support measures' => ['esm', 'radar warning receiver', 'rwr'],
            'infrared' => ['ir', 'thermal'],
            'identification friend or foe' => ['iff', 'transponder'],
            
            // ============================================
            // COMMAND & CONTROL
            // ============================================
            'commanding officer' => ['co', 'captain', 'skipper'],
            'executive officer' => ['xo', 'exec', 'first officer'],
            'officer of the watch' => ['oow', 'officer of watch', 'deck officer'],
            'operations' => ['ops', 'oper'],
            'headquarters' => ['hq', 'hdqtrs', 'command center'],
            'chain of command' => ['coc', 'command structure'],
            
            // ============================================
            // PROCEDURES & PROTOCOLS
            // ============================================
            'standard operating procedure' => ['sop', 'standard procedure'],
            'rules of engagement' => ['roe', 'engagement rules'],
            'general quarters' => ['gq', 'action stations', 'battle stations'],
            'damage control' => ['dc', 'damage con'],
            'man overboard' => ['mob', 'person overboard', 'pob'],
            'emergency' => ['emerg', 'emer'],
            
            // ============================================
            // MALAYSIAN MILITARY ORGANIZATIONS
            // ============================================
            'royal malaysian navy' => ['rmn', 'tldm', 'tentera laut diraja malaysia'],
            'royal malaysian air force' => ['rmaf', 'tudm', 'tentera udara diraja malaysia'],
            'malaysian army' => ['tentera darat malaysia', 'army'],
            'malaysian armed forces' => ['maf', 'atm', 'angkatan tentera malaysia'],
            'ministry of defence' => ['mindef', 'mod', 'kementerian pertahanan'],
            'naval base' => ['pangkalan tldm', 'base'],
            'fleet' => ['armada', 'flotilla'],
            
            // ============================================
            // CARDINAL DIRECTIONS (Navigation)
            // ============================================
            'north' => ['n'],
            'south' => ['s'],
            'east' => ['e'],
            'west' => ['w'],
            'northeast' => ['ne', 'north-east'],
            'northwest' => ['nw', 'north-west'],
            'southeast' => ['se', 'south-east'],
            'southwest' => ['sw', 'south-west'],
            
            // ============================================
            // WATCH & TIME SYSTEMS
            // ============================================
            'coordinated universal time' => ['utc', 'zulu time', 'z time', 'gmt'],
            'local time' => ['lt', 'local'],
            'watch' => ['duty period', 'shift'],
            
            // ============================================
            // MARITIME TERMS
            // ============================================
            'alongside' => ['berth', 'pier side', 'docked'],
            'underway' => ['under way', 'at sea', 'steaming'],
            'anchored' => ['at anchor', 'moored'],
            'port call' => ['visit', 'port visit'],
            'deployment' => ['deploy', 'deployment period'],
            'exercise' => ['ex', 'drill', 'training exercise'],
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
    // CALCULATE POINTS BASED ON DIFFICULTY
    // ================================================================
    
    /**
     * Calculate points based on difficulty and score
     * 
     * @param string $difficulty
     * @param float $scorePercentage
     * @return int
     */
    private function calculatePoints($difficulty, $scorePercentage)
    {
        // Only award points if the cadet passed (score >= 60%)
        if ($scorePercentage < 60) {
            return 0;
        }

        // Points based on difficulty
        switch ($difficulty) {
            case 'easy':
                return 10;
            case 'medium':
                return 20;
            case 'hard':
                return 30;
            default:
                return 0;
        }
    }

    // ================================================================
    // SUBMIT QUIZ ANSWERS
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

        $scorePercentage = round(($correctAnswers / $totalQuestions) * 100, 2);
        $categoryId = $quizSession['category_id'];
        $difficulty = $quizSession['difficulty'];

        // Get the cadet_id from the authenticated user
        $wasUpdated = false;
        $newPoints = 0;

        // Only store score if category is selected (not null)
        if ($categoryId !== null) {
            $cadet = auth()->user()->cadet;
            
            if (!$cadet) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cadet profile not found.'
                ], 404);
            }

            $cadetId = $cadet->id;
            $newPoints = $this->calculatePoints($difficulty, $scorePercentage);

            $existingScore = CadetQuizScore::where('cadet_id', $cadetId)
                ->byCategory($categoryId)
                ->first();

            if ($existingScore) {
                $difficultyWeight = ['easy' => 1, 'medium' => 2, 'hard' => 3];
                $existingDifficultyWeight = $difficultyWeight[$existingScore->difficulty] ?? 0;
                $newDifficultyWeight = $difficultyWeight[$difficulty] ?? 0;
                
                $shouldUpdate = false;
                
                if ($newDifficultyWeight > $existingDifficultyWeight) {
                    $shouldUpdate = true;
                } elseif ($newDifficultyWeight === $existingDifficultyWeight && $scorePercentage > $existingScore->score_percentage) {
                    $shouldUpdate = true;
                }
                
                if ($shouldUpdate) {
                    $existingScore->update([
                        'difficulty' => $difficulty,
                        'score_percentage' => $scorePercentage,
                        'total_questions' => $totalQuestions,
                        'correct_answers' => $correctAnswers,
                        'completed_at' => now()
                    ]);
                    $wasUpdated = true;
                }
            } else {
                CadetQuizScore::create([
                    'cadet_id' => $cadetId,
                    'learning_material_category_id' => $categoryId,
                    'score_percentage' => $scorePercentage,
                    'difficulty' => $difficulty,
                    'total_questions' => $totalQuestions,
                    'correct_answers' => $correctAnswers,
                    'completed_at' => now()
                ]);
                $wasUpdated = true;
            }

            if ($wasUpdated) {
                $performanceRating = PerformanceRating::getOrCreateForCadet($cadetId);
                $performanceRating->updateQuizPoints();
            }
        }

        // Store results in cache for viewing
        $resultKey = 'quiz_result_' . auth()->id() . '_' . time();
        Cache::put($resultKey, [
            'score' => $scorePercentage,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'results' => $results,
            'category_id' => $categoryId,
            'difficulty' => $difficulty,
            'points_awarded' => $newPoints,
            'was_updated' => $wasUpdated,
            'completed_at' => now(),
            'is_practice' => $categoryId === null // ADD THIS LINE
        ], now()->addHours(value: 24));

        Cache::forget($sessionKey);

        return response()->json([
            'success' => true,
            'result_key' => $resultKey,
            'score' => $scorePercentage,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'points_awarded' => $newPoints,
            'was_updated' => $wasUpdated,
            'is_practice' => $categoryId === null // ADD THIS LINE
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

    // ================================================================
    // GET TOP SCORES (AJAX)
    // ================================================================

    public function getTopScores()
    {
        $cadet = auth()->user()->cadet;

        if (!$cadet) {
            return response()->json([
                'success' => false,
                'message' => 'Cadet profile not found.'
            ], 404);
        }

        $topScores = CadetQuizScore::where('cadet_id', $cadet->id)
            ->with('category')
            ->get()
            ->groupBy('learning_material_category_id')
            ->map(function ($scores) {
                return $scores->sortByDesc('score_percentage')->first();
            })
            ->sortByDesc('score_percentage')
            ->values()
            ->map(function ($score) {
                return [
                    'category_name' => $score->category->name ?? 'General Quiz',
                    'difficulty' => $score->difficulty,
                    'score_percentage' => $score->score_percentage,
                    'correct_answers' => $score->correct_answers,
                    'total_questions' => $score->total_questions,
                    'completed_at' => $score->completed_at->toISOString()
                ];
            });

        return response()->json($topScores);
    }

    /**
     * Track when a material is started
     */
        public function startMaterial(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:learning_materials,id'
        ]);

        $cadet = auth()->user()->cadet;
        if (!$cadet) {
            return response()->json(['success' => false, 'message' => 'Cadet profile not found'], 404);
        }

        $progress = \App\Models\CadetLearningMaterialProgress::firstOrCreate(
            [
                'cadet_id' => $cadet->id,
                'learning_material_id' => $request->material_id
            ],
            [
                'is_completed' => false,
                'time_spent_seconds' => 0
            ]
        );

        $progress->markAsStarted();

        return response()->json([
            'success' => true,
            'progress' => $progress
        ]);
    }

    /**
     * Mark material as completed
     */
    public function completeMaterial(Request $request)
    {
        $request->validate([
            'material_id' => 'required|exists:learning_materials,id',
            'time_spent' => 'nullable|integer|min:0'
        ]);

        $cadet = auth()->user()->cadet;
        if (!$cadet) {
            return response()->json(['success' => false, 'message' => 'Cadet profile not found'], 404);
        }

        $progress = \App\Models\CadetLearningMaterialProgress::where('cadet_id', $cadet->id)
            ->where('learning_material_id', $request->material_id)
            ->first();

        if (!$progress) {
            // Create if doesn't exist
            $progress = \App\Models\CadetLearningMaterialProgress::create([
                'cadet_id' => $cadet->id,
                'learning_material_id' => $request->material_id,
                'is_completed' => false,
                'time_spent_seconds' => 0
            ]);
        }

        if ($request->filled('time_spent')) {
            $progress->updateTimeSpent($request->time_spent);
        }

        $progress->markAsCompleted();

        return response()->json([
            'success' => true,
            'message' => 'Material marked as completed',
            'progress' => $progress
        ]);
    }

    /**
     * Get cadet's progress for all categories
     */
    public function getProgress()
    {
        try {
            $cadet = auth()->user()->cadet;
            if (!$cadet) {
                return response()->json(['success' => false, 'message' => 'Cadet profile not found'], 404);
            }

            $categoryProgress = \App\Models\CadetCategoryProgress::where('cadet_id', $cadet->id)
                ->with('category')
                ->get();

            $materialProgress = \App\Models\CadetLearningMaterialProgress::where('cadet_id', $cadet->id)
                ->get()
                ->pluck('is_completed', 'learning_material_id')
                ->toArray();

            return response()->json([
                'success' => true,
                'category_progress' => $categoryProgress,
                'material_progress' => $materialProgress
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching learning progress: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error fetching progress',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ================================================================
    // Helper Methods for Difficulty Progression
    // ================================================================

    /**
     * Get unlocked difficulties for a cadet in a specific category
     * If categoryId is null (practice mode), all difficulties are unlocked
     */
    private function getUnlockedDifficulties($cadetId, $categoryId)
    {
        // Practice mode - all difficulties unlocked
        if (!$categoryId) {
            return ['easy', 'medium', 'hard'];
        }

        $unlocked = ['easy']; // Easy is always unlocked

        // Get scores for the specific category
        $categoryScores = CadetQuizScore::where('cadet_id', $cadetId)
            ->where('learning_material_category_id', $categoryId)
            ->get();

        // Check for passed difficulties (>=80%) and unlock progressively
        $easyScore = $categoryScores->where('difficulty', 'easy')
            ->sortByDesc('score_percentage')
            ->first();
        $mediumScore = $categoryScores->where('difficulty', 'medium')
            ->sortByDesc('score_percentage')
            ->first();
        $hardScore = $categoryScores->where('difficulty', 'hard')
            ->sortByDesc('score_percentage')
            ->first();

        // Progressive unlocking logic:
        // - Easy is always unlocked
        // - If easy is passed (>=80%), unlock easy and medium
        // - If medium is passed (>=80%), unlock easy, medium, and hard
        // - If hard is passed (>=80%), unlock all difficulties

        if ($hardScore && $hardScore->score_percentage >= 80) {
            $unlocked = ['easy', 'medium', 'hard'];
        }
        elseif ($mediumScore && $mediumScore->score_percentage >= 80) {
            $unlocked = ['easy', 'medium', 'hard'];
        }
        elseif ($easyScore && $easyScore->score_percentage >= 80) {
            $unlocked = ['easy', 'medium'];
        }
        // If nothing is passed, only easy is unlocked

        return $unlocked;
    }

    /**
     * Get the required difficulty that must be passed to unlock the given difficulty
     */
    private function getRequiredDifficulty($difficulty)
    {
        switch ($difficulty) {
            case 'medium':
                return 'easy';
            case 'hard':
                return 'medium';
            default:
                return 'easy';
        }
    }

    /**
     * Get progress data for the cadet across all categories
     */
    private function getProgressData($cadet)
    {
        if (!$cadet) {
            return [
                'overall_progress' => 0,
                'category_progress' => [],
                'total_materials' => 0,
                'completed_materials' => 0
            ];
        }

        $categories = LearningMaterialCategory::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('quiz_questions')
                ->whereColumn('quiz_questions.category_id', 'learning_material_categories.id')
                ->where('status', 'active');
        })->get();

        $totalMaterials = 0;
        $completedMaterials = 0;
        $categoryProgress = [];

        foreach ($categories as $category) {
            $materialsInCategory = LearningMaterial::where('learning_material_category_id', $category->id)->get();
            $totalMaterials += $materialsInCategory->count();

            $completedInCategory = 0;
            foreach ($materialsInCategory as $material) {
                if ($material->isCompletedBy($cadet->id)) {
                    $completedInCategory++;
                    $completedMaterials++;
                }
            }

            $categoryProgress[$category->id] = [
                'category_name' => $category->name,
                'total_materials' => $materialsInCategory->count(),
                'completed_materials' => $completedInCategory,
                'percentage' => $materialsInCategory->count() > 0 ? round(($completedInCategory / $materialsInCategory->count()) * 100, 1) : 0
            ];
        }

        $overallProgress = $totalMaterials > 0 ? round(($completedMaterials / $totalMaterials) * 100, 1) : 0;

        return [
            'overall_progress' => $overallProgress,
            'category_progress' => $categoryProgress,
            'total_materials' => $totalMaterials,
            'completed_materials' => $completedMaterials
        ];
    }
}
