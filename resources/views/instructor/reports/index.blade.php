<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports Dashboard') }}
        </h2>
    </x-slot>

    <style>
        .report-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
        }

        .report-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: #d1d5db;
        }

        .icon-wrapper {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gradient-blue {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .gradient-purple {
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .gradient-red {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .gradient-indigo {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        }

        .gradient-teal {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Page Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Reports & Analytics</h1>
                        <p class="mt-2 text-sm text-gray-600">Generate detailed reports and view system analytics</p>
                    </div>
                    <div class="text-right text-sm text-gray-500">
                        <p>Generated: {{ now()->format('d/m/Y') }}</p>
                        <p>{{ now()->format('h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Training Report -->
                <a href="{{ route('instructor.reports.training') }}" class="report-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 block">
                    <div class="flex items-start space-x-4">
                        <div class="icon-wrapper gradient-blue">
                            <i class="fas fa-dumbbell text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">Training Report</h3>
                            <p class="text-sm text-gray-600 mt-1">View training sessions with attendance statistics and participation rates</p>
                            <div class="mt-3 flex items-center text-blue-600 text-sm font-medium">
                                <span>Generate Report</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Attendance Report -->
                <a href="{{ route('instructor.reports.attendance') }}" class="report-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 block">
                    <div class="flex items-start space-x-4">
                        <div class="icon-wrapper gradient-green">
                            <i class="fas fa-user-check text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">Attendance Report</h3>
                            <p class="text-sm text-gray-600 mt-1">Analyze cadet attendance records by intake year and date range</p>
                            <div class="mt-3 flex items-center text-green-600 text-sm font-medium">
                                <span>Generate Report</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Inventory Report -->
                <a href="{{ route('instructor.reports.inventory') }}" class="report-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 block">
                    <div class="flex items-start space-x-4">
                        <div class="icon-wrapper gradient-purple">
                            <i class="fas fa-boxes text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">Inventory Report</h3>
                            <p class="text-sm text-gray-600 mt-1">Track equipment loans, returns, and overdue items</p>
                            <div class="mt-3 flex items-center text-purple-600 text-sm font-medium">
                                <span>Generate Report</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Performance Report -->
                <a href="{{ route('instructor.reports.performance') }}" class="report-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 block">
                    <div class="flex items-start space-x-4">
                        <div class="icon-wrapper gradient-orange">
                            <i class="fas fa-chart-line text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">Performance Report</h3>
                            <p class="text-sm text-gray-600 mt-1">View cadet performance ratings and achievement points</p>
                            <div class="mt-3 flex items-center text-orange-600 text-sm font-medium">
                                <span>Generate Report</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Financial Report -->
                <a href="{{ route('instructor.reports.financial') }}" class="report-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 block">
                    <div class="flex items-start space-x-4">
                        <div class="icon-wrapper gradient-red">
                            <i class="fas fa-coins text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">Financial Report</h3>
                            <p class="text-sm text-gray-600 mt-1">Generate allowance summary and financial overview by month</p>
                            <div class="mt-3 flex items-center text-red-600 text-sm font-medium">
                                <span>Generate Report</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Analytics Dashboard -->
                <a href="{{ route('instructor.reports.analytics') }}" class="report-card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 block">
                    <div class="flex items-start space-x-4">
                        <div class="icon-wrapper gradient-indigo">
                            <i class="fas fa-analytics text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">Analytics Dashboard</h3>
                            <p class="text-sm text-gray-600 mt-1">View comprehensive analytics with trends and insights</p>
                            <div class="mt-3 flex items-center text-indigo-600 text-sm font-medium">
                                <span>View Dashboard</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Statistics</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600">{{ \App\Models\Training::count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Trainings</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-600">{{ \App\Models\Cadet::count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">Total Cadets</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-3xl font-bold text-purple-600">{{ \App\Models\EquipmentLoan::whereIn('status', ['Borrowed', 'Pending Return'])->count() }}</div>
                        <div class="text-sm text-gray-600 mt-1">Active Loans</div>
                    </div>
                    <div class="text-center p-4 bg-orange-50 rounded-lg">
                        <div class="text-3xl font-bold text-orange-600">{{ \App\Models\PerformanceRating::avg('total_points') ? round(\App\Models\PerformanceRating::avg('total_points'), 1) : 0 }}</div>
                        <div class="text-sm text-gray-600 mt-1">Avg Performance</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
