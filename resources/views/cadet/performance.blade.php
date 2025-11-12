<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance') }}
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

    .btn-toggle.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }

    .btn-toggle:not(.active) {
        background: transparent;
        color: #64748b;
    }

    .btn-toggle:not(.active):hover {
        background: #f1f5f9;
        color: #334155;
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

    @media (max-width: 640px) {
        .dashboard-card:hover {
            transform: none !important;
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 mb-1 sm:mb-2 px-2">Performance & Achievements</h1>
                <p class="text-gray-600 text-sm sm:text-lg px-2">Track your progress, rankings, and earned badges</p>
            </div>

            {{-- ================================================================ --}}
            {{-- PERFORMANCE OVERVIEW SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl sm:rounded-2xl shadow-custom overflow-hidden"
                x-data="{ performanceOpen: true }">
                <div class="section-header cursor-pointer"
                    @click="performanceOpen = !performanceOpen">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center mb-1 sm:mb-2">
                                <div class="icon-wrapper gradient-blue mr-2 sm:mr-3">
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <h2 class="text-lg sm:text-2xl font-bold text-gray-900 truncate">Performance Overview</h2>
                            </div>
                            <p class="text-gray-600 text-xs sm:text-base ml-9 sm:ml-13 hidden sm:block">View your performance ratings and progress over time</p>
                        </div>
                        <div class="flex items-center ml-2 sm:ml-6 flex-shrink-0">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-400 transform transition-transform duration-300"
                                :class="{ 'rotate-180': performanceOpen }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="p-4 sm:p-8"
                    x-show="performanceOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-y-0"
                    x-transition:leave-end="opacity-0 transform -translate-y-2">
                    {{-- ================================================================ --}}
                    {{-- POINT DISTRIBUTION OVERVIEW --}}
                    {{-- ================================================================ --}}
                    @php
                        $performanceRating = $performanceRatings->first();
                        $attendancePoints = $performanceRating->attendance_points ?? 0;
                        $quizPoints = $performanceRating->quiz_points ?? 0;
                        $learningPoints = $performanceRating->learning_progress_points ?? 0;
                        $dutyPoints = $performanceRating->duty_points ?? 0;
                        $academicPoints = $performanceRating->academic_points ?? 0;
                        $bonusPoints = $performanceRating->position_bonus_points ?? 0;

                        $totalPoints = $attendancePoints + $quizPoints + $learningPoints + $dutyPoints + $academicPoints + $bonusPoints;

                        $attendancePercent = $totalPoints > 0 ? ($attendancePoints / $totalPoints) * 100 : 0;
                        $quizPercent = $totalPoints > 0 ? ($quizPoints / $totalPoints) * 100 : 0;
                        $learningPercent = $totalPoints > 0 ? ($learningPoints / $totalPoints) * 100 : 0;
                        $dutyPercent = $totalPoints > 0 ? ($dutyPoints / $totalPoints) * 100 : 0;
                        $academicPercent = $totalPoints > 0 ? ($academicPoints / $totalPoints) * 100 : 0;
                        $bonusPercent = $totalPoints > 0 ? ($bonusPoints / $totalPoints) * 100 : 0;
                    @endphp

                    <div class="info-card bg-gradient-to-br from-purple-50 to-pink-50 border-purple-200 mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                            Point Distribution Overview
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            {{-- Progress Bars --}}
                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm font-medium mb-2">
                                        <span class="text-blue-700">Attendance</span>
                                        <span class="text-gray-900">{{ number_format($attendancePoints, 2) }} pts ({{ number_format($attendancePercent, 1) }}%)</span>
                                    </div>
                                    <div class="progress-container h-6">
                                        <div class="progress-bar gradient-blue" style="width: {{ $attendancePercent }}%">
                                            <span class="text-white text-xs font-semibold px-3"></span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-sm font-medium mb-2">
                                        <span class="text-green-700">Quiz</span>
                                        <span class="text-gray-900">{{ number_format($quizPoints, 2) }} pts ({{ number_format($quizPercent, 1) }}%)</span>
                                    </div>
                                    <div class="progress-container h-6">
                                        <div class="progress-bar gradient-green" style="width: {{ $quizPercent }}%">
                                            <span class="text-white text-xs font-semibold px-3"></span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-sm font-medium mb-2">
                                        <span class="text-cyan-700">Learning Progress</span>
                                        <span class="text-gray-900">{{ number_format($learningPoints, 2) }} pts ({{ number_format($learningPercent, 1) }}%)</span>
                                    </div>
                                    <div class="progress-container h-6">
                                        <div class="progress-bar gradient-cyan" style="width: {{ $learningPercent }}%">
                                            <span class="text-white text-xs font-semibold px-3"></span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-sm font-medium mb-2">
                                        <span class="text-purple-700">Duty</span>
                                        <span class="text-gray-900">{{ number_format($dutyPoints, 2) }} pts ({{ number_format($dutyPercent, 1) }}%)</span>
                                    </div>
                                    <div class="progress-container h-6">
                                        <div class="progress-bar gradient-purple" style="width: {{ $dutyPercent }}%">
                                            <span class="text-white text-xs font-semibold px-3"></span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-sm font-medium mb-2">
                                        <span class="text-orange-700">Academic</span>
                                        <span class="text-gray-900">{{ number_format($academicPoints, 2) }} pts ({{ number_format($academicPercent, 1) }}%)</span>
                                    </div>
                                    <div class="progress-container h-6">
                                        <div class="progress-bar gradient-orange" style="width: {{ $academicPercent }}%">
                                            <span class="text-white text-xs font-semibold px-3"></span>
                                        </div>
                                    </div>
                                </div>

                                @if($bonusPoints > 0)
                                <div>
                                    <div class="flex justify-between text-sm font-medium mb-2">
                                        <span class="text-yellow-700 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            Position Bonus
                                        </span>
                                        <span class="text-gray-900 font-bold">{{ number_format($bonusPoints, 2) }} pts ({{ number_format($bonusPercent, 1) }}%)</span>
                                    </div>
                                    <div class="progress-container h-6">
                                        <div class="progress-bar bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600" style="width: {{ $bonusPercent }}%">
                                            <span class="text-white text-xs font-semibold px-3"></span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            {{-- Summary Stats --}}
                            <div class="flex items-center justify-center">
                                <div class="text-center">
                                    <div class="relative inline-block">
                                        <svg class="w-64 h-64 transform -rotate-90">
                                            @php
                                                $categories = [
                                                    ['percent' => $attendancePercent, 'color' => '#3b82f6'],
                                                    ['percent' => $quizPercent, 'color' => '#10b981'],
                                                    ['percent' => $learningPercent, 'color' => '#06b6d4'],
                                                    ['percent' => $dutyPercent, 'color' => '#8b5cf6'],
                                                    ['percent' => $academicPercent, 'color' => '#f59e0b'],
                                                    ['percent' => $bonusPercent, 'color' => '#eab308'],
                                                ];

                                                $radius = 90;
                                                $circumference = 2 * pi() * $radius;
                                                $currentOffset = 0;
                                            @endphp

                                            @foreach($categories as $category)
                                                @if($category['percent'] > 0)
                                                    @php
                                                        $strokeDasharray = ($category['percent'] / 100) * $circumference;
                                                        $strokeDashoffset = -$currentOffset;
                                                        $currentOffset += $strokeDasharray;
                                                    @endphp
                                                    <circle cx="128" cy="128" r="{{ $radius }}"
                                                        stroke="{{ $category['color'] }}"
                                                        stroke-width="32"
                                                        fill="none"
                                                        stroke-dasharray="{{ $strokeDasharray }} {{ $circumference }}"
                                                        stroke-dashoffset="{{ $strokeDashoffset }}"
                                                        class="transition-all duration-1000"/>
                                                @endif
                                            @endforeach
                                        </svg>

                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="text-center">
                                                <div class="text-4xl font-extrabold text-gray-900">{{ number_format($totalPoints, 0) }}</div>
                                                <div class="text-sm text-gray-600 font-medium">Total Points</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- USER PERFORMANCE SUMMARY --}}
                    {{-- ================================================================ --}}
                    <div class="info-card bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Your Performance Summary
                        </h3>

                        <div class="info-grid">
                            <div class="info-item">
                                <div class="icon-wrapper-sm bg-blue-100 mr-4">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-600">Total Points</div>
                                    <div class="text-3xl font-bold text-blue-600">{{ number_format($userTotalPoints, 0) }}</div>
                                    <div class="text-xs text-gray-500 mt-1">Out of 800 possible points</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="icon-wrapper-sm bg-yellow-100 mr-4">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-600">Overall Rating</div>
                                    <div class="flex items-center mt-1">
                                        @php
                                            $stars = substr_count($userOverallRating, '⭐');
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-6 h-6 {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $stars }} out of 5 stars</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- OVERALL PERFORMANCE LEADERBOARD --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-2xl shadow-custom overflow-hidden">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-orange mr-3">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Overall Performance</h2>
                    </div>
                    <p class="text-gray-600 ml-13">See how you rank against other cadets</p>
                </div>

                <div class="p-8">

                    {{-- ================================================================ --}}
                    {{-- LEADERBOARD DATA --}}
                    {{-- ================================================================ --}}
                    @php
                        $userEntry = null;
                        $userRank = null;
                        $showUserAtBottom = false;
                        
                        foreach($leaderboards['overall'] as $index => $entry) {
                            if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                $userEntry = $entry;
                                $userRank = $index + 1;
                                if($index >= 10) {
                                    $showUserAtBottom = true;
                                }
                                break;
                            }
                        }
                    @endphp
                    
                    {{-- ================================================================ --}}
                    {{-- LEADERBOARD LIST --}}
                    {{-- ================================================================ --}}
                    <div class="space-y-2 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($leaderboards['overall'] as $index => $entry)
                            @php
                                $rank = $index + 1;
                                $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                
                                if($rank == 1) {
                                    $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                    $rankBg = 'bg-yellow-500';
                                    $medalIcon = '🥇';
                                } elseif($rank == 2) {
                                    $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                    $rankBg = 'bg-gray-400';
                                    $medalIcon = '🥈';
                                } elseif($rank == 3) {
                                    $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                    $rankBg = 'bg-orange-500';
                                    $medalIcon = '🥉';
                                } else {
                                    $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                    $rankBg = 'bg-gray-500';
                                    $medalIcon = '';
                                }
                            @endphp
                            
                            @if(!$showUserAtBottom || !$isUser)
                                <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                            {{ $rank }}
                                        </div>
                                        @if($medalIcon)
                                            <span class="text-2xl mr-2">{{ $medalIcon }}</span>
                                        @endif
                                        <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }}">
                                            {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        @if($isUser)
                                            <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full">You</span>
                                        @endif
                                    </div>
                                    <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }}">{{ number_format($entry['score'], 0) }} pts</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    {{-- ================================================================ --}}
                    {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                    {{-- ================================================================ --}}
                    @if($showUserAtBottom && $userEntry)
                        <div class="mt-3 pt-3 border-t-2 border-gray-300">
                            <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                <div class="flex items-center flex-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                        {{ $userRank }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                    </span>
                                    <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full">You</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ number_format($userEntry['score'], 0) }} pts</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ATTENDANCE & DUTY LEADERBOARDS --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                {{-- ================================================================ --}}
                {{-- ATTENDANCE LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="dashboard-card bg-white rounded-2xl shadow-custom overflow-hidden">
                    <div class="section-header">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-blue mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Attendance</h2>
                        </div>
                        <p class="text-gray-600 ml-13">Track attendance performance rankings</p>
                    </div>

                    <div class="p-8">
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['attendance'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['attendance'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ number_format($entry['score'], 0) }} pts</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ number_format($userEntry['score'], 0) }} pts</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================================================================ --}}
                {{-- DUTY COUNT LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="dashboard-card bg-white rounded-2xl shadow-custom overflow-hidden">
                    <div class="section-header">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-purple mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Duty Count</h2>
                        </div>
                        <p class="text-gray-600 ml-13">Track duty participation rankings</p>
                    </div>

                    <div class="p-8">
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['duty'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['duty'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ $entry['score'] }} duties</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ $userEntry['score'] }} duties</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- QUIZ & LEARNING LEADERBOARDS --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                {{-- ================================================================ --}}
                {{-- QUIZ OVERALL LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="dashboard-card bg-white rounded-2xl shadow-custom overflow-hidden">
                    <div class="section-header">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-green mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Quiz Overall</h2>
                        </div>
                        <p class="text-gray-600 ml-13">Track quiz performance rankings</p>
                    </div>

                    <div class="p-8">
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['quiz_overall'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['quiz_overall'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ $entry['score'] }}%</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ $userEntry['score'] }}%</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================================================================ --}}
                {{-- LEARNING PROGRESS LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="dashboard-card bg-white rounded-2xl shadow-custom overflow-hidden">
                    <div class="section-header">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-cyan mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Learning Progress</h2>
                        </div>
                        <p class="text-gray-600 ml-13">Track learning progress rankings</p>
                    </div>

                    <div class="p-8">
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['learning'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['learning'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ $entry['score'] }}%</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ $userEntry['score'] }}%</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- QUIZ BY CATEGORY LEADERBOARD --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-2xl shadow-custom overflow-hidden mb-6">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-red mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Quiz by Category</h2>
                    </div>
                    <p class="text-gray-600 ml-13">Track performance across different quiz categories</p>
                </div>

                <div class="p-8">
                    
                    {{-- ================================================================ --}}
                    {{-- CATEGORY LEADERBOARDS GRID --}}
                    {{-- ================================================================ --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($leaderboards['quiz_categories'] as $categoryName => $categoryLeaderboard)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-300">{{ $categoryName }}</h4>
                                <div class="space-y-1 max-h-[300px] overflow-y-auto pr-1 custom-scrollbar">
                                    @foreach($categoryLeaderboard as $index => $entry)
                                        @php
                                            $rank = $index + 1;
                                            $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                            
                                            if($rank == 1) {
                                                $bgColor = 'bg-gradient-to-r from-yellow-50 to-yellow-25 border border-yellow-300';
                                                $medalIcon = '🥇';
                                            } elseif($rank == 2) {
                                                $bgColor = 'bg-gradient-to-r from-gray-100 to-gray-50 border border-gray-300';
                                                $medalIcon = '🥈';
                                            } elseif($rank == 3) {
                                                $bgColor = 'bg-gradient-to-r from-orange-100 to-orange-50 border border-orange-300';
                                                $medalIcon = '🥉';
                                            } else {
                                                $bgColor = $isUser ? 'bg-blue-50 border border-blue-300' : 'bg-white border border-gray-100';
                                                $medalIcon = '';
                                            }
                                        @endphp
                                        
                                        <div class="flex items-center justify-between p-2 {{ $bgColor }} rounded {{ $isUser ? 'ring-1 ring-blue-400' : '' }}">
                                            <div class="flex items-center flex-1 min-w-0">
                                                <span class="text-xs font-medium text-gray-600 w-5 flex-shrink-0">{{ $rank }}</span>
                                                @if($medalIcon)
                                                    <span class="text-sm mr-1 flex-shrink-0">{{ $medalIcon }}</span>
                                                @endif
                                                <span class="text-xs font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                    {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown' }}
                                                </span>
                                                @if($isUser)
                                                    <span class="ml-1 px-1.5 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap flex-shrink-0">You</span>
                                                @endif
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 ml-2 whitespace-nowrap flex-shrink-0">{{ $entry['score'] }}%</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ACHIEVEMENT BADGES SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-2xl shadow-custom overflow-visible">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-purple mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Achievement Badges</h2>
                    </div>
                    <div class="ml-13 space-y-2">
                        <p class="text-gray-600">Hover over badges to see details. Click unlocked badges to display/hide them on your profile.</p>
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center px-3 py-1.5 bg-blue-50 border border-blue-200 rounded-lg">
                                <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-blue-800">
                                    <span id="badge-counter">{{ count($badgesData['display']) }}</span>/12 badges displayed
                                </span>
                            </div>
                            <span class="text-xs text-gray-500 italic">Maximum 12 badges can be displayed at a time</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 lg:p-8">
                    {{-- ================================================================ --}}
                    {{-- BADGE CATEGORIZATION DATA --}}
                    {{-- ================================================================ --}}
                    @php
                        // Group badges by category
                        $badgesByCategory = [
                            'overall' => ['unlocked' => [], 'unlockable' => []],
                            'attendance' => ['unlocked' => [], 'unlockable' => []],
                            'quiz' => ['unlocked' => [], 'unlockable' => []],
                            'learning' => ['unlocked' => [], 'unlockable' => []],
                            'duty' => ['unlocked' => [], 'unlockable' => []],
                            'academic' => ['unlocked' => [], 'unlockable' => []],
                        ];
                        
                        foreach($badgesData['unlocked'] as $unlockedBadge) {
                            $category = $unlockedBadge['badge']->category;
                            if(isset($badgesByCategory[$category])) {
                                $badgesByCategory[$category]['unlocked'][] = $unlockedBadge;
                            }
                        }
                        
                        foreach($badgesData['unlockable'] as $badge) {
                            $category = $badge->category;
                            if(isset($badgesByCategory[$category])) {
                                $badgesByCategory[$category]['unlockable'][] = $badge;
                            }
                        }
                        
                        $categoryNames = [
                            'overall' => 'Overall Performance',
                            'attendance' => 'Attendance',
                            'quiz' => 'Quiz Performance',
                            'learning' => 'Learning Progress',
                            'duty' => 'Duty',
                            'academic' => 'Academic Excellence',
                        ];
                        
                        $categoryIcons = [
                            'overall' => 'fa-star',
                            'attendance' => 'fa-calendar-check',
                            'quiz' => 'fa-brain',
                            'learning' => 'fa-book-open',
                            'duty' => 'fa-clipboard-check',
                            'academic' => 'fa-graduation-cap',
                        ];
                        
                        // Count total unlocked badges
                        $totalUnlocked = count($badgesData['unlocked']);
                    @endphp
                    
                    {{-- ================================================================ --}}
                    {{-- UNLOCKED BADGES SECTION --}}
                    {{-- ================================================================ --}}
                    @if($totalUnlocked > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <div class="w-1 h-5 bg-green-600 mr-2 rounded"></div>
                                Unlocked Badges
                                <span class="ml-2 px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">{{ $totalUnlocked }}</span>
                            </h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                                @foreach($badgesData['unlocked'] as $unlockedBadge)
                                    <div class="badge-card badge-unlocked group relative bg-gradient-to-br from-white to-gray-50 border-2 {{ $unlockedBadge['is_displayed'] ? 'border-green-400 shadow-lg' : 'border-gray-200' }} rounded-xl p-4 text-center cursor-pointer"
                                        onclick="toggleBadgeDisplay({{ $unlockedBadge['badge']->id }})"
                                        data-badge-id="{{ $unlockedBadge['badge']->id }}">

                                        {{-- Badge Icon/Image --}}
                                        <div class="flex justify-center mb-2">
                                            <div class="relative w-28 h-28 flex items-center justify-center">
                                                @if($unlockedBadge['badge']->hasImageIcon())
                                                    <img src="{{ $unlockedBadge['badge']->icon_url }}"
                                                        alt="{{ $unlockedBadge['badge']->name }}"
                                                        class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-110">
                                                @else
                                                    <i class="{{ $unlockedBadge['badge']->icon }} text-6xl text-yellow-500 transition-transform duration-300 group-hover:scale-110"></i>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Badge Name --}}
                                        <h4 class="text-sm font-bold text-gray-900 mb-0.5 px-1">{{ $unlockedBadge['badge']->name }}</h4>

                                        {{-- Rarity Level --}}
                                        <div class="mb-1">
                                            <span class="text-xs font-medium" style="color: {{ $unlockedBadge['badge']->rarity_color }};">
                                                {{ $unlockedBadge['badge']->rarity_label }}
                                            </span>
                                        </div>

                                        {{-- Display Status --}}
                                        <span class="badge-status inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $unlockedBadge['is_displayed'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            <i class="fas fa-{{ $unlockedBadge['is_displayed'] ? 'eye' : 'eye-slash' }} mr-1"></i>
                                            {{ $unlockedBadge['is_displayed'] ? 'Displayed' : 'Hidden' }}
                                        </span>
                                        
                                        {{-- Hover Tooltip --}}
                                        <div class="badge-tooltip absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-64 bg-gray-900 text-white text-xs rounded-lg p-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 pointer-events-none">
                                            <div class="font-semibold mb-2 text-sm text-center">{{ $unlockedBadge['badge']->name }}</div>
                                            <div class="mb-2 text-gray-300 text-center">{{ $unlockedBadge['badge']->description }}</div>
                                            <div class="pt-2 border-t border-gray-700 space-y-1">
                                                <div class="flex items-center text-gray-400">
                                                    <i class="fas fa-unlock-alt mr-2"></i>
                                                    <span class="text-xs">{{ $unlockedBadge['badge']->unlock_criteria }}</span>
                                                </div>
                                                <div class="flex items-center justify-center text-green-400">
                                                    <i class="fas fa-calendar-check mr-2"></i>
                                                    <span class="text-xs">Unlocked: {{ $unlockedBadge['unlocked_at']->format('M d, Y') }}</span>
                                                </div>
                                                <div class="flex items-center justify-center text-yellow-400">
                                                    <i class="fas fa-trophy mr-2"></i>
                                                    <span class="text-xs">{{ $unlockedBadge['unlock_count'] }} cadets unlocked this badge ({{ $unlockedBadge['unlock_percentage'] }}%)</span>
                                                </div>
                                            </div>
                                            {{-- Arrow --}}
                                            <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                <div class="border-8 border-transparent border-t-gray-900"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    {{-- ================================================================ --}}
                    {{-- LOCKED BADGES BY CATEGORY --}}
                    {{-- ================================================================ --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <div class="w-1 h-5 bg-gray-400 mr-2 rounded"></div>
                            Locked Badges by Category
                        </h3>
                        
                        @foreach($badgesByCategory as $category => $badges)
                            @if(count($badges['unlockable']) > 0 || count($badges['unlocked']) > 0)
                                <div class="mb-8 last:mb-0">
                                    <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas {{ $categoryIcons[$category] }} text-gray-600 mr-2"></i>
                                        {{ $categoryNames[$category] }}
                                        <span class="ml-2 text-sm font-normal text-gray-500">
                                            ({{ count($badges['unlocked']) }}/{{ count($badges['unlocked']) + count($badges['unlockable']) }} unlocked)
                                        </span>
                                    </h4>
                                    
                                    @if(count($badges['unlockable']) > 0)
                                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                                            @foreach($badges['unlockable'] as $badge)
                                                <div class="badge-card badge-locked group relative bg-gray-50 border-2 border-gray-300 border-dashed rounded-xl p-4 text-center">

                                                    {{-- Greyed Out Badge Icon/Image --}}
                                                    <div class="flex justify-center mb-2">
                                                        <div class="relative w-28 h-28 flex items-center justify-center filter grayscale opacity-40 group-hover:opacity-60 transition-opacity duration-300">
                                                            @if($badge->hasImageIcon())
                                                                <img src="{{ $badge->icon_url }}"
                                                                    alt="{{ $badge->name }}"
                                                                    class="w-full h-full object-contain">
                                                            @else
                                                                <i class="{{ $badge->icon }} text-6xl text-gray-400"></i>
                                                            @endif

                                                            {{-- Lock Icon Overlay --}}
                                                            <div class="absolute inset-0 flex items-center justify-center">
                                                                <div class="w-8 h-8 bg-gray-700 bg-opacity-80 rounded-full flex items-center justify-center">
                                                                    <i class="fas fa-lock text-white text-sm"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Badge Name --}}
                                                    <h4 class="text-sm font-bold text-gray-500 mb-0.5 px-1">{{ $badge->name }}</h4>

                                                    {{-- Rarity Level --}}
                                                    <div class="mb-1">
                                                        <span class="text-xs font-medium" style="color: {{ $badge->rarity_color }};">
                                                            {{ $badge->rarity_label }}
                                                        </span>
                                                    </div>

                                                    {{-- Locked Status --}}
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-600">
                                                        <i class="fas fa-lock mr-1"></i>
                                                        Locked
                                                    </span>
                                                    
                                                    {{-- Hover Tooltip --}}
                                                    <div class="badge-tooltip absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-64 bg-gray-900 text-white text-xs rounded-lg p-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 pointer-events-none">
                                                        <div class="font-semibold mb-2 text-sm">{{ $badge->name }}</div>
                                                        <div class="mb-2 text-gray-300">{{ $badge->description }}</div>
                                                        <div class="pt-2 border-t border-gray-700 space-y-1">
                                                            <div class="flex items-start text-yellow-400">
                                                                <i class="fas fa-trophy mr-2 mt-0.5"></i>
                                                                <span class="text-xs">How to unlock: {{ $badge->unlock_criteria }}</span>
                                                            </div>
                                                            <div class="flex items-center text-blue-400">
                                                                <i class="fas fa-users mr-2"></i>
                                                                <span class="text-xs">{{ $badge->unlock_count }} cadets unlocked this badge ({{ $badge->unlock_percentage }}%)</span>
                                                            </div>
                                                        </div>
                                                        {{-- Arrow --}}
                                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-1">
                                                            <div class="border-8 border-transparent border-t-gray-900"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-gray-500 italic">All badges in this category have been unlocked! 🎉</p>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>

    {{-- ================================================================ --}}
    {{-- CUSTOM STYLES FOR BADGES --}}
    {{-- ================================================================ --}}
    <style>
        .badge-card {
            position: relative;
            /* GPU acceleration for smoother scrolling */
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000px;
        }

        .badge-tooltip {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            /* Ensure tooltip stays within viewport */
            max-width: calc(100vw - 2rem);
            /* GPU acceleration */
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        /* Animation for badge hover - use will-change for better performance */
        .badge-card:hover {
            z-index: 10;
            will-change: transform;
        }

        /* Optimize hover effects by reducing what gets recalculated */
        .badge-card img,
        .badge-card i {
            will-change: transform;
        }

        /* Simplify tooltip positioning - use simpler approach */
        @media (min-width: 1024px) {
            .badge-tooltip {
                bottom: calc(100% + 0.5rem);
                left: 50%;
                transform: translateX(-50%);
            }

            /* For badges in the last row, show tooltip above */
            .badge-card.tooltip-below .badge-tooltip {
                bottom: auto;
                top: calc(100% + 0.5rem);
            }

            .badge-card.tooltip-below .badge-tooltip > div:last-child {
                transform: translateX(-50%) rotate(180deg);
            }
        }

        /* Mobile optimization */
        @media (max-width: 1023px) {
            .badge-tooltip {
                bottom: auto;
                top: calc(100% + 0.5rem);
            }
        }

        /* Reduce animation complexity on lower-end devices */
        @media (prefers-reduced-motion: reduce) {
            .badge-card {
                transition: none;
            }
            .badge-card img,
            .badge-card i {
                transition: none;
            }
        }

        /* Use containment to isolate layout/paint */
        .badge-card {
            contain: layout style paint;
        }

        /* Optimized hover effects for unlocked badges */
        .badge-unlocked {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .badge-unlocked:hover {
            transform: translateY(-0.5rem) translateZ(0);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        /* Optimized hover effects for locked badges */
        .badge-locked {
            transition: box-shadow 0.3s ease;
        }

        .badge-locked:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Optimize icon/image hover animations */
        .badge-unlocked .group-hover\:scale-110 {
            transition: transform 0.3s ease;
        }

        /* Reduce repaints by using transform instead of filter for grayscale hover */
        .badge-locked .group-hover\:opacity-60 {
            transition: opacity 0.3s ease;
        }
    </style>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        function toggleBadgeDisplay(badgeId) {
            fetch('/cadet/performance/toggle-badge', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    badge_id: badgeId
                })
            })
            .then(response => {
                // Handle both success and error responses
                return response.json().then(data => ({
                    ok: response.ok,
                    status: response.status,
                    data: data
                }));
            })
            .then(({ok, status, data}) => {
                if (ok && data.success) {
                    // Find the badge card element
                    const badgeCard = document.querySelector(`[data-badge-id="${badgeId}"]`);
                    if (badgeCard) {
                        // Update the border and shadow classes
                        if (data.is_displayed) {
                            badgeCard.classList.remove('border-gray-200');
                            badgeCard.classList.add('border-green-400', 'shadow-lg');
                        } else {
                            badgeCard.classList.remove('border-green-400', 'shadow-lg');
                            badgeCard.classList.add('border-gray-200');
                        }

                        // Update the status span
                        const statusSpan = badgeCard.querySelector('.badge-status');
                        if (statusSpan) {
                            // Remove existing classes
                            statusSpan.classList.remove('bg-green-100', 'text-green-800', 'bg-gray-100', 'text-gray-600');

                            // Update icon and text
                            const icon = statusSpan.querySelector('i');
                            if (icon) {
                                icon.className = data.is_displayed ? 'fas fa-eye mr-1' : 'fas fa-eye-slash mr-1';
                            }

                            // Update text content
                            const textNode = statusSpan.lastChild;
                            if (textNode.nodeType === Node.TEXT_NODE) {
                                textNode.textContent = data.is_displayed ? 'Displayed' : 'Hidden';
                            }

                            // Add new classes
                            if (data.is_displayed) {
                                statusSpan.classList.add('bg-green-100', 'text-green-800');
                            } else {
                                statusSpan.classList.add('bg-gray-100', 'text-gray-600');
                            }
                        }
                    }

                    // Update the badge counter
                    const badgeCounter = document.getElementById('badge-counter');
                    if (badgeCounter && data.displayed_count !== undefined) {
                        badgeCounter.textContent = data.displayed_count;
                    }
                } else if (data.error === 'limit_reached') {
                    // Show custom alert for limit reached
                    alert(data.message || 'You can only display a maximum of 12 badges. Please disable one before adding another.');
                } else {
                    alert(data.message || 'Error toggling badge display');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error toggling badge display');
            });
        }
    </script>
</x-app-layout>