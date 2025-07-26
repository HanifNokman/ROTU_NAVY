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
            <div class="w-full lg:w-1/2 bg-white shadow border border-transparent rounded-lg p-6 flex flex-col gap-6 transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <h3 class="text-3xl font-bold text-center mb-1">DUTY RANKING</h3>

                <!-- Filter Form -->
                <form method="GET" id="duty-filter-form" class="mb-1 flex justify-center">
                    <select name="intake_year" onchange="this.form.submit()">
                        @foreach ($dutyIntakeOptions as $option)
                            <option value="{{ $option['year'] }}" {{ $selectedIntakeYear == $option['year'] ? 'selected' : '' }}>
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
                                $g = (int)(255 * $ratio);
                            } else {
                                $ratio = ($percentage - 50) / 50; // 0 to 1
                                $r = (int)(255 * (1 - $ratio));
                                $g = 255;
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
            </div>

                    <!-- RIGHT: Cadet CGPA Comparison -->
            <div class="w-full lg:w-1/2 bg-white shadow border border-transparent rounded-lg p-6 flex flex-col gap-6 transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <h3 class="text-3xl font-bold text-center mb-4">CADET CGPA</h3>

                {{-- Placeholder for CGPA comparison feature --}}
                <div class="text-center text-gray-500 italic">
                    CGPA comparison feature will be added here later.
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