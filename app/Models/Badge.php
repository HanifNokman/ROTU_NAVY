<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'unlock_criteria',
        'category',
        'rarity_level',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rarity_level' => 'integer'
    ];

    /**
     * Cadet badges relationship
     */
    public function cadetBadges()
    {
        return $this->hasMany(CadetBadge::class);
    }

    /**
     * Cadets who have this badge
     */
    public function cadets()
    {
        return $this->belongsToMany(Cadet::class, 'cadet_badges')
            ->withPivot('unlocked_at', 'is_displayed')
            ->withTimestamps();
    }

    /**
     * Scope for active badges
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope by rarity
     */
    public function scopeByRarity($query, $rarity)
    {
        return $query->where('rarity_level', $rarity);
    }

    /**
     * Get rarity label
     */
    public function getRarityLabelAttribute()
    {
        $rarities = [
            1 => 'Common',
            2 => 'Uncommon',
            3 => 'Rare',
            4 => 'Epic',
            5 => 'Legendary'
        ];

        return $rarities[$this->rarity_level] ?? 'Unknown';
    }

    /**
     * Get rarity color class
     */
    public function getRarityColorAttribute()
    {
        $colors = [
            1 => 'text-gray-500',
            2 => 'text-green-500',
            3 => 'text-blue-500',
            4 => 'text-purple-500',
            5 => 'text-yellow-500'
        ];

        return $colors[$this->rarity_level] ?? 'text-gray-500';
    }

    /**
     * Check if a cadet has unlocked this badge
     */
    public function isUnlockedBy($cadetId)
    {
        return $this->cadetBadges()->where('cadet_id', $cadetId)->exists();
    }

    /**
     * Get unlock count
     */
    public function getUnlockCountAttribute()
    {
        return $this->cadetBadges()->count();
    }
}
