<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cadet;
use App\Models\Instructor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if ($user && $user->role === 'cadet') {
            $cadet = Cadet::where('user_id', $user->id)->first();
            if ($cadet && $cadet->cadet_status === 'Suspended') {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Your account has been suspended.']);
            }
            return redirect()->intended(route('cadet.dashboard', absolute: false));
        } elseif ($user && $user->role === 'instructor') {
            $instructor = Instructor::where('user_id', $user->id)->first();
            if ($instructor && in_array($instructor->status, ['Relocated', 'Retired'])) {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Thank you for your service. Access to this system is no longer available.']);
            }
            return redirect()->intended(route('instructor.dashboard', absolute: false));
        } elseif ($user && $user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }
        // Default fallback
        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
