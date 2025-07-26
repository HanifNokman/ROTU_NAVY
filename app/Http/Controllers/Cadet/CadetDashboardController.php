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

        $sortOrder = $request->get('sort_order', 'desc');

        // Eager load 'user' relationship to access name
        $cadets = Cadet::where('intake_year', $cadet->intake_year)
            ->with('user') // <- make sure this relationship exists in the Cadet model
            ->orderBy('daily_duty_count', $sortOrder)
            ->get();

        return view('cadet.dashboard', compact('user', 'cadet', 'cadets', 'sortOrder'));
    }
}
