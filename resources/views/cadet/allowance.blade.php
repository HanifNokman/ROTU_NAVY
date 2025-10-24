<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allowance Estimation') }}
        </h2>
    </x-slot>

    <style>
    /* ========================================= */
    /* CUSTOM SCROLLBAR STYLES */
    /* ========================================= */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #94a3b8 0%, #64748b 100%);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #64748b 0%, #475569 100%);
    }

    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #f1f5f9;
    }

    /* ========================================= */
    /* CARD & ANIMATION STYLES */
    /* ========================================= */
    .dashboard-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #d1d5db;
    }

    .section-header {
        padding: 1.75rem;
        border-bottom: 2px solid #f3f4f6;
        background: linear-gradient(to right, #f8fafc 0%, #f1f5f9 100%);
    }

    /* ========================================= */
    /* GRADIENT BACKGROUNDS */
    /* ========================================= */
    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* ========================================= */
    /* TABLE STYLES */
    /* ========================================= */
    .data-table {
        min-width: 100%;
        background: white;
    }

    .data-table thead {
        background: linear-gradient(to right, #f8fafc 0%, #f1f5f9 100%);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .data-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: #4b5563;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        color: #1f2937;
    }

    .data-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .data-table tbody tr:hover {
        background-color: #f9fafb;
    }

    /* ========================================= */
    /* ICON STYLES */
    /* ========================================= */
    .icon-wrapper {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ========================================= */
    /* LOADING ANIMATION */
    /* ========================================= */
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- ================================================================ --}}
            {{-- HEADER SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-green rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Allowance Estimation</h1>
                <p class="text-gray-600 text-lg">Calculate your training allowances and compensation</p>
            </div>

            {{-- ================================================================ --}}
            {{-- MAIN CONTENT CARD --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">
                
                {{-- Card Header --}}
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper bg-green-100 mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Training Records & Allowances</h2>
                    </div>
                    <p class="text-gray-600 ml-13">View your training participation and calculate earned allowances</p>
                </div>

                {{-- Card Body --}}
                <div class="p-8">
                    
                    {{-- ================================================================ --}}
                    {{-- FILTER FORM --}}
                    {{-- ================================================================ --}}
                    <form id="allowance-filter-form" class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">Year</label>
                                <select name="year" id="year" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-colors duration-200">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">Month</label>
                                <select name="month" id="month" class="block w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-20 transition-colors duration-200">
                                    @if(empty($months))
                                        <option value="">No training months available</option>
                                    @else
                                        @foreach($months as $num => $name)
                                            <option value="{{ $num }}" @if($num == $selectedMonth) selected @endif>{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </form>

                    {{-- ================================================================ --}}
                    {{-- ALLOWANCE CONTENT --}}
                    {{-- ================================================================ --}}
                    <div id="allowance-content">
                        
                        {{-- Training Records Table --}}
                        <div class="mb-8 rounded-xl border border-gray-200 overflow-hidden custom-scrollbar" style="max-height: 600px; overflow-y: auto;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Training Involved</th>
                                        <th>Training Date</th>
                                        <th>Location</th>
                                        <th>Duration</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($trainings as $i => $training)
                                        <tr>
                                            <td class="font-medium text-gray-900">{{ $i+1 }}</td>
                                            <td class="font-semibold text-gray-900">{{ $training['title'] }}</td>
                                            <td class="text-gray-700">{{ $training['date'] }}</td>
                                            <td class="text-gray-700">{{ $training['location'] }}</td>
                                            <td class="font-semibold">
                                                @if($training['type'] === 'hourly')
                                                    <span class="text-green-700">{{ $training['hours'] }} hours</span>
                                                @else
                                                    <span class="text-blue-700">{{ $training['days'] }} days</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($training['type'] === 'hourly') bg-green-100 text-green-800 @else bg-blue-100 text-blue-800 @endif">
                                                    {{ ucfirst($training['type']) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-16">
                                                <div class="flex flex-col items-center justify-center">
                                                    <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                    <p class="text-gray-500 font-semibold text-lg">No trainings attended</p>
                                                    <p class="text-gray-400 text-sm mt-1">No training records found for the selected period</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Allowance Calculation Summary --}}
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center">
                                    <div class="icon-wrapper bg-green-100 mr-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Allowance Calculation</h3>
                                </div>
                            </div>

                            <div class="p-6">
                                {{-- Summary Stats Grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    {{-- Hourly Summary --}}
                                    <div class="bg-green-50 rounded-lg p-4 border-2 border-green-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-semibold text-green-700 uppercase tracking-wide">Hourly Training</span>
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="text-2xl font-bold text-green-900 mb-1">{{ $totalHours }} hrs</div>
                                        <div class="text-xs text-green-700">@ RM 8.00/hr</div>
                                    </div>

                                    {{-- Daily Summary --}}
                                    <div class="bg-blue-50 rounded-lg p-4 border-2 border-blue-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-semibold text-blue-700 uppercase tracking-wide">Daily Training</span>
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="text-2xl font-bold text-blue-900 mb-1">{{ $totalDays }} days</div>
                                        <div class="text-xs text-blue-700">@ RM 50.00/day</div>
                                    </div>

                                    {{-- Total Summary --}}
                                    <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg p-4 border-2 border-emerald-600 shadow-md">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs font-semibold text-white uppercase tracking-wide">Total Earned</span>
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                            </svg>
                                        </div>
                                        <div class="text-2xl font-bold text-white mb-1">RM {{ number_format($totalAllowance, 2) }}</div>
                                        <div class="text-xs text-emerald-100">This period</div>
                                    </div>
                                </div>

                                {{-- Calculation Breakdown --}}
                                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        Calculation Breakdown
                                    </h4>

                                    <div class="space-y-3">
                                        {{-- Hourly Row --}}
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Hourly Training:</span>
                                            <span class="font-mono text-gray-900">
                                                <span class="font-semibold text-green-700">{{ $totalHours }}</span> hrs ×
                                                <span class="font-semibold text-green-700">RM 8.00</span> =
                                                <span class="font-bold text-green-700">RM {{ number_format($hourlyAllowance, 2) }}</span>
                                            </span>
                                        </div>

                                        {{-- Daily Row --}}
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-600">Daily Training:</span>
                                            <span class="font-mono text-gray-900">
                                                <span class="font-semibold text-blue-700">{{ $totalDays }}</span> days ×
                                                <span class="font-semibold text-blue-700">RM 50.00</span> =
                                                <span class="font-bold text-blue-700">RM {{ number_format($dailyAllowance, 2) }}</span>
                                            </span>
                                        </div>

                                        <div class="border-t-2 border-gray-300 my-2"></div>

                                        {{-- Total Row --}}
                                        <div class="flex items-center justify-between text-base bg-white rounded-md p-3 border border-gray-200">
                                            <span class="font-semibold text-gray-900">Total Allowance:</span>
                                            <span class="font-mono">
                                                <span class="text-gray-600">RM {{ number_format($hourlyAllowance, 2) }}</span> +
                                                <span class="text-gray-600">RM {{ number_format($dailyAllowance, 2) }}</span> =
                                                <span class="text-2xl font-bold text-green-600">RM {{ number_format($totalAllowance, 2) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
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
                    
                    allowanceContent.innerHTML = `
                        <div class="flex justify-center items-center py-20">
                            <div>
                                <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-green-600 mx-auto mb-4"></div>
                                <p class="text-center text-gray-600 font-semibold">Loading allowance data...</p>
                            </div>
                        </div>
                    `;
                    
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
                        allowanceContent.innerHTML = `
                            <div class="flex justify-center items-center py-20">
                                <div class="text-center">
                                    <div class="bg-red-50 border-2 border-red-200 rounded-xl p-8 inline-block">
                                        <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-red-700 font-bold text-lg mb-2">Error loading data</p>
                                        <p class="text-red-600 text-sm">Please try again or contact support</p>
                                    </div>
                                </div>
                            </div>
                        `;
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