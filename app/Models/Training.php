<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Training extends Model
{
    use HasFactory;

    /**
     * Relationship: Training has many TrainingAttendances
     */
    public function trainingAttendances()
    {
        return $this->hasMany(TrainingAttendance::class);
    }

    /**
     * Relationships
     */
    public function attendances()
    {
        return $this->hasMany(TrainingAttendance::class);
    }

    public function presentAttendances()
    {
        return $this->hasMany(TrainingAttendance::class)->where('present', true);
    }

    public function absentAttendances()
    {
        return $this->hasMany(TrainingAttendance::class)->where('present', false);
    }

    /**
     * Get attendance statistics
     */
    public function getAttendanceStats(): array
    {
        $total = $this->attendances()->count();
        $present = $this->presentAttendances()->count();
        $absent = $this->absentAttendances()->count();

        return [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'attendance_rate' => $total > 0 ? round(($present / $total) * 100, 2) : 0
        ];
    }
    // ...existing code...

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_datetime',
        'end_datetime',
        'involvement',
        // 'duration_hours', // duration is now auto-calculated
        'allowance_amount',
        'allowance_type',
        'status'
    ];
    /**
     * Get list of time options in HHMMH format for dropdowns (0000H, 0100H, ..., 2300H, 2400H)
     */
    public static function getHourOptions(): array
    {
        $options = [];
        for ($h = 0; $h <= 24; $h++) {
            $label = str_pad($h, 2, '0', STR_PAD_LEFT) . '00H';
            $options[] = $label;
        }
        return $options;
    }

    /**
     * Round a Carbon time to the nearest hour (down if <30min, up if >=30min)
     */
    public static function roundToNearestHour(Carbon $time): Carbon
    {
        $minute = $time->minute;
        if ($minute < 30) {
            return $time->copy()->minute(0)->second(0);
        } else {
            return $time->copy()->addHour()->minute(0)->second(0);
        }
    }

/**
 * Calculate duration in hours between start and end, with min 2, max 10 for single-day
 */
public function calculateRoundedDuration(): ?int
{
    if (!$this->end_datetime) {
        return null;
    }
    
    $start = $this->start_datetime;
    $end = $this->end_datetime;
    
    // Check if training spans multiple days
    $isSingleDay = $start->toDateString() === $end->toDateString();
    
    if (!$isSingleDay) {
        return null; // Multi-day trainings don't have duration_hours
    }
    
    // Single-day training: calculate with min 2, max 10 (rounded to nearest integer)
    $calculatedHours = (int) round($start->diffInHours($end, false));
    return max(2, min(10, $calculatedHours));
}

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'allowance_amount' => 'float',
    ];

    protected $attributes = [
        'status' => 'Active'
    ];

    /**
     * Get formatted start date
     */
    public function getFormattedStartDateAttribute(): string
    {
        return $this->start_datetime->format('M d, Y');
    }

    /**
     * Get formatted start time
     */
    public function getFormattedStartTimeAttribute(): string
    {
        return $this->start_datetime->format('h:i A');
    }

/**
 * Get formatted date range for display
 */
public function getFormattedDateRangeAttribute(): string
{
    if (!$this->end_datetime) {
        return $this->formatted_start_date;
    }
    
    $startDate = $this->start_datetime->format('M d, Y');
    $endDate = $this->end_datetime->format('M d, Y');
    
    // If same day, show only start date
    if ($this->start_datetime->toDateString() === $this->end_datetime->toDateString()) {
        return $startDate;
    }
    
    // If different days, show range
    return $startDate . ' - ' . $endDate;
}

/**
 * Get formatted time range for display
 */
public function getFormattedTimeRangeAttribute(): string
{
    $startTime = $this->start_datetime->format('h:i A');
    
    if (!$this->end_datetime) {
        return $startTime;
    }
    
    // If same day, show time range
    if ($this->start_datetime->toDateString() === $this->end_datetime->toDateString()) {
        return $startTime . ' - ' . $this->end_datetime->format('h:i A');
    }
    
    // If multi-day, show start time only (since it spans days)
    return $startTime;
}

/**
 * Check if training is multi-day
 */
public function getIsMultiDayAttribute(): bool
{
    if (!$this->end_datetime) {
        return false;
    }
    
    return $this->start_datetime->toDateString() !== $this->end_datetime->toDateString();
}

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return match($this->status) {
            'Active' => 'bg-green-100 text-green-800',
            'Completed' => 'bg-gray-100 text-gray-800',
            'Cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-blue-100 text-blue-800'
        };
    }

    /**
     * Calculate duration in hours
     */
    // Deprecated: use calculateRoundedDuration instead
    public function calculateDuration(): ?int
    {
        return $this->calculateRoundedDuration();
    }

    /**
     * Calculate allowance based on duration and type
     */
    public function calculateAllowance(): array
    {
        if (!$this->end_datetime) {
            return ['amount' => 0, 'type' => null];
        }

        $start = $this->start_datetime;
        $end = $this->end_datetime;
        
        // Check if multi-day training
        $isMultiDay = $start->diffInDays($end) >= 1;
        
        if ($isMultiDay) {
            $days = $start->diffInDays($end) + 1; // Include both start and end days
            return [
                'amount' => $days * 50,
                'type' => 'daily'
            ];
        } else {
            $hours = $this->calculateDuration() ?? 2;
            return [
                'amount' => $hours * 8,
                'type' => 'hourly'
            ];
        }
    }

    /**
     * Update duration and allowance
     */
    public function updateDurationAndAllowance(): void
    {
        if ($this->end_datetime) {
            $this->duration_hours = $this->calculateRoundedDuration();
            $allowance = $this->calculateAllowance();
            $this->allowance_amount = $allowance['amount'];
            $this->allowance_type = $allowance['type'];
            $this->save();
        }
    }

    /**
     * Check if training is ongoing today
     */
    public function isOngoingToday(): bool
    {
        $today = Carbon::today();
        $startDate = $this->start_datetime->toDateString();
        $endDate = $this->end_datetime ? $this->end_datetime->toDateString() : $startDate;
        
        return $today->isBetween($startDate, $endDate, true);
    }

    /**
     * Check if training should be visible in "Today's Training"
     */
    public function shouldShowInTodaysTraining(): bool
    {
        $now = Carbon::now();
        $today = $now->toDateString();
        $yesterday = $now->subDay()->toDateString();
        
        $startDate = $this->start_datetime->toDateString();
        $endDate = $this->end_datetime ? $this->end_datetime->toDateString() : $startDate;
        
        // For single day training: show on training day + 1 extra day
        if ($startDate === $endDate) {
            return $today === $startDate || $today === Carbon::parse($startDate)->addDay()->toDateString();
        }
        
        // For multi-day training: show during training + 1 extra day after end
        $visibilityEndDate = Carbon::parse($endDate)->addDay()->toDateString();
        return $today >= $startDate && $today <= $visibilityEndDate;
    }

    /**
     * Scope for active trainings
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    /**
     * Scope for upcoming trainings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>', now());
    }

    /**
     * Scope for today's trainings (visible in Today's Training section)
     */
    public function scopeTodaysTraining($query)
    {
        return $query->where(function ($q) {
            $q->whereRaw('DATE(start_datetime) = CURDATE()')
              ->orWhereRaw('DATE(end_datetime) = CURDATE()')
              ->orWhereRaw('DATE(start_datetime) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)')
              ->orWhereRaw('(start_datetime <= NOW() AND (end_datetime IS NULL OR end_datetime >= DATE_SUB(NOW(), INTERVAL 1 DAY)))');
        });
    }

    // ...existing code...

    // ...existing code...
}