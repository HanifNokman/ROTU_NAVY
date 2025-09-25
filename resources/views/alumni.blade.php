<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumni') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Alumni
                </h1>
                <p class="text-gray-600">Meet our alumni and their achievements after ROTU NAVY training</p>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-green-50 to-blue-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Success Stories
                    </h2>
                    <p class="text-gray-600">Our graduates making a difference in their careers and communities</p>
                </div>

                <div class="p-6">
                    <!-- Alumni by Intake -->
                    @forelse($alumniByIntake as $intake => $cadets)
                    <div class="mb-8">
                        <details class="bg-gray-50 rounded-lg border border-gray-200">
                            <summary class="cursor-pointer p-4 font-semibold text-lg text-gray-800 hover:bg-gray-100 transition duration-200">
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
        </div>
    </div>
</x-app-layout>
