<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training Schedule') }}
        </h2>
    </x-slot>

    {{-- External Stylesheets --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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
    .gradient-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
        letter-spacing: 0.05em;
        color: #475569;
        border-bottom: 2px solid #e2e8f0;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .data-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* ========================================= */
    /* MODAL STYLES */
    /* ========================================= */
    .modal-overlay {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* ========================================= */
    /* FULLCALENDAR CUSTOMIZATION */
    /* ========================================= */
    .fc {
        border-radius: 0.5rem;
        overflow: hidden;
    }

    .fc .fc-toolbar {
        padding: 1rem;
        background: linear-gradient(to right, #f8fafc 0%, #f1f5f9 100%);
    }

    .fc .fc-button-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
    }

    .fc .fc-button-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    .fc .fc-button-primary:not(:disabled):active,
    .fc .fc-button-primary:not(:disabled).fc-button-active {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
    }

    /* ========================================= */
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 640px) {
        .dashboard-card:hover {
            transform: none !important;
        }

        .fc .fc-toolbar-title {
            font-size: 1.125rem !important;
        }

        .fc .fc-daygrid-day-number {
            font-size: 0.875rem !important;
        }
    }
    </style>

    <div class="py-4 sm:py-8 pb-8 sm:pb-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">

                {{-- ================================================================ --}}
                {{-- HEADER SECTION --}}
                {{-- ================================================================ --}}
                <div class="text-center mb-4 sm:mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 gradient-header rounded-2xl shadow-lg mb-3 sm:mb-4">
                        <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 mb-1 sm:mb-2 px-2">Training Schedule</h1>
                    <p class="text-gray-600 text-sm sm:text-lg px-2">View your upcoming training sessions and schedule</p>
                </div>

                {{-- ================================================================ --}}
                {{-- ERROR MESSAGE --}}
                {{-- ================================================================ --}}
                @if(isset($error))
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-lg">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">
                                    <strong class="font-bold">Error:</strong> {{ $error }}
                                </p>
                            </div>
                        </div>
                    </div>
                @else

                {{-- ================================================================ --}}
                {{-- CALENDAR VIEW --}}
                {{-- ================================================================ --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-xl sm:rounded-2xl dashboard-card">
                    <div class="section-header">
                        <div class="flex items-center mb-1 sm:mb-2">
                            <div class="icon-wrapper gradient-blue mr-2 sm:mr-3">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h2 class="text-lg sm:text-2xl font-bold text-gray-900 truncate">Training Calendar</h2>
                        </div>
                        <p class="text-gray-600 text-xs sm:text-base ml-9 sm:ml-13 hidden sm:block">Visual overview of your training schedule</p>
                    </div>

                    <div class="p-4 sm:p-8">
                        <div id="calendar"></div>

                        @if(empty($calendarEvents))
                            <div class="text-center py-8 sm:py-16">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1 sm:mb-2 px-2">No Training Sessions</h3>
                                <p class="text-gray-600 text-sm sm:text-lg px-2">No training sessions scheduled for your intake with the current filters.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================================================================ --}}
                {{-- TRAINING SESSIONS TABLE --}}
                {{-- ================================================================ --}}
                <div class="bg-white overflow-hidden shadow-lg rounded-xl sm:rounded-2xl dashboard-card">
                    <div class="section-header">
                        <div class="flex items-center mb-1 sm:mb-2">
                            <div class="icon-wrapper gradient-green mr-2 sm:mr-3">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h2 class="text-lg sm:text-2xl font-bold text-gray-900 truncate">Training Sessions</h2>
                        </div>
                        <p class="text-gray-600 ml-13">Detailed list of all training sessions</p>
                    </div>

                    <div class="p-8">
                        {{-- Filter Form --}}
                        <div class="mb-6 bg-gradient-to-r from-gray-50 to-blue-50 p-6 rounded-xl border border-gray-200">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                {{-- Year Filter --}}
                                <div>
                                    <label for="year" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Year
                                    </label>
                                    <select name="year" id="year" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                                        <option value="">All Years</option>
                                        @foreach($availableYears as $year)
                                            <option value="{{ $year }}" {{ $filterYear == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Month Filter --}}
                                <div>
                                    <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Month
                                    </label>
                                    <select name="month" id="month" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                                        <option value="">All Months</option>
                                    </select>
                                </div>

                                {{-- Status Filter --}}
                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Status
                                    </label>
                                    <select name="status" id="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-colors duration-200">
                                        <option value="">All Statuses</option>
                                        <option value="Active" {{ $filterStatus == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Completed" {{ $filterStatus == 'Completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="Cancelled" {{ $filterStatus == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Loading Spinner --}}
                        <div id="loading-spinner" class="hidden text-center py-12">
                            <div class="relative inline-block">
                                <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                            </div>
                            <p class="text-gray-600 mt-4 font-medium">Loading training data...</p>
                        </div>

                        {{-- Table Container --}}
                        <div id="table-container" class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="max-h-[600px] overflow-y-auto overflow-x-auto custom-scrollbar">
                                <table class="data-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Location</th>
                                            <th>Start</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Attendance</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($trainings as $training)
                                            <tr>
                                                <td>
                                                    <div class="text-sm font-medium text-gray-900">{{ $training->title }}</div>
                                                    @if($training->description)
                                                        <div class="text-sm text-gray-500 mt-1">{{ Str::limit($training->description, 60) }}</div>
                                                    @endif
                                                </td>
                                                <td class="text-sm text-gray-900">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                        {{ $training->location }}
                                                    </div>
                                                </td>
                                                <td class="text-sm text-gray-900">
                                                    <div class="font-medium">{{ $training->formatted_start_date }}</div>
                                                    <div class="text-gray-500">{{ $training->formatted_start_time }}</div>
                                                </td>
                                                <td class="text-sm text-gray-900">
                                                    {{ $training->formatted_duration }}
                                                </td>
                                                <td>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($training->status === 'Active') bg-green-100 text-green-800
                                                        @elseif($training->status === 'Completed') bg-gray-100 text-gray-800
                                                        @elseif($training->status === 'Cancelled') bg-red-100 text-red-800
                                                        @else bg-blue-100 text-blue-800 @endif">
                                                        {{ $training->status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @php
                                                        $cadet = \App\Models\Cadet::where('user_id', auth()->id())->first();
                                                        $attendance = null;
                                                        if ($cadet) {
                                                            $attendance = \App\Models\TrainingAttendance::where('training_id', $training->id)
                                                                ->where('cadet_id', $cadet->id)
                                                                ->first();
                                                        }
                                                    @endphp
                                                    @if($training->status === 'Completed' && $attendance)
                                                        @if($attendance->present)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                Present
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                                Absent
                                                            </span>
                                                        @endif
                                                    @elseif($training->status === 'Completed')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                            N/A
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            Upcoming
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button onclick="viewTraining({{ $training->id }})" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-4 py-12 text-center">
                                                    <div class="flex flex-col items-center">
                                                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                        </div>
                                                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Training Sessions</h3>
                                                        <p class="text-gray-600">There are no training sessions scheduled for your intake with the current filters.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- VIEW TRAINING DETAILS MODAL --}}
    {{-- ================================================================ --}}
    <div id="viewTrainingModal" class="modal-overlay fixed inset-0 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-6 border w-11/12 max-w-3xl modal-content my-10">
            {{-- Modal Header --}}
            <div class="flex justify-between items-center pb-4 border-b-2 border-gray-200">
                <div class="flex items-center">
                    <div class="icon-wrapper gradient-blue mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">Training Details</h3>
                </div>
                <button onclick="closeViewModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div id="trainingDetails" class="mt-6"></div>

            {{-- Modal Footer --}}
            <div class="mt-6 flex justify-end">
                <button onclick="closeViewModal()" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>

    {{-- External JavaScript --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script>
        let calendar;
        
        // Available years and months data from backend
        const availableYearsMonths = @json($availableYearsMonths ?? []);
        const currentFilterYear = "{{ $filterYear ?? '' }}";
        const currentFilterMonth = "{{ $filterMonth ?? '' }}";

        // Month names mapping
        const monthNames = {
            1: 'January', 2: 'February', 3: 'March', 4: 'April',
            5: 'May', 6: 'June', 7: 'July', 8: 'August',
            9: 'September', 10: 'October', 11: 'November', 12: 'December'
        };

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(!isset($error))
                initializeCalendar();
            @endif

            updateMonthFilter();
            document.getElementById('year').addEventListener('change', function() {
                updateMonthFilter();
                applyFilters();
            });
            document.getElementById('month').addEventListener('change', applyFilters);
            document.getElementById('status').addEventListener('change', applyFilters);
            renderTable(@json($formattedTrainings ?? $trainings));

            const viewTrainingModal = document.getElementById('viewTrainingModal');
            if (viewTrainingModal) {
                viewTrainingModal.addEventListener('click', function(e) {
                    if (e.target === this) closeViewModal();
                });
            }
        });

        // Apply filters via AJAX
        function applyFilters() {
            const year = document.getElementById('year').value;
            const month = document.getElementById('month').value;
            const status = document.getElementById('status').value;
            
            document.getElementById('loading-spinner').classList.remove('hidden');
            document.getElementById('table-container').classList.add('opacity-50');
            
            const params = new URLSearchParams();
            if (year) params.append('year', year);
            if (month) params.append('month', month);
            if (status) params.append('status', status);
            params.append('ajax', '1');
            
            fetch(`{{ route('cadet.training') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                renderTable(data.trainings);
                
                if (calendar) {
                    calendar.removeAllEvents();
                    calendar.addEventSource(data.calendarEvents);
                }
                
                const newUrl = `{{ route('cadet.training') }}?${params.toString().replace('ajax=1', '').replace(/&$/, '')}`;
                window.history.pushState({}, '', newUrl || '{{ route('cadet.training') }}');
                
                document.getElementById('loading-spinner').classList.add('hidden');
                document.getElementById('table-container').classList.remove('opacity-50');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load training data');
                document.getElementById('loading-spinner').classList.add('hidden');
                document.getElementById('table-container').classList.remove('opacity-50');
            });
        }

        // Render table with training data
        function renderTable(trainings) {
            const container = document.getElementById('table-container');
            
            if (!trainings || trainings.length === 0) {
                container.innerHTML = `
                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="max-h-[600px] overflow-y-auto overflow-x-auto custom-scrollbar">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Location</th>
                                        <th>Start</th>
                                        <th>Duration</th>
                                        <th>Status</th>
                                        <th>Attendance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="px-4 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">No Training Sessions</h3>
                                                <p class="text-gray-600">There are no training sessions scheduled for your intake with the current filters.</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                `;
                return;
            }
            
            let tableHtml = `
                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <div class="max-h-[600px] overflow-y-auto overflow-x-auto custom-scrollbar">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Location</th>
                                    <th>Start</th>
                                    <th>Duration</th>
                                    <th>Status</th>
                                    <th>Attendance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
            `;
            
            trainings.forEach(training => {
                const statusColor = getStatusBadgeColor(training.status);
                const description = training.description ? `<div class="text-sm text-gray-500 mt-1">${truncate(training.description, 60)}</div>` : '';
                
                tableHtml += `
                    <tr>
                        <td>
                            <div class="text-sm font-medium text-gray-900">${training.title}</div>
                            ${description}
                        </td>
                        <td class="text-sm text-gray-900">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                ${training.location}
                            </div>
                        </td>
                        <td class="text-sm text-gray-900">
                            <div class="font-medium">${training.formatted_start_date}</div>
                            <div class="text-gray-500">${training.formatted_start_time}</div>
                        </td>
                        <td class="text-sm text-gray-900">
                            ${training.formatted_duration}
                        </td>
                        <td>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColor}">
                                ${training.status}
                            </span>
                        </td>
                        <td>
                            ${getAttendanceBadge(training)}
                        </td>
                        <td>
                            <button onclick="viewTraining(${training.id})" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            tableHtml += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
            
            container.innerHTML = tableHtml;
        }

        // Truncate string
        function truncate(str, length) {
            return str.length > length ? str.substring(0, length) + '...' : str;
        }

        // Update month filter based on selected year
        function updateMonthFilter() {
            const yearSelect = document.getElementById('year');
            const monthSelect = document.getElementById('month');
            const selectedYear = yearSelect.value;
            
            monthSelect.innerHTML = '<option value="">All Months</option>';
            
            if (selectedYear && availableYearsMonths[selectedYear]) {
                availableYearsMonths[selectedYear].forEach(month => {
                    const option = document.createElement('option');
                    option.value = month;
                    option.textContent = monthNames[month];
                    
                    if (currentFilterMonth == month && currentFilterYear == selectedYear) {
                        option.selected = true;
                    }
                    
                    monthSelect.appendChild(option);
                });
            } else {
                const allMonths = new Set();
                Object.values(availableYearsMonths).forEach(months => {
                    months.forEach(month => allMonths.add(month));
                });
                
                Array.from(allMonths).sort((a, b) => a - b).forEach(month => {
                    const option = document.createElement('option');
                    option.value = month;
                    option.textContent = monthNames[month];
                    
                    if (currentFilterMonth == month && !currentFilterYear) {
                        option.selected = true;
                    }
                    
                    monthSelect.appendChild(option);
                });
            }
        }

        // Initialize calendar
        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($calendarEvents ?? []),
                eventClick: function(info) {
                    viewTraining(info.event.id);
                },
                height: 'auto',
                eventDisplay: 'block',
                eventTextColor: '#ffffff',
                displayEventTime: false
            });
            calendar.render();
        }

        // View training details
        function viewTraining(trainingId) {
            const modal = document.getElementById('viewTrainingModal');
            const detailsContainer = document.getElementById('trainingDetails');
            
            modal.classList.remove('hidden');
            detailsContainer.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="relative">
                        <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                        <p class="text-center text-gray-600 mt-4 font-medium">Loading details...</p>
                    </div>
                </div>
            `;
            
            fetch(`/cadet/training/${trainingId}`, {
                headers: { 'Accept': 'application/json' }
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(`HTTP ${response.status}: ${text}`);
                }
                return response.json();
            })
            .then(data => {
                const detailsHtml = `
                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                            <h4 class="text-2xl font-bold text-gray-900 mb-2">${data.title}</h4>
                            ${data.description ? `<p class="text-gray-700">${data.description}</p>` : ''}
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Location
                                </label>
                                <p class="text-base text-gray-900">${data.location}</p>
                            </div>
                            
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Status
                                </label>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full ${getStatusBadgeColor(data.status)}">${data.status}</span>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Start Date & Time
                                </label>
                                <p class="text-base text-gray-900">${formatDateTime(data.start_datetime)}</p>
                            </div>
                            
                            ${data.end_datetime ? `
                            <div class="bg-white border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    End Date & Time
                                </label>
                                <p class="text-base text-gray-900">${formatDateTime(data.end_datetime)}</p>
                            </div>` : ''}
                        </div>
                        
                        ${data.involvement ? `
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <svg class="w-4 h-4 inline mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Cadet Intakes Involved
                            </label>
                            <p class="text-base text-purple-900 font-medium">${data.involvement}</p>
                        </div>` : ''}
                    </div>
                `;
                detailsContainer.innerHTML = detailsHtml;
            })
            .catch(err => {
                console.error('Error fetching training details:', err);
                detailsContainer.innerHTML = `
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <p class="text-red-600 font-medium">Unable to load training details</p>
                    </div>
                `;
            });
        }

        // Close modal
        function closeViewModal() {
            document.getElementById('viewTrainingModal').classList.add('hidden');
        }

        // Format date time
        function formatDateTime(datetime) {
            const date = new Date(datetime);
            const day = date.toLocaleDateString('en-MY', { year: 'numeric', month: 'short', day: 'numeric' });
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${day} ${hours}${minutes}H`;
        }

        // Get status badge color
        function getStatusBadgeColor(status) {
            switch(status) {
                case 'Active': return 'bg-green-100 text-green-800';
                case 'Completed': return 'bg-gray-100 text-gray-800';
                case 'Cancelled': return 'bg-red-100 text-red-800';
                default: return 'bg-blue-100 text-blue-800';
            }
        }

        // Get attendance badge HTML
        function getAttendanceBadge(training) {
            if (training.status === 'Completed' && training.attendance_status) {
                if (training.attendance_status === 'Present') {
                    return `
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Present
                        </span>
                    `;
                } else {
                    return `
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Absent
                        </span>
                    `;
                }
            } else if (training.status === 'Completed') {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">N/A</span>';
            } else {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Upcoming</span>';
            }
        }

        // Auto-open training modal from URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const trainingId = urlParams.get('training_id');

            if (trainingId) {
                setTimeout(() => {
                    viewTraining(trainingId);
                    // Remove the parameter from URL without reloading
                    const newUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                }, 500);
            }
        });
    </script>
</x-app-layout>