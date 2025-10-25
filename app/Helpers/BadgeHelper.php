<?php

namespace App\Helpers;

use App\Models\Badge;
use App\Models\CadetBadge;
use App\Models\Cadet;
use Illuminate\Support\Facades\Auth;

class BadgeHelper
{
    /**
     * Unlock a badge for a cadet
     *
     * @param int $cadetId
     * @param int $badgeId
     * @return CadetBadge|null
     */
    public static function unlockBadge($cadetId, $badgeId)
    {
        // Check if badge already exists
        $existingBadge = CadetBadge::where('cadet_id', $cadetId)
            ->where('badge_id', $badgeId)
            ->first();

        if ($existingBadge) {
            return null; // Badge already unlocked
        }

        // Create new badge unlock
        $cadetBadge = CadetBadge::create([
            'cadet_id' => $cadetId,
            'badge_id' => $badgeId,
            'unlocked_at' => now(),
            'is_displayed' => false, // For profile display preference
            'modal_shown' => false, // Will be shown via modal
        ]);

        return $cadetBadge;
    }

    /**
     * Get all badges where unlock modal hasn't been shown yet
     *
     * @param int|null $cadetId
     * @return \Illuminate\Support\Collection
     */
    public static function getPendingBadges($cadetId = null)
    {
        if (!$cadetId) {
            $user = Auth::user();
            if ($user->role !== 'cadet') {
                return collect([]);
            }

            $cadet = Cadet::where('user_id', $user->id)->first();
            if (!$cadet) {
                return collect([]);
            }

            $cadetId = $cadet->id;
        }

        $pendingBadges = CadetBadge::where('cadet_id', $cadetId)
            ->where('modal_shown', false)
            ->with('badge')
            ->orderBy('unlocked_at', 'asc')
            ->get();

        return $pendingBadges->map(function ($cadetBadge) {
            $badge = $cadetBadge->badge;
            return [
                'id' => $cadetBadge->id,
                'badge_id' => $badge->id,
                'name' => $badge->name,
                'description' => $badge->description,
                'unlock_criteria' => $badge->unlock_criteria,
                'category' => $badge->category,
                'rarity_level' => $badge->rarity_level,
                'rarity_label' => $badge->rarity_label,
                'rarity_color' => $badge->rarity_color,
                'icon' => $badge->icon,
                'icon_url' => $badge->icon_url,
                'unlocked_at' => $cadetBadge->unlocked_at->toISOString(),
            ];
        });
    }

    /**
     * Mark a badge modal as shown
     *
     * @param int $cadetBadgeId
     * @return bool
     */
    public static function markAsDisplayed($cadetBadgeId)
    {
        $cadetBadge = CadetBadge::find($cadetBadgeId);

        if (!$cadetBadge) {
            return false;
        }

        $cadetBadge->modal_shown = true;
        $cadetBadge->save();

        return true;
    }

    /**
     * Trigger a badge unlock event (for use in views/JavaScript)
     *
     * @param array $badgeData
     * @return string JavaScript code to trigger the badge modal
     */
    public static function triggerBadgeUnlock($badgeData)
    {
        $json = json_encode($badgeData);
        return "<script>window.dispatchEvent(new CustomEvent('badge-unlocked', { detail: {$json} }));</script>";
    }

    /**
     * Check and award attendance-based badges
     *
     * @param int $cadetId
     * @return array Array of newly unlocked badge IDs
     */
    public static function checkAttendanceBadges($cadetId)
    {
        $cadet = Cadet::find($cadetId);
        if (!$cadet) {
            return [];
        }

        $unlockedBadges = [];

        // Get attendance percentage (you'll need to implement this based on your attendance tracking)
        // Example: 100% attendance, 90% attendance, etc.

        return $unlockedBadges;
    }

    /**
     * Check and award quiz-based badges
     *
     * @param int $cadetId
     * @return array Array of newly unlocked badge IDs
     */
    public static function checkQuizBadges($cadetId)
    {
        $cadet = Cadet::find($cadetId);
        if (!$cadet) {
            return [];
        }

        $unlockedBadges = [];

        // Implement quiz badge logic based on quiz scores

        return $unlockedBadges;
    }

    /**
     * Award a specific badge to a cadet and return badge data for modal
     *
     * @param int $cadetId
     * @param int $badgeId
     * @return array|null Badge data if newly unlocked, null if already had it
     */
    public static function awardBadge($cadetId, $badgeId)
    {
        $cadetBadge = self::unlockBadge($cadetId, $badgeId);

        if (!$cadetBadge) {
            return null; // Already unlocked
        }

        $badge = Badge::find($badgeId);

        return [
            'id' => $cadetBadge->id,
            'badge_id' => $badge->id,
            'name' => $badge->name,
            'description' => $badge->description,
            'unlock_criteria' => $badge->unlock_criteria,
            'category' => $badge->category,
            'rarity_level' => $badge->rarity_level,
            'rarity_label' => $badge->rarity_label,
            'rarity_color' => $badge->rarity_color,
            'icon' => $badge->icon,
            'icon_url' => $badge->icon_url,
            'unlocked_at' => $cadetBadge->unlocked_at->toISOString(),
        ];
    }
}
