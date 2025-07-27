<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Dashboard') }}
        </h2>
    </x-slot>

    <div class="w-full px-6 py-10">
        <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row gap-6 transition duration-300 hover:shadow-2xl hover:border hover:border-blue-300">
            <!-- Profile Picture -->
            <div class="flex-shrink-0 mx-auto md:mx-0">
                <img src="{{ $instructor?->profile_pic ? asset('storage/' . $instructor->profile_pic) : asset('images/default.png') }}"
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
                <div>
                    <p class="text-gray-500 font-semibold mb-2">Contact Information</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <p><strong>Phone:</strong> {{ $instructor?->phone_number ?? 'Not set' }}</p>
                        <p><strong>Email:</strong> {{ $user?->email ?? 'Not set' }}</p>
                    </div>
                </div>

                <!-- Row 3: General Info -->
                <div>
                    <p class="text-gray-500 font-semibold mb-2">General Information</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><strong>Position:</strong> {{ $instructor->position ?? '-' }}</div>
                        <div><strong>Expertise:</strong> {{ $instructor->expertise ?? '-' }}</div>
                        <div><strong>Time in Service:</strong> {{ $instructor->time_in_service ? $instructor->time_in_service . ' Years' : '-' }}</div>
                        <div><strong>TTP:</strong> {{ $instructor->ttp ?? '-' }}</div>
                        <div><strong>Status:</strong> {{ $instructor->status ?? '-' }}</div>
                        <div><strong>Service Number:</strong> {{ $instructor->service_number ?? '-' }}</div>
                        <div><strong>Past Unit:</strong> {{ is_array($instructor->past_unit) ? implode(', ', $instructor->past_unit) : ($instructor->past_unit ?? '-') }}</div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: Duty & CGPA Comparison -->
    <div class="w-full px-6 py-1">
        <div class="flex flex-col lg:flex-row gap-6">

        <!-- LEFT: Duty Ranking Card -->
                    <div class="w-full lg:w-1/2 bg-white shadow border border-transparent rounded-lg p-6 flex flex-col gap-6 transition duration-300 hover:shadow-2xl hover:border-blue-300"
                        x-data="{ open: false, selected: [] }">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-3xl font-bold text-center lg:text-left">DUTY RANKING</h3>
                            <button
                                @click="open = true"
                                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                ➕ Add Duty Count
                            </button>
                        </div>
                        
                        <!-- Filter Form for Duty Ranking -->
                        <form method="GET" id="duty-filter-form" class="mb-1 flex justify-center">
                            <input type="hidden" name="cgpa_intake_year" value="{{ $selectedCgpaIntakeYear }}">
                            <select name="duty_intake_year" onchange="this.form.submit()">
                                @foreach ($intakeOptions as $option)
                                    <option value="{{ $option['year'] }}" {{ $selectedDutyIntakeYear == $option['year'] ? 'selected' : '' }}>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="sort_order" onchange="this.form.submit()">
                                <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Highest First</option>
                                <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Lowest First</option>
                            </select>
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

                        <!-- Duty Increment Modal -->
                        <div x-show="open"
                            x-transition
                            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
                            @click.self="open = false; selected = [];">
                            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg max-h-[80vh] overflow-y-auto relative">
                                <!-- X Close Button -->
                                <button 
                                    @click="open = false; selected = [];"
                                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                                    ×
                                </button>
                                
                                <h2 class="text-xl font-bold mb-4 text-center pr-8">Select Cadets by Seniority</h2>

                                <ul class="space-y-2">
                                    @foreach ($cadetList as $cadet)
                                        <li class="flex items-center justify-between border p-2 rounded">
                                            <span>{{ $cadet->user->name }} ({{ $cadet->service_number }})</span>
                                            <input type="checkbox" x-model="selected" value="{{ $cadet->id }}">
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
                                                body: JSON.stringify({ cadet_ids: selected })
                                            }).then(response => {
                                                if (response.ok) {
                                                    open = false;
                                                    selected = [];
                                                    location.reload();
                                                }
                                            }).catch(error => {
                                                console.error('Error:', error);
                                            });
                                        "
                                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                        ➕ Add Duty Count
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Cadet CGPA Comparison -->
                    <div class="w-full lg:w-1/2 bg-white shadow border border-transparent rounded-lg p-6 flex flex-col gap-6 transition duration-300 hover:shadow-2xl hover:border-blue-300">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-3xl font-bold text-center lg:text-left">CADET CGPA</h3>
                        </div>

                        <!-- Filter Form for CGPA Comparison -->
                        <form method="GET" id="cgpa-filter-form" class="mb-1 flex justify-center gap-2">
                            <input type="hidden" name="duty_intake_year" value="{{ $selectedDutyIntakeYear }}">
                            <input type="hidden" name="sort_order" value="{{ $sortOrder }}">
                            <select name="cgpa_intake_year" onchange="this.form.submit()">
                                @foreach ($intakeOptions as $option)
                                    <option value="{{ $option['year'] }}" {{ $selectedCgpaIntakeYear == $option['year'] ? 'selected' : '' }}>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            
                            <select name="cgpa_sort_order" onchange="this.form.submit()">
                                <option value="desc" {{ $cgpaSortOrder == 'desc' ? 'selected' : '' }}>Highest CGPA First</option>
                                <option value="asc" {{ $cgpaSortOrder == 'asc' ? 'selected' : '' }}>Lowest CGPA First</option>
                            </select>
                        </form>

                        <!-- CGPA Comparison Bars -->
                        <div class="space-y-4 max-h-[600px] overflow-y-auto">
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

                                        <!-- Past CGPA Bar (Background) -->
                                        <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden mb-1">
                                            <div class="absolute top-0 left-0 h-full rounded-full"
                                                style="width: {{ $pastPercentage }}%; background-color: {{ $pastColor }};">
                                            </div>
                                            <span class="absolute inset-0 flex items-center justify-start pl-2 text-white font-semibold text-xs">
                                                Past: {{ number_format($cadet->past_cgpa, 2) }}
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
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-gray-500">No CGPA data available for this intake.</div>
                            @endforelse
                        </div>

                        <!-- Legend -->
                        <div class="flex justify-center gap-6 text-xs mt-4">
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