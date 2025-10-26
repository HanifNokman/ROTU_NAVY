<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Dashboard') }}
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

        /* Dashboard header responsive */
        .text-center.mb-8 h1 {
            font-size: 1.875rem !important;
            padding: 0 1rem;
        }

        .text-center.mb-8 p {
            font-size: 0.875rem !important;
            padding: 0 1rem;
        }

        /* Card spacing */
        .dashboard-card {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Personal profile section */
        .flex.flex-col.lg\\:flex-row {
            flex-direction: column !important;
        }

        /* Profile picture container */
        .flex.flex-row.lg\\:flex-col {
            flex-direction: row !important;
            align-items: flex-start !important;
        }

        /* Filters and controls responsive */
        .flex.justify-center select {
            font-size: 0.875rem !important;
            padding: 0.5rem !important;
        }

        /* Duty ranking and CGPA cards */
        .grid.grid-cols-1.lg\\:grid-cols-2 {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }

        /* Add duty button */
        .bg-green-600.hover\\:bg-green-700 {
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
        }

        .bg-green-600.hover\\:bg-green-700 span {
            display: inline !important;
        }

        /* Absence section filters */
        .flex.flex-col.sm\\:flex-row.items-start {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .flex.flex-col.sm\\:flex-row.items-start select {
            width: 100% !important;
        }

        /* Absence toggle buttons */
        .flex.bg-gray-100.rounded-lg.p-1 {
            width: 100% !important;
        }

        .flex.bg-gray-100.rounded-lg.p-1 button {
            font-size: 0.75rem !important;
            padding: 0.5rem 0.25rem !important;
        }

        /* Modal adjustments */
        .bg-white.p-6.rounded-lg.shadow-lg {
            margin: 1rem !important;
            padding: 1rem !important;
            max-width: calc(100vw - 2rem) !important;
        }

        /* Scrollable content areas */
        #duty-ranking-content,
        #cgpa-content,
        #absence-content {
            max-height: 300px !important;
        }
    }

    /* Extra small devices (Honor X9a - 360px-412px) */
    @media (max-width: 400px) {
        /* Further reduce text sizes */
        .text-center.mb-8 h1 {
            font-size: 1.5rem !important;
        }

        .section-header h3 {
            font-size: 1.125rem !important;
        }

        /* Compact filters */
        .flex.justify-center {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .flex.justify-center select {
            width: 100% !important;
        }

        /* Smaller icons */
        .icon-wrapper {
            width: 2rem !important;
            height: 2rem !important;
        }

        .icon-wrapper svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }

        /* Compact info items */
        .info-item {
            padding: 0.5rem !important;
            font-size: 0.75rem !important;
        }

        /* Reduce absence section toggle buttons */
        .flex.bg-gray-100.rounded-lg.p-1 button span {
            font-size: 0.625rem !important;
        }
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- SUCCESS MESSAGE ALERT --}}
            {{-- ================================================================ --}}
            @if(session('success'))
                <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="document.getElementById('success-alert').style.display='none'">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            {{-- ================================================================ --}}
            {{-- DASHBOARD HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-blue rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0121 14.657V8m-9 6l-6.16-3.422A12.083 12.083 0 013 14.657V8"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">
                    Instructor Dashboard
                </h1>
                <p class="text-lg text-gray-600">Your command center for cadet management and analytics</p>
            </div>
            {{-- ================================================================ --}}
            {{-- PERSONAL PROFILE SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden" x-data="{ open: false }">
                <div class="section-header" @click="open = !open" style="cursor: pointer;">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-blue mr-3 p-2 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Personal Profile</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 ml-13">Your profile information and service details</p>
                </div>

                <div class="p-8"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0">
                    <div class="flex flex-col lg:flex-row gap-8">
                        {{-- Profile Picture & Badges Section --}}
                        <div class="flex flex-row lg:flex-col items-start lg:items-start space-x-4 lg:space-x-0 lg:space-y-4">
                            <div class="relative flex-shrink-0">
                                <img src="{{ $instructor?->profile_pic ? asset('storage/' . $instructor->profile_pic) : asset('images/default.png') }}"
                                    alt="Profile Picture"
                                    class="w-32 h-44 sm:w-48 sm:h-64 md:w-56 md:h-80 object-cover rounded-2xl shadow-lg border-4 border-white">
                                <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-2 shadow-lg">
                                    <div class="w-12 h-12 gradient-blue rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Displayed Badges --}}
                            @if($instructor->instructorBadges && $instructor->instructorBadges->count() > 0)
                                <div class="flex-1 lg:w-full lg:max-w-[14rem] md:max-w-[16rem] space-y-2 max-h-[176px] sm:max-h-[256px] md:max-h-[320px] lg:max-h-none overflow-y-auto custom-scrollbar">
                                    @php
                                        // Define rarity order (higher number = higher priority/rarity)
                                        $rarityOrder = ['Platinum' => 5, 'Gold' => 4, 'Silver' => 3, 'Bronze' => 2, 'Standard' => 1];

                                        // Sort badges by rarity (descending - highest first)
                                        $sortedBadges = $instructor->instructorBadges->sortByDesc(function($instructorBadge) use ($rarityOrder) {
                                            $rarity = $instructorBadge->badge->rarity_label ?? 'Standard';
                                            return $rarityOrder[$rarity] ?? 0;
                                        });
                                    @endphp

                                    @foreach($sortedBadges as $instructorBadge)
                                        <div class="bg-white rounded-lg p-2 sm:p-3 border border-gray-200 hover:border-gray-300 hover:shadow-md transition-all duration-200 flex items-center space-x-2 sm:space-x-3">
                                            @if($instructorBadge->badge->icon_path)
                                                <img src="{{ asset('storage/assets/badges/' . $instructorBadge->badge->icon_path) }}"
                                                    alt="{{ $instructorBadge->badge->name }}"
                                                    class="w-8 h-8 sm:w-10 sm:h-10 object-contain flex-shrink-0">
                                            @else
                                                <span class="text-2xl sm:text-3xl flex-shrink-0">🏆</span>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs sm:text-sm font-semibold text-gray-900 truncate">{{ $instructorBadge->badge->name }}</p>
                                                <p class="text-xs text-gray-600" style="color: {{ $instructorBadge->badge->rarity_color ?? '#6b7280' }};">
                                                    {{ $instructorBadge->badge->rarity_label ?? 'Badge' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Profile Information --}}
                        <div class="flex-1 space-y-6">
                            {{-- Rank and Name --}}
                            <div class="info-card">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="icon-wrapper gradient-blue">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Rank & Identity</h3>
                                </div>
                                @php
                                    $prefix = '';
                                    if (str_starts_with($instructor?->service_number, 'NV')) {
                                        $prefix = ' PSSTLDM';
                                    } elseif (str_starts_with($instructor?->service_number, 'N')) {
                                        $prefix = ' TLDM';
                                    }
                                @endphp
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ ($instructor?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') . $prefix }}
                                </p>
                            </div>

                            {{-- Contact Information --}}
                            <div class="info-card">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="icon-wrapper bg-green-100">
                                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Contact Information</h3>
                                </div>
                                <div class="space-y-3">
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-green-50 mr-3">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Phone Number</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $instructor?->phone_number ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-blue-50 mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Email Address</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $user?->email ?? 'Not set' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- General Information --}}
                            <div class="info-card">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="icon-wrapper bg-purple-100">
                                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Service Information</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-blue-50 mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Position</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $instructor->position ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-purple-50 mr-3">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Expertise</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $instructor->expertise ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-orange-50 mr-3">
                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Service Years</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $instructor->time_in_service ? $instructor->time_in_service . ' Years' : '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-green-50 mr-3">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">TTP</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $instructor->ttp ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-green-50 mr-3">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Status</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $instructor->status ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-blue-50 mr-3">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Service Number</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ $instructor->service_number ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="icon-wrapper-sm bg-gray-50 mr-3">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-medium">Past Units</p>
                                            <p class="text-sm font-semibold text-gray-900">{{ is_array($instructor->past_unit) ? implode(', ', $instructor->past_unit) : ($instructor->past_unit ?? '-') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ================================================================ --}}
            {{-- PERFORMANCE METRICS GRID --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ================================================================ --}}
                {{-- DUTY RANKING CARD --}}
                {{-- ================================================================ --}}
                <div class="dashboard-card bg-white rounded-xl overflow-hidden" x-data="{ open: false, selected: [] }">
                    
                    <div class="section-header">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-green mr-3 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Duty Ranking</h3>
                            </div>
                            <button @click="$store.modal.open = true" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span class="flex-shrink-0">Add Duty</span>
                            </button>
                        </div>
                        <p class="text-gray-600 ml-13">Manage cadet duty assignments and performance</p>
                    </div>

                    <div class="p-6">
                        
                        <div class="mb-4 flex justify-center">
                            <form method="GET" action="{{ route('instructor.dashboard') }}" class="flex gap-2">
                                <select id="duty-intake-year" name="duty_intake_year" class="rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                                    @foreach ($intakeOptions as $option)
                                        <option value="{{ $option['year'] }}" {{ $selectedDutyIntakeYear == $option['year'] ? 'selected' : '' }}>
                                            {{ $option['label'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <select id="duty-sort-order" name="sort_order" class="rounded-md border-gray-300 shadow-sm" onchange="this.form.submit()">
                                    <option value="desc" {{ $sortOrder == 'desc' ? 'selected' : '' }}>Highest First</option>
                                    <option value="asc" {{ $sortOrder == 'asc' ? 'selected' : '' }}>Lowest First</option>
                                </select>

                                <input type="hidden" name="cgpa_intake_year" value="{{ $selectedCgpaIntakeYear }}">
                                <input type="hidden" name="cgpa_sort_order" value="{{ $cgpaSortOrder }}">
                                <input type="hidden" name="absence_intake_filter" value="{{ $selectedAbsenceIntake ?? '' }}">
                            </form>
                        </div>

                        <div id="duty-loading" class="hidden text-center py-4">
                            <div class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading...
                            </div>
                        </div>

                        <div class="duty-ranking-wrapper">
                            <div id="duty-ranking-content" class="space-y-4">
                                @php
                                    $maxCount = $cadets->max('daily_duty_count') ?: 1;
                                @endphp

                                @forelse ($cadets as $index => $cadet)
                                    @php
                                        $percentage = ($cadet->daily_duty_count / $maxCount) * 100;
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

                                    <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex-1 w-full">
                                            <div class="text-sm font-medium mb-1 text-center sm:text-left">
                                                #{{ $index + 1 }} - {{ $cadet->name }}
                                            </div>

                                            <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                                                <div class="absolute top-0 left-0 h-full rounded-full flex items-center" style="width: {{ $percentage }}%; background-color: {{ $bgColor }};">
                                                    <span class="text-white font-semibold text-sm pl-2 whitespace-nowrap">
                                                        {{ $cadet->daily_duty_count }} {{ Str::plural('Day', $cadet->daily_duty_count) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-500">No cadets available.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ================================================================ --}}
                {{-- CGPA ANALYTICS CARD --}}
                {{-- ================================================================ --}}
                <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                    
                    <div class="section-header">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-purple mr-3 p-2 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">Cadet CGPA Analytics</h3>
                        </div>
                        <p class="text-gray-600 ml-13">Academic performance tracking and comparison</p>
                    </div>

                    <div class="p-6">
                        
                        <div class="mb-4 flex justify-center gap-2">
                            <select id="cgpa-intake-year" class="rounded-md border-gray-300 shadow-sm">
                                @foreach ($intakeOptions as $option)
                                    <option value="{{ $option['year'] }}" {{ $selectedCgpaIntakeYear == $option['year'] ? 'selected' : '' }}>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                                
                            <select id="cgpa-sort-order" class="rounded-md border-gray-300 shadow-sm">
                                <option value="desc" {{ $cgpaSortOrder == 'desc' ? 'selected' : '' }}>Most Improvement</option>
                                <option value="asc" {{ $cgpaSortOrder == 'asc' ? 'selected' : '' }}>Most Decline</option>
                            </select>
                        </div>

                        <div id="cgpa-loading" class="hidden text-center py-4">
                            <div class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading...
                            </div>
                        </div>

                        <div class="cgpa-wrapper">
                            <div id="cgpa-content" class="space-y-4">
                                @php
                                    $maxCgpa = max($cgpaCadets->max('current_cgpa'), $cgpaCadets->max('past_cgpa')) ?: 4.0;
                                @endphp

                                @forelse ($cgpaCadets as $index => $cadet)
                                    @php
                                        $pastPercentage = ($cadet->past_cgpa / $maxCgpa) * 100;
                                        $currentPercentage = ($cadet->current_cgpa / $maxCgpa) * 100;
                                        $cgpaChange = $cadet->current_cgpa - $cadet->past_cgpa;
                                        $currentColor = $cgpaChange >= 0 ? '#10b981' : '#ef4444';
                                        $pastColor = '#3b82f6';
                                    @endphp

                                    <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 group">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-blue-200 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                        </div>

                                        <div class="flex-1 w-full">
                                            <div class="text-sm font-medium mb-1 text-center sm:text-left flex justify-between items-center">
                                                <span>#{{ $index + 1 }} - {{ $cadet->name }}</span>
                                                <span class="text-xs {{ $cgpaChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $cgpaChange >= 0 ? '+' : '' }}{{ number_format($cgpaChange, 2) }}
                                                </span>
                                            </div>

                                            <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden">
                                                <div class="absolute top-0 left-0 h-full rounded-full" style="width: {{ $currentPercentage }}%; background-color: {{ $currentColor }};"></div>
                                                <span class="absolute inset-0 flex items-center justify-start pl-2 text-white font-semibold text-xs">
                                                    Current: {{ number_format($cadet->current_cgpa, 2) }}
                                                </span>
                                            </div>

                                            <div class="relative h-5 rounded-full bg-gray-200 overflow-hidden mb-1">
                                                <div class="absolute top-0 left-0 h-full rounded-full" style="width: {{ $pastPercentage }}%; background-color: {{ $pastColor }};"></div>
                                                <span class="absolute inset-0 flex items-center justify-start pl-2 text-white font-semibold text-xs">
                                                    Past: {{ number_format($cadet->past_cgpa, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-500">No CGPA data available for this intake.</div>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex justify-center gap-4 text-sm mt-4">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-blue-500 rounded"></div>
                                <span>Past CGPA</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-green-500 rounded"></div>
                                <span>Improved</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-red-500 rounded"></div>
                                <span>Declined</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ================================================================ --}}
            {{-- PENDING ABSENCE REASONS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden" x-data="{ open: false }">

                <div class="section-header" @click="open = !open" style="cursor: pointer;">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center mb-2">
                            <div class="icon-wrapper gradient-red mr-3 p-2 rounded-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                <span id="absence-section-title">Pending Absence Reasons</span>
                                @if(isset($absentCadets) && !empty($absentCadets))
                                    <span id="absence-count-badge" class="ml-3 bg-red-500 text-white text-sm px-3 py-1 rounded-full">
                                        {{ collect($absentCadets)->flatten(1)->count() }}
                                    </span>
                                @endif
                            </h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <p id="absence-section-description" class="text-gray-600 ml-13">Cadets with training absences requiring documentation</p>
                </div>

                <div class="p-6"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0">

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6">
                        <div class="flex bg-gray-100 rounded-lg p-1 self-stretch sm:self-auto">
                            <button id="pending-view-btn" onclick="toggleAbsenceView('pending')" class="px-3 sm:px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 bg-red-500 text-white shadow-sm flex-1 sm:flex-none">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <span class="hidden sm:inline">Pending</span>
                                <span class="sm:hidden">Pending</span>
                            </button>
                            <button id="leaderboard-view-btn" onclick="toggleAbsenceView('leaderboard')" class="px-3 sm:px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-900 flex-1 sm:flex-none">
                                <i class="fas fa-chart-bar mr-1"></i>
                                <span class="hidden sm:inline">Absence List</span>
                                <span class="sm:hidden">List</span>
                            </button>
                        </div>

                        <div id="absence-filter-container" class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                            <label for="absence-intake-filter" class="text-sm font-medium text-gray-700 whitespace-nowrap">Filter by Intake:</label>
                            <select id="absence-intake-filter" class="rounded-md border-gray-300 shadow-sm text-sm w-full sm:w-auto">
                                <option value="">All Intakes</option>
                                @foreach ($intakeOptions as $option)
                                    <option value="{{ $option['year'] }}" {{ ($selectedAbsenceIntake ?? '') == $option['year'] ? 'selected' : '' }}>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="absence-loading" class="hidden text-center py-4">
                        <div class="inline-flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Loading absence data...
                        </div>
                    </div>
                    {{-- ================================================================ --}}
                    {{-- PENDING ABSENCE DATA --}}
                    {{-- ================================================================ --}}
                    <div id="absence-content" class="space-y-4 max-h-[600px] overflow-y-auto">
                        @if(isset($absentCadets) && !empty($absentCadets))
                            @foreach ($absentCadets as $intakeLabel => $cadets)
                                @if(($selectedAbsenceIntake ?? '') === '' || ($selectedAbsenceIntake ?? '') === 'all')
                                    
                                    <div class="border border-red-200 rounded-lg overflow-hidden">
                                        <div class="bg-red-50 px-4 py-3 border-b border-red-200">
                                            <h4 class="font-semibold text-red-800 flex items-center">
                                                <i class="fas fa-users mr-2"></i>
                                                {{ $intakeLabel }}
                                                <span class="ml-2 bg-red-200 text-red-800 px-2 py-1 rounded-full text-xs">
                                                    {{ count($cadets) }} {{ Str::plural('cadet', count($cadets)) }}
                                                </span>
                                            </h4>
                                        </div>
                                        <div class="p-4 space-y-3">
                                            @foreach($cadets as $cadet)
                                                <div class="border border-orange-200 rounded-lg overflow-hidden bg-white">
                                                    <button onclick="toggleAbsenceDropdown({{ $cadet->id }})" class="w-full flex justify-between items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                                <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                                </svg>
                                                            </div>
                                                            <div class="text-left">
                                                                <p class="font-semibold text-gray-900">{{ $cadet->name }}</p>
                                                                <p class="text-sm text-gray-600">Service: {{ $cadet->service_number ?? 'N/A' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="flex items-center space-x-3">
                                                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                                {{ count($cadet->pending_absences) }} {{ Str::plural('absence', count($cadet->pending_absences)) }}
                                                            </span>
                                                            <svg id="absence-icon-{{ $cadet->id }}" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    
                                                    <div id="absence-dropdown-{{ $cadet->id }}" class="hidden border-t border-orange-200">
                                                        <div class="p-4 space-y-3">
                                                            <h5 class="font-medium text-gray-800 mb-3 flex items-center">
                                                                <i class="fas fa-list mr-2 text-red-500"></i>
                                                                Missing Documentation for:
                                                            </h5>
                                                            
                                                            @foreach($cadet->pending_absences as $absence)
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
                                    
                                    <div class="p-4 space-y-3">
                                        @foreach($cadets as $cadet)
                                            <div class="border border-orange-200 rounded-lg overflow-hidden bg-white">
                                                <button onclick="toggleAbsenceDropdown({{ $cadet->id }})" class="w-full flex justify-between items-center px-4 py-3 bg-orange-50 hover:bg-orange-100 transition-colors duration-200">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="w-8 h-8 bg-orange-200 rounded-full flex items-center justify-center flex-shrink-0">
                                                            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 12c2.21 0 4-1.79 4-4S14.21 4 12 4 8 5.79 8 8s1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                            </svg>
                                                        </div>
                                                        <div class="text-left">
                                                            <p class="font-semibold text-gray-900">{{ $cadet->name }}</p>
                                                            <p class="text-sm text-gray-600">Service: {{ $cadet->service_number ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-3">
                                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                            {{ count($cadet->pending_absences) }} {{ Str::plural('absence', count($cadet->pending_absences)) }}
                                                        </span>
                                                        <svg id="absence-icon-{{ $cadet->id }}" class="w-5 h-5 text-gray-400 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </div>
                                                </button>

                                                <div id="absence-dropdown-{{ $cadet->id }}" class="hidden border-t border-orange-200">
                                                    <div class="p-4 space-y-3">
                                                        <h5 class="font-medium text-gray-800 mb-3 flex items-center">
                                                            <i class="fas fa-list mr-2 text-red-500"></i>
                                                            Missing Documentation for:
                                                        </h5>

                                                        @foreach($cadet->pending_absences as $absence)
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
                                @endif
                            @endforeach
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
                    {{-- ================================================================ --}}
                    {{-- ABSENCE LEADERBOARD --}}
                    {{-- ================================================================ --}}
                    <div id="absence-leaderboard-content" class="hidden space-y-4 max-h-[600px] overflow-y-auto">
                        @if(isset($absenceLeaderboard) && !empty($absenceLeaderboard))
                            @if(($selectedAbsenceIntake ?? '') === '' || ($selectedAbsenceIntake ?? '') === 'all')
                                @foreach ($absenceLeaderboard as $intakeLabel => $cadets)
                                    @if(!empty($cadets))
                                        <div class="border border-yellow-200 rounded-lg overflow-hidden">
                                            <div class="bg-yellow-50 px-4 py-3 border-b border-yellow-200">
                                                <h4 class="font-semibold text-yellow-800 flex items-center">
                                                    <i class="fas fa-users mr-2"></i>
                                                    {{ $intakeLabel }}
                                                    <span class="ml-2 bg-yellow-200 text-yellow-800 px-2 py-1 rounded-full text-xs">
                                                        {{ count($cadets) }} {{ Str::plural('cadet', count($cadets)) }}
                                                    </span>
                                                </h4>
                                            </div>
                                            <div class="p-4 space-y-3">
                                                @foreach($cadets as $index => $cadet)
                                                    @php
                                                        $attended = $cadet->total_trainings - $cadet->absence_count;
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
                                                                #{{ $index + 1 }} - {{ $cadet->cadet_name }}
                                                            </div>
                                                            <div class="text-center sm:text-left flex flex-col sm:flex-row gap-1 sm:gap-0">
                                                                <span class="text-sm font-semibold text-gray-800">
                                                                    Training Attended: {{ $attended }} / {{ $cadet->total_trainings }}
                                                                </span>
                                                                <span class="text-sm font-semibold text-red-600 sm:ml-4">
                                                                    Total Absence: {{ $cadet->absence_count }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="p-4 space-y-3">
                                    @foreach($absenceLeaderboard as $index => $cadet)
                                        @php
                                            $attended = $cadet->total_trainings - $cadet->absence_count;
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
                                                #{{ $index + 1 }} - {{ $cadet->cadet_name }}
                                            </div>
                                            <div class="text-center sm:text-left">
                                                <span class="text-sm font-semibold text-gray-800">
                                                    Training Attended: {{ $attended }} / {{ $cadet->total_trainings }}
                                                </span>
                                                <span class="text-sm font-semibold text-red-600 ml-4">
                                                    Total Absence: {{ $cadet->absence_count }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
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
            {{-- Mobile Bottom Spacer --}}
            <div class="block md:hidden h-20"></div>
        </div>
    </div>
    </div>

    {{-- ================================================================ --}}
    {{-- DUTY INCREMENT MODAL --}}
    {{-- ================================================================ --}}
    <div x-show="$store.modal.open" x-cloak x-transition class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-[9999]" @click.self="$store.modal.open = false; $store.modal.selected = []">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg max-h-[80vh] overflow-y-auto relative">

            <button @click="$store.modal.open = false; $store.modal.selected = []" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                ×
            </button>

            <h2 class="text-xl font-bold mb-4 text-center pr-8">Select Cadets on Duty</h2>
            <p class="text-center text-gray-600 mb-4">Intake - {{ $selectedDutyIntakeYear - 2011 }}</p>

            <form method="POST" action="{{ route('instructor.incrementDuty') }}">
                @csrf
                <input type="hidden" name="duty_intake_year" value="{{ $selectedDutyIntakeYear }}">
                <input type="hidden" name="sort_order" value="{{ $sortOrder }}">

                <div id="modal-cadet-list" class="space-y-2 max-h-[315px] overflow-y-auto border p-2 rounded mb-4">
                    <template x-for="cadet in $store.modal.cadets" :key="cadet.id">
                        <div class="flex items-center justify-between border p-2 rounded">
                            <span x-text="cadet.name + ' (' + cadet.service_number + ')'"></span>
                            <input type="checkbox" x-model="$store.modal.selected" :value="cadet.id" name="cadet_ids[]">
                        </div>
                    </template>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 inline-flex items-center gap-2" :disabled="$store.modal.selected.length === 0">
                        <i class="fas fa-plus"></i>
                        <span>Add Duty Count</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        let currentAbsenceView = 'pending';
        
        // ================================================================
        // SCROLL DETECTION FOR DUTY RANKING AND CGPA ANALYTICS
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
            
            // Check CGPA Analytics
            const cgpaContainer = document.getElementById('cgpa-content');
            const cgpaWrapper = cgpaContainer?.closest('.cgpa-wrapper');
            
            if (cgpaContainer && cgpaWrapper) {
                if (cgpaContainer.scrollHeight > cgpaContainer.clientHeight) {
                    cgpaWrapper.classList.add('has-scroll');
                } else {
                    cgpaWrapper.classList.remove('has-scroll');
                }
            }
        }

        // Check on load and after updates
        checkScrollableContent();
        window.addEventListener('resize', checkScrollableContent);
        
        // ================================================================
        // ABSENCE VIEW TOGGLE FUNCTION
        // ================================================================
        function toggleAbsenceView(view) {
            const pendingBtn = document.getElementById('pending-view-btn');
            const leaderboardBtn = document.getElementById('leaderboard-view-btn');
            const pendingContent = document.getElementById('absence-content');
            const leaderboardContent = document.getElementById('absence-leaderboard-content');
            const sectionTitle = document.getElementById('absence-section-title');
            const sectionDescription = document.getElementById('absence-section-description');
            const countBadge = document.getElementById('absence-count-badge');
            const filterContainer = document.getElementById('absence-filter-container');
            
            if (view === 'pending') {
                currentAbsenceView = 'pending';
                
                pendingBtn.classList.add('bg-red-500', 'text-white', 'shadow-sm');
                pendingBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                leaderboardBtn.classList.remove('bg-yellow-500', 'text-white', 'shadow-sm');
                leaderboardBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                
                pendingContent.classList.remove('hidden');
                leaderboardContent.classList.add('hidden');
                
                if (filterContainer) {
                    filterContainer.classList.remove('hidden');
                }
                
                sectionTitle.textContent = 'Pending Absence Reasons';
                sectionDescription.textContent = 'Cadets with training absences requiring documentation';
                if (countBadge) countBadge.classList.remove('hidden');
                
            } else if (view === 'leaderboard') {
                currentAbsenceView = 'leaderboard';
                
                leaderboardBtn.classList.add('bg-yellow-500', 'text-white', 'shadow-sm');
                leaderboardBtn.classList.remove('text-gray-600', 'hover:text-gray-900');
                pendingBtn.classList.remove('bg-red-500', 'text-white', 'shadow-sm');
                pendingBtn.classList.add('text-gray-600', 'hover:text-gray-900');
                
                leaderboardContent.classList.remove('hidden');
                pendingContent.classList.add('hidden');
                
                if (filterContainer) {
                    filterContainer.classList.add('hidden');
                }
                
                sectionTitle.textContent = 'Absence Summary - All Intakes';
                sectionDescription.textContent = 'Overview of cadets requiring attendance improvement';
                if (countBadge) countBadge.classList.add('hidden');
            }
        }

        window.toggleAbsenceView = toggleAbsenceView;

        // ================================================================
        // CGPA ANALYTICS AJAX LOADER
        // ================================================================
        function loadCgpaAnalytics() {
            const intakeYear = document.getElementById('cgpa-intake-year').value;
            const sortOrder = document.getElementById('cgpa-sort-order').value;

            document.getElementById('cgpa-loading').classList.remove('hidden');
            document.getElementById('cgpa-content').classList.add('opacity-50');

            const formData = new FormData();
            formData.append('duty_intake_year', document.getElementById('duty-intake-year').value);
            formData.append('sort_order', document.getElementById('duty-sort-order').value);
            formData.append('cgpa_intake_year', intakeYear);
            formData.append('cgpa_sort_order', sortOrder);

            fetch('{{ route("instructor.dashboard") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('CGPA analytics AJAX response:', data);
                if (data.cgpa_html) {
                    document.getElementById('cgpa-content').innerHTML = data.cgpa_html;
                }
                // Check scroll after content update
                setTimeout(checkScrollableContent, 100);
            })
            .catch(error => {
                console.error('Error loading CGPA analytics:', error);
            })
            .finally(() => {
                document.getElementById('cgpa-loading').classList.add('hidden');
                document.getElementById('cgpa-content').classList.remove('opacity-50');
            });
        }

        // ================================================================
        // ABSENCE DATA AJAX LOADER
        // ================================================================
        function loadAbsenceData() {
            const intakeFilter = document.getElementById('absence-intake-filter').value;

            document.getElementById('absence-loading').classList.remove('hidden');
            
            const pendingContent = document.getElementById('absence-content');
            const leaderboardContent = document.getElementById('absence-leaderboard-content');
            
            if (pendingContent) pendingContent.classList.add('opacity-50');
            if (leaderboardContent) leaderboardContent.classList.add('opacity-50');

            const formData = new FormData();
            formData.append('absence_intake_filter', intakeFilter);
            formData.append('duty_intake_year', document.getElementById('duty-intake-year').value);
            formData.append('sort_order', document.getElementById('duty-sort-order').value);
            formData.append('cgpa_intake_year', document.getElementById('cgpa-intake-year').value);
            formData.append('cgpa_sort_order', document.getElementById('cgpa-sort-order').value);

            fetch('{{ route("instructor.dashboard") }}', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Absence data AJAX response:', data);
                
                if (data.absence_html && pendingContent) {
                    pendingContent.innerHTML = data.absence_html;
                }
                if (data.absence_leaderboard_html && leaderboardContent) {
                    leaderboardContent.innerHTML = data.absence_leaderboard_html;
                }
                
                const countBadge = document.getElementById('absence-count-badge');
                if (countBadge && data.absence_count !== undefined) {
                    if (data.absence_count > 0) {
                        countBadge.textContent = data.absence_count;
                        countBadge.classList.remove('hidden');
                    } else {
                        countBadge.classList.add('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error loading absence data:', error);
            })
            .finally(() => {
                document.getElementById('absence-loading').classList.add('hidden');
                if (pendingContent) pendingContent.classList.remove('opacity-50');
                if (leaderboardContent) leaderboardContent.classList.remove('opacity-50');
            });
        }

        // ================================================================
        // EVENT LISTENERS
        // ================================================================
        document.getElementById('cgpa-intake-year').addEventListener('change', loadCgpaAnalytics);
        document.getElementById('cgpa-sort-order').addEventListener('change', loadCgpaAnalytics);
        document.getElementById('absence-intake-filter').addEventListener('change', loadAbsenceData);

        // Check scroll after duty ranking updates
        const dutyIntakeYear = document.getElementById('duty-intake-year');
        const dutySortOrder = document.getElementById('duty-sort-order');

        if (dutyIntakeYear) {
            dutyIntakeYear.addEventListener('change', function() {
                setTimeout(checkScrollableContent, 500);
            });
        }

        if (dutySortOrder) {
            dutySortOrder.addEventListener('change', function() {
                setTimeout(checkScrollableContent, 500);
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
    // ALPINE.JS MODAL STORE
    // ================================================================
    document.addEventListener('alpine:init', () => {
        Alpine.store('modal', {
            open: false,
            selected: [],
            cadets: @json($cadetList->map(function($cadet) {
                return [
                    'id' => $cadet->id,
                    'name' => $cadet->user->name,
                    'service_number' => $cadet->service_number
                ];
            }))
        });
    });
    </script>
</x-app-layout>
