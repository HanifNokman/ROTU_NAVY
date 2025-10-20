<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadet Dashboard') }}
        </h2>
    </x-slot>

    <style>
    #duty-ranking-content {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    #cgpa-content {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    #duty-ranking-content::-webkit-scrollbar,
    #cgpa-content::-webkit-scrollbar {
        width: 8px;
    }

    #duty-ranking-content::-webkit-scrollbar-track,
    #cgpa-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #duty-ranking-content::-webkit-scrollbar-thumb,
    #cgpa-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    #duty-ranking-content::-webkit-scrollbar-thumb:hover,
    #cgpa-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #duty-ranking-content,
    #cgpa-content {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    #duty-ranking-content,
    #cgpa-content {
        scroll-behavior: smooth;
    }

    .duty-ranking-wrapper,
    .cgpa-wrapper {
        position: relative;
    }

    .badge-icon-mini {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }

    /* Scrollbar styling for intake table */
    .max-h-\[500px\]::-webkit-scrollbar {
        width: 8px;
    }

    .max-h-\[500px\]::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .max-h-\[500px\]::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .max-h-\[500px\]::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- HEADER SECTION --}}
            {{-- ================================================================ --}}
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

            {{-- ================================================================ --}}
            {{-- PROFILE SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300"
                x-data="{ open: false }">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200 cursor-pointer"
                    @click="open = !open">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center justify-between text-gray-900">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Personal Profile
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200"
                            :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </h2>
                    <p class="text-gray-600">Your profile information and details</p>
                </div>

                <div class="p-6 flex flex-col md:flex-row gap-6"
                    x-show="open"
                    x-transition>
                    {{-- Profile Picture --}}
                    <div class="flex justify-center lg:justify-start">
                        <img src="{{ $cadet?->profile_pic ? asset('storage/' . $cadet->profile_pic) : asset('images/default.png') }}"
                            alt="Profile Picture"
                            class="w-40 h-52 md:w-60 md:h-80 object-cover border rounded-md">
                    </div>

                    {{-- Profile Information --}}
                    <div class="flex-1 space-y-6">
                        {{-- Rank and Name --}}
                        <div class="flex items-center justify-center md:justify-start gap-4">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold px-6 py-2 rounded-xl shadow-lg whitespace-nowrap">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Personal Profile
                            </div>
                            @php
                                $prefix = '';
                                if (trim($cadet?->rank) === 'Lt.M') {
                                    $prefix = ' PSSTLDM';
                                }
                            @endphp
                            <p class="text-2xl font-semibold text-gray-800">
                                {{ ($cadet?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') . $prefix }}
                            </p>
                        </div>

                        {{-- Contact Information --}}
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

                        {{-- General Information --}}
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
                                    <i class="fas fa-university w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Faculty:</strong> {{ $cadet->faculty ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-book w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>Course:</strong> {{ $cadet->course ?? '-' }}</span>
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
            {{-- ================================================================ --}}
            {{-- MY INTAKE SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300"
                x-data="{ open: false }">
                <div class="bg-gradient-to-r from-cyan-50 to-teal-50 p-6 border-b border-gray-200 cursor-pointer"
                    @click="open = !open">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center justify-between text-gray-900">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-2 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            My Intake
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200"
                            :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </h2>
                    <p class="text-gray-600">View all cadets in your intake with their achievements</p>
                </div>

                <div class="p-6"
                    x-show="open"
                    x-transition>
                    <div class="overflow-x-auto">
                        <div class="max-h-[500px] overflow-y-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100 sticky top-0">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Service No.</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rank</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Position</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rating</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total Points</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Badges</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($intakeCadets as $intakeCadet)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $intakeCadet->service_number ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $intakeCadet->rank ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $intakeCadet->user->name ?? 'N/A' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $intakeCadet->position ?? 'Normal Cadet' }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                <span class="text-xl">{{ $intakeCadet->performanceRating->rating ?? '⭐☆☆☆☆' }}</span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                                {{ number_format($intakeCadet->performanceRating->total_points ?? 0, 2) }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-1">
                                                    @forelse($intakeCadet->cadetBadges->take(3) as $cadetBadge)
                                                        @if($cadetBadge->badge->icon_path)
                                                            <img src="{{ asset('storage/badges/' . $cadetBadge->badge->icon_path) }}" 
                                                                alt="{{ $cadetBadge->badge->name }}"
                                                                title="{{ $cadetBadge->badge->name }}"
                                                                class="badge-icon-mini">
                                                        @else
                                                            <span class="text-2xl" title="{{ $cadetBadge->badge->name }}">🏆</span>
                                                        @endif
                                                    @empty
                                                        <span class="text-xs text-gray-400">No badges</span>
                                                    @endforelse
                                                    @if($intakeCadet->cadetBadges->count() > 3)
                                                        <span class="text-xs text-gray-500 ml-1">+{{ $intakeCadet->cadetBadges->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                <button onclick="openCadetModal({{ $intakeCadet->id }})"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-xs font-medium transition-colors duration-150">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                                No cadets found in your intake.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- PERFORMANCE METRICS SECTION --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Duty Ranking Card --}}
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

                        {{-- Sort Form --}}
                        <div class="mb-1 flex justify-center">
                            <div>
                                <select id="sort_order" class="rounded border-gray-300">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Highest First</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Lowest First</option>
                                </select>
                            </div>
                        </div>

                        {{-- Leaderboard Bars --}}
                        <div class="duty-ranking-wrapper">
                            <div id="duty-ranking-content" class="space-y-4">
                                @php
                                    $maxCount = $dutyCadets->max('daily_duty_count') ?: 1;
                                @endphp
                                @forelse ($dutyCadets as $index => $cadet)
                                    @php
                                        $percentage = ($cadet->daily_duty_count / $maxCount) * 100;

                                        if ($percentage < 50) {
                                            $ratio = $percentage / 50;
                                            $r = 255;
                                            $g = (int)(180 * $ratio);
                                        } else {
                                            $ratio = ($percentage - 50) / 50;
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
                                                <div class="absolute top-0 left-0 h-full rounded-full flex items-center"
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
                </div>

                {{-- Tauliah Countdown Card --}}
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
                            $tauliahDate = \Carbon\Carbon::createFromDate($intakeYear + 3, 9, 15);
                            $today = \Carbon\Carbon::today();
                            $daysLeft = $today->diffInDays($tauliahDate, false);
                            $totalPrepDays = 1095;

                            $progress = min(100, max(0, (1 - ($daysLeft / $totalPrepDays)) * 100));
                            $progressDegrees = floor(($progress / 100) * 360);

                            $dynamicColor = match (true) {
                                $progress < 25 => '#3b82f6',
                                $progress < 50 => '#6366f1',
                                $progress < 75 => '#ec4899',
                                default => '#ffd700',
                            };
                        @endphp

                        @if ($daysLeft > 0)
                            {{-- Countdown Circle --}}
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
                            {{-- Congratulations Message --}}
                            <div class="flex flex-col items-center text-center mt-1 space-y-4 animate-pulse">
                                <div class="text-2xl md:text-3xl font-semibold text-gray-800">
                                    Congratulations on Your Promotion to <span class="text-yellow-600">Lt. Muda!</span>
                                </div>
                                <div class="text-xl md:text-2xl text-pink-500 font-medium">
                                    Your service, dedication, and leadership are recognized! 🌟
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            {{-- ================================================================ --}}
            {{-- INTAKE ABSENCE TRACKING SECTION --}}
            {{-- Only visible for CO, Thana, Zayn positions --}}
            {{-- ================================================================ --}}
            @if(in_array($cadet->position ?? '', ['CO', 'Thana', 'Zayn']))
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                                <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                <span id="cadet-absence-section-title">Intake Absence Tracking</span>
                                @if(isset($absentCadets) && !empty($absentCadets))
                                    <span id="cadet-absence-count-badge" class="ml-3 bg-red-500 text-white text-sm px-3 py-1 rounded-full">
                                        {{ count($absentCadets) }}
                                    </span>
                                @endif
                            </h2>
                            <p id="cadet-absence-section-description" class="text-gray-600">Track your intake mates requiring absence documentation</p>
                        </div>

                        {{-- View Toggle --}}
                        <div class="flex bg-gray-100 rounded-lg p-1">
                            <button 
                                id="cadet-pending-view-btn"
                                onclick="toggleCadetAbsenceView('pending')"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 bg-red-500 text-white shadow-sm">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Pending
                            </button>
                            <button 
                                id="cadet-leaderboard-view-btn"
                                onclick="toggleCadetAbsenceView('leaderboard')"
                                class="px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-900">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Absence List
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    {{-- Pending Absence Data --}}
                    <div id="cadet-absence-content" class="space-y-4 max-h-[600px] overflow-y-auto">
                        @if(isset($absentCadets) && !empty($absentCadets))
                            @foreach($absentCadets as $cadetData)
                                <div class="border border-orange-200 rounded-lg overflow-hidden bg-white">
                                    <button 
                                        onclick="toggleAbsenceDropdown({{ $cadetData->id }})"
                                        class="w-full flex justify-between items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                            <div class="text-left">
                                                <p class="font-semibold text-gray-900">{{ $cadetData->name }}</p>
                                                <p class="text-sm text-gray-600">Service: {{ $cadetData->service_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                {{ count($cadetData->pending_absences) }} {{ Str::plural('absence', count($cadetData->pending_absences)) }}
                                            </span>
                                            <svg 
                                                id="absence-icon-{{ $cadetData->id }}" 
                                                class="w-5 h-5 text-gray-400 transform transition-transform duration-200" 
                                                fill="none" 
                                                stroke="currentColor" 
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </button>
                                    
                                    <div id="absence-dropdown-{{ $cadetData->id }}" class="hidden border-t border-orange-200">
                                        <div class="p-4 space-y-3">
                                            <h5 class="font-medium text-gray-800 mb-3 flex items-center">
                                                <i class="fas fa-list mr-2 text-red-500"></i>
                                                Missing Documentation for:
                                            </h5>
                                            
                                            @foreach($cadetData->pending_absences as $absence)
                                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex-1">
                                                            <h6 class="font-semibold text-red-900">{{ $absence->training_title }}</h6>
                                                            <div class="text-sm text-red-700 space-y-1 mt-2">
                                                                <div class="flex items-center">
                                                                    <i class="fas fa-calendar w-4 text-red-500 mr-2"></i>
                                                                    <span>{{ $absence->training_date }}</span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <i class="fas fa-map-marker-alt w-4 text-red-500 mr-2"></i>
                                                                    <span>{{ $absence->training_location }}</span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <i class="fas fa-exclamation-triangle w-4 text-orange-500 mr-2"></i>
                                                                    <span class="text-xs">
                                                                        Missing: {{ $absence->missing_items }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-medium ml-3">
                                                            Pending
                                                        </span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-16">
                                <div class="mb-6">
                                    <svg class="w-20 h-20 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-semibold text-gray-600 mb-3">All Clear!</h3>
                                <p class="text-gray-500 text-lg">No intake mates have pending absence reasons.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Absence Leaderboard --}}
                    <div id="cadet-absence-leaderboard-content" class="hidden space-y-4 max-h-[600px] overflow-y-auto">
                        @if(isset($absenceLeaderboard) && !empty($absenceLeaderboard))
                            @foreach($absenceLeaderboard as $index => $cadetData)
                                @php
                                    $attended = $cadetData->total_trainings - $cadetData->absence_count;
                                @endphp
                                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 w-full">
                                        <div class="text-sm font-medium mb-1 text-center sm:text-left">
                                            #{{ $index + 1 }} - {{ $cadetData->cadet_name }}
                                        </div>
                                        <div class="text-center sm:text-left flex flex-col sm:flex-row gap-1 sm:gap-0">
                                            <span class="text-sm font-semibold text-gray-800">
                                                Training Attended: {{ $attended }} / {{ $cadetData->total_trainings }}
                                            </span>
                                            <span class="text-sm font-semibold text-red-600 sm:ml-4">
                                                Total Absence: {{ $cadetData->absence_count }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <div class="mb-4">
                                    <svg class="w-16 h-16 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                @if($cadets->count() > 0)
                                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Perfect Attendance!</h3>
                                    <p class="text-gray-500">No training absences recorded in your intake.</p>
                                @else
                                    <h3 class="text-xl font-semibold text-gray-600 mb-2">No Cadets</h3>
                                    <p class="text-gray-500">No cadets in your intake.</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CADET DETAILS MODAL --}}
    {{-- ================================================================ --}}
    <div id="cadetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
            {{-- Modal Header --}}
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-2xl font-semibold text-gray-900">Cadet Details</h3>
                <button onclick="closeCadetModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div id="cadetModalContent" class="mt-4">
                {{-- Loading spinner --}}
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ================================================================
            // SCROLL DETECTION FOR DUTY RANKING
            // ================================================================
            function checkScrollableContent() {
                // Check Duty Ranking
                const dutyContainer = document.getElementById('duty-ranking-content');
                const dutyWrapper = dutyContainer?.closest('.duty-ranking-wrapper');
                
                if (dutyContainer && dutyWrapper) {
                    if (dutyContainer.scrollHeight > dutyContainer.clientHeight) {
                        dutyWrapper.classList.add('has-scroll');
                    } else {
                        dutyWrapper.classList.remove('has-scroll');
                    }
                }
            }

            // Check on load and after updates
            checkScrollableContent();
            window.addEventListener('resize', checkScrollableContent);

            // ================================================================
            // CADET ABSENCE VIEW TOGGLE
            // ================================================================
            function toggleCadetAbsenceView(view) {
                const pendingBtn = document.getElementById('cadet-pending-view-btn');
                const leaderboardBtn = document.getElementById('cadet-leaderboard-view-btn');
                const pendingContent = document.getElementById('cadet-absence-content');
                const leaderboardContent = document.getElementById('cadet-absence-leaderboard-content');
                const sectionTitle = document.getElementById('cadet-absence-section-title');
                const sectionDescription = document.getElementById('cadet-absence-section-description');
                const countBadge = document.getElementById('cadet-absence-count-badge');
                
                if (view === 'pending') {
                    pendingBtn.classList.add('bg-red-500', 'text-white', 'shadow-sm');
                    pendingBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                    leaderboardBtn.classList.remove('bg-yellow-500', 'text-white', 'shadow-sm');
                    leaderboardBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                    
                    pendingContent.classList.remove('hidden');
                    leaderboardContent.classList.add('hidden');
                    
                    sectionTitle.textContent = 'Intake Absence Tracking';
                    sectionDescription.textContent = 'Track your intake mates requiring absence documentation';
                    if (countBadge) countBadge.classList.remove('hidden');
                    
                } else if (view === 'leaderboard') {
                    leaderboardBtn.classList.add('bg-yellow-500', 'text-white', 'shadow-sm');
                    leaderboardBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                    pendingBtn.classList.remove('bg-red-500', 'text-white', 'shadow-sm');
                    pendingBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                    
                    leaderboardContent.classList.remove('hidden');
                    pendingContent.classList.add('hidden');
                    
                    sectionTitle.textContent = 'Intake Absence Summary';
                    sectionDescription.textContent = 'Overview of intake mates requiring attendance improvement';
                    if (countBadge) countBadge.classList.add('hidden');
                }
            }

            window.toggleCadetAbsenceView = toggleCadetAbsenceView;

            // ================================================================
            // DUTY RANKING SORT
            // ================================================================
            const sortSelect = document.getElementById('sort_order');
            const contentContainer = document.getElementById('duty-ranking-content');

            if (sortSelect && contentContainer) {
                sortSelect.addEventListener('change', function() {
                    const sortOrder = this.value;
                    
                    contentContainer.innerHTML = '<div class="text-center text-gray-500 py-4">Loading...</div>';

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
                        // Check scroll after content update
                        setTimeout(checkScrollableContent, 100);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        contentContainer.innerHTML = '<div class="text-center text-red-500 py-4">Error loading data. Please try again.</div>';
                    });
                });
            }

            // ================================================================
            // ABSENCE DROPDOWN TOGGLE
            // ================================================================
            window.toggleAbsenceDropdown = function(cadetId) {
                const dropdown = document.getElementById('absence-dropdown-' + cadetId);
                const icon = document.getElementById('absence-icon-' + cadetId);
                
                if (dropdown && icon) {
                    if (dropdown.classList.contains('hidden')) {
                        dropdown.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        dropdown.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            };
        });

        // ================================================================
        // CADET MODAL FUNCTIONS
        // ================================================================
        function openCadetModal(cadetId) {
            const modal = document.getElementById('cadetModal');
            const modalContent = document.getElementById('cadetModalContent');
            
            modal.classList.remove('hidden');
            
            // Show loading spinner
            modalContent.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                </div>
            `;
            
            // Fetch cadet details
            fetch(`/cadet/cadet/${cadetId}/details`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayCadetDetails(data.cadet);
                    } else {
                        modalContent.innerHTML = '<p class="text-center text-red-500">Error loading cadet details.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.innerHTML = '<p class="text-center text-red-500">Error loading cadet details.</p>';
                });
        }

        function closeCadetModal() {
            document.getElementById('cadetModal').classList.add('hidden');
        }

        function displayCadetDetails(cadet) {
            const modalContent = document.getElementById('cadetModalContent');
            
            let badgesHtml = '';
            if (cadet.badges && cadet.badges.length > 0) {
                badgesHtml = cadet.badges.map(badge => `
                    <div class="bg-white border-2 border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            ${badge.icon_path ? 
                                `<img src="/storage/badges/${badge.icon_path}" alt="${badge.name}" class="w-12 h-12 object-contain">` : 
                                '<span class="text-4xl">🏆</span>'
                            }
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900">${badge.name}</h5>
                                <p class="text-xs text-gray-600 mt-1">${badge.description}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs ${badge.rarity_color} font-medium">${badge.rarity_label}</span>
                                    <span class="text-xs text-gray-500">Unlocked: ${badge.unlocked_at}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                badgesHtml = '<p class="text-center text-gray-500 py-8">No badges unlocked yet.</p>';
            }
            
            modalContent.innerHTML = `
                <div class="space-y-6">
                    {{-- Profile Section --}}
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-shrink-0">
                            <img src="${cadet.profile_pic}" 
                                alt="${cadet.name}"
                                class="w-32 h-40 md:w-40 md:h-52 object-cover border rounded-md">
                        </div>
                        
                        <div class="flex-1 space-y-4">
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">${cadet.rank} ${cadet.name}</h4>
                                <p class="text-sm text-gray-600">${cadet.position}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="font-medium text-gray-700">Service Number:</span>
                                    <span class="text-gray-900">${cadet.service_number}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Matric Number:</span>
                                    <span class="text-gray-900">${cadet.matric_no}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Faculty:</span>
                                    <span class="text-gray-900">${cadet.faculty}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Course:</span>
                                    <span class="text-gray-900">${cadet.course}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Email:</span>
                                    <span class="text-gray-900">${cadet.email}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Phone:</span>
                                    <span class="text-gray-900">${cadet.phone_number}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Performance Section --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                        <h5 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Performance Rating
                        </h5>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-4">
                                <div class="text-center">
                                    <p class="text-4xl mb-2">${cadet.rating}</p>
                                    <p class="text-2xl font-bold text-gray-900">${parseFloat(cadet.total_points).toFixed(2)}</p>
                                    <p class="text-sm text-gray-600">Total Points</p>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-4 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Attendance:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.attendance_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Quiz:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.quiz_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Learning Progress:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.learning_progress_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Duty:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.duty_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Academic:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.academic_points).toFixed(2)}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Badges Section --}}
                    <div>
                        <h5 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            Displayed Badges (${cadet.badges ? cadet.badges.length : 0})
                        </h5>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                            ${badgesHtml}
                        </div>
                    </div>
                </div>
            `;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('cadetModal');
            if (event.target === modal) {
                closeCadetModal();
            }
        }
    </script>
</x-app-layout>