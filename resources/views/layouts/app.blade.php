<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ROTU NAVY UMS - Reserve Officer Training Unit') }}</title>

        {{-- ================================================================ --}}
        {{-- FONTS AND ASSETS --}}
        {{-- ================================================================ --}}
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @if(file_exists(public_path('build/manifest.json')))
            {{-- Production: Use built assets --}}
            @php
                $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
            @endphp
            <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
            <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>
        @else
            {{-- Development: Use Vite dev server --}}
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
        @stack('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        {{-- ================================================================ --}}
        {{-- CUSTOM STYLES --}}
        {{-- ================================================================ --}}
        <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar:horizontal {
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: white;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3c92d9, #2980b9);
            border-radius: 4px;
        }

        /* Sidebar scrollbar track */
        aside::-webkit-scrollbar-track,
        aside nav::-webkit-scrollbar-track {
            background: #2e313c !important;
        }
            [x-cloak] {
                display: none !important;
            }

            :root {
                --gradient-primary: linear-gradient(135deg, #3c92d9, #3c92d9);
                --shadow-primary: 0 10px 30px rgba(60, 146, 217, 0.3);
            }

            .btn-primary {
                background: var(--gradient-primary) !important;
                padding: 12px 28px;
                border: none;
                border-radius: 8px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                color: white !important;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.95rem;
                box-shadow: var(--shadow-primary);
                position: relative;
                overflow: visible;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(60, 146, 217, 0.4);
                background: #3c92d9 !important;
            }

            .btn-primary::after {
                display: none !important;
            }

            .notification-badge {
                position: absolute;
                top: -4px;
                right: -4px;
                width: 14px;
                height: 14px;
                background-color: #ef4444;
                border: 2px #ef4444;
                border-radius: 50%;
                z-index: 999;
                box-shadow: 0 2px 4px rgba(0,0,0,0.3);
            }

            .mobile-menu-notification {
                position: absolute;
                top: -2px;
                right: -2px;
                width: 12px;
                height: 12px;
                background-color: #ef4444;
                border: 1px solid white;
                border-radius: 50%;
                z-index: 999;
                box-shadow: 0 1px 3px rgba(0,0,0,0.3);
            }

            /* ========================================= */
            /* MOBILE RESPONSIVE OPTIMIZATIONS */
            /* ========================================= */
            @media (max-width: 640px) {
                /* Prevent horizontal scroll */
                body {
                    overflow-x: hidden;
                }

                /* Main content wrapper - add bottom padding to prevent cutoff */
                main {
                    padding-bottom: 3rem !important;
                }

                /* Optimize card spacing for mobile */
                .dashboard-card {
                    margin-bottom: 1rem;
                }

                /* Reduce section header padding */
                .section-header {
                    padding: 1.25rem 1rem !important;
                }

                /* Optimize table for mobile - make scrollable */
                .data-table {
                    font-size: 0.875rem;
                }

                .data-table th,
                .data-table td {
                    padding: 0.75rem 0.5rem !important;
                    white-space: nowrap;
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

                /* Keep sidebar section headers small on mobile */
                nav h3.text-xs,
                .text-xs.font-semibold.text-gray-400.uppercase,
                h3.text-xs.font-semibold {
                    font-size: 0.625rem !important;
                    line-height: 0.875rem !important;
                    letter-spacing: 0.05em !important;
                }

                /* Reduce button padding and ensure proper layout */
                .btn-primary {
                    padding: 10px 20px !important;
                    font-size: 0.875rem !important;
                    display: flex !important;
                    flex-direction: row !important;
                    align-items: center !important;
                    justify-content: center !important;
                    white-space: nowrap !important;
                }

                /* Optimize info cards */
                .info-card {
                    padding: 1rem !important;
                }

                /* Grid optimizations */
                .info-grid {
                    grid-template-columns: 1fr !important;
                }

                /* ========================================= */
                /* MODAL MOBILE OPTIMIZATION */
                /* ========================================= */

                /* Modal overlays - only style, don't force display */
                .fixed.inset-0.bg-black.bg-opacity-50,
                .fixed.inset-0.bg-gray-600.bg-opacity-50,
                .fixed.inset-0[style*="background"]:not([style*="display: none"]) {
                    overflow-y: auto !important;
                    padding: 1rem !important;
                }

                /* Center modal content when visible (not forcing display) */
                .fixed.inset-0:not([style*="display: none"]) {
                    align-items: center !important;
                    justify-content: center !important;
                }

                /* Modal containers */
                .modal-content,
                .fixed.inset-0 > div:not(.fixed),
                .bg-white.rounded-lg.shadow-xl,
                .relative.bg-white.rounded-lg {
                    margin: 1rem auto !important;
                    max-width: calc(100vw - 2rem) !important;
                    padding: 1rem !important;
                    width: 100% !important;
                }

                /* Modal headers */
                .modal-content h2,
                .modal-content h3,
                .bg-white.rounded-lg h2,
                .bg-white.rounded-lg h3 {
                    font-size: 1.125rem !important;
                    margin-bottom: 0.75rem !important;
                }

                /* Modal close button (X) */
                .modal-content button[type="button"]:first-child,
                .absolute.top-4.right-4,
                button.absolute {
                    position: absolute !important;
                    top: 0.75rem !important;
                    right: 0.75rem !important;
                    padding: 0.5rem !important;
                    width: 2rem !important;
                    height: 2rem !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    border-radius: 0.375rem !important;
                    background: #f3f4f6 !important;
                    z-index: 10 !important;
                }

                .modal-content button[type="button"]:first-child:hover,
                button.absolute:hover {
                    background: #e5e7eb !important;
                }

                .modal-content button[type="button"]:first-child svg,
                button.absolute svg {
                    width: 1.25rem !important;
                    height: 1.25rem !important;
                }

                /* Modal buttons - ensure they fit */
                .modal-content button:not(.absolute),
                .modal-content .btn-primary,
                .modal-content .btn-secondary {
                    font-size: 0.875rem !important;
                    padding: 0.5rem 1rem !important;
                }

                /* Modal action buttons container */
                .modal-content .flex.justify-end,
                .modal-content .flex.space-x-3,
                .bg-white.rounded-lg .flex.justify-end {
                    flex-direction: column !important;
                    gap: 0.5rem !important;
                }

                .modal-content .flex.justify-end button,
                .modal-content .flex.space-x-3 button {
                    width: 100% !important;
                }

                /* Modal forms */
                .modal-content input,
                .modal-content select,
                .modal-content textarea {
                    font-size: 0.875rem !important;
                    width: 100% !important;
                }

                .modal-content label {
                    font-size: 0.875rem !important;
                }

                /* Prevent text overflow */
                h1 {
                    font-size: 1.875rem !important;
                    line-height: 2.25rem !important;
                }

                h2 {
                    font-size: 1.5rem !important;
                    line-height: 2rem !important;
                }

                h3 {
                    font-size: 1.25rem !important;
                    line-height: 1.75rem !important;
                }

                /* Countdown circle - smaller for mobile */
                .countdown-circle {
                    width: 10rem !important;
                    height: 10rem !important;
                }

                .countdown-inner {
                    width: 8.5rem !important;
                    height: 8.5rem !important;
                }

                /* Accordion optimization */
                .accordion-header {
                    padding: 0.875rem 1rem !important;
                    font-size: 0.875rem !important;
                }

                /* Progress container */
                .progress-container {
                    height: 1.5rem !important;
                }

                /* Badge icons */
                .badge-icon-mini {
                    width: 24px !important;
                    height: 24px !important;
                }

                .badge-icon-large {
                    width: 40px !important;
                    height: 40px !important;
                }

                /* Ranking items */
                .ranking-item {
                    gap: 0.5rem !important;
                    padding: 0.625rem !important;
                }

                .rank-badge {
                    width: 2rem !important;
                    height: 2rem !important;
                    font-size: 0.75rem !important;
                }
            }

            /* Extra small devices (Honor X9a in portrait - 360px width) */
            @media (max-width: 400px) {
                .data-table {
                    font-size: 0.8125rem;
                }

                .data-table th,
                .data-table td {
                    padding: 0.5rem 0.375rem !important;
                }

                h1 {
                    font-size: 1.5rem !important;
                    line-height: 2rem !important;
                }

                /* Keep sidebar section headers small */
                nav h3.text-xs,
                .text-xs.font-semibold.text-gray-400.uppercase,
                h3.text-xs.font-semibold {
                    font-size: 0.625rem !important;
                    line-height: 0.875rem !important;
                    letter-spacing: 0.05em !important;
                }

                .section-header {
                    padding: 1rem 0.75rem !important;
                }

                .modal-content {
                    margin: 0.5rem !important;
                    max-width: calc(100vw - 1rem) !important;
                    padding: 1rem !important;
                }
            }

            /* ========================================= */
            /* INSTRUCTOR-SPECIFIC MOBILE OPTIMIZATIONS */
            /* ========================================= */
            @media (max-width: 640px) {
                /* Duty ranking and CGPA content areas */
                #duty-ranking-content,
                #cgpa-content {
                    max-height: 250px !important;
                }

                /* Dropdown sections for cadet management */
                .section-content-dropdown {
                    padding: 1rem !important;
                }

                /* Filter forms - stack inputs vertically */
                .filter-form select,
                .filter-form input {
                    width: 100% !important;
                }

                /* Cadet cards - full width on mobile */
                .cadet-card {
                    width: 100% !important;
                }

                /* Badge display optimizations */
                .badge-display {
                    gap: 0.375rem !important;
                }

                /* Profile pictures - responsive sizing */
                .profile-pic-instructor {
                    width: 8rem !important;
                    height: 11rem !important;
                }

                /* Info items - reduce padding */
                .info-item {
                    padding: 0.5rem !important;
                    font-size: 0.875rem !important;
                }

                .info-item svg {
                    width: 1rem !important;
                    height: 1rem !important;
                }

                /* Filter buttons - stack on mobile */
                .filter-buttons {
                    flex-direction: column !important;
                    gap: 0.5rem !important;
                }

                .filter-buttons button,
                .filter-buttons select {
                    width: 100% !important;
                }

                /* Action buttons in tables */
                .action-buttons {
                    flex-direction: column !important;
                    gap: 0.25rem !important;
                }

                .action-buttons button {
                    width: 100% !important;
                    font-size: 0.75rem !important;
                    padding: 0.375rem 0.75rem !important;
                }

                /* Stats cards */
                .stats-card {
                    padding: 1rem !important;
                }

                .stats-card h3 {
                    font-size: 1.125rem !important;
                }

                .stats-card .stat-value {
                    font-size: 1.5rem !important;
                }

                /* Calendar view on training page */
                .fc-toolbar {
                    flex-direction: column !important;
                    gap: 0.5rem !important;
                }

                .fc-toolbar-chunk {
                    display: flex !important;
                    justify-content: center !important;
                    width: 100% !important;
                }

                .fc-button {
                    font-size: 0.75rem !important;
                    padding: 0.375rem 0.625rem !important;
                }

                /* Pending verification steps */
                .verification-step {
                    padding: 0.75rem !important;
                }

                /* Gallery grid */
                .gallery-grid {
                    grid-template-columns: repeat(2, 1fr) !important;
                    gap: 0.5rem !important;
                }

                /* Form groups in instructor pages */
                .form-group {
                    margin-bottom: 0.75rem !important;
                }

                .form-group label {
                    font-size: 0.875rem !important;
                    margin-bottom: 0.25rem !important;
                }

                .form-group input,
                .form-group select,
                .form-group textarea {
                    font-size: 0.875rem !important;
                    padding: 0.5rem !important;
                }

                /* Bulk action controls */
                .bulk-actions {
                    flex-direction: column !important;
                    gap: 0.5rem !important;
                }

                .bulk-actions > * {
                    width: 100% !important;
                }
            }

            @media (max-width: 400px) {
                /* Extra compact for very small screens */
                #duty-ranking-content,
                #cgpa-content {
                    max-height: 200px !important;
                }

                .profile-pic-instructor {
                    width: 7rem !important;
                    height: 9.5rem !important;
                }

                .gallery-grid {
                    grid-template-columns: 1fr !important;
                }

                .fc-button {
                    font-size: 0.625rem !important;
                    padding: 0.25rem 0.5rem !important;
                }

                .stats-card .stat-value {
                    font-size: 1.25rem !important;
                }
            }
        </style>
    </head>
    
    <body class="font-sans antialiased overflow-hidden" style="background: #f5f5f5">
        {{-- ================================================================ --}}
        {{-- USER DATA AND NOTIFICATIONS SETUP --}}
        {{-- ================================================================ --}}
        @php
            $user = Auth::user();
            $profilePicture = null;
            $hasNotifications = false;

            if ($user->role === 'instructor') {
                $instructor = App\Models\Instructor::where('user_id', $user->id)->first();
                $profilePicture = $instructor?->profile_pic;

                $pendingUsersCount = App\Models\User::where('status', 'pending')->count();
                $applicationsCount = App\Models\Application::count();
                $hasNotifications = $pendingUsersCount > 0 || $applicationsCount > 0;

            } elseif ($user->role === 'cadet') {
                $layoutCadet = App\Models\Cadet::where('user_id', $user->id)->first();
                $profilePicture = $layoutCadet?->profile_pic;

                $hasNotifications = false;

                if ($layoutCadet) {
                    // Check for pending absences that need reasoning (completed trainings)
                    $pendingAbsences = DB::table('training_attendances')
                        ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
                        ->where('training_attendances.cadet_id', $layoutCadet->id)
                        ->where('training_attendances.present', false)
                        ->where('trainings.status', 'Completed')
                        ->where(function($q) {
                            $q->whereNull('training_attendances.absence_reason')
                              ->orWhereNull('training_attendances.file_url')
                              ->orWhere('training_attendances.absence_reason', '')
                              ->orWhere('training_attendances.file_url', '');
                        })
                        ->exists();

                    // Check for ongoing/recent trainings that need attendance marking
                    $intakeNumber = $layoutCadet->intake_year - 2011;
                    $intakeStr = "Intake - " . $intakeNumber;
                    $now = now();
                    $today = $now->toDateString();
                    $yesterday = $now->copy()->subDay()->toDateString();

                    // Check for active trainings where attendance hasn't been marked yet
                    $activeTrainingsNeedingAttendance = DB::table('trainings')
                        ->leftJoin('training_attendances', function($join) use ($layoutCadet) {
                            $join->on('trainings.id', '=', 'training_attendances.training_id')
                                 ->where('training_attendances.cadet_id', '=', $layoutCadet->id);
                        })
                        ->where(function ($query) use ($intakeStr) {
                            $query->where('trainings.involvement', 'LIKE', "%{$intakeStr}%")
                                ->orWhereNull('trainings.involvement')
                                ->orWhere('trainings.involvement', '');
                        })
                        ->where(function ($q) use ($today, $yesterday, $now) {
                            $q->where(function ($subQ) use ($today) {
                                $subQ->whereDate('trainings.start_datetime', $today);
                            })
                            ->orWhere(function ($subQ) use ($yesterday) {
                                $subQ->whereDate('trainings.start_datetime', $yesterday);
                            })
                            ->orWhere(function ($subQ) use ($now) {
                                $subQ->where('trainings.start_datetime', '<', $now->copy()->startOfDay())
                                    ->where(function ($endQ) use ($now) {
                                        $endQ->whereNull('trainings.end_datetime')
                                            ->orWhere('trainings.end_datetime', '>=', $now->copy()->startOfDay());
                                    });
                            });
                        })
                        ->where(function($q) {
                            // Either no attendance record exists, or attendance is marked as absent without reason
                            $q->whereNull('training_attendances.id')
                              ->orWhere(function($subQ) {
                                  $subQ->where('training_attendances.present', false)
                                       ->whereNull('training_attendances.absence_reason');
                              })
                              ->orWhere('training_attendances.present', false);
                        })
                        ->exists();

                    $hasNotifications = $pendingAbsences || $activeTrainingsNeedingAttendance;
                }
            }

            $nameParts = explode(' ', trim($user->name));
            $initials = '';
            foreach ($nameParts as $part) {
                if (!empty($part)) {
                    $initials .= strtoupper(substr($part, 0, 1));
                }
            }
            $initials = substr($initials, 0, 2);

            $avatarSrc = $profilePicture ? asset('storage/' . $profilePicture) : null;
        @endphp
        
        {{-- ================================================================ --}}
        {{-- MAIN LAYOUT WRAPPER --}}
        {{-- ================================================================ --}}
        <div x-data="{ sidebarOpen: false, showLogoutModal: false, currentLogoutForm: null }">
            {{-- ================================================================ --}}
            {{-- LOGOUT CONFIRMATION MODAL --}}
            {{-- ================================================================ --}}
            <div x-show="showLogoutModal" 
                 x-cloak
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showLogoutModal = false">
                
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 relative z-[10000]"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-90"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-90"
                     @click.stop>
                    
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0">
                                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Confirm Logout</h3>
                                <p class="text-sm text-gray-500">Are you sure you want to log out? You will need to sign in again to access your account.</p>
                            </div>
                        </div>
                        
                        <div class="flex flex-row justify-end gap-2 sm:gap-3 mt-6">
                            <button @click="showLogoutModal = false"
                                    class="flex-1 sm:flex-none px-4 sm:px-6 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Cancel
                            </button>
                            <button @click="if(currentLogoutForm) { currentLogoutForm.submit(); }"
                                    class="flex-1 sm:flex-none px-4 sm:px-6 py-3 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Yes, Log Out
                            </button>
                        </div>
                    </div>
                </div>
            </div>

                {{-- ================================================================ --}}
                {{-- MOBILE LAYOUT --}}
                {{-- ================================================================ --}}
                <div x-data="{ sidebarOpen: false }" class="min-h-screen">
                <div class="sm:hidden fixed top-4 right-4 z-50">
                    <button @click="sidebarOpen = !sidebarOpen" class="bg-white p-2 rounded-md shadow-md relative">
                        @if($hasNotifications)
                            <div class="mobile-menu-notification"></div>
                        @endif
                        <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                {{-- ================================================================ --}}
                {{-- MOBILE SIDEBAR (COLLAPSIBLE) --}}
                {{-- ================================================================ --}}
                <aside
                    x-show="sidebarOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-full"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-full"
                    class="fixed top-0 right-0 w-[85vw] max-w-sm h-full bg-[#2e313c] shadow-2xl flex flex-col justify-between z-50 border-l border-[#373a46] sm:hidden text-white overflow-y-auto"
                >
                    <div class="flex flex-col h-full px-4 pb-4">
                        <div class="flex justify-end pt-2 pb-2">
                            <button @click="sidebarOpen = false" class="text-white hover:text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- MOBILE PROFILE SECTION --}}
                        {{-- ================================================================ --}}
                        <x-dropdown align="right" width="full" contentClasses="py-1 bg-white text-black border border-gray-300">
                            <x-slot name="trigger">
                                <div class="flex items-center gap-2 border-b border-[#373a46] pb-3 mb-3 cursor-pointer hover:bg-[#373a46] transition-colors rounded-lg px-2 py-2 w-full">
                                    @if($avatarSrc)
                                        <img src="{{ $avatarSrc }}"
                                             alt="Profile"
                                             class="w-10 h-10 rounded-full object-cover flex-shrink-0"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0" style="display: none;">
                                            {{ $initials }}
                                        </div>
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                                            {{ $initials }}
                                        </div>
                                    @endif
                                    <div class="flex flex-col flex-1 min-w-0 overflow-hidden">
                                        <div class="font-semibold text-sm leading-tight truncate text-white">{{ Auth::user()->name }}</div>
                                        <div class="text-xs text-gray-400 leading-tight truncate">{{ Auth::user()->email }}</div>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link href="{{ route('profile.edit') }}" class="flex items-center text-black hover:bg-gray-100 transition-colors px-4 py-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Edit Profile
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                        
                        {{-- ================================================================ --}}
                        {{-- MOBILE NAVIGATION LINKS --}}
                        {{-- ================================================================ --}}
                        <nav class="flex flex-col space-y-1 flex-1 overflow-y-auto">
                            <a href="{{ route('dashboard') }}"
                            class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ (Auth::user()->role === 'instructor' && request()->routeIs('instructor.dashboard')) || (Auth::user()->role === 'cadet' && request()->routeIs('cadet.dashboard')) ? 'bg-[#3c92d9] bg-opacity-20 text-[#3c92d9] border-l-4 border-[#3c92d9]' : 'text-white hover:bg-[#373a46]' }}">
                                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                <span class="truncate">Dashboard</span>
                            </a>

                            @if(isset($instructor) && $instructor && $instructor->expertise === 'Admin')
                                <div x-data="{ open: false }" class="mt-4">
                                    <button @click="open = !open" class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9] focus:outline-none focus:ring-2 focus:ring-[#3c92d9] transition-colors">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                        </svg>
                                        Admin Management
                                        <svg :class="{'transform rotate-180': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="mt-2 space-y-1 pl-8">
                                        <a href="{{ route('admin.user_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                            User Management
                                        </a>
                                        <a href="{{ route('admin.data_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                            Data Management
                                        </a>
                                        <a href="{{ route('admin.gamification_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                            Gamification Management
                                        </a>
                                        <a href="{{ route('admin.access_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                            Access Management
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-6">
                                <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                                    @if(Auth::user()->role === 'instructor')
                                        Management
                                    @else
                                        Features
                                    @endif
                                </h3>
                                <div class="space-y-1">
                                    @if(Auth::user()->role === 'instructor')
                                        <a href="{{ route('instructor.cadet_management') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/cadet*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            Cadet Administration
                                        </a>

                                        <a href="{{ route('instructor.training') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/training*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                            Training
                                        </a>

                                        <a href="{{ route('instructor.allowance') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('instructor.allowance*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            Allowance
                                        </a>

                                        <a href="{{ route('instructor.inventory') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('instructor.inventory*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            Inventory
                                        </a>

                                        <a href="{{ route('instructor.learning_hub') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('instructor.learning*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Learning Hub
                                        </a>

                                        <a href="{{ route('instructor.gallery') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('instructor.gallery*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Gallery
                                        </a>
                                    @elseif(Auth::user()->role === 'cadet')
                                        <a href="{{ route('cadet.training') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('cadet.training*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                            </svg>
                                            Training
                                        </a>

                                        <a href="{{ route('cadet.allowance') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('cadet.allowance*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            Allowance Estimation
                                        </a>

                                        <a href="{{ route('cadet.inventory') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('cadet.inventory*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            Inventory
                                        </a>

                                        <a href="{{ route('cadet.learning_hub') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('cadet.learning*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Learning Hub
                                        </a>

                                        <a href="{{ route('cadet.performance') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('cadet.performance*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            Performance
                                        </a>

                                        <a href="{{ route('cadet.gallery') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('cadet.gallery*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Gallery
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </nav>
                        
                        {{-- ================================================================ --}}
                        {{-- MOBILE BOTTOM SECTION --}}
                        {{-- ================================================================ --}}
                        <div class="border-t border-[#373a46] mt-auto pt-3">
                            <div class="px-3 pb-2 flex flex-col space-y-2">
                                @if(Auth::user()->role === 'instructor')
                                    <div class="relative">
                                        <a href="{{ route('instructor.pending.verification') }}" class="btn-primary flex flex-row items-center justify-center w-full text-base h-12">
                                            @if($hasNotifications)
                                                <div class="notification-badge"></div>
                                            @endif
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <span class="truncate whitespace-nowrap">Pending Application</span>
                                        </a>
                                    </div>
                                @elseif(Auth::user()->role === 'cadet')
                                    <div class="relative">
                                        <a href="{{ route('cadet.attendance') }}" class="btn-primary flex flex-row items-center justify-center w-full text-base h-12">
                                            @if($hasNotifications)
                                                <div class="notification-badge"></div>
                                            @endif
                                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="truncate whitespace-nowrap">Attendance</span>
                                        </a>
                                    </div>
                                @endif

                                <a href="{{ url('/') }}" class="flex items-center justify-center py-1 hover:transform hover:scale-105 transition-transform">
                                    @if(View::exists('components.application-logo'))
                                        <x-application-logo class="h-24 w-auto fill-current text-white mt-0" />
                                    @else
                                        <div class="h-24 w-24 flex items-center justify-center bg-[#313541] rounded-full text-white font-bold text-sm">LOGO</div>
                                    @endif
                                </a>

                                <form method="POST" action="{{ route('logout') }}" x-ref="logoutFormMobile">
                                    @csrf
                                    <button type="button"
                                            @click="currentLogoutForm = $refs.logoutFormMobile; showLogoutModal = true"
                                            class="flex items-center justify-center w-full py-2.5 px-4 text-[#ec6c6c] font-semibold rounded-lg hover:bg-[#373a46] hover:text-white transition-colors text-sm">
                                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                                        </svg>
                                        <span class="truncate">Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- ================================================================ --}}
                {{-- MOBILE OVERLAY --}}
                {{-- ================================================================ --}}
                <div 
                    x-show="sidebarOpen || $store.modal?.open"
                    x-cloak
                    x-transition
                    @click="sidebarOpen = false; if ($store.modal) { $store.modal.open = false; $store.modal.selected = [] }"
                    class="fixed inset-0 bg-black bg-opacity-50 z-40 sm:hidden">
                </div>
                {{-- ================================================================ --}}
                {{-- DESKTOP TWO COLUMN LAYOUT --}}
                {{-- ================================================================ --}}
                <div class="flex h-screen" style="background: #f5f5f5;">
                    {{-- ================================================================ --}}
                    {{-- DESKTOP SIDEBAR --}}
                    {{-- ================================================================ --}}
                    <aside class="w-80 bg-[#2e313c] shadow-lg flex flex-col justify-between border-r border-[#373a46] transform transition-transform duration-300 ease-in-out hidden sm:flex text-white h-screen overflow-hidden"
                        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full sm:translate-x-0'">

                        <div class="flex flex-col h-full space-y-4 px-4 pt-4 overflow-hidden">
                            {{-- ================================================================ --}}
                            {{-- DESKTOP PROFILE SECTION --}}
                            {{-- ================================================================ --}}
                            <x-dropdown align="right" width="full" contentClasses="py-1 bg-white text-black border border-gray-300">
                                <x-slot name="trigger">
                                    <div class="flex items-center gap-3 border-b border-[#373a46] pb-2 cursor-pointer hover:bg-[#373a46] transition-colors rounded-md px-2 py-1 w-full">
                                        @if($avatarSrc)
                                            <img src="{{ $avatarSrc }}"
                                                 alt="Profile"
                                                 class="w-10 h-10 rounded-full object-cover"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm" style="display: none;">
                                                {{ $initials }}
                                            </div>
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                        <div class="flex flex-col flex-1 min-w-0">
                                            <div class="font-semibold text-sm leading-tight truncate text-white">{{ Auth::user()->name }}</div>
                                            <div class="text-xs text-gray-400 leading-tight truncate">{{ Auth::user()->email }}</div>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('profile.edit') }}" class="flex items-center text-black hover:bg-gray-100 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Edit Profile
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>

                            {{-- ================================================================ --}}
                            {{-- DESKTOP NAVIGATION LINKS --}}
                            {{-- ================================================================ --}}
                            <nav class="flex flex-col space-y-2 overflow-y-auto">
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors
                                   {{ (Auth::user()->role === 'instructor' && request()->routeIs('instructor.dashboard')) || (Auth::user()->role === 'cadet' && request()->routeIs('cadet.dashboard')) ? 'text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                    </svg>
                                    Dashboard
                                </a>

                                @if(isset($instructor) && $instructor && $instructor->expertise === 'Admin')
                                    <div x-data="{ open: false }" class="mt-4">
                                        <button @click="open = !open" class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9] focus:outline-none focus:ring-2 focus:ring-[#3c92d9] transition-colors">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                            </svg>
                                            Admin Management
                                            <svg :class="{'transform rotate-180': open}" class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>
                                        <div x-show="open" x-transition class="mt-2 space-y-1 pl-8">
                                            <a href="{{ route('admin.user_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                                User Management
                                            </a>
                                            <a href="{{ route('admin.data_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                                Data Management
                                            </a>
                                            <a href="{{ route('admin.gamification_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                                Gamification Management
                                            </a>
                                            <a href="{{ route('admin.access_management') }}" class="block px-3 py-2 text-sm font-medium rounded-md text-white hover:text-[#3c92d9]">
                                                Access Management
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mt-6">
                                    <h3 class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">
                                        @if(Auth::user()->role === 'instructor')
                                            Management
                                        @else
                                            Features
                                        @endif
                                    </h3>
                                    <div class="space-y-1">
                                        @if(Auth::user()->role === 'instructor')
                                            <a href="{{ route('instructor.cadet_management') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/cadet*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                                </svg>
                                                Cadet Administration
                                            </a>

                                            <a href="{{ route('instructor.training') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/training*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                                </svg>
                                                Training
                                            </a>

                                            <a href="{{ route('instructor.allowance') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/allowance*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                Allowance
                                            </a>

                                            <a href="{{ route('instructor.inventory') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/inventory*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                Inventory
                                            </a>

                                            <a href="{{ route('instructor.learning_hub') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/learning*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                Learning Hub
                                            </a>

                                            <a href="{{ route('instructor.gallery') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('instructor/gallery*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                Gallery
                                            </a>

                                        @elseif(Auth::user()->role === 'cadet')
                                            <a href="{{ route('cadet.training') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('cadet/training*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                                </svg>
                                                Training
                                            </a>

                                            <a href="{{ route('cadet.allowance') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('cadet/allowance*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                Allowance Estimation
                                            </a>

                                            <a href="{{ route('cadet.inventory') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('cadet/inventory*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                                Inventory
                                            </a>

                                            <a href="{{ route('cadet.learning_hub') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('cadet/learning*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                Learning Hub
                                            </a>

                                            <a href="{{ route('cadet.performance') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('cadet/performance*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                                </svg>
                                                Performance
                                            </a>

                                            <a href="{{ route('cadet.gallery') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->is('cadet/gallery*') ? 'border-l-4 border-[#3c92d9] text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                Gallery
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </nav>

                            {{-- ================================================================ --}}
                            {{-- DESKTOP BOTTOM SECTION --}}
                            {{-- ================================================================ --}}
                            <div class="border-t border-[#373a46] overflow-hidden mt-1">
                                <div class="p-4 flex flex-col justify-between h-full">
                                    @if(Auth::user()->role === 'instructor')
                                        <div class="relative">
                                            <a href="{{ route('instructor.pending.verification') }}" class="btn-primary flex items-center justify-center w-full h-12 text-base">
                                                @if($hasNotifications)
                                                    <div class="notification-badge"></div>
                                                @endif
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                                Pending Application
                                            </a>
                                        </div>
                                    @elseif(Auth::user()->role === 'cadet')
                                        <div class="relative">
                                            <a href="{{ route('cadet.attendance') }}" class="btn-primary flex items-center justify-center w-full h-12 text-base">
                                                @if($hasNotifications)
                                                    <div class="notification-badge"></div>
                                                @endif
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Attendance
                                            </a>
                                        </div>
                                    @endif

                                    <a href="{{ url('/') }}" class="flex items-center justify-center mt-0 mb-4 hover:transform hover:scale-105 transition-transform">
                                        @if(View::exists('components.application-logo'))
                                            <x-application-logo class="h-32 w-auto fill-current text-white" />
                                        @else
                                            <div class="h-32 w-32 flex items-center justify-center bg-[#313541] rounded-full text-white font-bold text-sm">LOGO</div>
                                        @endif
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}" class="mt-auto" x-ref="logoutFormDesktop">
                                        @csrf
                                        <button type="button" 
                                                @click="currentLogoutForm = $refs.logoutFormDesktop; showLogoutModal = true" 
                                                class="flex items-center justify-center w-full py-3 px-5 text-[#ec6c6c] font-semibold rounded-2xl hover:text-white transition-colors border border-transparent">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"></path>
                                            </svg>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </aside>

                    {{-- ================================================================ --}}
                    {{-- MAIN CONTENT AREA --}}
                    {{-- ================================================================ --}}
                    <div class="flex-1 flex flex-col h-screen overflow-hidden">
                        @isset($header)
                            <header class="bg-white shadow flex-shrink-0 w-full flex justify-end">
                                <div class="w-full max-w-7xl py-4 px-3 sm:py-6 sm:px-6 lg:px-8 flex justify-end">
                                    <div class="text-left w-full">
                                        {{ $header }}
                                    </div>
                                </div>
                            </header>
                        @endisset

                        <main class="flex-1 p-3 sm:p-6 overflow-y-auto">
                            {{ $slot }}
                        </main>
                    </div>
                </div>

                {{-- ================================================================ --}}
                {{-- DESKTOP OVERLAY --}}
                {{-- ================================================================ --}}
                <div x-show="sidebarOpen"
                     x-cloak
                     @click="sidebarOpen = false"
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-black bg-opacity-50 z-40 sm:hidden">
                </div>
            </div>
        </div>

        {{-- ================================================================ --}}
        {{-- BADGE UNLOCK MODAL SYSTEM --}}
        {{-- ================================================================ --}}
        <x-badge-unlock-modal />
    </body>
</html>