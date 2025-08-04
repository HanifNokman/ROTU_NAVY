<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_datetime',
        'end_datetime',
        'involvement',
        'status'
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
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
}