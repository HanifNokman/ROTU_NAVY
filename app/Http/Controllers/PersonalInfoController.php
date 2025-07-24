<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cadet;
use App\Models\Instructor;

class PersonalInfoController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $personal = $user->role === 'cadet'
            ? Cadet::firstOrNew(['user_id' => $user->id])
            : Instructor::firstOrNew(['user_id' => $user->id]);
        return view('profile.edit', compact('user', 'personal'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'cadet') {
            $validated = $request->validate([
                'phone_number' => 'nullable|string',
                'gender' => 'nullable|in:Male,Female',
                'bank_account_number' => 'nullable|string',
                'rank' => 'nullable|string',
            ]);
            Cadet::updateOrCreate(
                ['user_id' => $user->id],
                $validated
            );
        } elseif ($user->role === 'instructor') {
            $validated = $request->validate([
                'phone_number' => 'nullable|string',
                'rank' => 'nullable|string',
            ]);
            Instructor::updateOrCreate(
                ['user_id' => $user->id],
                $validated
            );
        }
        return back()->with('status', 'personal-updated');
    }
}
