<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cadet;

class CadetDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->firstOrFail();

        // Calculate Tauliah Date
        $intakeYear = $cadet->intake_year ?? now()->year;
        $tauliahDate = \Carbon\Carbon::createFromDate($intakeYear + 3, 9, 15);

        // Auto-update rank if date has passed and not yet updated
        if (now()->greaterThanOrEqualTo($tauliahDate) && $cadet->rank !== 'Lt.M') {
            $cadet->rank = 'Lt.M';
            $cadet->save();
        }

        $sortOrder = $request->get('sort_order', 'desc');

        // Cadets in same intake
        $cadets = Cadet::where('intake_year', $cadet->intake_year)
            ->with('user')
            ->orderBy('daily_duty_count', $sortOrder)
            ->get();

        // Duty cadets filtered by same intake
        $dutyCadets = Cadet::where('intake_year', $cadet->intake_year)
            ->with('user')
            ->orderBy('daily_duty_count', $sortOrder)
            ->get();

        return view('cadet.dashboard', compact('user', 'cadet', 'cadets', 'sortOrder', 'dutyCadets'));
    }
}
