@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Learning Hub') }}
            </h2>
        </div>
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

    /* ========================================= */
    /* INFO TOOLTIP STYLES */
    /* ========================================= */
    .info-tooltip-wrapper {
        display: inline-block;
        position: relative;
        margin-left: 0.5rem;
        flex-shrink: 0;
    }

    .info-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: help;
        transition: all 0.2s ease;
    }

    .info-icon:hover {
        transform: scale(1.1);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.4);
    }
    }
    
    .info-tooltip-wrapper {
        display: inline-block;
        position: relative;
        margin-left: 0.5rem;
        flex-shrink: 0;
        margin-left: auto; /* Added margin-left: auto; */
    .info-tooltip {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(10px);
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        font-size: 0.8rem;
        line-height: 1.6;
        width: 320px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        pointer-events: none;
    }

    .info-tooltip::before {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 8px solid transparent;
        border-bottom-color: #1e40af;
    }

    .info-tooltip-title {
        display: block;
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .info-tooltip ul {
        margin: 0;
        padding-left: 1.25rem;
    }

    .info-tooltip li {
        margin-bottom: 0.5rem;
    }

    .info-tooltip li:last-child {
        margin-bottom: 0;
    }

    .info-tooltip-wrapper:hover .info-tooltip {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(5px);
    }

    /* Mobile tooltip adjustments */
    @media (max-width: 640px) {
        .info-tooltip {
            width: 280px;
            left: auto;
            right: -10px;
            transform: translateY(10px);
        }
        }

        .info-tooltip::before {
            left: auto;
            right: 15px;
            transform: none;
        }

        .info-tooltip-wrapper:hover .info-tooltip {
            transform: translateY(5px);
        }
    }

    /* Mobile: Make tooltip visible on tap/click */
    .info-tooltip-wrapper.active .info-tooltip {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(5px);
    }

    @media (max-width: 640px) {
        .info-tooltip-wrapper.active .info-tooltip {
            transform: translateY(5px);
        }
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
    /* DROPDOWN ANIMATION STYLES */
    /* ========================================= */
    #progress-content {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transform: translateY(-10px);
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.3s ease-out,
                    transform 0.3s ease-out;
    }

    #progress-content.show {
        max-height: 2000px;
        opacity: 1;
        transform: translateY(0);
        transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.3s ease-in,
                    transform 0.3s ease-in;
    }

    .material-content {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        padding: 0 !important;
        border: 0 !important;
        transform: translateY(-10px);
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.3s ease-out,
                    transform 0.3s ease-out,
                    padding 0.3s ease-out;
    }

    .material-content.show {
        max-height: 3000px;
        opacity: 1;
        padding: 1rem !important;
        transform: translateY(0);
        transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1),
                    opacity 0.3s ease-in,
                    transform 0.3s ease-in,
                    padding 0.3s ease-in;
        border-top: 1px solid #e5e7eb !important;
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
        .dashboard-card:hover,
        .ranking-item:hover {
            transform: none !important;
        }

        .btn-primary:hover {
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 mb-1 sm:mb-2 px-2">Learning Hub</h1>
                <p class="text-gray-600 text-sm sm:text-lg px-2">Access educational materials and resources</p>
            </div>

            <!-- Progress Overview Section - Collapsible -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card"
                x-data="{ open: false }">
                <div class="bg-white shadow-sm rounded-xl p-5 border border-gray-100 cursor-pointer transition hover:shadow-md"
                    onclick="toggleProgressSection()">
                    <div class="flex justify-between items-center">
                        <!-- Left: Icon + Title + Description -->
                        <div class="flex flex-col">
                            <!-- First row: Icon + Title -->
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-cyan p-2 rounded-md mr-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Your Learning Progress</h2>
                            </div>
                            <!-- Second row: Description -->
                            <p class="text-gray-600">Track your completion across all categories</p>
                        </div>

                        <!-- Right: Progress + Chevron -->
                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <div class="text-2xl font-bold text-teal-600">{{ $progressData['overall_progress'] }}%</div>
                                <div class="text-xs text-gray-600">Overall Progress</div>
                            </div>
                            <svg id="progress-chevron"
                                class="w-6 h-6 text-gray-400 transform transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div id="progress-content">
                    <div class="p-6">
                        <!-- Overall Progress Bar -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Overall Completion</span>
                                <span class="text-sm text-gray-600">{{ $progressData['completed_materials'] }}/{{ $progressData['total_materials'] }} materials</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-3 rounded-full transition-all duration-500 ease-out"
                                     style="width: {{ $progressData['overall_progress'] }}%"></div>
                            </div>
                        </div>

                        <!-- Category Progress -->
                        <div class="space-y-4">
                            <h4 class="font-medium text-gray-800 mb-3">Progress by Category</h4>
                            @forelse($progressData['category_progress'] as $categoryId => $progress)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium text-gray-800">{{ $progress['category_name'] }}</span>
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-600">{{ $progress['completed_materials'] }}/{{ $progress['total_materials'] }}</span>
                                            <span class="text-sm font-semibold {{ $progress['percentage'] >= 80 ? 'text-green-600' : ($progress['percentage'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                                {{ $progress['percentage'] }}%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="h-2 rounded-full transition-all duration-500 ease-out
                                                    {{ $progress['percentage'] >= 80 ? 'bg-gradient-to-r from-green-500 to-emerald-500' : ($progress['percentage'] >= 60 ? 'bg-gradient-to-r from-yellow-500 to-orange-500' : 'bg-gradient-to-r from-red-500 to-pink-500') }}"
                                             style="width: {{ $progress['percentage'] }}%"></div>
                                    </div>
                                    @if($progress['percentage'] == 100)
                                        <div class="mt-2 flex items-center text-green-600 text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Category Completed!
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-4">
                                    <svg class="w-8 h-8 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    No categories available yet
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function toggleProgressSection() {
                    const content = document.getElementById('progress-content');
                    const chevron = document.getElementById('progress-chevron');

                    if (content.classList.contains('show')) {
                        content.classList.remove('show');
                        chevron.classList.remove('rotate-180');
                    } else {
                        content.classList.add('show');
                        chevron.classList.add('rotate-180');
                    }
                }
            </script>

            <!-- Learning Hub Content -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">
                <div class="section-header">
                    <div class="flex justify-between items-center">
                        <!-- Left side: Icon + Title + Description -->
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-green mr-3 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Learning Hub</h2>
                            </div>
                            <p class="text-gray-600 ml-13">Access educational materials and resources</p>
                        </div>

                        <!-- Right side: Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                            <button onclick="openMyScoresModal()"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 sm:px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm whitespace-nowrap">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="hidden sm:inline">View My Scores</span>
                                <span class="sm:hidden">My Scores</span>
                            </button>

                            <button onclick="openQuizSelectionModal()"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-3 sm:px-4 py-2 rounded-lg font-medium transition duration-200 flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm whitespace-nowrap">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="hidden sm:inline">Test Your Knowledge</span>
                                <span class="sm:hidden">Take Quiz</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Filter Section - PROFESSIONAL DESIGN -->
                    <div class="mb-6 p-6 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-200 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <!-- Left: Filter Controls -->
                            <div class="flex-1 space-y-3">
                                <div class="flex items-center justify-between">
                                    <label for="categorySelect" class="block text-sm font-semibold text-gray-800">
                                        Filter by Category
                                    </label>
                                    <!-- Completion Stats Badge -->
                                    @php
                                        $completedCategoriesCount = 0;
                                        foreach($progressData['category_progress'] as $progress) {
                                            if (($progress['percentage'] ?? 0) == 100) {
                                                $completedCategoriesCount++;
                                            }
                                        }
                                    @endphp
                                    <div class="text-xs text-gray-600 bg-white px-3 py-1 rounded-full border border-gray-300 shadow-sm">
                                        <span class="font-medium">{{ $categories->count() }}</span> categories •
                                        <span class="font-medium text-green-600">{{ $completedCategoriesCount }}</span> completed
                                    </div>
                                </div>
                                <select id="categorySelect" name="category"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white hover:border-purple-400 transition-all duration-200 text-gray-700 font-medium shadow-sm hover:shadow-md cursor-pointer"
                                        onchange="filterMaterials(this.value)">
                                    <option value="">📚 Select Category</option>
                                    @foreach ($categories as $category)
                                        @php
                                            $categoryProgress = $progressData['category_progress'][$category->id] ?? null;
                                            $completedCount = $categoryProgress ? $categoryProgress['completed_materials'] : 0;
                                            $totalCount = $categoryProgress ? $categoryProgress['total_materials'] : 0;
                                            $isCompleted = $categoryProgress && $categoryProgress['percentage'] == 100;
                                            $percentage = $categoryProgress ? $categoryProgress['percentage'] : 0;
                                        @endphp
                                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                            @if($totalCount > 0)
                                                @if($isCompleted)
                                                    ✅ {{ $category->name }} - Fully Completed ({{ $completedCount }}/{{ $totalCount }})
                                                @else
                                                    📖 {{ $category->name }} - Progress: {{ $completedCount }}/{{ $totalCount }} ({{ $percentage }}%)
                                                @endif
                                            @else
                                                📖 {{ $category->name }} - No materials yet
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                   <!-- Material List Accordion -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-medium text-gray-800 mb-4">
                            <span class="flex items-center w-full justify-between">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <span>Learning Materials</span>
                                </span>
                                {{-- Info Tooltip --}}
                                <span class="info-tooltip-wrapper">
                                    <span class="info-icon" style="background:rgba(33,150,243,0.4);color:rgba(255,255,255,0.9);border-radius:50%;display:inline-flex;align-items:center;justify-content:center;width:20px;height:20px;font-size:0.75rem;font-weight:600;cursor:help;transition:all 0.2s ease;">i</span>
                                    <div class="info-tooltip">
                                        <span class="info-tooltip-title">How to Complete Learning Materials</span>
                                        <ul>
                                            <li><strong>Text/Image:</strong> View for at least 10 seconds</li>
                                            <li><strong>Video/Audio:</strong> Watch/listen to at least 90% of the content</li>
                                            <li><strong>YouTube Video:</strong> Watch at least 80% of the video (skipping does not count)</li>
                                            <li><strong>Documents:</strong> Open and view the document</li>
                                        </ul>
                                    </div>
                                </span>
                            </span>
                        </h4>

                        <div id="materialsContainer">
                            @if(!request()->filled('category'))
                                <!-- Placeholder when no category selected -->
                                <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl border-2 border-dashed border-gray-300">
                                    <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-2">Select a Category to Begin</h3>
                                    <p class="text-gray-600 mb-4 max-w-md mx-auto">
                                        Please choose a category from the dropdown above to view available learning materials.
                                    </p>
                                    <svg class="w-8 h-8 text-blue-500 mx-auto animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                    </svg>
                                </div>
                            @else
                                @forelse($materials->groupBy('learning_material_category_id') as $grouped)
                                    @foreach($grouped as $material)
                                        @php
                                            $materialType = $material->material_type;
                                            $cadetId = auth()->user()->cadet->id ?? null;
                                            $isCompleted = $cadetId ? $material->isCompletedBy($cadetId) : false;
                                            $isStarted = $cadetId ? $material->isStartedBy($cadetId) : false;
                                        @endphp
                                        
                                        <div id="material-{{ $material->id }}" 
                                            class="border {{ $isCompleted ? 'border-green-300' : 'border-gray-200' }} rounded-lg mb-4 transition-all duration-300"
                                            data-material-id="{{ $material->id }}"
                                            data-material-type="{{ $materialType }}"
                                            data-material-url="{{ $material->file_url }}">
                                            
                                            <button
                                                id="material-button-{{ $material->id }}"
                                                onclick="toggleMaterial({{ $material->id }}, '{{ $materialType }}', '{{ addslashes($material->file_url ?? '') }}')"
                                                class="w-full flex justify-between items-center px-3 sm:px-6 py-2 sm:py-3 {{ $isCompleted ? 'bg-green-100 hover:bg-green-200 text-green-800' : 'bg-blue-100 hover:bg-blue-200 text-blue-800' }} text-left font-medium text-sm sm:text-lg rounded-t-lg transition-colors duration-300">
                                                <span class="flex items-center gap-1 sm:gap-2 flex-1 min-w-0 pr-2">
                                                    <svg id="checkmark-{{ $material->id }}"
                                                        class="w-4 h-4 sm:w-5 sm:h-5 text-green-600 flex-shrink-0 {{ $isCompleted ? '' : 'hidden' }}"
                                                        fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="truncate">{{ $material->title }}</span>
                                                </span>
                                                <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                                                    <span id="completion-badge-{{ $material->id }}"
                                                        class="{{ $isCompleted ? '' : 'hidden' }} text-green-700 text-xs sm:text-sm font-semibold bg-green-100 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-full whitespace-nowrap">
                                                        <span class="hidden sm:inline">✓ Completed</span>
                                                        <span class="sm:hidden">✓</span>
                                                    </span>
                                                    <svg id="chevron-{{ $material->id }}"
                                                        class="w-4 h-4 sm:w-5 sm:h-5 transform transition-transform flex-shrink-0"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </div>
                                            </button>
                                            
                                            <div id="material-content-{{ $material->id }}"
                                                class="material-content p-6 bg-gradient-to-br from-gray-50 to-blue-50 rounded-b-lg border-t-2 border-blue-200">
                                                <!-- Material Content -->
                                                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                                                    @if($material->file_url && $material->description && in_array($materialType, ['youtube', 'video', 'audio', 'image']))
                                                        <div class="flex flex-col md:flex-row gap-6">
                                                            <div class="md:flex-[0_0_30%]">
                                                                @if($materialType === 'youtube')
                                                                    <div class="relative group">
                                                                        <div class="relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                                                            <iframe
                                                                                src="{{ $material->getYouTubeEmbedUrl() }}"
                                                                                data-material-id="{{ $material->id }}"
                                                                                class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"
                                                                                frameborder="0"
                                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                                allowfullscreen>
                                                                            </iframe>
                                                                        </div>
                                                                        <div class="absolute top-2 left-2 bg-red-600 bg-opacity-90 text-white px-2 py-1 rounded text-xs font-medium z-10">
                                                                            ▶ YouTube Video
                                                                        </div>
                                                                    </div>
                                                                @elseif($materialType === 'video')
                                                                    <div class="relative group">
                                                                        <video id="video-{{ $material->id }}"
                                                                            controls
                                                                            class="w-full rounded-lg shadow-lg"
                                                                            data-material-id="{{ $material->id }}">
                                                                            <source src="{{ asset($material->file_url) }}" type="video/mp4">
                                                                        </video>
                                                                        <div class="absolute top-2 left-2 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs font-medium">
                                                                            🎥 Training Video
                                                                        </div>
                                                                        <button onclick="event.stopPropagation(); openVideoModal('{{ asset($material->file_url) }}', '{{ addslashes($material->title) }}')"
                                                                            class="absolute top-2 right-2 bg-black bg-opacity-70 hover:bg-opacity-90 text-white p-2 rounded-lg transition-all duration-300 opacity-0 group-hover:opacity-100"
                                                                            title="Open in fullscreen">
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                                                            </svg>
                                                                        </button>
                                                                    </div>
                                                                @elseif($materialType === 'audio')
                                                                    <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-lg border-2 border-purple-200">
                                                                        <div class="flex items-center gap-4 mb-4">
                                                                            <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                                                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                                                                </svg>
                                                                            </div>
                                                                            <div>
                                                                                <h4 class="font-semibold text-gray-800">Audio Training Material</h4>
                                                                                <p class="text-sm text-gray-600">Listen carefully and take notes</p>
                                                                            </div>
                                                                        </div>
                                                                        <audio id="audio-{{ $material->id }}"
                                                                            controls
                                                                            class="w-full"
                                                                            data-material-id="{{ $material->id }}">
                                                                            <source src="{{ asset($material->file_url) }}" type="audio/mpeg">
                                                                        </audio>
                                                                    </div>
                                                                @elseif($materialType === 'image')
                                                                    <div class="relative cursor-pointer group"
                                                                        onclick="openImageModal('{{ asset($material->file_url) }}', '{{ addslashes($material->title) }}')">
                                                                        <img src="{{ asset($material->file_url) }}"
                                                                            alt="Material Image"
                                                                            class="w-full h-auto rounded-lg shadow-lg max-w-4xl transition-transform duration-500 group-hover:scale-105"
                                                                            loading="lazy">
                                                                        <div class="absolute top-2 left-2 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs font-medium">
                                                                            📸 Training Image
                                                                        </div>
                                                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100 rounded-lg">
                                                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="md:col-span-1">
                                                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                                                                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        Contents
                                                                    </h4>
                                                                    <div class="text-sm text-gray-700 leading-relaxed">
                                                                        {{ $material->description }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @elseif($material->file_url && in_array($materialType, ['youtube', 'video', 'audio', 'image']))
                                                        <div class="text-center">
                                                            @if($materialType === 'youtube')
                                                                <div class="relative inline-block w-full max-w-4xl mx-auto">
                                                                    <div class="relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                                                        <iframe
                                                                            src="{{ $material->getYouTubeEmbedUrl() }}"
                                                                            data-material-id="{{ $material->id }}"
                                                                            class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"
                                                                            frameborder="0"
                                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                            allowfullscreen>
                                                                        </iframe>
                                                                    </div>
                                                                    <div class="absolute top-3 left-3 bg-red-600 bg-opacity-90 text-white px-3 py-1 rounded-lg text-sm font-medium z-10">
                                                                        ▶ YouTube Video
                                                                    </div>
                                                                </div>
                                                            @elseif($materialType === 'video')
                                                                <div class="relative inline-block">
                                                                    <video id="video-{{ $material->id }}"
                                                                        controls
                                                                        class="max-w-2xl w-full rounded-lg shadow-lg"
                                                                        data-material-id="{{ $material->id }}">
                                                                        <source src="{{ asset($material->file_url) }}" type="video/mp4">
                                                                    </video>
                                                                    <div class="absolute top-3 left-3 bg-black bg-opacity-70 text-white px-3 py-1 rounded-lg text-sm font-medium">
                                                                        🎥 Training Video
                                                                    </div>
                                                                </div>
                                                            @elseif($materialType === 'audio')
                                                                <div class="max-w-2xl mx-auto bg-gradient-to-r from-purple-50 to-blue-50 p-8 rounded-xl border-2 border-purple-200">
                                                                    <div class="flex items-center justify-center gap-4 mb-6">
                                                                        <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center">
                                                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                                                                            </svg>
                                                                        </div>
                                                                        <div class="text-left">
                                                                            <h4 class="text-lg font-semibold text-gray-800">Audio Training Material</h4>
                                                                            <p class="text-gray-600">Listen carefully and take notes</p>
                                                                        </div>
                                                                    </div>
                                                                    <audio id="audio-{{ $material->id }}"
                                                                        controls
                                                                        class="w-full"
                                                                        data-material-id="{{ $material->id }}">
                                                                        <source src="{{ asset($material->file_url) }}" type="audio/mpeg">
                                                                    </audio>
                                                                </div>
                                                            @elseif($materialType === 'image')
                                                                <div class="relative inline-block">
                                                                    <img src="{{ asset($material->file_url) }}"
                                                                        alt="Material Image"
                                                                        class="max-w-2xl w-full h-auto rounded-lg shadow-lg">
                                                                    <div class="absolute top-3 left-3 bg-black bg-opacity-70 text-white px-3 py-1 rounded-lg text-sm font-medium">
                                                                        📸 Training Image
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @elseif($materialType === 'document' && $material->file_url)
                                                        <div class="text-center">
                                                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-xl border-2 border-blue-200 max-w-md mx-auto">
                                                                <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                                    </svg>
                                                                </div>
                                                                <h4 class="text-lg font-semibold text-gray-800 mb-2">Document Material</h4>
                                                                <p class="text-gray-600 mb-6">Click below to view the training document</p>
                                                                <a href="{{ asset($material->file_url) }}"
                                                                target="_blank"
                                                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                                    </svg>
                                                                    Open Document
                                                                </a>
                                                            </div>
                                                            @if($material->description)
                                                                <div class="mt-6 bg-white p-4 rounded-lg border border-gray-200 max-w-2xl mx-auto">
                                                                    <h5 class="font-semibold text-gray-800 mb-2">Additional Information:</h5>
                                                                    <p class="text-gray-700 leading-relaxed">{{ $material->description }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="max-w-4xl mx-auto">
                                                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border-2 border-green-200">
                                                                <div class="flex items-start gap-4">
                                                                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="flex-1">
                                                                        <h4 class="text-lg font-semibold text-gray-800 mb-3">Training Content</h4>
                                                                        <div class="text-gray-700 leading-relaxed text-base">
                                                                            {{ $material->description ?? 'No description available' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                @if(in_array($materialType, ['video', 'audio']))
                                                    <div id="progress-indicator-{{ $material->id }}" class="mt-4 hidden">
                                                        <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                                            <span>Viewing Progress</span>
                                                            <span id="progress-percentage-{{ $material->id }}">0%</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                                            <div id="progress-bar-{{ $material->id }}" 
                                                                class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                                                                style="width: 0%"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if($isStarted || $isCompleted)
                                                    <div class="mt-4 pt-4 border-t border-gray-200">
                                                        <div class="flex items-center justify-between text-sm">
                                                            <span class="text-gray-600">
                                                                @if($isCompleted)
                                                                    <span class="flex items-center text-green-600">
                                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                                        </svg>
                                                                        Completed
                                                                    </span>
                                                                @else
                                                                    <span class="flex items-center text-blue-600">
                                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        In Progress
                                                                    </span>
                                                                @endif
                                                            </span>
                                                            @php
                                                                $progress = $material->getProgressFor($cadetId);
                                                            @endphp
                                                            @if($progress && $progress->started_at)
                                                                <span class="text-gray-500 text-xs">
                                                                    Started: {{ $progress->started_at->diffForHumans() }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @empty
                                    <div class="text-center text-gray-500 py-10">No learning materials found for this category.</div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructor Section -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">
                <div class="section-header">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Left: Icon + Title + Description -->
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-blue mr-3 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Meet Your Instructors</h2>
                            </div>
                            <p class="text-gray-600 ml-13">Click on any instructor to view their detailed profile</p>
                        </div>

                        <!-- Right: Filter Dropdown -->
                        <div class="flex flex-col space-y-2 min-w-[200px]">
                            <label for="instructorStatusSelect" class="block text-sm font-medium text-gray-700">
                                Filter by Status
                            </label>
                            <select id="instructorStatusSelect" name="instructor_status"
                                class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                                onchange="filterInstructors(this.value)">
                                <option value="">All Statuses</option>
                                <option value="Active" @selected(request('instructor_status') == 'Active')>Active</option>
                                <option value="Relocated" @selected(request('instructor_status') == 'Relocated')>Relocated</option>
                                <option value="Retired" @selected(request('instructor_status') == 'Retired')>Retired</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div id="instructorsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($instructors as $instructor)
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer"
                                 onclick="openInstructorModal({{ $instructor->id }})">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $instructor->profile_pic ? asset('storage/' . $instructor->profile_pic) : asset('images/default.png') }}"
                                         alt="Instructor Photo"
                                         class="w-16 h-16 rounded-full object-cover border-2 border-blue-200">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800">
                                            {{ $instructor->user->name ?? 'Unknown' }}
                                        </h4>
                                        <p class="text-sm text-blue-600 font-medium">
                                            {{ $instructor->rank ?? 'Instructor' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $instructor->position ?? 'Naval Instructor' }}
                                        </p>
                                        @if($instructor->expertise)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-1">
                                                {{ $instructor->expertise }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 py-10">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                No instructors available at the moment.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quiz Modal - Dynamically Rendered by QuizManager -->
    <div id="quizModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden transition-opacity duration-300"
        style="display: none;">
        <!-- QuizManager will render content here dynamically -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300">
                <div class="p-6 text-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"></div>
                    <p class="text-gray-600">Loading quiz...</p>
                </div>
                <!-- QuizManager will dynamically render quiz content here -->
            </div>
        </div>
    </div>

    <!-- Quiz Selection Modal -->
    <div id="quizSelectionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full transform transition-all duration-300 hover:shadow-3xl animate-modalSlideIn">
                <!-- Header with gradient background -->
                <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 p-6 rounded-t-xl sticky top-0 z-10">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg mr-3 transform hover:scale-110 transition-transform duration-200">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white tracking-wide">Test Your Knowledge</h2>
                                <p class="text-purple-100 text-sm mt-1">Choose your quiz preferences and challenge yourself</p>
                            </div>
                        </div>
                        <button onclick="closeQuizSelectionModal()"
                                class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition-all duration-200 hover:rotate-90 transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8 space-y-8 bg-gradient-to-b from-white to-gray-50">
                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Category Selection -->
                        <div class="space-y-3 group">
                            <label for="quizSelectionCategory" class="flex items-center text-sm font-semibold text-gray-800">
                                <div class="bg-purple-100 p-1.5 rounded-md mr-2 group-hover:bg-purple-200 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                Select Topic
                            </label>
                            <select id="quizSelectionCategory"
                                    class="w-full px-4 py-3.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white hover:border-purple-400 transition-all duration-200 text-gray-700 font-medium shadow-sm hover:shadow-md cursor-pointer">
                                <option value="">Practice Mode (All Topics)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Difficulty Selection -->
                        <div class="space-y-3 group">
                            <label for="quizSelectionDifficulty" class="flex items-center text-sm font-semibold text-gray-800">
                                <div class="bg-purple-100 p-1.5 rounded-md mr-2 group-hover:bg-purple-200 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                Select Difficulty
                            </label>
                            <select id="quizSelectionDifficulty"
                                    class="w-full px-4 py-3.5 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white hover:border-purple-400 transition-all duration-200 text-gray-700 font-medium shadow-sm hover:shadow-md cursor-pointer">
                            @php
                                $selectedCategory = request('category');
                                // For practice mode (empty category), unlock all difficulties
                                if (empty($selectedCategory)) {
                                    $unlockedDifficulties = ['easy', 'medium', 'hard'];
                                } else {
                                    $unlockedDifficulties = $unlockedDifficulties[$selectedCategory] ?? ['easy'];
                                }
                            @endphp
                            <option value="easy" title="{{ empty($selectedCategory) ? 'Always unlocked in practice mode' : 'Always unlocked' }}" {{ in_array('easy', $unlockedDifficulties) ? '' : 'disabled class="text-gray-400"' }}>
                                🟢 Easy - MCQ only (5 questions, 1 minute)
                            </option>
                            <option value="medium" title="{{ empty($selectedCategory) ? 'Unlocked in practice mode' : 'Unlock by achieving 80%+ on Easy difficulty' }}" {{ in_array('medium', $unlockedDifficulties) ? '' : 'disabled class="text-gray-400"' }}>
                                🟡 Medium - Mixed types (5 questions, 2 minutes)
                            </option>
                            <option value="hard" title="{{ empty($selectedCategory) ? 'Unlocked in practice mode' : 'Unlock by achieving 80%+ on Medium difficulty' }}" {{ in_array('hard', $unlockedDifficulties) ? '' : 'disabled class="text-gray-400"' }}>
                                🔴 Hard - More subjective (7 questions, 3 minutes)
                            </option>
                        </select>
                    </div>

                    </div>

                    <!-- Info Box -->
                    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 border-2 border-blue-300 rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="text-base font-bold text-blue-900 mb-2 flex items-center">
                                    Quiz Guidelines
                                    <span class="ml-2 text-xs bg-blue-200 text-blue-800 px-2 py-0.5 rounded-full">Important</span>
                                </h4>
                                <ul class="text-sm text-blue-800 space-y-2">
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Timer starts immediately when quiz begins
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Questions are randomly selected from the chosen topic
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Navigate freely between questions before submitting
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 mr-2 mt-0.5 text-blue-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Quiz auto-submits when time expires
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-4">
                        <button onclick="closeQuizSelectionModal()"
                                class="flex-1 px-6 py-3.5 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg transition-all duration-200 border-2 border-gray-300 hover:border-gray-400 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                            Cancel
                        </button>
                        <button onclick="startQuiz()"
                                class="flex-[2] px-8 py-3.5 bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 hover:from-purple-700 hover:via-purple-800 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M9 16h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Start Quiz
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Scores Modal -->
    <div id="myScoresModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 hover:shadow-3xl animate-modalSlideIn">
                <!-- Header -->
                <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 p-6 rounded-t-xl sticky top-0 z-10">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">My Quiz Performance</h2>
                                <p class="text-purple-100 text-sm">Top scores by category</p>
                            </div>
                        </div>
                        <button onclick="closeMyScoresModal()" 
                                class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6">
                    @if($topScores->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">No Quiz Scores Yet</h3>
                            <p class="text-gray-500 mb-4">Start taking quizzes to see your performance here!</p>
                            <button onclick="closeMyScoresModal(); openQuizSelectionModal();" 
                                    class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition duration-200">
                                Take Your First Quiz
                            </button>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($topScores as $score)
                                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-5 border-2 border-gray-200 hover:border-purple-400 hover:shadow-lg transition-all duration-200">
                                    <!-- Category Header -->
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-800 text-lg mb-1">
                                                {{ $score->category->name ?? 'General Quiz' }}
                                            </h4>
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                                    @if($score->difficulty === 'easy') bg-green-100 text-green-800
                                                    @elseif($score->difficulty === 'medium') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    @if($score->difficulty === 'easy') 🟢
                                                    @elseif($score->difficulty === 'medium') 🟡
                                                    @else 🔴
                                                    @endif
                                                    {{ ucfirst($score->difficulty) }}
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <!-- Score Circle -->
                                        <div class="flex flex-col items-center">
                                            <div class="relative w-20 h-20">
                                                <svg class="w-20 h-20 transform -rotate-90">
                                                    <circle cx="40" cy="40" r="32" stroke="#e5e7eb" stroke-width="6" fill="none"/>
                                                    <circle cx="40" cy="40" r="32" 
                                                            stroke="{{ $score->score_percentage >= 80 ? '#10b981' : ($score->score_percentage >= 60 ? '#f59e0b' : '#ef4444') }}" 
                                                            stroke-width="6" 
                                                            fill="none"
                                                            stroke-dasharray="{{ 2 * 3.14159 * 32 }}"
                                                            stroke-dashoffset="{{ 2 * 3.14159 * 32 * (1 - $score->score_percentage / 100) }}"
                                                            stroke-linecap="round"/>
                                                </svg>
                                                <div class="absolute inset-0 flex items-center justify-center">
                                                    <span class="text-xl font-bold 
                                                        @if($score->score_percentage >= 80) text-green-600
                                                        @elseif($score->score_percentage >= 60) text-yellow-600
                                                        @else text-red-600
                                                        @endif">
                                                        {{ number_format($score->score_percentage, 0) }}%
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                            <div class="text-2xl font-bold text-blue-600">{{ $score->correct_answers }}</div>
                                            <div class="text-xs text-gray-600">Correct</div>
                                        </div>
                                        <div class="bg-white rounded-lg p-3 text-center shadow-sm">
                                            <div class="text-2xl font-bold text-gray-600">{{ $score->total_questions }}</div>
                                            <div class="text-xs text-gray-600">Total</div>
                                        </div>
                                    </div>

                                    <!-- Date -->
                                    <div class="flex items-center text-xs text-gray-500 pt-2 border-t border-gray-300">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Completed: {{ $score->completed_at->format('d/m/Y') }}
                                    </div>

                                    <!-- Performance Badge -->
                                    @if($score->score_percentage >= 80)
                                        <div class="mt-2 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                ⭐ Excellent Performance
                                            </span>
                                        </div>
                                    @elseif($score->score_percentage >= 60)
                                        <div class="mt-2 text-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                ✓ Passed
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Summary Stats -->
                        <div class="mt-6 bg-gradient-to-r from-purple-50 to-indigo-50 rounded-lg p-4 border border-purple-200">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Overall Statistics
                            </h4>
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-purple-600">{{ $topScores->count() }}</div>
                                    <div class="text-sm text-gray-600">Categories Completed</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-purple-600">{{ number_format($topScores->avg('score_percentage'), 1) }}%</div>
                                    <div class="text-sm text-gray-600">Average Score</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-purple-600">{{ $topScores->where('score_percentage', '>=', 80)->count() }}</div>
                                    <div class="text-sm text-gray-600">Excellent Scores</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Button -->
                    <div class="mt-6 text-center">
                        <button onclick="closeMyScoresModal(); openQuizSelectionModal();" 
                                class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg transform hover:scale-105 transition duration-200 flex items-center justify-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Take Another Quiz
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructor Profile Modal -->
    <div id="instructorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[95vh] sm:max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-3 sm:p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg sm:text-2xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-1 sm:mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Instructor Profile
                        </h2>
                        <button onclick="closeInstructorModal()" class="text-gray-500 hover:text-gray-700 text-2xl sm:text-3xl font-bold leading-none">
                            ×
                        </button>
                    </div>
                </div>

                <div id="modalContent" class="p-3 sm:p-6">
                    <!-- Loading state -->
                    <div id="loadingState" class="text-center py-10">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="text-gray-600 mt-4">Loading instructor profile...</p>
                    </div>

                    <!-- Error state -->
                    <div id="errorState" class="text-center py-10 hidden">
                        <svg class="w-12 h-12 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-600">Error loading instructor profile.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>
    <script>
        // Global quiz state management without relying on Alpine timing
        window.quizState = {
            isActive: false,
            questions: [],
            currentQuestion: 0,
            answers: {},
            timeRemaining: 0,
            sessionKey: '',
            showResults: false,
            results: {},
            timer: null
        };

        // Quiz Manager - handles all quiz logic (UPDATED)
        const QuizManager = {
            initializeQuiz(data) {
                console.log('Initializing quiz with data:', data);
                
                // Reset and set state
                window.quizState.questions = data.questions || [];
                window.quizState.timeRemaining = data.time_limit || 300;
                window.quizState.sessionKey = data.session_key || '';
                window.quizState.answers = {};
                window.quizState.currentQuestion = 0;
                window.quizState.showResults = false;
                window.quizState.isActive = true;
                
                // Show modal and render quiz immediately
                this.showQuizModal();
                
                // Start timer
                if (window.quizState.questions.length > 0) {
                    this.startTimer();
                }
            },

            showQuizModal() {
                const modal = document.getElementById('quizModal');
                if (!modal) {
                    console.error('Quiz modal not found');
                    return;
                }

                // Apply proper modal styling
                modal.style.position = 'fixed';
                modal.style.top = '0';
                modal.style.left = '0';
                modal.style.right = '0';
                modal.style.bottom = '0';
                modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                modal.style.display = 'flex';
                modal.style.alignItems = 'center';
                modal.style.justifyContent = 'center';
                modal.style.padding = '1rem';
                modal.style.zIndex = '50';
                modal.classList.remove('hidden');
                window.modalVisible = true;

                // Render quiz content directly
                this.renderQuizContent();
            },

            renderQuizContent() {
                const modal = document.getElementById('quizModal');
                const question = window.quizState.questions[window.quizState.currentQuestion];
                
                if (!question) {
                    console.error('No question found');
                    return;
                }

                // Create quiz HTML with mobile-optimized styling
                const quizHTML = `
                    <div style="
                        background: white;
                        border-radius: 0.75rem;
                        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                        max-width: 56rem;
                        width: 100%;
                        max-height: 90vh;
                        overflow-y: auto;
                        margin: auto;
                    ">
                        <!-- Header -->
                        <div style="
                            background: linear-gradient(to right, #ecfdf5, #d1fae5);
                            padding: 1rem;
                            border-bottom: 1px solid #e5e7eb;
                            position: sticky;
                            top: 0;
                            border-radius: 0.75rem 0.75rem 0 0;
                        ">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 0.5rem;">
                                <div style="flex: 1; min-width: 0;">
                                    <h2 style="
                                        font-size: clamp(1.125rem, 4vw, 1.5rem);
                                        font-weight: 600;
                                        color: #111827;
                                        margin: 0 0 0.25rem 0;
                                        line-height: 1.2;
                                    ">Quiz in Progress</h2>
                                    <p style="
                                        color: #6b7280;
                                        margin: 0;
                                        font-size: clamp(0.75rem, 3vw, 0.875rem);
                                        line-height: 1.3;
                                    ">Question ${window.quizState.currentQuestion + 1} of ${window.quizState.questions.length}</p>
                                </div>
                                <div style="display: flex; align-items: flex-start; gap: 0.75rem; flex-shrink: 0;">
                                    <div style="text-align: right;">
                                        <div id="timer" style="
                                            font-size: clamp(0.875rem, 3vw, 1.125rem);
                                            font-weight: 600;
                                            color: #dc2626;
                                            line-height: 1.2;
                                        ">${this.formatTime(window.quizState.timeRemaining)}</div>
                                        <div style="
                                            font-size: clamp(0.625rem, 2.5vw, 0.75rem);
                                            color: #6b7280;
                                            white-space: nowrap;
                                        ">Time Left</div>
                                    </div>
                                    <button onclick="QuizManager.closeQuiz()" style="
                                        background: none;
                                        border: none;
                                        color: #6b7280;
                                        font-size: clamp(1.25rem, 5vw, 1.5rem);
                                        font-weight: bold;
                                        cursor: pointer;
                                        padding: 0.25rem;
                                        line-height: 1;
                                        touch-action: manipulation;
                                    " onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#6b7280'">×</button>
                                </div>
                            </div>
                            
                            <!-- Progress Bar -->
                            <div style="
                                margin-top: 0.75rem;
                                background: #e5e7eb;
                                border-radius: 9999px;
                                height: 0.5rem;
                            ">
                                <div style="
                                    background: #059669;
                                    height: 0.5rem;
                                    border-radius: 9999px;
                                    transition: width 0.3s ease;
                                    width: ${((window.quizState.currentQuestion + 1) / window.quizState.questions.length) * 100}%;
                                "></div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div style="padding: clamp(1rem, 4vw, 1.5rem);">
                            <!-- Question -->
                            <div style="margin-bottom: 1.5rem;">
                                <h3 style="
                                    font-size: clamp(1rem, 4vw, 1.125rem);
                                    font-weight: 500;
                                    color: #111827;
                                    margin: 0 0 1rem 0;
                                    line-height: 1.6;
                                ">${question.question_text}</h3>
                                
                                ${question.file_url ? `
                                    <div style="
                                        margin-bottom: 1.5rem;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                        width: 100%;
                                    ">
                                        ${this.renderFile(question.file_url)}
                                    </div>
                                ` : ''}
                            </div>

                            ${question.question_type === 'MCQ' ? this.renderMCQOptions(question) : this.renderSubjectiveInput(question)}

                            <!-- Navigation Buttons -->
                            <div style="
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                margin-top: 1.5rem;
                                padding-top: 1.5rem;
                                border-top: 1px solid #e5e7eb;
                                gap: 0.5rem;
                            ">
                                <button onclick="QuizManager.previousQuestion()" 
                                        ${window.quizState.currentQuestion === 0 ? 
                                            `disabled style="
                                                padding: clamp(0.5rem, 3vw, 0.75rem) clamp(0.75rem, 4vw, 1rem);
                                                background: #d1d5db;
                                                color: white;
                                                border: none;
                                                border-radius: 0.5rem;
                                                cursor: not-allowed;
                                                font-weight: 500;
                                                font-size: clamp(0.75rem, 3.5vw, 0.875rem);
                                                touch-action: manipulation;
                                            "` : 
                                            `style="
                                                padding: clamp(0.5rem, 3vw, 0.75rem) clamp(0.75rem, 4vw, 1rem);
                                                background: #2563eb;
                                                color: white;
                                                border: none;
                                                border-radius: 0.5rem;
                                                cursor: pointer;
                                                transition: background 0.2s;
                                                font-weight: 500;
                                                font-size: clamp(0.75rem, 3.5vw, 0.875rem);
                                                touch-action: manipulation;
                                            " onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'"`
                                        }>
                                    Previous
                                </button>

                                <div style="display: flex; gap: 0.5rem;">
                                    ${window.quizState.currentQuestion < window.quizState.questions.length - 1 ? 
                                        `<button onclick="QuizManager.nextQuestion()" style="
                                            padding: clamp(0.5rem, 3vw, 0.75rem) clamp(0.75rem, 4vw, 1rem);
                                            background: #2563eb;
                                            color: white;
                                            border: none;
                                            border-radius: 0.5rem;
                                            cursor: pointer;
                                            transition: background 0.2s;
                                            font-weight: 500;
                                            font-size: clamp(0.75rem, 3.5vw, 0.875rem);
                                            touch-action: manipulation;
                                        " onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">Next</button>` :
                                        `<button onclick="QuizManager.submitQuiz()" style="
                                            padding: clamp(0.5rem, 3vw, 0.75rem) clamp(0.75rem, 4vw, 1.5rem);
                                            background: #059669;
                                            color: white;
                                            border: none;
                                            border-radius: 0.5rem;
                                            cursor: pointer;
                                            transition: background 0.2s;
                                            font-weight: 600;
                                            font-size: clamp(0.75rem, 3.5vw, 0.875rem);
                                            touch-action: manipulation;
                                        " onmouseover="this.style.background='#047857'" onmouseout="this.style.background='#059669'">Submit Quiz</button>`
                                        }
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    modal.innerHTML = quizHTML;
                },

            renderFile(fileUrl) {
                const url = fileUrl.startsWith('/') ? fileUrl : `/${fileUrl}`;
                
                if (/\.(jpg|jpeg|png|gif)$/i.test(fileUrl)) {
                    return `<img src="${url}" alt="Question Image" style="
                        max-width: 100%;
                        max-height: 60vh;
                        width: auto;
                        height: auto;
                        border-radius: 0.5rem;
                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                        object-fit: contain;
                    ">`;
                } else if (/\.(mp4|webm|avi|mov)$/i.test(fileUrl)) {
                    return `<video controls style="
                        max-width: 100%;
                        max-height: 60vh;
                        width: auto;
                        height: auto;
                        border-radius: 0.5rem;
                        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    "><source src="${url}" type="video/mp4"></video>`;
                } else if (/\.(mp3|wav|ogg|m4a)$/i.test(fileUrl)) {
                    return `<div style="
                        width: 100%;
                        max-width: 400px;
                        padding: 1rem;
                        background: #f8fafc;
                        border-radius: 0.5rem;
                        border: 2px solid #e2e8f0;
                    ">
                        <div style="
                            display: flex;
                            align-items: center;
                            margin-bottom: 0.75rem;
                            font-weight: 500;
                            color: #374151;
                        ">
                            🎵 Audio File
                        </div>
                        <audio controls style="
                            width: 100%;
                            height: 40px;
                        ">
                            <source src="${url}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>`;
                } else {
                    return `<a href="${url}" target="_blank" style="
                        display: inline-flex;
                        align-items: center;
                        padding: 0.75rem 1rem;
                        background: #dbeafe;
                        color: #1e40af;
                        text-decoration: none;
                        border-radius: 0.5rem;
                        transition: background 0.2s;
                        font-size: clamp(0.75rem, 3.5vw, 0.875rem);
                        touch-action: manipulation;
                    " onmouseover="this.style.background='#bfdbfe'" onmouseout="this.style.background='#dbeafe'">
                        📄 View Document
                    </a>`;
                }
            },

            renderMCQOptions(question) {
                const options = question.shuffled_options || {};
                let optionsHTML = '<div style="margin-bottom: 1.5rem;">';
                
                Object.entries(options).forEach(([key, value]) => {
                    // Check if current answer matches this option's text value
                    const isChecked = window.quizState.answers[question.id] === value ? 'checked' : '';
                    optionsHTML += `
                        <label style="
                            display: flex;
                            align-items: flex-start;
                            padding: clamp(0.75rem, 3vw, 1rem);
                            border: 2px solid #e5e7eb;
                            border-radius: 0.5rem;
                            margin-bottom: 0.75rem;
                            cursor: pointer;
                            transition: all 0.2s;
                            background: white;
                            touch-action: manipulation;
                            min-height: 3rem;
                        " onmouseover="this.style.background='#f9fafb'; this.style.borderColor='#d1d5db'" 
                           onmouseout="this.style.background='white'; this.style.borderColor='#e5e7eb'"
                           onclick="this.style.borderColor='#059669'; this.style.background='#f0fdf4'">
                            <input type="radio" 
                                   name="question_${question.id}" 
                                   value="${value}" 
                                   ${isChecked}
                                   onchange="QuizManager.updateAnswer(${question.id}, '${value}'); console.log('Selected option text:', '${value}', 'for question:', ${question.id});"
                                   style="
                                       margin-right: 0.75rem;
                                       margin-top: 0.125rem;
                                       accent-color: #059669;
                                       transform: scale(clamp(1.1, 4vw, 1.3));
                                       flex-shrink: 0;
                                   ">
                            <span style="
                                color: #374151;
                                font-weight: 500;
                                font-size: clamp(0.875rem, 3.5vw, 1rem);
                                line-height: 1.5;
                                word-wrap: break-word;
                                flex: 1;
                            ">${key}. ${value}</span>
                        </label>
                    `;
                });
                
                optionsHTML += '</div>';
                return optionsHTML;
            },

            renderSubjectiveInput(question) {
                const currentAnswer = window.quizState.answers[question.id] || '';
                return `
                    <div style="margin-bottom: 1.5rem;">
                        <label style="
                            display: block;
                            font-size: clamp(0.75rem, 3.5vw, 0.875rem);
                            font-weight: 500;
                            color: #374151;
                            margin-bottom: 0.5rem;
                        ">Your Answer:</label>
                        <textarea rows="4" 
                                  onchange="QuizManager.updateAnswer(${question.id}, this.value)"
                                  style="
                                      width: 100%;
                                      padding: clamp(0.75rem, 3vw, 1rem);
                                      border: 2px solid #d1d5db;
                                      border-radius: 0.5rem;
                                      font-family: inherit;
                                      font-size: clamp(0.875rem, 3.5vw, 1rem);
                                      transition: border-color 0.2s;
                                      resize: vertical;
                                      box-sizing: border-box;
                                      min-height: 6rem;
                                      line-height: 1.5;
                                  "
                                  onfocus="this.style.borderColor='#059669'; this.style.outline='none'"
                                  onblur="this.style.borderColor='#d1d5db'"
                                  placeholder="Type your answer here...">${currentAnswer}</textarea>
                    </div>
                `;
            },

            formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
            },

            updateAnswer(questionId, value) {
                // Ensure value is always a string and log for debugging
                const cleanValue = String(value).trim();
                window.quizState.answers[questionId] = cleanValue;
                console.log('Answer updated - Question ID:', questionId, 'Value:', cleanValue, 'Type:', typeof cleanValue);
                console.log('Current answers state:', window.quizState.answers);
            },

            nextQuestion() {
                if (window.quizState.currentQuestion < window.quizState.questions.length - 1) {
                    window.quizState.currentQuestion++;
                    this.renderQuizContent();
                }
            },

            previousQuestion() {
                if (window.quizState.currentQuestion > 0) {
                    window.quizState.currentQuestion--;
                    this.renderQuizContent();
                }
            },

            startTimer() {
                if (window.quizState.timer) {
                    clearInterval(window.quizState.timer);
                }
                
                window.quizState.timer = setInterval(() => {
                    window.quizState.timeRemaining--;
                    
                    // Update timer display
                    const timerElement = document.getElementById('timer');
                    if (timerElement) {
                        timerElement.textContent = this.formatTime(window.quizState.timeRemaining);
                    }
                    
                    if (window.quizState.timeRemaining <= 0) {
                        this.submitQuiz();
                    }
                }, 1000);
            },

            submitQuiz() {
                if (window.quizState.timer) {
                    clearInterval(window.quizState.timer);
                }

                fetch('/api/quiz/submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        session_key: window.quizState.sessionKey,
                        answers: window.quizState.answers
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.loadResults(data.result_key);
                    } else {
                        alert(data.message || 'Error submitting quiz');
                    }
                })
                .catch(error => {
                    console.error('Error submitting quiz:', error);
                    alert('Error submitting quiz. Please try again.');
                });
            },

            loadResults(resultKey) {
                fetch('/api/quiz/results', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        result_key: resultKey
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.showResults(data.results);
                    }
                })
                .catch(error => {
                    console.error('Error loading results:', error);
                    alert('Error loading quiz results.');
                });
            },

            showResults(results) {
                const modal = document.getElementById('quizModal');

                // Apply proper modal styling
                modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4';
                modal.style.display = 'flex';

                const performanceMsg = results.score >= 80 ? `
                    <div class="mb-8 text-center">
                        <div class="inline-block bg-gradient-to-r from-yellow-100 to-amber-100 border-2 border-yellow-400 rounded-xl px-6 py-4 shadow-md">
                            <p class="text-lg font-bold text-yellow-900 flex items-center justify-center gap-2">
                                <span class="text-2xl">🎉</span>
                                Outstanding Performance! You've mastered this topic!
                                <span class="text-2xl">🎉</span>
                            </p>
                        </div>
                    </div>
                ` : '';

                const resultsHTML = `
                    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300">
                        <div class="p-8 bg-gradient-to-b from-white to-gray-50">
                            <!-- Success Animation & Header -->
                            <div class="text-center mb-8">
                                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-emerald-400 to-green-500 rounded-full mb-6 shadow-lg animate-bounce">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h2 class="text-4xl font-extrabold text-gray-900 mb-3">Quiz Completed!</h2>
                                <p class="text-lg text-gray-600">Great job! Here's how you performed</p>
                            </div>

                            <!-- Score Summary Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <!-- Score Percentage -->
                                <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-6 border-2 border-emerald-300 shadow-lg hover:shadow-xl transition-shadow duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-sm font-bold text-emerald-800 uppercase tracking-wide">Your Score</h3>
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="text-5xl font-extrabold text-emerald-600 mb-2">${results.score}%</div>
                                    <div class="flex items-center text-sm text-emerald-700">
                                        ${results.score >= 80 ? `
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            Excellent!
                                        ` : results.score >= 60 ? 'Good work!' : 'Keep practicing!'}
                                    </div>
                                </div>

                                <!-- Correct Answers -->
                                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-300 shadow-lg hover:shadow-xl transition-shadow duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wide">Correct</h3>
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div class="text-5xl font-extrabold text-blue-600 mb-2">${results.correct_answers}</div>
                                    <div class="text-sm text-blue-700">Out of ${results.total_questions} questions</div>
                                </div>

                                <!-- Total Questions -->
                                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border-2 border-purple-300 shadow-lg hover:shadow-xl transition-shadow duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-sm font-bold text-purple-800 uppercase tracking-wide">Total</h3>
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <div class="text-5xl font-extrabold text-purple-600 mb-2">${results.total_questions}</div>
                                    <div class="text-sm text-purple-700">Questions answered</div>
                                </div>
                            </div>

                            <!-- Performance Message -->
                            ${performanceMsg}

                            <!-- Review Answers -->
                            ${results.results && results.results.length > 0 ? `
                                <div class="space-y-5 mb-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                            </svg>
                                            Review Your Answers
                                        </h3>
                                        <div class="text-sm text-gray-600 bg-gray-100 px-4 py-2 rounded-lg font-medium">
                                            ${results.correct_answers} / ${results.total_questions} Correct
                                        </div>
                                    </div>

                                    ${results.results.map((result, index) => `
                                        <div class="border-2 rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-1 ${result.is_correct ? 'border-emerald-300 bg-gradient-to-br from-emerald-50 to-green-50' : 'border-red-300 bg-gradient-to-br from-red-50 to-pink-50'}">
                                            <!-- Question Header -->
                                            <div class="flex items-start justify-between mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold text-white ${result.is_correct ? 'bg-emerald-600' : 'bg-red-600'}">
                                                        ${index + 1}
                                                    </div>
                                                    <h4 class="font-bold text-gray-900 text-lg">Question ${index + 1}</h4>
                                                </div>
                                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold shadow-sm ${result.is_correct ? 'bg-emerald-600 text-white' : 'bg-red-600 text-white'}">
                                                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${result.is_correct ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"/>
                                                    </svg>
                                                    ${result.is_correct ? 'Correct' : 'Incorrect'}
                                                </span>
                                            </div>

                                            <!-- Question Text -->
                                            <div class="mb-4 bg-white bg-opacity-60 rounded-lg p-4 border border-gray-200">
                                                <p class="text-gray-900 font-medium leading-relaxed">${result.question_text}</p>
                                            </div>

                                            <!-- Answers -->
                                            <div class="space-y-3">
                                                <!-- User Answer -->
                                                <div class="bg-white bg-opacity-80 rounded-lg p-4 border-2 ${result.is_correct ? 'border-emerald-400' : 'border-red-400'}">
                                                    <div class="flex items-start gap-3">
                                                        <div class="flex-shrink-0">
                                                            <div class="w-8 h-8 rounded-full flex items-center justify-center ${result.is_correct ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700'}">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex-1">
                                                            <p class="text-xs font-bold uppercase tracking-wide mb-1 ${result.is_correct ? 'text-emerald-700' : 'text-red-700'}">Your Answer</p>
                                                            <p class="text-gray-900 font-medium">${result.user_answer || 'No answer provided'}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Correct Answer (if wrong) -->
                                                ${!result.is_correct ? `
                                                    <div class="bg-emerald-50 rounded-lg p-4 border-2 border-emerald-400">
                                                        <div class="flex items-start gap-3">
                                                            <div class="flex-shrink-0">
                                                                <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700">
                                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                            <div class="flex-1">
                                                                <p class="text-xs font-bold text-emerald-700 uppercase tracking-wide mb-1">Correct Answer</p>
                                                                <p class="text-emerald-900 font-bold">${result.correct_answer}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                ` : ''}
                                            </div>
                                        </div>
                                    `).join('')}
                                </div>
                            ` : ''}

                            <!-- Action Buttons -->
                            <div class="flex gap-4 justify-center pt-4 border-t-2 border-gray-200">
                                <button onclick="QuizManager.closeQuiz()" class="px-8 py-3.5 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Close Quiz
                                </button>
                                <button onclick="QuizManager.closeQuiz(); setTimeout(() => openQuizSelectionModal(), 300);" class="px-8 py-3.5 bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 hover:from-purple-700 hover:via-purple-800 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Take Another Quiz
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                modal.innerHTML = resultsHTML;
            },

            closeQuiz() {
                const modal = document.getElementById('quizModal');
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.add('hidden');
                    // Reset inline styles
                    modal.removeAttribute('style');
                }

                window.modalVisible = false;

                if (window.quizState.timer) {
                    clearInterval(window.quizState.timer);
                }

                // Reset state
                window.quizState.isActive = false;
                window.quizState.showResults = false;
                window.quizState.questions = [];
                window.quizState.answers = {};
                window.quizState.currentQuestion = 0;

                // Update difficulty options after quiz completion
                const categoryId = document.getElementById('quizSelectionCategory').value;
                updateDifficultyOptionsForCategory(categoryId);
            }
        };

        // Quiz Selection Modal Functions - Working version
        function openQuizSelectionModal() {
            console.log('Opening quiz selection modal...');
            const modal = document.getElementById('quizSelectionModal');
            if (modal) {
                modal.classList.remove('hidden');
                console.log('Modal should now be visible');

                // Update difficulty options when opening the modal
                const categoryId = document.getElementById('quizSelectionCategory').value;
                updateDifficultyOptionsForCategory(categoryId);
            } else {
                console.error('Quiz selection modal not found');
            }
        }

        function closeQuizSelectionModal() {
            console.log('Closing quiz selection modal...');
            const modal = document.getElementById('quizSelectionModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Updated startQuiz function
        function startQuiz() {
            console.log('Starting quiz...');
            const category = document.getElementById('quizSelectionCategory').value;
            const difficulty = document.getElementById('quizSelectionDifficulty').value;

            console.log('Selected category:', category);
            console.log('Selected difficulty:', difficulty);

            if (!difficulty) {
                alert('Please select a difficulty level.');
                return;
            }

            closeQuizSelectionModal();

            fetch('/api/quiz/start', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    category_id: category || null,
                    difficulty: difficulty
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Quiz start response:', data);
                if (data.success && Array.isArray(data.questions) && data.questions.length > 0) {
                    QuizManager.initializeQuiz(data);
                } else {
                    alert(data.message || 'No questions available for the selected category and difficulty.');
                }
            })
            .catch(error => {
                console.error('Error starting quiz:', error);
                alert('Error starting quiz. Please try again.');
            });
        }

        // Material Functions
        function openMaterial(materialId) {
            if (materialId) {
                // First, scroll to the material
                const element = document.getElementById(materialId);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Wait a bit for the scroll to complete, then open the accordion
                    setTimeout(() => {
                        const button = element.querySelector('button');
                        if (button) {
                            // Check if the accordion is closed and open it
                            const content = element.querySelector('[x-show]');
                            const isOpen = element.querySelector('[x-data]').__x.$data.open;

                            if (!isOpen) {
                                button.click();
                            }
                        }
                    }, 500);
                }

                // Reset the dropdown to default
                document.getElementById('materialDropdown').value = '';
            }
        }

        // Function to filter materials by category
        // Function to filter materials by category
        function filterMaterials(categoryId) {
            const materialsContainer = document.getElementById('materialsContainer');

            // If no category selected, show placeholder
            if (!categoryId) {
                materialsContainer.innerHTML = `
                    <div class="text-center py-16 bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl border-2 border-dashed border-gray-300">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Select a Category to Begin</h3>
                        <p class="text-gray-600 mb-4 max-w-md mx-auto">
                            Please choose a category from the dropdown above to view available learning materials.
                        </p>
                        <svg class="w-8 h-8 text-blue-500 mx-auto animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>
                `;
                return;
            }

            // Show loading state
            materialsContainer.innerHTML = '<div class="text-center py-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div><p class="text-gray-600 mt-2">Loading materials...</p></div>';

            // Fetch materials via AJAX
            fetch(`/api/materials?category=${categoryId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    materialsContainer.innerHTML = '<div class="text-center text-gray-500 py-10">No learning materials found for this category.</div>';
                    return;
                }

                let materialsHTML = '';
                data.forEach(material => {
                    // Determine material type
                    let materialType = 'text';
                    if (material.file_url) {
                        // Check if it's a YouTube link first
                        if (/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/.test(material.file_url)) {
                            materialType = 'youtube';
                        } else {
                            const ext = material.file_url.split('.').pop().toLowerCase();
                            if (['mp4', 'webm', 'avi', 'mov'].includes(ext)) materialType = 'video';
                            else if (['mp3', 'wav', 'ogg', 'm4a'].includes(ext)) materialType = 'audio';
                            else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) materialType = 'image';
                            else if (['pdf', 'doc', 'docx', 'ppt', 'pptx'].includes(ext)) materialType = 'document';
                        }
                    }

                    const isMedia = ['youtube', 'video', 'audio', 'image'].includes(materialType);
                    const hasDescription = material.description && material.description.trim() !== '';
                    const fileUrl = material.file_url ? material.file_url.replace(/\\/g, '\\\\').replace(/'/g, "\\'") : '';

                    // Extract YouTube video ID helper function
                    const getYouTubeVideoId = (url) => {
                        let match = url.match(/youtu\.be\/([a-zA-Z0-9_-]+)/);
                        if (match) return match[1];
                        match = url.match(/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/);
                        if (match) return match[1];
                        match = url.match(/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/);
                        if (match) return match[1];
                        return null;
                    };

                    let contentHTML = '';

                    if (material.file_url && hasDescription && isMedia) {
                        if (materialType === 'youtube') {
                            const videoId = getYouTubeVideoId(material.file_url);
                            contentHTML = `
                                <div class="md:w-[30%]">
                                    <div class="relative" style="padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                        <iframe
                                            src="https://www.youtube.com/embed/${videoId}?enablejsapi=1"
                                            data-material-id="${material.id}"
                                            class="absolute top-0 left-0 w-full h-full rounded"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                                <div class="md:w-[70%] text-gray-700"><p>${material.description}</p></div>
                            `;
                        } else if (materialType === 'video') {
                            contentHTML = `
                                <div class="md:w-[30%]">
                                    <video id="video-${material.id}" controls class="w-full rounded" data-material-id="${material.id}">
                                        <source src="/${material.file_url}" type="video/mp4">
                                    </video>
                                </div>
                                <div class="md:w-[70%] text-gray-700"><p>${material.description}</p></div>
                            `;
                        } else if (materialType === 'audio') {
                            contentHTML = `
                                <div class="md:w-[30%]">
                                    <audio id="audio-${material.id}" controls class="w-full" data-material-id="${material.id}">
                                        <source src="/${material.file_url}" type="audio/mpeg">
                                    </audio>
                                </div>
                                <div class="md:w-[70%] text-gray-700"><p>${material.description}</p></div>
                            `;
                        } else if (materialType === 'image') {
                            contentHTML = `
                                <div class="md:w-[30%]">
                                    <img src="/${material.file_url}" alt="Material Image" class="w-full h-auto rounded">
                                </div>
                                <div class="md:w-[70%] text-gray-700"><p>${material.description}</p></div>
                            `;
                        }
                    } else if (material.file_url && isMedia) {
                        if (materialType === 'youtube') {
                            const videoId = getYouTubeVideoId(material.file_url);
                            contentHTML = `
                                <div class="w-full flex justify-center">
                                    <div class="relative w-full max-w-4xl" style="padding-bottom: 56.25%; height: 0; overflow: hidden;">
                                        <iframe
                                            src="https://www.youtube.com/embed/${videoId}?enablejsapi=1"
                                            data-material-id="${material.id}"
                                            class="absolute top-0 left-0 w-full h-full rounded"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen>
                                        </iframe>
                                    </div>
                                </div>
                            `;
                        } else if (materialType === 'video') {
                            contentHTML = `
                                <div class="w-full flex justify-center">
                                    <video id="video-${material.id}" controls class="max-w-lg w-full rounded" data-material-id="${material.id}">
                                        <source src="/${material.file_url}" type="video/mp4">
                                    </video>
                                </div>
                            `;
                        } else if (materialType === 'audio') {
                            contentHTML = `
                                <div class="w-full flex justify-center">
                                    <audio id="audio-${material.id}" controls class="w-full max-w-lg" data-material-id="${material.id}">
                                        <source src="/${material.file_url}" type="audio/mpeg">
                                    </audio>
                                </div>
                            `;
                        } else if (materialType === 'image') {
                            contentHTML = `
                                <div class="w-full flex justify-center">
                                    <img src="/${material.file_url}" alt="Material Image" class="max-w-lg w-full h-auto rounded">
                                </div>
                            `;
                        }
                    } else {
                        contentHTML = `
                            <div class="w-full text-gray-700">
                                <p>${material.description || 'No description available'}</p>
                            </div>
                        `;
                    }

                    // Generate progress indicator for video/audio
                    const progressHTML = (materialType === 'video' || materialType === 'audio') ? `
                        <div id="progress-indicator-${material.id}" class="mt-4 hidden">
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-1">
                                <span>Viewing Progress</span>
                                <span id="progress-percentage-${material.id}">0%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="progress-bar-${material.id}" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    ` : '';

                    // Build material HTML WITHOUT Alpine.js
                    materialsHTML += `
                        <div id="material-${material.id}" class="border border-gray-200 rounded-lg mb-4">
                            <button onclick="toggleMaterial(${material.id}, '${materialType}', '${fileUrl}')"
                                    id="material-button-${material.id}"
                                    class="w-full flex justify-between items-center px-6 py-2 bg-blue-100 hover:bg-blue-200 text-left text-blue-800 font-medium text-lg rounded-t-lg">
                                <span>${material.title}</span>
                                <svg id="chevron-${material.id}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="material-content-${material.id}" class="material-content p-4 bg-white rounded-b-lg border-t">
                                <div class="flex flex-col md:flex-row gap-4">
                                    ${contentHTML}
                                </div>
                                ${progressHTML}
                            </div>
                        </div>
                    `;
                });

                materialsContainer.innerHTML = materialsHTML;
            })
            .catch(error => {
                console.error('Error fetching materials:', error);
                materialsContainer.innerHTML = '<div class="text-center text-red-500 py-10">Error loading materials. Please try again.</div>';
            });
        }

        // AJAX function to filter instructors by status
        function filterInstructors(status) {
            const instructorsContainer = document.getElementById('instructorsContainer');

            // Show loading state
            instructorsContainer.innerHTML = '<div class="col-span-full text-center text-gray-500 py-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div><p class="text-gray-600 mt-2">Loading instructors...</p></div>';

            // Fetch instructors via AJAX
            fetch(`/api/instructors?status=${status}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    instructorsContainer.innerHTML = `
                        <div class="col-span-full text-center text-gray-500 py-10">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            No instructors available for the selected status.
                        </div>
                    `;
                    return;
                }

                let instructorsHTML = '';
                data.forEach(instructor => {
                    const profilePic = instructor.profile_pic ? `/storage/${instructor.profile_pic}` : '/images/default.png';
                    const prefix = instructor.service_number && instructor.service_number.startsWith('NV') ? ' PSSTLDM' :
                                  instructor.service_number && instructor.service_number.startsWith('N') ? ' TLDM' : '';

                    instructorsHTML += `
                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer"
                             onclick="openInstructorModal(${instructor.id})">
                            <div class="flex items-center space-x-4">
                                <img src="${profilePic}"
                                     alt="Instructor Photo"
                                     class="w-16 h-16 rounded-full object-cover border-2 border-blue-200">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800">
                                        ${instructor.user?.name || 'Unknown'}
                                    </h4>
                                    <p class="text-sm text-blue-600 font-medium">
                                        ${instructor.rank || 'Instructor'}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        ${instructor.position || 'Naval Instructor'}
                                    </p>
                                    ${instructor.expertise ? `<span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-1">${instructor.expertise}</span>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });

                instructorsContainer.innerHTML = instructorsHTML;
            })
            .catch(error => {
                console.error('Error fetching instructors:', error);
                instructorsContainer.innerHTML = '<div class="col-span-full text-center text-red-500 py-10">Error loading instructors. Please try again.</div>';
            });
        }

        // Instructor modal functions
        function openInstructorModal(instructorId) {
            const modal = document.getElementById('instructorModal');
            const modalContent = document.getElementById('modalContent');

            // Reset modal content to loading state
            modalContent.innerHTML = `
                <div id="loadingState" class="text-center py-10">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="text-gray-600 mt-4">Loading instructor profile...</p>
                </div>
                <div id="errorState" class="text-center py-10 hidden">
                    <svg class="w-12 h-12 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-red-600">Error loading instructor profile.</p>
                </div>
            `;

            // Show modal
            modal.classList.remove('hidden');

            // Fetch instructor data
            fetch(`/api/instructor/${instructorId}`)
                .then(response => response.json())
                .then(data => {
                    modalContent.innerHTML = generateInstructorProfileHTML(data);
                })
                .catch(error => {
                    console.error('Error fetching instructor data:', error);
                    modalContent.innerHTML = `
                        <div id="errorState" class="text-center py-10">
                            <svg class="w-12 h-12 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-red-600">Error loading instructor profile.</p>
                        </div>
                    `;
                });
        }

        function closeInstructorModal() {
            const modal = document.getElementById('instructorModal');
            modal.classList.add('hidden');
        }

        // Function to format past units and remove brackets
        function formatPastUnits(pastUnits) {
            if (!pastUnits) return '-';

            // If it's a string with brackets, remove them and clean up
            if (typeof pastUnits === 'string') {
                // Remove square brackets and quotes
                let cleaned = pastUnits.replace(/[\[\]"]/g, '');
                // Split by comma and clean up each unit
                let units = cleaned.split(',').map(unit => unit.trim());
                // Filter out empty strings and join with commas
                return units.filter(unit => unit.length > 0).join(', ') || '-';
            }

            // If it's already an array
            if (Array.isArray(pastUnits)) {
                return pastUnits.filter(unit => unit && unit.trim().length > 0).join(', ') || '-';
            }

            return pastUnits || '-';
        }

        function generateInstructorProfileHTML(instructor) {
            const prefix = instructor.service_number && instructor.service_number.startsWith('NV') ? ' PSSTLDM' :
                          instructor.service_number && instructor.service_number.startsWith('N') ? ' TLDM' : '';

            return `
                <div class="flex flex-col md:flex-row gap-4 md:gap-6">
                    <!-- Profile Picture -->
                    <div class="flex justify-center lg:justify-start">
                        <img src="${instructor.profile_pic ? '/storage/' + instructor.profile_pic : '/images/default.png'}"
                            alt="Profile Picture"
                            class="w-32 h-40 sm:w-40 sm:h-52 md:w-60 md:h-80 object-cover border rounded-md">
                    </div>

                    <!-- Profile Information -->
                    <div class="flex-1 space-y-4 md:space-y-6">
                        <!-- Row 1 -->
                        <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-2 sm:gap-4">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold px-4 sm:px-6 py-2 rounded-xl shadow-lg whitespace-nowrap text-sm sm:text-base">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Personal Profile
                            </div>
                            <p class="text-lg sm:text-xl md:text-2xl font-semibold text-gray-800 text-center sm:text-left">
                                ${instructor.rank || 'Unknown'} ${instructor.user?.name || 'No Name'}${prefix}
                            </p>
                        </div>

                        <!-- Row 2: Contact Info -->
                        <div class="bg-gray-50 rounded-xl p-3 sm:p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-address-book w-5 text-blue-500 mr-2"></i>
                                <p class="text-gray-700 font-semibold text-sm sm:text-base">Contact Information</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-phone w-4 text-green-500 mr-2 mt-0.5 sm:mt-0"></i>
                                    <span class="text-xs sm:text-sm break-all"><strong>Phone:</strong> ${instructor.phone_number || 'Not set'}</span>
                                </div>
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-envelope w-4 text-blue-500 mr-2 mt-0.5 sm:mt-0"></i>
                                    <span class="text-xs sm:text-sm break-all"><strong>Email:</strong> ${instructor.user?.email || 'Not set'}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Service Info -->
                        <div class="bg-gray-50 rounded-xl p-3 sm:p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-medal w-5 text-purple-500 mr-2"></i>
                                <p class="text-gray-700 font-semibold text-sm sm:text-base">Service Information</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-user-tie w-4 text-blue-500 mr-2 mt-0.5 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-xs sm:text-sm break-words"><strong>Position:</strong> ${instructor.position || '-'}</span>
                                </div>
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-brain w-4 text-purple-500 mr-2 mt-0.5 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-xs sm:text-sm break-words"><strong>Expertise:</strong> ${instructor.expertise || '-'}</span>
                                </div>
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-clock w-4 text-orange-500 mr-2 mt-0.5 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-xs sm:text-sm"><strong>Service Years:</strong> ${instructor.time_in_service ? instructor.time_in_service + ' Years' : '-'}</span>
                                </div>
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-certificate w-4 text-green-500 mr-2 mt-0.5 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-xs sm:text-sm break-words"><strong>TTP:</strong> ${instructor.ttp || '-'}</span>
                                </div>
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-check-circle w-4 text-green-500 mr-2 mt-0.5 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-xs sm:text-sm"><strong>Status:</strong> ${instructor.status || '-'}</span>
                                </div>
                                <div class="flex items-start sm:items-center">
                                    <i class="fas fa-hashtag w-4 text-blue-500 mr-2 mt-0.5 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-xs sm:text-sm break-all"><strong>Service Number:</strong> ${instructor.service_number || '-'}</span>
                                </div>
                                <div class="flex items-start sm:items-center md:col-span-2">
                                    <i class="fas fa-building w-4 text-gray-500 mr-2 mt-0.5 sm:mt-0 flex-shrink-0"></i>
                                    <span class="text-xs sm:text-sm break-words"><strong>Past Units:</strong> ${formatPastUnits(instructor.past_unit)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            window.modalVisible = false;
            console.log('Quiz system initialized');

            // Add event listener for category change to update difficulties
            document.getElementById('quizSelectionCategory').addEventListener('change', function() {
                const categoryId = this.value;
                updateDifficultyOptionsForCategory(categoryId);
            });
        });

        // Function to update difficulty options based on category
        function updateDifficultyOptionsForCategory(categoryId) {
            fetch(`/api/unlocked-difficulties?category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateDifficultyOptions(data.unlocked_difficulties);
                    }
                })
                .catch(error => {
                    console.error('Error fetching unlocked difficulties:', error);
                });
        }

        // Function to update the difficulty select options
        function updateDifficultyOptions(unlockedDifficulties) {
            const difficultySelect = document.getElementById('quizSelectionDifficulty');
            const options = difficultySelect.querySelectorAll('option');

            options.forEach(option => {
                const difficulty = option.value;
                if (difficulty === 'easy') {
                    // Easy is always unlocked
                    option.disabled = false;
                    option.classList.remove('text-gray-400');
                } else {
                    const isUnlocked = unlockedDifficulties.includes(difficulty);
                    option.disabled = !isUnlocked;
                    if (isUnlocked) {
                        option.classList.remove('text-gray-400');
                    } else {
                        option.classList.add('text-gray-400');
                    }
                }
            });
        }

        // Clean up when page unloads
        window.addEventListener('beforeunload', function() {
            if (window.quizState.timer) {
                clearInterval(window.quizState.timer);
            }
        });

        // Close modals on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuizSelectionModal();
                QuizManager.closeQuiz();
                closeInstructorModal();
                closeMyScoresModal(); // ADD THIS LINE
            }
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            const quizModal = document.getElementById('quizModal');
            const selectionModal = document.getElementById('quizSelectionModal');
            const instructorModal = document.getElementById('instructorModal');
            const scoresModal = document.getElementById('myScoresModal'); // ADD THIS LINE
            
            if (e.target === quizModal) {
                QuizManager.closeQuiz();
            }
            if (e.target === selectionModal) {
                closeQuizSelectionModal();
            }
            if (e.target === instructorModal) {
                closeInstructorModal();
            }
            if (e.target === scoresModal) { // ADD THIS BLOCK
                closeMyScoresModal();
            }
        });

        function openMyScoresModal() {
            const modal = document.getElementById('myScoresModal');
            if (!modal) return;

            // Show modal with loading state
            modal.classList.remove('hidden');

            // Show loading state
            modal.innerHTML = `
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full p-8">
                        <div class="text-center py-16">
                            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-purple-600 mx-auto mb-4"></div>
                            <p class="text-gray-600 text-lg">Loading your scores...</p>
                        </div>
                    </div>
                </div>
            `;

            // Fetch fresh scores data
            fetch('/api/cadet/top-scores', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                renderMyScoresModal(data);
            })
            .catch(error => {
                console.error('Error fetching scores:', error);
                modal.innerHTML = `
                    <div class="flex items-center justify-center min-h-screen p-4">
                        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full p-8">
                            <div class="text-center py-16">
                                <svg class="w-16 h-16 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">Error Loading Scores</h3>
                                <p class="text-gray-600 mb-4">Could not load your quiz scores. Please try again.</p>
                                <button onclick="closeMyScoresModal()" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition duration-200">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        function renderMyScoresModal(scores) {
            const modal = document.getElementById('myScoresModal');
            if (!modal) return;

            const hasScores = scores && scores.length > 0;
            const avgScore = hasScores ? (scores.reduce((sum, s) => sum + parseFloat(s.score_percentage), 0) / scores.length).toFixed(1) : 0;
            const excellentScores = hasScores ? scores.filter(s => parseFloat(s.score_percentage) >= 80).length : 0;

            const modalHTML = `
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 hover:shadow-3xl animate-modalSlideIn">
                        <!-- Header -->
                        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 p-6 rounded-t-xl sticky top-0 z-10">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="bg-white bg-opacity-20 p-3 rounded-lg mr-3 transform hover:scale-110 transition-transform duration-200">
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-2xl font-bold text-white tracking-wide">My Quiz Performance</h2>
                                        <p class="text-purple-100 text-sm mt-1">Track your progress and top scores by category</p>
                                    </div>
                                </div>
                                <button onclick="closeMyScoresModal()"
                                        class="text-white hover:bg-white hover:bg-opacity-20 p-2 rounded-lg transition-all duration-200 hover:rotate-90 transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8 bg-gradient-to-b from-white to-gray-50">
                            ${!hasScores ? `
                                <!-- Empty State -->
                                <div class="text-center py-16">
                                    <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-800 mb-3">No Quiz Scores Yet</h3>
                                    <p class="text-gray-600 mb-6 text-lg">Start taking quizzes to track your progress and see your performance here!</p>
                                    <button onclick="closeMyScoresModal(); openQuizSelectionModal();"
                                            class="px-8 py-3.5 bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 hover:from-purple-700 hover:via-purple-800 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M9 16h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Take Your First Quiz
                                    </button>
                                </div>
                            ` : `
                                <!-- Summary Stats -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-xl p-6 border-2 border-purple-300 shadow-md hover:shadow-lg transition-shadow duration-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-sm font-bold text-purple-800 uppercase tracking-wide">Categories</h3>
                                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                        <div class="text-4xl font-extrabold text-purple-600">${scores.length}</div>
                                        <div class="text-sm text-purple-700 mt-1">Completed</div>
                                    </div>

                                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-xl p-6 border-2 border-blue-300 shadow-md hover:shadow-lg transition-shadow duration-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-sm font-bold text-blue-800 uppercase tracking-wide">Average</h3>
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                            </svg>
                                        </div>
                                        <div class="text-4xl font-extrabold text-blue-600">${avgScore}%</div>
                                        <div class="text-sm text-blue-700 mt-1">Overall Score</div>
                                    </div>

                                    <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl p-6 border-2 border-yellow-300 shadow-md hover:shadow-lg transition-shadow duration-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <h3 class="text-sm font-bold text-yellow-800 uppercase tracking-wide">Excellent</h3>
                                            <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </div>
                                        <div class="text-4xl font-extrabold text-yellow-600">${excellentScores}</div>
                                        <div class="text-sm text-yellow-700 mt-1">Scores ≥80%</div>
                                    </div>
                                </div>

                                <!-- Score Cards -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    ${scores.map(score => {
                                        const percentage = parseFloat(score.score_percentage);
                                        const isExcellent = percentage >= 80;
                                        const isPassed = percentage >= 60;
                                        const circumference = 2 * 3.14159 * 38;
                                        const offset = circumference * (1 - percentage / 100);
                                        const strokeColor = isExcellent ? '#10b981' : (isPassed ? '#f59e0b' : '#ef4444');

                                        return `
                                            <div class="bg-white rounded-xl p-6 border-2 border-gray-300 hover:border-purple-500 shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                                <!-- Category Header -->
                                                <div class="flex justify-between items-start mb-4">
                                                    <div class="flex-1">
                                                        <h4 class="font-bold text-gray-900 text-xl mb-2">${score.category_name || 'General Quiz'}</h4>
                                                        <div class="flex items-center gap-2">
                                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold ${
                                                                score.difficulty === 'easy' ? 'bg-green-100 text-green-800 ring-2 ring-green-300' :
                                                                score.difficulty === 'medium' ? 'bg-yellow-100 text-yellow-800 ring-2 ring-yellow-300' :
                                                                'bg-red-100 text-red-800 ring-2 ring-red-300'
                                                            }">
                                                                ${score.difficulty === 'easy' ? '🟢' : score.difficulty === 'medium' ? '🟡' : '🔴'}
                                                                ${score.difficulty.charAt(0).toUpperCase() + score.difficulty.slice(1)}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Score Circle -->
                                                    <div class="flex flex-col items-center">
                                                        <div class="relative w-24 h-24">
                                                            <svg class="w-24 h-24 transform -rotate-90">
                                                                <circle cx="48" cy="48" r="38" stroke="#e5e7eb" stroke-width="8" fill="none"/>
                                                                <circle cx="48" cy="48" r="38"
                                                                        stroke="${strokeColor}"
                                                                        stroke-width="8"
                                                                        fill="none"
                                                                        stroke-dasharray="${circumference}"
                                                                        stroke-dashoffset="${offset}"
                                                                        stroke-linecap="round"
                                                                        class="transition-all duration-500"/>
                                                            </svg>
                                                            <div class="absolute inset-0 flex items-center justify-center">
                                                                <span class="text-2xl font-extrabold ${
                                                                    isExcellent ? 'text-green-600' :
                                                                    isPassed ? 'text-yellow-600' : 'text-red-600'
                                                                }">${Math.round(percentage)}%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Stats -->
                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 text-center shadow-sm border-2 border-blue-200 hover:shadow-md transition-shadow duration-200">
                                                        <div class="text-3xl font-extrabold text-blue-600">${score.correct_answers}</div>
                                                        <div class="text-sm text-blue-800 font-semibold mt-1">Correct</div>
                                                    </div>
                                                    <div class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl p-4 text-center shadow-sm border-2 border-gray-300 hover:shadow-md transition-shadow duration-200">
                                                        <div class="text-3xl font-extrabold text-gray-700">${score.total_questions}</div>
                                                        <div class="text-sm text-gray-600 font-semibold mt-1">Total</div>
                                                    </div>
                                                </div>

                                                ${isExcellent ? `
                                                    <div class="mb-3 text-center">
                                                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-300 shadow-sm">
                                                            ⭐ Excellent Performance
                                                        </span>
                                                    </div>
                                                ` : isPassed ? `
                                                    <div class="mb-3 text-center">
                                                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border-2 border-yellow-300 shadow-sm">
                                                            ✓ Passed
                                                        </span>
                                                    </div>
                                                ` : ''}

                                                <!-- Date -->
                                                <div class="flex items-center justify-center text-sm text-gray-600 pt-3 border-t-2 border-gray-200">
                                                    <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="font-semibold">Completed:</span>
                                                    <span class="ml-1">${new Date(score.completed_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</span>
                                                </div>
                                            </div>
                                        `;
                                    }).join('')}
                                </div>

                                <!-- Action Button -->
                                <div class="mt-8 text-center">
                                    <button onclick="closeMyScoresModal(); openQuizSelectionModal();"
                                            class="px-8 py-3.5 bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-600 hover:from-purple-700 hover:via-purple-800 hover:to-indigo-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 inline-flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Take Another Quiz
                                    </button>
                                </div>
                            `}
                        </div>
                    </div>
                </div>
            `;

            modal.innerHTML = modalHTML;
        }

        function closeMyScoresModal() {
            const modal = document.getElementById('myScoresModal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Learning Material Progress Tracking
        const LearningProgressTracker = {
            materialTimers: {},
            videoPlayers: {},
            completedMaterials: new Set(),
            youtubeTrackers: {},

            init(materialId, materialType, fileUrl) {
                // Check if already completed
                if (this.completedMaterials.has(materialId)) {
                    console.log('✅ Already completed - showing badge');
                    this.showCompletionBadge(materialId);
                    return;
                }

                console.log('📝 Starting tracking for type:', materialType);

                if (materialType === 'text' || materialType === 'image') {
                    this.trackTextMaterial(materialId);
                } else if (materialType === 'video' || materialType === 'audio') {
                    this.trackMediaMaterial(materialId, materialType);
                } else if (materialType === 'youtube') {
                    this.trackYouTubeMaterial(materialId);
                }
            },
            
            trackTextMaterial(materialId) {
                console.log('📄 trackTextMaterial called for ID:', materialId);
                this.markMaterialStarted(materialId);
                
                if (this.materialTimers[materialId]) {
                    clearTimeout(this.materialTimers[materialId]);
                }
                
                this.materialTimers[materialId] = setTimeout(() => {
                    console.log('⏰ 10 seconds elapsed! Marking as complete');
                    this.completeMaterial(materialId, 10);
                }, 10000);
            },
            
            trackMediaMaterial(materialId, mediaType) {
                console.log('🎥 trackMediaMaterial called');
                this.markMaterialStarted(materialId);
                
                const mediaElement = document.getElementById(`${mediaType}-${materialId}`);
                if (!mediaElement) {
                    console.error('❌ Media element not found');
                    return;
                }
                
                let watchedTime = 0;
                let lastTime = 0;
                const progressIndicator = document.getElementById(`progress-indicator-${materialId}`);
                const progressBar = document.getElementById(`progress-bar-${materialId}`);
                const progressPercentage = document.getElementById(`progress-percentage-${materialId}`);
                
                if (progressIndicator) {
                    progressIndicator.classList.remove('hidden');
                }
                
                mediaElement.addEventListener('timeupdate', () => {
                    if (mediaElement.currentTime > lastTime) {
                        watchedTime += (mediaElement.currentTime - lastTime);
                        lastTime = mediaElement.currentTime;
                    } else {
                        lastTime = mediaElement.currentTime;
                    }
                    
                    if (mediaElement.duration > 0) {
                        const percentage = (watchedTime / mediaElement.duration) * 100;
                        if (progressBar) progressBar.style.width = `${Math.min(percentage, 100)}%`;
                        if (progressPercentage) progressPercentage.textContent = `${Math.min(Math.round(percentage), 100)}%`;
                    }
                });
                
                mediaElement.addEventListener('ended', () => {
                    const watchedPercentage = (watchedTime / mediaElement.duration) * 100;
                    if (watchedPercentage >= 90) {
                        this.completeMaterial(materialId, Math.floor(watchedTime));
                    }
                });
                
                mediaElement.addEventListener('pause', () => {
                    if (mediaElement.currentTime >= mediaElement.duration * 0.9) {
                        this.completeMaterial(materialId, Math.floor(watchedTime));
                    }
                });
            },

            trackYouTubeMaterial(materialId) {
                console.log('📺 trackYouTubeMaterial called for ID:', materialId);
                this.markMaterialStarted(materialId);

                // Find the YouTube iframe
                const iframe = document.querySelector(`iframe[src*="youtube.com/embed"][data-material-id="${materialId}"], iframe[src*="youtube.com/embed"]:not([data-material-id])`);

                if (!iframe) {
                    console.error('❌ YouTube iframe not found for material:', materialId);
                    return;
                }

                // Set material ID if not already set
                if (!iframe.hasAttribute('data-material-id')) {
                    iframe.setAttribute('data-material-id', materialId);
                }

                // Ensure iframe has enablejsapi parameter
                const currentSrc = iframe.src;
                if (!currentSrc.includes('enablejsapi=1')) {
                    const separator = currentSrc.includes('?') ? '&' : '?';
                    iframe.src = currentSrc + separator + 'enablejsapi=1';
                }

                // Initialize YouTube Player when API is ready
                const initYouTubePlayer = () => {
                    if (typeof YT === 'undefined' || !YT.Player) {
                        console.log('⏳ YouTube API not ready, waiting...');
                        setTimeout(initYouTubePlayer, 500);
                        return;
                    }

                    try {
                        const player = new YT.Player(iframe, {
                            events: {
                                'onStateChange': (event) => this.onYouTubePlayerStateChange(event, materialId)
                            }
                        });
                        this.youtubeTrackers[materialId] = {
                            player: player,
                            watchedTime: 0,
                            lastTime: 0,
                            checkInterval: null,
                            isPlaying: false,
                            completed: false
                        };

                        // Track watched time while video is playing
                        this.youtubeTrackers[materialId].checkInterval = setInterval(() => {
                            const tracker = this.youtubeTrackers[materialId];
                            if (tracker && tracker.isPlaying && tracker.player && typeof tracker.player.getCurrentTime === 'function') {
                                try {
                                    const currentTime = tracker.player.getCurrentTime();
                                    // Only add to watched time if moving forward (not seeking)
                                    // Skip large jumps (> 2 seconds) which indicate seeking
                                    if (currentTime > tracker.lastTime && (currentTime - tracker.lastTime) < 2) {
                                        tracker.watchedTime += (currentTime - tracker.lastTime);
                                    }
                                    tracker.lastTime = currentTime;

                                    // Check if 80% watched and mark as complete
                                    const duration = tracker.player.getDuration();
                                    if (duration > 0 && !tracker.completed) {
                                        const watchedPercentage = (tracker.watchedTime / duration) * 100;
                                        if (watchedPercentage >= 80) {
                                            console.log('✅ 80% watched! Marking YouTube video as complete.');
                                            tracker.completed = true;
                                            this.completeMaterial(materialId, Math.floor(tracker.watchedTime));
                                        }
                                    }
                                } catch (e) {
                                    console.log('Error tracking YouTube time:', e);
                                }
                            }
                        }, 1000);

                        console.log('✅ YouTube player initialized for material:', materialId);
                    } catch (error) {
                        console.error('❌ Error initializing YouTube player:', error);
                        // Fallback to timer-based tracking
                        this.fallbackYouTubeTracking(materialId);
                    }
                };

                // Check if YouTube API is loaded
                if (typeof YT !== 'undefined' && YT.Player) {
                    initYouTubePlayer();
                } else {
                    // Wait for YouTube API to load
                    window.onYouTubeIframeAPIReady = () => {
                        initYouTubePlayer();
                    };
                    // Also try after a delay in case the callback doesn't fire
                    setTimeout(initYouTubePlayer, 2000);
                }
            },

            onYouTubePlayerStateChange(event, materialId) {
                const tracker = this.youtubeTrackers[materialId];
                if (!tracker) return;

                // YT.PlayerState: ENDED=0, PLAYING=1, PAUSED=2, BUFFERING=3, CUED=5
                if (event.data === YT.PlayerState.PLAYING) {
                    tracker.isPlaying = true;
                    console.log('▶️ YouTube video playing for material:', materialId);
                } else if (event.data === YT.PlayerState.PAUSED) {
                    tracker.isPlaying = false;
                    console.log('⏸️ YouTube video paused for material:', materialId);
                } else if (event.data === YT.PlayerState.ENDED) {
                    tracker.isPlaying = false;
                    console.log('🏁 YouTube video ended for material:', materialId);

                    // Check if 80% was watched before marking as complete
                    if (!tracker.completed) {
                        try {
                            const duration = tracker.player.getDuration();
                            const watchedPercentage = (tracker.watchedTime / duration) * 100;
                            console.log(`📊 Final watch percentage: ${watchedPercentage.toFixed(1)}%`);

                            if (watchedPercentage >= 80) {
                                console.log('✅ 80% watched! Marking as complete.');
                                tracker.completed = true;
                                this.completeMaterial(materialId, Math.floor(tracker.watchedTime));
                            } else {
                                console.log(`⚠️ Only ${watchedPercentage.toFixed(1)}% watched. Need 80% to complete.`);
                            }
                        } catch (e) {
                            console.log('Error checking final percentage:', e);
                        }
                    }

                    // Clear the tracking interval
                    if (tracker.checkInterval) {
                        clearInterval(tracker.checkInterval);
                    }
                }
            },

            fallbackYouTubeTracking(materialId) {
                console.log('📺 Using fallback timer-based tracking for YouTube');
                if (this.materialTimers[materialId]) {
                    clearTimeout(this.materialTimers[materialId]);
                }
                this.materialTimers[materialId] = setTimeout(() => {
                    console.log('⏰ 30 seconds elapsed for YouTube video! Marking as complete');
                    this.completeMaterial(materialId, 30);
                }, 30000);
            },

            markMaterialStarted(materialId) {
                fetch("{{ route('cadet.learning.start') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ material_id: materialId })
                })
                .then(response => response.json())
                .then(data => console.log('✅ Material started:', data))
                .catch(error => console.error('❌ Error:', error));
            },
            
            completeMaterial(materialId, timeSpent) {
                console.log('🎉 COMPLETE MATERIAL CALLED for ID:', materialId);
                
                if (this.completedMaterials.has(materialId)) {
                    console.log('⚠️ Already completed - skipping');
                    return;
                }
                
                fetch("{{ route('cadet.learning.complete') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        material_id: materialId,
                        time_spent: timeSpent
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('✅ Material marked as complete!');
                        this.completedMaterials.add(materialId);
                        this.showCompletionNotification();
                        this.showCompletionBadge(materialId);
                        this.highlightCompletedMaterial(materialId);
                    }
                })
                .catch(error => console.error('❌ Error:', error));
            },
            
            showCompletionBadge(materialId) {
                const badge = document.getElementById(`completion-badge-${materialId}`);
                const checkmark = document.getElementById(`checkmark-${materialId}`);
                if (badge) badge.classList.remove('hidden');
                if (checkmark) checkmark.classList.remove('hidden');
            },
            
            highlightCompletedMaterial(materialId) {
                const button = document.getElementById(`material-button-${materialId}`);
                const container = document.getElementById(`material-${materialId}`);
                
                if (button) {
                    button.classList.remove('bg-blue-100', 'hover:bg-blue-200', 'text-blue-800');
                    button.classList.add('bg-green-100', 'hover:bg-green-200', 'text-green-800');
                }
                if (container) {
                    container.classList.remove('border-gray-200');
                    container.classList.add('border-green-300');
                }
            },
            
            showCompletionNotification() {
                const notification = document.createElement('div');
                notification.innerHTML = `
                    <div style="position:fixed;top:20px;right:20px;background:linear-gradient(to right,#10b981,#059669);color:white;padding:1rem 1.5rem;border-radius:0.5rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);z-index:9999;animation:slideIn 0.3s">
                        <div style="display:flex;align-items:center;gap:0.5rem">
                            <svg style="width:1.5rem;height:1.5rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span style="font-weight:600">Learning material completed! 🎉</span>
                        </div>
                    </div>
                `;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            },
            
            // UPDATED: Load completion states from server
            loadInitialProgress() {
                console.log('📊 Loading initial progress...');
                fetch("{{ route('cadet.learning.progress') }}")
                    .then(response => response.json())
                    .then(data => {
                        console.log('Progress loaded:', data);
                        if (data.success && data.material_progress) {
                            // Apply completion state to each material
                            Object.entries(data.material_progress).forEach(([id, isCompleted]) => {
                                if (isCompleted) {
                                    const materialId = parseInt(id);
                                    this.completedMaterials.add(materialId);
                                    this.highlightCompletedMaterial(materialId);
                                    this.showCompletionBadge(materialId);
                                }
                            });
                        }
                    })
                    .catch(error => console.error('Error loading progress:', error));
            },
            
            cleanup(materialId) {
                if (this.materialTimers[materialId]) {
                    clearTimeout(this.materialTimers[materialId]);
                    delete this.materialTimers[materialId];
                }
            }
        };

        // Function to filter materials by category
        function filterMaterials(categoryId) {
            // Redirect with category parameter
            const url = new URL(window.location.href);
            if (categoryId) {
                url.searchParams.set('category', categoryId);
            } else {
                url.searchParams.delete('category');
            }
            window.location.href = url.toString();
        }

        // Load initial progress when page loads
        document.addEventListener('DOMContentLoaded', function() {
            LearningProgressTracker.loadInitialProgress();
        });

       // Material accordion toggle (CORRECTED VERSION)
        let currentOpenMaterial = null;

        function toggleMaterial(materialId, materialType, fileUrl) {
            const contentDiv = document.getElementById(`material-content-${materialId}`);
            const chevron = document.getElementById(`chevron-${materialId}`);

            console.log('   Content div found:', contentDiv ? 'YES ✓' : 'NO ✗');
            console.log('   Chevron found:', chevron ? 'YES ✓' : 'NO ✗');

            if (!contentDiv) {
                console.error('❌ Content div not found for material:', materialId);
                console.error('   Looking for ID:', `material-content-${materialId}`);
                return;
            }

            // Check if this material is already open
            const isCurrentlyOpen = contentDiv.classList.contains('show');

            if (isCurrentlyOpen) {
                console.log('🔽 Closing material');
                // Close it
                contentDiv.classList.remove('show');
                if (chevron) chevron.classList.remove('rotate-180');
                currentOpenMaterial = null;
                LearningProgressTracker.cleanup(materialId);
            } else {
                console.log('🔼 Opening material');

                // Close previously open material
                if (currentOpenMaterial !== null && currentOpenMaterial !== materialId) {
                    console.log('   Closing previous material:', currentOpenMaterial);
                    const prevContent = document.getElementById(`material-content-${currentOpenMaterial}`);
                    const prevChevron = document.getElementById(`chevron-${currentOpenMaterial}`);
                    if (prevContent) prevContent.classList.remove('show');
                    if (prevChevron) prevChevron.classList.remove('rotate-180');
                    LearningProgressTracker.cleanup(currentOpenMaterial);
                }

                // Open new material
                contentDiv.classList.add('show');
                if (chevron) chevron.classList.add('rotate-180');
                currentOpenMaterial = materialId;

                // Initialize tracking after a short delay
                console.log('⏱️ Scheduling tracker initialization...');
                setTimeout(() => {
                    console.log('▶️ Calling LearningProgressTracker.init');
                    LearningProgressTracker.init(materialId, materialType, fileUrl);
                }, 100);
            }
        }

        console.log('✅ toggleMaterial function defined');

        // ========================================
        // MEDIA MODAL (IMAGE & VIDEO LIGHTBOX)
        // ========================================
        function openImageModal(imageSrc, title) {
            const modal = document.getElementById('imagePreviewModal');
            const imageLoader = document.getElementById('imageLoader');

            // Show loader
            imageLoader.style.display = 'flex';

            // Set image
            document.getElementById('previewImage').src = imageSrc;

            // Show modal
            modal.classList.remove('hidden');
            modal.style.animation = 'fadeIn 0.3s ease-in-out';
            document.body.style.overflow = 'hidden';
        }

        function openVideoModal(videoSrc, title) {
            const modal = document.getElementById('videoPreviewModal');
            const video = document.getElementById('previewVideo');

            // Set video
            video.src = videoSrc;

            // Show modal
            modal.classList.remove('hidden');
            modal.style.animation = 'fadeIn 0.3s ease-in-out';
            document.body.style.overflow = 'hidden';

            // Play video
            video.play();
        }

        function closeImageModal() {
            const modal = document.getElementById('imagePreviewModal');
            modal.style.animation = 'fadeOut 0.2s ease-in-out';

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoPreviewModal');
            const video = document.getElementById('previewVideo');

            // Pause and reset video
            video.pause();
            video.currentTime = 0;

            modal.style.animation = 'fadeOut 0.2s ease-in-out';
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        // Close modal when clicking outside or pressing Escape
        document.addEventListener('DOMContentLoaded', function() {
            const imageModal = document.getElementById('imagePreviewModal');
            const videoModal = document.getElementById('videoPreviewModal');

            if (imageModal) {
                imageModal.addEventListener('click', function(e) {
                    if (e.target === imageModal) {
                        closeImageModal();
                    }
                });
            }

            if (videoModal) {
                videoModal.addEventListener('click', function(e) {
                    if (e.target === videoModal) {
                        closeVideoModal();
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                    closeVideoModal();
                }
            });

            // Mobile info tooltip toggle
            const tooltipWrappers = document.querySelectorAll('.info-tooltip-wrapper');
            tooltipWrappers.forEach(wrapper => {
                const infoIcon = wrapper.querySelector('.info-icon');
                if (infoIcon) {
                    infoIcon.addEventListener('click', function(e) {
                        e.stopPropagation();
                        // Close other tooltips first
                        tooltipWrappers.forEach(w => {
                            if (w !== wrapper) w.classList.remove('active');
                        });
                        wrapper.classList.toggle('active');
                    });
                }
            });

            // Close tooltip when clicking outside
            document.addEventListener('click', function(e) {
                tooltipWrappers.forEach(wrapper => {
                    if (!wrapper.contains(e.target)) {
                        wrapper.classList.remove('active');
                    }
                });
            });
        });
    </script>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden flex items-center justify-center transition-all duration-300">
        <div class="relative max-w-6xl w-full p-4">
            <!-- Close Button (Outside on right) -->
            <button onclick="closeImageModal()" class="absolute top-4 right-4 z-20 text-white hover:text-gray-300 bg-black bg-opacity-60 hover:bg-opacity-80 rounded-full p-3 transition-all duration-200 transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="flex items-center justify-center">
                <!-- Image Container with Loading -->
                <div class="relative flex items-center justify-center">
                    <div id="imageLoader" class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white"></div>
                    </div>
                    <img id="previewImage" src="" alt="" class="max-w-full max-h-[90vh] object-contain rounded-xl shadow-2xl" onload="document.getElementById('imageLoader').style.display='none'">
                </div>
            </div>
        </div>
    </div>

    <!-- Video Preview Modal -->
    <div id="videoPreviewModal" class="fixed inset-0 bg-black bg-opacity-95 z-50 hidden flex items-center justify-center transition-all duration-300">
        <div class="relative max-w-6xl w-full p-4">
            <!-- Close Button (Outside on right) -->
            <button onclick="closeVideoModal()" class="absolute top-4 right-4 z-20 text-white hover:text-gray-300 bg-black bg-opacity-60 hover:bg-opacity-80 rounded-full p-3 transition-all duration-200 transform hover:scale-110">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="flex items-center justify-center">
                <!-- Video Container -->
                <video id="previewVideo" controls class="max-w-full max-h-[90vh] rounded-xl shadow-2xl">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>

    {{-- YouTube IFrame API --}}
    <script src="https://www.youtube.com/iframe_api"></script>
</x-app-layout>
