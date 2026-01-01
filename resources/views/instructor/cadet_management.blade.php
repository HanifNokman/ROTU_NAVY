<x-app-layout>
    {{-- ================================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================================ --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadet Administration') }}
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

    .gradient-yellow {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    }

    /* ========================================= */
    /* DROPDOWN ANIMATION STYLES */
    /* ========================================= */
    .section-content-dropdown {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .section-content-dropdown.show {
        max-height: 5000px;
        transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .section-content-dropdown:not(.show) > div {
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s ease-out, transform 0.3s ease-out;
    }

    .section-content-dropdown.show > div {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.3s ease-in 0.1s, transform 0.3s ease-in 0.1s;
    }

    .chevron-icon {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========================================= */
    /* EXISTING STYLES */
    /* ========================================= */
    #duty-ranking-content {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    #cgpa-content {
        max-height: 300px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    #duty-ranking-content::-webkit-scrollbar,
    #cgpa-content::-webkit-scrollbar {
        width: 8px;
    }

    #duty-ranking-content::-webkit-scrollbar-track,
    #cgpa-content::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #duty-ranking-content::-webkit-scrollbar-thumb,
    #cgpa-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    #duty-ranking-content::-webkit-scrollbar-thumb:hover,
    #cgpa-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #duty-ranking-content,
    #cgpa-content {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    #duty-ranking-content,
    #cgpa-content {
        scroll-behavior: smooth;
    }

    .duty-ranking-wrapper,
    .cgpa-wrapper {
        position: relative;
    }

    /* ========================================= */
    /* INFO CARD STYLES */
    /* ========================================= */
    .info-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }

    .info-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border-color: #d1d5db;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        background: #f9fafb;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease-in-out;
    }

    .info-item:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
    }

    .icon-wrapper-sm {
        width: 2rem;
        height: 2rem;
        border-radius: 0.375rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 0.75rem;
    }

    /* ========================================= */
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 640px) {
        .info-grid {
            grid-template-columns: 1fr;
        }

        /* Page header */
        .text-center.mb-8 h1 {
            font-size: 1.875rem !important;
            padding: 0 1rem;
        }

        .text-center.mb-8 p {
            font-size: 0.875rem !important;
            padding: 0 1rem;
        }

        /* Filter section - full width stacking */
        .flex.flex-wrap {
            flex-direction: column !important;
            gap: 1rem !important;
        }

        .flex.flex-wrap > div {
            width: 100% !important;
        }

        .flex.flex-wrap select,
        .flex.flex-wrap input {
            width: 100% !important;
            font-size: 0.875rem !important;
        }

        /* Information Type section - override parent flex-col */
        .mb-6.flex.flex-col.space-y-4 > div:last-child {
            width: 100% !important;
        }

        .mb-6.flex.flex-col.space-y-4 > div:last-child > label {
            font-size: 0.875rem !important;
            margin-bottom: 0.75rem !important;
            font-weight: 600 !important;
        }

        /* Information Type buttons container */
        .flex.space-x-2.flex-wrap,
        div.flex.space-x-2.flex-wrap.gap-y-2 {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 0.625rem !important;
            width: 100% !important;
            justify-content: flex-start !important;
        }

        .info-type-btn {
            flex: 0 0 calc((100% - 1.25rem) / 3) !important;
            min-width: calc((100% - 1.25rem) / 3) !important;
            max-width: calc((100% - 1.25rem) / 3) !important;
            padding: 0.75rem 0.5rem !important;
            font-size: 0.875rem !important;
            text-align: center !important;
            justify-content: center !important;
            white-space: nowrap !important;
            font-weight: 500 !important;
            border-radius: 0.5rem !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
            display: flex !important;
            align-items: center !important;
        }

        .info-type-btn:active {
            transform: scale(0.98) !important;
        }

        /* Personnel mode container - better mobile layout */
        #personnelModeContainer .flex.items-center.justify-between {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
        }

        /* Mode radio buttons */
        #personnelModeContainer .flex.items-center.space-x-4 {
            flex-direction: row !important;
            flex-wrap: wrap !important;
            gap: 1rem !important;
        }

        #personnelModeContainer label.text-sm.font-medium {
            width: 100% !important;
            margin-bottom: 0.5rem !important;
        }

        /* Action buttons container - side by side layout */
        #personnelActionButtonsContainer {
            display: flex !important;
            flex-direction: row !important;
            gap: 0.625rem !important;
            width: 100% !important;
            margin-top: 0.5rem !important;
        }

        #personnelActionButtonsContainer button {
            flex: 1 !important;
            justify-content: center !important;
            padding: 1rem 0.75rem !important;
            font-size: 0.875rem !important;
            white-space: nowrap !important;
            text-align: center !important;
            display: flex !important;
            align-items: center !important;
            min-height: 3rem !important;
            line-height: 1.25rem !important;
        }

        #personnelActionButtonsContainer button svg {
            flex-shrink: 0 !important;
            margin-right: 0.5rem !important;
        }

        /* For very long button text, allow wrapping */
        #personnelActionButtonsContainer button span {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        /* Cadet Intake dropdown */
        select {
            width: 100% !important;
        }

        /* Cadet cards */
        .flex.flex-col.md\\:flex-row {
            flex-direction: column !important;
        }

        /* Profile pictures */
        .w-32.h-44 {
            width: 8rem !important;
            height: 11rem !important;
        }

        /* Badge display */
        .grid.grid-cols-3 {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.375rem !important;
        }

        /* Icon wrapper sizes */
        .icon-wrapper {
            width: 2rem !important;
            height: 2rem !important;
        }

        .icon-wrapper svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }

        /* Table container - ensure horizontal scrolling */
        .overflow-x-auto {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
            display: block !important;
            position: relative !important;
            border-radius: 0.5rem !important;
            box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1) !important;
        }

        /* Show scroll hint only on cadet table */
        #cadetTableContainer::after {
            content: '← Scroll →' !important;
            position: absolute !important;
            bottom: 0.5rem !important;
            right: 0.5rem !important;
            background: rgba(59, 130, 246, 0.9) !important;
            color: white !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 0.25rem !important;
            font-size: 0.625rem !important;
            pointer-events: none !important;
            z-index: 1 !important;
        }

        /* Don't override table width - let min-w-full work */
        table.min-w-full {
            font-size: 0.875rem !important;
        }

        table.min-w-full th,
        table.min-w-full td {
            padding: 0.75rem 1rem !important;
            white-space: nowrap !important;
        }

        table.min-w-full th {
            font-weight: 600 !important;
        }

        /* Grid-based table (cadet management) - enable horizontal scrolling */
        #cadetTableContainer {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            overflow-y: visible !important;
        }

        /* Wrapper for synchronized scrolling */
        #cadetTableContainer > div {
            min-width: 600px !important;
        }

        #cadetTableContainer .grid.grid-cols-5 {
            display: grid !important;
            grid-template-columns: repeat(5, 1fr) !important;
            width: 100% !important;
            gap: 0.5rem !important;
        }

        #cadetTableContainer .grid.grid-cols-5 > div {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            min-width: 0 !important;
        }

        /* Table body - only vertical scroll, no horizontal */
        #cadetTableBody {
            overflow-x: visible !important;
            overflow-y: auto !important;
        }

        /* Fix dropdown white area */
        .section-content-dropdown {
            background: transparent !important;
            padding: 0 !important;
        }

        .section-content-dropdown > div {
            background: white !important;
        }

        /* Modals */
        .fixed.inset-0 > div {
            margin: 1rem !important;
            max-width: calc(100vw - 2rem) !important;
        }
    }

    /* Extra small devices (Honor X9a - 360px-412px) */
    @media (max-width: 400px) {
        .text-center.mb-8 h1 {
            font-size: 1.5rem !important;
        }

        .section-header h3 {
            font-size: 1.125rem !important;
        }

        .w-32.h-44 {
            width: 7rem !important;
            height: 9.5rem !important;
        }

        .grid.grid-cols-3 {
            grid-template-columns: 1fr !important;
        }

        /* Information Type buttons - adjust for very small screens */
        .flex.space-x-2.flex-wrap {
            gap: 0.5rem !important;
        }

        .info-type-btn {
            font-size: 0.75rem !important;
            padding: 0.625rem 1rem !important;
        }

        /* Action buttons - adjust padding for small screens */
        #personnelActionButtonsContainer button {
            font-size: 0.75rem !important;
            padding: 0.75rem 0.5rem !important;
        }

        #personnelActionButtonsContainer button svg {
            width: 1rem !important;
            height: 1rem !important;
        }

        table.min-w-full {
            font-size: 0.8125rem !important;
        }

        table.min-w-full th,
        table.min-w-full td {
            padding: 0.625rem 0.75rem !important;
        }

        /* Adjust scroll hint */
        .overflow-x-auto::after {
            font-size: 0.5625rem !important;
            padding: 0.2rem 0.4rem !important;
        }
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE TITLE SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8 relative">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-blue rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">
                    Cadet Administration
                </h1>
                <p class="text-lg text-gray-600">Manage cadet information, positions, and qualifications</p>

                {{-- Tauliah Settings Button --}}
                <button
                    type="button"
                    onclick="openTauliahModal()"
                    class="absolute top-0 right-0 sm:top-0 sm:right-4 md:right-8"
                    aria-label="Tauliah Date Settings">
                    <div class="flex items-center space-x-1 sm:space-x-2 bg-white hover:bg-green-50 border-2 border-green-500 hover:border-green-600 text-green-700 px-2 py-1.5 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl active:scale-95 sm:hover:scale-105 transition-all duration-200 cursor-pointer">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-bold text-xs sm:text-base whitespace-nowrap">Tauliah Settings</span>
                    </div>
                </button>
            </div>

            {{-- ================================================================ --}}
            {{-- ACTIVE CADET MANAGEMENT SECTION (NOW AS DROPDOWN) --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header" style="cursor: pointer;">
                    <button onclick="toggleSection('activeCadetSection')" class="w-full flex flex-col text-left">
                        <!-- Top row: title + chevron -->
                        <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-blue mr-3 p-2 rounded-md">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Active Cadet Management</h3>
                        </div>
                            <svg class="chevron-icon w-6 h-6 text-gray-500 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 ml-13">Manage cadet information, positions, and qualifications</p>
                    </button>
                </div>
                
                <div id="activeCadetSection" class="section-content-dropdown show">
                    <div class="p-6">
                    {{-- ================================================================ --}}
                    {{-- SEARCH BAR --}}
                    {{-- ================================================================ --}}
                    <div class="mb-6">
                        <div class="flex items-center space-x-2">
                            <div class="flex-1 relative">
                                <input type="text" 
                                       id="searchInput"
                                       placeholder="Search by name, service number, matric number, or IC number..."
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            
                            <button id="clearSearchBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors hidden">
                                Clear
                            </button>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- FILTERS AND CONTROLS SECTION --}}
                    {{-- ================================================================ --}}
                    <div class="mb-6 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:justify-between items-start">

                        {{-- Left Side: Intake and Dynamic Filters --}}
                        <div class="flex flex-row space-x-4 items-center flex-wrap gap-y-4">

                            {{-- Intake Filter --}}
                            <div class="flex flex-col">
                                <label class="text-sm font-medium text-gray-700 mb-1">Cadet Intake</label>
                                <select id="intakeFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 min-w-[180px]">
                                    @if(!empty($recentIntakes) && is_array($recentIntakes))
                                        @foreach($recentIntakes as $intake)
                                            <option value="{{ $intake['year'] }}" {{ $intakeYear == $intake['year'] ? 'selected' : '' }}>
                                                {{ $intake['label'] }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- Dynamic Filter (Changes based on Info Type) --}}
                            <div id="dynamicFilterContainer" class="flex flex-col">
                                <label class="text-sm font-medium text-gray-700 mb-1" id="dynamicFilterLabel">Filter</label>
                                <select id="dynamicFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 min-w-[120px]">
                                    <option value="all">All</option>
                                </select>
                            </div>

                            {{-- Additional Dynamic Filter (For Swimming Pass Date) --}}
                            <div id="additionalFilterContainer" class="flex flex-col hidden">
                                <label class="text-sm font-medium text-gray-700 mb-1" id="additionalFilterLabel">Pass Date</label>
                                <select id="additionalFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 min-w-[120px]">
                                    <option value="all">All</option>
                                </select>
                            </div>
                        </div>

                        {{-- Right Side: Information Type Toggle Buttons --}}
                        <div class="flex flex-col">
                            <label class="text-sm font-medium text-gray-700 mb-1">Information Type</label>
                            <div class="flex space-x-2 flex-wrap gap-y-2">
                                <button class="info-type-btn px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $infoType == 'personnel' ? 'bg-[#3c92d9] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}" data-info-type="personnel">Personnel</button>
                                <button class="info-type-btn px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $infoType == 'position' ? 'bg-[#3c92d9] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}" data-info-type="position">Position</button>
                                <button class="info-type-btn px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $infoType == 'gender' ? 'bg-[#3c92d9] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}" data-info-type="gender">Gender</button>
                                <button class="info-type-btn px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $infoType == 'cgpa' ? 'bg-[#3c92d9] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}" data-info-type="cgpa">CGPA</button>
                                <button class="info-type-btn px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $infoType == 'swimming' ? 'bg-[#3c92d9] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}" data-info-type="swimming">Swimming</button>
                                <button class="info-type-btn px-3 py-2 rounded-md text-sm font-medium transition-colors {{ $infoType == 'bmi' ? 'bg-[#3c92d9] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}" data-info-type="bmi">BMI</button>
                            </div>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- PERSONNEL MODE TOGGLE --}}
                    {{-- ================================================================ --}}
                    <div id="personnelModeContainer" class="mb-4 hidden">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <label class="text-sm font-medium text-gray-700">Mode:</label>
                                <div class="flex items-center space-x-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="personnelMode" value="rank_up" class="mr-2" {{ $personnelMode == 'rank_up' ? 'checked' : '' }}>
                                        <span class="text-sm">Rank Up</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="personnelMode" value="suspend" class="mr-2" {{ $personnelMode == 'suspend' ? 'checked' : '' }}>
                                        <span class="text-sm">Suspend</span>
                                    </label>
                                </div>
                            </div>
                            <div id="personnelActionButtonsContainer" class="flex space-x-2">
                                {{-- Select All Button --}}
                                <button id="selectAllBtn"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed hidden">
                                    Select All
                                </button>

                                {{-- Rank Up Button --}}
                                <button id="rankUpBtn"
                                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed hidden">
                                    Rank Up Selected (PK → PKK)
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- ACTION BUTTONS CONTAINER --}}
                    {{-- ================================================================ --}}
                    <div id="actionButtonsContainer" class="mb-4 flex justify-end hidden">
                        {{-- Save Changes Button (Position Management) --}}
                        <button id="savePositionsBtn"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed">
                            Save Changes
                        </button>

                        {{-- Mark as Passed Button (Swimming Management) --}}
                        <button id="markAsPassedBtn"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed hidden"
                                disabled>
                            Mark Selected as Passed
                        </button>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- LOADING INDICATOR --}}
                    {{-- ================================================================ --}}
                    <div id="loadingIndicator" class="hidden text-center py-8">
                        <svg class="animate-spin h-8 w-8 mx-auto text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 mt-2">Loading cadets...</p>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- CADET TABLE SECTION --}}
                    {{-- ================================================================ --}}
                    <div id="cadetTableContainer" class="border border-gray-200 rounded-lg overflow-hidden">
                        
                        {{-- Table Header (Fixed) --}}
                        <div class="bg-gray-50 border-b border-gray-200 sticky top-0 z-10">
                            <div class="px-6 py-3">
                                <div class="grid grid-cols-5 gap-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div>No.</div>
                                    <div>Service Number</div>
                                    <div>Name</div>
                                    <div id="dynamicColumnHeader">Information</div>
                                    <div id="actionsColumnHeader">Actions</div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Table Body (Scrollable - Max 5 rows visible) --}}
                        <div id="cadetTableBody" class="overflow-y-auto bg-white" style="max-height: calc(5 * 72px);">
                            {{-- Content will be loaded via AJAX --}}
                            @forelse($cadets as $index => $cadet)
                                <div class="border-b border-gray-200 hover:bg-gray-50 cursor-pointer cadet-row px-6 py-4" 
                                     data-cadet-id="{{ $cadet->id }}">
                                    <div class="grid grid-cols-5 gap-4 items-center">
                                        <div class="text-sm text-gray-900">{{ $cadets->firstItem() + $index }}</div>
                                        <div class="text-sm text-gray-900">{{ $cadet->service_number ?? 'N/A' }}</div>
                                        <div class="text-sm font-medium text-gray-900">{{ $cadet->user->name ?? 'Unknown' }}</div>
                                        <div class="text-sm text-gray-900" data-column-type="{{ $infoType }}">
                                            {{-- Dynamic content based on info type --}}
                                        </div>
                                        <div class="text-sm font-medium">
                                            {{-- Actions will be rendered dynamically --}}
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-8 text-center">
                                    <div class="text-sm text-gray-500">No cadets found matching the current filters.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- PAGINATION SECTION --}}
                    {{-- ================================================================ --}}
                    <div id="paginationContainer" class="mt-6">
                        {{ $cadets->appends(request()->query())->links() }}
                    </div>

                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- BEST CADET SUGGESTIONS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header" style="cursor: pointer;">
                    <button onclick="toggleSection('bestCadetSection')" class="w-full flex flex-col text-left">
                        <!-- Top row: title + chevron -->
                        <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-yellow mr-3 p-2 rounded-md">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Best Cadet Candidates</h3>
                        </div>
                            <svg class="chevron-icon w-6 h-6 text-gray-500 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 ml-13">View top-performing cadets based on performance ratings and points.</p>
                    </button>
                </div>
                
                <div id="bestCadetSection" class="section-content-dropdown">
                    <div class="p-6">
                    <div class="mb-4 flex justify-center">
                        <select id="bestCadetIntakeFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($recentIntakes as $intake)
                                <option value="{{ $intake['year'] }}" {{ $bestCadetIntakeYear == $intake['year'] ? 'selected' : '' }}>
                                    {{ $intake['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="bestCadetLoadingIndicator" class="hidden text-center py-8">
                        <svg class="animate-spin h-8 w-8 mx-auto text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 mt-2">Loading best cadets...</p>
                    </div>

                    <div id="bestCadetContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        @forelse($bestCadets as $index => $cadet)
                            <div class="bg-gradient-to-br from-yellow-50 to-amber-50 border-2 border-yellow-200 rounded-lg p-4 hover:shadow-lg transition-all duration-200">
                                <div class="text-center mb-3">
                                    <div class="text-2xl font-bold text-yellow-600 mb-1">#{{ $index + 1 }}</div>
                                    @if($cadet->profile_pic)
                                        <img src="{{ asset('storage/' . $cadet->profile_pic) }}" alt="Profile" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-yellow-300">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($cadet->user->name) }}" alt="Profile" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-yellow-300">
                                    @endif
                                </div>
                                <div class="space-y-1 text-sm">
                                    <div class="font-semibold text-gray-800 text-center">{{ $cadet->rank ?? 'Cadet' }}</div>
                                    <div class="font-medium text-gray-900 text-center">{{ $cadet->user->name }}</div>
                                    <div class="text-gray-600 text-center">{{ $cadet->service_number }}</div>
                                    <div class="border-t border-yellow-200 pt-2 mt-2">
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-yellow-700">{{ number_format($cadet->performanceRating->total_points ?? 0, 0) }}</div>
                                            <div class="text-xs text-gray-600">Total Points</div>
                                        </div>
                                        <div class="text-center mt-1">
                                            <div class="text-lg">{{ $cadet->performanceRating->rating ?? '⭐☆☆☆☆' }}</div>
                                        </div>
                                        <div class="text-center mt-1">
                                            <div class="text-sm font-semibold text-yellow-600">{{ number_format($cadet->current_cgpa ?? 0, 2) }} CGPA</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-5 text-center text-gray-500 py-8">
                                No cadets found for this intake
                            </div>
                        @endforelse
                    </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- BEST ACADEMIC CANDIDATE SUGGESTIONS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header" style="cursor: pointer;">
                    <button onclick="toggleSection('bestAcademicSection')" class="w-full flex flex-col text-left">
                        <!-- Top row: title + chevron -->
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="icon-wrapper gradient-green mr-3 p-2 rounded-md">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                            <h3 class="text-2xl font-bold text-gray-900">Best Academic Candidates</h3>
                        </div>
                            <svg class="chevron-icon w-6 h-6 text-gray-500 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 ml-13">View cadets with highest academic performance for scholarships and commendations.</p>
                    </button>
                </div>
                
                <div id="bestAcademicSection" class="section-content-dropdown">
                    <div class="p-6">
                    <div class="mb-4 flex justify-center">
                        <select id="bestAcademicIntakeFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($recentIntakes as $intake)
                                <option value="{{ $intake['year'] }}" {{ $bestCadetIntakeYear == $intake['year'] ? 'selected' : '' }}>
                                    {{ $intake['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="bestAcademicLoadingIndicator" class="hidden text-center py-8">
                        <svg class="animate-spin h-8 w-8 mx-auto text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 mt-2">Loading academic candidates...</p>
                    </div>

                    <div id="bestAcademicContent" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        @forelse($bestAcademicCadets as $index => $cadet)
                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg p-4 hover:shadow-lg transition-all duration-200">
                                <div class="text-center mb-3">
                                    <div class="text-2xl font-bold text-green-600 mb-1">#{{ $index + 1 }}</div>
                                    @if($cadet->profile_pic)
                                        <img src="{{ asset('storage/' . $cadet->profile_pic) }}" alt="Profile" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-green-300">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($cadet->user->name) }}" alt="Profile" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-green-300">
                                    @endif
                                </div>
                                <div class="space-y-1 text-sm">
                                    <div class="font-semibold text-gray-800 text-center">{{ $cadet->rank ?? 'Cadet' }}</div>
                                    <div class="font-medium text-gray-900 text-center">{{ $cadet->user->name }}</div>
                                    <div class="text-gray-600 text-center">{{ $cadet->service_number }}</div>
                                    <div class="border-t border-green-200 pt-2 mt-2">
                                        <div class="text-center">
                                            <div class="text-lg font-bold text-green-700">{{ number_format($cadet->current_cgpa ?? 0, 2) }}</div>
                                            <div class="text-xs text-gray-600">CGPA</div>
                                        </div>
                                        <div class="text-center mt-1">
                                            <div class="text-sm font-semibold text-green-600">{{ number_format($cadet->performanceRating->academic_points ?? 0, 0) }} pts</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-5 text-center text-gray-500 py-8">
                                No cadets found for this intake
                            </div>
                        @endforelse
                    </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- SUSPENDED CADETS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header" style="cursor: pointer;">
                    <button onclick="toggleSection('suspendedSection')" class="w-full flex flex-col text-left">
                        <!-- Top row: title + chevron -->
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="icon-wrapper gradient-red mr-3 p-2 rounded-md">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                    </svg>
                                </div>
                            <h3 class="text-2xl font-bold text-gray-900">Suspended Cadets</h3>
                        </div>
                            <svg class="chevron-icon w-6 h-6 text-gray-500 transform transition-transform duration-200"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <p class="text-gray-600 ml-13">Manage suspended cadets and permanently delete them from the system.</p>
                    </button>
                </div>
                
                <div id="suspendedSection" class="section-content-dropdown">
                    <div class="p-6">
                    <div class="mb-4 flex justify-center">
                        <select id="suspendedIntakeFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($recentIntakes as $intake)
                                <option value="{{ $intake['year'] }}" {{ $suspendedIntakeYear == $intake['year'] ? 'selected' : '' }}>
                                    {{ $intake['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="suspendedLoadingIndicator" class="hidden text-center py-8">
                        <svg class="animate-spin h-8 w-8 mx-auto text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="text-gray-600 mt-2">Loading suspended cadets...</p>
                    </div>

                    <div id="suspendedTableContainer" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matric No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="suspendedTableBody" class="bg-white divide-y divide-gray-200">
                                @forelse($suspendedCadets as $cadet)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cadet->service_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cadet->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cadet->matric_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Suspended
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <button class="text-green-600 hover:text-green-900 reactivate-cadet-btn"
                                                    data-cadet-id="{{ $cadet->id }}"
                                                    data-cadet-name="{{ $cadet->user->name }}">
                                                Reactivate
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 delete-suspended-btn"
                                                    data-cadet-id="{{ $cadet->id }}"
                                                    data-cadet-name="{{ $cadet->user->name }}">
                                                Delete Permanently
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                                            No suspended cadets found for this intake
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CADET PROFILE MODAL --}}
    {{-- ================================================================ --}}
    <div id="cadetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Cadet Profile</h3>
                        <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="cadetProfileContent"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- SUSPEND CADET CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="suspendModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Cadet Suspension</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        To confirm suspension, please type the cadet's full name: 
                        <strong id="cadetNameToSuspend"></strong>
                    </p>
                    <input type="text" 
                           id="confirmationNameInputSuspend" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500 mb-4"
                           placeholder="Type the full name here">
                    <div class="flex justify-end space-x-3">
                        <button id="cancelSuspend" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button id="confirmSuspend" 
                                class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700">
                            Suspend Cadet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- REACTIVATE CADET CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="reactivateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Cadet Reactivation</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Are you sure you want to reactivate <strong id="cadetNameToReactivate"></strong>?
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button id="cancelReactivate"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button id="confirmReactivate"
                                class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                            Reactivate Cadet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- RANK UP CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="rankUpModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Rank Up</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Are you sure you want to rank up the selected cadets from <strong>PK</strong> to <strong>PKK</strong>?
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button id="cancelRankUp"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button id="confirmRankUp"
                                class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-md hover:bg-purple-700">
                            Confirm Rank Up
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- DELETE SUSPENDED CADET CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Permanent Deletion</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Are you sure you want to permanently delete <strong id="cadetNameToDelete"></strong>? This action cannot be undone.
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button id="cancelDelete"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button id="confirmDelete"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                            Delete Permanently
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>

    {{-- ================================================================ --}}
    {{-- TAULIAH SETTINGS MODAL --}}
    {{-- ================================================================ --}}
    <div id="tauliahModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-4 sm:p-5 border w-11/12 sm:w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900">Tauliah Date Settings</h3>
                    <button onclick="closeTauliahModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <p class="text-sm text-gray-600 mb-4">
                    Set the ceremony date and location for Tauliah promotion. Year is automatically calculated as Intake Year + 3.
                </p>

                <form id="tauliahForm" class="space-y-4">
                    <div>
                        <label for="tauliahMonth" class="block text-sm font-medium text-gray-700 mb-1">
                            Month
                        </label>
                        <select id="tauliahMonth" name="tauliah_month" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="1" {{ $tauliahMonth == 1 ? 'selected' : '' }}>January</option>
                            <option value="2" {{ $tauliahMonth == 2 ? 'selected' : '' }}>February</option>
                            <option value="3" {{ $tauliahMonth == 3 ? 'selected' : '' }}>March</option>
                            <option value="4" {{ $tauliahMonth == 4 ? 'selected' : '' }}>April</option>
                            <option value="5" {{ $tauliahMonth == 5 ? 'selected' : '' }}>May</option>
                            <option value="6" {{ $tauliahMonth == 6 ? 'selected' : '' }}>June</option>
                            <option value="7" {{ $tauliahMonth == 7 ? 'selected' : '' }}>July</option>
                            <option value="8" {{ $tauliahMonth == 8 ? 'selected' : '' }}>August</option>
                            <option value="9" {{ $tauliahMonth == 9 ? 'selected' : '' }}>September</option>
                            <option value="10" {{ $tauliahMonth == 10 ? 'selected' : '' }}>October</option>
                            <option value="11" {{ $tauliahMonth == 11 ? 'selected' : '' }}>November</option>
                            <option value="12" {{ $tauliahMonth == 12 ? 'selected' : '' }}>December</option>
                        </select>
                    </div>

                    <div>
                        <label for="tauliahDay" class="block text-sm font-medium text-gray-700 mb-1">
                            Day
                        </label>
                        <input type="number" id="tauliahDay" name="tauliah_day" min="1" max="31"
                               value="{{ $tauliahDay }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>

                    <div>
                        <label for="tauliahLocation" class="block text-sm font-medium text-gray-700 mb-1">
                            Ceremony Location
                        </label>
                        <input type="text" id="tauliahLocation" name="tauliah_location" maxlength="255"
                               value="{{ $tauliahLocation }}" placeholder="e.g., UMS KK, UPNM Sungai Besi"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        <p class="mt-1 text-xs text-gray-500">Specify where the commissioning ceremony will be held</p>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <p class="text-xs sm:text-sm text-blue-800">
                            <strong>Note:</strong> This applies to all cadets. Promotion year = Intake Year + 3.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-2">
                        <button type="button" onclick="closeTauliahModal()"
                                class="w-full sm:flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                                class="w-full sm:flex-1 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    @push('scripts')
    <script>
        // ============================================================
        // GLOBAL VARIABLES AND STATE
        // ============================================================
        let searchTimeout;
        let currentPage = 1;
        let hasUnsavedPositionChanges = false;
        let currentFilters = {
            infoType: '{{ $infoType }}',
            intakeYear: '{{ $intakeYear }}',
            filterBy: '{{ $filterBy }}',
            sortBy: '{{ $sortBy }}',
            search: '{{ $searchQuery }}',
            personnelMode: '{{ $personnelMode }}',
            swimmingPassDate: '{{ request("swimming_pass_date", "all") }}'
        };

        // Initialize the page on load
        document.addEventListener('DOMContentLoaded', function() {
            initializeDynamicFilters(currentFilters.infoType);
            loadCadets(1);
        });

        // ============================================================
        // SECTION TOGGLE FUNCTIONS
        // ============================================================
        window.toggleSection = function(sectionId) {
            const section = document.getElementById(sectionId);
            const chevron = document.querySelector(`[onclick="toggleSection('${sectionId}')"] .chevron-icon`);

            if (section.classList.contains('show')) {
                section.classList.remove('show');
                if (chevron) chevron.classList.remove('rotate-180');
            } else {
                section.classList.add('show');
                if (chevron) chevron.classList.add('rotate-180');

                // Load content when opening specific sections
                if (sectionId === 'bestCadetSection') {
                    const intakeYear = document.getElementById('bestCadetIntakeFilter')?.value;
                    if (intakeYear) {
                        loadBestCadets(intakeYear);
                    }
                } else if (sectionId === 'bestAcademicSection') {
                    const intakeYear = document.getElementById('bestAcademicIntakeFilter')?.value;
                    if (intakeYear) {
                        loadBestAcademicCadets(intakeYear);
                    }
                } else if (sectionId === 'suspendedSection') {
                    const intakeYear = document.getElementById('suspendedIntakeFilter')?.value;
                    if (intakeYear) {
                        loadSuspendedCadets(intakeYear);
                    }
                }
            }
        };

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // ============================================================
            // INITIALIZE DYNAMIC FILTERS
            // ============================================================
            initializeDynamicFilters(currentFilters.infoType);

            // ============================================================
            // EVENT LISTENERS: Search Input with Debounce
            // ============================================================
            document.getElementById('searchInput').addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchValue = this.value;

                searchTimeout = setTimeout(() => {
                    currentFilters.search = searchValue;
                    currentPage = 1;
                    loadCadets();

                    // Show/hide clear button
                    const clearBtn = document.getElementById('clearSearchBtn');
                    if (searchValue) {
                        clearBtn.classList.remove('hidden');
                    } else {
                        clearBtn.classList.add('hidden');
                    }
                }, 500);
            });

            document.getElementById('clearSearchBtn').addEventListener('click', function() {
                document.getElementById('searchInput').value = '';
                currentFilters.search = '';
                currentPage = 1;
                this.classList.add('hidden');
                loadCadets();
            });

            // ============================================================
            // EVENT LISTENERS: Filter Changes
            // ============================================================
            document.getElementById('intakeFilter').addEventListener('change', function() {
                // Check for unsaved changes before changing intake
                if (hasUnsavedPositionChanges) {
                    if (!confirm('You have unsaved position changes. Changing the intake will discard these changes. Continue?')) {
                        // Reset the select to previous value
                        this.value = currentFilters.intakeYear;
                        return;
                    }
                    hasUnsavedPositionChanges = false;
                    updateSaveButtonVisibility();
                }

                currentFilters.intakeYear = this.value;
                currentPage = 1;

                // Reload swimming pass dates if swimming info type is selected
                if (currentFilters.infoType === 'swimming') {
                    loadSwimmingPassDates();
                }

                loadCadets();
            });

            // Event listeners for Information Type Toggle Buttons
            document.querySelectorAll('.info-type-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const infoType = this.dataset.infoType;

                    // Update active button styling
                    document.querySelectorAll('.info-type-btn').forEach(b => {
                        b.classList.remove('bg-[#3c92d9]', 'text-white');
                        b.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                    });
                    this.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
                    this.classList.add('bg-[#3c92d9]', 'text-white');

                    // Update filters
                    currentFilters.infoType = infoType;
                    currentFilters.filterBy = 'all';
                    currentFilters.swimmingPassDate = 'all';
                    currentPage = 1;
                    initializeDynamicFilters(infoType);
                    loadCadets();
                });
            });

            document.getElementById('dynamicFilter').addEventListener('change', function() {
                currentFilters.filterBy = this.value;
                currentPage = 1;
                loadCadets();
            });

            const additionalFilter = document.getElementById('additionalFilter');
            if (additionalFilter) {
                additionalFilter.addEventListener('change', function() {
                    currentFilters.swimmingPassDate = this.value;
                    currentPage = 1;
                    loadCadets();
                });
            }

            // ============================================================
            // EVENT LISTENERS: Best Cadet Sections
            // ============================================================
            document.getElementById('bestCadetIntakeFilter')?.addEventListener('change', function() {
                loadBestCadets(this.value);
            });

            document.getElementById('bestAcademicIntakeFilter')?.addEventListener('change', function() {
                loadBestAcademicCadets(this.value);
            });

            document.getElementById('suspendedIntakeFilter')?.addEventListener('change', function() {
                loadSuspendedCadets(this.value);
            });

            // ============================================================
            // EVENT LISTENERS: Personnel Mode Toggle
            // ============================================================
            document.querySelectorAll('input[name="personnelMode"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    currentFilters.personnelMode = this.value;
                    currentPage = 1;
                    loadCadets();
                });
            });

            // ============================================================
            // EVENT LISTENERS: Cadet Checkbox Changes
            // ============================================================
            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('cadet-checkbox')) {
                    updateRankUpButtonState();
                }
            });

            // ============================================================
            // EVENT LISTENERS: Modal Controls
            // ============================================================
            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('cadetModal').classList.add('hidden');
            });

            document.getElementById('cancelSuspend')?.addEventListener('click', function() {
                document.getElementById('suspendModal').classList.add('hidden');
            });

            document.getElementById('confirmSuspend')?.addEventListener('click', function() {
                confirmSuspension();
            });

            document.getElementById('cancelRankUp')?.addEventListener('click', function() {
                document.getElementById('rankUpModal').classList.add('hidden');
            });

            document.getElementById('confirmRankUp')?.addEventListener('click', function() {
                confirmRankUp();
            });

            document.getElementById('cancelDelete')?.addEventListener('click', function() {
                document.getElementById('deleteModal').classList.add('hidden');
            });

            document.getElementById('confirmDelete')?.addEventListener('click', function() {
                confirmDeletion();
            });

            document.getElementById('cancelReactivate')?.addEventListener('click', function() {
                document.getElementById('reactivateModal').classList.add('hidden');
            });

            document.getElementById('confirmReactivate')?.addEventListener('click', function() {
                confirmReactivation();
            });

            // ============================================================
            // EVENT LISTENERS: Action Buttons
            // ============================================================

            // Attach event listeners to reactivate buttons
            document.querySelectorAll('.reactivate-cadet-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const cadetId = this.dataset.cadetId;
                    const cadetName = this.dataset.cadetName;
                    showReactivateModal(cadetId, cadetName);
                });
            });

            // Attach event listeners to delete buttons
            document.querySelectorAll('.delete-suspended-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const cadetId = this.dataset.cadetId;
                    const cadetName = this.dataset.cadetName;
                    showDeleteModal(cadetId, cadetName);
                });
            });

            document.getElementById('savePositionsBtn')?.addEventListener('click', function() {
                savePositions();
            });

            document.getElementById('selectAllBtn')?.addEventListener('click', function() {
                selectAllCadets();
            });

            document.getElementById('rankUpBtn')?.addEventListener('click', function() {
                showRankUpModal();
            });

            document.getElementById('markAsPassedBtn')?.addEventListener('click', function() {
                markSelectedAsPassed();
            });
        });

        // ============================================================
        // FUNCTION: Initialize Dynamic Filters
        // ============================================================
        function initializeDynamicFilters(infoType) {
            const dynamicFilterContainer = document.getElementById('dynamicFilterContainer');
            const additionalFilterContainer = document.getElementById('additionalFilterContainer');
            const personnelModeContainer = document.getElementById('personnelModeContainer');
            const dynamicFilterLabel = document.getElementById('dynamicFilterLabel');
            const dynamicFilter = document.getElementById('dynamicFilter');
            const actionButtonsContainer = document.getElementById('actionButtonsContainer');
            const savePositionsBtn = document.getElementById('savePositionsBtn');
            const markAsPassedBtn = document.getElementById('markAsPassedBtn');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const rankUpBtn = document.getElementById('rankUpBtn');

            // Reset visibility
            additionalFilterContainer.classList.add('hidden');
            personnelModeContainer.classList.add('hidden');
            actionButtonsContainer.classList.add('hidden');
            savePositionsBtn.classList.add('hidden');
            markAsPassedBtn.classList.add('hidden');
            selectAllBtn.classList.add('hidden');
            rankUpBtn.classList.add('hidden');

            // Clear existing options
            dynamicFilter.innerHTML = '';

            if (infoType === 'personnel') {
                // Show personnel mode toggle
                personnelModeContainer.classList.remove('hidden');
                dynamicFilterContainer.classList.add('hidden');

                // Show appropriate action buttons based on mode
                if (currentFilters.personnelMode === 'rank_up') {
                    actionButtonsContainer.classList.remove('hidden');
                    selectAllBtn.classList.remove('hidden');
                    rankUpBtn.classList.remove('hidden');
                }
            } else if (infoType === 'seniority') {
                // Hide dynamic filter for seniority
                dynamicFilterContainer.classList.add('hidden');
            } else {
                dynamicFilterContainer.classList.remove('hidden');

                switch(infoType) {
                    case 'bmi':
                        dynamicFilterLabel.textContent = 'Sort Order';
                        dynamicFilter.innerHTML = `
                            <option value="all">All</option>
                            <option value="overweight">BMI > 26.9</option>
                            <option value="underweight">BMI < 18.0</option>
                        `;
                        break;
                        
                    case 'position':
                        dynamicFilterLabel.textContent = 'Filter';
                        dynamicFilter.innerHTML = `
                            <option value="all">All</option>
                            <option value="rank_holders">Rank Holders Only</option>
                        `;
                        actionButtonsContainer.classList.remove('hidden');
                        savePositionsBtn.classList.remove('hidden');
                        break;
                        
                    case 'gender':
                        dynamicFilterLabel.textContent = 'Gender';
                        dynamicFilter.innerHTML = `
                            <option value="all">All</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        `;
                        break;
                        
                    case 'swimming':
                        dynamicFilterLabel.textContent = 'Status';
                        dynamicFilter.innerHTML = `
                            <option value="all">All</option>
                            <option value="pass">Pass</option>
                            <option value="in_progress">In Progress</option>
                            <option value="fail">Fail</option>
                        `;
                        // Show additional filter for swimming pass date
                        additionalFilterContainer.classList.remove('hidden');
                        document.getElementById('additionalFilterLabel').textContent = 'Pass Date';
                        loadSwimmingPassDates();
                        actionButtonsContainer.classList.remove('hidden');
                        markAsPassedBtn.classList.remove('hidden');
                        break;
                        
                    case 'cgpa':
                        dynamicFilterLabel.textContent = 'CGPA Range';
                        dynamicFilter.innerHTML = `
                            <option value="all">All</option>
                            <option value="3.67_and_above">3.67 and above</option>
                            <option value="3.00_to_3.66">3.00 - 3.66</option>
                            <option value="2.50_to_2.99">2.50 - 2.99</option>
                            <option value="2.49_and_below">2.49 and below</option>
                        `;
                        break;
                }
                
                // Set current filter value
                dynamicFilter.value = currentFilters.filterBy || 'all';
            }

            // Update column headers
            updateColumnHeaders(infoType, currentFilters.personnelMode);
        }

        // ============================================================
        // FUNCTION: Update Column Headers
        // ============================================================
        function updateColumnHeaders(infoType, personnelMode = 'suspend') {
            const dynamicColumnHeader = document.getElementById('dynamicColumnHeader');
            const actionsColumnHeader = document.getElementById('actionsColumnHeader');

            switch(infoType) {
                case 'personnel':
                    dynamicColumnHeader.textContent = 'Rank';
                    if (personnelMode === 'rank_up') {
                        actionsColumnHeader.innerHTML = `
                            <div class="flex items-center">
                                <input type="checkbox"
                                       id="selectAll"
                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
                                <span>Select All</span>
                            </div>
                        `;
                        // Re-attach select all event listener
                        setTimeout(() => {
                            const selectAllCheckbox = document.getElementById('selectAll');
                            if (selectAllCheckbox) {
                                selectAllCheckbox.addEventListener('change', handleSelectAll);
                            }
                        }, 100);
                    } else {
                        actionsColumnHeader.innerHTML = 'Actions';
                    }
                    break;
                case 'seniority':
                    dynamicColumnHeader.textContent = 'IC Number';
                    actionsColumnHeader.innerHTML = 'Actions';
                    break;
                case 'position':
                    dynamicColumnHeader.textContent = 'Position';
                    actionsColumnHeader.innerHTML = 'Actions';
                    break;
                case 'gender':
                    dynamicColumnHeader.textContent = 'Gender';
                    actionsColumnHeader.innerHTML = 'Actions';
                    break;
                case 'cgpa':
                    dynamicColumnHeader.textContent = 'CGPA';
                    actionsColumnHeader.innerHTML = 'Actions';
                    break;
                case 'swimming':
                    dynamicColumnHeader.textContent = 'Swimming Status';
                    actionsColumnHeader.innerHTML = `
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="selectAll"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
                            <span>Select All</span>
                        </div>
                    `;
                    // Re-attach select all event listener
                    setTimeout(() => {
                        const selectAllCheckbox = document.getElementById('selectAll');
                        if (selectAllCheckbox) {
                            selectAllCheckbox.addEventListener('change', handleSelectAll);
                        }
                    }, 100);
                    break;
                case 'bmi':
                    dynamicColumnHeader.textContent = 'BMI & Last Updated';
                    actionsColumnHeader.innerHTML = 'Actions';
                    break;
            }
        }

        // ============================================================
        // FUNCTION: Load Swimming Pass Dates
        // ============================================================
        function loadSwimmingPassDates() {
            fetch(`/instructor/cadets/swimming-pass-dates?intake_year=${currentFilters.intakeYear}`)
                .then(response => response.json())
                .then(data => {
                    const additionalFilter = document.getElementById('additionalFilter');
                    additionalFilter.innerHTML = '<option value="all">All Dates</option>';
                    
                    if (data.dates && data.dates.length > 0) {
                        data.dates.forEach(date => {
                            const option = document.createElement('option');
                            option.value = date;
                            option.textContent = date;
                            if (currentFilters.swimmingPassDate === date) {
                                option.selected = true;
                            }
                            additionalFilter.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading swimming pass dates:', error);
                });
        }

        // ============================================================
// FUNCTION: Load Cadets via AJAX
// ============================================================
function loadCadets(page = 1) {
    currentPage = page;
    
    // Show loading indicator
    document.getElementById('loadingIndicator').classList.remove('hidden');
    document.getElementById('cadetTableContainer').style.opacity = '0.5';

    const params = new URLSearchParams({
        info_type: currentFilters.infoType,
        intake_year: currentFilters.intakeYear,
        filter_by: currentFilters.filterBy,
        sort_by: currentFilters.sortBy,
        search: currentFilters.search,
        personnel_mode: currentFilters.personnelMode,
        page: page
    });

    if (currentFilters.infoType === 'swimming' && currentFilters.swimmingPassDate !== 'all') {
        params.append('swimming_pass_date', currentFilters.swimmingPassDate);
    }

    fetch(`/instructor/cadets/ajax?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        renderCadetsTable(data);
        
        // Hide loading indicator
        document.getElementById('loadingIndicator').classList.add('hidden');
        document.getElementById('cadetTableContainer').style.opacity = '1';
    })
    .catch(error => {
        console.error('Error loading cadets:', error);
        document.getElementById('loadingIndicator').classList.add('hidden');
        document.getElementById('cadetTableContainer').style.opacity = '1';
        alert('Failed to load cadets. Please try again.');
    });
}

        // ============================================================
        // FUNCTION: Render Cadets Table
        // ============================================================
        function renderCadetsTable(data) {
            const tableBody = document.getElementById('cadetTableBody');
            tableBody.innerHTML = '';

            if (data.cadets && data.cadets.length > 0) {
                data.cadets.forEach((cadet, index) => {
                    const row = createCadetRow(cadet, data.firstItem + index);
                    tableBody.appendChild(row);
                });

                // Attach event listeners
                attachCadetRowEventListeners();
            } else {
                tableBody.innerHTML = `
                    <div class="px-6 py-8 text-center">
                        <div class="text-sm text-gray-500">No cadets found matching the current filters.</div>
                    </div>
                `;
            }

            // Update pagination
            renderPagination(data.pagination);

            // Reinitialize select all checkbox and mark as passed button after AJAX load
            setTimeout(() => {
                updateSelectAllCheckbox();
                updateMarkAsPassedButton();
            }, 100);
        }

// ============================================================
// FUNCTION: Create Cadet Row
// ============================================================
function createCadetRow(cadet, rowNumber) {
    const row = document.createElement('div');
    row.className = 'border-b border-gray-200 hover:bg-gray-50 cursor-pointer cadet-row px-6 py-4';
    row.dataset.cadetId = cadet.id;

    const dynamicContent = getDynamicColumnContent(cadet);
    const actionsContent = getActionsColumnContent(cadet);

    row.innerHTML = `
        <div class="grid grid-cols-5 gap-4 items-center">
            <div class="text-sm text-gray-900">${rowNumber}</div>
            <div class="text-sm text-gray-900">${cadet.service_number || 'N/A'}</div>
            <div class="text-sm font-medium text-gray-900">${cadet.user_name || 'Unknown'}</div>
            <div class="text-sm text-gray-900">${dynamicContent}</div>
            <div class="text-sm font-medium">${actionsContent}</div>
        </div>
    `;

    return row;
}

// ============================================================
// FUNCTION: Get Dynamic Column Content
// ============================================================
function getDynamicColumnContent(cadet) {
    switch(currentFilters.infoType) {
        case 'personnel':
            return cadet.rank || 'N/A';

        case 'seniority':
            return cadet.ic_number || 'N/A';

        case 'position':
            return cadet.position || 'Normal Cadet';

        case 'gender':
            return cadet.gender || 'N/A';

        case 'cgpa':
            return cadet.current_cgpa ? parseFloat(cadet.current_cgpa).toFixed(2) : 'N/A';

        case 'swimming':
            const statusClass = cadet.swimming_qualification === 'Pass' ? 'bg-green-100 text-green-800' :
                              cadet.swimming_qualification === 'In Progress' ? 'bg-yellow-100 text-yellow-800' :
                              'bg-red-100 text-red-800';
            return `
                <div>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusClass}">
                        ${cadet.swimming_qualification || 'N/A'}
                    </span>
                    <div class="text-xs text-gray-500 mt-1">
                        ${cadet.swimming_pass_date || 'Not passed'}
                    </div>
                </div>
            `;

        case 'bmi':
            return `
                <div>
                    <div class="font-medium">${cadet.BMI ? parseFloat(cadet.BMI).toFixed(1) : 'N/A'}</div>
                    <div class="text-xs text-gray-500">
                        ${cadet.BMI_update_date || 'Not updated'}
                    </div>
                </div>
            `;

        default:
            return 'N/A';
    }
}

// ============================================================
// FUNCTION: Get Actions Column Content
// ============================================================
function getActionsColumnContent(cadet) {
    switch(currentFilters.infoType) {
        case 'personnel':
            if (currentFilters.personnelMode === 'suspend') {
                return `
                    <button class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700 suspend-cadet-btn"
                            data-cadet-id="${cadet.id}"
                            data-cadet-name="${cadet.user_name}">
                        Suspend Cadet
                    </button>
                `;
            } else if (currentFilters.personnelMode === 'rank_up' && cadet.rank === 'PK') {
                return `
                    <input type="checkbox"
                           class="cadet-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           data-cadet-id="${cadet.id}">
                `;
            } else if (currentFilters.personnelMode === 'rank_up' && cadet.rank === 'PKK') {
                return '<span class="text-purple-600 font-medium">Already PKK</span>';
            } else {
                return '<span class="text-gray-500">N/A</span>';
            }

        case 'seniority':
            return `
                <button class="px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-md hover:bg-orange-700 suspend-cadet-btn"
                        data-cadet-id="${cadet.id}"
                        data-cadet-name="${cadet.user_name}">
                    Suspend Cadet
                </button>
            `;

        case 'position':
            const positions = {
                'Normal': 'Normal Cadet',
                'CO': 'CO',
                'Thana': 'Thana',
                'Zayn': 'Zayn',
                'PMC': 'PMC',
            };
            let options = '';
            for (const [value, label] of Object.entries(positions)) {
                const selected = (cadet.position || 'Normal Cadet') === value ? 'selected' : '';
                options += `<option value="${value}" ${selected}>${label}</option>`;
            }
            return `
                <select class="position-select border-gray-300 rounded text-sm"
                        data-cadet-id="${cadet.id}"
                        data-original-value="${cadet.position || 'Normal Cadet'}">
                    ${options}
                </select>
            `;

        case 'swimming':
            if (cadet.swimming_qualification !== 'Pass') {
                return `
                    <input type="checkbox"
                           class="cadet-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                           data-cadet-id="${cadet.id}">
                `;
            } else {
                return '<span class="text-green-600 font-medium">Passed</span>';
            }

        default:
            return `
                <button class="text-indigo-600 hover:text-indigo-900 view-profile-btn"
                        data-cadet-id="${cadet.id}">
                    View Profile
                </button>
            `;
    }
}

// ============================================================
// FUNCTION: Validate Position Selection
// ============================================================
function validatePositionSelection(selectElement) {
    const selectedPosition = selectElement.value;
    const cadetId = selectElement.dataset.cadetId;
    const specialPositions = ['CO', 'Thana', 'Zayn', 'PMC'];
    
    if (specialPositions.includes(selectedPosition)) {
        const otherSelects = document.querySelectorAll('.position-select');
        let conflictFound = false;
        
        otherSelects.forEach(otherSelect => {
            if (otherSelect.dataset.cadetId !== cadetId && otherSelect.value === selectedPosition) {
                conflictFound = true;
            }
        });
        
        if (conflictFound) {
            alert(`Only one cadet per intake can hold the ${selectedPosition} position. Please change the other cadet's position first.`);
            selectElement.value = selectElement.dataset.originalValue || 'Normal Cadet';
            return false;
        }
    }
    
    selectElement.dataset.originalValue = selectedPosition;
    return true;
}

// ============================================================
// FUNCTION: Save Positions
// ============================================================
function savePositions() {
    const positionSelects = document.querySelectorAll('.position-select');
    const positionCounts = { 'CO': 0, 'Thana': 0, 'Zayn': 0, 'PMC': 0 };

    positionSelects.forEach(select => {
        const position = select.value;
        if (positionCounts.hasOwnProperty(position)) {
            positionCounts[position]++;
        }
    });

    const conflicts = Object.entries(positionCounts).filter(([position, count]) => count > 1);
    if (conflicts.length > 0) {
        const conflictMessage = conflicts.map(([position, count]) =>
            `${position}: ${count} cadets selected`).join(', ');
        alert(`Position conflicts detected: ${conflictMessage}. Each position can only be assigned to one cadet per intake.`);
        return;
    }

    const positions = {};
    positionSelects.forEach(select => {
        positions[select.dataset.cadetId] = select.value;
    });

    const intakeYear = currentFilters.intakeYear;

    fetch('/instructor/cadets/positions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            positions: positions,
            intake_year: intakeYear
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Positions updated successfully');
            hasUnsavedPositionChanges = false;
            updateSaveButtonVisibility();
            loadCadets(currentPage);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update positions');
    });
}

