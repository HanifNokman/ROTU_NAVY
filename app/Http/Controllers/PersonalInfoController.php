<?php
namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Cadet;
use App\Models\Instructor;
use App\Models\PerformanceRating;

class PersonalInfoController extends Controller
{
    /**
     * Display the user's personal information form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        
        $personal = $user->role === 'cadet'
            ? Cadet::where('user_id', $user->id)->first()
            : Instructor::where('user_id', $user->id)->first();
            
        return view('profile.edit', [
            'user' => $user,
            'personal' => $personal,
        ]);
    }

    /**
     * Update the user's personal information.
     */

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->role === 'cadet') {
            $validated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'nullable|in:Male,Female',
                'ic_number' => 'nullable|string|max:15',
                'matric_no' => 'nullable|string|max:11',
                'intake_year' => 'nullable|digits:4',
                'service_number' => 'nullable|string|max:10',
                'rank' => 'nullable|string',
                'bank_account_number' => 'nullable|string|max:15',
                'current_cgpa' => 'nullable|numeric|between:0,4.00',
                'past_cgpa' => 'nullable|numeric|between:0,4.00',
                'BMI' => 'nullable|numeric',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                $image = $request->file('profile_pic');
                $imagePath = $image->store('profile_pics', 'public');
                $validated['profile_pic'] = $imagePath;
            }

            $cadet = Cadet::where('user_id', $user->id)->first();
            if (!$cadet) {
                $cadet = new Cadet(['user_id' => $user->id]);
            }
            $oldBMI = $cadet->BMI;
            $oldCGPA = $cadet->current_cgpa;

            // Define fields that can only be filled once
            $oneTimeFillFields = ['gender', 'ic_number', 'matric_no', 'intake_year', 'rank'];

            // Only update fields present in the request, preserve others
            foreach ($validated as $key => $value) {
                if ($request->has($key) || $key === 'profile_pic') {
                    // Check if this is a one-time fill field
                    if (in_array($key, $oneTimeFillFields)) {
                        // Only allow update if the field is currently empty/null
                        if (empty($cadet->$key)) {
                            $cadet->$key = $value;
                        }
                        // If field already has a value, skip the update (preserve existing value)
                    } else {
                        // For non-restricted fields, update normally
                        $cadet->$key = $value;
                    }
                }
            }

            // If BMI is being updated, set BMI_update_date to now
            if (array_key_exists('BMI', $validated) && $validated['BMI'] !== null && $validated['BMI'] != $oldBMI) {
                $cadet->BMI_update_date = now();
            }

            $cadet->save();

            // Update performance rating if CGPA changed
            if (array_key_exists('current_cgpa', $validated) && $validated['current_cgpa'] != $oldCGPA) {
                $performanceRating = PerformanceRating::getOrCreateForCadet($cadet->id);
                $performanceRating->updateAcademicPoints();
            }

        } elseif ($user->role === 'instructor') {
            $validated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'nullable|in:Male,Female',
                'position' => 'nullable|string|max:20',
                'expertise' => 'nullable|string',
                'past_unit' => 'nullable|array',
                'service_number' => 'nullable|string|max:10',
                'rank' => 'nullable|string',
                'status' => 'nullable|string',
                'time_in_service' => 'nullable|integer|min:0',
                'ttp' => 'nullable|date',
                'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle profile picture upload
            if ($request->hasFile('profile_pic')) {
                $image = $request->file('profile_pic');
                $imagePath = $image->store('profile_pics', 'public');
                $validated['profile_pic'] = $imagePath;
            }

            // Handle past_unit array - filter out empty values and encode as JSON
            if (isset($validated['past_unit'])) {
                $validated['past_unit'] = json_encode(array_filter($validated['past_unit'], function($value) {
                    return !empty(trim($value));
                }));
            }

            $instructor = Instructor::where('user_id', $user->id)->first();
            if (!$instructor) {
                $instructor = new Instructor(['user_id' => $user->id]);
            }
            foreach ($validated as $key => $value) {
                if ($request->has($key) || $key === 'profile_pic' || $key === 'past_unit') {
                    $instructor->$key = $value;
                }
            }
            $instructor->save();
        }

        return Redirect::route('personal.edit')->with('status', 'personal-updated');
    }
}