<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0121 14.657V8m-9 6l-6.16-3.422A12.083 12.083 0 013 14.657V8"/>
                    </svg>
                    Instructor Dashboard
                </h1>
                <p class="text-gray-600">Your command center for cadet management and analytics</p>
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
                    <p class="text-gray-600">Your profile information and service details</p>
                </div>

                <div class="p-6 flex flex-col md:flex-row gap-6">
                    <!-- Profile Picture -->
                    <div class="flex justify-center lg:justify-start">
                        <img src="{{ $instructor?->profile_pic ? asset('storage/' . $instructor->profile_pic) : asset('images/default.png') }}"
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
                                if (str_starts_with($instructor?->service_number, 'NV')) {
                                    $prefix = ' PSSTLDM'; // include space before
                                } elseif (str_starts_with($instructor?->service_number, 'N')) {
                                    $prefix = ' TLDM'; // include space before
                                }
                            @endphp

                            <p class="text-2xl font-semibold text-gray-800">
                                {{ ($instructor?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') . $prefix }}
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
                                    <span class="text-sm"><strong>Phone:</strong> {{ $instructor?->phone_number ?? 'Not set' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Email:</strong> {{ $user?->email ?? 'Not set' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Service Info -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-medal w-5 text-purple-500 mr-2"></i>
                                <p class="text-gray-700 font-semibold">Service Information</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <i class="fas fa-user-tie w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Position:</strong> {{ $instructor->position ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-brain w-4 text-purple-500 mr-2"></i>
                                    <span class="text-sm"><strong>Expertise:</strong> {{ $instructor->expertise ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock w-4 text-orange-500 mr-2"></i>
                                    <span class="text-sm"><strong>Service Years:</strong> {{ $instructor->time_in_service ? $instructor->time_in_service . ' Years' : '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-certificate w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>TTP:</strong> {{ $instructor->ttp ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>Status:</strong> {{ $instructor->status ?? '-' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Service Number:</strong> {{ $instructor->service_number ?? '-' }}</span>
                                </div>
                                <div class="flex items-center col-span-2">
                                    <i class="fas fa-building w-4 text-gray-500 mr-2"></i>
                                    <span class="text-sm"><strong>Past Units:</strong> {{ is_array($instructor->past_unit) ? implode(', ', $instructor->past_unit) : ($instructor->past_unit ?? '-') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Metrics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Duty Ranking Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300"
                    x-data="{ open: false, selected: [] }">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    Duty Ranking
                                </h2>
                                <p class="text-gray-600">Manage cadet duty assignments and performance</p>
                            </div>
                            <button
                                @click="$store.modal.open = true"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors shadow-md">
                                <i class="fas fa-plus mr-2"></i>Add Duty
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Filter Form for Duty Ranking -->
                        <form method="GET" id="duty-filter-form" class="mb-4 flex justify-center">
                            <input type="hidden" name="cgpa_intake_year" value="{{ $selectedCgpaIntakeYear }}">

                            <div class="flex gap-2">
                                <select name="duty_intake_year" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                                    @foreach ($intakeOptions as $option)
                                        <option value="{{ $option['year'] }}" {{ $selectedDutyIntakeYear == $option['year'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <select name="sort_order" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Highest First</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Lowest First</option>
                                </select>
                            </div>
                        </form>

                        <!-- Leaderboard Bars -->
                        <div class="space-y-4 max-h-[600px] overflow-y-auto">
                            @php
                                $maxCount = $cadets->max('daily_duty_count') ?: 1;
                            @endphp

                            @forelse ($cadets as $index => $cadet)
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
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Bar + Name -->
                                    <div class="flex-1 w-full">
                                        <div class="text-sm font-medium mb-1 text-center sm:text-left">
                                            #{{ $index + 1 }} - {{ $cadet->name }}
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

                        <script>
                            document.addEventListener('alpine:init', () => {
                                Alpine.store('modal', {
                                    open: false,
                                    selected: []
                                });
                            });
                        </script>

                        <!-- Duty Increment Modal -->
                        <div x-show="$store.modal.open"
                            x-cloak
                            x-transition
                            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
                            @click.self="$store.modal.open = false; $store.modal.selected = []">

                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg max-h-[80vh] overflow-y-auto relative">
                                <!-- X Close Button -->
                                <button 
                                    @click="$store.modal.open = false; $store.modal.selected = []"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                                    ×
                                </button>

                                <h2 class="text-xl font-bold mb-4 text-center pr-8">Select Cadets on Duty</h2>

                                <ul class="space-y-2">
                                    @foreach ($cadetList as $cadet)
                                        <li class="flex items-center justify-between border p-2 rounded">
                                            <span>{{ $cadet->user->name }} ({{ $cadet->service_number }})</span>
                                            <input type="checkbox" x-model="$store.modal.selected" value="{{ $cadet->id }}">
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="mt-6 text-center">
                                    <button
                                        @click="
                                            fetch('{{ route('instructor.incrementDuty') }}', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: JSON.stringify({ cadet_ids: $store.modal.selected })
                                            }).then(response => {
                                                if (response.ok) {
                                                    $store.modal.open = false;
                                                    $store.modal.selected = [];
                                                    location.reload();
                                                }
                                            }).catch(error => {
                                                console.error('Error:', error);
                                            });
                                        "
                                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                        <i class="fas fa-plus mr-2"></i>Add Duty Count
                                     </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cadet CGPA Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300"
                    x-data="{ showDistribution: false }">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    Cadet CGPA Analytics
                                </h2>
                                <p class="text-gray-600">Academic performance tracking and comparison</p>
                            </div>
                            <button
                                @click="showDistribution = !showDistribution"
                                class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors shadow-md">
                                <span x-text="showDistribution ? '📊 Individual View' : '📈 Distribution View'"></span>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Filter Form for CGPA Comparison -->
                        <div x-show="!showDistribution" x-transition>
                            <form method="GET" id="cgpa-filter-form" class="mb-4 flex justify-center gap-2">
                                <input type="hidden" name="duty_intake_year" value="{{ $selectedDutyIntakeYear }}">
                                <input type="hidden" name="sort_order" value="{{ $sortOrder }}">
                                <select name="cgpa_intake_year" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                                    @foreach ($intakeOptions as $option)
                                        <option value="{{ $option['year'] }}" {{ $selectedCgpaIntakeYear == $option['year'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                                    
                                <select name="cgpa_sort_order" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                                    <option value="desc" {{ $cgpaSortOrder == 'desc' ? 'selected' : '' }}>Highest CGPA First</option>
                                    <option value="asc" {{ $cgpaSortOrder == 'asc' ? 'selected' : '' }}>Lowest CGPA First</option>
                                </select>
                            </form>
                        </div>

                        <!-- Distribution Filter (only intake year) -->
                        <div x-show="showDistribution" x-transition>
                            <form method="GET" id="cgpa-distribution-filter-form" class="mb-4 flex justify-center">
                                <input type="hidden" name="duty_intake_year" value="{{ $selectedDutyIntakeYear }}">
                                <input type="hidden" name="sort_order" value="{{ $sortOrder }}">
                                <input type="hidden" name="cgpa_sort_order" value="{{ $cgpaSortOrder }}">
                                <select name="cgpa_intake_year" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm">
                                    @foreach ($intakeOptions as $option)
                                        <option value="{{ $option['year'] }}" {{ $selectedCgpaIntakeYear == $option['year'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- CGPA Comparison Bars (Individual View) -->
                        <div x-show="!showDistribution" x-cloak x-transition class="space-y-4 max-h-[600px] overflow-y-auto">
                            @php
                                $maxCgpa = max($cgpaCadets->max('current_cgpa'), $cgpaCadets->max('past_cgpa')) ?: 4.0;
                            @endphp

                            @forelse ($cgpaCadets as $index => $cadet)
                                @php
                                    $pastPercentage = ($cadet->past_cgpa / $maxCgpa) * 100;
                                    $currentPercentage = ($cadet->current_cgpa / $maxCgpa) * 100;
                                    $cgpaChange = $cadet->current_cgpa - $cadet->past_cgpa;
                                        
                                    // Color logic: green if improved, red if declined
                                    $currentColor = $cgpaChange >= 0 ? '#10b981' : '#ef4444'; // green-500 or red-500
                                    $pastColor = '#3b82f6'; // blue-500
                                @endphp

                                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                                    <!-- Avatar -->
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Bar + Name -->
                                    <div class="flex-1 w-full">
                                        <div class="text-sm font-medium mb-1 text-center sm:text-left flex justify-between items-center">
                                            <span>#{{ $index + 1 }} - {{ $cadet->name }}</span>
                                            <span class="text-xs {{ $cgpaChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $cgpaChange >= 0 ? '+' : '' }}{{ number_format($cgpaChange, 2) }}
                                            </span>
                                        </div>

                                        <!-- Current CGPA Bar -->
                                        <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                                            <div class="absolute top-0 left-0 h-full rounded-full"
                                                style="width: {{ $currentPercentage }}%; background-color: {{ $currentColor }};">
                                            </div>
                                            <span class="absolute inset-0 flex items-center justify-start pl-2 text-white font-semibold text-xs">
                                                Current: {{ number_format($cadet->current_cgpa, 2) }}
                                            </span>
                                        </div>

                                        <!-- Past CGPA Bar (Background) -->
                                        <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden mb-1">
                                            <div class="absolute top-0 left-0 h-full rounded-full"
                                                style="width: {{ $pastPercentage }}%; background-color: {{ $pastColor }};">
                                            </div>
                                            <span class="absolute inset-0 flex items-center justify-start pl-2 text-white font-semibold text-xs">
                                                Past: {{ number_format($cadet->past_cgpa, 2) }}
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500">No CGPA data available for this intake.</div>
                            @endforelse
                        </div>

                        <!-- CGPA Distribution Chart (Distribution View) -->
                        <div x-show="showDistribution" x-cloak x-transition class="max-h-[600px] overflow-y-auto">
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-1 h-full">
                                @foreach ($cgpaDistribution as $range)
                                    @php
                                        $MAX_BAR_HEIGHT = 160;
                                        $pastHeight = $maxCount > 0 ? ($range['past_count'] / $maxCount) * $MAX_BAR_HEIGHT : 0;
                                        $currentHeight = $maxCount > 0 ? ($range['current_count'] / $maxCount) * $MAX_BAR_HEIGHT : 0;
                                        $barColor = $range['current_count'] >= $range['past_count'] ? '#10b981' : '#ef4444';
                                    @endphp

                                    <div class="flex flex-col items-center">
                                        <div class="flex-1 flex items-end justify-center gap-1 w-full max-h-80">
                                            
                                            <!-- Past CGPA Bar -->
                                            <div class="flex flex-col items-center">
                                                @if ($range['past_count'] > 0)
                                                    <div class="w-6 bg-blue-500 rounded-t flex items-end justify-center transition-all duration-300"
                                                        style="height: {{ $pastHeight }}px; min-height: 20px;">
                                                        <span class="text-white text-xs font-bold mb-0.5">{{ $range['past_count'] }}</span>
                                                    </div>
                                                @else
                                                    <!-- Empty bar placeholder to keep layout consistent -->
                                                    <div class="w-6" style="height: 20px;"></div>
                                                @endif
                                                <div class="text-xs text-blue-600 font-medium mt-0.5">Past</div>
                                            </div>

                                            <!-- Current CGPA Bar -->
                                            <div class="flex flex-col items-center">
                                                @if ($range['current_count'] > 0)
                                                    <div class="w-6 rounded-t flex items-end justify-center transition-all duration-300"
                                                        style="height: {{ $currentHeight }}px; min-height: 20px; background-color: {{ $barColor }};">
                                                        <span class="text-white text-xs font-bold mb-0.5">{{ $range['current_count'] }}</span>
                                                    </div>
                                                @else
                                                    <!-- Empty bar placeholder to keep layout consistent -->
                                                    <div class="w-6" style="height: 20px;"></div>
                                                @endif
                                                <div class="text-xs font-medium mt-0.5" style="color: {{ $barColor }};">Current</div>
                                            </div>

                                        </div>

                                        <!-- Range label -->
                                        <div class="text-xs font-medium text-center mt-2">
                                            {{ $range['label'] }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Distribution Summary -->
                            <div class="mt-4 text-center">
                                <h4 class="font-semibold text-lg mb-2">CGPA Distribution Summary</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                                    @foreach ($cgpaDistribution as $range)
                                        <div class="flex justify-between items-center bg-gray-50 px-3 py-2 rounded-lg">
                                            <span class="font-medium">{{ $range['label'] }}:</span>
                                            <div class="flex gap-2">
                                                <span class="text-blue-600">Past: {{ $range['past_count'] }}</span>
                                                <span class="{{ $range['current_count'] >= $range['past_count'] ? 'text-green-600' : 'text-red-600' }}">
                                                    Current: {{ $range['current_count'] }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="flex justify-center gap-4 text-sm mt-4">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-blue-500 rounded"></div>
                                <span>Past CGPA</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-green-500 rounded"></div>
                                <span>Improved</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-red-500 rounded"></div>
                                <span>Declined</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store scroll position when submitting the filter form
        document.addEventListener('DOMContentLoaded', function () {
            const filterForm = document.getElementById('duty-filter-form');

            if (filterForm) {
                filterForm.addEventListener('submit', function () {
                    sessionStorage.setItem('scrollAfterReload', window.scrollY);
                });
            }

            // Restore scroll position after reload (only once)
            const savedScroll = sessionStorage.getItem('scrollAfterReload');
            if (savedScroll !== null) {
                window.scrollTo({ top: parseInt(savedScroll), behavior: 'instant' });
                sessionStorage.removeItem('scrollAfterReload');
            }
        });
    </script>
</x-app-layout>