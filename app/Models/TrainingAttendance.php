<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TrainingAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'cadet_id',
        'present',
        'method',
        'marked_at'
    ];

    protected $casts = [
        'present' => 'boolean',
        'marked_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    /**
     * Scopes
     */
    public function scopePresent($query)
    {
        return $query->where('present', true);
    }

    public function scopeAbsent($query)
    {
        return $query->where('present', false);
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('method', $method);
    }

    /**
     * Mark attendance as present
     */
    public function markPresent($method = 'manual')
    {
        $this->update([
            'present' => true,
            'method' => $method,
            'marked_at' => Carbon::now()
        ]);
    }

    /**
     * Mark attendance as absent
     */
    public function markAbsent($method = 'manual')
    {
        $this->update([
            'present' => false,
            'method' => $method,
            'marked_at' => Carbon::now()
        ]);
    }
}