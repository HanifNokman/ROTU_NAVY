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

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('scripts')
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        {{-- ================================================================ --}}
        {{-- CUSTOM STYLES --}}
        {{-- ================================================================ --}}
        <style>
            [x-cloak] { 
                display: none !important; 
            }
            
            :root {
                --gradient-primary: linear-gradient(135deg, #3c92d9, #2980b9);
                --shadow-primary: 0 10px 30px rgba(60, 146, 217, 0.3);
            }
            
            .btn-primary {
                background: var(--gradient-primary);
                padding: 12px 28px;
                border: none;
                border-radius: 8px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                color: white;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.95rem;
                box-shadow: var(--shadow-primary);
                position: relative;
                overflow: visible;
                cursor: pointer;
            }
            
            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 20px rgba(60, 146, 217, 0.4);
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
        </style>
    </head>
    
    <body class="font-sans antialiased bg-gray-100">
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
                $hasNotifications = $pendingUsersCount > 0;
                
            } elseif ($user->role === 'cadet') {
                $cadet = App\Models\Cadet::where('user_id', $user->id)->first();
                $profilePicture = $cadet?->profile_pic;
                
                $hasNotifications = false;
                
                if ($cadet) {
                    $pendingAbsences = DB::table('training_attendances')
                        ->join('trainings', 'training_attendances.training_id', '=', 'trainings.id')
                        ->where('training_attendances.cadet_id', $cadet->id)
                        ->where('training_attendances.present', false)
                        ->where('trainings.status', 'Completed')
                        ->where(function($q) {
                            $q->whereNull('training_attendances.absence_reason')
                              ->orWhereNull('training_attendances.file_url')
                              ->orWhere('training_attendances.absence_reason', '')
                              ->orWhere('training_attendances.file_url', '');
                        })
                        ->exists();
                    
                    $hasNotifications = $pendingAbsences;
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
                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[60]"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4"
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
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button @click="showLogoutModal = false" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Cancel
                            </button>
                            <button @click="if(currentLogoutForm) { currentLogoutForm.submit(); }" 
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                Yes, Log Out
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- MOBILE LAYOUT --}}
            {{-- ================================================================ --}}
            <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
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
                    class="fixed top-0 right-0 w-72 h-full bg-[#2e313c] shadow-lg flex flex-col justify-between z-50 border-l border-[#373a46] sm:hidden text-white"
                >
                    <div class="flex flex-col h-full space-y-4 px-3 pt-3">
                        <div class="flex justify-end">
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
                                <div class="flex items-center gap-3 border-b border-[#373a46] pb-4 cursor-pointer hover:bg-[#373a46] transition-colors rounded-md px-2 py-1 w-full">
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
                        {{-- MOBILE NAVIGATION LINKS --}}
                        {{-- ================================================================ --}}
                        <nav class="flex flex-col space-y-2">
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ (Auth::user()->role === 'instructor' && request()->routeIs('instructor.dashboard')) || (Auth::user()->role === 'cadet' && request()->routeIs('cadet.dashboard')) ? 'text-[#3c92d9]' : 'text-white hover:text-[#3c92d9]' }}">
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
                                            Cadet Management
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
                        <div class="border-t border-[#373a46] mt-1">
                            <div class="p-2 flex flex-col space-y-0">
                                @if(Auth::user()->role === 'instructor')
                                    <div class="relative">
                                        <a href="{{ route('instructor.pending.verification') }}" class="btn-primary flex items-center justify-center w-full">
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
                                        <a href="{{ route('cadet.attendance') }}" class="btn-primary flex items-center justify-center w-full">
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

                                <a href="{{ url('/') }}" class="flex items-center justify-center mt-4 hover:transform hover:scale-105 transition-transform">
                                    @if(View::exists('components.application-logo'))
                                        <x-application-logo class="h-8 w-auto fill-current text-white" />
                                    @else
                                        <div class="h-6 w-6 flex items-center justify-center bg-[#313541] rounded-full text-white font-bold text-xs">LOGO</div>
                                    @endif
                                </a>

                                <form method="POST" action="{{ route('logout') }}" x-ref="logoutFormMobile">
                                    @csrf
                                    <button type="button" 
                                            @click="currentLogoutForm = $refs.logoutFormMobile; showLogoutModal = true" 
                                            class="flex items-center justify-center w-full py-3 px-5 text-[#ec6c6c] font-semibold rounded-2xl hover:text-white">
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
                <div class="flex h-screen">
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
                                                Cadet Management
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
                                            <a href="{{ route('instructor.pending.verification') }}" class="btn-primary flex items-center justify-center w-full">
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
                                            <a href="{{ route('cadet.attendance') }}" class="btn-primary flex items-center justify-center w-full">
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

                                    <a href="{{ url('/') }}" class="flex items-center justify-center mt-0 hover:transform hover:scale-105 transition-transform">
                                        @if(View::exists('components.application-logo'))
                                            <x-application-logo class="h-8 w-auto fill-current text-white" />
                                        @else
                                            <div class="h-8 w-8 flex items-center justify-center bg-[#313541] rounded-full text-white font-bold text-sm">LOGO</div>
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
                    <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
                        @isset($header)
                            <header class="bg-white shadow flex-shrink-0 w-full flex justify-end">
                                <div class="w-full max-w-7xl py-6 px-4 sm:px-6 lg:px-8 flex justify-end">
                                    <div class="text-left w-full">
                                        {{ $header }}
                                    </div>
                                </div>
                            </header>
                        @endisset
                    
                        <main class="flex-1 p-6 overflow-y-auto">
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
    </body>
</html>