// ============================================================
// FUNCTION: Update Save Button Visibility
// ============================================================
function updateSaveButtonVisibility() {
    const savePositionsBtn = document.getElementById('savePositionsBtn');
    if (hasUnsavedPositionChanges) {
        savePositionsBtn.disabled = false;
        savePositionsBtn.classList.remove('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
    } else {
        savePositionsBtn.disabled = true;
        savePositionsBtn.classList.add('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
    }
}



// ============================================================
// FUNCTION: Show Rank Up Modal
// ============================================================
function showRankUpModal() {
    const selectedCadets = [];
    document.querySelectorAll('.cadet-checkbox:checked').forEach(checkbox => {
        selectedCadets.push(checkbox.dataset.cadetId);
    });

    if (selectedCadets.length === 0) {
        alert('Please select at least one cadet to rank up.');
        return;
    }

    document.getElementById('rankUpModal').classList.remove('hidden');
}

// ============================================================
// FUNCTION: Select All Cadets
// ============================================================
function selectAllCadets() {
    const checkboxes = document.querySelectorAll('.cadet-checkbox');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    checkboxes.forEach(checkbox => {
        checkbox.checked = !allChecked;
    });

    updateRankUpButtonState();
}

// ============================================================
// FUNCTION: Update Rank Up Button State
// ============================================================
function updateRankUpButtonState() {
    const selectedCount = document.querySelectorAll('.cadet-checkbox:checked').length;
    const rankUpBtn = document.getElementById('rankUpBtn');

    if (selectedCount > 0) {
        rankUpBtn.disabled = false;
        rankUpBtn.classList.remove('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
    } else {
        rankUpBtn.disabled = true;
        rankUpBtn.classList.add('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
    }
}

// ============================================================
// FUNCTION: Confirm Rank Up
// ============================================================
function confirmRankUp() {
    const selectedCadets = [];
    document.querySelectorAll('.cadet-checkbox:checked').forEach(checkbox => {
        selectedCadets.push(checkbox.dataset.cadetId);
    });

    if (selectedCadets.length === 0) {
        alert('Please select at least one cadet to rank up.');
        return;
    }

    const intakeYear = currentFilters.intakeYear;

    fetch('/instructor/cadets/rank-up', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            cadet_ids: selectedCadets,
            intake_year: intakeYear
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('rankUpModal').classList.add('hidden');
            alert(`${data.updated_count} cadet(s) ranked up successfully`);
            loadCadets(currentPage);
        } else {
            alert(data.message || 'Failed to rank up cadets');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to rank up cadets');
    });
}

// ============================================================
// FUNCTION: Mark Selected as Passed (Swimming)
// ============================================================
function markSelectedAsPassed() {
    const selectedCadets = [];
    document.querySelectorAll('.cadet-checkbox:checked').forEach(checkbox => {
        selectedCadets.push(checkbox.dataset.cadetId);
    });

    if (selectedCadets.length === 0) {
        alert('Please select at least one cadet to mark as passed.');
        return;
    }

    const intakeYear = currentFilters.intakeYear;

    fetch('/instructor/cadets/swimming/mark-passed', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            cadet_ids: selectedCadets,
            intake_year: intakeYear
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`${data.updated_count} cadet(s) marked as passed successfully`);
            loadCadets(currentPage);
        } else {
            alert(data.message || 'Failed to update swimming qualification');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to update swimming qualification');
    });
}



// ============================================================
// EXPOSE FUNCTIONS TO GLOBAL SCOPE
// ============================================================
window.loadCadets = loadCadets;
window.loadBestCadets = loadBestCadets;
window.loadBestAcademicCadets = loadBestAcademicCadets;
window.loadSuspendedCadets = loadSuspendedCadets;
window.showCadetProfile = showCadetProfile;
window.showSuspendModal = showSuspendModal;
window.showDeleteModal = showDeleteModal;

// ============================================================
// FUNCTION: Show Cadet Profile Modal
// ============================================================
function showCadetProfile(cadetId) {
    fetch(`/instructor/cadets/${cadetId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                throw new Error(data.message || 'Unknown error');
            }
            let profilePicHtml = '';
            if (data.cadet.profile_pic) {
                const profilePicUrl = `/storage/${data.cadet.profile_pic}`;
                profilePicHtml = `<img src="${profilePicUrl}" alt="Profile" class="w-full h-full object-cover">`;
            } else {
                const fallbackAvatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.user.name)}`;
                profilePicHtml = `<img src="${fallbackAvatarUrl}" alt="Profile" class="w-full h-full object-cover">`;
            }

            // Calculate point distribution percentages
            const performance = data.performance || {};
            const totalPoints = parseFloat(performance.total_points) || 0;
            const attendancePoints = parseFloat(performance.attendance_points) || 0;
            const quizPoints = parseFloat(performance.quiz_points) || 0;
            const learningPoints = parseFloat(performance.learning_progress_points) || 0;

            // Calculate dynamic font size for rank + name based on total length
            const fullName = `${data.cadet.rank || 'Cadet'} ${data.user.name}`;
            const nameLength = fullName.length;
            let nameFontSize = 'text-3xl'; // Default size for short names
            let nameFontSizeMobile = 'text-2xl'; // Default mobile size

            if (nameLength > 45) {
                nameFontSize = 'text-sm';
                nameFontSizeMobile = 'text-xs';
            } else if (nameLength > 40) {
                nameFontSize = 'text-base';
                nameFontSizeMobile = 'text-sm';
            } else if (nameLength > 35) {
                nameFontSize = 'text-lg';
                nameFontSizeMobile = 'text-base';
            } else if (nameLength > 30) {
                nameFontSize = 'text-xl';
                nameFontSizeMobile = 'text-lg';
            } else if (nameLength > 25) {
                nameFontSize = 'text-2xl';
                nameFontSizeMobile = 'text-xl';
            }

            const attendancePercent = totalPoints > 0 ? (attendancePoints / totalPoints) * 100 : 0;
            const quizPercent = totalPoints > 0 ? (quizPoints / totalPoints) * 100 : 0;
            const learningPercent = totalPoints > 0 ? (learningPoints / totalPoints) * 100 : 0;

            // Generate SVG donut chart
            const radius = 70;
            const circumference = 2 * Math.PI * radius;

            const categories = [
                { percent: attendancePercent, color: '#3b82f6', points: attendancePoints, label: 'Attendance' },
                { percent: quizPercent, color: '#10b981', points: quizPoints, label: 'Quiz' },
                { percent: learningPercent, color: '#06b6d4', points: learningPoints, label: 'Learning' },
            ];

            let currentOffset = 0;
            let svgCircles = '';

            categories.forEach(category => {
                if (category.percent > 0) {
                    const strokeDasharray = (category.percent / 100) * circumference;
                    const strokeDashoffset = -currentOffset;
                    currentOffset += strokeDasharray;

                    svgCircles += `
                        <circle cx="100" cy="100" r="${radius}"
                            stroke="${category.color}"
                            stroke-width="28"
                            fill="none"
                            stroke-dasharray="${strokeDasharray} ${circumference}"
                            stroke-dashoffset="${strokeDashoffset}"
                            style="transition: all 0.5s ease;"/>
                    `;
                }
            });

            const profileContent = `
                <!-- Header Card: Profile Info & Performance -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
                    <!-- Profile Section -->
                    <div class="px-4 py-6 md:px-8 md:py-8">
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <!-- Top Row: Profile Picture + Chart -->
                            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 w-full">
                                <!-- Profile Picture - Rounded Vertical Rectangle -->
                                <div class="w-24 h-32 md:w-28 md:h-36 flex-shrink-0 rounded-2xl bg-gradient-to-br from-blue-100 to-indigo-200 shadow-lg p-1">
                                    <div class="w-full h-full rounded-xl overflow-hidden bg-white">
                                        ${profilePicHtml}
                                    </div>
                                </div>

                                <!-- Name and Details Section -->
                                <div class="flex-1 text-center md:text-left">
                                    <h3 class="${nameFontSizeMobile} md:${nameFontSize} font-bold text-gray-900 break-words leading-tight mb-4">${fullName}</h3>

                                    <div class="space-y-2.5 text-sm md:text-base text-gray-700">
                                        <div class="flex flex-col md:flex-row md:items-center gap-1">
                                            <span class="font-semibold text-gray-800">Service Number:</span>
                                            <span class="text-gray-600">${data.cadet.service_number || 'N/A'}</span>
                                        </div>
                                        <div class="flex flex-col md:flex-row md:items-center gap-1">
                                            <span class="font-semibold text-gray-800">Matric Number:</span>
                                            <span class="text-gray-600">${data.cadet.matric_no || 'N/A'}</span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <span class="text-yellow-500 text-2xl md:text-xl">${performance.rating || '⭐☆☆☆☆'}</span>
                                    </div>
                                </div>

                                <!-- Performance Chart -->
                                <div class="flex-shrink-0">
                                    <div class="bg-gradient-to-br from-gray-50 to-slate-100 rounded-xl p-4 border border-gray-200">
                                        <div class="relative w-40 h-40 md:w-44 md:h-44">
                                            <svg viewBox="0 0 200 200" class="w-full h-full transform -rotate-90">
                                                ${svgCircles}
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="text-center">
                                                    <div class="text-2xl md:text-3xl font-black text-gray-900">${totalPoints.toFixed(0)}</div>
                                                    <div class="text-xs text-gray-600 font-medium">Points</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Points Legend -->
                                        <div class="mt-3 space-y-1.5 w-full max-w-[180px] mx-auto">
                                            <div class="flex items-center justify-between text-gray-700 text-xs">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-2 h-2 rounded-full flex-shrink-0" style="background-color: #3b82f6;"></div>
                                                    <span class="truncate">Attendance</span>
                                                </div>
                                                <span class="font-bold ml-2">${attendancePoints.toFixed(0)}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-gray-700 text-xs">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-2 h-2 rounded-full flex-shrink-0" style="background-color: #10b981;"></div>
                                                    <span class="truncate">Quiz</span>
                                                </div>
                                                <span class="font-bold ml-2">${quizPoints.toFixed(0)}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-gray-700 text-xs">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-2 h-2 rounded-full flex-shrink-0" style="background-color: #06b6d4;"></div>
                                                    <span class="truncate">Learning</span>
                                                </div>
                                                <span class="font-bold ml-2">${learningPoints.toFixed(0)}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information Sections Grid -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h5 class="font-medium text-gray-900 border-b pb-2">Personal Information</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Gender:</span>
                                <span class="font-medium">${data.cadet.gender || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone:</span>
                                <span class="font-medium">${data.cadet.phone_number || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">${data.user.email || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Insurance Number:</span>
                                <span class="font-medium">${data.cadet.insurance_number || 'N/A'}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h5 class="font-medium text-gray-900 border-b pb-2">Military Information</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Rank:</span>
                                <span class="font-medium">${data.cadet.rank || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Position:</span>
                                <span class="font-medium">${data.cadet.position || 'Normal Cadet'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Intake Year:</span>
                                <span class="font-medium">${data.cadet.intake_year || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Swimming Status:</span>
                                <span class="font-medium px-2 py-1 rounded text-xs ${
                                    data.cadet.swimming_qualification === 'Pass' ? 'bg-green-100 text-green-800' :
                                    data.cadet.swimming_qualification === 'In Progress' ? 'bg-yellow-100 text-yellow-800' :
                                    'bg-red-100 text-red-800'
                                }">
                                    ${data.cadet.swimming_qualification || 'N/A'}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">TTP Date:</span>
                                <span class="font-medium">${data.cadet.ttp_date ? new Date(data.cadet.ttp_date).toLocaleDateString('en-GB', {day: '2-digit', month: 'short', year: 'numeric'}) : 'N/A'}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h5 class="font-medium text-gray-900 border-b pb-2">Academic Information</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Faculty:</span>
                                <span class="font-medium">${data.cadet.faculty || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Course:</span>
                                <span class="font-medium">${data.cadet.course || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Current CGPA:</span>
                                <span class="font-medium">${data.cadet.current_cgpa ? parseFloat(data.cadet.current_cgpa).toFixed(2) : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Past CGPA:</span>
                                <span class="font-medium">${data.cadet.past_cgpa ? parseFloat(data.cadet.past_cgpa).toFixed(2) : 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <h5 class="font-medium text-gray-900 border-b pb-2">Physical Information</h5>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">BMI:</span>
                                <span class="font-medium">${data.cadet.BMI ? parseFloat(data.cadet.BMI).toFixed(1) : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">BMI Updated:</span>
                                <span class="font-medium text-xs">${data.cadet.BMI_update_date ? new Date(data.cadet.BMI_update_date).toLocaleDateString() : 'Not updated'}</span>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            `;

            document.getElementById('cadetProfileContent').innerHTML = profileContent;
            document.getElementById('cadetModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error fetching cadet profile:', error);
            alert('Failed to load cadet profile: ' + error.message);
        });
}

