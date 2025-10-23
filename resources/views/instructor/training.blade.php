<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Training Schedule') }}
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
    /* GRADIENT BACKGROUNDS */
    /* ========================================= */
    .gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- DASHBOARD HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-blue rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">
                    Training Schedule Management
                </h1>
                <p class="text-lg text-gray-600">Manage training sessions and track attendance</p>
            </div>
            
            {{-- ================================================================ --}}
            {{-- TODAY'S TRAINING SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-green mr-3 p-2 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Today's Training Sessions</h3>
                        </div>
                        <button onclick="openAttendanceListModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="flex-shrink-0">Attendance List</span>
                        </button>
                    </div>
                    <p class="text-gray-600 ml-13">Manage attendance for ongoing training sessions</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if($todaysTrainings->count() > 0)
                            @foreach($todaysTrainings as $training)
                            <div class="border-2 border-gray-200 rounded-lg p-6 bg-gradient-to-r from-gray-50 to-blue-50 hover:shadow-lg transition-all duration-300">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $training->title }}</h4>
                                        <div class="space-y-1 text-gray-600">
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                {{ $training->location }}
                                            </p>
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                @if($training->end_datetime && $training->start_datetime->toDateString() !== $training->end_datetime->toDateString())
                                                    <!-- Multi-day training -->
                                                    <span>{{ $training->start_datetime->format('M d, Y') }} - {{ $training->end_datetime->format('M d, Y') }} | Starts: {{ $training->formatted_start_time }} | Ends: {{ $training->end_datetime->format('h:i A') }}</span>
                                                @else
                                                    <!-- Single day training -->
                                                    <span>{{ $training->formatted_start_date }} at {{ $training->formatted_start_time }}@if($training->end_datetime) - {{ $training->end_datetime->format('h:i A') }}@endif</span>
                                                @endif
                                            </p>
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                {{ $training->involvement ?? 'Not specified' }}
                                            </p>
                                            @if($training->end_datetime && $training->start_datetime->toDateString() !== $training->end_datetime->toDateString())
                                                <!-- Show duration for multi-day trainings -->
                                                <p class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                                        {{ floor($training->start_datetime->diffInDays($training->end_datetime)) + 1 }}-day training
                                                    </span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col w-48 ml-6 gap-3">
                                        <button onclick="openAttendanceModal({{ $training->id }})" class="bg-green-600 hover:bg-green-700 text-white w-full py-3 rounded-lg text-base font-semibold transition duration-200 flex items-center justify-center shadow-lg hover:shadow-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            Attendance
                                        </button>
                                        @if($training->status === 'Active' && empty($training->end_datetime))
                                        <button onclick="endTraining({{ $training->id }})" class="bg-red-600 hover:bg-red-700 text-white w-full py-3 rounded-lg text-base font-semibold transition duration-200 flex items-center justify-center shadow-lg hover:shadow-xl">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                                            </svg>
                                            End Training
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 bg-gray-50 text-center">
                                <svg class="w-12 h-12 text-gray-300 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <h4 class="text-lg font-semibold text-gray-500 mb-2">No training sessions scheduled for today</h4>
                                <p class="text-sm text-gray-400">There are no nearby training sessions. Please check the calendar or add a new training session.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- TRAINING CALENDAR SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-blue mr-3 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Training Calendar</h3>
                            </div>
                            <p class="text-gray-600 ml-13">View scheduled trainings in calendar format</p>
                        </div>
                        <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="flex-shrink-0">Add Training</span>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <div id="calendar" style="min-height: 500px;"></div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ACTIVITY TIME TABLE SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-purple mr-3 p-2 rounded-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Activity Time Table</h3>
                    </div>
                    <p class="text-gray-600 ml-13">Detailed list of all training sessions and their status</p>
                </div>
                <div class="p-6">
                    <!-- Filter Form -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Year Filter -->
                            <div>
                                <label for="activityYear" class="block text-sm font-medium text-gray-700 mb-2">Year</label>
                                <select name="activityYear" id="activityYear" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">All Years</option>
                                    @foreach($availableYears as $year)
                                        <option value="{{ $year }}" {{ $filterYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Month Filter -->
                            <div>
                                <label for="activityMonth" class="block text-sm font-medium text-gray-700 mb-2">Month</label>
                                <select name="activityMonth" id="activityMonth" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">All Months</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label for="activityStatus" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="activityStatus" id="activityStatus" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">All Statuses</option>
                                    <option value="Active" {{ $filterStatus == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Completed" {{ $filterStatus == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ $filterStatus == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="activityLoadingSpinner" class="hidden text-center py-8">
                        <svg class="animate-spin h-8 w-8 mx-auto text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 mt-2">Loading...</p>
                    </div>

                    <div id="activityTableContainer" class="overflow-x-auto" style="max-height: 350px; overflow-y: auto;">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100 sticky top-0 z-20">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 sticky top-0">Title</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 sticky top-0">Involvement</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 sticky top-0">Location</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 sticky top-0">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 sticky top-0">Duration</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 sticky top-0">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-100 sticky top-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="activityTableBody">
                                <!-- Table content will be rendered here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== ALL MODALS SECTION ===== -->
    <!-- Create/Edit Training Modal -->
    <div id="trainingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Header with Close Button -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">Create Training Session</h3>
                        <button onclick="closeModal()" type="button" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Form -->
                <form id="trainingForm" class="p-6 space-y-6">
                    <input type="hidden" id="trainingId" name="training_id">
                    
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Basic Information</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Training Title *</label>
                                <input type="text" id="title" name="title" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter training title">
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
                                <input type="text" id="location" name="location" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Training location">
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" name="description" rows="3" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Optional training description"></textarea>
                        </div>
                    </div>

                    <!-- Participants -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Participants</h4>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Cadet Intakes *</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-gray-50 rounded-lg" id="dynamicIntakeCheckboxes">
                                <!-- Dynamic intake checkboxes will be rendered here -->
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Select which cadet intakes will participate in this training</p>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Schedule</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Start Date/Time -->
                            <div class="space-y-3">
                                <h5 class="text-sm font-medium text-gray-700">Start Date & Time *</h5>
                                <div class="space-y-2">
                                    <input type="date" id="start_date" name="start_date" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <select id="start_time" name="start_time" required 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select start time</option>
                                        @foreach(\App\Models\Training::getHourOptions() as $hour)
                                            <option value="{{ $hour }}">{{ substr($hour, 0, 2) }}:00</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- End Date/Time -->
                            <div class="space-y-3">
                                <h5 class="text-sm font-medium text-gray-700">End Date & Time</h5>
                                <div class="space-y-2">
                                    <input type="date" id="end_date" name="end_date" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <select id="end_time" name="end_time" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select end time</option>
                                        @foreach(\App\Models\Training::getHourOptions() as $hour)
                                            <option value="{{ $hour }}">{{ substr($hour, 0, 2) }}:00</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="text-xs text-gray-500">Leave empty if training duration is unknown</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Status</h4>
                        
                        <div class="w-full md:w-1/2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Training Status *</label>
                            <select id="status" name="status" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeModal()" 
                            class="px-6 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span id="submitText">Create Training</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Training Session</h3>
                    <p class="text-sm text-gray-600">Are you sure you want to delete this training session? This action cannot be undone.</p>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md">
                        Cancel
                    </button>
                    <button id="confirmDelete" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

<!-- Attendance Modal -->
<div id="attendanceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-5xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Take Attendance</h3>
                        <p id="trainingTitle" class="text-sm text-gray-600 mt-1"></p>
                    </div>
                    <button onclick="closeAttendanceModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 overflow-y-auto flex-1">
                <!-- Loading State -->
                <div id="attendanceLoading" class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-gray-600">Loading cadets...</p>
                </div>

                <!-- Main Content -->
                <div id="attendanceContent" class="hidden">
                    <!-- Controls Row -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <!-- Intake Filter -->
                            <div id="intakeFilterSection">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Intake:</label>
                                <div class="flex flex-wrap gap-2" id="intakeFilters"></div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="flex gap-2">
                                <button onclick="markAllPresent()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md text-sm font-medium">
                                    Mark All Present
                                </button>
                                <button onclick="markAllAbsent()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm font-medium">
                                    Mark All Absent
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-blue-700" id="totalCadets">0</div>
                            <div class="text-sm text-blue-600">Total Cadets</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-green-700" id="presentCount">0</div>
                            <div class="text-sm text-green-600">Present</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg text-center">
                            <div class="text-2xl font-bold text-red-700" id="absentCount">0</div>
                            <div class="text-sm text-red-600">Absent</div>
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex gap-2 mb-4">
                        <button id="filterAll" class="px-3 py-1 text-sm rounded-md bg-blue-600 text-white border" onclick="setAttendanceFilter('all')">All</button>
                        <button id="filterPresent" class="px-3 py-1 text-sm rounded-md bg-gray-200 text-gray-700 border" onclick="setAttendanceFilter('present')">Present Only</button>
                        <button id="filterAbsent" class="px-3 py-1 text-sm rounded-md bg-gray-200 text-gray-700 border" onclick="setAttendanceFilter('absent')">Absent Only</button>
                    </div>

                    <!-- Cadet List -->
                    <div id="cadetsList" class="space-y-4"></div>

                    <!-- Save Button -->
                    <div class="mt-6 text-center">
                        <button onclick="saveAttendance()" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                            Save Attendance
                        </button>
                    </div>
                </div>

                <!-- Error State -->
                <div id="attendanceError" class="hidden text-center py-12">
                    <div class="text-red-500 mb-4">
                        <i class="fas fa-exclamation-triangle text-4xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4" id="errorMessage">Failed to load cadets</p>
                    <button onclick="loadCadetsForAttendance(currentTrainingId)" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                        Try Again
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance List Modal -->
<div id="attendanceListModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 hidden z-50">
    <div class="min-h-full flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full max-h-[90vh] overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Attendance Reports</h3>
                    <button onclick="closeAttendanceListModal()" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 overflow-y-auto flex-1">
                <!-- Loading State -->
                <div id="attendanceListLoading" class="text-center py-12">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <p class="mt-2 text-gray-600">Loading attendance data...</p>
                </div>

                <!-- Main Content -->
                <div id="attendanceListContent" class="hidden">
                    <!-- Filters - Removed Status Filter -->
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                                <select id="attendanceListYearFilter" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                                <select id="attendanceListMonthFilter" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></select>
                            </div>
                            <div id="attendanceListIntakeSection" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Intake</label>
                                <select id="attendanceListIntakeFilter" class="w-full px-3 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></select>
                            </div>
                        </div>
                    </div>

                    <!-- Training Sessions -->
                    <div id="attendanceListTrainings" class="space-y-4"></div>

                    <!-- Empty State -->
                    <div id="attendanceListEmpty" class="hidden text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-calendar-times text-4xl"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-500 mb-2">No Training Sessions Found</h4>
                        <p class="text-sm text-gray-400">Try adjusting your filters to see more results.</p>
                    </div>
                </div>

                <!-- Error State -->
                <div id="attendanceListError" class="hidden text-center py-12">
                    <div class="text-red-500 mb-4">
                        <i class="fas fa-exclamation-triangle text-4xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4" id="attendanceListErrorMessage">Failed to load data</p>
                    <button onclick="fetchAttendanceListData()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                        Try Again
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Modal Styles -->
    <style>
/* Ensure notifications don't affect layout */
.toast-notification {
    position: fixed !important;
    z-index: 9999 !important;
    pointer-events: none;
}

.toast-notification.show {
    pointer-events: auto;
}

/* Prevent any top spacing issues */
body > div:first-child {
    margin-top: 0 !important;
}

    /* Consistent modal styles */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
    }

    .modal-backdrop.hidden {
        display: none;
    }

    /* Custom scrollbar for all modals */
    .modal-content {
        scrollbar-width: thin;
        scrollbar-color: #CBD5E0 #F7FAFC;
    }

    .modal-content::-webkit-scrollbar {
        width: 6px;
    }

    .modal-content::-webkit-scrollbar-track {
        background: #F7FAFC;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: #CBD5E0;
        border-radius: 3px;
    }

    .modal-content::-webkit-scrollbar-thumb:hover {
        background: #A0AEC0;
    }

    /* Enhanced checkbox styling */
input[type="checkbox"]:checked + span {
    color: #1d4ed8;
    font-weight: 600;
}

input[type="checkbox"]:checked {
    background-color: #2563eb;
    border-color: #2563eb;
}

/* Better form focus states */
.form-input:focus {
    outline: none;
    ring: 2px;
    ring-color: #3b82f6;
    border-color: #3b82f6;
}

/* Loading state for submit button */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

.loading svg {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
    </style>

    @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/main.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
<!-- Updated JavaScript section for the view file -->
<script>
    let calendar;
    let currentTrainingId = null;
    let cadetsData = [];
    let currentIntakeFilter = 'all';
    let currentAttendanceFilter = 'all';

    document.addEventListener('DOMContentLoaded', function() {
        initializeCalendar();
        renderDynamicIntakeCheckboxes();
        // Form submission handler
        document.getElementById('trainingForm').addEventListener('submit', handleFormSubmit);
        
        // Add checkbox interaction
        document.addEventListener('change', function(e) {
            if (e.target.name === 'involvement[]') {
                const label = e.target.closest('label');
                if (e.target.checked) {
                    label.classList.add('bg-blue-50', 'border-blue-300');
                } else {
                    label.classList.remove('bg-blue-50', 'border-blue-300');
                }
            }
        });
    });

    // Dynamically render intake checkboxes based on current year
    function renderDynamicIntakeCheckboxes() {
        const container = document.getElementById('dynamicIntakeCheckboxes');
        container.innerHTML = '';
        const currentYear = new Date().getFullYear();
        const startIntakeYear = currentYear - 3;
        const intakes = [];
        
        for (let year = startIntakeYear; year <= currentYear; year++) {
            const intakeNum = year - 2011;
            intakes.push({
                label: `Intake ${intakeNum}`,
                value: `Intake - ${intakeNum}`
            });
        }
        
        intakes.forEach(intake => {
            const label = document.createElement('label');
            label.className = 'flex items-center p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition-colors duration-200';
            label.innerHTML = `
                <input type="checkbox" name="involvement[]" value="${intake.value}" 
                    class="mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <span class="text-sm font-medium text-gray-700">${intake.label}</span>
            `;
            container.appendChild(label);
        });
    }

    function initializeCalendar() {
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: @json($calendarEvents),
            eventClick: function(info) {
                editTraining(info.event.id);
            },
            height: 'auto',
            eventDisplay: 'block'
        });
        calendar.render();
    }

    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Create Training Session';
        document.getElementById('submitText').textContent = 'Create Training';
        document.getElementById('trainingForm').reset();
        document.getElementById('trainingId').value = '';
        
        // Reset all checkboxes
        const involvementCheckboxes = document.querySelectorAll('input[name="involvement[]"]');
        involvementCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
            checkbox.closest('label').classList.remove('bg-blue-50', 'border-blue-300');
        });
        
        // Reset dropdowns
        document.getElementById('start_time').selectedIndex = 0;
        document.getElementById('end_time').selectedIndex = 0;
        
        currentTrainingId = null;
        document.getElementById('trainingModal').classList.remove('hidden');
    }

    function editTraining(trainingId) {
        currentTrainingId = trainingId;
        document.getElementById('modalTitle').textContent = 'Edit Training Session';
        document.getElementById('submitText').textContent = 'Update Training';
        
        // Fetch training data
        fetch(`/instructor/training/${trainingId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('trainingId').value = data.id;
                document.getElementById('title').value = data.title;
                document.getElementById('description').value = data.description || '';
                document.getElementById('location').value = data.location;
                
                // Handle involvement checkboxes
                const involvementCheckboxes = document.querySelectorAll('input[name="involvement[]"]');
                involvementCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    checkbox.closest('label').classList.remove('bg-blue-50', 'border-blue-300');
                });
                
                if (data.involvement) {
                    const selectedIntakes = data.involvement.split(', ');
                    involvementCheckboxes.forEach(checkbox => {
                        if (selectedIntakes.includes(checkbox.value)) {
                            checkbox.checked = true;
                            checkbox.closest('label').classList.add('bg-blue-50', 'border-blue-300');
                        }
                    });
                }
                
                // Set date and hour dropdowns using raw values from database
                if (data.start_datetime) {
                    document.getElementById('start_date').value = data.start_datetime.substring(0,10);
                    const startHour = data.start_datetime.substring(11,13) + '00H';
                    const startTimeSelect = document.getElementById('start_time');
                    for (let i = 0; i < startTimeSelect.options.length; i++) {
                        if (startTimeSelect.options[i].value === startHour) {
                            startTimeSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
                if (data.end_datetime) {
                    document.getElementById('end_date').value = data.end_datetime.substring(0,10);
                    const endHour = data.end_datetime.substring(11,13) + '00H';
                    const endTimeSelect = document.getElementById('end_time');
                    for (let i = 0; i < endTimeSelect.options.length; i++) {
                        if (endTimeSelect.options[i].value === endHour) {
                            endTimeSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
                document.getElementById('status').value = data.status;
                document.getElementById('trainingModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching training data:', error);
                alert('Error loading training data');
            });
    }

    function endTraining(trainingId) {
        if (confirm('Are you sure you want to end this training session?')) {
            fetch(`/instructor/training/${trainingId}/end`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error ending training session');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error ending training session');
            });
        }
    }

    function deleteTraining(trainingId) {
        currentTrainingId = trainingId;
        document.getElementById('deleteModal').classList.remove('hidden');
        
        document.getElementById('confirmDelete').onclick = function() {
            fetch(`/instructor/training/${trainingId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting training session');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting training session');
            });
        };
    }

    function openAttendanceModal(trainingId) {
        currentTrainingId = trainingId;
        document.getElementById('attendanceModal').classList.remove('hidden');
        
        // Show loading state
        document.getElementById('attendanceLoading').classList.remove('hidden');
        document.getElementById('attendanceContent').classList.add('hidden');
        document.getElementById('attendanceError').classList.add('hidden');
        
        // Fetch cadets data
        loadCadetsForAttendance(trainingId);
    }

    function loadCadetsForAttendance(trainingId) {
        fetch(`/instructor/training/${trainingId}/cadets`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cadetsData = data.cadets_by_intake;
                    
                    // Set training title
                    document.getElementById('trainingTitle').textContent = data.training.title;
                    
                    // Setup intake filters (this will set the default intake)
                    setupIntakeFilters();
                    
                    // Display cadets
                    displayCadets();
                    
                    // Show content
                    document.getElementById('attendanceLoading').classList.add('hidden');
                    document.getElementById('attendanceContent').classList.remove('hidden');
                    
                } else {
                    showError(data.message || 'Failed to load cadets');
                }
            })
            .catch(error => {
                console.error('Error loading cadets:', error);
                showError('Failed to load cadets');
            });
    }

    function showError(message) {
        document.getElementById('attendanceLoading').classList.add('hidden');
        document.getElementById('attendanceContent').classList.add('hidden');
        document.getElementById('attendanceError').classList.remove('hidden');
        document.getElementById('errorMessage').textContent = message;
    }

    function setupIntakeFilters() {
        const filtersContainer = document.getElementById('intakeFilters');
        const filterSection = document.getElementById('intakeFilterSection');
        filtersContainer.innerHTML = '';
        
        // Only show intake filters if there are multiple intakes
        if (cadetsData.length <= 1) {
            filterSection.style.display = 'none';
            currentIntakeFilter = 'all';
            return;
        }
        
        filterSection.style.display = 'block';
        
        // Sort intakes by intake_year (ascending) to get the lowest year first
        const sortedIntakes = [...cadetsData].sort((a, b) => {
            // Extract year from intake label (e.g., "Intake - 12" -> 12, then convert to year)
            const getYear = (intake) => {
                const match = intake.intake.label.match(/Intake - (\d+)/);
                if (match) {
                    // Convert intake number to year (assuming Intake 1 = 2012)
                    return 2011 + parseInt(match[1]);
                }
                return 0;
            };
            return getYear(a) - getYear(b);
        });
        
        // Set default to lowest intake year (first in sorted array)
        const defaultIntakeIndex = cadetsData.findIndex(intake => 
            intake.intake.label === sortedIntakes[0].intake.label
        );
        currentIntakeFilter = defaultIntakeIndex;
        
        // Add individual intake filters (sorted by year)
        sortedIntakes.forEach((intakeGroup) => {
            const originalIndex = cadetsData.findIndex(group => 
                group.intake.label === intakeGroup.intake.label
            );
            
            const button = document.createElement('button');
            const isDefault = originalIndex === defaultIntakeIndex;
            button.className = isDefault 
                ? 'px-4 py-2 text-sm rounded-md bg-blue-600 text-white transition-colors duration-200 border border-blue-600'
                : 'px-4 py-2 text-sm rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors duration-200 border border-gray-300';
            
            button.textContent = `${intakeGroup.intake.label} (${intakeGroup.cadets.length})`;
            button.onclick = () => filterByIntake(originalIndex, button);
            filtersContainer.appendChild(button);
        });
    }

    function filterByIntake(filter, buttonElement) {
        currentIntakeFilter = filter;
        
        // Update button states
        document.querySelectorAll('#intakeFilters button').forEach(btn => {
            btn.className = 'px-4 py-2 text-sm rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors duration-200 border border-gray-300';
        });
        buttonElement.className = 'px-4 py-2 text-sm rounded-md bg-blue-600 text-white transition-colors duration-200 border border-blue-600';
        
        displayCadets();
    }

    function displayCadets() {
        const cadetsContainer = document.getElementById('cadetsList');
        cadetsContainer.innerHTML = '';
        
        let displayData = [];
        if (currentIntakeFilter === 'all') {
            displayData = cadetsData;
        } else {
            displayData = [cadetsData[currentIntakeFilter]];
        }

        displayData.forEach(intakeGroup => {
            if (!intakeGroup || !intakeGroup.cadets) return;

            // Intake header
            const intakeHeader = document.createElement('div');
            intakeHeader.className = 'mb-4';
            intakeHeader.innerHTML = `
                <h5 class="text-lg font-semibold text-gray-800 border-b-2 border-gray-200 pb-2 mb-4">
                    ${intakeGroup.intake.label}
                    <span class="text-sm font-normal text-gray-600 ml-2">(${intakeGroup.cadets.length} cadets)</span>
                </h5>
            `;
            cadetsContainer.appendChild(intakeHeader);

            // Cadets grid - simplified cards
            const cadetsGrid = document.createElement('div');
            cadetsGrid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mb-6';

            // Filter cadets by attendance status
            let filteredCadets = intakeGroup.cadets;
            if (currentAttendanceFilter === 'present') {
                filteredCadets = intakeGroup.cadets.filter(c => c.present);
            } else if (currentAttendanceFilter === 'absent') {
                filteredCadets = intakeGroup.cadets.filter(c => !c.present);
            }

            filteredCadets.forEach(cadet => {
                const cadetCard = document.createElement('div');
                const cardClass = cadet.present ? 
                    'p-4 border-2 border-green-300 bg-green-50 rounded-lg' : 
                    'p-4 border border-gray-300 bg-white rounded-lg hover:bg-gray-50';
                cadetCard.className = cardClass;
                cadetCard.setAttribute('data-cadet-id', cadet.id);

                // Simplified cadet info
                let rankName = cadet.rank ? cadet.rank + ' ' : '';
                let displayName = cadet.name;
                if (cadet.rank && displayName.startsWith(cadet.rank + ' ')) {
                    displayName = displayName.substring(cadet.rank.length + 1);
                }
                rankName += displayName;

                cadetCard.innerHTML = `
                    <div class="flex justify-between items-center">
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">${rankName}</div>
                            <div class="text-sm text-gray-600">
                                ${cadet.service_number ? `Service: ${cadet.service_number}` : ''}
                            </div>
                            ${cadet.present ? 
                                '<div class="text-xs text-green-700 font-medium mt-1"><i class="fas fa-check-circle mr-1"></i>Present</div>' : 
                                '<div class="text-xs text-red-700 font-medium mt-1"><i class="fas fa-times-circle mr-1"></i>Absent</div>'
                            }
                        </div>
                        <div class="ml-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer attendance-toggle" 
                                    data-cadet-id="${cadet.id}" ${cadet.present ? 'checked' : ''} 
                                    onchange="toggleCadetAttendance(this)">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </div>
                    </div>
                `;
                cadetsGrid.appendChild(cadetCard);
            });

            cadetsContainer.appendChild(cadetsGrid);
        });

        updateAttendanceCount();
    }

    // Attendance filter toggle logic
    function setAttendanceFilter(filter) {
        currentAttendanceFilter = filter;
        // Update button states
        document.getElementById('filterAll').className = 'px-3 py-1 text-sm rounded-md bg-gray-200 text-gray-700 border';
        document.getElementById('filterPresent').className = 'px-3 py-1 text-sm rounded-md bg-gray-200 text-gray-700 border';
        document.getElementById('filterAbsent').className = 'px-3 py-1 text-sm rounded-md bg-gray-200 text-gray-700 border';
        
        if (filter === 'all') {
            document.getElementById('filterAll').className = 'px-3 py-1 text-sm rounded-md bg-blue-600 text-white border';
        } else if (filter === 'present') {
            document.getElementById('filterPresent').className = 'px-3 py-1 text-sm rounded-md bg-blue-600 text-white border';
        } else if (filter === 'absent') {
            document.getElementById('filterAbsent').className = 'px-3 py-1 text-sm rounded-md bg-blue-600 text-white border';
        }
        displayCadets();
    }

    // Updated function to handle individual cadet attendance toggle
    function toggleCadetAttendance(checkbox) {
        const cadetId = checkbox.dataset.cadetId;
        const isPresent = checkbox.checked;
        
        // Update the cadet's attendance in the data
        cadetsData.forEach(intakeGroup => {
            const cadet = intakeGroup.cadets.find(c => c.id == cadetId);
            if (cadet) {
                cadet.present = isPresent;
                if (isPresent) {
                    cadet.attendance_method = 'manual';
                    cadet.marked_at = new Date().toISOString();
                } else {
                    cadet.attendance_method = null;
                    cadet.marked_at = null;
                }
            }
        });
        
        // Update visual state of the card
        const card = checkbox.closest('.p-4');
        if (isPresent) {
            card.className = 'p-4 border-2 border-green-300 bg-green-50 rounded-lg';
        } else {
            card.className = 'p-4 border border-gray-300 bg-white rounded-lg hover:bg-gray-50';
        }
        
        // Update attendance counts
        updateAttendanceCount();
        
        // Refresh display to show updated status indicators
        setTimeout(() => {
            displayCadets();
        }, 100);
        
        // Auto-save individual attendance change
        autoSaveAttendance(cadetId, isPresent);
    }

    // Function to auto-save individual attendance changes
    function autoSaveAttendance(cadetId, isPresent) {
        const attendanceData = [{
            cadet_id: cadetId,
            present: isPresent
        }];
        
        fetch(`/instructor/training/${currentTrainingId}/attendance`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                attendance: attendanceData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Error auto-saving attendance:', data.message);
                showNotification('Error saving attendance: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error auto-saving attendance:', error);
        });
    }

    // Enhanced updateAttendanceCount function
    function updateAttendanceCount() {
        const allToggles = document.querySelectorAll('.attendance-toggle');
        const checkedToggles = document.querySelectorAll('.attendance-toggle:checked');
        
        const total = allToggles.length;
        const present = checkedToggles.length;
        const absent = total - present;
        
        document.getElementById('totalCadets').textContent = total;
        document.getElementById('presentCount').textContent = present;
        document.getElementById('absentCount').textContent = absent;
    }

    // Updated function to mark all cadets as present
    function markAllPresent() {
        // Update data for currently visible cadets
        let displayData = [];
        if (currentIntakeFilter === 'all') {
            displayData = cadetsData;
        } else {
            displayData = [cadetsData[currentIntakeFilter]];
        }
        
        const cadetIds = [];
        displayData.forEach(intakeGroup => {
            intakeGroup.cadets.forEach(cadet => {
                if (!cadet.present) {
                    cadet.present = true;
                    cadet.attendance_method = 'manual';
                    cadet.marked_at = new Date().toISOString();
                    cadetIds.push(cadet.id);
                }
            });
        });
        
        // Refresh display
        displayCadets();
        
        // Save all changes
        if (cadetIds.length > 0) {
            saveBulkAttendance(cadetIds, true);
        }
    }

    // Updated function to mark all cadets as absent
    function markAllAbsent() {
        // Update data for currently visible cadets
        let displayData = [];
        if (currentIntakeFilter === 'all') {
            displayData = cadetsData;
        } else {
            displayData = [cadetsData[currentIntakeFilter]];
        }
        
        const cadetIds = [];
        displayData.forEach(intakeGroup => {
            intakeGroup.cadets.forEach(cadet => {
                if (cadet.present) {
                    cadet.present = false;
                    cadet.attendance_method = null;
                    cadet.marked_at = null;
                    cadetIds.push(cadet.id);
                }
            });
        });
        
        // Refresh display
        displayCadets();
        
        // Save all changes
        if (cadetIds.length > 0) {
            saveBulkAttendance(cadetIds, false);
        }
    }

    // Function to save bulk attendance changes
    function saveBulkAttendance(cadetIds, isPresent) {
        const attendanceData = cadetIds.map(cadetId => ({
            cadet_id: cadetId,
            present: isPresent
        }));
        
        fetch(`/instructor/training/${currentTrainingId}/attendance`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                attendance: attendanceData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Successfully marked ${cadetIds.length} cadets as ${isPresent ? 'present' : 'absent'}!`, 'success');
            } else {
                showNotification('Error saving bulk attendance: ' + (data.message || 'Unknown error'), 'error');
            }
        })
        .catch(error => {
            console.error('Error saving bulk attendance:', error);
            showNotification('Error saving bulk attendance. Please try again.', 'error');
        });
    }

    // Enhanced saveAttendance function with better feedback
    function saveAttendance() {
        const attendanceData = [];
        document.querySelectorAll('.attendance-toggle').forEach(toggle => {
            attendanceData.push({
                cadet_id: toggle.dataset.cadetId,
                present: toggle.checked
            });
        });
        
        // Show saving indicator
        const saveButton = document.querySelector('button[onclick="saveAttendance()"]');
        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        saveButton.disabled = true;
        
        fetch(`/instructor/training/${currentTrainingId}/attendance`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                attendance: attendanceData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification('All attendance saved successfully!', 'success');
                
                // Update button
                saveButton.innerHTML = '<i class="fas fa-check mr-2"></i>Saved!';
                saveButton.className = saveButton.className.replace('bg-blue-600 hover:bg-blue-700', 'bg-green-500');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                    saveButton.className = saveButton.className.replace('bg-green-500', 'bg-blue-600 hover:bg-blue-700');
                }, 2000);
                
            } else {
                showNotification('Error saving attendance: ' + (data.message || 'Unknown error'), 'error');
                saveButton.innerHTML = originalText;
                saveButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error saving attendance:', error);
            showNotification('Error saving attendance. Please try again.', 'error');
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        });
    }

    // Enhanced closeAttendanceModal with confirmation if unsaved changes
    function closeAttendanceModal() {
        document.getElementById('attendanceModal').classList.add('hidden');
        
        // Reset data and filters
        cadetsData = [];
        currentIntakeFilter = 'all';
        currentTrainingId = null;
    }

    // New notification system
    function showNotification(message, type = 'info') {
    // Remove any existing notifications first
    const existingNotifications = document.querySelectorAll('.toast-notification');
    existingNotifications.forEach(notification => notification.remove());
    
    // Create notification element
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    
    // Key change: Use absolute positioning and start hidden off-screen
    notification.className = `toast-notification absolute ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        transform: translateX(100%);
        opacity: 0;
        pointer-events: none;
    `;
    
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
        notification.style.opacity = '1';
        notification.style.pointerEvents = 'auto';
    }, 100);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }
    }, 3000);
}

    // Enhanced keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // ESC to close attendance modal
        if (e.key === 'Escape' && !document.getElementById('attendanceModal').classList.contains('hidden')) {
            closeAttendanceModal();
        }
        
        // Ctrl+S to save attendance
        if (e.ctrlKey && e.key === 's' && !document.getElementById('attendanceModal').classList.contains('hidden')) {
            e.preventDefault();
            saveAttendance();
        }
    });

    function handleFormSubmit(e) {
        e.preventDefault();
        
        const formData = new FormData(e.target);
        
        // Handle involvement checkboxes
        const involvementCheckboxes = document.querySelectorAll('input[name="involvement[]"]:checked');
        const selectedIntakes = Array.from(involvementCheckboxes).map(cb => cb.value);
        
        // Convert FormData to regular object
        const data = {};
        for (let [key, value] of formData.entries()) {
            if (key !== 'involvement[]') {
                data[key] = value;
            }
        }
        // Add involvement as comma-separated string
        data.involvement = selectedIntakes.join(', ');
        // Combine date and hour dropdowns into proper datetime string
        function combineDateHour(date, hour) {
            if (!date || !hour) return null;
            // hour is in format 'HH00H', e.g. '0900H'
            const hourNum = hour.substring(0,2);
            return date + 'T' + hourNum + ':00:00';
        }
        data.start_datetime = combineDateHour(data.start_date, data.start_time);
        data.end_datetime = data.end_date && data.end_time ? combineDateHour(data.end_date, data.end_time) : null;
        // Remove raw date/time fields
        delete data.start_date;
        delete data.start_time;
        delete data.end_date;
        delete data.end_time;
        // Set endpoint and method
        const url = currentTrainingId ? `/instructor/training/${currentTrainingId}` : '/instructor/training';
        const method = currentTrainingId ? 'PUT' : 'POST';
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error saving training session');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving training session');
        });
    }

    function closeModal() {
        document.getElementById('trainingModal').classList.add('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function formatDateTimeForInput(datetime) {
        return new Date(datetime).toISOString().slice(0, 16);
    }

    // Close modals when clicking outside
    document.getElementById('trainingModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    document.getElementById('attendanceModal').addEventListener('click', function(e) {
        if (e.target === this) closeAttendanceModal();
    });
</script>

<script>
    // Enhanced Attendance List Modal Logic with individual training filters
let attendanceListData = [];
let attendanceListMonths = [];
let currentAttendanceListYear = '';
let currentAttendanceListMonth = '';
let currentAttendanceListIntake = '';
let openAccordionId = null;
let allAvailableIntakes = [];
let trainingFilters = {}; // Store individual training filters

function openAttendanceListModal() {
    document.getElementById('attendanceListModal').classList.remove('hidden');
    resetAttendanceListModal();
    fetchAttendanceListYears();
}

function closeAttendanceListModal() {
    document.getElementById('attendanceListModal').classList.add('hidden');
    resetAttendanceListModal();
}

function resetAttendanceListModal() {
    attendanceListData = [];
    attendanceListMonths = [];
    allAvailableIntakes = [];
    trainingFilters = {}; // Reset training-specific filters
    // Set default year, month, and intake
    const now = new Date();
    currentAttendanceListYear = now.getFullYear();
    currentAttendanceListMonth = now.getMonth() + 1; // JS months are 0-based
    currentAttendanceListIntake = '';
    openAccordionId = null;
    // Reset UI states
    document.getElementById('attendanceListLoading').classList.remove('hidden');
    document.getElementById('attendanceListContent').classList.add('hidden');
    document.getElementById('attendanceListError').classList.add('hidden');
    document.getElementById('attendanceListYearFilter').innerHTML = '';
    document.getElementById('attendanceListMonthFilter').innerHTML = '';
    document.getElementById('attendanceListIntakeSection').classList.add('hidden');
    document.getElementById('attendanceListTrainings').innerHTML = '';
}

function fetchAttendanceListYears() {
    fetch('/instructor/getYears')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.years) {
                const yearSelect = document.getElementById('attendanceListYearFilter');
                yearSelect.innerHTML = '';
                data.years.forEach(year => {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    yearSelect.appendChild(option);
                });
                // Set current year as default
                const currentYear = new Date().getFullYear();
                if (data.years.includes(currentYear)) {
                    yearSelect.value = currentYear;
                    currentAttendanceListYear = currentYear;
                    fetchAttendanceListMonths();
                } else if (data.years.length > 0) {
                    yearSelect.value = data.years[0];
                    currentAttendanceListYear = data.years[0];
                    fetchAttendanceListMonths();
                }
            }
            
            document.getElementById('attendanceListLoading').classList.add('hidden');
            document.getElementById('attendanceListContent').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching years:', error);
            showAttendanceListError('Failed to load years');
        });

    // Set up event listeners
    document.getElementById('attendanceListYearFilter').onchange = function() {
        currentAttendanceListYear = this.value;
        currentAttendanceListMonth = '';
        currentAttendanceListIntake = '';
        trainingFilters = {}; // Reset all training filters
        document.getElementById('attendanceListMonthFilter').innerHTML = '';
        document.getElementById('attendanceListTrainings').innerHTML = '';
        document.getElementById('attendanceListIntakeSection').classList.add('hidden');
        
        if (currentAttendanceListYear) {
            fetchAttendanceListMonths();
        }
    };
}

function fetchAttendanceListMonths() {
    if (!currentAttendanceListYear) return;
    
    fetch(`/instructor/getMonths?year=${currentAttendanceListYear}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.months) {
                const monthSelect = document.getElementById('attendanceListMonthFilter');
                monthSelect.innerHTML = '';
                const sortedMonths = data.months.sort((a, b) => b - a);
                sortedMonths.forEach(monthNum => {
                    const date = new Date(currentAttendanceListYear, monthNum - 1);
                    const monthDisplay = date.toLocaleString('en-US', { month: 'long' });
                    const option = document.createElement('option');
                    option.value = monthNum;
                    option.textContent = monthDisplay;
                    monthSelect.appendChild(option);
                });
                const now = new Date();
                const currentMonth = now.getMonth() + 1;
                if (sortedMonths.includes(currentMonth)) {
                    monthSelect.value = currentMonth;
                    currentAttendanceListMonth = currentMonth;
                } else if (sortedMonths.length > 0) {
                    monthSelect.value = sortedMonths[0];
                    currentAttendanceListMonth = sortedMonths[0];
                }
                
                // CRITICAL FIX: Reset intake filter and data when month changes
                allAvailableIntakes = [];
                currentAttendanceListIntake = '';
                
                fetchAttendanceListData();
            }
        })
        .catch(error => {
            console.error('Error fetching months:', error);
        });

    document.getElementById('attendanceListMonthFilter').onchange = function() {
        currentAttendanceListMonth = this.value;
        
        // CRITICAL FIX: Reset intake filter when month changes
        currentAttendanceListIntake = '';
        allAvailableIntakes = [];
        trainingFilters = {};
        
        document.getElementById('attendanceListTrainings').innerHTML = '';
        
        if (currentAttendanceListMonth) {
            fetchAttendanceListData();
        }
    };
}

