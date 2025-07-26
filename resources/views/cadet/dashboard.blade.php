<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadet Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full px-6 py-10">
        <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row gap-6 transition duration-300 hover:shadow-2xl hover:border hover:border-blue-300">
            <!-- Profile Picture -->
            <div class="flex justify-center lg:justify-start">
                <img src="{{ $cadet?->profile_pic ? asset('storage/' . $cadet->profile_pic) : asset('images/default.png') }}"
                    alt="Profile Picture"
                    class="w-40 h-52 md:w-60 md:h-80 object-cover border rounded-md">
            </div>

            <!-- Profile Information -->
            <div class="flex-1 space-y-6">
                <!-- Row 1 -->
                <div class="flex items-center justify-center md:justify-start gap-4">
                    <button class="bg-gray-100 text-gray-800 font-bold px-6 py-2 rounded shadow whitespace-nowrap">
                        🛡️ Personal Profile
                    </button>
                    @php
                        $prefix = '';
                        if (trim($cadet?->rank) === 'Lt.M') {
                            $prefix = ' PSSTLDM'; // add space before
                        }
                    @endphp

                    <p class="text-2xl font-semibold text-gray-800">
                        {{ ($cadet?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') . $prefix }}
                    </p>
                </div>

                <!-- Row 2: Contact Info -->
                <div>
                    <p class="text-gray-500 font-semibold mb-2">Contact Information</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <p><strong>Phone:</strong> {{ $cadet?->phone_number ?? 'Not set' }}</p>
                        <p><strong>Email:</strong> {{ $user?->email ?? 'Not set' }}</p>
                    </div>
                </div>

                <!-- Row 3: General Info -->
                <div>
                    <p class="text-gray-500 font-semibold mb-2">General Information</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><strong>Gender:</strong> {{ $cadet->gender ?? '-' }}</div>
                        <div><strong>Bank Account Number:</strong> {{ $cadet->bank_account_number ?? '-' }}</div>
                        <div><strong>Service Number:</strong> {{ $cadet->service_number ?? '-' }}</div>
                        <div><strong>Matric Number:</strong> {{ $cadet->matric_no ?? '-' }}</div>
                        <div>
                            <strong>Intake Year:</strong>
                            @if($cadet->intake_year)
                                {{ $cadet->intake_year }} / Intake - {{ $cadet->intake_year - 2011 }}
                            @else
                                -
                            @endif
                        </div>
                        <div><strong>Current CGPA:</strong> {{ $cadet->current_cgpa ?? '-' }}</div>
                        <div><strong>IC Number:</strong> {{ $cadet->ic_number ?? '-' }}</div>
                        <div><strong>BMI:</strong> {{ $cadet->BMI ?? '-' }}</div>
                        <div><strong>Swimming Qualification:</strong> {{ $cadet->swimming_qualification ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Side-by-side Cards (Duty Ranking & Tauliah Timer) -->
    <div class="w-full px-6 py-1">
        <div class="flex flex-col lg:flex-row gap-6">

            <!-- Duty Ranking Card -->
            <div class="w-full lg:w-1/2 bg-white shadow border border-transparent rounded-lg p-6 flex flex-col gap-6 transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <h3 class="text-3xl font-bold text-center mb-1">DUTY RANKING</h3>

                <!-- Sort Form -->
                <form method="GET" id="filter-form" class="mb-1 flex justify-center">
                    <div>
                        <select name="sort_order" id="sort_order" class="rounded border-gray-300"
                                onchange="document.getElementById('filter-form').submit();">
                            <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Highest First</option>
                            <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Lowest First</option>
                        </select>
                    </div>
                </form>

                <!-- Leaderboard Bars -->
                <div class="space-y-4 max-h-[600px] overflow-y-auto">
                    @php
                        $maxCount = $dutyCadets->max('daily_duty_count') ?: 1;
                    @endphp
                    @forelse ($dutyCadets as $index => $cadet)
                        @php
                            $percentage = ($cadet->daily_duty_count / $maxCount) * 100;

                            // Gradient from red → yellow → green
                            $ratio = $percentage / 100;

                            if ($ratio < 0.5) {
                                $r = 255;
                                $g = (int)(510 * $ratio); // 0 → 255
                            } else {
                                $r = (int)(510 * (1 - $ratio)); // 255 → 0
                                $g = 255;
                            }
                            $bgColor = "rgb($r, $g, 0)";
                        @endphp

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
                                    #{{ $index + 1 }} - {{ $cadet->user->name ?? '-' }}
                                </div>

                                <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                                    <div
                                        class="absolute top-0 left-0 h-full rounded-full flex items-center"
                                        style="width: {{ $percentage }}%; background-color: {{ $bgColor }};">
                                        <span class="text-white font-semibold text-sm pl-2 whitespace-nowrap">
                                            {{ $cadet->daily_duty_count }} {{ Str::plural('Day', $cadet->daily_duty_count) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500">No cadets available.</div>
                    @endforelse
                </div>
            </div>

            <!-- Tauliah Countdown Card -->
            <div class="w-full lg:w-1/2 bg-white shadow border border-transparent rounded-lg p-6 flex flex-col gap-6 transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <h3 class="text-3xl font-bold text-center mb-1">TAULIAH COUNTDOWN</h3>

                @php
                    $intakeYear = $cadet->intake_year ?? now()->year;
                    $tauliahDate = \Carbon\Carbon::createFromDate($intakeYear + 3, 9, 1); // 3 years later on Sep 1
                    $today = \Carbon\Carbon::today();
                    $daysLeft = $today->diffInDays($tauliahDate, false);
                    $totalPrepDays = 1095; // 3 years in days

                    $progress = min(100, max(0, (1 - ($daysLeft / $totalPrepDays)) * 100));
                    $progressDegrees = floor(($progress / 100) * 360);

                    // Gradient color transition (blue → purple → pink → gold)
                    $dynamicColor = match (true) {
                        $progress < 25 => '#3b82f6',         // Blue
                        $progress < 50 => '#6366f1',         // Indigo
                        $progress < 75 => '#ec4899',         // Pink
                        default       => '#ffd700',          // Gold
                    };
                @endphp

                @if ($daysLeft > 0)
                    <!-- Countdown Circle -->
                    <div class="flex justify-center">
                        <div class="relative w-48 h-48 rounded-full flex items-center justify-center"
                            style="background: conic-gradient({{ $dynamicColor }} {{ $progressDegrees }}deg, #e5e7eb {{ $progressDegrees }}deg);">
                            <div class="absolute bg-white rounded-full w-40 h-40 flex flex-col items-center justify-center">
                                <div class="flex items-baseline justify-center space-x-1">
                                    <div class="text-7xl font-extrabold text-navy-800">
                                        {{ intval($daysLeft) }}
                                    </div>
                                </div>
                                <div class="text-center text-gray-700 mt-1 text-sm font-medium">
                                    Days Left
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- After Countdown -->
                    <div class="flex justify-center items-center text-center text-2xl font-bold text-yellow-600 mt-6">
                        ⚓ Commissioned Officer<br class="block md:hidden" /> – Congratulations!
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