// ============================================================
// FUNCTION: Show Suspend Modal
// ============================================================
function showSuspendModal(cadetId, cadetName) {
    document.getElementById('cadetNameToSuspend').textContent = cadetName;
    document.getElementById('confirmationNameInputSuspend').value = '';
    document.getElementById('confirmSuspend').dataset.cadetId = cadetId;
    document.getElementById('suspendModal').classList.remove('hidden');
}

// ============================================================
// FUNCTION: Confirm Suspension
// ============================================================
function confirmSuspension() {
    const cadetId = document.getElementById('confirmSuspend').dataset.cadetId;
    const confirmationName = document.getElementById('confirmationNameInputSuspend').value;
    
    fetch(`/instructor/cadets/${cadetId}/suspend`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            confirmation_name: confirmationName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('suspendModal').classList.add('hidden');
            alert('Cadet suspended successfully');
            loadCadets(currentPage);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to suspend cadet');
    });
}

// ============================================================
// FUNCTION: Show Delete Modal
// ============================================================
function showDeleteModal(cadetId, cadetName) {
    document.getElementById('cadetNameToDelete').textContent = cadetName;
    document.getElementById('confirmDelete').dataset.cadetId = cadetId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

// ============================================================
// FUNCTION: Show Reactivate Modal
// ============================================================
function showReactivateModal(cadetId, cadetName) {
    document.getElementById('cadetNameToReactivate').textContent = cadetName;
    document.getElementById('confirmReactivate').dataset.cadetId = cadetId;
    document.getElementById('reactivateModal').classList.remove('hidden');
}

// ============================================================
// FUNCTION: Confirm Reactivation
// ============================================================
function confirmReactivation() {
    const cadetId = document.getElementById('confirmReactivate').dataset.cadetId;

    fetch(`/instructor/cadets/${cadetId}/reactivate`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('reactivateModal').classList.add('hidden');
            alert('Cadet reactivated successfully');
            loadSuspendedCadets(document.getElementById('suspendedIntakeFilter').value);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to reactivate cadet');
    });
}

