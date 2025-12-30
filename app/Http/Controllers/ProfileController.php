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
        $user = $request->user();
        $personal = null;
        if ($user->role === 'cadet') {
            $personal = \App\Models\Cadet::where('user_id', $user->id)->first();
        } elseif ($user->role === 'instructor') {
            $personal = \App\Models\Instructor::where('user_id', $user->id)->first();
        }
        return view('profile.edit', [
            'user' => $user,
            'personal' => $personal,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Standardize name: capitalize first letter of each word
        if (isset($validated['name'])) {
            $validated['name'] = $this->standardizeName($validated['name']);
        }

        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Standardize name by capitalizing the first letter of each word.
     * Handles common Malay name particles (bin, binti) as lowercase.
     */
    private function standardizeName(string $name): string
    {
        // Trim and remove extra spaces
        $name = trim(preg_replace('/\s+/', ' ', $name));

        // Split into words
        $words = explode(' ', $name);

        // Common Malay name particles that should be lowercase
        $lowercaseParticles = ['bin', 'binti', 'a/l', 'a/p', 'al'];

        $standardized = [];
        foreach ($words as $word) {
            $lowerWord = strtolower($word);

            // Check if it's a common particle
            if (in_array($lowerWord, $lowercaseParticles)) {
                $standardized[] = $lowerWord;
            } else {
                // Capitalize first letter, rest lowercase
                $standardized[] = ucfirst($lowerWord);
            }
        }

        return implode(' ', $standardized);
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
