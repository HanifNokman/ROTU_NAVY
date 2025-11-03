<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Cadet extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'phone_number',
        'gender',
        'bank_account_number',
        'rank',
        'position',
        'profile_pic',
        'intake_year',
        'matric_no',
        'faculty',
        'course',
        'current_cgpa',
        'past_cgpa',
        'ic_number',
        'BMI',
        'BMI_update_date',
        'swimming_qualification',
        'swimming_pass_date',
        'ttp_date',
        'insurance_number',
        'service_number',
        'cadet_status',
        'daily_duty_count',
        'is_best_cadet',
        'is_best_academic',
    ];

    protected $hidden = [
        // Add any fields you want hidden
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'BMI_update_date' => 'datetime',
        'swimming_pass_date' => 'datetime',
        'ttp_date' => 'datetime',
        'current_cgpa' => 'decimal:2',
        'BMI' => 'decimal:1',
        'is_best_cadet' => 'boolean',
        'is_best_academic' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Performance rating relationship
     */
    public function performanceRating()
    {
        return $this->hasOne(PerformanceRating::class);
    }

    /**
     * Training attendance relationship
     */
    public function trainingAttendances()
    {
        return $this->hasMany(TrainingAttendance::class);
    }

    /**
     * Get present attendances only
     */
    public function presentAttendances()
    {
        return $this->hasMany(TrainingAttendance::class)->where('present', true);
    }

    /**
     * Get absent attendances only
     */
    public function absentAttendances()
    {
        return $this->hasMany(TrainingAttendance::class)->where('present', false);
    }

    /**
     * Learning material progress relationship
     */
    public function learningMaterialProgress()
    {
        return $this->hasMany(CadetLearningMaterialProgress::class);
    }

    /**
     * Completed learning materials
     */
    public function completedLearningMaterials()
    {
        return $this->hasMany(CadetLearningMaterialProgress::class)
            ->where('is_completed', true);
    }

    /**
     * Category progress relationship
     */
    public function categoryProgress()
    {
        return $this->hasMany(CadetCategoryProgress::class);
    }

    /**
     * Quiz scores relationship
     */
    public function quizScores()
    {
        return $this->hasMany(CadetQuizScore::class);
    }

    public function cadetSizes()
    {
        return $this->hasMany(CadetSize::class);
    }

    public function equipmentLoans()
    {
        return $this->hasMany(EquipmentLoan::class);
    }

    public function activeLoans()
    {
        return $this->hasMany(EquipmentLoan::class)
                ->whereIn('status', ['Borrowed', 'Pending Return']);
    }

    public function pastLoans()
    {
        return $this->hasMany(EquipmentLoan::class)
                ->where('status', 'Returned')
                ->orderBy('return_date', 'desc');
    }

    /**
     * Cadet badges relationship (pivot table)
     */
    public function cadetBadges()
    {
        return $this->hasMany(CadetBadge::class);
    }

    /**
     * Displayed badges only
     */
    public function displayedBadges()
    {
        return $this->hasMany(CadetBadge::class)->where('is_displayed', true);
    }

    /**
     * Badges relationship (many-to-many through cadet_badges pivot)
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'cadet_badges')
            ->withPivot('unlocked_at', 'is_displayed')
            ->withTimestamps();
    }

    // Scopes for filtering
    public function scopeByIntake($query, $intakeYear)
    {
        return $query->where('intake_year', $intakeYear);
    }

    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function scopeBySwimmingQualification($query, $status)
    {
        return $query->where('swimming_qualification', $status);
    }

    public function scopeRankHoldersOnly($query)
    {
        return $query->whereNotIn('position', ['Normal Cadet', null]);
    }

    public function scopeHighBMI($query)
    {
        return $query->where('BMI', '>', 26.9);
    }

    public function scopeLowBMI($query)
    {
        return $query->where('BMI', '<', 18.0);
    }

    /**
     * Scope to get cadets with training attendance stats
     */
    public function scopeWithAttendanceStats($query, $trainingId = null)
    {
        $query->withCount([
            'trainingAttendances',
            'presentAttendances',
            'absentAttendances'
        ]);

        if ($trainingId) {
            $query->with(['trainingAttendances' => function($q) use ($trainingId) {
                $q->where('training_id', $trainingId);
            }]);
        }

        return $query;
    }

    /**
     * Scope to get cadets with learning progress stats
     */
    public function scopeWithLearningProgressStats($query)
    {
        return $query->withCount([
            'learningMaterialProgress',
            'completedLearningMaterials',
            'categoryProgress'
        ]);
    }

    // Accessors
    public function getIntakeNameAttribute()
    {
        $intakeNumber = 2025 - $this->intake_year + 14;
        return "Intake - {$intakeNumber} ({$this->intake_year})";
    }

    /**
     * Get intake label in the format used by training involvement
     */
    public function getIntakeLabelAttribute()
    {
        $intakeNumber = 2025 - $this->intake_year + 14;
        return "Intake - {$intakeNumber}";
    }

    public function getFormattedBmiUpdatedAttribute()
    {
        return $this->BMI_update_date ? $this->BMI_update_date->format('d/m/Y') : 'Not updated';
    }

    /**
     * Get full name from user relationship
     */
    public function getFullNameAttribute()
    {
        return $this->user->name ?? 'Unknown';
    }

    /**
     * Get attendance percentage for a specific training or overall
     */
    public function getAttendancePercentage($trainingId = null)
    {
        if ($trainingId) {
            $attendance = $this->trainingAttendances()->where('training_id', $trainingId)->first();
            return $attendance && $attendance->present ? 100 : 0;
        }

        $total = $this->trainingAttendances()->count();
        $present = $this->presentAttendances()->count();
        
        return $total > 0 ? round(($present / $total) * 100, 1) : 0;
    }

    /**
     * Get overall learning progress percentage
     */
    public function getLearningProgressPercentage()
    {
        $categoryProgresses = $this->categoryProgress;
        
        if ($categoryProgresses->isEmpty()) {
            return 0;
        }

        $totalProgress = $categoryProgresses->sum('progress_percentage');
        $averageProgress = $totalProgress / $categoryProgresses->count();
        
        return round($averageProgress, 1);
    }

    /**
     * Get completed materials count
     */
    public function getCompletedMaterialsCount()
    {
        return $this->completedLearningMaterials()->count();
    }

    /**
     * Get total materials count across all categories
     */
    public function getTotalAvailableMaterialsCount()
    {
        return \App\Models\LearningMaterial::count();
    }

    // Static methods
    public static function getRecentIntakes($count = 4)
    {
        $currentYear = Carbon::now()->year;
        $intakes = [];
        
        for ($i = 0; $i < $count; $i++) {
            $year = $currentYear - $i;
            $intakeNumber = 14 - $i;
            $intakes[] = [
                'year' => $year,
                'label' => "Intake - {$intakeNumber} ({$year})",
                'short_label' => "Intake - {$intakeNumber}" // ADDED FOR ATTENDANCE COMPATIBILITY
            ];
        }
        
        return $intakes;
    }

    /**
     * Get cadets grouped by intake for attendance purposes
     */
    public static function getByIntakesForAttendance($intakeNumbers)
    {
        $result = [];
        
        foreach ($intakeNumbers as $intakeData) {
            $cadets = static::byIntake($intakeData['year'])
                ->with('user')
                ->orderBy('service_number')
                ->orderBy('matric_no')
                ->get();

            if ($cadets->count() > 0) {
                $result[] = [
                    'intake' => $intakeData,
                    'cadets' => $cadets
                ];
            }
        }

        return $result;
    }

    public static function getPositions()
    {
        return [
            'CO' => 'CO Intake',
            'Thana' => 'Thana',
            'Zayn' => 'Zayn',
            'PMC' => 'PMC',
            'Normal' => 'Normal Cadet'
        ];
    }

    public static function getSwimmingStatuses()
    {
        return [
            'Pass' => 'Pass',
            'In Progress' => 'In Progress',
            'Fail' => 'Fail'
        ];
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($cadet) {
            // Create performance rating entry when cadet is created
            PerformanceRating::create([
                'cadet_id' => $cadet->id,
                'attendance_points' => 0,
                'quiz_points' => 0,
                'learning_progress_points' => 0,
                'duty_points' => 0,
                'academic_points' => 0,
                'position_bonus_points' => 0,
                'total_points' => 0,
                'rating' => '⭐☆☆☆☆',
                'updated_at' => now()
            ]);
        });
    }
}