// ============================================================
// FUNCTION: Handle Reactivate Button Click
// ============================================================
function handleReactivateClick(e) {
    e.stopPropagation();
    const cadetId = this.dataset.cadetId;
    const cadetName = this.dataset.cadetName;
    showReactivateModal(cadetId, cadetName);
}

// ============================================================
// FUNCTION: Handle Delete Button Click
// ============================================================
function handleDeleteClick(e) {
    e.stopPropagation();
    const cadetId = this.dataset.cadetId;
    const cadetName = this.dataset.cadetName;
    showDeleteModal(cadetId, cadetName);
}

// ============================================================
// FUNCTION: Confirm Deletion
// ============================================================
function confirmDeletion() {
    const cadetId = document.getElementById('confirmDelete').dataset.cadetId;

    fetch(`/instructor/cadets/${cadetId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('deleteModal').classList.add('hidden');
            alert('Cadet deleted permanently');
            loadSuspendedCadets(document.getElementById('suspendedIntakeFilter').value);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to delete cadet');
    });
}

// Continue to next part...

// ============================================================
// FUNCTION: Load Best Cadets
// ============================================================
function loadBestCadets(intakeYear) {
    const loadingIndicator = document.getElementById('bestCadetLoadingIndicator');
    const contentContainer = document.getElementById('bestCadetContent');
    
    loadingIndicator.classList.remove('hidden');
    contentContainer.style.opacity = '0.5';

    fetch(`/instructor/cadets/best-cadets?intake_year=${intakeYear}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        renderBestCadets(data.cadets);
        loadingIndicator.classList.add('hidden');
        contentContainer.style.opacity = '1';
    })
    .catch(error => {
        console.error('Error loading best cadets:', error);
        loadingIndicator.classList.add('hidden');
        contentContainer.style.opacity = '1';
        alert('Failed to load best cadets. Please try again.');
    });
}

