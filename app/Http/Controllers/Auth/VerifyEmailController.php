<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $role = $request->user()->role ?? 'cadet';
        $route = match ($role) {
            'cadet' => 'cadet.dashboard',
            'instructor' => 'instructor.dashboard',
            'admin' => 'admin.dashboard',
            default => 'cadet.dashboard'
        };
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route($route, absolute: false).'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            $user = $request->user();
            if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
                event(new Verified($user));
            }
        }

        return redirect()->intended(route($route, absolute: false).'?verified=1');
    }
}
