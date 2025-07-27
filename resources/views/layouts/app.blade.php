<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        @php
            $user = Auth::user();
            $profilePicture = null;

            if ($user->role === 'instructor') {
                $profilePicture = optional(App\Models\Instructor::where('user_id', $user->id)->first())->profile_picture;
            } elseif ($user->role === 'cadet') {
                $profilePicture = optional(App\Models\Cadet::where('user_id', $user->id)->first())->profile_picture;
            }

            $fallbackAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name);
            $avatarSrc = $profilePicture 
                ? asset('storage/' . $profilePicture) 
                : $fallbackAvatar;
        @endphp

        <!-- Mobile Sidebar (Toggle Sidebar) -->
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100">
            <!-- Mobile menu button (top right, always fixed) -->
            <div class="sm:hidden fixed top-4 right-4 z-50">
                <button @click="sidebarOpen = !sidebarOpen" class="bg-white p-2 rounded-md shadow-md">
                    <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Sidebar (collapsible, matches sidebar links) -->
            <aside 
                x-show="sidebarOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-x-full"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 translate-x-full"
                class="fixed top-0 right-0 w-80 h-full bg-white shadow-lg flex flex-col justify-between z-50 border-l border-gray-200 sm:hidden"
            >
                <div class="flex flex-col flex-1 space-y-6 px-4 pt-4">
                    <!-- Close (X) button -->
                    <div class="flex justify-end mb-2">
                        <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Profile Section -->
                    <div class="flex items-center gap-3 border-b border-gray-200 pb-4">
                       <img src="{{ $avatarSrc }}" 
                            alt="Profile" 
                            class="w-10 h-10 rounded-full object-cover"
                            onerror="this.onerror=null; this.src='{{ $fallbackAvatar }}';">
                        <div class="flex flex-col flex-1 min-w-0">
                            <div class="font-semibold text-sm leading-tight truncate">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 leading-tight truncate">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center text-gray-500 hover:text-gray-700 transition text-sm focus:outline-none">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                    <!-- Navigation Links -->
                    <nav class="flex flex-col space-y-2 flex-1 overflow-y-auto">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>
                        <div class="mt-6">
                            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                Management
                            </h3>
                            <div class="space-y-1">
                                @if(Auth::user()->role === 'instructor')
                                    <a href="{{ route('instructor.cadet_management') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.cadet_management') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                        Cadet Management
                                    </a>

                                    <a href="{{ route('instructor.training') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.training') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                        </svg>
                                        Training
                                    </a>

                                    <a href="{{ route('instructor.allowance') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.allowance') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Allowance
                                    </a>

                                    <a href="{{ route('instructor.inventory') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.inventory') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        Inventory
                                    </a>

                                    <a href="{{ route('instructor.learning-hub') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.learning-hub') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Learning Hub
                                    </a>

                                    <a href="{{ route('instructor.gallery') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.gallery') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Gallery
                                    </a>
                                @elseif(Auth::user()->role === 'cadet')
                                    <a href="{{ route('cadet.training') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.training') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                        </svg>
                                        Training
                                    </a>

                                    <a href="{{ route('cadet.allowance') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.allowance') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Allowance Estimation
                                    </a>

                                    <a href="{{ route('cadet.learning_hub') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.learning_hub') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Learning Hub
                                    </a>

                                    <a href="{{ route('cadet.inventory') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.inventory') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        Inventory
                                    </a>

                                    <a href="{{ route('cadet.gallery') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.gallery') ? 'bg-blue-50 text-blue-700' : '' }}">
                                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Gallery
                                    </a>
                                @endif
                            </div>
                        </div>
                    </nav>
                    <!-- Special Action Buttons - Mobile -->
                    <div class="px-4 py-4">
                        @if(Auth::user()->role === 'instructor')
                            <a href="{{ route('pending.verification') }}" class="flex items-center justify-center w-full py-4 px-5 bg-yellow-100 text-yellow-800 rounded-lg font-semibold hover:bg-yellow-200 transition-colors border border-yellow-200 {{ request()->routeIs('pending.verification') ? 'bg-yellow-200' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                Pending Verification
                            </a>
                        @elseif(Auth::user()->role === 'cadet')
                            <a href="{{ route('cadet.attendance') }}" class="flex items-center justify-center w-full py-4 px-5 bg-green-100 text-green-800 rounded-lg font-semibold hover:bg-green-200 transition-colors border border-green-200 {{ request()->routeIs('cadet.attendance') ? 'bg-green-200' : '' }}">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Attendance
                            </a>
                        @endif
                    </div>

                    <!-- Bottom Logo Section -->
                    <div class="p-6 border-t border-gray-200">
                        <a href="{{ url('/') }}" class="flex items-center justify-center">
                            @if(View::exists('components.application-logo'))
                                <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
                            @else
                                <div class="h-8 w-8 flex items-center justify-center bg-gray-200 rounded-full text-gray-600 font-bold text-sm">LOGO</div>
                            @endif
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Two Column Layout -->
            <div class="flex h-screen">
                <!-- Column 1: Sidebar -->
                <aside class="w-80 bg-white shadow-lg flex-col justify-between border-r border-gray-200 transform transition-transform duration-300 ease-in-out hidden sm:flex"
                       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full sm:translate-x-0'">
                    
                    <div class="flex flex-col flex-1 space-y-6 px-4 pt-4">
                        <!-- Profile Section -->
                        <div class="flex items-center gap-3 border-b border-gray-200 pb-4">
                            <img src="{{ $avatarSrc }}" 
                                alt="Profile" 
                                class="w-10 h-10 rounded-full object-cover"
                                onerror="this.onerror=null; this.src='{{ $fallbackAvatar }}';">
                            <div class="flex flex-col flex-1 min-w-0">
                                <div class="font-semibold text-sm leading-tight truncate">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 leading-tight truncate">{{ Auth::user()->email }}</div>
                            </div>
                            <div class="relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center text-gray-500 hover:text-gray-700 transition text-sm focus:outline-none">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                Log Out
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <nav class="flex flex-col space-y-2 flex-1 overflow-y-auto">
                            <!-- Dashboard -->
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Dashboard
                            </a>

                            <!-- Management Section -->
                            <div class="mt-6">
                                <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                    Management
                                </h3>
                                <!-- Dynamic Navigation based on User Role -->
                                <div class="space-y-1">
                                    @if(Auth::user()->role === 'instructor')
                                        <!-- Instructor Navigation -->
                                        <a href="{{ route('instructor.cadet_management') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.cadet_management') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <!-- Icon -->
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                            Cadet Management
                                        </a>

                                        <a href="{{ route('instructor.training') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.training') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                            Training
                                        </a>

                                        <a href="{{ route('instructor.allowance') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.allowance') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            Allowance
                                        </a>

                                        <a href="{{ route('instructor.inventory') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.inventory') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            Inventory
                                        </a>

                                        <a href="{{ route('instructor.learning-hub') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.learning-hub') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Learning Hub
                                        </a>

                                        <a href="{{ route('instructor.gallery') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('instructor.gallery') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Gallery
                                        </a>
                                    @elseif(Auth::user()->role === 'cadet')
                                        <!-- Cadet Navigation -->
                                        <a href="{{ route('cadet.training') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.training') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                            </svg>
                                            Training
                                        </a>

                                        <a href="{{ route('cadet.allowance') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.allowance') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                            </svg>
                                            Allowance Estimation
                                        </a>

                                        <a href="{{ route('cadet.learning_hub') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.learning_hub') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                            Learning Hub
                                        </a>

                                        <a href="{{ route('cadet.inventory') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.inventory') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                            Inventory
                                        </a>

                                        <a href="{{ route('cadet.gallery') }}"
                                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:bg-blue-50 hover:text-blue-700 transition-colors {{ request()->routeIs('cadet.gallery') ? 'bg-blue-50 text-blue-700' : '' }}">
                                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Gallery
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </nav>
                        
                        <!-- Special Action Buttons - Desktop -->
                        <div class="px-4 py-4">
                            @if(Auth::user()->role === 'instructor')
                                <a href="{{ route('pending.verification') }}" class="flex items-center justify-center w-full py-4 px-5 bg-yellow-100 text-yellow-800 rounded-lg font-semibold hover:bg-yellow-200 transition-colors border border-yellow-200 {{ request()->routeIs('pending.verification') ? 'bg-yellow-200' : '' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    Pending Verification
                                </a>
                            @elseif(Auth::user()->role === 'cadet')
                                <a href="{{ route('cadet.attendance') }}" class="flex items-center justify-center w-full py-4 px-5 bg-green-100 text-green-800 rounded-lg font-semibold hover:bg-green-200 transition-colors border border-green-200 {{ request()->routeIs('cadet.attendance') ? 'bg-green-200' : '' }}">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Attendance
                                </a>
                            @endif
                        </div>

                        <!-- Bottom Logo Section -->
                        <div class="p-6 border-t border-gray-200">
                            <a href="{{ url('/') }}" class="flex items-center justify-center">
                                @if(View::exists('components.application-logo'))
                                    <x-application-logo class="h-8 w-auto fill-current text-gray-800" />
                                @else
                                    <div class="h-8 w-8 flex items-center justify-center bg-gray-200 rounded-full text-gray-600 font-bold text-sm">LOGO</div>
                                @endif
                            </a>
                        </div>
                    </div>
                </aside>

                <!-- Column 2: Main Content -->
                <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
                <!-- Page Heading (optional) -->
                @isset($header)
                    <header class="bg-white shadow flex-shrink-0 w-full flex justify-end">
                        <div class="w-full max-w-7xl py-6 px-4 sm:px-6 lg:px-8 flex justify-end">
                            <div class="text-left w-full">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endisset
            
                    <!-- Page Content -->
                    <main class="flex-1 p-6 overflow-y-auto">
                        {{ $slot }}
                    </main>
                </div>
            </div>
            <!-- Mobile Overlay -->
            <div x-show="sidebarOpen" 
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
    </body>
</html>