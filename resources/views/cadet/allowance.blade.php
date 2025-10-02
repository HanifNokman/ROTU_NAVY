<x-app-layout>
    {{-- ================================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================================ --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Allowance Estimation
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE TITLE SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    Allowance Estimation
                </h1>
                <p class="text-gray-600">Calculate your training allowances and compensation</p>
            </div>

            {{-- ================================================================ --}}
            {{-- MAIN CONTENT CARD --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Training Records & Allowances
                    </h2>
                    <p class="text-gray-600">View your training participation and calculate earned allowances</p>
                </div>

                {{-- Card Body --}}
                <div class="p-6">
                    
                    {{-- ================================================================ --}}
                    {{-- FILTER FORM --}}
                    {{-- ================================================================ --}}
                    <form id="allowance-filter-form" class="mb-6 flex flex-wrap gap-4">
                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                            <select name="year" id="year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                            <select name="month" id="month" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @if(empty($months))
                                    <option value="">No training months available</option>
                                @else
                                    @foreach($months as $num => $name)
                                        <option value="{{ $num }}" @if($num == $selectedMonth) selected @endif>{{ $name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </form>

                    {{-- ================================================================ --}}
                    {{-- ALLOWANCE CONTENT --}}
                    {{-- ================================================================ --}}
                    <div id="allowance-content">
                        
                        {{-- Training Records Table --}}
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                    <tr>
                                        <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                                        <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Training Involved</th>
                                        <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Training Date</th>
                                        <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Location</th>
                                        <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Duration</th>
                                        <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Type</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($trainings as $i => $training)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-2 py-2 text-xs">{{ $i+1 }}</td>
                                            <td class="px-2 py-2 text-xs font-medium">{{ $training['title'] }}</td>
                                            <td class="px-2 py-2 text-xs">{{ $training['date'] }}</td>
                                            <td class="px-2 py-2 text-xs">{{ $training['location'] }}</td>
                                            <td class="px-2 py-2 text-xs font-medium">
                                                @if($training['type'] === 'hourly')
                                                    <span class="text-green-700">{{ $training['hours'] }} hours</span>
                                                @else
                                                    <span class="text-blue-700">{{ $training['days'] }} days</span>
                                                @endif
                                            </td>
                                            <td class="px-2 py-2 text-xs">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @if($training['type'] === 'hourly') bg-green-100 text-green-800 @else bg-blue-100 text-blue-800 @endif">
                                                    {{ ucfirst($training['type']) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-8">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                    <p class="text-gray-500 text-sm">No trainings attended for selected period.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Allowance Calculation Summary --}}
                        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-lg font-semibold mb-2">Allowance Calculation</h3>
                            <div class="mb-2">
                                <span class="font-semibold">Hourly Calculation:</span>
                                {{ $totalHours }} hours × RM8 = <span class="font-bold text-blue-700">RM{{ number_format($hourlyAllowance, 2) }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="font-semibold">Daily Calculation:</span>
                                {{ $totalDays }} days × RM50 = <span class="font-bold text-blue-700">RM{{ number_format($dailyAllowance, 2) }}</span>
                            </div>
                            <div class="mt-4 text-xl font-bold text-green-700">
                                Total Allowance: RM{{ number_format($totalAllowance, 2) }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearSelect = document.getElementById('year');
                const monthSelect = document.getElementById('month');
                const allowanceContent = document.getElementById('allowance-content');

                // ================================================================
                // FETCH ALLOWANCE DATA
                // ================================================================
                function fetchAllowance() {
                    const year = yearSelect.value;
                    const month = monthSelect.value;
                    
                    allowanceContent.innerHTML = '<div class="text-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div><p class="mt-2 text-gray-600">Loading...</p></div>';
                    
                    fetch(`{{ route('cadet.allowance') }}?year=${year}&month=${month}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        allowanceContent.innerHTML = data.html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        allowanceContent.innerHTML = '<div class="text-center py-8 text-red-600"><p>Error loading data. Please try again.</p></div>';
                    });
                }

                // ================================================================
                // EVENT LISTENERS
                // ================================================================
                yearSelect.addEventListener('change', fetchAllowance);
                monthSelect.addEventListener('change', fetchAllowance);
            });
        </script>
    @endpush
</x-app-layout>