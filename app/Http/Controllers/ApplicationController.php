<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use App\Models\Cadet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{
    public function create()
    {
        $applicationDeadline = \App\Models\ContentSetting::getFormattedDeadline();
        return view('application', compact('applicationDeadline'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:applications,email',
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|in:Male,Female',
            'ic_number' => 'required|string|unique:applications,ic_number',
            'matric_no' => 'required|string|unique:applications,matric_no',
            'faculty' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'height' => 'required|numeric|min:100|max:250',
            'weight' => 'required|numeric|min:30|max:200',
            'bmi' => 'required|numeric|min:10|max:50',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('profile_pic')) {
            $data['profile_pic'] = $request->file('profile_pic')->store('profile_pics', 'public');
        }

        // Set default statuses for evaluation fields
        $data['attendance'] = 'pending';
        $data['drill_test'] = 'pending';
        $data['physical_test'] = 'pending';
        $data['medical_test'] = 'pending';
        $data['interview'] = 'pending';
        $data['final_evaluation'] = 'pending';

        Application::create($data);

        $qrCodeImage = \App\Models\ContentSetting::get('qr_code_image');
        $whatsappUrl = \App\Models\ContentSetting::get('application_portal_url');
        $applicationDeadline = \App\Models\ContentSetting::getFormattedDeadline();

        return view('application_success', compact('qrCodeImage', 'whatsappUrl', 'applicationDeadline'));
    }

    public function index()
    {
        $applications = Application::all();
        return view('pending_verification', compact('applications'));
    }

    public function updateStatus(Request $request, Application $application)
    {
        $request->validate([
            'attendance' => 'nullable|in:pending,passed,failed',
            'drill_test' => 'nullable|in:pending,passed,failed',
            'physical_test' => 'nullable|in:pending,passed,failed',
            'medical_test' => 'nullable|in:pending,passed,failed',
            'interview' => 'nullable|in:pending,passed,failed',
            'final_evaluation' => 'nullable|in:pending,passed,failed',
        ]);

        $application->update($request->only(['attendance','drill_test', 'physical_test', 'medical_test', 'interview','final_evaluation']));

        // Check if all tests are passed
        if ($application->attendance === 'passed' &&
            $application->drill_test === 'passed' &&
            $application->physical_test === 'passed' &&
            $application->medical_test === 'passed' &&
            $application->interview === 'passed' &&
            $application->final_evaluation === 'passed') {
            $this->approveApplication($application);
        }

        return redirect()->back()->with('success', 'Application status updated successfully!');
    }

    private function approveApplication(Application $application)
    {
        // Create user
        $user = User::create([
            'name' => $application->name,
            'email' => $application->email,
            'password' => Hash::make($application->matric_no),
            'role' => 'cadet',
        ]);

        // Create cadet
        Cadet::create([
            'user_id' => $user->id,
            'phone_number' => $application->phone_number,
            'gender' => $application->gender,
            'ic_number' => $application->ic_number,
            'matric_no' => $application->matric_no,
            'faculty' => $application->faculty,
            'course' => $application->course,
            'profile_pic' => $application->profile_pic,
            'BMI' => $application->bmi,
            'BMI_update_date' => now(),
            'rank' => 'PK',
            'position' => 'Normal',
            'cadet_status' => 'Active',
            'intake_year' => now()->year,
            'daily_duty_count' => 0,
            'swimming_qualification' => 'In Progress',
        ]);

        // Delete application
        $application->delete();
    }
}
