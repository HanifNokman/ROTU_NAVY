<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumni') }}
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
    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-green rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3" id="page-title">
                    Alumni
                </h1>
                <p class="text-lg text-gray-600" id="page-description">Meet our alumni and their achievements after ROTU NAVY training</p>

                <!-- Toggle Buttons -->
                <div class="flex justify-center mt-6 gap-3">
                    <button onclick="toggleView('alumni')" id="alumni-btn" class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg">
                        Alumni
                    </button>
                    <button onclick="toggleView('halloffame')" id="halloffame-btn" class="px-6 py-3 rounded-lg font-semibold transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300">
                        Hall of Fame
                    </button>
                </div>
            </div>

            <!-- Alumni Content Card -->
            <div id="alumni-content" class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-green mr-3 p-2 rounded-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Success Stories</h3>
                    </div>
                    <p class="text-gray-600 ml-13">Our graduates making a difference in their careers and communities</p>
                </div>

                <div class="p-6">
                    <!-- Alumni by Intake -->
                    @forelse($alumniByIntake as $intake => $cadets)
                    <div class="mb-8">
                        <details class="bg-gray-50 rounded-lg border border-gray-200">
                            <summary class="cursor-pointer p-4 font-semibold text-lg text-gray-800 transition duration-200">
                                Intake - {{ $intake - 2011 }} ({{ $intake }})
                                <span class="text-sm text-gray-600 ml-2">({{ $cadets->count() }} alumni)</span>
                            </summary>
                            <div class="p-6">
                                <!-- Family Tree Layout -->
                                <div class="flex flex-col items-center space-y-6">
                                    <!-- CO at the top -->
                                    @php
                                        $co = $cadets->firstWhere('position', 'CO');
                                    @endphp
                                    <div class="text-center">
                                        <div class="w-20 h-24 mx-auto mb-3 bg-gray-200 rounded-lg overflow-hidden">
                                            @if($co && $co->profile_pic)
                                                <img src="{{ asset('storage/' . $co->profile_pic) }}" alt="{{ $co->user->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        @if($co)
                                            <p class="text-sm text-gray-600 font-bold">Lt. M {{ $co->user->name }} PSSTLDM</p>
                                        @else
                                            <p class="text-sm text-gray-600 font-bold">Position Vacant</p>
                                        @endif
                                        <p class="text-sm text-gray-500 font-bold">CO Intake</p>
                                    </div>

                                    <!-- Line connecting CO to Thana and Zayn -->
                                    @if($co)
                                    <div class="w-px h-6 bg-gray-300"></div>
                                    @endif

                                    <!-- Thana and Zayn side by side -->
                                    @php
                                        $thana = $cadets->firstWhere('position', 'Thana');
                                        $zayn = $cadets->firstWhere('position', 'Zayn');
                                    @endphp
                                    <div class="flex justify-center space-x-40">
                                        <!-- Thana position -->
                                        <div class="text-center">
                                            <div class="w-20 h-24 mx-auto mb-3 bg-gray-200 rounded-lg overflow-hidden">
                                                @if($thana && $thana->profile_pic)
                                                    <img src="{{ asset('storage/' . $thana->profile_pic) }}" alt="{{ $thana->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($thana)
                                                <p class="text-sm text-gray-600 font-bold">Lt. M {{ $thana->user->name }} PSSTLDM</p>
                                            @else
                                                <p class="text-sm text-gray-600 font-bold">Position Vacant</p>
                                            @endif
                                            <p class="text-sm text-gray-500 font-bold">Rank Thana</p>
                                        </div>
                                        <!-- Zayn position -->
                                        <div class="text-center">
                                            <div class="w-20 h-24 mx-auto mb-3 bg-gray-200 rounded-lg overflow-hidden">
                                                @if($zayn && $zayn->profile_pic)
                                                    <img src="{{ asset('storage/' . $zayn->profile_pic) }}" alt="{{ $zayn->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            @if($zayn)
                                                <p class="text-sm text-gray-600 font-bold">Lt. M {{ $zayn->user->name }} PSSTLDM</p>
                                            @else
                                                <p class="text-sm text-gray-600 font-bold">Position Vacant</p>
                                            @endif
                                            <p class="text-sm text-gray-500 font-bold">Rank Zayn</p>
                                        </div>
                                    </div>

                                    <!-- Line connecting to others -->
                                    @if($thana || $zayn)
                                    <div class="w-px h-6 bg-gray-300"></div>
                                    @endif

                                    <!-- Other cadets in grid -->
                                    @php
                                        $others = $cadets->filter(function($cadet) {
                                            return !in_array($cadet->position, ['CO', 'Thana', 'Zayn']);
                                        });
                                    @endphp
                                    @if($others->count() > 0)
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                        @foreach($others as $cadet)
                                        <div class="text-center">
                                            <div class="w-20 h-24 mx-auto mb-2 bg-gray-200 rounded-lg overflow-hidden">
                                                @if($cadet->profile_pic)
                                                    <img src="{{ asset('storage/' . $cadet->profile_pic) }}" alt="{{ $cadet->user->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 font-bold">Lt. M {{ $cadet->user->name }} PSSTLDM</p>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </details>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="mt-2 text-gray-500">No alumni available.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Hall of Fame Content Card -->
            <div id="halloffame-content" class="dashboard-card bg-white rounded-xl overflow-hidden hidden">
                <div class="section-header" style="background: linear-gradient(to right, #fef3c7 0%, #fde68a 100%);">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper bg-gradient-to-r from-yellow-400 to-yellow-600 mr-3 p-2 rounded-md">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Hall of Fame</h3>
                    </div>
                    <p class="text-gray-600 ml-13">Celebrating excellence: Best Cadets and Best Academics by intake</p>
                </div>

                <div class="p-6">
                    @forelse($hallOfFameByIntake as $intake => $cadets)
                    <div class="mb-8">
                        <div class="bg-gradient-to-r from-yellow-50 to-blue-50 rounded-lg border-2 border-yellow-200 p-6">
                            <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                Intake - {{ $intake - 2011 }} ({{ $intake }})
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($cadets as $cadet)
                                    <div class="bg-white rounded-lg p-5 shadow-lg border-2 {{ $cadet->is_best_cadet ? 'border-yellow-400' : 'border-blue-400' }}">
                                        <div class="flex items-start space-x-4">
                                            {{-- Profile Picture --}}
                                            <div class="flex-shrink-0">
                                                <div class="w-24 h-32 bg-gray-200 rounded-lg overflow-hidden">
                                                    @if($cadet->profile_pic)
                                                        <img src="{{ asset('storage/' . $cadet->profile_pic) }}"
                                                             alt="{{ $cadet->user->name }}"
                                                             class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Cadet Info --}}
                                            <div class="flex-1">
                                                {{-- Recognition Badges --}}
                                                <div class="flex flex-wrap gap-2 mb-3">
                                                    @if($cadet->is_best_cadet)
                                                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white px-3 py-1 rounded-lg shadow flex items-center space-x-1 text-xs font-bold">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                            <span>BEST CADET</span>
                                                        </div>
                                                    @endif
                                                    @if($cadet->is_best_academic)
                                                        <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white px-3 py-1 rounded-lg shadow flex items-center space-x-1 text-xs font-bold">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                                            </svg>
                                                            <span>BEST ACADEMIC</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Name and Details --}}
                                                <h5 class="text-lg font-bold text-gray-900">Lt. M {{ $cadet->user->name }} PSSTLDM</h5>
                                                <p class="text-sm text-gray-600 mt-1">{{ $cadet->position ?? 'Cadet' }}</p>
                                                <p class="text-xs text-gray-500 mt-1">Service No: {{ $cadet->service_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <p class="mt-2 text-gray-500 font-semibold">No Hall of Fame members yet.</p>
                        <p class="text-sm text-gray-400">Best Cadets and Best Academics will appear here.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleView(view) {
            const alumniBtn = document.getElementById('alumni-btn');
            const halloffameBtn = document.getElementById('halloffame-btn');
            const alumniContent = document.getElementById('alumni-content');
            const halloffameContent = document.getElementById('halloffame-content');
            const pageTitle = document.getElementById('page-title');
            const pageDescription = document.getElementById('page-description');

            if (view === 'alumni') {
                // Update buttons
                alumniBtn.className = 'px-6 py-3 rounded-lg font-semibold transition-all duration-200 bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg';
                halloffameBtn.className = 'px-6 py-3 rounded-lg font-semibold transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300';

                // Update content
                alumniContent.classList.remove('hidden');
                halloffameContent.classList.add('hidden');

                // Update title
                pageTitle.textContent = 'Alumni';
                pageDescription.textContent = 'Meet our alumni and their achievements after ROTU NAVY training';
            } else if (view === 'halloffame') {
                // Update buttons
                halloffameBtn.className = 'px-6 py-3 rounded-lg font-semibold transition-all duration-200 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white shadow-lg';
                alumniBtn.className = 'px-6 py-3 rounded-lg font-semibold transition-all duration-200 bg-gray-200 text-gray-700 hover:bg-gray-300';

                // Update content
                halloffameContent.classList.remove('hidden');
                alumniContent.classList.add('hidden');

                // Update title
                pageTitle.textContent = 'Hall of Fame';
                pageDescription.textContent = 'Celebrating excellence: Best Cadets and Best Academics by intake';
            }
        }
    </script>
</x-app-layout>
