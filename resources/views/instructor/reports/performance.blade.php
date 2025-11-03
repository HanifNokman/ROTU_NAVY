<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance Report') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Back Button -->
            <div>
                <a href="{{ route('instructor.reports') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Reports Dashboard
                </a>
            </div>

            <!-- Page Header & Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Cadet Performance Report</h1>
                        <p class="text-sm text-gray-600 mt-1">View cadet performance ratings and achievement points</p>
                    </div>
                    <a href="{{ route('instructor.reports.performance.export', request()->query()) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors shadow-sm">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export to Excel
                    </a>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('instructor.reports.performance') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="intake_year" class="block text-sm font-medium text-gray-700 mb-1">Intake Year</label>
                        <select name="intake_year" id="intake_year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Intakes</option>
                            @foreach($intakeYears as $year)
                                <option value="{{ $year }}" {{ ($request->intake_year ?? '') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="min_rating" class="block text-sm font-medium text-gray-700 mb-1">Minimum Rating</label>
                        <select name="min_rating" id="min_rating" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Ratings</option>
                            <option value="5" {{ ($request->min_rating ?? '') == '5' ? 'selected' : '' }}>5 Stars</option>
                            <option value="4" {{ ($request->min_rating ?? '') == '4' ? 'selected' : '' }}>4+ Stars</option>
                            <option value="3" {{ ($request->min_rating ?? '') == '3' ? 'selected' : '' }}>3+ Stars</option>
                            <option value="2" {{ ($request->min_rating ?? '') == '2' ? 'selected' : '' }}>2+ Stars</option>
                            <option value="1" {{ ($request->min_rating ?? '') == '1' ? 'selected' : '' }}>1+ Star</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            <i class="fas fa-filter mr-2"></i>Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Performance List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Cadet Performance Rankings</h2>
                    <p class="text-sm text-gray-600 mt-1">Sorted by total points (highest to lowest)</p>
                </div>

                <div class="overflow-x-auto">
                    @if($performanceData->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake Year</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Points</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quiz</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Learning</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($performanceData as $index => $data)
                                    @php
                                        $cadet = $data['cadet'];
                                        $rank = $index + 1;
                                    @endphp
                                    <tr class="hover:bg-gray-50 {{ $rank <= 3 ? 'bg-yellow-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            @if($rank == 1)
                                                <span class="text-yellow-600"><i class="fas fa-trophy"></i> #1</span>
                                            @elseif($rank == 2)
                                                <span class="text-gray-400"><i class="fas fa-medal"></i> #2</span>
                                            @elseif($rank == 3)
                                                <span class="text-orange-600"><i class="fas fa-award"></i> #3</span>
                                            @else
                                                #{{ $rank }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $cadet->service_number ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $cadet->user->name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $cadet->intake_year }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <div class="text-2xl">
                                                {{ $data['rating']->rating ?? '⭐☆☆☆☆' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <span class="text-lg font-bold text-blue-600">{{ $data['total_points'] }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                            {{ $data['attendance_points'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                            {{ $data['quiz_points'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-center">
                                            {{ $data['learning_progress_points'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>No performance data found for the selected criteria.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Performance Distribution -->
            @if($performanceData->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Performance Distribution</h2>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="text-center p-4 bg-yellow-50 rounded-lg border-2 border-yellow-200">
                            <div class="text-3xl mb-2">⭐⭐⭐⭐⭐</div>
                            <div class="text-2xl font-bold text-yellow-600">{{ $performanceData->where('stars', 5)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">5 Stars</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 rounded-lg border-2 border-blue-200">
                            <div class="text-3xl mb-2">⭐⭐⭐⭐☆</div>
                            <div class="text-2xl font-bold text-blue-600">{{ $performanceData->where('stars', 4)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">4 Stars</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg border-2 border-green-200">
                            <div class="text-3xl mb-2">⭐⭐⭐☆☆</div>
                            <div class="text-2xl font-bold text-green-600">{{ $performanceData->where('stars', 3)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">3 Stars</div>
                        </div>
                        <div class="text-center p-4 bg-orange-50 rounded-lg border-2 border-orange-200">
                            <div class="text-3xl mb-2">⭐⭐☆☆☆</div>
                            <div class="text-2xl font-bold text-orange-600">{{ $performanceData->where('stars', 2)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">2 Stars</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg border-2 border-red-200">
                            <div class="text-3xl mb-2">⭐☆☆☆☆</div>
                            <div class="text-2xl font-bold text-red-600">{{ $performanceData->where('stars', '<=', 1)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">1 Star or Less</div>
                        </div>
                    </div>
                </div>

                <!-- Top Performers in Each Category -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $topAttendance = $performanceData->sortByDesc('attendance_points')->first();
                        $topQuiz = $performanceData->sortByDesc('quiz_points')->first();
                        $topLearning = $performanceData->sortByDesc('learning_progress_points')->first();
                    @endphp

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-user-check text-green-600 mr-2"></i>
                            Top Attendance
                        </h3>
                        @if($topAttendance)
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $topAttendance['cadet']->user->name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-gray-600">{{ $topAttendance['cadet']->service_number ?? 'N/A' }}</p>
                                </div>
                                <div class="text-2xl font-bold text-green-600">{{ $topAttendance['attendance_points'] }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-graduation-cap text-purple-600 mr-2"></i>
                            Top Quiz Performance
                        </h3>
                        @if($topQuiz)
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $topQuiz['cadet']->user->name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-gray-600">{{ $topQuiz['cadet']->service_number ?? 'N/A' }}</p>
                                </div>
                                <div class="text-2xl font-bold text-purple-600">{{ $topQuiz['quiz_points'] }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                            <i class="fas fa-book-reader text-blue-600 mr-2"></i>
                            Top Learning Progress
                        </h3>
                        @if($topLearning)
                            <div class="flex items-center">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900">{{ $topLearning['cadet']->user->name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-gray-600">{{ $topLearning['cadet']->service_number ?? 'N/A' }}</p>
                                </div>
                                <div class="text-2xl font-bold text-blue-600">{{ $topLearning['learning_progress_points'] }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
