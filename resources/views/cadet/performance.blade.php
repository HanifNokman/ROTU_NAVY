<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Performance Ratings Section --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Performance Overview
                        </h1>
                    </div>

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        View your performance ratings and progress over time.
                    </p>

                    {{-- User's Points and Rating Summary --}}
                    <div class="mt-6 bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Performance Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-md p-4 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600">Total Points:</span>
                                    <span class="text-lg font-bold text-blue-600">{{ $userTotalPoints }}</span>
                                </div>
                            </div>
                            <div class="bg-white rounded-md p-4 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600">Overall Rating:</span>
                                    <div class="flex items-center">
                                        @php
                                            $stars = substr_count($userOverallRating, '⭐');
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm font-medium text-gray-600">({{ $stars }} Stars)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leaderboards Section --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Leaderboards
                        </h1>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        {{-- Overall Performance --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                Overall Performance
                            </h3>
                            <div class="space-y-2">
                                @foreach($leaderboards['overall'] as $entry)
                                    <div class="flex items-center justify-between p-3 bg-white rounded-md shadow-sm">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 w-6">#{{ $entry['rank'] }}</span>
                                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">{{ $entry['score'] }} pts</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Attendance --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Attendance
                            </h3>
                            <div class="space-y-2">
                                @foreach($leaderboards['attendance'] as $entry)
                                    <div class="flex items-center justify-between p-3 bg-white rounded-md shadow-sm">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 w-6">#{{ $entry['rank'] }}</span>
                                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">{{ $entry['score'] }} pts</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Quiz Overall --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                Quiz Overall
                            </h3>
                            <div class="space-y-2">
                                @foreach($leaderboards['quiz_overall'] as $entry)
                                    <div class="flex items-center justify-between p-3 bg-white rounded-md shadow-sm">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 w-6">#{{ $entry['rank'] }}</span>
                                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">{{ $entry['score'] }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Duty Count --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Duty Count
                            </h3>
                            <div class="space-y-2">
                                @foreach($leaderboards['duty'] as $entry)
                                    <div class="flex items-center justify-between p-3 bg-white rounded-md shadow-sm">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 w-6">#{{ $entry['rank'] }}</span>
                                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">{{ $entry['score'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Learning Progress --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Learning Progress
                            </h3>
                            <div class="space-y-2">
                                @foreach($leaderboards['learning'] as $entry)
                                    <div class="flex items-center justify-between p-3 bg-white rounded-md shadow-sm">
                                        <div class="flex items-center">
                                            <span class="text-sm font-medium text-gray-500 w-6">#{{ $entry['rank'] }}</span>
                                            <span class="ml-3 text-sm font-medium text-gray-900">{{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}</span>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700">{{ $entry['score'] }}%</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Quiz Categories --}}
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Quiz by Category
                            </h3>
                            <div class="space-y-4">
                                @foreach($leaderboards['quiz_categories'] as $categoryName => $categoryLeaderboard)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">{{ $categoryName }}</h4>
                                        <div class="space-y-1">
                                            @foreach($categoryLeaderboard as $entry)
                                                <div class="flex items-center justify-between p-2 bg-white rounded-md shadow-sm">
                                                    <div class="flex items-center">
                                                        <span class="text-xs font-medium text-gray-500 w-4">#{{ $entry['rank'] }}</span>
                                                        <span class="ml-2 text-xs font-medium text-gray-900">{{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}</span>
                                                    </div>
                                                    <span class="text-xs font-semibold text-gray-700">{{ $entry['score'] }}%</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Badges Section --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Achievement Badges
                        </h1>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    {{-- Unlocked Badges --}}
                    @if(count($badgesData['unlocked']) > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Unlocked Badges</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($badgesData['unlocked'] as $unlockedBadge)
                                    <div class="bg-white border-2 border-gray-200 rounded-lg p-4 text-center hover:shadow-md transition-shadow cursor-pointer"
                                         onclick="toggleBadgeDisplay({{ $unlockedBadge['badge']->id }})">
                                        <div class="flex justify-center mb-2">
                                            <i class="{{ $unlockedBadge['badge']->icon }} text-3xl {{ $unlockedBadge['is_displayed'] ? 'text-yellow-500' : 'text-gray-400' }}"></i>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $unlockedBadge['badge']->name }}</h4>
                                        <p class="text-xs text-gray-600 mb-2">{{ $unlockedBadge['badge']->description }}</p>
                                        <div class="text-xs text-gray-500">
                                            Unlocked: {{ $unlockedBadge['unlocked_at']->format('M d, Y') }}
                                        </div>
                                        <div class="mt-2">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $unlockedBadge['is_displayed'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $unlockedBadge['is_displayed'] ? 'Displayed' : 'Hidden' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Unlockable Badges --}}
                    @if(count($badgesData['unlockable']) > 0)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Available Badges</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                @foreach($badgesData['unlockable'] as $badge)
                                    <div class="bg-gray-50 border-2 border-gray-200 border-dashed rounded-lg p-4 text-center opacity-60 hover:opacity-80 transition-opacity"
                                         title="{{ $badge->unlock_criteria }}">
                                        <div class="flex justify-center mb-2">
                                            <i class="{{ $badge->icon }} text-3xl text-gray-300"></i>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-500 mb-1">{{ $badge->name }}</h4>
                                        <p class="text-xs text-gray-400 mb-2">{{ $badge->description }}</p>
                                        <div class="text-xs text-gray-400">
                                            {{ $badge->unlock_criteria }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleBadgeDisplay(badgeId) {
            fetch('/cadet/performance/toggle-badge', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    badge_id: badgeId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error toggling badge display');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error toggling badge display');
            });
        }
    </script>
</x-app-layout>
