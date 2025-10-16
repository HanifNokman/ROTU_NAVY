<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Application') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Account & New Cadet Intake Verification
                </h1>
                <p class="text-gray-600">Review and approve pending account registrations and cadet applications</p>
            </div>

            {{-- ================================================================ --}}
            {{-- CADET APPLICATION SECTION --}}
            {{-- ================================================================ --}}
            @if($applications->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300 mt-6">

                {{-- Section Header --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Cadet Application | Intake - {{ date('Y') - 2011 }} ({{ date('Y') }})
                            </h2>
                            <p class="text-gray-600">Review cadet applications for the current year intake</p>
                        </div>
                        <button id="toggleSelectionMode" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span id="toggleButtonText">Start Selection</span>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    {{-- ================================================================ --}}
                    {{-- REGULAR APPLICATION VIEW --}}
                    {{-- ================================================================ --}}
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

                            <table class="min-w-full divide-y divide-gray-200" id="applicationTable">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faculty</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="applicationTableBody">
                                    {{-- Dynamic content populated by JavaScript --}}
                                </tbody>
                            </table>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- SELECTION MODE VIEW --}}
                    {{-- ================================================================ --}}
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

                            {{-- Progress Indicator --}}
                            <div class="flex justify-between items-center">
                                <div class="flex-1 flex items-center" id="step1Progress">
                                    <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">1</div>
                                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                </div>
                                <div class="flex-1 flex items-center" id="step2Progress">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">2</div>
                                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                </div>
                                <div class="flex-1 flex items-center" id="step3Progress">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">3</div>
                                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                </div>
                                <div class="flex-1 flex items-center" id="step4Progress">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">4</div>
                                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                </div>
                                <div class="flex-1 flex items-center" id="step5Progress">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">5</div>
                                    <div class="flex-1 h-1 bg-gray-300 mx-2"></div>
                                </div>
                                <div class="flex items-center" id="step6Progress">
                                    <div class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-bold">6</div>
                                </div>
                            </div>

                            {{-- Search in Selection Mode --}}
                            <div class="mt-4 flex items-center justify-end space-x-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input type="text" id="selectionSearch" placeholder="Search by name, gender, course..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        {{-- Candidates List --}}
                        <div id="candidatesList">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Select</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                        <th class="px-4 py-2 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="candidatesTableBody">
                                    {{-- Dynamic content populated by JavaScript --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- End Selection Button --}}
                        <div id="endSelectionContainer" class="hidden mt-6 text-center">
                                <form method="POST" action="{{ route('instructor.pending.verification.end-selection') }}" onsubmit="return confirm('Are you sure you want to end the selection process? All passed candidates will be registered as cadets and all application records will be deleted.')">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors duration-200 flex items-center justify-center mx-auto">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    End Selection & Register Candidates
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- ================================================================ --}}
            {{-- VERIFICATION SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300 mt-6">

                {{-- Section Header --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pending Accounts
                    </h2>
                    <p class="text-gray-600">Review registration requests by role and take appropriate actions</p>
                </div>

                <div class="p-6">
                    {{-- Success Message --}}
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

                    {{-- Error Message --}}
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

                    {{-- ================================================================ --}}
                    {{-- TAB NAVIGATION --}}
                    {{-- ================================================================ --}}
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

                    {{-- ================================================================ --}}
                    {{-- CADETS TAB CONTENT --}}
                    {{-- ================================================================ --}}
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

                    {{-- ================================================================ --}}
                    {{-- INSTRUCTORS TAB CONTENT --}}
                    {{-- ================================================================ --}}
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

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT FOR SELECTION MODE --}}
    {{-- ================================================================ --}}
    <script>
        // Application data from backend
        const applications = @json($applications);
        let filteredApplications = [...applications];
        let selectionFilteredCandidates = [...applications];
        
        // Selection steps configuration
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

        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching for pending accounts
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

            // Selection mode toggle
            const toggleButton = document.getElementById('toggleSelectionMode');
            const toggleButtonText = document.getElementById('toggleButtonText');
            const regularView = document.getElementById('regularView');
            const selectionView = document.getElementById('selectionView');

            // Search functionality for regular view
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
                    renderApplicationTable();
                });
            }

            // Search functionality for selection mode
            const selectionSearchInput = document.getElementById('selectionSearch');
            if (selectionSearchInput) {
                selectionSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    if (searchTerm === '') {
                        selectionFilteredCandidates = [...applications];
                    } else {
                        selectionFilteredCandidates = applications.filter(app =>
                            app.name.toLowerCase().includes(searchTerm) ||
                            app.gender.toLowerCase().includes(searchTerm) ||
                            app.course.toLowerCase().includes(searchTerm)
                        );
                    }
                    renderCandidates();
                });
            }

            // Initial render of application table
            renderApplicationTable();

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

            // Step navigation
            const prevButton = document.getElementById('prevStep');
            const nextButton = document.getElementById('nextStep');

            if (prevButton) {
                prevButton.addEventListener('click', function() {
                    if (currentStep > 0) {
                        currentStep--;
                        updateStepDisplay();
                        renderCandidates();
                    }
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function() {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        updateStepDisplay();
                        renderCandidates();
                    }
                });
            }
        });

        function updateStepDisplay() {
            const currentStepTitle = document.getElementById('currentStepTitle');
            const currentStepDescription = document.getElementById('currentStepDescription');
            const prevButton = document.getElementById('prevStep');
            const nextButton = document.getElementById('nextStep');
            const endSelectionContainer = document.getElementById('endSelectionContainer');

            // Update title and description
            currentStepTitle.textContent = steps[currentStep].title;
            currentStepDescription.textContent = steps[currentStep].description;

            // Update button states
            prevButton.disabled = currentStep === 0;
            
            if (currentStep === steps.length - 1) {
                nextButton.classList.add('hidden');
                endSelectionContainer.classList.remove('hidden');
            } else {
                nextButton.classList.remove('hidden');
                endSelectionContainer.classList.add('hidden');
            }

            // Update progress indicators
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

            if (currentStep === 0) {
                return candidates;
            }

            // Filter candidates based on previous steps
            return candidates.filter(app => {
                for (let i = 0; i < currentStep; i++) {
                    const field = steps[i].field;
                    if (app[field] !== 'passed') {
                        return false;
                    }
                }
                return true;
            });
        }

        function renderCandidates() {
            const tableBody = document.getElementById('candidatesTableBody');
            const filteredCandidates = getFilteredCandidates();
            const currentField = steps[currentStep].field;

            tableBody.innerHTML = '';

            if (filteredCandidates.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-400 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="font-medium">No candidates remaining</p>
                            <p class="text-sm">All candidates have been filtered out from previous steps</p>
                        </td>
                    </tr>
                `;
                return;
            }

            filteredCandidates.forEach((application, index) => {
                const status = application[currentField] || 'pending';
                const isPassed = status === 'passed';
                const isFailed = status === 'failed';

                const row = document.createElement('tr');
                row.className = isFailed ? 'bg-red-50' : (isPassed ? 'bg-green-50' : '');
                row.innerHTML = `
                    <td class="px-4 py-2 whitespace-nowrap">
                        <input type="checkbox"
                               class="w-5 h-5 text-green-600 rounded focus:ring-green-500"
                               data-app-id="${application.id}"
                               ${isPassed ? 'checked' : ''}>
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">${index + 1}</td>
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

                // Add checkbox event listener
                const checkbox = row.querySelector('input[type="checkbox"]');
                checkbox.addEventListener('change', function() {
                    const newStatus = this.checked ? 'passed' : 'failed';
                    updateStatus(application.id, steps[currentStep].name, newStatus);
                });
            });
        }

        function renderApplicationTable() {
            const tableBody = document.getElementById('applicationTableBody');
            tableBody.innerHTML = '';

            if (filteredApplications.length === 0) {
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
                return;
            }

            filteredApplications.forEach((application, index) => {
                const isComplete = application.drill_test === 'passed' && application.physical_test === 'passed' && application.medical_test === 'passed' && application.interview === 'passed';
                const hasFailed = application.drill_test === 'failed' || application.physical_test === 'failed' || application.medical_test === 'failed' || application.interview === 'failed';

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-4 py-2 whitespace-nowrap text-sm">${index + 1}</td>
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
                    // Update local data
                    const app = applications.find(a => a.id === applicationId);
                    if (app) {
                        app[steps[currentStep].field] = status;
                    }

                    // Re-render candidates
                    renderCandidates();
                } else {
                    alert('Failed to update status. Please try again.');
                }
            } catch (error) {
                console.error('Error updating status:', error);
                alert('An error occurred. Please try again.');
            }
        }
    </script>

    {{-- ================================================================ --}}
    {{-- TAB SWITCHING JAVASCRIPT (Original) --}}
    {{-- ================================================================ --}}
    <script>
        // This script is kept for backward compatibility if needed
    </script>
</x-app-layout>