// ============================================================
// FUNCTION: Render Best Cadets
// ============================================================
function renderBestCadets(cadets) {
    const contentContainer = document.getElementById('bestCadetContent');
    contentContainer.innerHTML = '';

    if (cadets && cadets.length > 0) {
        cadets.forEach((cadet, index) => {
            const card = document.createElement('div');
            card.className = 'bg-gradient-to-br from-yellow-50 to-amber-50 border-2 border-yellow-200 rounded-lg p-4 hover:shadow-lg transition-all duration-200';
            
            const profilePic = cadet.profile_pic 
                ? `/storage/${cadet.profile_pic}` 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(cadet.user_name)}`;
            
            const isBestCadet = cadet.is_best_cadet || false;

            card.innerHTML = `
                <div class="text-center mb-3">
                    <div class="text-2xl font-bold text-yellow-600 mb-1">#${index + 1}</div>
                    <img src="${profilePic}" alt="Profile" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-yellow-300">
                </div>
                <div class="space-y-1 text-sm">
                    <div class="font-semibold text-gray-800 text-center">${cadet.rank || 'Cadet'}</div>
                    <div class="font-medium text-gray-900 text-center">${cadet.user_name}</div>
                    <div class="text-gray-600 text-center">${cadet.service_number}</div>
                    <div class="border-t border-yellow-200 pt-2 mt-2">
                        <div class="text-center">
                            <div class="text-lg font-bold text-yellow-700">${cadet.total_points || 0}</div>
                            <div class="text-xs text-gray-600">Total Points</div>
                        </div>
                        <div class="text-center mt-1">
                            <div class="text-lg">${cadet.rating || '⭐☆☆☆☆'}</div>
                        </div>
                        <div class="text-center mt-1">
                            <div class="text-sm font-semibold text-yellow-600">${parseFloat(cadet.current_cgpa || 0).toFixed(2)} CGPA</div>
                        </div>
                    </div>
                    <div class="border-t border-yellow-200 pt-2 mt-2">
                        <button onclick="toggleBestCadet(${cadet.id}, this)"
                                class="w-full py-2 px-3 rounded-md text-xs font-semibold transition-all ${isBestCadet ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}">
                            ${isBestCadet ? '★ Best Cadet' : 'Mark as Best Cadet'}
                        </button>
                    </div>
                </div>
            `;
            contentContainer.appendChild(card);
        });
    } else {
        contentContainer.innerHTML = '<div class="col-span-5 text-center text-gray-500 py-8">No cadets found for this intake</div>';
    }
}

// ============================================================
// FUNCTION: Load Best Academic Cadets
// ============================================================
function loadBestAcademicCadets(intakeYear) {
    const loadingIndicator = document.getElementById('bestAcademicLoadingIndicator');
    const contentContainer = document.getElementById('bestAcademicContent');
    
    loadingIndicator.classList.remove('hidden');
    contentContainer.style.opacity = '0.5';

    fetch(`/instructor/cadets/best-academic?intake_year=${intakeYear}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        renderBestAcademicCadets(data.cadets);
        loadingIndicator.classList.add('hidden');
        contentContainer.style.opacity = '1';
    })
    .catch(error => {
        console.error('Error loading best academic cadets:', error);
        loadingIndicator.classList.add('hidden');
        contentContainer.style.opacity = '1';
        alert('Failed to load best academic cadets. Please try again.');
    });
}

