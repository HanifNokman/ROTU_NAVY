<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin="">
    </script>

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

    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .category-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .category-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }

    .category-card.selected {
        border: 2px solid #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .photo-card {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
    }

    .photo-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
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

    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .gradient-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .gradient-cyan {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
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

    .icon-wrapper-sm {
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ========================================= */
    /* BUTTON STYLES */
    /* ========================================= */
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        transform: translateY(-1px);
    }

    .filter-btn {
        padding: 0.625rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid #e5e7eb;
        background: white;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }

    .filter-btn:not(.active):hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* ========================================= */
    /* INFO CARD STYLES */
    /* ========================================= */
    .info-card {
        background: #ffffff;
        border-radius: 0.75rem;
        padding: 1.25rem;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .info-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
    /* UTILITY CLASSES */
    /* ========================================= */
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .shadow-custom {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* ========================================= */
    /* ADDITIONAL ANIMATIONS */
    /* ========================================= */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    .photo-card {
        position: relative;
        overflow: hidden;
    }

    .photo-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
        z-index: 1;
    }

    .photo-card:hover::before {
        left: 100%;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        z-index: 2;
    }

    .photo-card:hover .image-overlay {
        opacity: 1;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ========================================= */
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 640px) {
        .category-card:hover,
        .photo-card:hover,
        .dashboard-card:hover {
            transform: none !important;
        }

        #map {
            height: 250px !important;
        }
    }
    </style>

    <div class="py-4 sm:py-8 pb-8 sm:pb-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

            {{-- ================================================================ --}}
            {{-- PAGE TITLE SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-4 sm:mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 gradient-header rounded-2xl shadow-lg mb-3 sm:mb-4">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 mb-1 sm:mb-2 px-2">Attendance Portal</h1>
                <p class="text-gray-600 text-sm sm:text-lg px-2">Mark your attendance and manage absence records</p>
            </div>
            {{-- ================================================================ --}}
            {{-- TODAY'S TRAINING SESSIONS --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-xl sm:rounded-2xl dashboard-card">

                {{-- Section Header --}}
                <div class="section-header">
                    <div class="flex items-center mb-1 sm:mb-2">
                        <div class="icon-wrapper gradient-green mr-2 sm:mr-3">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-2xl font-bold text-gray-900 truncate">Current Training Sessions</h3>
                    </div>
                    <p class="text-gray-600 text-xs sm:text-base hidden sm:block">Mark your attendance for active training sessions</p>
                </div>

                {{-- Section Content --}}
                <div class="p-4 sm:p-6">
                    @if(isset($todaysTrainings) && $todaysTrainings->count() > 0)
                        <div class="grid gap-6">
                            @foreach($todaysTrainings as $training)
                                @php
                                    $attendance = \App\Models\TrainingAttendance::where('training_id', $training->id)
                                        ->where('cadet_id', $cadet->id)
                                        ->first();
                                @endphp

                                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-blue-300 transition-all duration-300">

                                    {{-- Training Header --}}
                                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 sm:px-6 sm:py-4">
                                        <div class="flex items-start justify-between flex-wrap sm:flex-nowrap gap-2">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-base sm:text-xl font-bold text-white mb-1 truncate">{{ $training->title }}</h3>
                                                <div class="flex flex-wrap gap-2 mt-2">
                                                    <span class="inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs font-semibold bg-white bg-opacity-20 text-white backdrop-blur-sm">
                                                        <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                        </svg>
                                                        <span class="truncate">
                                                        @if($training->end_datetime && $training->start_datetime->toDateString() !== $training->end_datetime->toDateString())
                                                            {{ $training->start_datetime->format('M d') }} - {{ $training->end_datetime->format('M d, Y') }}
                                                        @else
                                                            {{ $training->formatted_start_date }}
                                                        @endif
                                                        </span>
                                                    </span>
                                                    @if($training->start_datetime->isToday())
                                                        <span class="inline-flex items-center px-2 py-0.5 sm:px-3 sm:py-1 rounded-full text-xs font-semibold bg-green-500 text-white">
                                                            <span class="w-2 h-2 bg-white rounded-full mr-1.5 animate-pulse flex-shrink-0"></span>
                                                            Live Today
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-bold shadow-lg
                                                    {{ $training->status === 'Active' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }}">
                                                    {{ $training->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Training Details --}}
                                    <div class="p-4 sm:p-6">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4 sm:mb-6">
                                            <div class="flex items-start space-x-2 sm:space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-map-marker-alt text-red-600 text-sm sm:text-base"></i>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Location</div>
                                                    <div class="text-sm font-bold text-gray-900 mt-0.5 truncate">{{ $training->location }}</div>
                                                </div>
                                            </div>

                                            <div class="flex items-start space-x-2 sm:space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-clock text-green-600 text-sm sm:text-base"></i>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Time</div>
                                                    <div class="text-sm font-bold text-gray-900 mt-0.5 break-words">
                                                        {{ $training->formatted_start_time }}
                                                        @if($training->end_datetime)
                                                            - {{ $training->end_datetime->format('h:i A') }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            @if($training->involvement)
                                                <div class="flex items-start space-x-2 sm:space-x-3">
                                                    <div class="flex-shrink-0 w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-users text-purple-600 text-sm sm:text-base"></i>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Involvement</div>
                                                        <div class="text-sm font-bold text-gray-900 mt-0.5 truncate">{{ $training->involvement }}</div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if($training->end_datetime && $training->start_datetime->toDateString() !== $training->end_datetime->toDateString())
                                                @php
                                                    $days = $training->start_datetime->diffInDays($training->end_datetime) + 1;
                                                @endphp
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-calendar-alt text-blue-600"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Duration</div>
                                                        <div class="text-sm font-bold text-gray-900 mt-0.5">{{ floor($days ?? 0) }}-Day Training</div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        @if($training->description)
                                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <i class="fas fa-info-circle text-blue-600"></i>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm text-blue-900">{{ $training->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Attendance Action --}}
                                    @if(!$attendance || !$attendance->present)
                                        <div class="px-6 pb-6 space-y-4">
                                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 border-2 border-blue-200">
                                                <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                                                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                                                        <i class="fas fa-map-marked-alt text-white text-sm"></i>
                                                    </div>
                                                    Location Verification Required
                                                </h4>

                                                {{-- Map Container --}}
                                                <div class="bg-white rounded-lg overflow-hidden shadow-md">
                                                    <div id="map-{{ $training->id }}" class="w-full h-80"></div>
                                                </div>

                                                {{-- Map Legend --}}
                                                <div class="mt-3 flex flex-wrap gap-3 text-xs">
                                                    <div class="flex items-center bg-white px-3 py-1.5 rounded-full shadow-sm">
                                                        <div class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></div>
                                                        <span class="text-gray-700 font-medium">Meetup Point</span>
                                                    </div>
                                                    <div class="flex items-center bg-white px-3 py-1.5 rounded-full shadow-sm">
                                                        <div class="w-2.5 h-2.5 bg-blue-500 rounded-full mr-2"></div>
                                                        <span class="text-gray-700 font-medium">Your Location</span>
                                                    </div>
                                                    <div class="flex items-center bg-white px-3 py-1.5 rounded-full shadow-sm">
                                                        <div class="w-2.5 h-2.5 bg-green-200 border-2 border-green-500 rounded-full mr-2"></div>
                                                        <span class="text-gray-700 font-medium">Allowed Zone ({{ $geofence['radius'] }}m)</span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Attendance Form --}}
                                            <form method="POST" action="{{ route('cadet.attendance.mark') }}" class="w-full">
                                                @csrf
                                                <input type="hidden" name="training_id" value="{{ $training->id }}">
                                                {{-- Location inputs will be added by JavaScript --}}

                                                <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-xl transform hover:scale-[1.01] transition-all duration-200 flex items-center justify-center group">
                                                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-opacity-30 transition-all">
                                                        <i class="fas fa-hand-paper text-xl"></i>
                                                    </div>
                                                    Mark My Attendance
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="px-6 pb-6">
                                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl p-6 relative overflow-hidden">
                                                {{-- Decorative Background --}}
                                                <div class="absolute top-0 right-0 opacity-5">
                                                    <i class="fas fa-check-circle text-9xl text-green-600"></i>
                                                </div>

                                                {{-- Content --}}
                                                <div class="relative z-10 flex items-center">
                                                    <div class="flex-shrink-0 w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                                                        <i class="fas fa-check-circle text-3xl text-white"></i>
                                                    </div>
                                                    <div class="ml-5 flex-1">
                                                        <div class="text-xl font-bold text-green-900">Attendance Confirmed</div>
                                                        <div class="text-sm text-green-700 mt-1 flex items-center">
                                                            <i class="fas fa-clock mr-1.5"></i>
                                                            Marked present at {{ $attendance->marked_at->format('g:i A') }}
                                                        </div>
                                                        @if($attendance->latitude && $attendance->longitude)
                                                            <div class="text-xs text-green-600 mt-1.5 flex items-center">
                                                                <div class="w-5 h-5 bg-green-200 rounded-full flex items-center justify-center mr-1.5">
                                                                    <i class="fas fa-map-marker-alt text-green-700 text-xs"></i>
                                                                </div>
                                                                Location verified successfully
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4">
                                                        <span class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full text-sm font-bold shadow-lg">
                                                            <i class="fas fa-check mr-2"></i>
                                                            Present
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 px-6">
                            <div class="max-w-md mx-auto">
                                {{-- Illustration --}}
                                <div class="mb-6 relative">
                                    <div class="w-32 h-32 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full mx-auto flex items-center justify-center">
                                        <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    {{-- Decorative elements --}}
                                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-2">
                                        <div class="w-3 h-3 bg-blue-400 rounded-full animate-bounce"></div>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Training Sessions Today</h3>
                                <p class="text-gray-600 mb-4">There are no training sessions scheduled for today.</p>

                                {{-- Info Card --}}
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
                                    <div class="flex items-center justify-center text-blue-800 text-sm">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        <span>Check back later or contact your instructor for updates</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ABSENCE RECORDS SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card mt-8">

                {{-- Section Header --}}
                <div class="section-header">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-orange mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Absence Records</h3>
                        </div>
                        @if($absentAttendances->count() > 0)
                            <div class="ml-4">
                                <span class="inline-flex items-center justify-center w-12 h-12 bg-red-500 text-white text-lg font-bold rounded-full shadow-lg">
                                    {{ $absentAttendances->count() }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <p class="text-gray-600">Submit reasons for your absences with supporting documentation</p>
                </div>

                {{-- Section Content --}}
                <div class="p-6">
                    @if($absentAttendances->count() > 0)

                        {{-- Quick Navigation --}}
                        <div class="bg-gradient-to-br from-orange-50 to-red-50 rounded-xl p-6 border-2 border-orange-200 mb-6">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Quick Actions</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-100">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-exclamation-triangle text-orange-600 mr-2"></i>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Pending Items</span>
                                    </div>
                                    <div class="text-2xl font-bold text-orange-600">
                                        {{ $absentAttendances->count() }}
                                        <span class="text-sm font-normal text-gray-600">Record{{ $absentAttendances->count() > 1 ? 's' : '' }}</span>
                                    </div>
                                </div>

                                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-100">
                                    <label for="absenceDropdown" class="flex items-center text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                                        <i class="fas fa-search mr-2 text-orange-600"></i>
                                        Jump to Record
                                    </label>
                                    <select id="absenceDropdown"
                                            class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white text-sm font-medium transition-all"
                                            onchange="openAbsenceRecord(this.value)">
                                        <option value="">Select an absence...</option>
                                        @foreach($absentAttendances as $attendance)
                                            <option value="absence-{{ $attendance->id }}">{{ $attendance->training->title }} - {{ $attendance->training->formatted_start_date }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Absence Submissions --}}
                        <div class="space-y-4">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-600 to-red-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">Submit Absence Documentation</h4>
                            </div>

                            <div id="absenceContainer" class="space-y-4">
                                @foreach($absentAttendances as $attendance)
                                    <div id="absence-{{ $attendance->id }}" x-data="{ open: false }" class="bg-white border-2 border-orange-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300">

                                        {{-- Accordion Header --}}
                                        <button @click="open = !open"
                                                class="w-full flex justify-between items-center px-6 py-5 bg-gradient-to-r from-orange-50 to-red-50 hover:from-orange-100 hover:to-red-100 text-left transition-all duration-200">
                                            <div class="flex items-center flex-1">
                                                <div class="flex-shrink-0 w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 shadow-md">
                                                    <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="font-bold text-gray-900 text-lg">{{ $attendance->training->title }}</div>
                                                    <div class="text-sm text-gray-600 mt-1 flex items-center">
                                                        <i class="fas fa-calendar-alt mr-1.5 text-orange-600"></i>
                                                        {{ $attendance->training->formatted_start_date }} at {{ $attendance->training->formatted_start_time }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center ml-4">
                                                <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-md mr-4">
                                                    ABSENT
                                                </span>
                                                <div class="w-8 h-8 bg-orange-200 rounded-lg flex items-center justify-center">
                                                    <svg :class="{'rotate-180': open}" class="w-4 h-4 text-orange-700 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </button>


                                        {{-- Accordion Content --}}
                                        <div x-show="open" x-transition class="p-6 bg-gradient-to-br from-gray-50 to-orange-50">

                                            {{-- Training Details --}}
                                            <div class="bg-white rounded-lg p-5 mb-6 shadow-sm border border-gray-200">
                                                <h5 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4 flex items-center">
                                                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                                                    Session Details
                                                </h5>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-map-marker-alt text-red-600 text-sm"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-xs text-gray-500 font-semibold uppercase">Location</div>
                                                            <div class="text-sm font-bold text-gray-900">{{ $attendance->training->location }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-calendar text-blue-600 text-sm"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-xs text-gray-500 font-semibold uppercase">Date</div>
                                                            <div class="text-sm font-bold text-gray-900">{{ $attendance->training->formatted_start_date }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-start space-x-3">
                                                        <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                                            <i class="fas fa-clock text-green-600 text-sm"></i>
                                                        </div>
                                                        <div>
                                                            <div class="text-xs text-gray-500 font-semibold uppercase">Time</div>
                                                            <div class="text-sm font-bold text-gray-900">{{ $attendance->training->formatted_start_time }}</div>
                                                        </div>
                                                    </div>
                                                    @if($attendance->training->involvement)
                                                        <div class="flex items-start space-x-3">
                                                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                                                <i class="fas fa-users text-purple-600 text-sm"></i>
                                                            </div>
                                                            <div>
                                                                <div class="text-xs text-gray-500 font-semibold uppercase">Involvement</div>
                                                                <div class="text-sm font-bold text-gray-900">{{ $attendance->training->involvement }}</div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Absence Form --}}
                                            <form method="POST" action="{{ route('cadet.attendance.absence', $attendance->id) }}"
                                                  enctype="multipart/form-data" class="space-y-5">
                                                @csrf

                                                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200">
                                                    <label class="flex items-center text-sm font-bold text-gray-900 mb-3">
                                                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-2">
                                                            <i class="fas fa-comment-alt text-white text-sm"></i>
                                                        </div>
                                                        Reason for Absence <span class="text-red-500 ml-1">*</span>
                                                    </label>
                                                    <textarea
                                                        name="absence_reason"
                                                        required
                                                        placeholder="Provide a detailed explanation for your absence (minimum 10 characters)"
                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none text-sm transition-all"
                                                        rows="4"
                                                        maxlength="500"
                                                        oninput="updateCharCount(this, 'char-count-{{ $attendance->id }}')"
                                                    >{{ old('absence_reason') }}</textarea>
                                                    <div class="flex justify-between items-center mt-2 text-xs">
                                                        <div class="text-gray-600">
                                                            <span id="char-count-{{ $attendance->id }}" class="font-bold text-orange-600">0</span><span class="text-gray-500">/500 characters</span>
                                                        </div>
                                                        <div class="text-gray-500">
                                                            <i class="fas fa-info-circle mr-1"></i>Minimum 10 characters
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200">
                                                    <label class="flex items-center text-sm font-bold text-gray-900 mb-3">
                                                        <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center mr-2">
                                                            <i class="fas fa-paperclip text-white text-sm"></i>
                                                        </div>
                                                        Supporting Documentation <span class="text-red-500 ml-1">*</span>
                                                    </label>
                                                    <input
                                                        type="file"
                                                        name="supporting_file"
                                                        id="supporting_file"
                                                        required
                                                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 transition-all"
                                                        onchange="validateAttendanceFileSize(this)"
                                                    >
                                                    <div class="text-xs text-gray-600 mt-2 flex items-center bg-blue-50 p-2 rounded">
                                                        <i class="fas fa-info-circle mr-1.5 text-blue-600"></i>
                                                        <span>JPG, PNG, PDF, DOC, DOCX • Max 5MB</span>
                                                    </div>
                                                    <div id="supporting-file-error" class="text-xs text-red-600 mt-2 hidden flex items-center">
                                                        <i class="fas fa-exclamation-triangle mr-1.5"></i>
                                                        <span id="supporting-file-error-text"></span>
                                                    </div>
                                                </div>

                                                <button type="submit"
                                                        class="w-full bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-xl transform hover:scale-[1.01] transition-all duration-200 flex items-center justify-center group">
                                                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-opacity-30 transition-all">
                                                        <i class="fas fa-paper-plane text-lg"></i>
                                                    </div>
                                                    Submit Absence Documentation
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16 px-6">
                            <div class="max-w-md mx-auto">
                                {{-- Illustration --}}
                                <div class="mb-6 relative">
                                    <div class="w-32 h-32 bg-gradient-to-br from-green-100 to-emerald-100 rounded-full mx-auto flex items-center justify-center shadow-lg">
                                        <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    {{-- Decorative checkmarks --}}
                                    <div class="absolute top-0 right-1/4 animate-bounce">
                                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                    </div>
                                    <div class="absolute bottom-0 left-1/4 animate-bounce" style="animation-delay: 0.2s;">
                                        <div class="w-3 h-3 bg-emerald-400 rounded-full"></div>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <h3 class="text-2xl font-bold text-gray-800 mb-2">Perfect Attendance!</h3>
                                <p class="text-gray-600 mb-4">You have no pending absence records. Keep up the excellent attendance!</p>

                                {{-- Success Card --}}
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-xl p-6 mt-6">
                                    <div class="flex items-center justify-center">
                                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-3 shadow-md">
                                            <i class="fas fa-trophy text-white text-xl"></i>
                                        </div>
                                        <div class="text-left">
                                            <div class="text-lg font-bold text-green-900">All Clear</div>
                                            <div class="text-sm text-green-700">No action required at this time</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- SUCCESS/ERROR MESSAGES --}}
    {{-- ================================================================ --}}
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <div>
                    <div class="font-semibold">Success!</div>
                    <div class="text-sm">{{ session('success') }}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                <div>
                    <div class="font-semibold">Error!</div>
                    <div class="text-sm">{{ session('error') }}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div id="validation-errors" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 max-w-sm animate-slide-in">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-xl mr-3 mt-1"></i>
                <div>
                    <div class="font-semibold mb-2">Validation Errors:</div>
                    <ul class="text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start">
                                <i class="fas fa-circle text-xs mr-2 mt-1"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>
    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    @push('scripts')
        <script>
            // ================================================================
            // GEOFENCING ATTENDANCE SYSTEM WITH INTERACTIVE MAP
            // ================================================================
            
            // Wait for Leaflet to be fully loaded
            function initializeAttendanceMaps() {
                if (typeof L === 'undefined') {
                    console.error('Leaflet not loaded, retrying...');
                    setTimeout(initializeAttendanceMaps, 100);
                    return;
                }

                console.log('Leaflet loaded successfully');

                const defaultGeofence = {
                    latitude: {{ $geofence['latitude'] }},
                    longitude: {{ $geofence['longitude'] }},
                    radius: {{ $geofence['radius'] }}
                };

                // Store individual training meetup coordinates
                const trainingMeetups = {
                    @foreach($todaysTrainings as $training)
                    {{ $training->id }}: {
                        latitude: {{ $training->meetup_latitude ?? $geofence['latitude'] }},
                        longitude: {{ $training->meetup_longitude ?? $geofence['longitude'] }},
                        radius: {{ $geofence['radius'] }}
                    },
                    @endforeach
                };

                let userLocation = null;
                const maps = {};

                console.log('Looking for attendance forms...');
                // Find forms that have training_id input (more reliable selector)
                const formsWithTrainingId = Array.from(document.querySelectorAll('form')).filter(form => {
                    return form.querySelector('input[name="training_id"]') &&
                           form.getAttribute('action') &&
                           form.getAttribute('action').includes('attendance') &&
                           form.getAttribute('method') === 'POST';
                });

                const forms = formsWithTrainingId;
                console.log('Found', forms.length, 'attendance form(s)');

                // Additional debugging
                const allForms = document.querySelectorAll('form');
                console.log('Total forms on page:', allForms.length);
                allForms.forEach((f, i) => {
                    const action = f.getAttribute('action');
                    const method = f.getAttribute('method');
                    const hasTrainingId = f.querySelector('input[name="training_id"]');
                    console.log(`Form ${i + 1} action:`, action, '| Method:', method, '| Has training_id:', !!hasTrainingId);
                });

                const trainingSections = document.querySelectorAll('.bg-white.rounded-xl.border.border-gray-200');
                console.log('Training session cards found:', trainingSections.length);

                const attendanceConfirmed = document.querySelectorAll('.bg-gradient-to-br.from-green-50.to-emerald-50');
                console.log('Already marked attendance sections:', attendanceConfirmed.length);

                if (forms.length === 0) {
                    console.warn('⚠️ No attendance forms found. Possible reasons:');
                    console.warn('1. No training sessions scheduled for today');
                    console.warn('2. Attendance already marked for all sessions');
                    console.warn('3. Training sessions are not active/eligible');
                    console.warn('Check the page - do you see any "Mark My Attendance" buttons?');
                    return; // Exit early if no forms
                }

                // Process all attendance forms on the page
                forms.forEach((form, index) => {
                    console.log('Processing form', index + 1);
                    const button = form.querySelector('button[type="submit"]');
                    const trainingCard = form.closest('.px-6.pb-6.space-y-4') || form.closest('.bg-white.rounded-xl.border.border-gray-200');
                    const trainingIdInput = form.querySelector('input[name="training_id"]');
                    const trainingId = trainingIdInput ? trainingIdInput.value : index;
                    const mapContainer = document.getElementById(`map-${trainingId}`);

                    // Get the specific training's meetup coordinates or use default
                    const geofence = trainingMeetups[trainingId] || defaultGeofence;

                    console.log('Training ID:', trainingId);
                    console.log('Training meetup coordinates:', geofence);
                    console.log('Map container element:', mapContainer);
                    console.log('Button element:', button);
                    console.log('Training card:', trainingCard);
                    
                    if (!mapContainer) {
                        console.error('❌ Map container not found for training:', trainingId);
                        console.error('Looking for element with ID: map-' + trainingId);
                        return;
                    }

                    if (!button) {
                        console.error('❌ Submit button not found');
                        return;
                    }

                    if (!trainingCard) {
                        console.error('❌ Training card container not found');
                        return;
                    }

                    console.log('✅ All required elements found, proceeding with map initialization...');

                    // Create status message div - insert before the button
                    let statusDiv = form.querySelector('.location-status');
                    if (!statusDiv) {
                        statusDiv = document.createElement('div');
                        statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2';
                        form.insertBefore(statusDiv, button);
                    }

                    // Disable button initially
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');

                    try {
                        // Initialize map
                        const map = L.map(mapContainer, {
                            center: [geofence.latitude, geofence.longitude],
                            zoom: 16,
                            zoomControl: true,
                            scrollWheelZoom: false,
                            attributionControl: true
                        });

                        console.log('Map created successfully');

                        // Add OpenStreetMap tiles with error handling
                        const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            maxZoom: 19,
                            minZoom: 10
                        });

                        tileLayer.on('tileerror', function(error) {
                            console.error('Tile loading error:', error);
                        });

                        tileLayer.on('tileload', function() {
                            console.log('Tiles loading...');
                        });

                        tileLayer.addTo(map);

                        // Force map to refresh
                        setTimeout(() => {
                            map.invalidateSize();
                            console.log('Map size invalidated');
                        }, 100);

                        // Add geofence circle (allowed zone)
                        const geofenceCircle = L.circle([geofence.latitude, geofence.longitude], {
                            color: '#10b981',
                            fillColor: '#10b981',
                            fillOpacity: 0.15,
                            radius: geofence.radius,
                            weight: 2
                        }).addTo(map);

                        // Add meetup location marker
                        const meetupIcon = L.divIcon({
                            html: '<div class="bg-red-500 w-8 h-8 rounded-full border-4 border-white shadow-lg flex items-center justify-center"><i class="fas fa-flag text-white text-xs"></i></div>',
                            iconSize: [32, 32],
                            iconAnchor: [16, 16],
                            className: 'pulse-marker'
                        });

                        const meetupMarker = L.marker([geofence.latitude, geofence.longitude], {
                            icon: meetupIcon
                        }).addTo(map);
                        meetupMarker.bindPopup('<b>Meetup Location</b><br>You must be within ' + geofence.radius + 'm of this point.');

                        maps[trainingId] = {
                            map: map,
                            geofenceCircle: geofenceCircle,
                            userMarker: null,
                            distanceLine: null
                        };

                        console.log('Map elements added successfully');

                    } catch (error) {
                        console.error('Error initializing map:', error);
                        statusDiv.innerHTML = `<div class="text-red-600"><i class="fas fa-exclamation-circle mr-2"></i>Map initialization failed. Please refresh the page.</div>`;
                        statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300';
                        return;
                    }

                    // Check geolocation support
                    if (!navigator.geolocation) {
                        showError(statusDiv, 'Geolocation is not supported by your browser.');
                        console.error('Geolocation not supported');
                        return;
                    }

                    // Get user location
                    statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <strong>Verifying your location...</strong><br><span class="text-xs">Please wait while we check your position</span>';
                    statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-blue-50 border-blue-300 text-blue-800';

                    console.log('Requesting geolocation...');

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            userLocation = {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                                accuracy: position.coords.accuracy
                            };

                            console.log('User location obtained:', userLocation);
                            console.log('GPS Accuracy:', userLocation.accuracy, 'meters');

                            const distance = calculateDistance(
                                geofence.latitude,
                                geofence.longitude,
                                userLocation.latitude,
                                userLocation.longitude
                            );

                            console.log('Distance from meetup:', distance);

                            // Add user marker to map
                            const userIcon = L.divIcon({
                                html: '<div class="bg-blue-500 w-8 h-8 rounded-full border-4 border-white shadow-lg flex items-center justify-center"><i class="fas fa-user text-white text-xs"></i></div>',
                                iconSize: [32, 32],
                                iconAnchor: [16, 16],
                                className: ''
                            });

                            maps[trainingId].userMarker = L.marker([userLocation.latitude, userLocation.longitude], {
                                icon: userIcon
                            }).addTo(maps[trainingId].map);
                            maps[trainingId].userMarker.bindPopup('<b>Your Location</b><br>Distance: ' + Math.round(distance) + 'm from meetup');

                            // Add accuracy circle
                            L.circle([userLocation.latitude, userLocation.longitude], {
                                color: '#3b82f6',
                                fillColor: '#3b82f6',
                                fillOpacity: 0.1,
                                radius: userLocation.accuracy,
                                weight: 1,
                                dashArray: '3, 3'
                            }).addTo(maps[trainingId].map);

                            // Draw line between user and meetup point
                            maps[trainingId].distanceLine = L.polyline([
                                [geofence.latitude, geofence.longitude],
                                [userLocation.latitude, userLocation.longitude]
                            ], {
                                color: distance <= geofence.radius ? '#10b981' : '#ef4444',
                                weight: 2,
                                dashArray: '5, 5',
                                className: 'distance-line'
                            }).addTo(maps[trainingId].map);

                            // Fit map to show both markers
                            const bounds = L.latLngBounds([
                                [geofence.latitude, geofence.longitude],
                                [userLocation.latitude, userLocation.longitude]
                            ]);
                            maps[trainingId].map.fitBounds(bounds, { padding: [50, 50] });

                            if (distance <= geofence.radius) {
                                // SUCCESS - Within geofence
                                statusDiv.innerHTML = `
                                    <div class="flex items-start">
                                        <i class="fas fa-check-circle text-2xl mr-3"></i>
                                        <div>
                                            <strong class="block">✓ Location Verified!</strong>
                                            <span class="text-xs">You are <strong>${Math.round(distance)}m</strong> from the meetup point (within ${geofence.radius}m allowed zone)</span>
                                        </div>
                                    </div>
                                `;
                                statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-green-50 border-green-300 text-green-800';
                                
                                // Enable button
                                button.disabled = false;
                                button.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                                button.classList.add('bg-gradient-to-r', 'from-green-500', 'to-green-600', 'hover:from-green-600', 'hover:to-green-700');

                                // Add location to form
                                addLocationToForm(form, userLocation);

                                // Open user marker popup
                                setTimeout(() => {
                                    maps[trainingId].userMarker.openPopup();
                                }, 500);
                            } else {
                                // FAIL - Outside geofence
                                statusDiv.innerHTML = `
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                                        <div>
                                            <strong class="block">⚠ Outside Allowed Zone</strong>
                                            <span class="text-xs">You are <strong>${Math.round(distance)}m</strong> away. Please move closer to the meetup location (within ${geofence.radius}m)</span>
                                        </div>
                                    </div>
                                `;
                                statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300 text-red-800';
                                
                                // Keep button DISABLED
                                button.disabled = true;
                                button.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                                button.classList.remove('bg-gradient-to-r', 'from-green-500', 'to-green-600', 'hover:from-green-600', 'hover:to-green-700');

                                // Change button appearance to show it's locked
                                button.innerHTML = '<i class="fas fa-lock text-xl mr-3"></i> Location Required - Move Closer';
                                
                                // Add refresh button
                                const refreshBtn = document.createElement('button');
                                refreshBtn.type = 'button';
                                refreshBtn.className = 'mt-2 text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded';
                                refreshBtn.innerHTML = '<i class="fas fa-sync-alt mr-1"></i> Refresh Location';
                                refreshBtn.onclick = () => location.reload();
                                statusDiv.appendChild(refreshBtn);
                            }
                        },
                        (error) => {
                            console.error('Geolocation error:', error);
                            console.error('Error code:', error.code);
                            console.error('Error message:', error.message);
                            handleGeolocationError(error, statusDiv, maps[trainingId].map);
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );

                    // Prevent form submission if location not verified
                    form.addEventListener('submit', function(e) {
                        if (!userLocation || button.disabled) {
                            e.preventDefault();
                            alert('Please wait for location verification or enable location services.');
                            return false;
                        }
                    });
                });

                function addLocationToForm(form, location) {
                    // Remove old inputs if they exist
                    form.querySelectorAll('input[name="latitude"], input[name="longitude"]').forEach(el => el.remove());

                    // Add hidden inputs
                    const latInput = document.createElement('input');
                    latInput.type = 'hidden';
                    latInput.name = 'latitude';
                    latInput.value = location.latitude;
                    
                    const lonInput = document.createElement('input');
                    lonInput.type = 'hidden';
                    lonInput.name = 'longitude';
                    lonInput.value = location.longitude;
                    
                    form.appendChild(latInput);
                    form.appendChild(lonInput);
                }

                function calculateDistance(lat1, lon1, lat2, lon2) {
                    const R = 6371000; // Earth's radius in meters
                    const dLat = toRad(lat2 - lat1);
                    const dLon = toRad(lon2 - lon1);
                    
                    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                            Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    
                    const distance = R * c;
                    
                    console.log('Distance Calculation:');
                    console.log('From:', lat1, lon1);
                    console.log('To:', lat2, lon2);
                    console.log('dLat:', dLat, 'dLon:', dLon);
                    console.log('a:', a, 'c:', c);
                    console.log('Distance:', distance, 'meters =', (distance/1000).toFixed(2), 'km');
                    
                    return distance;
                }

                function toRad(degrees) {
                    return degrees * (Math.PI / 180);
                }

                function showError(statusDiv, message) {
                    statusDiv.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                            <div>
                                <strong class="block">Location Error</strong>
                                <span class="text-xs">${message}</span>
                            </div>
                        </div>
                    `;
                    statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300 text-red-800';
                }

                function handleGeolocationError(error, statusDiv, map) {
                    let message = '';
                    let instructions = '';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Location permission denied.';
                            instructions = 'Please enable location access in your browser settings and refresh the page.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Location unavailable.';
                            instructions = 'Please check your device settings and ensure GPS is enabled.';
                            break;
                        case error.TIMEOUT:
                            message = 'Location request timed out.';
                            instructions = 'Please refresh the page to try again.';
                            break;
                        default:
                            message = 'An error occurred while getting your location.';
                            instructions = 'Please refresh the page and try again.';
                    }
                    
                    statusDiv.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                            <div>
                                <strong class="block">${message}</strong>
                                <span class="text-xs">${instructions}</span>
                            </div>
                        </div>
                    `;
                    statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300 text-red-800';
                    
                    // Add retry button
                    const retryBtn = document.createElement('button');
                    retryBtn.type = 'button';
                    retryBtn.className = 'mt-2 text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded';
                    retryBtn.innerHTML = '<i class="fas fa-redo mr-1"></i> Retry';
                    retryBtn.onclick = () => location.reload();
                    statusDiv.appendChild(retryBtn);
                }
            }

            // Initialize when DOM and Leaflet are ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeAttendanceMaps);
            } else {
                initializeAttendanceMaps();
            }

            // ================================================================
            // ABSENCE RECORD NAVIGATION
            // ================================================================
            function openAbsenceRecord(absenceId) {
                if (absenceId) {
                    const element = document.getElementById(absenceId);
                    if (element) {
                        element.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                        setTimeout(() => {
                            const button = element.querySelector('button');
                            if (button) {
                                const isOpen = element.querySelector('[x-data]').__x.$data.open;
                                if (!isOpen) {
                                    button.click();
                                }
                            }
                        }, 500);
                    }

                    document.getElementById('absenceDropdown').value = '';
                }
            }

            // ================================================================
            // CHARACTER COUNTER
            // ================================================================
            function updateCharCount(textarea, counterId) {
                const counter = document.getElementById(counterId);
                if (counter) {
                    const length = textarea.value.length;
                    counter.textContent = length;
                    
                    counter.classList.remove('text-gray-500', 'char-count-warning', 'char-count-danger');
                    
                    if (length > 450) {
                        counter.classList.add('char-count-danger');
                    } else if (length > 350) {
                        counter.classList.add('char-count-warning');
                    } else {
                        counter.classList.add('text-gray-500');
                    }
                }
            }

            // ================================================================
            // INITIALIZATION
            // ================================================================
            document.addEventListener('DOMContentLoaded', function() {
                const textareas = document.querySelectorAll('textarea[name="absence_reason"]');
                textareas.forEach(textarea => {
                    const form = textarea.closest('form');
                    const actionUrl = form.getAttribute('action');
                    const attendanceId = actionUrl.split('/').pop();
                    const counterId = `char-count-${attendanceId}`;
                    updateCharCount(textarea, counterId);
                });

                const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
                if (hasErrors) {
                    // Wait for Alpine.js to initialize before accessing x-data
                    setTimeout(() => {
                        const firstAccordion = document.querySelector('[id^="absence-"]');
                        if (firstAccordion) {
                            const button = firstAccordion.querySelector('button');
                            const alpineElement = firstAccordion.querySelector('[x-data]');
                            
                            // Check if Alpine has initialized and accordion is closed
                            if (button && alpineElement && alpineElement.__x && !alpineElement.__x.$data.open) {
                                button.click();
                            } else if (button && (!alpineElement || !alpineElement.__x)) {
                                // Fallback if Alpine hasn't initialized yet - just click the button
                                button.click();
                            }
                        }
                    }, 100);
                }
            });

            // ================================================================
            // AUTO-HIDE NOTIFICATIONS
            // ================================================================
            @if(session('success'))
                setTimeout(() => {
                    const msg = document.getElementById('success-message');
                    if (msg) {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateX(100%)';
                        setTimeout(() => msg.remove(), 300);
                    }
                }, 5000);
            @endif

            @if(session('error'))
                setTimeout(() => {
                    const msg = document.getElementById('error-message');
                    if (msg) {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateX(100%)';
                        setTimeout(() => msg.remove(), 300);
                    }
                }, 5000);
            @endif

            @if($errors->any())
                setTimeout(() => {
                    const msg = document.getElementById('validation-errors');
                    if (msg) {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateX(100%)';
                        setTimeout(() => msg.remove(), 300);
                    }
                }, 8000);
            @endif

            // File Size Validation
            function validateAttendanceFileSize(input) {
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                const errorElement = document.getElementById('supporting-file-error');
                const errorText = document.getElementById('supporting-file-error-text');
                const submitButton = input.closest('form').querySelector('button[type="submit"]');

                if (input.files && input.files[0]) {
                    const fileSize = input.files[0].size;
                    const fileName = input.files[0].name;

                    if (fileSize > maxSize) {
                        const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);
                        errorText.textContent = `File size (${fileSizeMB}MB) exceeds the maximum limit of 5MB. Please choose a smaller file.`;
                        errorElement.classList.remove('hidden');
                        input.value = ''; // Clear the file input

                        if (submitButton) {
                            submitButton.disabled = true;
                            submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                        }

                        return false;
                    } else {
                        errorElement.classList.add('hidden');
                        if (submitButton) {
                            submitButton.disabled = false;
                            submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                        return true;
                    }
                }
                return true;
            }
        </script>
    @endpush
</x-app-layout>
