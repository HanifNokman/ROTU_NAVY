<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Application') }}
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
        /* Page header */
        .text-center.mb-8 h1 {
            font-size: 1.875rem !important;
            padding: 0 1rem;
        }

        .text-center.mb-8 p {
            font-size: 0.875rem !important;
            padding: 0 1rem;
        }

        /* Section headers - better mobile layout */
        .section-header {
            padding: 1rem !important;
        }

        .section-header .flex.items-center.justify-between {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 1rem !important;
        }

        .section-header h3 {
            font-size: 1.25rem !important;
            line-height: 1.75rem !important;
        }

        /* Start Selection button */
        .section-header button {
            width: 100% !important;
            justify-content: center !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem !important;
        }

        /* Application Overview section */
        .grid.grid-cols-1.md\\:grid-cols-3 {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }

        /* Pagination */
        #regularPagination,
        #selectionPagination {
            flex-direction: column !important;
            gap: 1rem !important;
            align-items: stretch !important;
        }

        #regularPagination .text-sm,
        #selectionPagination .text-sm {
            text-align: center !important;
            font-size: 0.75rem !important;
        }

        #regularPagination .flex.gap-2,
        #selectionPagination .flex.gap-2 {
            justify-content: center !important;
            flex-wrap: wrap !important;
        }

        #regularPagination button,
        #selectionPagination button {
            font-size: 0.75rem !important;
            padding: 0.5rem 0.75rem !important;
            min-width: 80px !important;
        }

        #regularPageNumbers button,
        #selectionPageNumbers button {
            min-width: 40px !important;
            padding: 0.5rem !important;
        }

        /* Pending Accounts section */
        .flex.items-center.justify-between.mb-4 {
            flex-direction: column !important;
            align-items: stretch !important;
            gap: 1rem !important;
        }

        /* Accept All / Reject All buttons */
        .flex.items-center.justify-between.mb-4 > .flex.gap-2 {
            width: 100% !important;
            flex-direction: row !important;
            gap: 0.5rem !important;
        }

        .flex.items-center.justify-between.mb-4 > .flex.gap-2 form {
            flex: 1 !important;
        }

        .flex.items-center.justify-between.mb-4 > .flex.gap-2 button {
            width: 100% !important;
            font-size: 0.75rem !important;
            padding: 0.75rem 0.5rem !important;
            justify-content: center !important;
        }

        .flex.items-center.justify-between.mb-4 > .flex.gap-2 button svg {
            width: 1rem !important;
            height: 1rem !important;
            margin-right: 0.25rem !important;
        }

        /* Category cards - stack on mobile for better readability */
        .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
            grid-template-columns: 1fr !important;
            gap: 0.75rem !important;
        }

        .category-card {
            padding: 1rem !important;
        }

        .category-card h3 {
            font-size: 1.125rem !important;
        }

        .category-card .text-5xl {
            font-size: 2.5rem !important;
        }

        /* Application cards */
        .space-y-4 > div {
            padding: 1rem !important;
        }

        /* User info section */
        .flex.flex-col.md\\:flex-row {
            flex-direction: column !important;
        }

        /* Profile pictures */
        .w-32.h-44 {
            width: 8rem !important;
            height: 11rem !important;
        }

        /* Buttons - stack vertically */
        .flex.gap-2 {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .flex.gap-2 button {
            width: 100% !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 1rem !important;
        }

        /* Modals */
        .fixed.inset-0 > div {
            margin: 1rem !important;
            max-width: calc(100vw - 2rem) !important;
            padding: 1rem !important;
        }
    }

    /* Extra small devices (Honor X9a - 360px-412px) */
    @media (max-width: 400px) {
        .text-center.mb-8 h1 {
            font-size: 1.5rem !important;
        }

        /* Single column for categories */
        .grid.grid-cols-1.md\\:grid-cols-2.lg\\:grid-cols-3 {
            grid-template-columns: 1fr !important;
        }

        .category-card {
            padding: 1rem !important;
        }

        .w-32.h-44 {
            width: 7rem !important;
            height: 9.5rem !important;
        }

        button {
            font-size: 0.75rem !important;
            padding: 0.5rem 0.75rem !important;
        }

        .fixed.inset-0 > div {
            margin: 0.5rem !important;
            max-width: calc(100vw - 1rem) !important;
        }
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- PAGE HEADER --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-green rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Account & New Cadet Intake Verification</h1>
                <p class="text-gray-600 text-lg">Review and approve pending account registrations and cadet applications</p>
            </div>
            {{-- CADET APPLICATION SECTION --}}
            @if($applications->count() > 0)
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">
                {{-- Section Header --}}
                <div class="section-header">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-green mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                Cadet Application | Intake - {{ date('Y') - 2011 }} ({{ date('Y') }})
                            </h3>
                        </div>

                        {{-- Toggle Button --}}
                        <button id="toggleSelectionMode" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span id="toggleButtonText">Start Selection</span>
                        </button>
                    </div>
                    <p class="text-gray-600">Review cadet applications for the current year intake</p>
                </div>

                <div class="p-6">
                    {{-- REGULAR APPLICATION VIEW --}}
                    <div id="regularView">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        Pending Cadet Applications ({{ $applications->count() }})
                                    </h3>
                                    <p class="text-sm text-gray-600">Review and manage cadet applications</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input type="text" id="applicationSearch" placeholder="Search by name, gender, course..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        {{-- Application Summary --}}
                        <div class="mb-6 bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Application Overview
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="applicationSummary">
                                {{-- Summary cards will be populated by JavaScript --}}
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="applicationTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faculty</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="applicationTableBody">
                                    {{-- Dynamic content populated by JavaScript --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination for Regular View --}}
                        <div id="regularPagination" class="mt-4 flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span id="regularShowingStart">1</span> to <span id="regularShowingEnd">10</span> of <span id="regularTotal">0</span> applications
                            </div>
                            <div class="flex gap-2">
                                <button id="regularPrevPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Previous
                                </button>
                                <div id="regularPageNumbers" class="flex gap-2">
                                    {{-- Page numbers will be populated by JavaScript --}}
                                </div>
                                <button id="regularNextPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- SELECTION MODE VIEW --}}
                    <div id="selectionView" class="hidden">
                        {{-- Step Navigation --}}
                        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between mb-4">
                                <button id="prevStep" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Previous
                                </button>

                                <div class="text-center">
                                    <h3 id="currentStepTitle" class="text-xl font-bold text-gray-900 mb-1">Step 1: Attendance</h3>
                                    <p id="currentStepDescription" class="text-sm text-gray-600">Mark candidates who attended the selection process</p>
                                </div>

                                <button id="nextStep" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
                                    Next
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Progress Steps --}}
                            <div class="flex justify-between items-center mt-6">
                                <div id="step1Progress" class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">1</div>
                                    <div class="text-xs mt-1">Attendance</div>
                                </div>
                                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                <div id="step2Progress" class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">2</div>
                                    <div class="text-xs mt-1">Marching</div>
                                </div>
                                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                <div id="step3Progress" class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">3</div>
                                    <div class="text-xs mt-1">Physical</div>
                                </div>
                                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                <div id="step4Progress" class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">4</div>
                                    <div class="text-xs mt-1">Medical</div>
                                </div>
                                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                <div id="step5Progress" class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">5</div>
                                    <div class="text-xs mt-1">Interview</div>
                                </div>
                                <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                <div id="step6Progress" class="flex flex-col items-center">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">6</div>
                                    <div class="text-xs mt-1">Final</div>
                                </div>
                            </div>
                        </div>

                        {{-- Selection Summary --}}
                        <div class="mb-6 bg-white p-4 rounded-lg border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Current Step Overview
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4" id="selectionSummary">
                                {{-- Summary cards will be populated by JavaScript --}}
                            </div>
                        </div>

                        {{-- Filters --}}
                        <div class="mb-4 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 mr-2">Status:</label>
                                    <select id="statusFilter" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="all">All</option>
                                        <option value="passed">Passed</option>
                                        <option value="failed">Failed</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    <input type="text" id="selectionSearch" placeholder="Search by name, gender, course..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="candidatesTableBody">
                                    {{-- Dynamic content populated by JavaScript --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination for Selection View --}}
                        <div id="selectionPagination" class="mt-4 flex items-center justify-between">
                            <div class="text-sm text-gray-700">
                                Showing <span id="selectionShowingStart">1</span> to <span id="selectionShowingEnd">10</span> of <span id="selectionTotal">0</span> candidates
                            </div>
                            <div class="flex gap-2">
                                <button id="selectionPrevPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Previous
                                </button>
                                <div id="selectionPageNumbers" class="flex gap-2">
                                    {{-- Page numbers will be populated by JavaScript --}}
                                </div>
                                <button id="selectionNextPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Next
                                </button>
                            </div>
                        </div>

                        {{-- End Selection Button --}}
                        <div id="endSelectionContainer" class="hidden mt-6">
                            <form method="POST" action="{{ route('instructor.pending.verification.end-selection') }}" onsubmit="return confirm('Are you sure you want to complete the selection process? This will create cadet accounts for all passed candidates and delete all application records.')">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-colors duration-200">
                                    Complete Selection Process
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- VERIFICATION SECTION --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">
                {{-- Section Header --}}
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-blue mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Pending Accounts</h3>
                    </div>
                    <p class="text-gray-600">Review registration requests by role and take appropriate actions</p>
                </div>

                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 text-red-600 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <button id="cadets-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm
                                    {{ $pendingCadets->count() > 0 ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Cadets ({{ $pendingCadets->count() }})
                                </button>
                                <button id="instructors-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm
                                    {{ $pendingInstructors->count() > 0 ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
                                    {{ $pendingCadets->count() == 0 ? 'border-blue-500 text-blue-600' : '' }}">
                                    Instructors ({{ $pendingInstructors->count() }})
                                </button>
                            </nav>
                        </div>
                    </div>

                    <div id="cadets-content" class="tab-content {{ $pendingCadets->count() > 0 ? 'block' : 'hidden' }}">
                        @if($pendingCadets->count() > 0)
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                        </svg>
                                        Pending Cadet Registrations
                                    </h3>
                                    <p class="text-sm text-gray-600">Review and approve cadet account requests</p>
                                </div>
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('instructor.pending.verification.accept-all') }}" onsubmit="return confirm('Are you sure you want to accept all pending cadets?')">
                                        @csrf
                                        <input type="hidden" name="role" value="cadet">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Accept All
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('instructor.pending.verification.reject-all') }}" onsubmit="return confirm('Are you sure you want to reject all pending cadets? This action cannot be undone.')">
                                        @csrf
                                        <input type="hidden" name="role" value="cadet">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject All
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingCadets as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    <form method="POST" action="{{ route('instructor.pending.verification.accept', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('instructor.pending.verification.reject', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                                <p class="text-lg font-medium text-gray-900 mb-1">No pending cadet registrations</p>
                                <p class="text-sm text-gray-500">All cadet registration requests have been processed</p>
                            </div>
                        @endif
                    </div>

                    <div id="instructors-content" class="tab-content {{ $pendingCadets->count() == 0 ? 'block' : 'hidden' }}">
                        @if($pendingInstructors->count() > 0)
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Pending Instructor Registrations
                                    </h3>
                                    <p class="text-sm text-gray-600">Review and approve instructor account requests</p>
                                </div>
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('instructor.pending.verification.accept-all') }}" onsubmit="return confirm('Are you sure you want to accept all pending instructors?')">
                                        @csrf
                                        <input type="hidden" name="role" value="instructor">
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Accept All
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('instructor.pending.verification.reject-all') }}" onsubmit="return confirm('Are you sure you want to reject all pending instructors? This action cannot be undone.')">
                                        @csrf
                                        <input type="hidden" name="role" value="instructor">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject All
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingInstructors as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    <form method="POST" action="{{ route('instructor.pending.verification.accept', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('instructor.pending.verification.reject', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <p class="text-lg font-medium text-gray-900 mb-1">No pending instructor registrations</p>
                                <p class="text-sm text-gray-500">All instructor registration requests have been processed</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const applications = @json($applications);
        let filteredApplications = [...applications];
        let selectionFilteredCandidates = [...applications];
        
        const steps = [
            { name: 'attendance', title: 'Step 1: Attendance', description: 'Mark candidates who attended the selection process', field: 'attendance' },
            { name: 'marching_test', title: 'Step 2: Marching Test', description: 'Evaluate candidates on marching drill performance', field: 'drill_test' },
            { name: 'physical_test', title: 'Step 3: Physical Test', description: 'Assess physical fitness and endurance', field: 'physical_test' },
            { name: 'medical_test', title: 'Step 4: Medical Evaluation', description: 'Conduct medical examination and health assessment', field: 'medical_test' },
            { name: 'interview', title: 'Step 5: Interview', description: 'Conduct interviews with qualified candidates', field: 'interview' },
            { name: 'final_evaluation', title: 'Step 6: Final Evaluation', description: 'Final review and selection decision', field: 'final_evaluation' }
        ];

        let currentStep = 0;
        let selectionMode = false;
        let regularCurrentPage = 1;
        let selectionCurrentPage = 1;
        let statusFilter = 'all';
        const itemsPerPage = 10;

        document.addEventListener('DOMContentLoaded', function() {
            const cadetsTab = document.getElementById('cadets-tab');
            const instructorsTab = document.getElementById('instructors-tab');
            const cadetsContent = document.getElementById('cadets-content');
            const instructorsContent = document.getElementById('instructors-content');

            if (cadetsTab && instructorsTab) {
                cadetsTab.addEventListener('click', function() {
                    cadetsTab.className = cadetsTab.className.replace('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'border-blue-500 text-blue-600');
                    instructorsTab.className = instructorsTab.className.replace('border-blue-500 text-blue-600', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                    cadetsContent.classList.remove('hidden');
                    cadetsContent.classList.add('block');
                    instructorsContent.classList.remove('block');
                    instructorsContent.classList.add('hidden');
                });

                instructorsTab.addEventListener('click', function() {
                    instructorsTab.className = instructorsTab.className.replace('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'border-blue-500 text-blue-600');
                    cadetsTab.className = cadetsTab.className.replace('border-blue-500 text-blue-600', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');
                    instructorsContent.classList.remove('hidden');
                    instructorsContent.classList.add('block');
                    cadetsContent.classList.remove('block');
                    cadetsContent.classList.add('hidden');
                });
            }

            const toggleButton = document.getElementById('toggleSelectionMode');
            const toggleButtonText = document.getElementById('toggleButtonText');
            const regularView = document.getElementById('regularView');
            const selectionView = document.getElementById('selectionView');

            const searchInput = document.getElementById('applicationSearch');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    if (searchTerm === '') {
                        filteredApplications = [...applications];
                    } else {
                        filteredApplications = applications.filter(app =>
                            app.name.toLowerCase().includes(searchTerm) ||
                            app.gender.toLowerCase().includes(searchTerm) ||
                            app.course.toLowerCase().includes(searchTerm)
                        );
                    }
                    regularCurrentPage = 1;
                    renderApplicationTable();
                });
            }

            const selectionSearchInput = document.getElementById('selectionSearch');
            if (selectionSearchInput) {
                selectionSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    applyFilters(searchTerm);
                });
            }

            const statusFilterSelect = document.getElementById('statusFilter');
            if (statusFilterSelect) {
                statusFilterSelect.addEventListener('change', function() {
                    statusFilter = this.value;
                    const searchTerm = selectionSearchInput ? selectionSearchInput.value.toLowerCase().trim() : '';
                    applyFilters(searchTerm);
                });
            }

            renderApplicationTable();
            renderApplicationSummary();

            if (toggleButton) {
                toggleButton.addEventListener('click', function() {
                    selectionMode = !selectionMode;

                    if (selectionMode) {
                        regularView.classList.add('hidden');
                        selectionView.classList.remove('hidden');
                        toggleButtonText.textContent = 'Exit Selection';
                        toggleButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        toggleButton.classList.add('bg-gray-600', 'hover:bg-gray-700');
                        renderCandidates();
                        renderSelectionSummary();
                    } else {
                        regularView.classList.remove('hidden');
                        selectionView.classList.add('hidden');
                        toggleButtonText.textContent = 'Start Selection';
                        toggleButton.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                        toggleButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        renderApplicationTable();
                    }
                });
            }

            const prevButton = document.getElementById('prevStep');
            const nextButton = document.getElementById('nextStep');

            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    if (currentStep > 0) {
                        currentStep--;
                        selectionCurrentPage = 1;
                        updateStepDisplay();
                        renderCandidates();
                        renderSelectionSummary();
                    }
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        selectionCurrentPage = 1;
                        updateStepDisplay();
                        renderCandidates();
                        renderSelectionSummary();
                    }
                });
            }

            const regularPrevPage = document.getElementById('regularPrevPage');
            const regularNextPage = document.getElementById('regularNextPage');

            if (regularPrevPage) {
                regularPrevPage.addEventListener('click', function() {
                    if (regularCurrentPage > 1) {
                        regularCurrentPage--;
                        renderApplicationTable();
                    }
                });
            }

            if (regularNextPage) {
                regularNextPage.addEventListener('click', function() {
                    const totalPages = Math.ceil(filteredApplications.length / itemsPerPage);
                    if (regularCurrentPage < totalPages) {
                        regularCurrentPage++;
                        renderApplicationTable();
                    }
                });
            }

            const selectionPrevPage = document.getElementById('selectionPrevPage');
            const selectionNextPage = document.getElementById('selectionNextPage');

            if (selectionPrevPage) {
                selectionPrevPage.addEventListener('click', function() {
                    if (selectionCurrentPage > 1) {
                        selectionCurrentPage--;
                        renderCandidates();
                    }
                });
            }

            if (selectionNextPage) {
                selectionNextPage.addEventListener('click', function() {
                    const filteredCandidates = getFilteredCandidates();
                    const totalPages = Math.ceil(filteredCandidates.length / itemsPerPage);
                    if (selectionCurrentPage < totalPages) {
                        selectionCurrentPage++;
                        renderCandidates();
                    }
                });
            }
        });

        function applyFilters(searchTerm) {
            let filtered = applications;

            if (searchTerm !== '') {
                filtered = filtered.filter(app =>
                    app.name.toLowerCase().includes(searchTerm) ||
                    app.gender.toLowerCase().includes(searchTerm) ||
                    app.course.toLowerCase().includes(searchTerm)
                );
            }

            selectionFilteredCandidates = filtered;
            selectionCurrentPage = 1;
            renderCandidates();
            renderSelectionSummary();
        }

        function updateStepDisplay() {
            const currentStepTitle = document.getElementById('currentStepTitle');
            const currentStepDescription = document.getElementById('currentStepDescription');
            const prevButton = document.getElementById('prevStep');
            const nextButton = document.getElementById('nextStep');
            const endSelectionContainer = document.getElementById('endSelectionContainer');

            currentStepTitle.textContent = steps[currentStep].title;
            currentStepDescription.textContent = steps[currentStep].description;

            prevButton.disabled = currentStep === 0;
            
            if (currentStep === steps.length - 1) {
                nextButton.classList.add('hidden');
                endSelectionContainer.classList.remove('hidden');
            } else {
                nextButton.classList.remove('hidden');
                endSelectionContainer.classList.add('hidden');
            }

            for (let i = 0; i < steps.length; i++) {
                const progressElement = document.getElementById(`step${i + 1}Progress`);
                const circle = progressElement.querySelector('div');
                
                if (i === currentStep) {
                    circle.className = 'w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold';
                } else if (i < currentStep) {
                    circle.className = 'w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-bold';
                } else {
                    circle.className = 'w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold';
                }
            }
        }

        function getFilteredCandidates() {
            let candidates = selectionFilteredCandidates;

            if (currentStep > 0) {
                candidates = candidates.filter(app => {
                    for (let i = 0; i < currentStep; i++) {
                        const field = steps[i].field;
                        if (app[field] !== 'passed') {
                            return false;
                        }
                    }
                    return true;
                });
            }

            const currentField = steps[currentStep].field;
            if (statusFilter !== 'all') {
                candidates = candidates.filter(app => {
                    const status = app[currentField] || 'pending';
                    return status === statusFilter;
                });
            }

            return candidates;
        }

        function renderCandidates() {
            const tableBody = document.getElementById('candidatesTableBody');
            const filteredCandidates = getFilteredCandidates();
            const currentField = steps[currentStep].field;

            const totalPages = Math.ceil(filteredCandidates.length / itemsPerPage);
            const startIndex = (selectionCurrentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredCandidates.length);
            const paginatedCandidates = filteredCandidates.slice(startIndex, endIndex);

            tableBody.innerHTML = '';

            if (paginatedCandidates.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-400 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-medium">No candidates found</p>
                            <p class="text-sm">Try adjusting your filters or search criteria</p>
                        </td>
                    </tr>
                `;
            } else {
                paginatedCandidates.forEach((application, index) => {
                    const status = application[currentField] || 'pending';
                    const isPassed = status === 'passed';
                    const isFailed = status === 'failed';
                    const actualIndex = startIndex + index + 1;

                    const row = document.createElement('tr');
                    row.className = isFailed ? 'bg-red-50' : (isPassed ? 'bg-green-50' : '');
                    row.innerHTML = `
                        <td class="px-4 py-2 whitespace-nowrap">
                            <input type="checkbox"
                                   class="w-5 h-5 text-green-600 rounded focus:ring-green-500"
                                   data-app-id="${application.id}"
                                   ${isPassed ? 'checked' : ''}>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${actualIndex}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">${application.name}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${application.gender}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${application.course}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="flex gap-2">
                                <button onclick="updateStatus(${application.id}, '${steps[currentStep].name}', 'passed')" 
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200 ${isPassed ? 'opacity-50 cursor-not-allowed' : ''}">
                                    Pass
                                </button>
                                <button onclick="updateStatus(${application.id}, '${steps[currentStep].name}', 'failed')" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200 ${isFailed ? 'opacity-50 cursor-not-allowed' : ''}">
                                    Fail
                                </button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(row);

                    const checkbox = row.querySelector('input[type="checkbox"]');
                    checkbox.addEventListener('change', function() {
                        const newStatus = this.checked ? 'passed' : 'failed';
                        updateStatus(application.id, steps[currentStep].name, newStatus);
                    });
                });
            }

            updateSelectionPagination(filteredCandidates.length);
        }

        function renderApplicationTable() {
            const tableBody = document.getElementById('applicationTableBody');
            
            const totalPages = Math.ceil(filteredApplications.length / itemsPerPage);
            const startIndex = (regularCurrentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredApplications.length);
            const paginatedApplications = filteredApplications.slice(startIndex, endIndex);

            tableBody.innerHTML = '';

            if (paginatedApplications.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-400 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-medium">No applications found</p>
                            <p class="text-sm">Try adjusting your search criteria</p>
                        </td>
                    </tr>
                `;
            } else {
                paginatedApplications.forEach((application, index) => {
                    const isComplete = application.drill_test === 'passed' && application.physical_test === 'passed' && application.medical_test === 'passed' && application.interview === 'passed';
                    const hasFailed = application.drill_test === 'failed' || application.physical_test === 'failed' || application.medical_test === 'failed' || application.interview === 'failed';
                    const actualIndex = startIndex + index + 1;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${actualIndex}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${application.name}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${application.gender}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${application.phone_number}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${application.faculty}</td>
                        <td class="px-4 py-2 whitespace-nowrap text-sm">${application.course}</td>
                        <td class="px-4 py-2 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                ${isComplete ? 'bg-green-100 text-green-800' : hasFailed ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'}">
                                ${isComplete ? 'Complete' : hasFailed ? 'Failed' : 'In Progress'}
                            </span>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });
            }

            updateRegularPagination(filteredApplications.length);
        }
        function updateRegularPagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const startIndex = (regularCurrentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(regularCurrentPage * itemsPerPage, totalItems);

            document.getElementById('regularShowingStart').textContent = totalItems > 0 ? startIndex : 0;
            document.getElementById('regularShowingEnd').textContent = endIndex;
            document.getElementById('regularTotal').textContent = totalItems;

            document.getElementById('regularPrevPage').disabled = regularCurrentPage === 1;
            document.getElementById('regularNextPage').disabled = regularCurrentPage === totalPages || totalPages === 0;

            const pageNumbersContainer = document.getElementById('regularPageNumbers');
            pageNumbersContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= regularCurrentPage - 1 && i <= regularCurrentPage + 1)) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `px-3 py-2 rounded-lg ${i === regularCurrentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                    pageButton.addEventListener('click', function() {
                        regularCurrentPage = i;
                        renderApplicationTable();
                    });
                    pageNumbersContainer.appendChild(pageButton);
                } else if (i === regularCurrentPage - 2 || i === regularCurrentPage + 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-2 py-2 text-gray-500';
                    pageNumbersContainer.appendChild(ellipsis);
                }
            }
        }

        function updateSelectionPagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const startIndex = (selectionCurrentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(selectionCurrentPage * itemsPerPage, totalItems);

            document.getElementById('selectionShowingStart').textContent = totalItems > 0 ? startIndex : 0;
            document.getElementById('selectionShowingEnd').textContent = endIndex;
            document.getElementById('selectionTotal').textContent = totalItems;

            document.getElementById('selectionPrevPage').disabled = selectionCurrentPage === 1;
            document.getElementById('selectionNextPage').disabled = selectionCurrentPage === totalPages || totalPages === 0;

            const pageNumbersContainer = document.getElementById('selectionPageNumbers');
            pageNumbersContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= selectionCurrentPage - 1 && i <= selectionCurrentPage + 1)) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `px-3 py-2 rounded-lg ${i === selectionCurrentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                    pageButton.addEventListener('click', function() {
                        selectionCurrentPage = i;
                        renderCandidates();
                    });
                    pageNumbersContainer.appendChild(pageButton);
                } else if (i === selectionCurrentPage - 2 || i === selectionCurrentPage + 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-2 py-2 text-gray-500';
                    pageNumbersContainer.appendChild(ellipsis);
                }
            }
        }

        async function updateStatus(applicationId, step, status) {
            try {
                const response = await fetch('{{ route("instructor.pending.verification.update-step") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        application_id: applicationId,
                        step: step,
                        status: status
                    })
                });

                const data = await response.json();

                if (data.success) {
                    const app = applications.find(a => a.id === applicationId);
                    if (app) {
                        app[steps[currentStep].field] = status;
                    }

                    renderCandidates();
                    renderSelectionSummary();
                } else {
                    alert('Failed to update status. Please try again.');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                alert('An error occurred. Please try again.');
            }
        }

        function renderSelectionSummary() {
            const summaryContainer = document.getElementById('selectionSummary');
            summaryContainer.innerHTML = '';

            let eligibleCandidates = applications;
            for (let i = 0; i < currentStep; i++) {
                eligibleCandidates = eligibleCandidates.filter(app => app[steps[i].field] === 'passed');
            }

            const currentStepData = steps[currentStep];
            const totalInCurrentStep = eligibleCandidates.length;
            const passedInCurrentStep = eligibleCandidates.filter(app => app[currentStepData.field] === 'passed').length;
            const failedInCurrentStep = eligibleCandidates.filter(app => app[currentStepData.field] === 'failed').length;
            const pendingInCurrentStep = totalInCurrentStep - passedInCurrentStep - failedInCurrentStep;

            const totalCard = document.createElement('div');
            totalCard.className = 'p-4 rounded-lg border text-center bg-blue-50 border-blue-200';
            totalCard.innerHTML = `
                <div class="text-sm font-medium text-gray-600 mb-2">Total Candidates</div>
                <div class="text-2xl font-bold text-blue-900">${totalInCurrentStep}</div>
            `;
            summaryContainer.appendChild(totalCard);

            const passedCard = document.createElement('div');
            passedCard.className = 'p-4 rounded-lg border text-center bg-green-50 border-green-200';
            passedCard.innerHTML = `
                <div class="text-sm font-medium text-gray-600 mb-2">Passed</div>
                <div class="text-2xl font-bold text-green-900">${passedInCurrentStep}</div>
            `;
            summaryContainer.appendChild(passedCard);

            const failedCard = document.createElement('div');
            failedCard.className = 'p-4 rounded-lg border text-center bg-red-50 border-red-200';
            failedCard.innerHTML = `
                <div class="text-sm font-medium text-gray-600 mb-2">Failed</div>
                <div class="text-2xl font-bold text-red-900">${failedInCurrentStep}</div>
            `;
            summaryContainer.appendChild(failedCard);

            const pendingCard = document.createElement('div');
            pendingCard.className = 'p-4 rounded-lg border text-center bg-yellow-50 border-yellow-200';
            pendingCard.innerHTML = `
                <div class="text-sm font-medium text-gray-600 mb-2">Pending</div>
                <div class="text-2xl font-bold text-yellow-900">${pendingInCurrentStep}</div>
            `;
            summaryContainer.appendChild(pendingCard);
        }

        function renderApplicationSummary() {
            const summaryContainer = document.getElementById('applicationSummary');
            summaryContainer.innerHTML = '';

            const totalCandidates = applications.length;
            const maleCount = applications.filter(app => app.gender.toLowerCase() === 'male').length;
            const femaleCount = applications.filter(app => app.gender.toLowerCase() === 'female').length;

            const totalCard = document.createElement('div');
            totalCard.className = 'p-4 rounded-lg border text-center bg-blue-50 border-blue-200';
            totalCard.innerHTML = `
                <div class="text-sm font-medium text-gray-600 mb-2">Total Candidates</div>
                <div class="text-2xl font-bold text-blue-900">${totalCandidates}</div>
            `;
            summaryContainer.appendChild(totalCard);

            const maleCard = document.createElement('div');
            maleCard.className = 'p-4 rounded-lg border text-center bg-green-50 border-green-200';
            maleCard.innerHTML = `
                <div class="text-sm font-medium text-gray-600 mb-2">Male Candidates</div>
                <div class="text-2xl font-bold text-green-900">${maleCount}</div>
            `;
            summaryContainer.appendChild(maleCard);

            const femaleCard = document.createElement('div');
            femaleCard.className = 'p-4 rounded-lg border text-center bg-pink-50 border-pink-200';
            femaleCard.innerHTML = `
                <div class="text-sm font-medium text-gray-600 mb-2">Female Candidates</div>
                <div class="text-2xl font-bold text-pink-900">${femaleCount}</div>
            `;
            summaryContainer.appendChild(femaleCard);
        }
    </script>
</x-app-layout>