// ============================================================
// FUNCTION: Render Best Academic Cadets
// ============================================================
function renderBestAcademicCadets(cadets) {
    const contentContainer = document.getElementById('bestAcademicContent');
    contentContainer.innerHTML = '';

    if (cadets && cadets.length > 0) {
        cadets.forEach((cadet, index) => {
            const card = document.createElement('div');
            card.className = 'bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-lg p-4 hover:shadow-lg transition-all duration-200';
            
            const profilePic = cadet.profile_pic 
                ? `/storage/${cadet.profile_pic}` 
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(cadet.user_name)}`;
            
            const isBestAcademic = cadet.is_best_academic || false;

            card.innerHTML = `
                <div class="text-center mb-3">
                    <div class="text-2xl font-bold text-green-600 mb-1">#${index + 1}</div>
                    <img src="${profilePic}" alt="Profile" class="w-20 h-20 rounded-full mx-auto object-cover border-4 border-green-300">
                </div>
                <div class="space-y-1 text-sm">
                    <div class="font-semibold text-gray-800 text-center">${cadet.rank || 'Cadet'}</div>
                    <div class="font-medium text-gray-900 text-center">${cadet.user_name}</div>
                    <div class="text-gray-600 text-center">${cadet.service_number}</div>
                    <div class="border-t border-green-200 pt-2 mt-2">
                        <div class="text-center">
                            <div class="text-lg font-bold text-green-700">${parseFloat(cadet.current_cgpa || 0).toFixed(2)}</div>
                            <div class="text-xs text-gray-600">CGPA</div>
                        </div>
                        <div class="text-center mt-1">
                            <div class="text-sm font-semibold text-green-600">${cadet.academic_points || 0} pts</div>
                        </div>
                    </div>
                    <div class="border-t border-green-200 pt-2 mt-2">
                        <button onclick="toggleBestAcademic(${cadet.id}, this)"
                                class="w-full py-2 px-3 rounded-md text-xs font-semibold transition-all ${isBestAcademic ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}">
                            ${isBestAcademic ? '★ Best Academic' : 'Mark as Best Academic'}
                        </button>
                    </div>
                </div>
            `;
            contentContainer.appendChild(card);
        });
    } else {
        contentContainer.innerHTML = '<div class="col-span-5 text-center text-gray-500 py-8">No cadets found for this intake</div>';
    }
}

// ============================================================
// FUNCTION: Load Suspended Cadets
// ============================================================
function loadSuspendedCadets(intakeYear) {
    const loadingIndicator = document.getElementById('suspendedLoadingIndicator');
    const tableBody = document.getElementById('suspendedTableBody');
    
    loadingIndicator.classList.remove('hidden');
    tableBody.style.opacity = '0.5';

    fetch(`/instructor/cadets/suspended?intake_year=${intakeYear}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        renderSuspendedCadets(data.cadets);
        loadingIndicator.classList.add('hidden');
        tableBody.style.opacity = '1';
    })
    .catch(error => {
        console.error('Error loading suspended cadets:', error);
        loadingIndicator.classList.add('hidden');
        tableBody.style.opacity = '1';
        alert('Failed to load suspended cadets. Please try again.');
    });
}

