<x-app-layout>
    <x-slot name="header">
        <h2 id="legacy-gallery-header" class="font-semibold text-xl leading-tight transition-colors duration-500" style="color: #1f2937;">
            {{ __('Legacy Gallery') }}
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

    @media (max-width: 768px) {
        .dashboard-card:hover {
            transform: translateY(-2px);
        }
    }

    .section-header {
        padding: 1.75rem;
        border-bottom: 2px solid #f3f4f6;
        background: linear-gradient(to right, #f8fafc 0%, #f1f5f9 100%);
    }

    @media (max-width: 768px) {
        .section-header {
            padding: 1rem;
        }
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

    @media (max-width: 768px) {
        .icon-wrapper {
            width: 2rem;
            height: 2rem;
        }
    }

    /* ========================================= */
    /* GRADIENT BACKGROUNDS */
    /* ========================================= */
    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* ========================================= */
    /* TRANSITION EFFECTS FOR TOGGLE */
    /* ========================================= */
    .content-transition {
        transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
    }

    .content-hidden {
        opacity: 0;
        transform: translateY(10px);
        pointer-events: none;
        position: absolute;
        visibility: hidden;
    }

    .content-visible {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
        position: relative;
        visibility: visible;
    }

    /* ========================================= */
    /* GOLDEN GLOW HOVER EFFECT */
    /* ========================================= */
    .portrait-frame {
        transition: box-shadow 0.4s ease-in-out;
    }

    @media (hover: hover) {
        .group:hover .portrait-frame {
            box-shadow:
                inset 0 0 30px rgba(0,0,0,0.5),
                inset 0 4px 10px rgba(255,215,0,0.3),
                inset 0 -4px 10px rgba(0,0,0,0.4),
                0 15px 45px rgba(0,0,0,0.7),
                0 0 0 3px #5d4037,
                0 0 0 10px #b8860b,
                0 0 0 12px #3e2723,
                0 0 20px rgba(212,175,55,0.5),
                0 0 30px rgba(218,165,32,0.35),
                0 0 45px rgba(255,215,0,0.25) !important;
        }
    }

    /* ========================================= */
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 768px) {
        /* Reduce portrait frame width for mobile */
        .portrait-frame-container {
            width: 280px !important;
        }

        /* Adjust header icon size */
        .header-icon {
            width: 4rem !important;
            height: 4rem !important;
        }

        .header-icon svg {
            width: 2rem !important;
            height: 2rem !important;
        }

        /* Adjust title font sizes */
        #page-title {
            font-size: 2rem !important;
        }

        #page-description {
            font-size: 0.95rem !important;
            padding: 0 1rem;
        }

        /* Adjust toggle buttons */
        .toggle-btn {
            padding: 0.65rem 1.25rem !important;
            font-size: 0.9rem !important;
        }

        /* Adjust intake header */
        .intake-header {
            font-size: 1.5rem !important;
            padding: 0.5rem 1rem !important;
        }

        /* Reduce spacing between frames */
        .hall-of-fame-grid {
            gap: 2rem !important;
        }

        /* Adjust rope decorations */
        .rope-decoration {
            width: 60px !important;
        }

        /* Adjust profile picture size in frames */
        .profile-pic-container {
            width: 140px !important;
            height: 182px !important;
        }

        /* Smaller name plaque */
        .name-plaque {
            max-width: 240px !important;
            padding: 0.5rem 1rem !important;
        }

        .cadet-name {
            font-size: 14px !important;
        }

        /* Adjust award ribbon */
        .award-ribbon {
            font-size: 0.65rem !important;
            padding: 0.4rem 0.75rem !important;
        }

        /* Alumni tree adjustments */
        .alumni-tree-spacing {
            gap: 1rem !important;
        }

        .alumni-portrait {
            width: 5rem !important;
            height: 7rem !important;
        }

        .alumni-portrait svg {
            width: 1.75rem !important;
            height: 1.75rem !important;
        }

        .alumni-name {
            font-size: 0.7rem !important;
            line-height: 1.2 !important;
            padding: 0 0.25rem;
        }

        .alumni-role {
            font-size: 0.7rem !important;
            margin-top: 0.125rem !important;
        }

        .connecting-line {
            height: 1rem !important;
        }

        /* Adjust Thana/Zayn spacing on mobile */
        .thana-zayn-container {
            gap: 4rem !important;
            space-x: 6rem !important;
        }

        /* Alumni grid on mobile */
        .alumni-others-grid {
            gap: 1rem !important;
            padding: 0 0.5rem;
        }

        /* Section header adjustments */
        .section-header h3 {
            font-size: 1.25rem !important;
        }

        .section-header p {
            font-size: 0.85rem !important;
        }
    }

    @media (max-width: 480px) {
        /* Extra small devices */
        .portrait-frame-container {
            width: 260px !important;
        }

        #page-title {
            font-size: 1.75rem !important;
        }

        .toggle-btn {
            padding: 0.5rem 1rem !important;
            font-size: 0.85rem !important;
        }

        .intake-header {
            font-size: 1.25rem !important;
        }

        .profile-pic-container {
            width: 130px !important;
            height: 169px !important;
        }

        .name-plaque {
            max-width: 220px !important;
        }

        .cadet-name {
            font-size: 13px !important;
        }
    }
    </style>

    <div id="page-background" class="py-4 sm:py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen transition-all duration-500">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 space-y-4 sm:space-y-6">

            <!-- Header Section -->
            <div class="text-center mb-6 sm:mb-8">
                <div id="page-icon" class="header-icon inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 gradient-green rounded-2xl shadow-lg mb-3 sm:mb-4">
                    <svg id="icon-svg" class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2 sm:mb-3 px-2" id="page-title">
                    Alumni
                </h1>
                <p class="text-base sm:text-lg text-gray-600 px-4" id="page-description">Meet our alumni and their achievements after ROTU NAVY training</p>

                <!-- Toggle Buttons -->
                <div class="flex justify-center mt-4 sm:mt-6 gap-2 sm:gap-3 px-2">
                    <button onclick="toggleView('alumni')" id="alumni-btn" class="toggle-btn px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg text-sm sm:text-base">
                        Alumni
                    </button>
                    <button onclick="toggleView('halloffame')" id="halloffame-btn" class="toggle-btn px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm sm:text-base">
                        Hall of Fame
                    </button>
                </div>
            </div>

            <!-- Alumni Content Card -->
            <div id="alumni-content" class="dashboard-card bg-white rounded-xl overflow-hidden content-transition content-visible">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-green mr-2 sm:mr-3 p-1.5 sm:p-2 rounded-md">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Success Stories</h3>
                    </div>
                    <p class="text-sm sm:text-base text-gray-600 ml-9 sm:ml-13">Our graduates making a difference in their careers and communities</p>
                </div>

                <div class="p-4 sm:p-6">
                    <!-- Alumni by Intake -->
                    @forelse($alumniByIntake as $intake => $cadets)
                    <div class="mb-6 sm:mb-8">
                        <details class="bg-gray-50 rounded-lg border border-gray-200">
                            <summary class="cursor-pointer p-3 sm:p-4 font-semibold text-base sm:text-lg text-gray-800 transition duration-200">
                                Intake - {{ $intake - 2011 }} ({{ $intake }})
                                <span class="text-xs sm:text-sm text-gray-600 ml-2">({{ $cadets->count() }} alumni)</span>
                            </summary>
                            <div class="p-4 sm:p-6">
                                <!-- Family Tree Layout -->
                                <div class="flex flex-col items-center alumni-tree-spacing space-y-3 sm:space-y-4">
                                    <!-- CO at the top -->
                                    @php
                                        $co = $cadets->firstWhere('position', 'CO');
                                    @endphp
                                    <div class="text-center">
                                        <div class="alumni-portrait w-20 h-28 sm:w-24 sm:h-32 mx-auto mb-1 bg-gray-200 rounded-lg overflow-hidden shadow-md border-2 border-gray-300">
                                            @if($co && $co->profile_pic)
                                                <img src="{{ asset('storage/' . $co->profile_pic) }}" alt="{{ $co->user->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        @if($co)
                                            <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">Lt M {{ $co->user->name }}</p>
                                            <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">PSSTLDM</p>
                                        @else
                                            <p class="alumni-name text-xs sm:text-sm text-gray-600 font-bold">Position Vacant</p>
                                        @endif
                                        <p class="alumni-role text-xs sm:text-sm text-gray-500 font-semibold mt-1">CO Intake</p>
                                    </div>

                                    <!-- Thana and Zayn side by side -->
                                    @php
                                        $thana = $cadets->firstWhere('position', 'Thana');
                                        $zayn = $cadets->firstWhere('position', 'Zayn');
                                    @endphp
                                    <div class="thana-zayn-container flex justify-center" style="gap: 6rem;">
                                        <style>
                                            @media (min-width: 640px) {
                                                .thana-zayn-container {
                                                    gap: 12rem !important;
                                                }
                                            }
                                            @media (min-width: 768px) {
                                                .thana-zayn-container {
                                                    gap: 14rem !important;
                                                }
                                            }
                                            @media (min-width: 1024px) {
                                                .thana-zayn-container {
                                                    gap: 16rem !important;
                                                }
                                            }
                                        </style>
                                        <!-- Thana position -->
                                        <div class="text-center">
                                            <div class="alumni-portrait w-20 h-28 sm:w-24 sm:h-32 mx-auto mb-1 bg-gray-200 rounded-lg overflow-hidden shadow-md border-2 border-gray-300">
                                                @if($thana && $thana->profile_pic)
                                                    <img src="{{ asset('storage/' . $thana->profile_pic) }}" alt="{{ $thana->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($thana)
                                                <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">Lt M {{ $thana->user->name }}</p>
                                                <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">PSSTLDM</p>
                                            @else
                                                <p class="alumni-name text-xs sm:text-sm text-gray-600 font-bold">Position Vacant</p>
                                            @endif
                                            <p class="alumni-role text-xs sm:text-sm text-gray-500 font-semibold mt-1">Rank Thana</p>
                                        </div>
                                        <!-- Zayn position -->
                                        <div class="text-center">
                                            <div class="alumni-portrait w-20 h-28 sm:w-24 sm:h-32 mx-auto mb-1 bg-gray-200 rounded-lg overflow-hidden shadow-md border-2 border-gray-300">
                                                @if($zayn && $zayn->profile_pic)
                                                    <img src="{{ asset('storage/' . $zayn->profile_pic) }}" alt="{{ $zayn->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($zayn)
                                                <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">Lt M {{ $zayn->user->name }}</p>
                                                <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">PSSTLDM</p>
                                            @else
                                                <p class="alumni-name text-xs sm:text-sm text-gray-600 font-bold">Position Vacant</p>
                                            @endif
                                            <p class="alumni-role text-xs sm:text-sm text-gray-500 font-semibold mt-1">Rank Zayn</p>
                                        </div>
                                    </div>

                                    <!-- Other cadets in grid -->
                                    @php
                                        $others = $cadets->filter(function($cadet) {
                                            return !in_array($cadet->position, ['CO', 'Thana', 'Zayn']);
                                        });
                                        $otherCount = $others->count();
                                        
                                        // Determine desktop grid columns based on count
                                        $desktopCols = 'lg:grid-cols-5'; // default 5 columns
                                        if ($otherCount <= 3) {
                                            $desktopCols = 'lg:grid-cols-' . $otherCount;
                                        } elseif ($otherCount == 4) {
                                            $desktopCols = 'lg:grid-cols-4';
                                        }
                                    @endphp
                                    @if($otherCount > 0)
                                    <div class="alumni-others-grid flex flex-wrap justify-center gap-4 sm:gap-6 w-full" style="max-width: calc(7 * 6rem + 6 * 1.5rem);">
                                        @foreach($others as $cadet)
                                        <div class="text-center" style="width: 6rem; flex-shrink: 0;">
                                            <div class="alumni-portrait w-20 h-28 sm:w-24 sm:h-32 mx-auto mb-2 bg-gray-200 rounded-lg overflow-hidden shadow-md border-2 border-gray-300">
                                                @if($cadet->profile_pic)
                                                    <img src="{{ asset('storage/' . $cadet->profile_pic) }}" alt="{{ $cadet->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">Lt M {{ $cadet->user->name }}</p>
                                            <p class="alumni-name text-xs sm:text-sm text-gray-700 font-bold">PSSTLDM</p>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </details>
                    </div>
                    @empty
                    <div class="text-center py-8 sm:py-12">
                        <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="mt-2 text-sm sm:text-base text-gray-500">No alumni available.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Hall of Fame Content -->
            <div id="halloffame-content" class="space-y-12 sm:space-y-16 content-transition content-hidden">
                    @forelse($hallOfFameByIntake as $intake => $cadets)
                    <div>
                        {{-- Naval Intake Header --}}
                        <div class="text-center mb-8 sm:mb-12 px-2">
                            <div class="inline-block relative">
                                {{-- Naval Rope Border Top --}}
                                <div class="flex items-center justify-center gap-2 sm:gap-3 mb-2 sm:mb-3">
                                    <div class="rope-decoration" style="width: 80px; height: 3px; background: repeating-linear-gradient(90deg, #c9b037 0px, #c9b037 10px, transparent 10px, transparent 15px); opacity: 0.8;"></div>
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8" style="fill: #c9b037; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));" viewBox="0 0 24 24">
                                        <path d="M12,2C10.89,2 10,2.9 10,4C10,4.54 10.23,5.03 10.6,5.38C9.5,6.1 9,7.41 9,8.66C9,9.66 9.27,10.66 9.82,11.54C8.71,12.32 8,13.57 8,15C8,16.11 8.45,17.11 9.18,17.83C8.45,18.55 8,19.55 8,20.66C8,21.4 8.18,22.08 8.5,22.68L10.5,21.32C10.18,20.89 10,20.39 10,19.86C10,18.76 10.89,17.86 12,17.86C13.11,17.86 14,18.76 14,19.86C14,20.39 13.82,20.89 13.5,21.32L15.5,22.68C15.82,22.08 16,21.4 16,20.66C16,19.55 15.55,18.55 14.82,17.83C15.55,17.11 16,16.11 16,15C16,13.57 15.29,12.32 14.18,11.54C14.73,10.66 15,9.66 15,8.66C15,7.41 14.5,6.1 13.4,5.38C13.77,5.03 14,4.54 14,4C14,2.9 13.11,2 12,2M12,4.86C12.41,4.86 12.75,5.2 12.75,5.61C12.75,6.03 12.41,6.36 12,6.36C11.59,6.36 11.25,6.03 11.25,5.61C11.25,5.2 11.59,4.86 12,4.86M12,9.14C12.69,9.14 13.25,9.7 13.25,10.39C13.25,11.08 12.69,11.64 12,11.64C11.31,11.64 10.75,11.08 10.75,10.39C10.75,9.7 11.31,9.14 12,9.14M12,13.93C12.83,13.93 13.5,14.6 13.5,15.43C13.5,16.26 12.83,16.93 12,16.93C11.17,16.93 10.5,16.26 10.5,15.43C10.5,14.6 11.17,13.93 12,13.93Z"/>
                                    </svg>
                                    <div class="rope-decoration" style="width: 80px; height: 3px; background: repeating-linear-gradient(90deg, #c9b037 0px, #c9b037 10px, transparent 10px, transparent 15px); opacity: 0.8;"></div>
                                </div>

                                {{-- Naval Banner --}}
                                <div class="relative inline-block px-4 py-2 sm:px-8 sm:py-3"
                                     style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #1e3a8a 100%);
                                            border: 2px sm:border-3 solid #c9b037;
                                            box-shadow:
                                                0 6px 20px rgba(0,0,0,0.6),
                                                inset 0 2px 4px rgba(255,255,255,0.2),
                                                inset 0 -2px 4px rgba(0,0,0,0.3);">

                                    {{-- Corner Decorations --}}
                                    <div class="absolute top-0 left-0 w-3 h-3 sm:w-4 sm:h-4 border-t-2 border-l-2 border-yellow-300"></div>
                                    <div class="absolute top-0 right-0 w-3 h-3 sm:w-4 sm:h-4 border-t-2 border-r-2 border-yellow-300"></div>
                                    <div class="absolute bottom-0 left-0 w-3 h-3 sm:w-4 sm:h-4 border-b-2 border-l-2 border-yellow-300"></div>
                                    <div class="absolute bottom-0 right-0 w-3 h-3 sm:w-4 sm:h-4 border-b-2 border-r-2 border-yellow-300"></div>

                                    <h3 class="intake-header text-2xl sm:text-3xl font-bold text-yellow-100 tracking-widest relative z-10"
                                        style="font-family: 'Times New Roman', serif;
                                               text-shadow: 2px 2px 4px rgba(0,0,0,0.8), 0 0 15px rgba(201,176,55,0.4);
                                               letter-spacing: 0.2em;">
                                        INTAKE {{ $intake - 2011 }} · {{ $intake }}
                                    </h3>
                                </div>

                                {{-- Naval Rope Border Bottom --}}
                                <div class="flex items-center justify-center gap-2 mt-2 sm:mt-3">
                                    <div style="width: 50px; height: 2px; background: repeating-linear-gradient(90deg, #c9b037 0px, #c9b037 8px, transparent 8px, transparent 12px); opacity: 0.7;"></div>
                                    <div style="width: 6px; height: 6px; sm:width: 8px; sm:height: 8px; background: #c9b037; border-radius: 50%; box-shadow: 0 0 8px rgba(201,176,55,0.6);"></div>
                                    <div style="width: 50px; height: 2px; background: repeating-linear-gradient(90deg, #c9b037 0px, #c9b037 8px, transparent 8px, transparent 12px); opacity: 0.7;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="hall-of-fame-grid flex flex-wrap justify-center gap-16 sm:gap-24 md:gap-32 lg:gap-40 max-w-7xl mx-auto px-2">
                            @foreach($cadets as $cadet)
                                {{-- Regal Portrait Frame --}}
                                <div class="portrait-frame-container relative group flex-shrink-0" style="perspective: 1500px; width: 320px;">
                                    {{-- Outer Gilded Frame --}}
                                    <div class="portrait-frame relative p-3 sm:p-4 rounded-lg shadow-2xl"
                                         style="background: linear-gradient(145deg, #b8860b 0%, #daa520 25%, #8b6914 50%, #daa520 75%, #b8860b 100%);
                                                box-shadow:
                                                    inset 0 0 30px rgba(0,0,0,0.5),
                                                    inset 0 4px 10px rgba(255,215,0,0.3),
                                                    inset 0 -4px 10px rgba(0,0,0,0.4),
                                                    0 15px 45px rgba(0,0,0,0.7),
                                                    0 0 0 3px #5d4037,
                                                    0 0 0 10px #b8860b,
                                                    0 0 0 12px #3e2723,
                                                    0 0 20px rgba(212,175,55,0.4);
                                                border: 2px solid #d4af37;">

                                        {{-- Ornate Corners --}}
                                        <div class="absolute top-1 left-1 w-5 h-5 sm:w-6 sm:h-6 border-t-3 border-l-3 border-yellow-400 opacity-70"></div>
                                        <div class="absolute top-1 right-1 w-5 h-5 sm:w-6 sm:h-6 border-t-3 border-r-3 border-yellow-400 opacity-70"></div>
                                        <div class="absolute bottom-1 left-1 w-5 h-5 sm:w-6 sm:h-6 border-b-3 border-l-3 border-yellow-400 opacity-70"></div>
                                        <div class="absolute bottom-1 right-1 w-5 h-5 sm:w-6 sm:h-6 border-b-3 border-r-3 border-yellow-400 opacity-70"></div>

                                        {{-- Middle Mahogany Frame --}}
                                        <div class="relative p-2 sm:p-3 rounded"
                                             style="background: linear-gradient(145deg, #4e342e 0%, #5d4037 50%, #3e2723 100%);
                                                    box-shadow: inset 0 0 20px rgba(0,0,0,0.6), 0 4px 8px rgba(0,0,0,0.5);">

                                            {{-- Inner Velvet Mat --}}
                                            <div class="relative border-2 sm:border-3 rounded"
                                                 style="border-color: #8b4513;
                                                        background: linear-gradient(to bottom, #2c1810 0%, #1a0f0a 100%);
                                                        box-shadow: inset 0 0 30px rgba(0,0,0,0.8), inset 0 4px 6px rgba(0,0,0,0.6);">

                                                {{-- Canvas Background --}}
                                                <div class="p-3 sm:p-4" style="background: linear-gradient(135deg, #faf8f3 0%, #f5f1e8 50%, #ebe6d9 100%);">

                                                    {{-- Award Ribbon Banner at Top --}}
                                                    @if($cadet->is_best_cadet)
                                                        <div class="mb-2 sm:mb-3">
                                                            <div class="award-ribbon px-3 py-1 sm:px-4 sm:py-1.5 rounded"
                                                                 style="background: linear-gradient(135deg, #c9b037 0%, #f4d03f 50%, #c9b037 100%);
                                                                        box-shadow:
                                                                            0 4px 15px rgba(201,176,55,0.5),
                                                                            inset 0 2px 4px rgba(255,255,255,0.4),
                                                                            inset 0 -2px 4px rgba(0,0,0,0.2);
                                                                        border: 2px solid #8b6914;">
                                                                <p class="text-xs font-black tracking-widest text-center"
                                                                   style="font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
                                                                          color: #2c1810;
                                                                          text-shadow: 1px 1px 2px rgba(255,255,255,0.4), 0 0 8px rgba(255,215,0,0.3);
                                                                          letter-spacing: 0.15em;">
                                                                    BEST CADET
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($cadet->is_best_academic)
                                                        <div class="mb-2 sm:mb-3">
                                                            <div class="award-ribbon px-3 py-1 sm:px-4 sm:py-1.5 rounded"
                                                                 style="background: linear-gradient(135deg, #c9b037 0%, #f4d03f 50%, #c9b037 100%);
                                                                        box-shadow:
                                                                            0 4px 15px rgba(201,176,55,0.5),
                                                                            inset 0 2px 4px rgba(255,255,255,0.4),
                                                                            inset 0 -2px 4px rgba(0,0,0,0.2);
                                                                        border: 2px solid #8b6914;">
                                                                <p class="text-xs font-black tracking-widest text-center"
                                                                   style="font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
                                                                          color: #2c1810;
                                                                          text-shadow: 1px 1px 2px rgba(255,255,255,0.4), 0 0 8px rgba(255,215,0,0.3);
                                                                          letter-spacing: 0.15em;">
                                                                    BEST ACADEMIC
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Profile Picture with Ornate Border --}}
                                                    <div class="relative mb-2 sm:mb-3">
                                                        {{-- Decorative outer glow --}}
                                                        <div class="absolute -inset-1 sm:-inset-1.5 rounded-lg"
                                                             style="background: linear-gradient(135deg, rgba(212,175,55,0.3), rgba(184,134,11,0.3));
                                                                    filter: blur(6px);"></div>

                                                        <div class="profile-pic-container relative mx-auto rounded overflow-hidden shadow-2xl"
                                                             style="width: 160px; height: 208px; border: 3px sm:border-4 solid;
                                                                    border-image: linear-gradient(135deg, #d4af37 0%, #f9d84b 50%, #d4af37 100%) 1;
                                                                    box-shadow:
                                                                        0 6px 16px rgba(0,0,0,0.5),
                                                                        inset 0 0 30px rgba(212,175,55,0.15),
                                                                        0 0 20px rgba(212,175,55,0.2);">
                                                            @if($cadet->profile_pic)
                                                                <img src="{{ asset('storage/' . $cadet->profile_pic) }}"
                                                                     alt="{{ $cadet->user->name }}"
                                                                     class="w-full h-full object-cover"
                                                                     style="filter: sepia(5%) contrast(108%) brightness(102%);">
                                                            @else
                                                                <div class="w-full h-full flex items-center justify-center"
                                                                     style="background: linear-gradient(135deg, #f5f1e8, #ebe6d9);">
                                                                    <svg class="w-12 h-12 sm:w-16 sm:h-16 text-amber-800 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- Name and Service Number --}}
                                                    <div class="text-center space-y-1 sm:space-y-1.5">
                                                        {{-- Decorative ribbon --}}
                                                        <div class="flex items-center justify-center gap-1 sm:gap-1.5 mb-1 sm:mb-1.5">
                                                            <div style="width: 15px; sm:width: 20px; height: 1px; background: linear-gradient(to right, transparent, #8b6914);"></div>
                                                            <div style="width: 2.5px; height: 2.5px; sm:width: 3px; sm:height: 3px; background: #d4af37; border-radius: 50%;"></div>
                                                            <div style="width: 15px; sm:width: 20px; height: 1px; background: linear-gradient(to left, transparent, #8b6914);"></div>
                                                        </div>

                                                        {{-- Name Plaque --}}
                                                        <div class="name-plaque inline-block px-3 py-1.5 sm:px-4 sm:py-2 rounded-sm relative"
                                                             style="background: linear-gradient(to bottom, #d4af37 0%, #f9d84b 50%, #d4af37 100%);
                                                                    box-shadow:
                                                                        inset 0 2px 4px rgba(255,255,255,0.4),
                                                                        inset 0 -2px 4px rgba(0,0,0,0.3),
                                                                        0 3px 10px rgba(0,0,0,0.5);
                                                                    border: 2px solid #b8860b;
                                                                    max-width: 260px;">
                                                            <h4 class="cadet-name font-bold tracking-wide"
                                                                data-name="Lt M {{ strtoupper($cadet->user->name) }} PSSTLDM"
                                                                style="font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
                                                                       color: #3e2723;
                                                                       text-shadow:
                                                                           1px 1px 2px rgba(255,255,255,0.5),
                                                                           0 0 10px rgba(255,215,0,0.3);
                                                                       letter-spacing: 0.05em;
                                                                       line-height: 1.3;
                                                                       font-size: 16px;">
                                                                Lt M {{ strtoupper($cadet->user->name) }} PSSTLDM
                                                            </h4>
                                                        </div>

                                                        {{-- Service Number --}}
                                                        <div class="mt-1 sm:mt-1.5">
                                                            <p class="text-xs font-semibold tracking-wide"
                                                               style="font-family: 'Times New Roman', serif;
                                                                      color: #5d4037;
                                                                      letter-spacing: 0.1em;">
                                                                Service No: {{ $cadet->service_number }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Gilded Frame Shine Effect --}}
                                        <div class="absolute inset-0 rounded-lg pointer-events-none"
                                             style="background: linear-gradient(135deg, rgba(255,255,255,0.3) 0%, transparent 30%, transparent 70%, rgba(0,0,0,0.2) 100%);"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 sm:py-12">
                        <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <p class="mt-2 text-sm sm:text-base text-gray-500 font-semibold">No Hall of Fame members yet.</p>
                        <p class="text-xs sm:text-sm text-gray-400">Best Cadets and Best Academics will appear here.</p>
                    </div>
                    @endforelse
                </div>
            </div>
            {{-- Mobile Bottom Spacer --}}
            <div class="block md:hidden h-20"></div>
        </div>
    </div>

    <script>
        // Function to adjust name font size to fit in 2 lines
        function adjustNameFontSize() {
            const nameElements = document.querySelectorAll('.cadet-name');

            nameElements.forEach(nameEl => {
                const text = nameEl.getAttribute('data-name') || nameEl.textContent;
                const textLength = text.length;

                // Get viewport width for mobile adjustments
                const isMobile = window.innerWidth < 768;
                const isExtraSmall = window.innerWidth < 480;

                // Calculate font size based on text length and viewport
                let fontSize;
                if (isExtraSmall) {
                    if (textLength <= 25) fontSize = 13;
                    else if (textLength <= 30) fontSize = 12;
                    else if (textLength <= 35) fontSize = 11;
                    else if (textLength <= 40) fontSize = 10;
                    else fontSize = 9;
                } else if (isMobile) {
                    if (textLength <= 25) fontSize = 14;
                    else if (textLength <= 30) fontSize = 13;
                    else if (textLength <= 35) fontSize = 12;
                    else if (textLength <= 40) fontSize = 11;
                    else fontSize = 10;
                } else {
                    if (textLength <= 25) fontSize = 16;
                    else if (textLength <= 30) fontSize = 15;
                    else if (textLength <= 35) fontSize = 14;
                    else if (textLength <= 40) fontSize = 13;
                    else if (textLength <= 45) fontSize = 12;
                    else fontSize = 11;
                }

                nameEl.style.fontSize = fontSize + 'px';

                // Check if it exceeds 2 lines and adjust further if needed
                setTimeout(() => {
                    const lineHeight = parseFloat(getComputedStyle(nameEl).lineHeight);
                    const actualHeight = nameEl.scrollHeight;
                    const maxHeight = lineHeight * 2.1;

                    if (actualHeight > maxHeight && fontSize > (isExtraSmall ? 8 : 10)) {
                        nameEl.style.fontSize = (fontSize - 1) + 'px';
                    }
                }, 10);
            });
        }

        // Run on page load, after view toggle, and on resize
        document.addEventListener('DOMContentLoaded', adjustNameFontSize);
        window.addEventListener('resize', adjustNameFontSize);

        function toggleView(view) {
            const alumniBtn = document.getElementById('alumni-btn');
            const halloffameBtn = document.getElementById('halloffame-btn');
            const alumniContent = document.getElementById('alumni-content');
            const halloffameContent = document.getElementById('halloffame-content');
            const pageTitle = document.getElementById('page-title');
            const pageDescription = document.getElementById('page-description');
            const pageIcon = document.getElementById('page-icon');
            const iconSvg = document.getElementById('icon-svg');
            const pageBackground = document.getElementById('page-background');
            const mainContent = document.querySelector('main');
            const headerElement = document.querySelector('header');
            const legacyGalleryHeader = document.getElementById('legacy-gallery-header');

            if (view === 'alumni') {
                // Update buttons
                alumniBtn.className = 'toggle-btn px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg text-sm sm:text-base';
                halloffameBtn.className = 'toggle-btn px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm sm:text-base';

                // Update content with smooth transitions
                halloffameContent.classList.remove('content-visible');
                halloffameContent.classList.add('content-hidden');

                setTimeout(() => {
                    alumniContent.classList.remove('content-hidden');
                    alumniContent.classList.add('content-visible');
                }, 50);

                // Update title
                pageTitle.textContent = 'Alumni';
                pageDescription.textContent = 'Meet our alumni and their achievements after ROTU NAVY training';

                // Reset title styles for Alumni
                pageTitle.style.color = '';
                pageTitle.style.textShadow = '';
                pageTitle.style.fontFamily = '';
                pageDescription.style.color = '';

                // Update background to light gray
                pageBackground.style.background = 'linear-gradient(to bottom right, rgb(249, 250, 251), rgb(229, 231, 235))';

                // Reset main content and header background
                if (mainContent) {
                    mainContent.style.background = '';
                }
                if (headerElement) {
                    headerElement.style.background = '';
                    headerElement.style.boxShadow = '';
                }

                // Reset Legacy Gallery header to black
                if (legacyGalleryHeader) {
                    legacyGalleryHeader.style.color = '#1f2937';
                }

                // Update icon to book
                pageIcon.className = 'header-icon inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 gradient-green rounded-2xl shadow-lg mb-3 sm:mb-4';
                iconSvg.setAttribute('fill', 'none');
                iconSvg.setAttribute('stroke', 'currentColor');
                iconSvg.setAttribute('viewBox', '0 0 24 24');
                iconSvg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>';
            } else if (view === 'halloffame') {
                // Update buttons
                halloffameBtn.className = 'toggle-btn px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white shadow-lg text-sm sm:text-base';
                alumniBtn.className = 'toggle-btn px-5 py-2.5 sm:px-6 sm:py-3 rounded-lg font-semibold transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300 text-sm sm:text-base';

                // Update content with smooth transitions
                alumniContent.classList.remove('content-visible');
                alumniContent.classList.add('content-hidden');

                setTimeout(() => {
                    halloffameContent.classList.remove('content-hidden');
                    halloffameContent.classList.add('content-visible');
                    // Adjust font sizes after content is visible
                    setTimeout(adjustNameFontSize, 100);
                }, 50);

                // Update title
                pageTitle.textContent = 'Hall of Fame';
                pageDescription.textContent = 'Honoring Excellence Across Generations';

                // Update background to dark color matching side nav
                pageBackground.style.background = '#2e313c';

                // Update main content and header background
                if (mainContent) {
                    mainContent.style.background = '#2e313c';
                }
                if (headerElement) {
                    headerElement.style.background = '#25272f';
                    headerElement.style.boxShadow = '0 2px 4px 0 rgba(0, 0, 0, 0.4)';
                }

                // Update Legacy Gallery header to golden
                if (legacyGalleryHeader) {
                    legacyGalleryHeader.style.color = '#d4af37';
                }

                // Update text colors for Hall of Fame
                pageTitle.style.color = '#fef3c7';
                pageTitle.style.textShadow = '2px 2px 4px rgba(0,0,0,0.5)';
                pageTitle.style.fontFamily = 'Georgia, serif';
                pageDescription.style.color = '#fde68a';

                // Update icon to trophy/star
                pageIcon.className = 'header-icon inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-2xl shadow-lg mb-3 sm:mb-4';
                iconSvg.setAttribute('fill', 'currentColor');
                iconSvg.removeAttribute('stroke');
                iconSvg.setAttribute('viewBox', '0 0 20 20');
                iconSvg.innerHTML = '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>';
            }
        }
    </script>
</x-app-layout>