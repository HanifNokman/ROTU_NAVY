<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadet Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"/>
                    </svg>
                    Cadet Dashboard
                </h1>
                <p class="text-gray-600">Your personal overview and performance metrics</p>
            </div>

            <!-- Profile Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Personal Profile
                    </h2>
                    <p class="text-gray-600">Your profile information and details</p>
                </div>

                <div class="p-6 flex flex-col md:flex-row gap-6">
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
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold px-6 py-2 rounded-xl shadow-lg whitespace-nowrap">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Personal Profile
                            </div>
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
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-address-book w-5 text-blue-500 mr-2"></i>
                                <p class="text-gray-700 font-semibold">Contact Information</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <i class="fas fa-phone w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>Phone:</strong> {{ $cadet?->phone_number ?? 'Not set' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Email:</strong> {{ $user?->email ?? 'Not set' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: General Info -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-info-circle w-5 text-purple-500 mr-2"></i>
                                <p class="text-gray-700 font-semibold">General Information</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <i class="fas fa-venus-mars w-4 text-pink-500 mr-2"></i>
                                    <span class="text-sm"><strong>Gender:</strong> {{ $cadet->gender ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-credit-card w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>Bank Account:</strong> {{ $cadet->bank_account_number ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Service Number:</strong> {{ $cadet->service_number ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-graduation-cap w-4 text-purple-500 mr-2"></i>
                                    <span class="text-sm"><strong>Matric Number:</strong> {{ $cadet->matric_no ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt w-4 text-orange-500 mr-2"></i>
                                    <span class="text-sm">
                                        <strong>Intake Year:</strong>
                                        @if($cadet->intake_year)
                                            {{ $cadet->intake_year }} / Intake - {{ $cadet->intake_year - 2011 }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-chart-line w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>Current CGPA:</strong> {{ $cadet->current_cgpa ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-id-card w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>IC Number:</strong> {{ $cadet->ic_number ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-weight w-4 text-red-500 mr-2"></i>
                                    <span class="text-sm"><strong>BMI:</strong> {{ $cadet->BMI ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-swimmer w-4 text-cyan-500 mr-2"></i>
                                    <span class="text-sm"><strong>Swimming Qualification:</strong> {{ $cadet->swimming_qualification ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Duty Ranking Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-gray-200">
                        <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Duty Ranking
                        </h2>
                        <p class="text-gray-600">Your performance ranking among cadets</p>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-center mb-4">Performance Leaderboard</h3>

                        <!-- Sort Form -->
                        <div class="mb-1 flex justify-center">
                            <div>
                                <select id="sort_order" class="rounded border-gray-300">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Highest First</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Lowest First</option>
                                </select>
                            </div>
                        </div>

                        <!-- Leaderboard Bars -->
                        <div id="duty-ranking-content" class="space-y-4 max-h-[600px] overflow-y-auto">
                            @php
                                $maxCount = $dutyCadets->max('daily_duty_count') ?: 1;
                            @endphp
                            @forelse ($dutyCadets as $index => $cadet)
                                @php
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
                </div>

                <!-- Tauliah Countdown Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 border-b border-gray-200">
                        <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tauliah Countdown
                        </h2>
                        <p class="text-gray-600">Your journey to becoming a commissioned officer</p>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-center mb-4">Commissioning Timeline</h3>

                        @php
                            $intakeYear = $cadet->intake_year ?? now()->year;
                            $tauliahDate = \Carbon\Carbon::createFromDate($intakeYear + 3, 9, 15); // 3 years later on Sep 15
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
                            <div class="flex flex-col items-center text-center mt-1 space-y-4 animate-pulse">
                                <div class="text-2xl md:text-3xl font-semibold text-gray-800">
                                    Congratulations on Your Promotion to <span class="text-yellow-600">Lt. Muda!</span>
                                </div>
                                <div class="text-xl md:text-2xl text-pink-500 font-medium">
                                    Your service, dedication, and leadership are recognized! 🌟
                                </div>
                                <div class="text-3xl animate-bounce mt-4">
                                    🎉🥳🎊
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortSelect = document.getElementById('sort_order');
        const contentContainer = document.getElementById('duty-ranking-content');

        sortSelect.addEventListener('change', function() {
            const sortOrder = this.value;
            
            // Show loading state
            contentContainer.innerHTML = '<div class="text-center text-gray-500 py-4">Loading...</div>';

            // Make AJAX request
            fetch(window.location.pathname + '?sort_order=' + sortOrder, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                contentContainer.innerHTML = data.html;
            })
            .catch(error => {
                console.error('Error:', error);
                contentContainer.innerHTML = '<div class="text-center text-red-500 py-4">Error loading data. Please try again.</div>';
            });
        });
    });
    </script>

</x-app-layout>