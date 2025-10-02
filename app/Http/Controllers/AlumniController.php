<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadet;

class AlumniController extends Controller
{
    // ================================================================
    // DISPLAY ALUMNI INDEX
    // ================================================================
    
    public function index()
    {
        $alumniByIntake = Cadet::where('cadet_status', 'completed')
            ->with('user')
            ->orderBy('intake_year')
            ->get()
            ->groupBy('intake_year')
            ->map(function ($cadets) {
                return $cadets->sort(function ($a, $b) {
                    $positionOrder = ['CO' => 1, 'Thana' => 2, 'Zayn' => 3];
                    $aPos = $positionOrder[$a->position] ?? 4;
                    $bPos = $positionOrder[$b->position] ?? 4;
                    
                    if ($aPos !== $bPos) {
                        return $aPos <=> $bPos;
                    }
                    
                    return $a->service_number <=> $b->service_number;
                })->values();
            });

        return view('alumni', compact('alumniByIntake'));
    }
}