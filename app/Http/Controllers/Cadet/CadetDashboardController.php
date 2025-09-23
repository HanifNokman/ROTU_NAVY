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

        // Handle AJAX request for duty ranking filter
        if ($request->ajax()) {
            return $this->getDutyRankingData($dutyCadets);
        }

        return view('cadet.dashboard', compact('user', 'cadet', 'cadets', 'sortOrder', 'dutyCadets'));
    }

    private function getDutyRankingData($dutyCadets)
    {
        $maxCount = $dutyCadets->max('daily_duty_count') ?: 1;
        $html = '';

        if ($dutyCadets->isEmpty()) {
            $html = '<div class="text-center text-gray-500">No cadets available.</div>';
        } else {
            foreach ($dutyCadets as $index => $cadet) {
                $percentage = ($cadet->daily_duty_count / $maxCount) * 100;

                // Calculate RGB color from red → yellow → green based on percentage
                if ($percentage < 50) {
                    $ratio = $percentage / 50; // 0 to 1
                    $r = 255;
                    $g = (int)(180 * $ratio);
                } else {
                    $ratio = ($percentage - 50) / 50; // 0 to 1
                    $r = (int)(255 * (1 - $ratio));
                    $g = 180;
                }
                $bgColor = "rgb($r, $g, 0)";

                $pluralDays = $cadet->daily_duty_count == 1 ? 'Day' : 'Days';

                $html .= '
                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    </div>

                    <div class="flex-1 w-full">
                        <div class="text-sm font-medium mb-1 text-center sm:text-left">
                            #' . ($index + 1) . ' - ' . ($cadet->user->name ?? '-') . '
                        </div>

                        <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                            <div
                                class="absolute top-0 left-0 h-full rounded-full flex items-center"
                                style="width: ' . $percentage . '%; background-color: ' . $bgColor . ';">
                                <span class="text-white font-semibold text-sm pl-2 whitespace-nowrap">
                                    ' . $cadet->daily_duty_count . ' ' . $pluralDays . '
                                </span>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }

        return response()->json(['html' => $html]);
    }
}