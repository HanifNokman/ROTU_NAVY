<x-app-layout>
    {{-- ================================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================================ --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Performance') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ================================================================ --}}
            {{-- PAGE TITLE SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Performance & Achievements
                </h1>
                <p class="text-gray-600">Track your progress, rankings, and earned badges</p>
            </div>

            {{-- ================================================================ --}}
            {{-- PERFORMANCE OVERVIEW SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Performance Overview
                        </h1>
                    </div>

                    <p class="mt-6 text-gray-500 leading-relaxed">
                        View your performance ratings and progress over time.
                    </p>

                    {{-- ================================================================ --}}
                    {{-- USER PERFORMANCE SUMMARY --}}
                    {{-- ================================================================ --}}
                    <div class="mt-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Performance Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600">Total Points</span>
                                    <span class="text-2xl font-bold text-blue-600">{{ number_format($userTotalPoints, 0) }}</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-500">Out of 800 possible points</div>
                            </div>
                            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600">Overall Rating</span>
                                    <div class="flex items-center">
                                        @php
                                            $stars = substr_count($userOverallRating, '⭐');
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-6 h-6 {{ $i <= $stars ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mt-2 text-xs text-gray-500 text-right">{{ $stars }} out of 5 stars</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- OVERALL PERFORMANCE LEADERBOARD --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6 lg:p-8 bg-white">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-900">Overall Performance</h2>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- LEADERBOARD DATA --}}
                    {{-- ================================================================ --}}
                    @php
                        $userEntry = null;
                        $userRank = null;
                        $showUserAtBottom = false;
                        
                        foreach($leaderboards['overall'] as $index => $entry) {
                            if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                $userEntry = $entry;
                                $userRank = $index + 1;
                                if($index >= 10) {
                                    $showUserAtBottom = true;
                                }
                                break;
                            }
                        }
                    @endphp
                    
                    {{-- ================================================================ --}}
                    {{-- LEADERBOARD LIST --}}
                    {{-- ================================================================ --}}
                    <div class="space-y-2 max-h-[500px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($leaderboards['overall'] as $index => $entry)
                            @php
                                $rank = $index + 1;
                                $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                
                                if($rank == 1) {
                                    $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                    $rankBg = 'bg-yellow-500';
                                    $medalIcon = '🥇';
                                } elseif($rank == 2) {
                                    $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                    $rankBg = 'bg-gray-400';
                                    $medalIcon = '🥈';
                                } elseif($rank == 3) {
                                    $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                    $rankBg = 'bg-orange-500';
                                    $medalIcon = '🥉';
                                } else {
                                    $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                    $rankBg = 'bg-gray-500';
                                    $medalIcon = '';
                                }
                            @endphp
                            
                            @if(!$showUserAtBottom || !$isUser)
                                <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                            {{ $rank }}
                                        </div>
                                        @if($medalIcon)
                                            <span class="text-2xl mr-2">{{ $medalIcon }}</span>
                                        @endif
                                        <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }}">
                                            {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        @if($isUser)
                                            <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full">You</span>
                                        @endif
                                    </div>
                                    <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }}">{{ number_format($entry['score'], 0) }} pts</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    {{-- ================================================================ --}}
                    {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                    {{-- ================================================================ --}}
                    @if($showUserAtBottom && $userEntry)
                        <div class="mt-3 pt-3 border-t-2 border-gray-300">
                            <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                <div class="flex items-center flex-1">
                                    <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                        {{ $userRank }}
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">
                                        {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                    </span>
                                    <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full">You</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ number_format($userEntry['score'], 0) }} pts</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ATTENDANCE & DUTY LEADERBOARDS --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                {{-- ================================================================ --}}
                {{-- ATTENDANCE LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 lg:p-8 bg-white">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h2 class="text-xl font-semibold text-gray-900">Attendance</h2>
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['attendance'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['attendance'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ number_format($entry['score'], 0) }} pts</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ number_format($userEntry['score'], 0) }} pts</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================================================================ --}}
                {{-- DUTY COUNT LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 lg:p-8 bg-white">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h2 class="text-xl font-semibold text-gray-900">Duty Count</h2>
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['duty'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['duty'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ $entry['score'] }} duties</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ $userEntry['score'] }} duties</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- QUIZ & LEARNING LEADERBOARDS --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                {{-- ================================================================ --}}
                {{-- QUIZ OVERALL LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 lg:p-8 bg-white">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <h2 class="text-xl font-semibold text-gray-900">Quiz Overall</h2>
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['quiz_overall'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['quiz_overall'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ $entry['score'] }}%</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ $userEntry['score'] }}%</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ================================================================ --}}
                {{-- LEARNING PROGRESS LEADERBOARD --}}
                {{-- ================================================================ --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-6 lg:p-8 bg-white">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            <h2 class="text-xl font-semibold text-gray-900">Learning Progress</h2>
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD DATA --}}
                        {{-- ================================================================ --}}
                        @php
                            $userEntry = null;
                            $userRank = null;
                            $showUserAtBottom = false;
                            
                            foreach($leaderboards['learning'] as $index => $entry) {
                                if($entry['cadet'] && $entry['cadet']->id == $cadet->id) {
                                    $userEntry = $entry;
                                    $userRank = $index + 1;
                                    if($index >= 10) {
                                        $showUserAtBottom = true;
                                    }
                                    break;
                                }
                            }
                        @endphp
                        
                        {{-- ================================================================ --}}
                        {{-- LEADERBOARD LIST --}}
                        {{-- ================================================================ --}}
                        <div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($leaderboards['learning'] as $index => $entry)
                                @php
                                    $rank = $index + 1;
                                    $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                    
                                    if($rank == 1) {
                                        $bgColor = 'bg-gradient-to-r from-yellow-100 to-yellow-50 border-2 border-yellow-400';
                                        $rankBg = 'bg-yellow-500';
                                        $medalIcon = '🥇';
                                    } elseif($rank == 2) {
                                        $bgColor = 'bg-gradient-to-r from-gray-200 to-gray-100 border-2 border-gray-400';
                                        $rankBg = 'bg-gray-400';
                                        $medalIcon = '🥈';
                                    } elseif($rank == 3) {
                                        $bgColor = 'bg-gradient-to-r from-orange-200 to-orange-100 border-2 border-orange-400';
                                        $rankBg = 'bg-orange-500';
                                        $medalIcon = '🥉';
                                    } else {
                                        $bgColor = $isUser ? 'bg-blue-50 border-2 border-blue-400' : 'bg-white border border-gray-200';
                                        $rankBg = 'bg-gray-500';
                                        $medalIcon = '';
                                    }
                                @endphp
                                
                                @if(!$showUserAtBottom || !$isUser)
                                    <div class="flex items-center justify-between p-3 {{ $bgColor }} rounded-lg {{ $isUser ? 'ring-2 ring-blue-500' : '' }} transition-all">
                                        <div class="flex items-center flex-1">
                                            <div class="flex items-center justify-center w-8 h-8 {{ $rankBg }} rounded-full text-white font-bold text-sm mr-3">
                                                {{ $rank }}
                                            </div>
                                            @if($medalIcon)
                                                <span class="text-xl mr-2">{{ $medalIcon }}</span>
                                            @endif
                                            <span class="text-sm font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown Cadet' }}
                                            </span>
                                            @if($isUser)
                                                <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold {{ $rank <= 3 ? 'text-gray-900' : 'text-gray-700' }} ml-2 whitespace-nowrap">{{ $entry['score'] }}%</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        {{-- ================================================================ --}}
                        {{-- USER POSITION (IF OUTSIDE TOP 10) --}}
                        {{-- ================================================================ --}}
                        @if($showUserAtBottom && $userEntry)
                            <div class="mt-3 pt-3 border-t-2 border-gray-300">
                                <div class="flex items-center justify-between p-3 bg-blue-50 border-2 border-blue-400 rounded-lg ring-2 ring-blue-500">
                                    <div class="flex items-center flex-1">
                                        <div class="flex items-center justify-center w-8 h-8 bg-gray-500 rounded-full text-white font-bold text-sm mr-3">
                                            {{ $userRank }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 truncate">
                                            {{ $userEntry['cadet'] && $userEntry['cadet']->user ? ($userEntry['cadet']->rank ? $userEntry['cadet']->rank . ' ' : '') . $userEntry['cadet']->user->name : 'Unknown Cadet' }}
                                        </span>
                                        <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap">You</span>
                                    </div>
                                    <span class="text-sm font-semibold text-gray-700 ml-2 whitespace-nowrap">{{ $userEntry['score'] }}%</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- QUIZ BY CATEGORY LEADERBOARD --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6 lg:p-8 bg-white">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-900">Quiz by Category</h2>
                    </div>
                    
                    {{-- ================================================================ --}}
                    {{-- CATEGORY LEADERBOARDS GRID --}}
                    {{-- ================================================================ --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($leaderboards['quiz_categories'] as $categoryName => $categoryLeaderboard)
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b border-gray-300">{{ $categoryName }}</h4>
                                <div class="space-y-1 max-h-[300px] overflow-y-auto pr-1 custom-scrollbar">
                                    @foreach($categoryLeaderboard as $index => $entry)
                                        @php
                                            $rank = $index + 1;
                                            $isUser = $entry['cadet'] && $entry['cadet']->id == $cadet->id;
                                            
                                            if($rank == 1) {
                                                $bgColor = 'bg-gradient-to-r from-yellow-50 to-yellow-25 border border-yellow-300';
                                                $medalIcon = '🥇';
                                            } elseif($rank == 2) {
                                                $bgColor = 'bg-gradient-to-r from-gray-100 to-gray-50 border border-gray-300';
                                                $medalIcon = '🥈';
                                            } elseif($rank == 3) {
                                                $bgColor = 'bg-gradient-to-r from-orange-100 to-orange-50 border border-orange-300';
                                                $medalIcon = '🥉';
                                            } else {
                                                $bgColor = $isUser ? 'bg-blue-50 border border-blue-300' : 'bg-white border border-gray-100';
                                                $medalIcon = '';
                                            }
                                        @endphp
                                        
                                        <div class="flex items-center justify-between p-2 {{ $bgColor }} rounded {{ $isUser ? 'ring-1 ring-blue-400' : '' }}">
                                            <div class="flex items-center flex-1 min-w-0">
                                                <span class="text-xs font-medium text-gray-600 w-5 flex-shrink-0">{{ $rank }}</span>
                                                @if($medalIcon)
                                                    <span class="text-sm mr-1 flex-shrink-0">{{ $medalIcon }}</span>
                                                @endif
                                                <span class="text-xs font-medium text-gray-900 {{ $isUser ? 'font-bold' : '' }} truncate">
                                                    {{ $entry['cadet'] && $entry['cadet']->user ? ($entry['cadet']->rank ? $entry['cadet']->rank . ' ' : '') . $entry['cadet']->user->name : 'Unknown' }}
                                                </span>
                                                @if($isUser)
                                                    <span class="ml-1 px-1.5 py-0.5 bg-blue-500 text-white text-xs rounded-full whitespace-nowrap flex-shrink-0">You</span>
                                                @endif
                                            </div>
                                            <span class="text-xs font-semibold text-gray-700 ml-2 whitespace-nowrap flex-shrink-0">{{ $entry['score'] }}%</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ACHIEVEMENT BADGES SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <h1 class="ml-2 text-2xl font-medium text-gray-900">
                            Achievement Badges
                        </h1>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Track your achievements and unlock new badges</p>
                </div>

                <div class="p-6 lg:p-8">
                    {{-- ================================================================ --}}
                    {{-- BADGE CATEGORIZATION DATA --}}
                    {{-- ================================================================ --}}
                    @php
                        // Group badges by category
                        $badgesByCategory = [
                            'overall' => ['unlocked' => [], 'unlockable' => []],
                            'attendance' => ['unlocked' => [], 'unlockable' => []],
                            'quiz' => ['unlocked' => [], 'unlockable' => []],
                            'learning' => ['unlocked' => [], 'unlockable' => []],
                            'duty' => ['unlocked' => [], 'unlockable' => []],
                            'academic' => ['unlocked' => [], 'unlockable' => []],
                        ];
                        
                        foreach($badgesData['unlocked'] as $unlockedBadge) {
                            $category = $unlockedBadge['badge']->category;
                            if(isset($badgesByCategory[$category])) {
                                $badgesByCategory[$category]['unlocked'][] = $unlockedBadge;
                            }
                        }
                        
                        foreach($badgesData['unlockable'] as $badge) {
                            $category = $badge->category;
                            if(isset($badgesByCategory[$category])) {
                                $badgesByCategory[$category]['unlockable'][] = $badge;
                            }
                        }
                        
                        $categoryNames = [
                            'overall' => 'Overall Performance',
                            'attendance' => 'Attendance',
                            'quiz' => 'Quiz Performance',
                            'learning' => 'Learning Progress',
                            'duty' => 'Duty',
                            'academic' => 'Academic Excellence',
                        ];
                        
                        $categoryIcons = [
                            'overall' => 'fa-star',
                            'attendance' => 'fa-calendar-check',
                            'quiz' => 'fa-brain',
                            'learning' => 'fa-book-open',
                            'duty' => 'fa-clipboard-check',
                            'academic' => 'fa-graduation-cap',
                        ];
                        
                        // Count total unlocked badges
                        $totalUnlocked = count($badgesData['unlocked']);
                    @endphp
                    
                    {{-- ================================================================ --}}
                    {{-- UNLOCKED BADGES SECTION --}}
                    {{-- ================================================================ --}}
                    @if($totalUnlocked > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <div class="w-1 h-5 bg-green-600 mr-2 rounded"></div>
                                Unlocked Badges
                                <span class="ml-2 px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">{{ $totalUnlocked }}</span>
                            </h3>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                @foreach($badgesData['unlocked'] as $unlockedBadge)
                                    <div class="bg-gradient-to-br from-white to-gray-50 border-2 {{ $unlockedBadge['is_displayed'] ? 'border-green-400 shadow-lg' : 'border-gray-200' }} rounded-xl p-4 text-center hover:shadow-xl transition-all duration-200 cursor-pointer transform hover:-translate-y-1"
                                         onclick="toggleBadgeDisplay({{ $unlockedBadge['badge']->id }})">
                                        <div class="flex justify-center mb-3">
                                            <div class="relative">
                                                <i class="{{ $unlockedBadge['badge']->icon }} text-4xl {{ $unlockedBadge['is_displayed'] ? 'text-yellow-500' : 'text-gray-600' }}"></i>
                                                @if($unlockedBadge['is_displayed'])
                                                    <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                                                @endif
                                            </div>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">{{ $unlockedBadge['badge']->name }}</h4>
                                        <p class="text-xs text-gray-600 mb-2 line-clamp-2">{{ $unlockedBadge['badge']->description }}</p>
                                        <div class="text-xs text-gray-500 mb-2">
                                            <i class="fas fa-calendar-check mr-1"></i>{{ $unlockedBadge['unlocked_at']->format('M d, Y') }}
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $unlockedBadge['is_displayed'] ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            <i class="fas fa-{{ $unlockedBadge['is_displayed'] ? 'eye' : 'eye-slash' }} mr-1 text-xs"></i>
                                            {{ $unlockedBadge['is_displayed'] ? 'Displayed' : 'Hidden' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    {{-- ================================================================ --}}
                    {{-- LOCKED BADGES BY CATEGORY --}}
                    {{-- ================================================================ --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <div class="w-1 h-5 bg-gray-400 mr-2 rounded"></div>
                            Locked Badges by Category
                        </h3>
                        
                        @foreach($badgesByCategory as $category => $badges)
                            @if(count($badges['unlockable']) > 0)
                                <div class="mb-8 last:mb-0">
                                    <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                        <i class="fas {{ $categoryIcons[$category] }} text-gray-600 mr-2"></i>
                                        {{ $categoryNames[$category] }}
                                        <span class="ml-2 text-sm font-normal text-gray-500">({{ count($badges['unlocked']) }}/{{ count($badges['unlocked']) + count($badges['unlockable']) }} unlocked)</span>
                                    </h4>
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                        @foreach($badges['unlockable'] as $badge)
                                            <div class="bg-gray-50 border-2 border-gray-300 border-dashed rounded-xl p-4 text-center opacity-60 hover:opacity-90 transition-all duration-200"
                                                 title="{{ $badge->unlock_criteria }}">
                                                <div class="flex justify-center mb-3">
                                                    <div class="relative">
                                                        <i class="{{ $badge->icon }} text-4xl text-gray-300"></i>
                                                        <div class="absolute inset-0 flex items-center justify-center">
                                                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h4 class="text-sm font-semibold text-gray-600 mb-1">{{ $badge->name }}</h4>
                                                <p class="text-xs text-gray-500 mb-2 line-clamp-2">{{ $badge->description }}</p>
                                                <div class="text-xs text-gray-400 bg-gray-100 rounded-lg p-2 mt-2">
                                                    <i class="fas fa-info-circle mr-1"></i>{{ $badge->unlock_criteria }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CUSTOM STYLES --}}
    {{-- ================================================================ --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        function toggleBadgeDisplay(badgeId) {
            fetch('/cadet/performance/toggle-badge', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    badge_id: badgeId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error toggling badge display');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error toggling badge display');
            });
        }
    </script>
</x-app-layout>