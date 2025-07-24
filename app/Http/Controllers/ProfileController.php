<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's personal information (cadet/instructor).
     */
    public function updatePersonal(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === 'cadet') {
            $validated = $request->validate([
                'phone_number' => 'required|string',
                'gender' => 'required|in:Male,Female',
                'bank_account_number' => 'required|string',
                'rank' => 'required|string',
            ]);

            Cadet::updateOrCreate(
                ['user_id' => $user->id],
                $validated
            );

        } elseif ($user->role === 'instructor') {
            $validated = $request->validate([
                'phone_number' => 'required|string',
                'rank' => 'required|string',
            ]);

            Instructor::updateOrCreate(
                ['user_id' => $user->id],
                $validated
            );
        }

        return back()->with('status', 'personal-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
