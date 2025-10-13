<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allowance (Instructor)') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE HEADER --}}
            {{-- ================================================================ --}}

            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 mr-2 sm:mr-3 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    <span class="leading-tight">Training Allowance Management</span>
                </h1>
                <p class="text-sm sm:text-base text-gray-600">Manage and track cadet training allowances</p>
            </div>

            {{-- ================================================================ --}}
            {{-- TRAINING LIST SECTION --}}
            {{-- ================================================================ --}}

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300" id="training-list-container">
                
                {{-- Section Header with Filters --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 sm:p-6 border-b border-gray-200">
                    <div class="flex flex-col gap-4">
                        <div>
                            <h2 class="text-lg sm:text-2xl font-semibold mb-2 flex items-start sm:items-center text-gray-900">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-green-600 flex-shrink-0 mt-0.5 sm:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <span class="leading-tight">
                                    Training Sessions for
                                    <span id="selected-month" class="text-green-600 block sm:inline sm:ml-2">{{ $months[$selectedMonth] ?? 'Unknown' }}</span>
                                    <span id="selected-year" class="text-green-600 sm:ml-1">{{ $selectedYear ?? date('Y') }}</span>
                                </span>
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">View and manage cadet allowances</p>
                        </div>

                        <form method="GET" action="{{ route('instructor.allowance') }}" class="flex gap-2 sm:gap-3">
                            <div class="flex-1">
                                <label for="year" class="text-xs font-medium text-gray-700 mb-1 block">Year</label>
                                <select name="year" id="year" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200 text-sm py-2">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ ($selectedYear ?? date('Y')) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex-1">
                                <label for="month" class="text-xs font-medium text-gray-700 mb-1 block">Month</label>
                                <select name="month" id="month" class="w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200 text-sm py-2">
                                    @foreach($months as $value => $name)
                                        <option value="{{ $value }}" {{ ($selectedMonth ?? date('n')) == $value ? 'selected' : '' }}>
                                            {{ $name ?? 'Unknown' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Training List Content --}}
                <div class="p-3 sm:p-6" id="training-list-content">
                    @if($trainings->count() > 0)
                        <div class="space-y-3 sm:space-y-4">
                            @foreach($trainings as $training)
                                <div class="border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                                    
                                    {{-- Training Header (Clickable) --}}
                                    <div class="p-3 sm:p-4 bg-gradient-to-r from-gray-50 to-blue-50 cursor-pointer hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 training-header"
                                         data-training-id="{{ $training->id }}">
                                        <div class="flex items-start justify-between gap-3">
                                            
                                            {{-- Left Content --}}
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 text-sm sm:text-base mb-1 truncate">{{ $training->title }}</h4>
                                                
                                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-600">
                                                    {{-- Location --}}
                                                    <div class="flex items-center min-w-0">
                                                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        <span class="truncate">{{ $training->location }}</span>
                                                    </div>
                                                    
                                                    {{-- Date --}}
                                                    <div class="flex items-center flex-shrink-0">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        @if($training->end_datetime && $training->start_datetime->toDateString() !== $training->end_datetime->toDateString())
                                                            <span class="whitespace-nowrap">{{ $training->start_datetime->format('d/m/y') }} - {{ $training->end_datetime->format('d/m/y') }}</span>
                                                        @else
                                                            <span class="whitespace-nowrap">{{ $training->start_datetime->format('d/m/Y') }}</span>
                                                        @endif
                                                    </div>
                                                    
                                                    {{-- Duration Badge --}}
                                                    @php
                                                        $duration = '';
                                                        if($training->end_datetime) {
                                                            $start = \Carbon\Carbon::parse($training->start_datetime);
                                                            $end = \Carbon\Carbon::parse($training->end_datetime);
                                                            $isMultiDay = $start->toDateString() !== $end->toDateString();
                                                            
                                                            if ($isMultiDay) {
                                                                $days = floor($start->diffInDays($end)) + 1;
                                                                $duration = $days . ' days';
                                                            } else {
                                                                $diffInMinutes = $start->diffInMinutes($end);
                                                                $calculatedHours = (int) round($diffInMinutes / 60);
                                                                $hours = max(2, min(10, $calculatedHours));
                                                                $duration = $hours . 'h';
                                                            }
                                                        } else {
                                                            $duration = 'N/A';
                                                        }
                                                    @endphp
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700">
                                                        {{ $duration }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            {{-- Right Arrow --}}
                                            <div class="flex-shrink-0 flex items-center gap-1">
                                                <span class="text-xs font-medium text-blue-600 bg-blue-100 px-2 py-1 rounded-full whitespace-nowrap">
                                                    Details
                                                </span>
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 transform transition-transform duration-300 training-arrow" 
                                                     id="arrow-{{ $training->id }}">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                
                                    {{-- Training Details (Hidden by default) --}}
                                    <div class="hidden training-details" id="details-{{ $training->id }}">
                                        
                                        {{-- Intake Filter --}}
                                        <div class="px-3 sm:px-4 py-3 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                                <label for="intake-{{ $training->id }}" class="text-sm font-medium text-gray-700 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                                    </svg>
                                                    <span>Filter by Intake</span>
                                                </label>
                                                <select id="intake-{{ $training->id }}"
                                                        class="bg-white border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 shadow-sm hover:border-blue-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-auto sm:min-w-[180px]"
                                                        onchange="filterByIntake({{ $training->id }})">
                                                    <option value="">All Intakes</option>
                                                </select>
                                            </div>
                                        </div>
                                                                            
                                        {{-- Cadet List --}}
                                        <div class="p-3 sm:p-6 bg-white">
                                            <div class="overflow-x-auto -mx-3 sm:mx-0">
                                                <div class="inline-block min-w-full align-middle px-3 sm:px-0">
                                                    <!-- Scrollable container with max height for 10 rows -->
                                                    <div class="overflow-y-auto" style="max-height: 520px;">
                                                        <table class="min-w-full divide-y divide-gray-200" id="cadets-table-{{ $training->id }}">
                                                            <thead class="bg-gradient-to-r from-gray-50 to-blue-50 sticky top-0 z-10">
                                                                <tr>
                                                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                                                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-gray-700 uppercase">Service No</th>
                                                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-gray-700 uppercase hidden lg:table-cell">Rank</th>
                                                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-gray-700 uppercase">Name</th>
                                                                    <th class="px-2 sm:px-4 py-2 sm:py-3 text-left text-xs font-semibold text-gray-700 uppercase hidden md:table-cell">Bank Account</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-white divide-y divide-gray-200">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Allowance Summary --}}
                                            <div class="mt-4 sm:mt-6 p-3 sm:p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200" id="summary-{{ $training->id }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-8 sm:py-12">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 sm:h-16 sm:w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-2">No trainings found</h3>
                                <p class="text-sm text-gray-500 px-4">
                                    No trainings found for <span id="selected-month-empty" class="font-medium text-blue-600">{{ $months[$selectedMonth] ?? 'Unknown' }}</span> <span id="selected-year-empty" class="font-medium text-blue-600">{{ $selectedYear ?? date('Y') }}</span>.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}

    <script>
        let loadedTrainings = new Set();
        let trainingData = {};

        document.addEventListener('DOMContentLoaded', function() {
            initializeEventListeners();
        });

        function initializeEventListeners() {
            const yearSelect = document.getElementById('year');
            const monthSelect = document.getElementById('month');
            
            if (yearSelect) {
                yearSelect.removeEventListener('change', filterTrainingsAjax);
                yearSelect.addEventListener('change', filterTrainingsAjax);
            }
            
            if (monthSelect) {
                monthSelect.removeEventListener('change', filterTrainingsAjax);
                monthSelect.addEventListener('change', filterTrainingsAjax);
            }

            const trainingContainer = document.getElementById('training-list-container');
            if (trainingContainer) {
                trainingContainer.removeEventListener('click', handleTrainingClick);
                trainingContainer.addEventListener('click', handleTrainingClick);
            }
        }

        function handleTrainingClick(e) {
            const header = e.target.closest('.training-header');
            if (header) {
                const trainingId = header.getAttribute('data-training-id');
                if (trainingId) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleTrainingDetails(trainingId);
                }
            }
        }

        function filterTrainingsAjax() {
            const year = document.getElementById('year').value;
            const month = document.getElementById('month').value;
            const trainingListContent = document.getElementById('training-list-content');
            
            trainingListContent.innerHTML = `
                <div class="text-center py-12">
                    <div class="inline-flex items-center px-4 sm:px-6 py-3 font-semibold leading-6 text-sm shadow-lg rounded-xl text-white bg-gradient-to-r from-blue-500 to-blue-600 transition ease-in-out duration-150 cursor-wait">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Loading...
                    </div>
                </div>
            `;
            
            loadedTrainings.clear();
            trainingData = {};
            
            fetch(`/instructor/allowance?year=${year}&month=${month}&ajax=1`)
                .then(response => response.json())
                .then(data => {
                    trainingListContent.innerHTML = data.html;
                    
                    const selectedMonthElement = document.getElementById('selected-month');
                    const selectedYearElement = document.getElementById('selected-year');
                    const selectedMonthEmptyElement = document.getElementById('selected-month-empty');
                    const selectedYearEmptyElement = document.getElementById('selected-year-empty');
                    
                    if (selectedMonthElement) selectedMonthElement.textContent = data.monthName;
                    if (selectedYearElement) selectedYearElement.textContent = data.year;
                    if (selectedMonthEmptyElement) selectedMonthEmptyElement.textContent = data.monthName;
                    if (selectedYearEmptyElement) selectedYearEmptyElement.textContent = data.year;
                    
                    initializeEventListeners();
                })
                .catch(error => {
                    console.error('Error loading trainings:', error);
                    trainingListContent.innerHTML = `
                        <div class="text-center py-12 px-4">
                            <div class="text-red-500">
                                <svg class="mx-auto h-12 w-12 text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h3 class="text-lg font-medium text-red-900 mb-2">Error loading trainings</h3>
                                <p class="text-sm text-red-600">Please try again later.</p>
                            </div>
                        </div>
                    `;
                });
        }

        function toggleTrainingDetails(trainingId) {
            const detailsDiv = document.getElementById(`details-${trainingId}`);
            const arrow = document.getElementById(`arrow-${trainingId}`);

            const isCurrentlyOpen = detailsDiv && !detailsDiv.classList.contains('hidden');

            document.querySelectorAll('.training-details').forEach(function(div) {
                div.classList.add('hidden');
            });
            document.querySelectorAll('.training-arrow').forEach(function(arrow) {
                arrow.style.transform = 'rotate(0deg)';
            });

            if (!isCurrentlyOpen && detailsDiv) {
                detailsDiv.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';

                if (!loadedTrainings.has(trainingId)) {
                    loadTrainingDetails(trainingId);
                }
            }
        }

        function loadTrainingDetails(trainingId) {
            const tableBody = document.querySelector(`#cadets-table-${trainingId} tbody`);
            const intakeSelect = document.getElementById(`intake-${trainingId}`);
            const summary = document.getElementById(`summary-${trainingId}`);

            if (!tableBody) return;

            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-8">
                        <div class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Loading...</span>
                        </div>
                    </td>
                </tr>
            `;

            fetch(`/instructor/allowance/training/${trainingId}/details`)
                .then(response => response.json())
                .then(data => {
                    trainingData[trainingId] = data;

                    // Populate intake dropdown WITHOUT "All Intakes" option
                    if (intakeSelect) {
                        intakeSelect.innerHTML = '';
                        data.available_intakes.forEach(intake => {
                            const option = document.createElement('option');
                            option.value = intake;
                            option.textContent = intake;
                            // Select the most senior intake (default_intake) by default
                            if (data.default_intake && intake === data.default_intake) {
                                option.selected = true;
                            }
                            intakeSelect.appendChild(option);
                        });
                    }

                    // Filter cadets by the most senior intake (default_intake)
                    let cadetsToShow = data.cadets;
                    if (data.default_intake) {
                        cadetsToShow = data.cadets.filter(cadet => cadet.intake === data.default_intake);
                    }
                    
                    displayCadets(trainingId, cadetsToShow);
                    
                    // Calculate and display summary for filtered cadets only
                    const filteredSummary = calculateFilteredSummary(data.summary, cadetsToShow.length);
                    displaySummary(trainingId, filteredSummary);

                    loadedTrainings.add(trainingId);
                })
                .catch(error => {
                    console.error('Error loading training details:', error);
                    if (tableBody) {
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="5" class="text-center py-8 text-red-500">
                                    <div>
                                        <svg class="mx-auto h-8 w-8 text-red-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm">Error loading data</span>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }
                });
        }

        function calculateFilteredSummary(originalSummary, filteredCadetsCount) {
            const baseRate = originalSummary.base_rate || 0;
            const durationValue = originalSummary.duration_value || 0;
            const newTotalAllowance = filteredCadetsCount * baseRate * durationValue;
            
            return {
                ...originalSummary,
                total_cadets: filteredCadetsCount,
                total_allowance: newTotalAllowance
            };
        }

        function displayCadets(trainingId, cadets) {
            const tableBody = document.querySelector(`#cadets-table-${trainingId} tbody`);
            
            if (!tableBody) return;
            
            if (cadets.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center py-8 text-gray-500">
                            <div>
                                <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="text-sm">No cadets found</span>
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            const rows = cadets.map((cadet, index) => `
                <tr class="${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'} hover:bg-blue-50 transition-colors duration-200">
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">${index + 1}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-xs sm:text-sm font-medium text-blue-600">${cadet.service_number}</td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden lg:table-cell">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            ${cadet.rank}
                        </span>
                    </td>
                    <td class="px-2 sm:px-4 py-3 text-xs sm:text-sm font-medium text-gray-900">
                        <div class="max-w-[150px] sm:max-w-xs truncate">${cadet.name}</div>
                        <div class="lg:hidden text-xs text-gray-500 mt-1">
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                ${cadet.rank}
                            </span>
                        </div>
                        <div class="md:hidden text-xs text-gray-500 mt-1 font-mono">
                            ${cadet.bank_account}
                        </div>
                    </td>
                    <td class="px-2 sm:px-4 py-3 whitespace-nowrap text-xs sm:text-sm text-gray-900 font-mono hidden md:table-cell">${cadet.bank_account}</td>
                </tr>
            `).join('');

            tableBody.innerHTML = rows;
        }

        function displaySummary(trainingId, summary) {
            const summaryDiv = document.getElementById(`summary-${trainingId}`);

            if (!summaryDiv) return;

            const totalCadets = summary.total_cadets || 0;
            const baseRate = summary.base_rate || 0;
            const durationValue = summary.duration_value || 0;
            const durationUnit = summary.duration_unit || 'hours';
            const totalAllowance = summary.total_allowance || 0;
            const allowanceType = summary.allowance_type || 'hourly';
            const isMultiDay = summary.is_multi_day || false;

            let calculationFormula = '';
            let rateLabel = '';
            let typeIcon = '';

            if (allowanceType === 'daily' || isMultiDay) {
                calculationFormula = `<span class="font-semibold">${totalCadets}</span> cadets × <span class="font-semibold">RM${baseRate}</span> × <span class="font-semibold">${durationValue} ${durationUnit}</span>`;
                rateLabel = `RM ${baseRate}/day`;
                typeIcon = '(daily)';
            } else {
                calculationFormula = `<span class="font-semibold">${totalCadets}</span> cadets × <span class="font-semibold">RM${baseRate}</span> × <span class="font-semibold">${durationValue} ${durationUnit}</span>`;
                rateLabel = `RM ${baseRate}/hour`;
                typeIcon = '(hourly)';
            }

            const formattedTotal = new Intl.NumberFormat().format(totalAllowance);

            summaryDiv.innerHTML = `
                <div class="flex items-center mb-3 sm:mb-4">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h4 class="text-sm sm:text-base font-semibold text-gray-800">Allowance Summary <span class="text-xs text-gray-600">${typeIcon}</span></h4>
                </div>
                <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-3 sm:mb-4">
                    <div class="text-center bg-white rounded-lg p-2 sm:p-3 shadow-sm border border-blue-200">
                        <div class="text-base sm:text-lg font-bold text-blue-600">${totalCadets}</div>
                        <div class="text-xs text-gray-600 mt-1 flex items-center justify-center gap-1">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            <span class="hidden sm:inline">Total Cadets</span>
                            <span class="sm:hidden">Cadets</span>
                        </div>
                    </div>
                    <div class="text-center bg-white rounded-lg p-2 sm:p-3 shadow-sm border border-green-200">
                        <div class="text-sm sm:text-lg font-bold text-green-600">${rateLabel}</div>
                        <div class="text-xs text-gray-600 mt-1 flex items-center justify-center gap-1">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                            <span class="hidden sm:inline">Base Rate</span>
                            <span class="sm:hidden">Rate</span>
                        </div>
                    </div>
                    <div class="text-center bg-white rounded-lg p-2 sm:p-3 shadow-sm border border-purple-200">
                        <div class="text-sm sm:text-lg font-bold text-purple-600">RM${formattedTotal}</div>
                        <div class="text-xs text-gray-600 mt-1 flex items-center justify-center gap-1">
                            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="hidden sm:inline">Total</span>
                            <span class="sm:hidden">Total</span>
                        </div>
                    </div>
                </div>
                <div class="p-2 sm:p-3 bg-white rounded-lg border border-purple-200 shadow-sm">
                    <div class="text-xs sm:text-sm text-gray-700">
                        <div class="flex items-center justify-center mb-2 gap-1">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-medium">Calculation</span>
                        </div>
                        <div class="text-center text-xs sm:text-sm leading-relaxed">
                            ${calculationFormula} = <span class="font-semibold text-purple-600">RM${formattedTotal}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        function filterByIntake(trainingId) {
            const intakeSelect = document.getElementById(`intake-${trainingId}`);
            const selectedIntake = intakeSelect ? intakeSelect.value : '';
            const originalData = trainingData[trainingId];
            
            if (!originalData) return;
            
            // Filter cadets by selected intake
            let filteredCadets = originalData.cadets.filter(cadet => cadet.intake === selectedIntake);
            
            displayCadets(trainingId, filteredCadets);
            
            // Recalculate summary based on filtered cadets count
            const filteredSummary = calculateFilteredSummary(originalData.summary, filteredCadets.length);
            displaySummary(trainingId, filteredSummary);
        }
    </script>
</x-app-layout>