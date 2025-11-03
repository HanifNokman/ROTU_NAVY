<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Financial Report') }}
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
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Financial Report (Allowance Summary)</h1>
                            <p class="text-sm text-gray-600 mt-1">View cadet allowance summary by month and year</p>
                        </div>
                        <a href="{{ route('instructor.reports.financial.export', request()->query()) }}"
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors shadow-sm">
                            <i class="fas fa-file-excel mr-2"></i>
                            Export to Excel
                        </a>
                    </div>
                    <div class="mt-2 p-3 bg-blue-50 border-l-4 border-blue-500 text-sm text-blue-700">
                        <i class="fas fa-info-circle mr-1"></i>
                        <strong>Note:</strong> This is a placeholder report. The allowance data structure needs to be fully implemented in the system.
                    </div>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('instructor.reports.financial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                        <select name="month" id="month" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($months as $monthNum => $monthName)
                                <option value="{{ $monthNum }}" {{ $month == $monthNum ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                        <select name="year" id="year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @for($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="intake_year" class="block text-sm font-medium text-gray-700 mb-1">Intake Year</label>
                        <select name="intake_year" id="intake_year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">All Intakes</option>
                            @foreach($intakeYears as $intYear)
                                <option value="{{ $intYear }}" {{ ($request->intake_year ?? '') == $intYear ? 'selected' : '' }}>
                                    {{ $intYear }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            <i class="fas fa-filter mr-2"></i>Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @php
                    $totalCadets = $allowanceData->count();
                    $totalAllowance = $allowanceData->sum('total');
                    $avgAllowance = $totalCadets > 0 ? round($totalAllowance / $totalCadets, 2) : 0;
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Cadets</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalCadets }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Allowance</p>
                            <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalAllowance, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <i class="fas fa-calculator text-2xl text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Average Allowance</p>
                            <p class="text-2xl font-bold text-gray-900">RM {{ number_format($avgAllowance, 2) }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <i class="fas fa-calendar text-2xl text-orange-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Report Period</p>
                            <p class="text-lg font-bold text-gray-900">{{ $months[$month] }} {{ $year }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Allowance List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Allowance Breakdown</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $months[$month] }} {{ $year }}</p>
                </div>

                <div class="overflow-x-auto">
                    @if($allowanceData->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake Year</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base Allowance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Training Bonus</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance Bonus</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($allowanceData as $data)
                                    @php
                                        $cadet = $data['cadet'];
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $cadet->service_number ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $cadet->user->name ?? 'Unknown' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $cadet->intake_year }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            RM {{ number_format($data['base_allowance'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 text-right">
                                            +RM {{ number_format($data['training_bonus'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 text-right">
                                            +RM {{ number_format($data['performance_bonus'], 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                            RM {{ number_format($data['total'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-sm font-bold text-gray-900">TOTAL</td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">
                                        RM {{ number_format($allowanceData->sum('base_allowance'), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-green-600 text-right">
                                        +RM {{ number_format($allowanceData->sum('training_bonus'), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-blue-600 text-right">
                                        +RM {{ number_format($allowanceData->sum('performance_bonus'), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">
                                        RM {{ number_format($totalAllowance, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>No allowance data found for the selected criteria.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
