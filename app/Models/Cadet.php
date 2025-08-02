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
        'current_cgpa',
        'past_cgpa',
        'ic_number',
        'BMI',
        'BMI_update_date',
        'swimming_qualification',
        'service_number',
    ];

    protected $hidden = [
        // Add any fields you want hidden
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'BMI_update_date' => 'datetime',
        'current_cgpa' => 'decimal:2',
        'BMI' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
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

    // Accessors
    public function getIntakeNameAttribute()
    {
        $intakeNumber = 2025 - $this->intake_year + 14;
        return "Intake - {$intakeNumber} ({$this->intake_year})";
    }

    public function getFormattedBmiUpdatedAttribute()
    {
        return $this->BMI_update_date ? $this->BMI_update_date->format('d/m/Y') : 'Not updated';
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
                'label' => "Intake - {$intakeNumber} ({$year})"
            ];
        }
        
        return $intakes;
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
                ->where('status', 'Borrowed');
    }

    public function pastLoans()
    {
        return $this->hasMany(EquipmentLoan::class)
                ->where('status', 'Returned')
                ->orderBy('return_date', 'desc');
    }
}