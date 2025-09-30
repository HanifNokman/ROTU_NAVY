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
        if ($request->has('intake') && $request->intake) {
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

        // Get distinct intakes for cadets filter
        $intakes = Cadet::select('intake_year')->distinct()->orderBy('intake_year', 'desc')->pluck('intake_year');

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

        // Update user fields
        $user->update($request->only(['name', 'email', 'role']));

        // Update related model
        if ($user->role === 'cadet' && $user->cadet) {
            $user->cadet->update($request->only([
                'phone_number', 'gender', 'bank_account_number', 'rank', 'position', 'profile_pic',
                'intake_year', 'matric_no', 'current_cgpa', 'past_cgpa', 'ic_number', 'BMI',
                'BMI_update_date', 'swimming_qualification', 'service_number'
            ]));
        } elseif ($user->role === 'instructor' && $user->instructor) {
            $user->instructor->update($request->only([
                'phone_number', 'gender', 'rank', 'profile_pic', 'position', 'expertise',
                'time_in_service', 'ttp', 'status', 'service_number', 'past_unit'
            ]));
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
