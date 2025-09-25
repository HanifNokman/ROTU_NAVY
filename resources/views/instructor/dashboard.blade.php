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
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span class="flex-shrink-0">Add Duty</span>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Filter Form for Duty Ranking -->
                        <div class="mb-4 flex justify-center">
                            <div class="flex gap-2">
                                <select id="duty-intake-year" class="rounded-md border-gray-300 shadow-sm">
                                    @foreach ($intakeOptions as $option)
                                        <option value="{{ $option['year'] }}" {{ $selectedDutyIntakeYear == $option['year'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <select id="duty-sort-order" class="rounded-md border-gray-300 shadow-sm">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Highest First</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Lowest First</option>
                                </select>
                            </div>
                        </div>

                        <!-- Loading indicator -->
                        <div id="duty-loading" class="hidden text-center py-4">
                            <div class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading...
                            </div>
                        </div>

                        <!-- Leaderboard Bars -->
                        <div id="duty-ranking-content" class="space-y-4 max-h-[600px] overflow-y-auto">
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

                                <div id="modal-cadet-list" class="space-y-2">
                                    <template x-for="cadet in $store.modal.cadets" :key="cadet.id">
                                        <div class="flex items-center justify-between border p-2 rounded">
                                            <span x-text="cadet.name + ' (' + cadet.service_number + ')'"></span>
                                            <input type="checkbox" x-model="$store.modal.selected" :value="cadet.id">
                                        </div>
                                    </template>
                                </div>

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
                                                    loadDutyRanking();
                                                }
                                            }).catch(error => {
                                                console.error('Error:', error);
                                            });
                                        "
                                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 inline-flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        <span>Add Duty Count</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cadet CGPA Card -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
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
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Filter Form for CGPA Comparison -->
                        <div class="mb-4 flex justify-center gap-2">
                            <select id="cgpa-intake-year" class="rounded-md border-gray-300 shadow-sm">
                                @foreach ($intakeOptions as $option)
                                    <option value="{{ $option['year'] }}" {{ $selectedCgpaIntakeYear == $option['year'] ? 'selected' : '' }}>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                                
                            <select id="cgpa-sort-order" class="rounded-md border-gray-300 shadow-sm">
                                <option value="desc" {{ $cgpaSortOrder == 'desc' ? 'selected' : '' }}>Most Improvement</option>
                                <option value="asc" {{ $cgpaSortOrder == 'asc' ? 'selected' : '' }}>Most Decline</option>
                            </select>
                        </div>

                        <!-- Loading indicator -->
                        <div id="cgpa-loading" class="hidden text-center py-4">
                            <div class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading...
                            </div>
                        </div>

                        <!-- CGPA Comparison Bars -->
                        <div id="cgpa-content" class="space-y-4 max-h-[600px] overflow-y-auto">
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
            <!-- Pending Absence Reasons Section with Toggle -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                                <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                <span id="absence-section-title">Pending Absence Reasons</span>
                                @if(isset($absentCadets) && !empty($absentCadets))
                                    <span id="absence-count-badge" class="ml-3 bg-red-500 text-white text-sm px-3 py-1 rounded-full">
                                        {{ collect($absentCadets)->flatten(1)->count() }}
                                    </span>
                                @endif
                            </h2>
                            <p id="absence-section-description" class="text-gray-600">Cadets with training absences requiring documentation</p>
                        </div>
                        <!-- Controls Container -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <!-- View Toggle -->
                            <div class="flex bg-gray-100 rounded-lg p-1 self-stretch sm:self-auto">
                                <button
                                    id="pending-view-btn"
                                    onclick="toggleAbsenceView('pending')"
                                    class="px-3 sm:px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 bg-red-500 text-white shadow-sm flex-1 sm:flex-none"
                                >
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <span class="hidden sm:inline">Pending</span>
                                    <span class="sm:hidden">Pending</span>
                                </button>
                                <button
                                    id="leaderboard-view-btn"
                                    onclick="toggleAbsenceView('leaderboard')"
                                    class="px-3 sm:px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-900 flex-1 sm:flex-none"
                                >
                                    <i class="fas fa-chart-bar mr-1"></i>
                                    <span class="hidden sm:inline">Absence List</span>
                                    <span class="sm:hidden">List</span>
                                </button>
                            </div>

                            <!-- Filter -->
                            <div id="absence-filter-container" class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                                <label for="absence-intake-filter" class="text-sm font-medium text-gray-700 whitespace-nowrap">Filter by Intake:</label>
                                <select id="absence-intake-filter" class="rounded-md border-gray-300 shadow-sm text-sm w-full sm:w-auto">
                                    <option value="">All Intakes</option>
                                    @foreach ($intakeOptions as $option)
                                        <option value="{{ $option['year'] }}" {{ ($selectedAbsenceIntake ?? '') == $option['year'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Loading indicator -->
                    <div id="absence-loading" class="hidden text-center py-4">
                        <div class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Loading absence data...
                        </div>
                    </div>
                    <!-- Pending Absence Data -->
                    <div id="absence-content" class="space-y-4 max-h-[600px] overflow-y-auto">
                        @if(isset($absentCadets) && !empty($absentCadets))
                            @foreach ($absentCadets as $intakeLabel => $cadets)
                                @if(($selectedAbsenceIntake ?? '') === '' || ($selectedAbsenceIntake ?? '') === 'all')
                                    <!-- Show intake grouping when All Intakes is selected -->
                                    <div class="border border-red-200 rounded-lg overflow-hidden">
                                        <div class="bg-red-50 px-4 py-3 border-b border-red-200">
                                            <h4 class="font-semibold text-red-800 flex items-center">
                                                <i class="fas fa-users mr-2"></i>
                                                {{ $intakeLabel }}
                                                <span class="ml-2 bg-red-200 text-red-800 px-2 py-1 rounded-full text-xs">
                                                    {{ count($cadets) }} {{ Str::plural('cadet', count($cadets)) }}
                                                </span>
                                            </h4>
                                        </div>
                                        <div class="p-4 space-y-3">
                                            @foreach($cadets as $cadet)
                                                <!-- Cadet Absence Dropdown -->
                                                <div class="border border-orange-200 rounded-lg overflow-hidden bg-white">
                                                    <button 
                                                        onclick="toggleAbsenceDropdown({{ $cadet->id }})"
                                                        class="w-full flex justify-between items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 transition-colors duration-200"
                                                    >
                                                        <div class="flex items-center space-x-3">
                                                            <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                                <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                                </svg>
                                                            </div>
                                                            <div class="text-left">
                                                                <p class="font-semibold text-gray-900">{{ $cadet->name }}</p>
                                                                <p class="text-sm text-gray-600">Service: {{ $cadet->service_number ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center space-x-3">
                                                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                                {{ count($cadet->pending_absences) }} {{ Str::plural('absence', count($cadet->pending_absences)) }}
                                                            </span>
                                                            <svg 
                                                                id="absence-icon-{{ $cadet->id }}" 
                                                                class="w-5 h-5 text-gray-400 transform transition-transform duration-200" 
                                                                fill="none" 
                                                                stroke="currentColor" 
                                                                viewBox="0 0 24 24"
                                                            >
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    
                                                    <div id="absence-dropdown-{{ $cadet->id }}" class="hidden border-t border-orange-200">
                                                        <div class="p-4 space-y-3">
                                                            <h5 class="font-medium text-gray-800 mb-3 flex items-center">
                                                                <i class="fas fa-list mr-2 text-red-500"></i>
                                                                Missing Documentation for:
                                                            </h5>
                                                            
                                                            @foreach($cadet->pending_absences as $absence)
                                                                <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
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
                                                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-medium self-start sm:self-auto">
                                                                            Pending
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                            @else
                                <!-- Show individual cadets when specific intake is selected -->
                                <div class="p-4 space-y-3">
                                    @foreach($cadets as $cadet)
                                        <!-- Same cadet dropdown structure as above -->
                                        <div class="border border-orange-200 rounded-lg overflow-hidden bg-white">
                                            <button
                                                onclick="toggleAbsenceDropdown({{ $cadet->id }})"
                                                class="w-full flex justify-between items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 transition-colors duration-200"
                                            >
                                                <div class="flex items-center space-x-3">
                                                    <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                    </svg>
                                                </div>
                                                <div class="text-left">
                                                    <p class="font-semibold text-gray-900">{{ $cadet->name }}</p>
                                                    <p class="text-sm text-gray-600">Service: {{ $cadet->service_number ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                    {{ count($cadet->pending_absences) }} {{ Str::plural('absence', count($cadet->pending_absences)) }}
                                                </span>
                                                <svg
                                                    id="absence-icon-{{ $cadet->id }}"
                                                    class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </div>
                                        </button>

                                        <div id="absence-dropdown-{{ $cadet->id }}" class="hidden border-t border-orange-200">
                                            <div class="p-4 space-y-3">
                                                <h5 class="font-medium text-gray-800 mb-3 flex items-center">
                                                    <i class="fas fa-list mr-2 text-red-500"></i>
                                                    Missing Documentation for:
                                                </h5>

                                                @foreach($cadet->pending_absences as $absence)
                                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
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
                                                            <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-medium self-start sm:self-auto">
                                                                Pending
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @endforeach
                        @else
                            <div class="text-center py-16">
                                <div class="mb-6">
                                    <svg class="w-20 h-20 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-semibold text-gray-600 mb-3">All Clear!</h3>
                                <p class="text-gray-500 text-lg">No pending absence reasons found.</p>
                            </div>
                        @endif
                    </div>
                    <!-- Absence Leaderboard (Hidden by default) -->
                    <div id="absence-leaderboard-content" class="hidden space-y-4 max-h-[600px] overflow-y-auto">
                        @if(isset($absenceLeaderboard) && !empty($absenceLeaderboard))
                            @if(($selectedAbsenceIntake ?? '') === '' || ($selectedAbsenceIntake ?? '') === 'all')
                                @foreach ($absenceLeaderboard as $intakeLabel => $cadets)
                                    @if(!empty($cadets))
                                        <div class="border border-yellow-200 rounded-lg overflow-hidden">
                                            <div class="bg-yellow-50 px-4 py-3 border-b border-yellow-200">
                                                <h4 class="font-semibold text-yellow-800 flex items-center">
                                                    <i class="fas fa-users mr-2"></i>
                                                    {{ $intakeLabel }}
                                                    <span class="ml-2 bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                                        {{ count($cadets) }} {{ Str::plural('cadet', count($cadets)) }}
                                                    </span>
                                                </h4>
                                            </div>
                                            <div class="p-4 space-y-3">
                                                @foreach($cadets as $index => $cadet)
                                                    @php
                                                        $attended = $cadet->total_trainings - $cadet->absence_count;
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
                                                                #{{ $index + 1 }} - {{ $cadet->cadet_name }}
                                                            </div>
                                                            <div class="text-center sm:text-left flex flex-col sm:flex-row gap-1 sm:gap-0">
                                                                <span class="text-sm font-semibold text-gray-800">
                                                                    Training Attended: {{ $attended }} / {{ $cadet->total_trainings }}
                                                                </span>
                                                                <span class="text-sm font-semibold text-red-600 sm:ml-4">
                                                                    Total Absence: {{ $cadet->absence_count }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="p-4 space-y-3">
                                    @foreach($absenceLeaderboard as $index => $cadet)
                                        @php
                                            $attended = $cadet->total_trainings - $cadet->absence_count;
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
                                                    #{{ $index + 1 }} - {{ $cadet->cadet_name }}
                                                </div>
                                                <div class="text-center sm:text-left">
                                                    <span class="text-sm font-semibold text-gray-800">
                                                        Training Attended: {{ $attended }} / {{ $cadet->total_trainings }}
                                                    </span>
                                                    <span class="text-sm font-semibold text-red-600 ml-4">
                                                        Total Absence: {{ $cadet->absence_count }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <div class="mb-4">
                                    <svg class="w-16 h-16 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">Perfect Attendance!</h3>
                                <p class="text-gray-500">No training absences recorded.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Global variables to track current view
        let currentAbsenceView = 'pending';
        
        // Toggle function for absence view
        function toggleAbsenceView(view) {
            const pendingBtn = document.getElementById('pending-view-btn');
            const leaderboardBtn = document.getElementById('leaderboard-view-btn');
            const pendingContent = document.getElementById('absence-content');
            const leaderboardContent = document.getElementById('absence-leaderboard-content');
            const sectionTitle = document.getElementById('absence-section-title');
            const sectionDescription = document.getElementById('absence-section-description');
            const countBadge = document.getElementById('absence-count-badge');
            const filterContainer = document.getElementById('absence-filter-container');
            
            if (view === 'pending') {
                // Switch to pending view
                currentAbsenceView = 'pending';
                
                // Update buttons
                pendingBtn.classList.add('bg-red-500', 'text-white', 'shadow-sm');
                pendingBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                leaderboardBtn.classList.remove('bg-yellow-500', 'text-white', 'shadow-sm');
                leaderboardBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                
                // Update content visibility
                pendingContent.classList.remove('hidden');
                leaderboardContent.classList.add('hidden');
                
                // Show filter for pending view
                if (filterContainer) {
                    filterContainer.classList.remove('hidden');
                }
                
                // Update header
                sectionTitle.textContent = 'Pending Absence Reasons';
                sectionDescription.textContent = 'Cadets with training absences requiring documentation';
                if (countBadge) countBadge.classList.remove('hidden');
                
            } else if (view === 'leaderboard') {
                // Switch to leaderboard view
                currentAbsenceView = 'leaderboard';
                
                // Update buttons
                leaderboardBtn.classList.add('bg-yellow-500', 'text-white', 'shadow-sm');
                leaderboardBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                pendingBtn.classList.remove('bg-red-500', 'text-white', 'shadow-sm');
                pendingBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                
                // Update content visibility
                leaderboardContent.classList.remove('hidden');
                pendingContent.classList.add('hidden');
                
                // Hide filter for leaderboard view (shows all intakes)
                if (filterContainer) {
                    filterContainer.classList.add('hidden');
                }
                
                // Update header
                sectionTitle.textContent = 'Absence Summary - All Intakes';
                sectionDescription.textContent = 'Overview of cadets requiring attendance improvement';
                if (countBadge) countBadge.classList.add('hidden');
            }
        }

        // Make toggleAbsenceView globally accessible
        window.toggleAbsenceView = toggleAbsenceView;

        // AJAX function for duty ranking
        function loadDutyRanking() {
            const intakeYear = document.getElementById('duty-intake-year').value;
            const sortOrder = document.getElementById('duty-sort-order').value;

            // Show loading indicator
            document.getElementById('duty-loading').classList.remove('hidden');
            document.getElementById('duty-ranking-content').classList.add('opacity-50');

            // Create form data
            const formData = new FormData();
            formData.append('duty_intake_year', intakeYear);
            formData.append('sort_order', sortOrder);
            formData.append('cgpa_intake_year', document.getElementById('cgpa-intake-year').value);
            formData.append('cgpa_sort_order', document.getElementById('cgpa-sort-order').value);

            fetch('{{ route("instructor.dashboard") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Duty ranking AJAX response:', data);
                if (data.duty_html) {
                    document.getElementById('duty-ranking-content').innerHTML = data.duty_html;
                }
                if (data.cadet_list) {
                    // Update the modal cadet list
                    Alpine.store('modal').cadets = data.cadet_list;
                }
            })
            .catch(error => {
                console.error('Error loading duty ranking:', error);
            })
            .finally(() => {
                // Hide loading indicator
                document.getElementById('duty-loading').classList.add('hidden');
                document.getElementById('duty-ranking-content').classList.remove('opacity-50');
            });
        }

        // AJAX function for CGPA analytics
        function loadCgpaAnalytics() {
            const intakeYear = document.getElementById('cgpa-intake-year').value;
            const sortOrder = document.getElementById('cgpa-sort-order').value;

            // Show loading indicator
            document.getElementById('cgpa-loading').classList.remove('hidden');
            document.getElementById('cgpa-content').classList.add('opacity-50');

            // Create form data
            const formData = new FormData();
            formData.append('duty_intake_year', document.getElementById('duty-intake-year').value);
            formData.append('sort_order', document.getElementById('duty-sort-order').value);
            formData.append('cgpa_intake_year', intakeYear);
            formData.append('cgpa_sort_order', sortOrder);

            fetch('{{ route("instructor.dashboard") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('CGPA analytics AJAX response:', data);
                if (data.cgpa_html) {
                    document.getElementById('cgpa-content').innerHTML = data.cgpa_html;
                }
            })
            .catch(error => {
                console.error('Error loading CGPA analytics:', error);
            })
            .finally(() => {
                // Hide loading indicator
                document.getElementById('cgpa-loading').classList.add('hidden');
                document.getElementById('cgpa-content').classList.remove('opacity-50');
            });
        }

        // AJAX function for absence data
        function loadAbsenceData() {
            const intakeFilter = document.getElementById('absence-intake-filter').value;

            // Show loading indicator
            document.getElementById('absence-loading').classList.remove('hidden');
            
            // Add opacity to both content areas
            const pendingContent = document.getElementById('absence-content');
            const leaderboardContent = document.getElementById('absence-leaderboard-content');
            
            if (pendingContent) pendingContent.classList.add('opacity-50');
            if (leaderboardContent) leaderboardContent.classList.add('opacity-50');

            // Create form data - IMPORTANT: Include all current filter states
            const formData = new FormData();
            formData.append('absence_intake_filter', intakeFilter);
            
            // Also include other filters to maintain state
            formData.append('duty_intake_year', document.getElementById('duty-intake-year').value);
            formData.append('sort_order', document.getElementById('duty-sort-order').value);
            formData.append('cgpa_intake_year', document.getElementById('cgpa-intake-year').value);
            formData.append('cgpa_sort_order', document.getElementById('cgpa-sort-order').value);

            fetch('{{ route("instructor.dashboard") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Absence data AJAX response:', data);
                
                if (data.absence_html && pendingContent) {
                    pendingContent.innerHTML = data.absence_html;
                }
                if (data.absence_leaderboard_html && leaderboardContent) {
                    leaderboardContent.innerHTML = data.absence_leaderboard_html;
                }
                
                // Update the count badge if present
                const countBadge = document.getElementById('absence-count-badge');
                if (countBadge && data.absence_count !== undefined) {
                    if (data.absence_count > 0) {
                        countBadge.textContent = data.absence_count;
                        countBadge.classList.remove('hidden');
                    } else {
                        countBadge.classList.add('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error loading absence data:', error);
            })
            .finally(() => {
                // Hide loading indicator and remove opacity
                document.getElementById('absence-loading').classList.add('hidden');
                if (pendingContent) pendingContent.classList.remove('opacity-50');
                if (leaderboardContent) leaderboardContent.classList.remove('opacity-50');
            });
        }

        // Event listeners for duty ranking filters
        document.getElementById('duty-intake-year').addEventListener('change', loadDutyRanking);
        document.getElementById('duty-sort-order').addEventListener('change', loadDutyRanking);

        // Event listeners for CGPA analytics filters
        document.getElementById('cgpa-intake-year').addEventListener('change', loadCgpaAnalytics);
        document.getElementById('cgpa-sort-order').addEventListener('change', loadCgpaAnalytics);

        // Event listener for absence filter
        document.getElementById('absence-intake-filter').addEventListener('change', loadAbsenceData);

        // Make loadDutyRanking globally accessible for the modal
        window.loadDutyRanking = loadDutyRanking;

        // Dropdown toggle function
        window.toggleAbsenceDropdown = function(cadetId) {
            const dropdown = document.getElementById('absence-dropdown-' + cadetId);
            const icon = document.getElementById('absence-icon-' + cadetId);
            
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                dropdown.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        };
    });

    // Alpine.js initialization for modal functionality
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            open: false,
            selected: [],
            cadets: @json($cadetList->map(function($cadet) {
                return [
                    'id' => $cadet->id,
                    'name' => $cadet->user->name,
                    'service_number' => $cadet->service_number
                ];
            }))
        });
    });

    // Update modal cadets when AJAX response includes cadet_list
    document.addEventListener('DOMContentLoaded', function() {
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            return originalFetch.apply(this, args).then(response => {
                if (response.url.includes('instructor/dashboard') && args[1] && args[1].body) {
                    response.clone().json().then(data => {
                        if (data.cadet_list) {
                            Alpine.store('modal').cadets = data.cadet_list;
                        }
                    });
                }
                return response;
            });
        };
    });
</script>
</x-app-layout>