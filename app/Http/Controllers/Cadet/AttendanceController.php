<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;


use App\Models\Cadet;
use App\Models\Training;
use App\Models\TrainingAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->first();
        $today = Carbon::today();



        // Use instructor logic for today's training visibility
        $now = Carbon::now();
        $today = $now->toDateString();
        $yesterday = $now->copy()->subDay()->toDateString();
        $todaysTraining = Training::where(function ($query) use ($cadet, $today, $yesterday, $now) {
            $intakeStr = "Intake - " . ($cadet->intake_year - 2011);
            $query->where('involvement', 'LIKE', "%$intakeStr%")
                ->where(function ($q) use ($today, $yesterday, $now) {
                    $q->whereDate('start_datetime', $today)
                      ->orWhere(function ($subQ) use ($today, $yesterday) {
                          $subQ->whereDate('start_datetime', $yesterday)
                                ->where('status', 'Active');
                      })
                      ->orWhere(function ($subQ) use ($now) {
                          $subQ->where('start_datetime', '<=', $now)
                                ->where(function ($subSubQ) use ($now) {
                                    $subSubQ->whereNull('end_datetime')
                                             ->orWhere('end_datetime', '>=', $now->copy()->subDay());
                                });
                      });
                });
        })
        ->orderBy('start_datetime', 'asc')
        ->first();

        // Attendance record for today
        $attendance = null;
        if ($todaysTraining) {
            $attendance = TrainingAttendance::where('training_id', $todaysTraining->id)
                ->where('cadet_id', $cadet->id)
                ->first();
        }


        // Absence section: completed trainings where cadet was absent and has NOT submitted both reason and file
        $absentAttendances = TrainingAttendance::where('cadet_id', $cadet->id)
            ->where('present', false)
            ->whereHas('training', function($q) {
                $q->where('status', 'Completed');
            })
            ->where(function($q) {
                $q->whereNull('absence_reason')->orWhereNull('file_url');
            })
            ->with('training')
            ->get();

        return view('cadet.attendance', [
            'cadet' => $cadet,
            'todaysTraining' => $todaysTraining,
            'attendance' => $attendance,
            'absentAttendances' => $absentAttendances,
        ]);
    }

    // Mark present manually or via QR
    public function markPresent(Request $request)
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->firstOrFail();
        $trainingId = $request->input('training_id');
        $method = $request->input('method', 'manual');

        $attendance = TrainingAttendance::firstOrNew([
            'training_id' => $trainingId,
            'cadet_id' => $cadet->id,
        ]);
        $attendance->present = true;
        $attendance->method = $method;
        $attendance->marked_at = Carbon::now();
        $attendance->absence_reason = null;
        $attendance->file_url = null;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance marked as present.');
    }

    // Submit absence reason and file
    public function submitAbsence(Request $request, $attendanceId)
    {
        $attendance = TrainingAttendance::findOrFail($attendanceId);
        $request->validate([
            'absence_reason' => 'required|string',
            'supporting_file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        // Handle file upload
        $file = $request->file('supporting_file');
        $path = $file->store('absences', 'public');
        $attendance->absence_reason = $request->input('absence_reason');
        $attendance->file_url = $path;
        $attendance->save();

        return redirect()->back()->with('success', 'Absence reason submitted.');
    }
}
