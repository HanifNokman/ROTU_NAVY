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

                        <script>
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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

            // Event listeners for duty ranking filters
            document.getElementById('duty-intake-year').addEventListener('change', loadDutyRanking);
            document.getElementById('duty-sort-order').addEventListener('change', loadDutyRanking);

            // Event listeners for CGPA analytics filters
            document.getElementById('cgpa-intake-year').addEventListener('change', loadCgpaAnalytics);
            document.getElementById('cgpa-sort-order').addEventListener('change', loadCgpaAnalytics);

            // Make loadDutyRanking globally accessible for the modal
            window.loadDutyRanking = loadDutyRanking;
        });
    </script>
</x-app-layout>