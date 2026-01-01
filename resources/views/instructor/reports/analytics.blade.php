<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Back Button -->
            <div>
                <a href="{{ route('instructor.reports') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Reports Dashboard
                </a>
            </div>

            <!-- Page Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Analytics Dashboard</h1>
                        <p class="text-sm text-gray-600 mt-1">Comprehensive system analytics and insights</p>
                    </div>
                    <div class="text-right text-sm text-gray-500">
                        <p>Last Updated</p>
                        <p class="font-medium">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Overall Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Total Cadets -->
                <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4">
                            <i class="fas fa-users text-3xl text-white"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Total Cadets</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_cadets'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Trainings -->
                <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4">
                            <i class="fas fa-dumbbell text-3xl text-white"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Total Trainings</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_trainings'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Average Attendance -->
                <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-4">
                            <i class="fas fa-user-check text-3xl text-white"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Avg Attendance</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['average_attendance'] }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Total Loans -->
                <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-4">
                            <i class="fas fa-boxes text-3xl text-white"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Total Equipment Loans</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['total_loans'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Loans -->
                <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg p-4">
                            <i class="fas fa-hand-holding text-3xl text-white"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Active Loans</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['active_loans'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Average Performance -->
                <div class="stat-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-br from-red-500 to-red-600 rounded-lg p-4">
                            <i class="fas fa-chart-line text-3xl text-white"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium text-gray-600">Avg Performance</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $stats['average_performance'] }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Attendance Trends -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Attendance Trends (Last 6 Months)</h2>

                <div class="space-y-4">
                    @foreach($attendanceTrends as $trend)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">{{ $trend['month'] }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $trend['rate'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-500 {{ $trend['rate'] >= 80 ? 'bg-green-500' : ($trend['rate'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                     style="width: {{ $trend['rate'] }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Trainings & Top Performers -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Recent Trainings -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Recent Trainings</h2>
                    </div>
                    <div class="p-6">
                        @if($recentTrainings->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentTrainings as $training)
                                    @php
                                        $total = $training->trainingAttendances->count();
                                        $present = $training->trainingAttendances->where('present', true)->count();
                                        $rate = $total > 0 ? round(($present / $total) * 100, 1) : 0;
                                    @endphp
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $training->title }}</p>
                                            <p class="text-xs text-gray-600">{{ $training->start_datetime->format('d/m/Y') }} • {{ $training->location }}</p>
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-sm font-bold {{ $rate >= 80 ? 'text-green-600' : ($rate >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                                {{ $rate }}%
                                            </p>
                                            <p class="text-xs text-gray-600">{{ $present }}/{{ $total }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No recent trainings</p>
                        @endif
                    </div>
                </div>

                <!-- Top Performers -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-bold text-gray-900">Top 10 Performers</h2>
                    </div>
                    <div class="p-6">
                        @if($topPerformers->count() > 0)
                            <div class="space-y-3">
                                @foreach($topPerformers as $index => $cadet)
                                    @php
                                        $rank = $index + 1;
                                        $rating = $cadet->performanceRating;
                                    @endphp
                                    <div class="flex items-center justify-between p-3 {{ $rank <= 3 ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50' }} rounded-lg">
                                        <div class="flex items-center flex-1">
                                            <div class="w-8 h-8 rounded-full {{ $rank == 1 ? 'bg-yellow-400' : ($rank == 2 ? 'bg-gray-300' : ($rank == 3 ? 'bg-orange-400' : 'bg-gray-200')) }} flex items-center justify-center text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-900">{{ $cadet->user->name ?? 'Unknown' }}</p>
                                                <p class="text-xs text-gray-600">{{ $cadet->service_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-sm font-bold text-blue-600">{{ $rating->total_points ?? 0 }}</p>
                                            <p class="text-xs">{{ $rating->rating ?? '⭐☆☆☆☆' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-8">No performance data available</p>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('instructor.reports.training') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <i class="fas fa-dumbbell text-2xl text-blue-600 mr-3"></i>
                        <span class="font-medium text-gray-900">View Training Report</span>
                    </a>
                    <a href="{{ route('instructor.reports.attendance') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                        <i class="fas fa-user-check text-2xl text-green-600 mr-3"></i>
                        <span class="font-medium text-gray-900">View Attendance Report</span>
                    </a>
                    <a href="{{ route('instructor.reports.performance') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                        <i class="fas fa-chart-line text-2xl text-purple-600 mr-3"></i>
                        <span class="font-medium text-gray-900">View Performance Report</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
