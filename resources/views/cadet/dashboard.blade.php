<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadet Dashboard') }}
        </h2>
    </x-slot>

    <style>
    /* ========================================= */
    /* CUSTOM SCROLLBAR STYLES (Blue Theme) */
    /* ========================================= */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #e3f2fd;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #5ba4e0 0%, #3c92d9 100%);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #3c92d9 0%, #2d7ac4 100%);
    }

    /* Firefox */
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #3c92d9 #e3f2fd;
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
    /* BADGE STYLES */
    /* ========================================= */
    .badge-icon-mini {
        width: 32px;
        height: 32px;
        object-fit: contain;
        transition: transform 0.2s ease;
    }

    .badge-icon-mini:hover {
        transform: scale(1.1);
    }

    .badge-icon-large {
        width: 56px;
        height: 56px;
        object-fit: contain;
    }

    .badge-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
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

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 0.5rem;
        transition: background 0.2s ease;
    }

    .info-item:hover {
        background: #f3f4f6;
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
    /* PROGRESS BAR STYLES */
    /* ========================================= */
    .progress-container {
        height: 2rem;
        background: #e5e7eb;
        border-radius: 9999px;
        overflow: hidden;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        height: 100%;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

    .btn-toggle {
        padding: 0.625rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    /* Pending button - RED when active */
    #cadet-pending-view-btn.active {
        background: #ef4444;
        color: white;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    /* Leaderboard button - YELLOW when active */
    #cadet-leaderboard-view-btn.active {
        background: #eab308;
        color: white;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .btn-toggle:not(.active) {
        background: transparent;
        color: #4b5563;
    }

    .btn-toggle:not(.active):hover {
        color: #111827;
    }

    /* ========================================= */
    /* COUNTDOWN CIRCLE */
    /* ========================================= */
    .countdown-circle {
        position: relative;
        width: 12rem;
        height: 12rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .countdown-inner {
        position: absolute;
        width: 10rem;
        height: 10rem;
        background: white;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    /* ========================================= */
    /* ACCORDION STYLES */
    /* ========================================= */
    .accordion-item {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        overflow: hidden;
        background: white;
        margin-bottom: 0.75rem;
    }

    .accordion-header {
        width: 100%;
        padding: 1rem 1.25rem;
        background: linear-gradient(to right, #fef3c7 0%, #fde68a 100%);
        transition: all 0.2s ease;
        cursor: pointer;
        border: none;
    }

    .accordion-header:hover {
        background: linear-gradient(to right, #fde68a 0%, #fcd34d 100%);
    }

    .accordion-content {
        border-top: 1px solid #e5e7eb;
        background: #fefce8;
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
    /* RANKING CARD STYLES */
    /* ========================================= */
    .ranking-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.75rem;
        background: white;
        border-radius: 0.75rem;
        border: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .ranking-item:hover {
        border-color: #e2e8f0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transform: translateX(4px);
    }

    .rank-badge {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
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
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 640px) {
        .info-grid {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }

        .dashboard-card:hover {
            transform: none !important;
        }
    }
    </style>

    <div class="py-4 sm:py-8 pb-8 sm:pb-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen relative"
         @if(isset($badgeProgress) && count($badgeProgress) > 0)
         x-data="{ showBadgeBanner: false }"
         x-init="setTimeout(() => { showBadgeBanner = true }, 300); setTimeout(() => { showBadgeBanner = false }, 5300)"
         @endif>

        {{-- Badge Progression Overlay (Full Width of Main Content Area) --}}
        @if(isset($badgeProgress) && count($badgeProgress) > 0)
            <div x-show="showBadgeBanner"
                 x-transition:enter="transition-all ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform -translate-y-full"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition-all ease-in duration-300"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-full"
                 class="absolute top-4 left-0 right-0 z-50 px-3 sm:px-6 lg:px-8">

                <div class="bg-white border border-gray-300 rounded-lg shadow-xl overflow-visible">
                    {{-- Header --}}
                    <div class="flex items-center justify-between px-4 py-2 border-b border-gray-200 bg-gray-50">
                        <span class="text-xs sm:text-sm font-semibold text-gray-700 uppercase tracking-wide">Badge Progression</span>
                        <button @click="showBadgeBanner = false"
                                class="text-gray-500 hover:text-gray-700 hover:bg-gray-200 p-1 rounded transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Badge Cards --}}
                    <div class="px-4 py-4 overflow-visible">
                        <div class="flex gap-3 overflow-x-auto overflow-y-visible custom-scrollbar pb-2">
                            @foreach($badgeProgress as $badge)
                                <div class="badge-card group flex-shrink-0 bg-gray-50 border-2 border-gray-300 border-dashed rounded-xl p-3 text-center hover:shadow-lg transition-all duration-300 cursor-pointer relative"
                                     style="width: 110px; height: 160px; overflow: visible;">

                                    {{-- Default View --}}
                                    <div class="absolute inset-0 p-3 flex flex-col items-center justify-center opacity-100 group-hover:opacity-0 transition-opacity duration-300">
                                        {{-- Greyed Out Badge Icon/Image with Progress --}}
                                        <div class="flex justify-center mb-2">
                                            <div class="relative w-20 h-20 flex items-center justify-center filter grayscale opacity-40 transition-opacity duration-300">
                                                @if(!empty($badge['icon_path']))
                                                    <img src="{{ asset('storage/assets/badges/' . $badge['icon_path']) }}"
                                                         alt="{{ $badge['name'] }}"
                                                         class="w-full h-full object-contain">
                                                @else
                                                    <i class="fas fa-trophy text-5xl text-gray-400"></i>
                                                @endif

                                                {{-- Lock Icon Overlay --}}
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <div class="bg-gray-800 bg-opacity-80 rounded-full p-2">
                                                        <i class="fas fa-lock text-white text-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Badge Name --}}
                                        <h4 class="text-[10px] font-bold text-gray-700 mb-1 px-0.5 line-clamp-2 leading-tight">{{ $badge['name'] }}</h4>

                                        {{-- Rarity Level --}}
                                        <div class="mb-1.5">
                                            <span class="text-[8px] font-medium" style="color: {{ $badge['rarity_color'] ?? '#6b7280' }};">
                                                {{ $badge['rarity_label'] }}
                                            </span>
                                        </div>

                                        {{-- Progress Bar --}}
                                        <div class="relative h-2 bg-gray-200 rounded-full overflow-hidden mb-1 w-full">
                                            <div class="absolute inset-0 h-full rounded-full transition-all duration-500 bg-gray-400"
                                                 style="width: {{ $badge['progress']['percentage'] }}%;"></div>
                                        </div>

                                        {{-- Progress Percentage --}}
                                        <span class="text-[9px] font-semibold text-gray-600">{{ number_format($badge['progress']['percentage'], 0) }}%</span>
                                    </div>

                                    {{-- Hover View - Progress & Criteria --}}
                                    <div class="absolute inset-0 p-3 flex flex-col items-center justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gray-900 bg-opacity-95 text-white">
                                        {{-- Progress at top --}}
                                        <div class="text-center w-full">
                                            <div class="text-sm font-bold text-yellow-400 mb-2">{{ $badge['progress']['current'] }}/{{ $badge['progress']['target'] }}</div>

                                            {{-- Progress Bar --}}
                                            <div class="relative h-1.5 bg-gray-600 rounded-full overflow-hidden w-full">
                                                <div class="absolute inset-0 h-full rounded-full transition-all duration-500 bg-yellow-400"
                                                     style="width: {{ $badge['progress']['percentage'] }}%;"></div>
                                            </div>
                                        </div>

                                        {{-- Unlock Criteria in the middle - uses flex-grow to fill available space --}}
                                        <div class="text-center w-full flex-grow flex items-center justify-center px-2 py-3">
                                            <p class="text-[10px] text-gray-200 leading-snug">{{ $badge['progress']['criteria_text'] }}</p>
                                        </div>

                                        {{-- Percentage at bottom --}}
                                        <div class="text-center w-full">
                                            <span class="text-xs font-semibold text-yellow-400">{{ number_format($badge['progress']['percentage'], 0) }}%</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">

            {{-- ================================================================ --}}
            {{-- HEADER SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-4 sm:mb-8 relative">
                {{-- Notification Badge (Left Side) --}}
                @if(isset($notifications))
                    <div class="absolute left-0 top-0 sm:left-4 md:left-8">
                        <x-notification-badge :notifications="$notifications" />
                    </div>
                @endif

                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 gradient-header rounded-2xl shadow-lg mb-3 sm:mb-4">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 mb-1 sm:mb-2 px-2">Cadet Dashboard</h1>
                <p class="text-gray-600 text-sm sm:text-lg px-2">Your personal overview and performance metrics</p>

                {{-- Badge Progression Button --}}
                @if(isset($badgeProgress) && count($badgeProgress) > 0)
                    <button
                        type="button"
                        @click="showBadgeBanner = !showBadgeBanner"
                        class="absolute top-0 right-0 sm:top-0 sm:right-4 md:right-8"
                        aria-label="Toggle Badge Progression">
                        <div class="flex items-center space-x-1 sm:space-x-2 bg-white hover:bg-blue-50 border-2 border-blue-500 hover:border-blue-600 text-blue-700 px-2 py-1.5 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl active:scale-95 sm:hover:scale-105 transition-all duration-200 cursor-pointer">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span class="font-bold text-xs sm:text-base whitespace-nowrap">Badge Progression</span>
                        </div>
                    </button>
                @endif
            </div>

            {{-- ================================================================ --}}
            {{-- PROFILE SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-lg rounded-xl sm:rounded-2xl dashboard-card"
                x-data="{ open: false }">
                <div class="section-header cursor-pointer"
                    @click="open = !open">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center mb-1 sm:mb-2">
                                <div class="icon-wrapper bg-blue-100 mr-2 sm:mr-3">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h2 class="text-lg sm:text-2xl font-bold text-gray-900 truncate">Personal Profile</h2>
                            </div>
                            <p class="text-gray-600 ml-8 sm:ml-13 text-xs sm:text-sm">Your profile information and service details</p>
                        </div>
                        <div class="flex items-center ml-2 sm:ml-6 flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400 transform transition-transform duration-300"
                                :class="{ 'rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-8"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="flex flex-col lg:flex-row gap-4 sm:gap-8">
                        {{-- Profile Picture & Badges Section --}}
                        <div class="flex flex-col sm:flex-row lg:flex-col items-center sm:items-start space-y-3 sm:space-y-0 sm:space-x-4 lg:space-x-0 lg:space-y-4">
                            <div class="relative flex-shrink-0">
                                <img src="{{ $cadet?->profile_pic ? asset('storage/' . $cadet->profile_pic) : asset('images/default.png') }}"
                                    alt="Profile Picture"
                                    class="w-32 h-44 sm:w-40 sm:h-56 md:w-56 md:h-80 object-cover rounded-xl sm:rounded-2xl shadow-lg border-2 sm:border-4 border-white">

                                {{-- Best Cadet/Academic Banner --}}
                                @if($cadet->is_best_cadet || $cadet->is_best_academic)
                                    <div class="absolute top-0 left-0 right-0 flex flex-col gap-0.5 sm:gap-1">
                                        @if($cadet->is_best_cadet)
                                            <div class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-white px-3 py-2 sm:px-4 sm:py-3 rounded-md sm:rounded-lg shadow-lg flex items-center justify-center space-x-2 sm:space-x-3 border border-yellow-300 sm:border-2">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <span class="font-bold text-sm">BEST CADET</span>
                                            </div>
                                        @endif
                                        @if($cadet->is_best_academic)
                                            <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white px-3 py-2 sm:px-4 sm:py-3 rounded-md sm:rounded-lg shadow-lg flex items-center justify-center space-x-2 sm:space-x-3 border border-blue-300 sm:border-2">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                </svg>
                                                <span class="font-bold text-sm">BEST ACADEMIC</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Displayed Badges --}}
                            @if($cadet->cadetBadges && $cadet->cadetBadges->count() > 0)
                                @php
                                    // Sort badges by rarity level (descending - highest first)
                                    // Rarity levels: 6=Legendary (Best Cadet/Academic), 5=Platinum, 4=Gold, 3=Silver, 2=Bronze, 1=Standard
                                    $sortedBadges = $cadet->cadetBadges->sortByDesc(function($cadetBadge) {
                                        return $cadetBadge->badge->rarity_level ?? 0;
                                    });
                                @endphp

                                {{-- Mobile: 4 Column Grid Layout (< 640px) - Same style as Desktop --}}
                                <div class="w-full grid grid-cols-2 gap-1.5 sm:hidden">
                                    @foreach($sortedBadges->take(12) as $cadetBadge)
                                        <div class="bg-white rounded-lg p-2 border border-gray-200 hover:border-gray-300 hover:shadow-md transition-all duration-200 flex items-center space-x-2">
                                            @if($cadetBadge->badge->icon_path)
                                                <img src="{{ asset('storage/assets/badges/' . $cadetBadge->badge->icon_path) }}"
                                                    alt="{{ $cadetBadge->badge->name }}"
                                                    class="w-8 h-8 object-contain flex-shrink-0">
                                            @else
                                                <span class="text-2xl flex-shrink-0">🏆</span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-gray-900 truncate">{{ $cadetBadge->badge->name }}</p>
                                                <p class="text-xs text-gray-600" style="color: {{ $cadetBadge->badge->rarity_color ?? '#6b7280' }};">
                                                    {{ $cadetBadge->badge->rarity_label ?? 'Badge' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Desktop/Tablet: Vertical List (≥ 640px) - UNCHANGED --}}
                                <div class="hidden sm:flex flex-1 lg:w-full lg:max-w-[14rem] md:max-w-[16rem] flex-col space-y-1.5 sm:space-y-2 max-h-[224px] md:max-h-[320px] lg:max-h-none overflow-y-auto custom-scrollbar">
                                    @foreach($sortedBadges as $cadetBadge)
                                        <div class="bg-white rounded-lg p-2 sm:p-3 border border-gray-200 hover:border-gray-300 hover:shadow-md transition-all duration-200 flex items-center space-x-2 sm:space-x-3">
                                            @if($cadetBadge->badge->icon_path)
                                                <img src="{{ asset('storage/assets/badges/' . $cadetBadge->badge->icon_path) }}"
                                                    alt="{{ $cadetBadge->badge->name }}"
                                                    class="w-8 h-8 sm:w-10 sm:h-10 object-contain flex-shrink-0">
                                            @else
                                                <span class="text-2xl sm:text-3xl flex-shrink-0">🏆</span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs sm:text-sm font-semibold text-gray-900 truncate">{{ $cadetBadge->badge->name }}</p>
                                                <p class="text-xs text-gray-600" style="color: {{ $cadetBadge->badge->rarity_color ?? '#6b7280' }};">
                                                    {{ $cadetBadge->badge->rarity_label ?? 'Badge' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Profile Information --}}
                        <div class="flex-1 space-y-3 sm:space-y-6">
                            {{-- Rank and Name --}}
                            <div class="info-card">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="icon-wrapper gradient-blue">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Rank & Identity</h3>
                                </div>
                                @php
                                    $prefix = '';
                                    if (trim($cadet?->rank) === 'Lt M') {
                                        $prefix = ' PSSTLDM';
                                    }
                                @endphp
                                <p class="text-lg sm:text-2xl font-bold text-gray-900 break-words">
                                    {{ ($cadet?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') . $prefix }}
                                </p>
                            </div>

                            {{-- Contact Information --}}
                            <div class="info-card">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="icon-wrapper bg-green-100">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Contact Information</h3>
                                </div>
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-green-50 mr-2 sm:mr-3">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs text-gray-500 font-medium">Phone Number</p>
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $cadet?->phone_number ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-blue-50 mr-2 sm:mr-3">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs text-gray-500 font-medium">Email Address</p>
                                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $user?->email ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Personal Information --}}
                            <div class="info-card">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="icon-wrapper bg-pink-100">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Personal Information</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-gray-50 mr-3">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">IC Number</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->ic_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-green-50 mr-3">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Bank Account</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->bank_account_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Military Information --}}
                            <div class="info-card">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="icon-wrapper bg-red-100">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Military Information</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-blue-50 mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Service Number</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->service_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-orange-50 mr-3">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Intake Year</p>
                                            <p class="text-sm font-semibold text-gray-900">
                                                @if($cadet->intake_year)
                                                    {{ $cadet->intake_year }} / Intake-{{ $cadet->intake_year - 2011 }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-indigo-50 mr-3">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">TTP Date</p>
                                            <p class="text-sm font-semibold text-gray-900">
                                                @if(!empty($cadet->ttp_date))
                                                    {{ \Carbon\Carbon::parse($cadet->ttp_date)->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-purple-50 mr-3">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Insurance Number</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->insurance_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Academic Information --}}
                            <div class="info-card">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="icon-wrapper bg-indigo-100">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Academic Information</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-purple-50 mr-3">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Matric Number</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->matric_no ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-indigo-50 mr-3">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Faculty</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->faculty ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-yellow-50 mr-3">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Course</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->course ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-emerald-50 mr-3">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Current CGPA</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->current_cgpa ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Health & Physical Information --}}
                            <div class="info-card">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="icon-wrapper bg-cyan-100">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900">Health & Physical</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-red-50 mr-3">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">BMI</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $cadet->BMI ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-cyan-50 mr-3">
                                            <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Swimming Qualification</p>
                                            <div class="flex items-center">
                                                <span class="text-sm font-semibold text-gray-900 flex-1">
                                                    {{ $cadet->swimming_qualification ?? '-' }}
                                                </span>
                                                @if(!empty($cadet->swimming_pass_date))
                                                    <span class="text-xs text-gray-500">
                                                        ({{ \Carbon\Carbon::parse($cadet->swimming_pass_date)->format('d/m/Y') }})
                                                    </span>
                                                @endif
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
            {{-- MY INTAKE SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card"
                x-data="{ open: false }">
                <div class="section-header cursor-pointer"
                    @click="open = !open">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-cyan mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">My Intake</h2>
                            </div>
                            <p class="text-gray-600 ml-13">View all cadets in your intake with their achievements</p>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-300"
                            :class="{ 'rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div class="p-8"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="overflow-hidden rounded-xl border border-gray-200">
                        <div class="max-h-[500px] overflow-y-auto overflow-x-auto custom-scrollbar">
                            <table class="data-table text-sm">
                                <thead>
                                    <tr>
                                        <th class="text-xs">No.</th>
                                        <th class="text-xs">Service No.</th>
                                        <th class="text-xs">Rank</th>
                                        <th class="text-xs">Name</th>
                                        <th class="text-xs">Position</th>
                                        <th class="text-xs">Rating</th>
                                        <th class="text-xs">Total Points</th>
                                        <th class="text-xs">Badges</th>
                                        <th class="text-xs">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($intakeCadets as $index => $intakeCadet)
                                        <tr>
                                            <td class="font-semibold text-gray-700 text-xs">{{ $index + 1 }}</td>
                                            <td class="text-gray-900 text-xs">{{ $intakeCadet->service_number ?? 'N/A' }}</td>
                                            <td>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $intakeCadet->rank ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="font-semibold text-gray-900 text-xs">{{ $intakeCadet->user->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                    {{ $intakeCadet->position ?? 'Normal Cadet' }}
                                                </span>
                                            </td>
                                            <td class="text-lg">{{ $intakeCadet->performanceRating->rating ?? '⭐☆☆☆☆' }}</td>
                                            <td class="font-bold text-gray-900 text-xs">{{ number_format($intakeCadet->performanceRating->total_points ?? 0, 2) }}</td>
                                            <td>
                                                <div class="flex items-center space-x-1">
                                                    @forelse($intakeCadet->cadetBadges->take(3) as $cadetBadge)
                                                        @if($cadetBadge->badge->icon_path)
                                                            <img src="{{ asset('storage/assets/badges/' . $cadetBadge->badge->icon_path) }}"
                                                                alt="{{ $cadetBadge->badge->name }}"
                                                                title="{{ $cadetBadge->badge->name }}"
                                                                class="badge-icon-mini">
                                                        @else
                                                            <span class="text-lg" title="{{ $cadetBadge->badge->name }}">🏆</span>
                                                        @endif
                                                    @empty
                                                        <span class="text-xs text-gray-400">No badges</span>
                                                    @endforelse
                                                    @if($intakeCadet->cadetBadges->count() > 3)
                                                        <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-1.5 py-0.5 rounded-full">
                                                            +{{ $intakeCadet->cadetBadges->count() - 3 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="pl-4">
                                                <button onclick="openCadetModal({{ $intakeCadet->id }})" class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-4 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                    </svg>
                                                    <p class="text-gray-500 text-lg font-medium">No cadets found in your intake.</p>
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

            {{-- ================================================================ --}}
            {{-- PERFORMANCE METRICS SECTION --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Duty Ranking Card --}}
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">
                    <div class="section-header">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-green mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Duty Ranking</h2>
                        </div>
                        <p class="text-gray-600 ml-13">Your performance ranking among cadets</p>
                    </div>

                    <div class="p-6">
                        {{-- Sort Form --}}
                        <div class="mb-6 flex justify-center">
                            <div class="inline-flex rounded-lg border border-gray-200 bg-gray-50 p-1">
                                <select id="sort_order" class="bg-transparent border-0 text-sm font-medium text-gray-700 focus:ring-0 cursor-pointer">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>🏆 Highest First</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>📊 Lowest First</option>
                                </select>
                            </div>
                        </div>

                        {{-- Leaderboard --}}
                        <div id="duty-ranking-content" class="space-y-4 max-h-[400px] overflow-y-auto custom-scrollbar">
                            @php
                                $maxCount = $dutyCadets->max('daily_duty_count') ?: 1;
                            @endphp

                            @forelse ($dutyCadets as $index => $dutyCadet)
                                @php
                                    $percentage = ($dutyCadet->daily_duty_count / $maxCount) * 100;
                                    if ($percentage < 50) {
                                        $ratio = $percentage / 50;
                                        $r = 255;
                                        $g = (int)(180 * $ratio);
                                    } else {
                                        $ratio = ($percentage - 50) / 50;
                                        $r = (int)(255 * (1 - $ratio));
                                        $g = 180;
                                    }
                                    $bgColor = "rgb($r, $g, 0)";
                                @endphp

                                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="flex-1 w-full">
                                        <div class="text-sm font-medium mb-1 text-center sm:text-left">
                                            #{{ $index + 1 }} - {{ $dutyCadet->user->name ?? '-' }}
                                        </div>

                                        <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                                            <div class="absolute top-0 left-0 h-full rounded-full flex items-center" style="width: {{ $percentage }}%; background-color: {{ $bgColor }};">
                                                <span class="text-white font-semibold text-sm pl-2 whitespace-nowrap">
                                                    {{ $dutyCadet->daily_duty_count }} {{ Str::plural('Day', $dutyCadet->daily_duty_count) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">No cadets available.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Tauliah Countdown Card --}}
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">
                    <div class="section-header">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-purple mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Tauliah Countdown</h2>
                        </div>
                        <p class="text-gray-600 ml-13">Your journey to becoming a commissioned officer</p>
                    </div>

                    <div class="p-8">
                        @php
                            $intakeYear = $cadet->intake_year ?? now()->year;
                            $tauliahDate = \App\Models\ContentSetting::getTauliahDate($intakeYear);
                            $tauliahLocation = \App\Models\ContentSetting::getTauliahLocation();
                            $today = \Carbon\Carbon::today();
                            $daysLeft = $today->diffInDays($tauliahDate, false);
                            $totalPrepDays = 1095;

                            $progress = min(100, max(0, (1 - ($daysLeft / $totalPrepDays)) * 100));
                            $progressDegrees = floor(($progress / 100) * 360);

                            $dynamicColor = match (true) {
                                $progress < 25 => '#3b82f6',
                                $progress < 50 => '#8b5cf6',
                                $progress < 75 => '#ec4899',
                                default => '#f59e0b',
                            };
                        @endphp

                        @if ($daysLeft > 0)
                            <div class="flex flex-col items-center">
                                {{-- Countdown Circle --}}
                                <div class="countdown-circle mb-6"
                                    style="background: conic-gradient({{ $dynamicColor }} {{ $progressDegrees }}deg, #e5e7eb {{ $progressDegrees }}deg);">
                                    <div class="countdown-inner">
                                        <div class="text-6xl font-extrabold text-gray-900">
                                            {{ intval($daysLeft) }}
                                        </div>
                                        <div class="text-gray-600 text-sm font-semibold mt-1">
                                            Days Left
                                        </div>
                                    </div>
                                </div>

                                {{-- Progress Info --}}
                                <div class="w-full max-w-md">
                                    <div class="info-card">
                                        <div class="flex justify-between items-center mb-3">
                                            <span class="text-sm font-medium text-gray-600">Progress</span>
                                            <span class="text-sm font-bold text-gray-900">{{ number_format($progress, 1) }}%</span>
                                        </div>
                                        <div class="progress-container h-3">
                                            <div class="progress-bar" style="width: {{ $progress }}%; background: linear-gradient(90deg, {{ $dynamicColor }}, {{ $dynamicColor }}dd);"></div>
                                        </div>
                                        <div class="mt-4 text-center space-y-2">
                                            <div>
                                                <p class="text-sm text-gray-600">Commissioning Date:</p>
                                                <p class="text-lg font-bold text-gray-900">{{ $tauliahDate->format('d/m/Y') }}</p>
                                            </div>
                                            <div class="pt-2 border-t border-gray-200">
                                                <p class="text-sm text-gray-600">This year's Tauliah ceremony will be held at</p>
                                                <p class="text-base font-bold text-blue-600">{{ $tauliahLocation }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Congratulations Message --}}
                            <div class="flex flex-col items-center text-center space-y-6">
                                <div class="w-24 h-24 gradient-orange rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-gray-900 mb-3">
                                        Congratulations! 🎉
                                    </h3>
                                    <p class="text-xl text-gray-700 mb-2">
                                        You've been promoted to <span class="font-bold text-yellow-600">Lt. Muda!</span>
                                    </p>
                                    <p class="text-gray-600">
                                        Your service, dedication, and leadership are recognized!
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Mobile Bottom Spacer --}}
            <div class="block md:hidden h-20"></div>

            {{-- ================================================================ --}}
            {{-- INTAKE ABSENCE TRACKING SECTION --}}
            {{-- Only visible for CO, Thana, Zayn positions --}}
            {{-- ================================================================ --}}
            @php
                $allowedPositions = ['CO', 'Thana', 'Zayn'];
                $cadetPosition = trim($cadet->position ?? '');
                $canViewAbsence = in_array(strtolower($cadetPosition), array_map('strtolower', $allowedPositions));
            @endphp
            @if($canViewAbsence)
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card" x-data="{ open: false }">
                    <div class="section-header" @click="open = !open" style="cursor: pointer;">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-red mr-3 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    <span id="cadet-absence-section-title">Intake Absence Tracking</span>
                                    @if(isset($absentCadets) && !empty($absentCadets))
                                        <span id="cadet-absence-count-badge" class="ml-3 bg-red-500 text-white text-sm px-3 py-1 rounded-full">
                                            {{ count($absentCadets) }}
                                        </span>
                                    @endif
                                </h3>
                            </div>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <p id="cadet-absence-section-description" class="text-gray-600 ml-13">Track your intake mates requiring absence documentation</p>
                    </div>

                    <div class="p-6"
                        x-show="open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0">

                        {{-- View Toggle --}}
                        <div class="flex bg-gray-100 rounded-lg p-1 gap-1 mb-6">
                            <button
                                id="cadet-pending-view-btn"
                                onclick="toggleCadetAbsenceView('pending')"
                                class="btn-toggle active">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                                Pending
                            </button>
                            <button
                                id="cadet-leaderboard-view-btn"
                                onclick="toggleCadetAbsenceView('leaderboard')"
                                class="btn-toggle">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Absence List
                            </button>
                        </div>

                        {{-- Pending Absence Data --}}
                        <div id="cadet-absence-content" class="space-y-4 max-h-[600px] overflow-y-auto">
                            @if(isset($absentCadets) && !empty($absentCadets))
                                @php
                                    $intakeLabel = isset($cadet->intake_year)
                                        ? $cadet->intake_year . ' / Intake-' . ($cadet->intake_year - 2011)
                                        : 'Your Intake';
                                @endphp

                                <div class="border border-red-200 rounded-lg overflow-hidden">
                                    <div class="bg-red-50 px-4 py-3 border-b border-red-200">
                                        <h4 class="font-semibold text-red-800 flex items-center">
                                            <i class="fas fa-users mr-2"></i>
                                            {{ $intakeLabel }}
                                            <span class="ml-2 bg-red-200 text-red-800 px-2 py-1 rounded-full text-xs">
                                                {{ count($absentCadets) }} {{ Str::plural('cadet', count($absentCadets)) }}
                                            </span>
                                        </h4>
                                    </div>
                                    <div class="p-4 space-y-3">
                                        @foreach($absentCadets as $cadetData)
                                            <div class="border border-orange-200 rounded-lg overflow-hidden bg-white">
                                                <button onclick="toggleAbsenceDropdown({{ $cadetData->id }})" class="w-full flex justify-between items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="text-left">
                                                            <p class="font-semibold text-gray-900">{{ $cadetData->name }}</p>
                                                            <p class="text-sm text-gray-600">Service: {{ $cadetData->service_number ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-3">
                                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                            {{ count($cadetData->pending_absences) }} {{ Str::plural('absence', count($cadetData->pending_absences)) }}
                                                        </span>
                                                        <svg id="absence-icon-{{ $cadetData->id }}" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </div>
                                                </button>

                                                <div id="absence-dropdown-{{ $cadetData->id }}" class="hidden border-t border-orange-200">
                                                    <div class="p-4 space-y-3">
                                                        <h5 class="font-medium text-gray-800 mb-3 flex items-center">
                                                            <i class="fas fa-list mr-2 text-red-500"></i>
                                                            Missing Documentation for:
                                                        </h5>

                                                        @foreach($cadetData->pending_absences as $absence)
                                                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2">
                                                                    <div class="flex-1">
                                                                        <h6 class="font-semibold text-red-900">{{ $absence->training_title }}</h6>
                                                                        <div class="text-sm text-red-700 space-y-1 mt-2">
                                                                            <div class="flex items-center">
                                                                                <i class="fas fa-calendar w-4 text-red-500 mr-2"></i>
                                                                                <span>{{ $absence->training_date }}</span>
                                                                            </div>
                                                                            <div class="flex items-center">
                                                                                <i class="fas fa-map-marker-alt w-4 text-red-500 mr-2"></i>
                                                                                <span>{{ $absence->training_location }}</span>
                                                                            </div>
                                                                            <div class="flex items-center">
                                                                                <i class="fas fa-exclamation-triangle w-4 text-orange-500 mr-2"></i>
                                                                                <span class="text-xs">Missing: {{ $absence->missing_items }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-medium self-start sm:self-auto">
                                                                        Pending
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="mb-6">
                                        <svg class="w-20 h-20 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-semibold text-gray-600 mb-3">All Clear!</h3>
                                    <p class="text-gray-500 text-lg">No pending absence reasons found.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Absence Leaderboard --}}
                        <div id="cadet-absence-leaderboard-content" class="hidden space-y-4 max-h-[600px] overflow-y-auto">
                            @if(isset($absenceLeaderboard) && !empty($absenceLeaderboard))
                                @php
                                    $intakeLabel = isset($cadet->intake_year)
                                        ? $cadet->intake_year . ' / Intake-' . ($cadet->intake_year - 2011)
                                        : 'Your Intake';
                                @endphp

                                <div class="border border-yellow-200 rounded-lg overflow-hidden">
                                    <div class="bg-yellow-50 px-4 py-3 border-b border-yellow-200">
                                        <h4 class="font-semibold text-yellow-800 flex items-center">
                                            <i class="fas fa-users mr-2"></i>
                                            {{ $intakeLabel }}
                                            <span class="ml-2 bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                                {{ count($absenceLeaderboard) }} {{ Str::plural('cadet', count($absenceLeaderboard)) }}
                                            </span>
                                        </h4>
                                    </div>
                                    <div class="p-4 space-y-3">
                                        @foreach($absenceLeaderboard as $index => $cadetData)
                                            @php
                                                $attended = $cadetData->total_trainings - $cadetData->absence_count;
                                            @endphp
                                            <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1 w-full">
                                                    <div class="text-sm font-medium mb-1 text-center sm:text-left">
                                                        #{{ $index + 1 }} - {{ $cadetData->cadet_name }}
                                                    </div>
                                                    <div class="text-center sm:text-left flex flex-col sm:flex-row gap-1 sm:gap-0">
                                                        <span class="text-sm font-semibold text-gray-800">
                                                            Training Attended: {{ $attended }} / {{ $cadetData->total_trainings }}
                                                        </span>
                                                        <span class="text-sm font-semibold text-red-600 sm:ml-4">
                                                            Total Absence: {{ $cadetData->absence_count }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="mb-4">
                                        <svg class="w-16 h-16 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Perfect Attendance!</h3>
                                    <p class="text-gray-500">No training absences recorded.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- Mobile Bottom Spacer --}}
            <div class="block md:hidden h-20"></div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CADET DETAILS MODAL --}}
    {{-- ================================================================ --}}
    <div id="cadetModal" class="modal-overlay fixed inset-0 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-6 border w-11/12 max-w-5xl modal-content my-10">
            {{-- Modal Header --}}
            <div class="flex justify-between items-center pb-4 border-b-2 border-gray-200">
                <div class="flex items-center">
                    <div class="icon-wrapper gradient-blue mr-3">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">Cadet Details</h3>
                </div>
                <button onclick="closeCadetModal()" class="text-gray-400 hover:text-gray-600 transition-colors p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Modal Body --}}
            <div id="cadetModalContent" class="mt-6">
                {{-- Loading spinner --}}
                <div class="flex justify-center items-center py-16">
                    <div class="relative">
                        <div class="w-16 h-16 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                        <p class="text-center text-gray-600 mt-4 font-medium">Loading cadet details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ================================================================
            // SCROLL DETECTION FOR DUTY RANKING
            // ================================================================
            function checkScrollableContent() {
                // Check Duty Ranking
                const dutyContainer = document.getElementById('duty-ranking-content');
                const dutyWrapper = dutyContainer?.closest('.duty-ranking-wrapper');
                
                if (dutyContainer && dutyWrapper) {
                    if (dutyContainer.scrollHeight > dutyContainer.clientHeight) {
                        dutyWrapper.classList.add('has-scroll');
                    } else {
                        dutyWrapper.classList.remove('has-scroll');
                    }
                }
            }

            // Check on load and after updates
            checkScrollableContent();
            window.addEventListener('resize', checkScrollableContent);

            // ================================================================
            // CADET ABSENCE VIEW TOGGLE
            // ================================================================
            function toggleCadetAbsenceView(view) {
                const pendingBtn = document.getElementById('cadet-pending-view-btn');
                const leaderboardBtn = document.getElementById('cadet-leaderboard-view-btn');
                const pendingContent = document.getElementById('cadet-absence-content');
                const leaderboardContent = document.getElementById('cadet-absence-leaderboard-content');
                const sectionTitle = document.getElementById('cadet-absence-section-title');
                const sectionDescription = document.getElementById('cadet-absence-section-description');
                const countBadge = document.getElementById('cadet-absence-count-badge');
                
                if (view === 'pending') {
                    pendingBtn.classList.add('active');
                    leaderboardBtn.classList.remove('active');
                    
                    pendingContent.classList.remove('hidden');
                    leaderboardContent.classList.add('hidden');
                    
                    sectionTitle.textContent = 'Intake Absence Tracking';
                    sectionDescription.textContent = 'Track your intake mates requiring absence documentation';
                    if (countBadge) countBadge.classList.remove('hidden');
                    
                } else if (view === 'leaderboard') {
                    leaderboardBtn.classList.add('active');
                    pendingBtn.classList.remove('active');
                    
                    leaderboardContent.classList.remove('hidden');
                    pendingContent.classList.add('hidden');
                    
                    sectionTitle.textContent = 'Intake Absence Summary';
                    sectionDescription.textContent = 'Overview of intake mates requiring attendance improvement';
                    if (countBadge) countBadge.classList.add('hidden');
                }
            }

            window.toggleCadetAbsenceView = toggleCadetAbsenceView;

            // ================================================================
            // DUTY RANKING SORT
            // ================================================================
            const sortSelect = document.getElementById('sort_order');
            const contentContainer = document.getElementById('duty-ranking-content');

            if (sortSelect && contentContainer) {
                sortSelect.addEventListener('change', function() {
                    const sortOrder = this.value;
                    
                    contentContainer.innerHTML = '<div class="text-center text-gray-500 py-4">Loading...</div>';

                    fetch(window.location.pathname + '?sort_order=' + sortOrder, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        contentContainer.innerHTML = data.html;
                        // Check scroll after content update
                        setTimeout(checkScrollableContent, 100);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        contentContainer.innerHTML = '<div class="text-center text-red-500 py-4">Error loading data. Please try again.</div>';
                    });
                });
            }

            // ================================================================
            // ABSENCE DROPDOWN TOGGLE
            // ================================================================
            window.toggleAbsenceDropdown = function(cadetId) {
                const dropdown = document.getElementById('absence-dropdown-' + cadetId);
                const icon = document.getElementById('absence-icon-' + cadetId);
                
                if (dropdown && icon) {
                    if (dropdown.classList.contains('hidden')) {
                        dropdown.classList.remove('hidden');
                        icon.style.transform = 'rotate(180deg)';
                    } else {
                        dropdown.classList.add('hidden');
                        icon.style.transform = 'rotate(0deg)';
                    }
                }
            };
        });

        // ================================================================
        // CADET MODAL FUNCTIONS
        // ================================================================
        function openCadetModal(cadetId) {
            const modal = document.getElementById('cadetModal');
            const modalContent = document.getElementById('cadetModalContent');
            
            modal.classList.remove('hidden');
            
            // Show loading spinner
            modalContent.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                </div>
            `;
            
            // Fetch cadet details
            fetch(`/cadet/cadet/${cadetId}/details`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayCadetDetails(data.cadet);
                    } else {
                        modalContent.innerHTML = '<p class="text-center text-red-500">Error loading cadet details.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.innerHTML = '<p class="text-center text-red-500">Error loading cadet details.</p>';
                });
        }

        function closeCadetModal() {
            document.getElementById('cadetModal').classList.add('hidden');
        }

        function displayCadetDetails(cadet) {
            const modalContent = document.getElementById('cadetModalContent');
            
            let badgesHtml = '';
            if (cadet.badges && cadet.badges.length > 0) {
                badgesHtml = cadet.badges.map(badge => `
                    <div class="bg-white border-2 border-gray-200 rounded-lg p-4 hover:shadow-lg transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            ${badge.icon_path ?
                                `<img src="/storage/assets/badges/${badge.icon_path}" alt="${badge.name}" class="w-12 h-12 object-contain">` :
                                '<span class="text-4xl">🏆</span>'
                            }
                            <div class="flex-1">
                                <h5 class="font-semibold text-gray-900">${badge.name}</h5>
                                <p class="text-xs text-gray-600 mt-1">${badge.description}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs font-medium" style="color: ${badge.rarity_color};">${badge.rarity_label}</span>
                                    <span class="text-xs text-gray-500">Unlocked: ${badge.unlocked_at}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                badgesHtml = '<p class="text-center text-gray-500 py-8">No badges unlocked yet.</p>';
            }
            
            // Build recognition banners HTML
            let recognitionBannersHtml = '';
            if (cadet.is_best_cadet || cadet.is_best_academic) {
                recognitionBannersHtml = '<div class="flex flex-wrap gap-2 mb-3">';
                if (cadet.is_best_cadet) {
                    recognitionBannersHtml += `
                        <div class="bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-white px-3 py-1.5 rounded-lg shadow-lg flex items-center space-x-2 border-2 border-yellow-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="font-bold text-sm">BEST CADET</span>
                        </div>
                    `;
                }
                if (cadet.is_best_academic) {
                    recognitionBannersHtml += `
                        <div class="bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 text-white px-3 py-1.5 rounded-lg shadow-lg flex items-center space-x-2 border-2 border-blue-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            <span class="font-bold text-sm">BEST ACADEMIC</span>
                        </div>
                    `;
                }
                recognitionBannersHtml += '</div>';
            }

            modalContent.innerHTML = `
                <div class="space-y-6">
                    {{-- Profile Section --}}
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-shrink-0">
                            <img src="${cadet.profile_pic}"
                                alt="${cadet.name}"
                                class="w-32 h-40 md:w-40 md:h-52 object-cover border rounded-md">
                        </div>

                        <div class="flex-1 space-y-4">
                            ${recognitionBannersHtml}
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">${cadet.rank} ${cadet.name}${cadet.rank === 'Lt M' ? ' PSSTLDM' : ''}</h4>
                                <p class="text-sm text-gray-600">${cadet.position}</p>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                <div>
                                    <span class="font-medium text-gray-700">Service Number:</span>
                                    <span class="text-gray-900">${cadet.service_number}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Matric Number:</span>
                                    <span class="text-gray-900">${cadet.matric_no}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Faculty:</span>
                                    <span class="text-gray-900">${cadet.faculty}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Course:</span>
                                    <span class="text-gray-900">${cadet.course}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Email:</span>
                                    <span class="text-gray-900">${cadet.email}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Phone:</span>
                                    <span class="text-gray-900">${cadet.phone_number}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Performance Section --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                        <h5 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Performance Rating
                        </h5>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-4 flex items-center justify-center">
                                <div class="text-center">
                                    <p class="text-4xl mb-2">${cadet.rating}</p>
                                    <p class="text-2xl font-bold text-gray-900">${parseFloat(cadet.total_points).toFixed(2)}</p>
                                    <p class="text-sm text-gray-600">Total Points</p>
                                </div>
                            </div>
                            
                            <div class="bg-white rounded-lg p-4 space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Attendance:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.attendance_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Quiz:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.quiz_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Learning Progress:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.learning_progress_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Duty:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.duty_points).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-700">Academic:</span>
                                    <span class="font-semibold text-gray-900">${parseFloat(cadet.academic_points).toFixed(2)}</span>
                                </div>
                                ${(['CO', 'Thana', 'Zayn'].includes(cadet.position)) ? `
                                <div class="flex justify-between pt-2 border-t border-gray-200">
                                    <span class="text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        Bonus Points:
                                    </span>
                                    <span class="font-bold text-yellow-600">${parseFloat(cadet.position_bonus_points).toFixed(2)}</span>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>

                    {{-- Badges Section --}}
                    <div>
                        <h5 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            Displayed Badges (${cadet.badges ? cadet.badges.length : 0})
                        </h5>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                            ${badgesHtml}
                        </div>
                    </div>
                </div>
            `;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('cadetModal');
            if (event.target === modal) {
                closeCadetModal();
            }
        }
    </script>

    </div>
</div>

</x-app-layout>
