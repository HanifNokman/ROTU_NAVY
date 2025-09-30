<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cadet;
use App\Models\Instructor;

class AdminController extends Controller
{
    public function userManagement(Request $request)
    {
        // Fetch cadets with user data, filtered by intake if provided, sorted by service_number ascending
        $cadetsQuery = Cadet::with('user');
        if ($request->has('intake') && $request->intake == 'no_intake') {
            $cadetsQuery->whereNull('intake_year');
        } elseif ($request->has('intake') && $request->intake) {
            $cadetsQuery->where('intake_year', $request->intake);
        }
        $cadets = $cadetsQuery->orderBy('service_number')->get();

        // Define rank hierarchy for instructors
        $rankOrder = [
            'Kpt' => 1,
            'Kdr' => 2,
            'Lt.Kdr' => 3,
            'Lt' => 4,
            'Lt.Dya' => 5,
            'Lt.M' => 6,
            'PWI' => 7,
            'PWII' => 8,
            'BK' => 9,
            'BM' => 10,
            'LK' => 11,
            'LKI' => 12,
            'LKII' => 13,
        ];

        // Fetch instructors with user data, filtered by status if provided, sorted by rank hierarchy then service_number
        $instructorsQuery = Instructor::with('user');
        if ($request->has('status') && $request->status) {
            $instructorsQuery->where('status', $request->status);
        }
        $instructors = $instructorsQuery
            ->orderByRaw("FIELD(rank, '" . implode("','", array_keys($rankOrder)) . "')")
            ->orderBy('service_number')
            ->get();

        // Get distinct intakes for cadets filter, ordered ascending for lowest first
        $intakes = Cadet::select('intake_year')->distinct()->orderBy('intake_year', 'asc')->pluck('intake_year');

        // Status options for instructors
        $statuses = ['Active', 'Relocated', 'Retired'];

        return view('admin.user_management', compact('cadets', 'instructors', 'intakes', 'statuses', 'request'));
    }

    public function dataManagement()
    {
        return view('admin.data_management');
    }

    public function accessManagement()
    {
        return view('admin.access_management');
    }

    public function getUser($id)
    {
        $user = User::with('cadet', 'instructor')->findOrFail($id);
        return response()->json([
            'user' => $user,
            'cadet' => $user->cadet,
            'instructor' => $user->instructor,
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate user fields
        $userValidated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,instructor,cadet',
        ]);

        // Update user fields
        $user->update($userValidated);

        // Update related model
        if ($user->role === 'cadet' && $user->cadet) {
            $cadetValidated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'gender' => 'nullable|in:Male,Female',
                'bank_account_number' => 'nullable|string|max:15',
                'rank' => 'nullable|string',
                'position' => 'nullable|string',
                'profile_pic' => 'nullable|string',
                'intake_year' => 'nullable|digits:4',
                'matric_no' => 'nullable|string|max:11',
                'current_cgpa' => 'nullable|numeric|between:0,4.00',
                'past_cgpa' => 'nullable|numeric|between:0,4.00',
                'ic_number' => 'nullable|string|max:15',
                'BMI' => 'nullable|numeric',
                'BMI_update_date' => 'nullable|date',
                'swimming_qualification' => 'nullable|string',
                'service_number' => 'nullable|string|max:10',
            ]);
            $user->cadet->update($cadetValidated);
        } elseif ($user->role === 'instructor' && $user->instructor) {
            $instructorValidated = $request->validate([
                'phone_number' => 'nullable|string|max:13',
                'rank' => 'nullable|string',
                'profile_pic' => 'nullable|string',
                'position' => 'nullable|string|max:20',
                'expertise' => 'nullable|string',
                'time_in_service' => 'nullable|integer|min:0',
                'ttp' => 'nullable|date',
                'status' => 'nullable|string',
                'service_number' => 'nullable|string|max:10',
                'past_unit' => 'nullable|array',
            ]);
            // Handle past_unit array - filter out empty values and encode as JSON
            if (isset($instructorValidated['past_unit'])) {
                $instructorValidated['past_unit'] = json_encode(array_filter($instructorValidated['past_unit'], function($value) {
                    return !empty(trim($value));
                }));
            }
            $user->instructor->update($instructorValidated);
        }

        return response()->json(['success' => true]);
    }

    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->confirm_name !== $user->name) {
            return response()->json(['error' => 'Name confirmation does not match.'], 400);
        }

        $user->delete();

        return response()->json(['success' => true]);
    }
}
