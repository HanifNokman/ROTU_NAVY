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

        // Get Hall of Fame - Best Cadets and Best Academics grouped by intake
        $hallOfFameByIntake = Cadet::where('cadet_status', 'completed')
            ->where(function($query) {
                $query->where('is_best_cadet', true)
                      ->orWhere('is_best_academic', true);
            })
            ->with('user')
            ->orderBy('intake_year', 'desc')
            ->get()
            ->groupBy('intake_year');

        return view('alumni', compact('alumniByIntake', 'hallOfFameByIntake'));
    }
}