// ============================================================
// FUNCTION: Render Suspended Cadets
// ============================================================
function renderSuspendedCadets(cadets) {
    const tableBody = document.getElementById('suspendedTableBody');
    tableBody.innerHTML = '';

    if (cadets && cadets.length > 0) {
        cadets.forEach(cadet => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${cadet.service_number}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${cadet.user_name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${cadet.matric_no}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                        Suspended
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                    <button class="text-green-600 hover:text-green-900 reactivate-cadet-btn"
                            data-cadet-id="${cadet.id}"
                            data-cadet-name="${cadet.user_name}">
                        Reactivate
                    </button>
                    <button class="text-red-600 hover:text-red-900 delete-suspended-btn"
                            data-cadet-id="${cadet.id}"
                            data-cadet-name="${cadet.user_name}">
                        Delete Permanently
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Attach event listeners for dynamically created buttons
        attachSuspendedCadetEventListeners();

    } else {
        tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                    No suspended cadets found for this intake
                </td>
            </tr>
        `;
    }
}

// Continue to next part...

// ============================================================
// FUNCTION: Render Pagination
// ============================================================
function renderPagination(pagination) {
    const paginationContainer = document.getElementById('paginationContainer');
    
    if (!pagination || pagination.lastPage <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }

    let html = '<nav class="flex items-center justify-between">';
    html += '<div class="flex-1 flex justify-between sm:hidden">';
    
    // Previous button (mobile)
    if (pagination.currentPage > 1) {
        html += `<button onclick="loadCadets(${pagination.currentPage - 1})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Previous</button>`;
    }
    
    // Next button (mobile)
    if (pagination.currentPage < pagination.lastPage) {
        html += `<button onclick="loadCadets(${pagination.currentPage + 1})" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">Next</button>`;
    }
    
    html += '</div>';
    html += '<div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">';
    html += `<div><p class="text-sm text-gray-700">Showing <span class="font-medium">${pagination.from}</span> to <span class="font-medium">${pagination.to}</span> of <span class="font-medium">${pagination.total}</span> results</p></div>`;
    html += '<div><nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">';
    
    // Previous button (desktop)
    if (pagination.currentPage > 1) {
        html += `<button onclick="loadCadets(${pagination.currentPage - 1})" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Previous</button>`;
    }
    
    // Page numbers
    const maxVisiblePages = 5;
    let startPage = Math.max(1, pagination.currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(pagination.lastPage, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage < maxVisiblePages - 1) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        const activeClass = i === pagination.currentPage ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50';
        html += `<button onclick="loadCadets(${i})" class="relative inline-flex items-center px-4 py-2 border text-sm font-medium ${activeClass}">${i}</button>`;
    }
    
    // Next button (desktop)
    if (pagination.currentPage < pagination.lastPage) {
        html += `<button onclick="loadCadets(${pagination.currentPage + 1})" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">Next</button>`;
    }
    
    html += '</nav></div></div></nav>';
    
    paginationContainer.innerHTML = html;
}

// ============================================================
// FUNCTION: Attach Event Listeners to Cadet Rows
// ============================================================
function attachCadetRowEventListeners() {
    // Cadet row click (view profile)
    document.querySelectorAll('.cadet-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.classList.contains('suspend-cadet-btn') || 
                e.target.classList.contains('position-select') ||
                e.target.classList.contains('cadet-checkbox') ||
                e.target.type === 'checkbox' ||
                e.target.tagName === 'SELECT' ||
                e.target.tagName === 'BUTTON') {
                return;
            }
            
            const cadetId = this.dataset.cadetId;
            showCadetProfile(cadetId);
        });
    });

    // Suspend cadet buttons
    document.querySelectorAll('.suspend-cadet-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const cadetId = this.dataset.cadetId;
            const cadetName = this.dataset.cadetName;
            showSuspendModal(cadetId, cadetName);
        });
    });

    // Position selects
    document.querySelectorAll('.position-select').forEach(select => {
        select.addEventListener('change', function(e) {
            e.stopPropagation();
            if (validatePositionSelection(this)) {
                hasUnsavedPositionChanges = true;
                updateSaveButtonVisibility();
            }
        });
    });

    // Swimming checkboxes
    document.querySelectorAll('.cadet-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function(e) {
            e.stopPropagation();
            updateSelectAllCheckbox();
            updateMarkAsPassedButton();
        });
    });

    // View profile buttons
    document.querySelectorAll('.view-profile-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const cadetId = this.dataset.cadetId;
            showCadetProfile(cadetId);
        });
    });
}

