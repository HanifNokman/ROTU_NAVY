<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Helpers\BadgeHelper;
use App\Models\Cadet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BadgeController extends Controller
{
    /**
     * Get pending badges where unlock modal hasn't been shown yet
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPendingBadges(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'cadet') {
            return response()->json([
                'badges' => []
            ]);
        }

        $cadet = Cadet::where('user_id', $user->id)->first();

        if (!$cadet) {
            return response()->json([
                'badges' => []
            ]);
        }

        $pendingBadges = BadgeHelper::getPendingBadges($cadet->id);

        return response()->json([
            'badges' => $pendingBadges
        ]);
    }

    /**
     * Mark a badge modal as shown
     *
     * @param Request $request
     * @param int $cadetBadgeId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsDisplayed(Request $request, $cadetBadgeId)
    {
        $success = BadgeHelper::markAsDisplayed($cadetBadgeId);

        return response()->json([
            'success' => $success
        ]);
    }

    /**
     * Manually trigger a badge unlock (for testing purposes)
     * Remove this in production or protect with admin middleware
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function triggerTestBadge(Request $request)
    {
        $request->validate([
            'badge_id' => 'required|exists:badges,id'
        ]);

        $user = Auth::user();

        if ($user->role !== 'cadet') {
            return response()->json([
                'error' => 'Only cadets can unlock badges'
            ], 403);
        }

        $cadet = Cadet::where('user_id', $user->id)->first();

        if (!$cadet) {
            return response()->json([
                'error' => 'Cadet profile not found'
            ], 404);
        }

        $badgeData = BadgeHelper::awardBadge($cadet->id, $request->badge_id);

        if (!$badgeData) {
            return response()->json([
                'error' => 'Badge already unlocked'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'badge' => $badgeData
        ]);
    }
}
