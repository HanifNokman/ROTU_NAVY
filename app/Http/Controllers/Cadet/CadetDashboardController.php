<?php

namespace App\Http\Controllers\Cadet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cadet;
use App\Models\User;

class CadetDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cadet = Cadet::where('user_id', $user->id)->first();

        return view('cadet.dashboard', compact('user', 'cadet'));
    }
}