// ============================================================
// FUNCTION: Handle Select All Checkbox
// ============================================================
function handleSelectAll() {
    const cadetCheckboxes = document.querySelectorAll('.cadet-checkbox');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    cadetCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    
    updateMarkAsPassedButton();
}

// ============================================================
// FUNCTION: Update Select All Checkbox State
// ============================================================
function updateSelectAllCheckbox() {
    const selectAllCheckbox = document.getElementById('selectAll');
    if (!selectAllCheckbox) return;
    
    const cadetCheckboxes = document.querySelectorAll('.cadet-checkbox');
    const checkedBoxes = document.querySelectorAll('.cadet-checkbox:checked');
    
    if (cadetCheckboxes.length === 0) {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
        return;
    }
    
    if (checkedBoxes.length === cadetCheckboxes.length) {
        selectAllCheckbox.checked = true;
        selectAllCheckbox.indeterminate = false;
    } else if (checkedBoxes.length > 0) {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = true;
    } else {
        selectAllCheckbox.checked = false;
        selectAllCheckbox.indeterminate = false;
    }
}

// ============================================================
// FUNCTION: Update Mark As Passed Button State
// ============================================================
function updateMarkAsPassedButton() {
    const markAsPassedBtn = document.getElementById('markAsPassedBtn');
    if (!markAsPassedBtn) return;

    const checkedBoxes = document.querySelectorAll('.cadet-checkbox:checked');
    markAsPassedBtn.disabled = checkedBoxes.length === 0;
}

// ============================================================
// FUNCTION: Attach Event Listeners for Suspended Cadet Buttons
// ============================================================
function attachSuspendedCadetEventListeners() {
    // Attach event listeners to reactivate buttons
    document.querySelectorAll('.reactivate-cadet-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const cadetId = this.dataset.cadetId;
            const cadetName = this.dataset.cadetName;
            showReactivateModal(cadetId, cadetName);
        });
    });

    // Attach event listeners to delete buttons
    document.querySelectorAll('.delete-suspended-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const cadetId = this.dataset.cadetId;
            const cadetName = this.dataset.cadetName;
            showDeleteModal(cadetId, cadetName);
        });
    });
}

// ============================================================
// FUNCTION: Toggle Best Cadet Status
// ============================================================
function toggleBestCadet(cadetId, button) {
    if (!confirm('Are you sure you want to toggle Best Cadet status for this cadet?')) {
        return;
    }

    fetch(`/instructor/cadets/${cadetId}/toggle-best-cadet`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const isBestCadet = data.is_best_cadet;
            button.className = `w-full py-2 px-3 rounded-md text-xs font-semibold transition-all ${isBestCadet ? 'bg-yellow-500 text-white hover:bg-yellow-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
            button.textContent = isBestCadet ? '★ Best Cadet' : 'Mark as Best Cadet';

            // Show success message
            alert(data.message);

            // Reload the best cadets section
            const intakeYear = document.getElementById('bestCadetIntakeFilter').value;
            loadBestCadets(intakeYear);
        } else {
            alert('Error: ' + (data.message || 'Failed to update Best Cadet status'));
        }
    })
    .catch(error => {
        console.error('Error toggling Best Cadet status:', error);
        alert('Failed to update Best Cadet status. Please try again.');
    });
}

// ============================================================
// FUNCTION: Toggle Best Academic Status
// ============================================================
function toggleBestAcademic(cadetId, button) {
    if (!confirm('Are you sure you want to toggle Best Academic status for this cadet?')) {
        return;
    }

    fetch(`/instructor/cadets/${cadetId}/toggle-best-academic`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const isBestAcademic = data.is_best_academic;
            button.className = `w-full py-2 px-3 rounded-md text-xs font-semibold transition-all ${isBestAcademic ? 'bg-green-500 text-white hover:bg-green-600' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
            button.textContent = isBestAcademic ? '★ Best Academic' : 'Mark as Best Academic';

            // Show success message
            alert(data.message);

            // Reload the best academic section
            const intakeYear = document.getElementById('bestAcademicIntakeFilter').value;
            loadBestAcademicCadets(intakeYear);
        } else {
            alert('Error: ' + (data.message || 'Failed to update Best Academic status'));
        }
    })
    .catch(error => {
        console.error('Error toggling Best Academic status:', error);
        alert('Failed to update Best Academic status. Please try again.');
    });
}

// ================================================================
// AUTO-OPEN CADET MODAL FROM URL PARAMETER
// ================================================================
document.addEventListener('DOMContentLoaded', function() {
    // Check if cadet_id parameter exists in URL
    const urlParams = new URLSearchParams(window.location.search);
    const cadetId = urlParams.get('cadet_id');

    if (cadetId) {
        // Wait a bit for the page to fully load, then open the modal
        setTimeout(() => {
            showCadetProfile(cadetId);
            // Remove the parameter from URL without reloading the page
            const newUrl = window.location.pathname;
            window.history.replaceState({}, document.title, newUrl);
        }, 500);
    }
});

// ================================================================
// TAULIAH SETTINGS MODAL FUNCTIONS
// ================================================================
function openTauliahModal() {
    document.getElementById('tauliahModal').classList.remove('hidden');
}

function closeTauliahModal() {
    document.getElementById('tauliahModal').classList.add('hidden');
}

// Handle Tauliah settings form submission - wait for DOM to be ready
window.addEventListener('DOMContentLoaded', function() {
    const tauliahForm = document.getElementById('tauliahForm');
    if (tauliahForm) {
        tauliahForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = {
                tauliah_month: document.getElementById('tauliahMonth').value,
                tauliah_day: document.getElementById('tauliahDay').value
            };

            fetch('{{ route('instructor.cadets.tauliah-settings') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    alert('Tauliah date settings updated successfully!\nMonth: ' + data.data.month + ', Day: ' + data.data.day);
                    closeTauliahModal();
                    // Reload the page to reflect changes
                    location.reload();
                } else {
                    alert('Error: ' + (data.message || 'Failed to update settings'));
                }
            })
            .catch(error => {
                console.error('Error updating Tauliah settings:', error);
                alert('Failed to update settings. Please try again.');
            });
        });
    }

    // Close modal when clicking outside
    const tauliahModal = document.getElementById('tauliahModal');
    if (tauliahModal) {
        tauliahModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeTauliahModal();
            }
        });
    }
});
    </script>
    @endpush
</x-app-layout>
