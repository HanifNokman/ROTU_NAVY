<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Cadet;
use App\Services\BadgeCheckingService;
use Illuminate\Support\Facades\Auth;

class CheckCadetBadges
{
    protected $badgeCheckingService;

    public function __construct(BadgeCheckingService $badgeCheckingService)
    {
        $this->badgeCheckingService = $badgeCheckingService;
    }

    /**
     * Handle an incoming request.
     * Check and unlock badges for cadets on every page load
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated cadet users
        if (Auth::check() && Auth::user()->role === 'cadet') {
            $cadet = Cadet::where('user_id', Auth::id())->first();

            if ($cadet) {
                // Check and unlock any eligible badges
                $this->badgeCheckingService->checkAndUnlockBadges($cadet);
            }
        }

        return $next($request);
    }
}
