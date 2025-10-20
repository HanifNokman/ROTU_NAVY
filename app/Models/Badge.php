<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon_path',
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
            1 => 'Standard',
            2 => 'Bronze',
            3 => 'Silver',
            4 => 'Gold',
            5 => 'Platinum'
        ];

        return $rarities[$this->rarity_level] ?? 'Unknown';
    }

    /**
     * Get rarity color hex code
     */
    public function getRarityColorAttribute()
    {
        $colors = [
            1 => '#6B7280',      // Standard - neutral gray
            2 => '#D97706',      // Bronze - warm brown/amber
            3 => '#94A3B8',      // Silver - metallic silver
            4 => '#EAB308',      // Gold - bright gold
            5 => '#22D3EE'       // Platinum - cool platinum blue
        ];

        return $colors[$this->rarity_level] ?? '#6B7280';
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

    /**
     * Get the full URL for the badge icon
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon_path) {
            return asset('storage/badges/' . $this->icon_path);
        }
        return null;
    }

    /**
     * Check if badge has an image icon
     */
    public function hasImageIcon()
    {
        return !empty($this->icon_path) && file_exists(public_path('storage/badges/' . $this->icon_path));
    }
}
