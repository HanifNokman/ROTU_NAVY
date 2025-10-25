<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadetBadge extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadet_id',
        'badge_id',
        'unlocked_at',
        'is_displayed',
        'modal_shown'
    ];

    protected $casts = [
        'unlocked_at' => 'datetime',
        'is_displayed' => 'boolean',
        'modal_shown' => 'boolean'
    ];

    /**
     * Cadet relationship
     */
    public function cadet()
    {
        return $this->belongsTo(Cadet::class);
    }

    /**
     * Badge relationship
     */
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Scope for displayed badges
     */
    public function scopeDisplayed($query)
    {
        return $query->where('is_displayed', true);
    }

    /**
     * Scope for a specific cadet
     */
    public function scopeForCadet($query, $cadetId)
    {
        return $query->where('cadet_id', $cadetId);
    }

    /**
     * Toggle display status
     */
    public function toggleDisplay()
    {
        $this->is_displayed = !$this->is_displayed;
        $this->save();
    }

    /**
     * Get formatted unlock date
     */
    public function getFormattedUnlockDateAttribute()
    {
        return $this->unlocked_at->format('M d, Y');
    }
}
