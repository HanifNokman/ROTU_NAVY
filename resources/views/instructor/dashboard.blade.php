<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row gap-6">
            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                <img src="{{ $instructor?->profile_pic ? asset('storage/' . $instructor->profile_pic) : asset('images/default.png') }}"
                     alt="Profile Picture"
                     class="w-60 h-80 object-cover border rounded">
            </div>

            <!-- Profile Information -->
            <div class="flex-1 space-y-6">
                <!-- Row 1 -->
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <button class="bg-gray-100 text-gray-800 font-bold px-6 py-2 rounded shadow whitespace-nowrap">
                        🛡️ Personal Profile
                    </button>
                    <p class="text-2xl font-semibold text-gray-800">
                        {{ ($instructor?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') }}
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
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Duty Ranking Card -->
    <div class="max-w-6xl mx-auto mt-10 px-4 sm:px-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-3xl font-bold text-center mb-4">DUTY RANKING</h3>

            <!-- Filter Form -->
            <form method="GET" id="filter-form" class="mb-6 flex flex-col md:flex-row md:items-center gap-4 justify-center">
                <!-- Intake Dropdown -->
                <div>
                    <label for="intake_year" class="block font-medium mb-1">Filter by Intake:</label>
                    <select name="intake_year" id="intake_year" class="rounded border-gray-300"
                            onchange="document.getElementById('filter-form').submit();">
                        @foreach ($intakeOptions as $option)
                            <option value="{{ $option['year'] }}" {{ $option['year'] == $selectedIntakeYear ? 'selected' : '' }}>
                                {{ $option['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Order Dropdown -->
                <div>
                    <label for="sort_order" class="block font-medium mb-1">Sort Order:</label>
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
                    $maxCount = $cadets->max('daily_duty_count') ?: 1;
                @endphp

                @forelse ($cadets as $index => $cadet)
                    @php
                        $maxCount = $cadets->max('daily_duty_count') ?: 1;
                        $percentage = ($cadet->daily_duty_count / $maxCount) * 100;

                        $totalCadets = count($cadets);
                        $position = $sortOrder === 'desc' ? $index : ($totalCadets - $index - 1);
                        $relative = $totalCadets > 1 ? ($position / ($totalCadets - 1)) : 0;

                        // Interpolate: green → yellow → red
                        if ($relative < 0.5) {
                            $ratio = $relative * 2;
                            $r = (int)(255 * $ratio);
                            $g = 255;
                        } else {
                            $ratio = ($relative - 0.5) * 2;
                            $r = 255;
                            $g = (int)(255 * (1 - $ratio));
                        }
                        $bgColor = "rgb($r, $g, 0)";
                    @endphp

                    <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
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

                            <!-- Progress Bar -->
                            <div class="relative h-8 rounded-full bg-gray-200 overflow-hidden">
                                <div
                                    class="absolute top-0 left-0 h-full rounded-full transition-all duration-300 group-hover:scale-[1.02] group-hover:brightness-110 flex items-center"
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

</x-app-layout>
