<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance Report') }}
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
                        <h1 class="text-2xl font-bold text-gray-900">Attendance Report</h1>
                        <p class="text-sm text-gray-600 mt-1">Analyze cadet attendance records and performance</p>
                    </div>
                    <a href="{{ route('instructor.reports.attendance.export', request()->query()) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-colors shadow-sm">
                        <i class="fas fa-file-excel mr-2"></i>
                        Export to Excel
                    </a>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('instructor.reports.attendance') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ $request->start_date ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ $request->end_date ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
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
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors">
                            <i class="fas fa-filter mr-2"></i>Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Cadet Attendance List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Cadet Attendance Records</h2>
                    <p class="text-sm text-gray-600 mt-1">Sorted by attendance rate (highest to lowest)</p>
                </div>

                <div class="overflow-x-auto">
                    @if($attendanceData->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake Year</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sessions</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Absent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance Rate</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($attendanceData as $data)
                                    @php
                                        $cadet = $data['cadet'];
                                        $rate = $data['rate'];
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                            {{ $data['total'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium text-center">
                                            {{ $data['present'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium text-center">
                                            {{ $data['absent'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                            <div class="flex items-center justify-center">
                                                <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="h-2 rounded-full {{ $rate >= 80 ? 'bg-green-500' : ($rate >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                                         style="width: {{ $rate }}%"></div>
                                                </div>
                                                <span class="font-medium">{{ $rate }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($rate >= 80)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>Excellent
                                                </span>
                                            @elseif($rate >= 60)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>Fair
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i>Poor
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-6 text-center text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-3"></i>
                            <p>No attendance data found for the selected criteria.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Summary Statistics -->
            @if($attendanceData->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Summary Statistics</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-3xl font-bold text-blue-600">{{ $attendanceData->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">Total Cadets</div>
                        </div>
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-3xl font-bold text-green-600">{{ $attendanceData->where('rate', '>=', 80)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">Excellent Attendance</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 rounded-lg">
                            <div class="text-3xl font-bold text-yellow-600">{{ $attendanceData->where('rate', '>=', 60)->where('rate', '<', 80)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">Fair Attendance</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-3xl font-bold text-red-600">{{ $attendanceData->where('rate', '<', 60)->count() }}</div>
                            <div class="text-sm text-gray-600 mt-1">Poor Attendance</div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
