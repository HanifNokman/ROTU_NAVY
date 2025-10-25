<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    protected $appends = [
        'rarity_label',
        'rarity_color',
        'icon_url',
        'icon'
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
            5 => 'Legendary',
            6 => 'Mythic'
        ];

        return $rarities[$this->rarity_level] ?? 'Unknown';
    }

    /**
     * Get rarity color hex code
     */
    public function getRarityColorAttribute()
    {
        $colors = [
            1 => '#9CA3AF',      // Common - gray
            2 => '#22C55E',      // Uncommon - vibrant green
            3 => '#3B82F6',      // Rare - bright blue
            4 => '#9333EA',      // Epic - deep purple
            5 => '#FBBF24',      // Legendary - bright gold
            6 => '#DC2626'       // Mythic - deep red
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
            // Check if file exists in storage
            if (Storage::disk('public')->exists('assets/badges/' . $this->icon_path)) {
                return asset('storage/assets/badges/' . $this->icon_path);
            }
            // Fallback: check if it's a direct public path
            if (file_exists(public_path('storage/assets/badges/' . $this->icon_path))) {
                return asset('storage/assets/badges/' . $this->icon_path);
            }
        }
        return null;
    }

    /**
     * Check if badge has an image icon
     */
    public function hasImageIcon()
    {
        if (empty($this->icon_path)) {
            return false;
        }

        // Check in storage disk first
        if (Storage::disk('public')->exists('assets/badges/' . $this->icon_path)) {
            return true;
        }

        // Fallback: check in public directory
        return file_exists(public_path('storage/assets/badges/' . $this->icon_path));
    }

    /**
     * Get FontAwesome icon class as fallback
     */
    public function getIconAttribute()
    {
        // Return FontAwesome icon based on category as fallback
        $icons = [
            'overall' => 'fas fa-trophy',
            'attendance' => 'fas fa-calendar-check',
            'quiz' => 'fas fa-brain',
            'learning' => 'fas fa-book-open',
            'duty' => 'fas fa-clipboard-check',
            'academic' => 'fas fa-graduation-cap',
        ];

        return $icons[$this->category] ?? 'fas fa-award';
    }

    /**
     * Get category display name
     */
    public function getCategoryNameAttribute()
    {
        $categories = [
            'overall' => 'Overall Performance',
            'attendance' => 'Attendance',
            'quiz' => 'Quiz Performance',
            'learning' => 'Learning Progress',
            'duty' => 'Duty',
            'academic' => 'Academic Excellence',
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    /**
     * Get category icon
     */
    public function getCategoryIconAttribute()
    {
        return $this->getIconAttribute();
    }

    /**
     * Check if badge should be displayed
     * (Helper method for checking display status for specific cadet)
     */
    public function isDisplayedBy($cadetId)
    {
        $cadetBadge = $this->cadetBadges()
            ->where('cadet_id', $cadetId)
            ->first();
        
        return $cadetBadge ? $cadetBadge->is_displayed : false;
    }

    /**
     * Get the cadet badge record for a specific cadet
     */
    public function getCadetBadge($cadetId)
    {
        return $this->cadetBadges()
            ->where('cadet_id', $cadetId)
            ->first();
    }
}