function fetchAttendanceListData() {
    if (!currentAttendanceListYear || !currentAttendanceListMonth) return;
    
    let query = `?year=${currentAttendanceListYear}&month=${currentAttendanceListMonth}`;
    if (currentAttendanceListIntake) {
        query += `&intake=${encodeURIComponent(currentAttendanceListIntake)}`;
    }

    fetch(`/instructor/getCadetAttendanceList${query}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                attendanceListData = data.trainings || [];
                
                // ALWAYS setup intake filter when data changes
                setupIntakeFilter();
                
                renderTrainingAccordions();
            } else {
                showAttendanceListError(data.message || 'Failed to load attendance data');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            showAttendanceListError('Network error occurred. Please try again.');
        });
}

function setupIntakeFilter() {
    // Collect all available intakes from the CURRENT month's data
    const intakeSet = new Set();
    
    attendanceListData.forEach(training => {
        if (training.available_intakes && training.available_intakes.length > 0) {
            training.available_intakes.forEach(intake => {
                intakeSet.add(intake);
            });
        }
    });
    
    const newIntakes = Array.from(intakeSet).sort((a, b) => {
        const aNum = parseInt(a.match(/Intake - (\d+)/)?.[1] || '0');
        const bNum = parseInt(b.match(/Intake - (\d+)/)?.[1] || '0');
        return aNum - bNum;
    });
    
    const intakeSection = document.getElementById('attendanceListIntakeSection');
    const intakeSelect = document.getElementById('attendanceListIntakeFilter');
    
    // Store the current selection before rebuilding
    const previousSelection = currentAttendanceListIntake;
    
    // Update available intakes
    allAvailableIntakes = newIntakes;
    
    if (newIntakes.length > 0) {
        intakeSection.classList.remove('hidden');
        
        // Rebuild dropdown options
        intakeSelect.innerHTML = '';
        
        // Add "All Intakes" option
        const allOption = document.createElement('option');
        allOption.value = '';
        allOption.textContent = 'All Intakes';
        intakeSelect.appendChild(allOption);
        
        // Add individual intake options
        newIntakes.forEach(intake => {
            const option = document.createElement('option');
            option.value = intake;
            option.textContent = intake;
            intakeSelect.appendChild(option);
        });
        
        // CRITICAL FIX: Check if previous selection still exists in new data
        if (previousSelection && newIntakes.includes(previousSelection)) {
            // Keep the previous selection if it exists in new month
            intakeSelect.value = previousSelection;
            currentAttendanceListIntake = previousSelection;
        } else {
            // Reset to "All Intakes" if previous selection doesn't exist
            intakeSelect.value = '';
            currentAttendanceListIntake = '';
        }
        
        // Set up event listener only once
        if (!intakeSelect.onchange) {
            intakeSelect.onchange = function() {
                const previousIntake = currentAttendanceListIntake;
                currentAttendanceListIntake = this.value;
                
                if (previousIntake !== currentAttendanceListIntake) {
                    trainingFilters = {};
                    fetchAttendanceListData();
                }
            };
        }
    } else {
        intakeSection.classList.add('hidden');
        currentAttendanceListIntake = '';
        allAvailableIntakes = [];
    }
}

function renderTrainingAccordions() {
    const container = document.getElementById('attendanceListTrainings');
    const emptyState = document.getElementById('attendanceListEmpty');
    
    container.innerHTML = '';
    
    if (!attendanceListData || attendanceListData.length === 0) {
        emptyState.classList.remove('hidden');
        return;
    }
    
    emptyState.classList.add('hidden');
    
    // Sort trainings by date (most recent first)
    const sortedTrainings = [...attendanceListData].sort((a, b) => 
        new Date(b.start_datetime) - new Date(a.start_datetime)
    );

    sortedTrainings.forEach((training, index) => {
        // Initialize filter for this training if not exists
        if (!trainingFilters[training.id]) {
            trainingFilters[training.id] = 'all';
        }
        
        const accordion = createTrainingAccordion(training, index);
        container.appendChild(accordion);
    });
}

function createTrainingAccordion(training, index) {
    const accordionDiv = document.createElement('div');
    accordionDiv.className = 'border border-gray-200 rounded-lg overflow-hidden';
    
    const cadets = training.cadets || [];
    const totalCadets = cadets.length;
    const presentCount = cadets.filter(c => c.present).length;
    const attendancePercentage = totalCadets > 0 ? Math.round((presentCount / totalCadets) * 100) : 0;
    
    // Header styling based on attendance percentage
    let headerClass = 'bg-gray-50 hover:bg-gray-100';
    if (attendancePercentage >= 90) {
        headerClass = 'bg-green-50 hover:bg-green-100';
    } else if (attendancePercentage >= 70) {
        headerClass = 'bg-yellow-50 hover:bg-yellow-100';
    } else if (totalCadets > 0) {
        headerClass = 'bg-red-50 hover:bg-red-100';
    }
    
    accordionDiv.innerHTML = `
        <div class="accordion-header ${headerClass} cursor-pointer" onclick="toggleAccordion('accordion-${index}')">
            <div class="px-6 py-4 flex justify-between items-center">
                <div class="flex-1">
                    <h4 class="text-lg font-semibold text-gray-900">${training.title}</h4>
                    <div class="text-sm text-gray-600 mt-1">
                        ${training.start_datetime} • ${training.location || 'N/A'}
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-900">${attendancePercentage}%</div>
                        <div class="text-sm text-gray-600">${presentCount}/${totalCadets} present</div>
                    </div>
                    <div class="transform transition-transform duration-200" id="accordion-icon-${index}">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="accordion-content hidden" id="accordion-content-${index}">
            <div class="border-t border-gray-200">
                ${createTrainingContent(cadets, training.id)}
            </div>
        </div>
    `;
    
    return accordionDiv;
}

function createTrainingContent(cadets, trainingId) {
    if (!cadets || cadets.length === 0) {
        return `
            <div class="px-6 py-8 text-center text-gray-500">
                <i class="fas fa-user-slash text-3xl mb-2"></i>
                <p>No cadets found for this training session.</p>
            </div>
        `;
    }

    const currentFilter = trainingFilters[trainingId] || 'all';
    
    // Filter buttons for this specific training
    const filterButtons = `
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h5 class="text-sm font-medium text-gray-700">Filter Cadets:</h5>
                <div class="flex gap-1">
                    <button id="filter-all-${trainingId}" 
                        class="px-3 py-1 text-xs rounded ${currentFilter === 'all' ? 'bg-blue-600 text-white font-medium' : 'bg-gray-200 text-gray-700'}" 
                        onclick="setTrainingFilter(${trainingId}, 'all')">
                        All (${cadets.length})
                    </button>
                    <button id="filter-present-${trainingId}" 
                        class="px-3 py-1 text-xs rounded ${currentFilter === 'present' ? 'bg-blue-600 text-white font-medium' : 'bg-gray-200 text-gray-700'}" 
                        onclick="setTrainingFilter(${trainingId}, 'present')">
                        Present (${cadets.filter(c => c.present).length})
                    </button>
                    <button id="filter-absent-${trainingId}" 
                        class="px-3 py-1 text-xs rounded ${currentFilter === 'absent' ? 'bg-blue-600 text-white font-medium' : 'bg-gray-200 text-gray-700'}" 
                        onclick="setTrainingFilter(${trainingId}, 'absent')">
                        Absent (${cadets.filter(c => !c.present).length})
                    </button>
                </div>
            </div>
        </div>
    `;

    return filterButtons + createCadetTable(cadets, trainingId, currentFilter);
}

function setTrainingFilter(trainingId, filter) {
    trainingFilters[trainingId] = filter;
    
    // Update button states for this specific training
    const buttons = ['all', 'present', 'absent'];
    buttons.forEach(btnType => {
        const btn = document.getElementById(`filter-${btnType}-${trainingId}`);
        if (btn) {
            if (btnType === filter) {
                btn.className = 'px-3 py-1 text-xs rounded bg-blue-600 text-white font-medium';
            } else {
                btn.className = 'px-3 py-1 text-xs rounded bg-gray-200 text-gray-700';
            }
        }
    });
    
    // Find and update the table content for this training
    const accordionContent = document.querySelector(`[id^="accordion-content-"] [onclick*="${trainingId}"]`).closest('.accordion-content');
    if (accordionContent) {
        // Find the training data
        const training = attendanceListData.find(t => t.id === trainingId);
        if (training) {
            const filterButtons = accordionContent.querySelector('.bg-gray-50');
            const newContent = createTrainingContent(training.cadets, trainingId);
            accordionContent.innerHTML = `<div class="border-t border-gray-200">${newContent}</div>`;
        }
    }
}

function createCadetTable(cadets, trainingId, filter = 'all') {
    // Apply filter
    let filteredCadets = cadets;
    if (filter === 'present') {
        filteredCadets = cadets.filter(c => c.present);
    } else if (filter === 'absent') {
        filteredCadets = cadets.filter(c => !c.present);
    }
    
    if (filteredCadets.length === 0) {
        return `
            <div class="px-6 py-8 text-center text-gray-500">
                <i class="fas fa-filter text-3xl mb-2"></i>
                <p>No cadets match the current filter.</p>
            </div>
        `;
    }
    
    // Check if we're showing all intakes (no specific intake filter applied)
    const showingAllIntakes = !currentAttendanceListIntake || currentAttendanceListIntake === '';
    
    if (showingAllIntakes) {
        // Group cadets by intake when showing all intakes
        const cadetsByIntake = {};
        
        filteredCadets.forEach(cadet => {
            const intakeLabel = cadet.intake_label || 'Unknown Intake';
            
            if (!cadetsByIntake[intakeLabel]) {
                cadetsByIntake[intakeLabel] = [];
            }
            cadetsByIntake[intakeLabel].push(cadet);
        });
        
        // Sort intake groups by intake number
        const sortedIntakes = Object.keys(cadetsByIntake).sort((a, b) => {
            const aNum = parseInt(a.match(/Intake - (\d+)/)?.[1] || '0');
            const bNum = parseInt(b.match(/Intake - (\d+)/)?.[1] || '0');
            return aNum - bNum;
        });
        
        // Create grouped table HTML
        let groupedTableHTML = '<div class="space-y-6">';
        
        sortedIntakes.forEach(intakeLabel => {
            const intakeCadets = cadetsByIntake[intakeLabel];
            
            // Sort cadets within each intake by service number
            const sortedIntakeCadets = [...intakeCadets].sort((a, b) => {
                const numA = parseInt(a.service_number, 10) || 0;
                const numB = parseInt(b.service_number, 10) || 0;
                return numA - numB;
            });
            
            const presentCount = intakeCadets.filter(c => c.present).length;
            const totalCount = intakeCadets.length;
            const attendancePercentage = totalCount > 0 ? Math.round((presentCount / totalCount) * 100) : 0;
            
            groupedTableHTML += `
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-3 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <h6 class="text-lg font-semibold text-gray-800 flex items-center">
                                <i class="fas fa-users mr-2 text-blue-600"></i>
                                ${intakeLabel}
                            </h6>
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-gray-600">${presentCount}/${totalCount} present</span>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold ${attendancePercentage >= 90 ? 'bg-green-100 text-green-800' : attendancePercentage >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'}">${attendancePercentage}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matric No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
            `;
            
            sortedIntakeCadets.forEach(cadet => {
                const statusBadge = cadet.present 
                    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Present</span>'
                    : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Absent</span>';
                
                let detailsCell = '';
                if (cadet.present) {
                    const method = cadet.method === 'qr_code' ? 'QR Code' : 'Manual';
                    const timeStr = cadet.marked_at ? `at ${cadet.marked_at}` : '';
                    detailsCell = `<span class="text-xs text-green-700">Marked via ${method} ${timeStr}</span>`;
                } else {
                    let absenceDetails = [];
                    if (cadet.absence_reason) {
                        absenceDetails.push(`<div class="text-xs text-gray-700 mb-1"><i class="fas fa-info-circle mr-1 text-blue-500"></i><strong>Reason:</strong> ${cadet.absence_reason}</div>`);
                    }
                    if (cadet.file_url) {
                        absenceDetails.push(`<div class="text-xs text-blue-700"><i class="fas fa-file mr-1"></i><a href="${cadet.file_url}" target="_blank" class="underline hover:text-blue-900">View Supporting File</a></div>`);
                    }
                    detailsCell = absenceDetails.join('') || '<span class="text-xs text-gray-400">No additional details</span>';
                }
                
                groupedTableHTML += `
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${cadet.service_number || '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${cadet.rank || '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${cadet.name}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${cadet.matric_no || '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${statusBadge}</td>
                        <td class="px-6 py-4 text-sm">${detailsCell}</td>
                    </tr>
                `;
            });
            
            groupedTableHTML += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        });
        
        groupedTableHTML += '</div>';
        return groupedTableHTML;
        
    } else {
        // Single intake view - use original table format
        const sortedCadets = [...filteredCadets].sort((a, b) => {
            const numA = parseInt(a.service_number, 10) || 0;
            const numB = parseInt(b.service_number, 10) || 0;
            return numA - numB;
        });
        
        let tableHTML = `
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matric No.</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
        `;
        
        sortedCadets.forEach(cadet => {
            const statusBadge = cadet.present 
                ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Present</span>'
                : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Absent</span>';
            
            let detailsCell = '';
            if (cadet.present) {
                const method = cadet.method === 'qr_code' ? 'QR Code' : 'Manual';
                const timeStr = cadet.marked_at ? `at ${cadet.marked_at}` : '';
                detailsCell = `<span class="text-xs text-green-700">Marked via ${method} ${timeStr}</span>`;
            } else {
                let absenceDetails = [];
                if (cadet.absence_reason) {
                    absenceDetails.push(`<div class="text-xs text-gray-700 mb-1"><i class="fas fa-info-circle mr-1 text-blue-500"></i><strong>Reason:</strong> ${cadet.absence_reason}</div>`);
                }
                if (cadet.file_url) {
                    absenceDetails.push(`<div class="text-xs text-blue-700"><i class="fas fa-file mr-1"></i><a href="${cadet.file_url}" target="_blank" class="underline hover:text-blue-900">View Supporting File</a></div>`);
                }
                detailsCell = absenceDetails.join('') || '<span class="text-xs text-gray-400">No additional details</span>';
            }
            
            tableHTML += `
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${cadet.service_number || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${cadet.rank || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${cadet.name}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${cadet.matric_no || '-'}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${statusBadge}</td>
                    <td class="px-6 py-4 text-sm">${detailsCell}</td>
                </tr>
            `;
        });
        
        tableHTML += `
                    </tbody>
                </table>
            </div>
        `;
        
        return tableHTML;
    }
}

function toggleAccordion(accordionId) {
    const contentId = accordionId.replace('accordion-', 'accordion-content-');
    const iconId = accordionId.replace('accordion-', 'accordion-icon-');
    
    const content = document.getElementById(contentId);
    const icon = document.getElementById(iconId);
    
    // Close previously opened accordion
    if (openAccordionId && openAccordionId !== accordionId) {
        const prevContent = document.getElementById(openAccordionId.replace('accordion-', 'accordion-content-'));
        const prevIcon = document.getElementById(openAccordionId.replace('accordion-', 'accordion-icon-'));
        
        if (prevContent) {
            prevContent.classList.add('hidden');
        }
        if (prevIcon) {
            prevIcon.style.transform = 'rotate(0deg)';
        }
    }
    
    // Toggle current accordion
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        openAccordionId = accordionId;
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
        openAccordionId = null;
    }
}

function showAttendanceListError(message) {
    document.getElementById('attendanceListLoading').classList.add('hidden');
    document.getElementById('attendanceListContent').classList.add('hidden');
    document.getElementById('attendanceListError').classList.remove('hidden');
    document.getElementById('attendanceListErrorMessage').textContent = message;
}

// Activity Time Table Filter Variables
let activityAvailableYearsMonths = @json($availableYearsMonths ?? []);
let activityCurrentFilterYear = "{{ $filterYear ?? '' }}";
let activityCurrentFilterMonth = "{{ $filterMonth ?? '' }}";

// Month names mapping
const activityMonthNames = {
    1: 'January', 2: 'February', 3: 'March', 4: 'April',
    5: 'May', 6: 'June', 7: 'July', 8: 'August',
    9: 'September', 10: 'October', 11: 'November', 12: 'December'
};

// Initialize Activity Time Table
document.addEventListener('DOMContentLoaded', function() {
    // Initialize month filter
    updateActivityMonthFilter();
    
    // Add event listener to year filter
    document.getElementById('activityYear').addEventListener('change', function() {
        updateActivityMonthFilter();
        applyActivityFilters();
    });
    
    // Add event listeners to all filters for auto-apply
    document.getElementById('activityMonth').addEventListener('change', applyActivityFilters);
    document.getElementById('activityStatus').addEventListener('change', applyActivityFilters);
    
    // Initial table render
    renderActivityTable(@json($trainings));
});

// ================================================================
// UPDATE MONTH FILTER BASED ON SELECTED YEAR
// ================================================================
function updateActivityMonthFilter() {
    const yearSelect = document.getElementById('activityYear');
    const monthSelect = document.getElementById('activityMonth');
    const selectedYear = yearSelect.value;
    
    // Clear current options except "All Months"
    monthSelect.innerHTML = '<option value="">All Months</option>';
    
    if (selectedYear && activityAvailableYearsMonths[selectedYear]) {
        // Add months available for the selected year
        activityAvailableYearsMonths[selectedYear].forEach(month => {
            const option = document.createElement('option');
            option.value = month;
            option.textContent = activityMonthNames[month];
            
            // Preserve selected month if it exists in the new year
            if (activityCurrentFilterMonth == month && activityCurrentFilterYear == selectedYear) {
                option.selected = true;
            }
            
            monthSelect.appendChild(option);
        });
    } else {
        // If no year selected, show all unique months across all years
        const allMonths = new Set();
        Object.values(activityAvailableYearsMonths).forEach(months => {
            months.forEach(month => allMonths.add(month));
        });
        
        // Sort and add all months
        Array.from(allMonths).sort((a, b) => a - b).forEach(month => {
            const option = document.createElement('option');
            option.value = month;
            option.textContent = activityMonthNames[month];
            
            if (activityCurrentFilterMonth == month && !activityCurrentFilterYear) {
                option.selected = true;
            }
            
            monthSelect.appendChild(option);
        });
    }
}

// ================================================================
// APPLY FILTERS VIA AJAX
// ================================================================
function applyActivityFilters() {
    const year = document.getElementById('activityYear').value;
    const month = document.getElementById('activityMonth').value;
    const status = document.getElementById('activityStatus').value;
    
    // Show loading spinner
    document.getElementById('activityLoadingSpinner').classList.remove('hidden');
    document.getElementById('activityTableContainer').classList.add('opacity-50');
    
    // Build query string
    const params = new URLSearchParams();
    if (year) params.append('year', year);
    if (month) params.append('month', month);
    if (status) params.append('status', status);
    params.append('ajax', '1');
    
    // Fetch filtered data
    fetch(`{{ route('instructor.training') }}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Update table
        renderActivityTable(data.trainings);
        
        // Update calendar
        if (calendar) {
            calendar.removeAllEvents();
            calendar.addEventSource(data.calendarEvents);
        }
        
        // Update URL without reload
        const newUrl = `{{ route('instructor.training') }}?${params.toString().replace('ajax=1', '').replace(/&$/, '')}`;
        window.history.pushState({}, '', newUrl || '{{ route('instructor.training') }}');
        
        // Hide loading spinner
        document.getElementById('activityLoadingSpinner').classList.add('hidden');
        document.getElementById('activityTableContainer').classList.remove('opacity-50');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load training data');
        document.getElementById('activityLoadingSpinner').classList.add('hidden');
        document.getElementById('activityTableContainer').classList.remove('opacity-50');
    });
}

// ================================================================
// RENDER TABLE WITH TRAINING DATA
// ================================================================
function renderActivityTable(trainings) {
    const tbody = document.getElementById('activityTableBody');
    tbody.innerHTML = '';
    
    if (!trainings || trainings.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="px-6 py-8 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-gray-500 text-sm">No training sessions found with the current filters</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }
    
    trainings.forEach(training => {
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50 transition-colors duration-150';
        
        let durationText = 'TBD';
        if (training.duration_hours) {
            if (training.allowance_type === 'daily') {
                durationText = training.duration_hours + ' days';
            } else {
                durationText = training.duration_hours + 'h';
            }
        }
        
        const description = training.description ? 
            `<div class="text-sm text-gray-500">${truncateActivityText(training.description, 50)}</div>` : '';
        
        row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">${training.title}</div>
                ${description}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${training.involvement || 'Not specified'}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${training.location}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                <div>${training.formatted_start_date}</div>
                <div class="text-gray-500">${training.formatted_start_time}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${durationText}
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full ${training.status_badge_color}">
                    ${training.status}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="editTraining(${training.id})" class="text-indigo-600 hover:text-indigo-900 mr-4 transition-colors duration-150">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </button>
                <button onclick="deleteTraining(${training.id})" class="text-red-600 hover:text-red-900 transition-colors duration-150">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
    });
}

// ================================================================
// UTILITY: TRUNCATE STRING
// ================================================================
function truncateActivityText(text, length) {
    return text.length > length ? text.substring(0, length) + '...' : text;
}
</script>
    @endpush
</x-app-layout>