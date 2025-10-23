<x-app-layout>
    {{-- ================================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================================ --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance (Cadet)') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE TITLE SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-3 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Attendance Portal
                </h1>
                <p class="text-gray-600 text-lg">Mark your attendance and manage absence records</p>
            </div>

            {{-- ================================================================ --}}
            {{-- TODAY'S TRAINING SESSIONS --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                
                {{-- Section Header --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Current Training Sessions
                    </h2>
                    <p class="text-gray-600">Mark your attendance for active training sessions</p>
                </div>
                
                {{-- Section Content --}}
                <div class="p-8">
                    @if(isset($todaysTrainings) && $todaysTrainings->count() > 0)
                        <div class="space-y-6">
                            @foreach($todaysTrainings as $training)
                                @php
                                    $attendance = \App\Models\TrainingAttendance::where('training_id', $training->id)
                                        ->where('cadet_id', $cadet->id)
                                        ->first();
                                @endphp
                                
                                <div class="p-6 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border-l-4 border-blue-500 hover:shadow-lg transition-all duration-200">
                                    
                                    {{-- Training Info --}}
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-xl font-bold text-gray-800 mb-3">{{ $training->title }}</h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-600">
                                                <div class="flex items-center">
                                                    <i class="fas fa-map-marker-alt w-5 text-red-500 mr-3"></i>
                                                    <span class="font-medium">{{ $training->location }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock w-5 text-green-500 mr-3"></i>
                                                    @if($training->end_datetime && $training->start_datetime->toDateString() !== $training->end_datetime->toDateString())
                                                        <span>{{ $training->start_datetime->format('M d, Y') }} - {{ $training->end_datetime->format('M d, Y') }}</span>
                                                        <span class="mx-2 text-gray-400">|</span>
                                                        <span>{{ $training->formatted_start_time }} - {{ $training->end_datetime->format('h:i A') }}</span>
                                                    @else
                                                        <span>{{ $training->formatted_start_date }} at {{ $training->formatted_start_time }}</span>
                                                        @if($training->end_datetime)
                                                            <span class="ml-2 text-gray-500">- {{ $training->end_datetime->format('h:i A') }}</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                @if($training->involvement)
                                                    <div class="flex items-center">
                                                        <i class="fas fa-users w-5 text-purple-500 mr-3"></i>
                                                        <span>{{ $training->involvement }}</span>
                                                    </div>
                                                @endif
                                                @if($training->description)
                                                    <div class="flex items-start md:col-span-2">
                                                        <i class="fas fa-info-circle w-5 text-blue-500 mr-3 mt-1"></i>
                                                        <span>{{ $training->description }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        {{-- Status Badges --}}
                                        <div class="ml-6 flex flex-col gap-2">
                                            <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                                                {{ $training->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $training->status }}
                                            </span>
                                            @if($training->start_datetime->isYesterday())
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                    Yesterday
                                                </span>
                                            @elseif($training->start_datetime->isToday())
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                    Today
                                                </span>
                                            @endif
                                            @if($training->end_datetime && $training->start_datetime->toDateString() !== $training->end_datetime->toDateString())
                                                @php
                                                    $days = $training->start_datetime->diffInDays($training->end_datetime) + 1;
                                                @endphp
                                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                    {{ $days }}-Day Training
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Attendance Action --}}
                                    @if(!$attendance || !$attendance->present)
                                        <div class="pt-4 border-t border-gray-200 space-y-4">
                                            {{-- Interactive Map --}}
                                            <div class="bg-white rounded-lg border-2 border-blue-200 overflow-hidden">
                                                <div class="bg-blue-50 px-4 py-2 border-b border-blue-200">
                                                    <h4 class="font-semibold text-blue-900 flex items-center">
                                                        <i class="fas fa-map-marked-alt mr-2"></i>
                                                        Location Verification Map
                                                    </h4>
                                                </div>
                                                <div id="map-{{ $training->id }}" class="w-full h-80"></div>
                                                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                                                    <div class="flex items-center justify-between text-sm">
                                                        <div class="flex items-center gap-4">
                                                            <div class="flex items-center">
                                                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                                                <span class="text-gray-700">Meetup Location</span>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                                                <span class="text-gray-700">Your Location</span>
                                                            </div>
                                                            <div class="flex items-center">
                                                                <div class="w-3 h-3 bg-green-200 border-2 border-green-500 rounded-full mr-2"></div>
                                                                <span class="text-gray-700">Allowed Zone ({{ $geofence['radius'] }}m radius)</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Attendance Form --}}
                                            <form method="POST" action="{{ route('cadet.attendance.mark') }}" class="w-full">
                                                @csrf
                                                <input type="hidden" name="training_id" value="{{ $training->id }}">
                                                {{-- Location inputs will be added by JavaScript --}}
                                                
                                                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center">
                                                    <i class="fas fa-hand-paper text-xl mr-3"></i>
                                                    Mark Present
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="pt-4 border-t border-gray-200">
                                            <div class="bg-green-50 border border-green-200 rounded-xl p-6 text-center">
                                                <div class="inline-flex items-center text-green-800">
                                                    <i class="fas fa-check-circle text-3xl mr-4"></i>
                                                    <div class="text-left">
                                                        <div class="text-lg font-semibold">Attendance Confirmed</div>
                                                        <div class="text-sm text-green-600 mt-1">
                                                            Marked present at {{ $attendance->marked_at->format('g:i A') }}
                                                        </div>
                                                        @if($attendance->latitude && $attendance->longitude)
                                                            <div class="text-xs text-green-500 mt-1">
                                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                                Location verified
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="mb-6">
                                <svg class="w-20 h-20 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-600 mb-3">No Training Sessions</h3>
                            <p class="text-gray-500 text-lg">There are no training sessions scheduled for today. Enjoy your day!</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ABSENCE RECORDS SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                
                {{-- Section Header --}}
                <div class="bg-gradient-to-r from-orange-50 to-red-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        Absence Records
                        @if($absentAttendances->count() > 0)
                            <span class="ml-3 bg-red-500 text-white text-sm px-3 py-1 rounded-full">
                                {{ $absentAttendances->count() }}
                            </span>
                        @endif
                    </h2>
                    <p class="text-gray-600">Submit reasons for your absences with supporting documentation</p>
                </div>
                
                {{-- Section Content --}}
                <div class="p-6">
                    @if($absentAttendances->count() > 0)
                        
                        {{-- Filter Section --}}
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-800 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                                    </svg>
                                    Quick Navigation
                                </span>
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Pending Submissions
                                    </label>
                                    <div class="bg-orange-100 border border-orange-200 rounded-lg p-3">
                                        <p class="text-sm text-orange-800">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            {{ $absentAttendances->count() }} absence record{{ $absentAttendances->count() > 1 ? 's' : '' }} requiring attention
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="absenceDropdown" class="block text-sm font-medium text-gray-700">
                                        Jump to Specific Absence
                                    </label>
                                    <select id="absenceDropdown"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white"
                                            onchange="openAbsenceRecord(this.value)">
                                        <option value="">Choose an absence record...</option>
                                        @foreach($absentAttendances as $attendance)
                                            <option value="absence-{{ $attendance->id }}">{{ $attendance->training->title }} - {{ $attendance->training->formatted_start_date }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Absence Records Accordion --}}
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="font-medium text-gray-800 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Absence Submissions
                                </span>
                            </h4>

                            <div id="absenceContainer">
                                @foreach($absentAttendances as $attendance)
                                    <div id="absence-{{ $attendance->id }}" x-data="{ open: false }" class="border border-orange-200 rounded-lg mb-4">
                                        
                                        {{-- Accordion Header --}}
                                        <button @click="open = !open"
                                                class="w-full flex justify-between items-center px-6 py-4 bg-orange-100 hover:bg-orange-200 text-left text-orange-800 font-medium text-lg rounded-t-lg">
                                            <div class="flex items-center">
                                                <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                                                <div>
                                                    <div class="font-semibold">{{ $attendance->training->title }}</div>
                                                    <div class="text-sm text-orange-600 font-normal">{{ $attendance->training->formatted_start_date }} at {{ $attendance->training->formatted_start_time }}</div>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold mr-3">
                                                    Absent
                                                </span>
                                                <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </button>
                                        
                                        {{-- Accordion Content --}}
                                        <div x-show="open" x-transition class="p-6 bg-white rounded-b-lg border-t">
                                            
                                            {{-- Training Details --}}
                                            <div class="mb-6">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600 text-sm">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-map-marker-alt w-4 text-red-500 mr-3"></i>
                                                        <span><strong>Location:</strong> {{ $attendance->training->location }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-calendar w-4 text-blue-500 mr-3"></i>
                                                        <span><strong>Date:</strong> {{ $attendance->training->formatted_start_date }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-clock w-4 text-green-500 mr-3"></i>
                                                        <span><strong>Time:</strong> {{ $attendance->training->formatted_start_time }}</span>
                                                    </div>
                                                    @if($attendance->training->involvement)
                                                        <div class="flex items-center">
                                                            <i class="fas fa-users w-4 text-purple-500 mr-3"></i>
                                                            <span><strong>Involvement:</strong> {{ $attendance->training->involvement }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Absence Form --}}
                                            <form method="POST" action="{{ route('cadet.attendance.absence', $attendance->id) }}" 
                                                  enctype="multipart/form-data" class="space-y-6">
                                                @csrf
                                                
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700 mb-3">
                                                        <i class="fas fa-comment-alt mr-2 text-blue-500"></i>
                                                        Reason for Absence <span class="text-red-500">*</span>
                                                    </label>
                                                    <textarea 
                                                        name="absence_reason" 
                                                        required 
                                                        placeholder="Please provide a detailed explanation for your absence (minimum 10 characters)"
                                                        class="w-full px-4 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none text-sm"
                                                        rows="4"
                                                        maxlength="500"
                                                        oninput="updateCharCount(this, 'char-count-{{ $attendance->id }}')"
                                                    >{{ old('absence_reason') }}</textarea>
                                                    <div class="flex justify-between items-center mt-2">
                                                        <div class="text-xs text-gray-500">
                                                            Character count: <span id="char-count-{{ $attendance->id }}" class="font-semibold">0</span>/500
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            Minimum 10 characters required
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700 mb-3">
                                                        <i class="fas fa-paperclip mr-2 text-green-500"></i>
                                                        Supporting Documentation <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="relative">
                                                        <input 
                                                            type="file" 
                                                            name="supporting_file" 
                                                            required 
                                                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                                            class="w-full px-4 py-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition-all duration-200"
                                                        >
                                                    </div>
                                                    <div class="text-xs text-gray-500 mt-2 flex items-center">
                                                        <i class="fas fa-info-circle mr-1 text-blue-400"></i>
                                                        Accepted formats: JPG, PNG, PDF, DOC, DOCX • Maximum file size: 5MB
                                                    </div>
                                                </div>
                                                
                                                <div class="pt-4 border-t border-orange-200">
                                                    <button type="submit" 
                                                            class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-8 py-4 rounded-xl font-semibold text-lg shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center">
                                                        <i class="fas fa-paper-plane text-xl mr-3"></i>
                                                        Submit Absence Information
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="mb-6">
                                <svg class="w-20 h-20 text-green-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-600 mb-3">All Clear!</h3>
                            <p class="text-gray-500 text-lg">You have no pending absence records that require attention.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- SUCCESS/ERROR MESSAGES --}}
    {{-- ================================================================ --}}
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-xl mr-3"></i>
                <div>
                    <div class="font-semibold">Success!</div>
                    <div class="text-sm">{{ session('success') }}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 animate-slide-in">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                <div>
                    <div class="font-semibold">Error!</div>
                    <div class="text-sm">{{ session('error') }}</div>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div id="validation-errors" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 max-w-sm animate-slide-in">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-xl mr-3 mt-1"></i>
                <div>
                    <div class="font-semibold mb-2">Validation Errors:</div>
                    <ul class="text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start">
                                <i class="fas fa-circle text-xs mr-2 mt-1"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- ================================================================ --}}
    {{-- CUSTOM STYLES --}}
    {{-- ================================================================ --}}
    @push('styles')
        <style>
            .animate-slide-in {
                animation: slideIn 0.3s ease-out;
            }
            
            @keyframes slideIn {
                0% { 
                    opacity: 0; 
                    transform: translateX(100%); 
                }
                100% { 
                    opacity: 1; 
                    transform: translateX(0); 
                }
            }
            
            input[type="file"]::-webkit-file-upload-button {
                transition: all 0.2s ease;
            }
            
            button, .hover\:shadow-lg, .hover\:shadow-xl {
                transition: all 0.2s ease;
            }

            .char-count-warning {
                color: #f59e0b;
            }
            
            .char-count-danger {
                color: #ef4444;
            }

            /* Leaflet map custom styles */
            .leaflet-container {
                font-family: inherit;
                height: 320px;
                width: 100%;
                z-index: 1;
            }

            /* Fix for missing tiles */
            .leaflet-tile-container {
                opacity: 1 !important;
            }

            .leaflet-tile {
                opacity: 1 !important;
            }

            .distance-line {
                stroke-dasharray: 5, 5;
                animation: dash 20s linear infinite;
            }

            @keyframes dash {
                to {
                    stroke-dashoffset: -100;
                }
            }

            .pulse-marker {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.5;
                }
            }
        </style>
    @endpush

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    @push('scripts')
        <script>
            // ================================================================
            // GEOFENCING ATTENDANCE SYSTEM WITH INTERACTIVE MAP
            // ================================================================
            
            // Wait for Leaflet to be fully loaded
            function initializeAttendanceMaps() {
                if (typeof L === 'undefined') {
                    console.error('Leaflet not loaded, retrying...');
                    setTimeout(initializeAttendanceMaps, 100);
                    return;
                }

                console.log('Leaflet loaded successfully');

                const geofence = {
                    latitude: {{ $geofence['latitude'] }},
                    longitude: {{ $geofence['longitude'] }},
                    radius: {{ $geofence['radius'] }}
                };

                let userLocation = null;
                const maps = {};

                console.log('Looking for attendance forms...');
                // More specific selector - find forms with training_id input
                const forms = document.querySelectorAll('form[action*="attendance/mark"]');
                console.log('Found', forms.length, 'attendance form(s)');

                // Additional debugging
                const allForms = document.querySelectorAll('form');
                console.log('Total forms on page:', allForms.length);
                allForms.forEach((f, i) => {
                    const action = f.getAttribute('action');
                    const hasTrainingId = f.querySelector('input[name="training_id"]');
                    console.log(`Form ${i + 1} action:`, action, '| Has training_id:', !!hasTrainingId);
                });

                const trainingSections = document.querySelectorAll('.p-6.bg-gradient-to-r.from-gray-50.to-blue-50');
                console.log('Training session cards found:', trainingSections.length);

                const attendanceConfirmed = document.querySelectorAll('.bg-green-50.border.border-green-200');
                console.log('Already marked attendance sections:', attendanceConfirmed.length);

                if (forms.length === 0) {
                    console.warn('⚠️ No attendance forms found. Possible reasons:');
                    console.warn('1. No training sessions scheduled for today');
                    console.warn('2. Attendance already marked for all sessions');
                    console.warn('3. Training sessions are not active/eligible');
                    console.warn('Check the page - do you see any "Mark Present" buttons?');
                }

                // Process all attendance forms on the page
                forms.forEach((form, index) => {
                    console.log('Processing form', index + 1);
                    const button = form.querySelector('button[type="submit"]');
                    const trainingCard = form.closest('.p-6');
                    const trainingIdInput = form.querySelector('input[name="training_id"]');
                    const trainingId = trainingIdInput ? trainingIdInput.value : index;
                    const mapContainer = document.getElementById(`map-${trainingId}`);
                    
                    console.log('Training ID:', trainingId);
                    console.log('Map container element:', mapContainer);
                    console.log('Button element:', button);
                    console.log('Training card:', trainingCard);
                    
                    if (!mapContainer) {
                        console.error('❌ Map container not found for training:', trainingId);
                        console.error('Looking for element with ID: map-' + trainingId);
                        return;
                    }

                    if (!button) {
                        console.error('❌ Submit button not found');
                        return;
                    }

                    if (!trainingCard) {
                        console.error('❌ Training card container not found');
                        return;
                    }

                    console.log('✅ All required elements found, proceeding with map initialization...');

                    // Create status message div
                    let statusDiv = trainingCard.querySelector('.location-status');
                    if (!statusDiv) {
                        statusDiv = document.createElement('div');
                        statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2';
                        button.parentNode.insertBefore(statusDiv, button);
                    }

                    // Disable button initially
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');

                    try {
                        // Initialize map
                        const map = L.map(mapContainer, {
                            center: [geofence.latitude, geofence.longitude],
                            zoom: 16,
                            zoomControl: true,
                            scrollWheelZoom: false,
                            attributionControl: true
                        });

                        console.log('Map created successfully');

                        // Add OpenStreetMap tiles with error handling
                        const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            maxZoom: 19,
                            minZoom: 10
                        });

                        tileLayer.on('tileerror', function(error) {
                            console.error('Tile loading error:', error);
                        });

                        tileLayer.on('tileload', function() {
                            console.log('Tiles loading...');
                        });

                        tileLayer.addTo(map);

                        // Force map to refresh
                        setTimeout(() => {
                            map.invalidateSize();
                            console.log('Map size invalidated');
                        }, 100);

                        // Add geofence circle (allowed zone)
                        const geofenceCircle = L.circle([geofence.latitude, geofence.longitude], {
                            color: '#10b981',
                            fillColor: '#10b981',
                            fillOpacity: 0.15,
                            radius: geofence.radius,
                            weight: 2
                        }).addTo(map);

                        // Add meetup location marker
                        const meetupIcon = L.divIcon({
                            html: '<div class="bg-red-500 w-8 h-8 rounded-full border-4 border-white shadow-lg flex items-center justify-center"><i class="fas fa-flag text-white text-xs"></i></div>',
                            iconSize: [32, 32],
                            iconAnchor: [16, 16],
                            className: 'pulse-marker'
                        });

                        const meetupMarker = L.marker([geofence.latitude, geofence.longitude], {
                            icon: meetupIcon
                        }).addTo(map);
                        meetupMarker.bindPopup('<b>Meetup Location</b><br>You must be within ' + geofence.radius + 'm of this point.');

                        maps[trainingId] = {
                            map: map,
                            geofenceCircle: geofenceCircle,
                            userMarker: null,
                            distanceLine: null
                        };

                        console.log('Map elements added successfully');

                    } catch (error) {
                        console.error('Error initializing map:', error);
                        statusDiv.innerHTML = `<div class="text-red-600"><i class="fas fa-exclamation-circle mr-2"></i>Map initialization failed. Please refresh the page.</div>`;
                        statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300';
                        return;
                    }

                    // Check geolocation support
                    if (!navigator.geolocation) {
                        showError(statusDiv, 'Geolocation is not supported by your browser.');
                        console.error('Geolocation not supported');
                        return;
                    }

                    // Get user location
                    statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <strong>Verifying your location...</strong><br><span class="text-xs">Please wait while we check your position</span>';
                    statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-blue-50 border-blue-300 text-blue-800';

                    console.log('Requesting geolocation...');

                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            userLocation = {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                                accuracy: position.coords.accuracy
                            };

                            console.log('User location obtained:', userLocation);
                            console.log('GPS Accuracy:', userLocation.accuracy, 'meters');

                            const distance = calculateDistance(
                                geofence.latitude,
                                geofence.longitude,
                                userLocation.latitude,
                                userLocation.longitude
                            );

                            console.log('Distance from meetup:', distance);

                            // Add user marker to map
                            const userIcon = L.divIcon({
                                html: '<div class="bg-blue-500 w-8 h-8 rounded-full border-4 border-white shadow-lg flex items-center justify-center"><i class="fas fa-user text-white text-xs"></i></div>',
                                iconSize: [32, 32],
                                iconAnchor: [16, 16],
                                className: ''
                            });

                            maps[trainingId].userMarker = L.marker([userLocation.latitude, userLocation.longitude], {
                                icon: userIcon
                            }).addTo(maps[trainingId].map);
                            maps[trainingId].userMarker.bindPopup('<b>Your Location</b><br>Distance: ' + Math.round(distance) + 'm from meetup');

                            // Add accuracy circle
                            L.circle([userLocation.latitude, userLocation.longitude], {
                                color: '#3b82f6',
                                fillColor: '#3b82f6',
                                fillOpacity: 0.1,
                                radius: userLocation.accuracy,
                                weight: 1,
                                dashArray: '3, 3'
                            }).addTo(maps[trainingId].map);

                            // Draw line between user and meetup point
                            maps[trainingId].distanceLine = L.polyline([
                                [geofence.latitude, geofence.longitude],
                                [userLocation.latitude, userLocation.longitude]
                            ], {
                                color: distance <= geofence.radius ? '#10b981' : '#ef4444',
                                weight: 2,
                                dashArray: '5, 5',
                                className: 'distance-line'
                            }).addTo(maps[trainingId].map);

                            // Fit map to show both markers
                            const bounds = L.latLngBounds([
                                [geofence.latitude, geofence.longitude],
                                [userLocation.latitude, userLocation.longitude]
                            ]);
                            maps[trainingId].map.fitBounds(bounds, { padding: [50, 50] });

                            if (distance <= geofence.radius) {
                                // SUCCESS - Within geofence
                                statusDiv.innerHTML = `
                                    <div class="flex items-start">
                                        <i class="fas fa-check-circle text-2xl mr-3"></i>
                                        <div>
                                            <strong class="block">✓ Location Verified!</strong>
                                            <span class="text-xs">You are <strong>${Math.round(distance)}m</strong> from the meetup point (within ${geofence.radius}m allowed zone)</span>
                                        </div>
                                    </div>
                                `;
                                statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-green-50 border-green-300 text-green-800';
                                
                                // Enable button
                                button.disabled = false;
                                button.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                                button.classList.add('bg-gradient-to-r', 'from-green-500', 'to-green-600', 'hover:from-green-600', 'hover:to-green-700');

                                // Add location to form
                                addLocationToForm(form, userLocation);

                                // Open user marker popup
                                setTimeout(() => {
                                    maps[trainingId].userMarker.openPopup();
                                }, 500);
                            } else {
                                // FAIL - Outside geofence
                                statusDiv.innerHTML = `
                                    <div class="flex items-start">
                                        <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                                        <div>
                                            <strong class="block">⚠ Outside Allowed Zone</strong>
                                            <span class="text-xs">You are <strong>${Math.round(distance)}m</strong> away. Please move closer to the meetup location (within ${geofence.radius}m)</span>
                                        </div>
                                    </div>
                                `;
                                statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300 text-red-800';
                                
                                // Keep button DISABLED
                                button.disabled = true;
                                button.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-400');
                                button.classList.remove('bg-gradient-to-r', 'from-green-500', 'to-green-600', 'hover:from-green-600', 'hover:to-green-700');

                                // Change button appearance to show it's locked
                                button.innerHTML = '<i class="fas fa-lock text-xl mr-3"></i> Location Required - Move Closer';
                                
                                // Add refresh button
                                const refreshBtn = document.createElement('button');
                                refreshBtn.type = 'button';
                                refreshBtn.className = 'mt-2 text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded';
                                refreshBtn.innerHTML = '<i class="fas fa-sync-alt mr-1"></i> Refresh Location';
                                refreshBtn.onclick = () => location.reload();
                                statusDiv.appendChild(refreshBtn);
                            }
                        },
                        (error) => {
                            console.error('Geolocation error:', error);
                            console.error('Error code:', error.code);
                            console.error('Error message:', error.message);
                            handleGeolocationError(error, statusDiv, maps[trainingId].map);
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );

                    // Prevent form submission if location not verified
                    form.addEventListener('submit', function(e) {
                        if (!userLocation || button.disabled) {
                            e.preventDefault();
                            alert('Please wait for location verification or enable location services.');
                            return false;
                        }
                    });
                });

                function addLocationToForm(form, location) {
                    // Remove old inputs if they exist
                    form.querySelectorAll('input[name="latitude"], input[name="longitude"]').forEach(el => el.remove());

                    // Add hidden inputs
                    const latInput = document.createElement('input');
                    latInput.type = 'hidden';
                    latInput.name = 'latitude';
                    latInput.value = location.latitude;
                    
                    const lonInput = document.createElement('input');
                    lonInput.type = 'hidden';
                    lonInput.name = 'longitude';
                    lonInput.value = location.longitude;
                    
                    form.appendChild(latInput);
                    form.appendChild(lonInput);
                }

                function calculateDistance(lat1, lon1, lat2, lon2) {
                    const R = 6371000; // Earth's radius in meters
                    const dLat = toRad(lat2 - lat1);
                    const dLon = toRad(lon2 - lon1);
                    
                    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                            Math.sin(dLon / 2) * Math.sin(dLon / 2);
                    
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                    
                    const distance = R * c;
                    
                    console.log('Distance Calculation:');
                    console.log('From:', lat1, lon1);
                    console.log('To:', lat2, lon2);
                    console.log('dLat:', dLat, 'dLon:', dLon);
                    console.log('a:', a, 'c:', c);
                    console.log('Distance:', distance, 'meters =', (distance/1000).toFixed(2), 'km');
                    
                    return distance;
                }

                function toRad(degrees) {
                    return degrees * (Math.PI / 180);
                }

                function showError(statusDiv, message) {
                    statusDiv.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                            <div>
                                <strong class="block">Location Error</strong>
                                <span class="text-xs">${message}</span>
                            </div>
                        </div>
                    `;
                    statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300 text-red-800';
                }

                function handleGeolocationError(error, statusDiv, map) {
                    let message = '';
                    let instructions = '';
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Location permission denied.';
                            instructions = 'Please enable location access in your browser settings and refresh the page.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Location unavailable.';
                            instructions = 'Please check your device settings and ensure GPS is enabled.';
                            break;
                        case error.TIMEOUT:
                            message = 'Location request timed out.';
                            instructions = 'Please refresh the page to try again.';
                            break;
                        default:
                            message = 'An error occurred while getting your location.';
                            instructions = 'Please refresh the page and try again.';
                    }
                    
                    statusDiv.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                            <div>
                                <strong class="block">${message}</strong>
                                <span class="text-xs">${instructions}</span>
                            </div>
                        </div>
                    `;
                    statusDiv.className = 'location-status text-sm mb-3 p-3 rounded-lg border-2 bg-red-50 border-red-300 text-red-800';
                    
                    // Add retry button
                    const retryBtn = document.createElement('button');
                    retryBtn.type = 'button';
                    retryBtn.className = 'mt-2 text-xs bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded';
                    retryBtn.innerHTML = '<i class="fas fa-redo mr-1"></i> Retry';
                    retryBtn.onclick = () => location.reload();
                    statusDiv.appendChild(retryBtn);
                }
            }

            // Initialize when DOM and Leaflet are ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeAttendanceMaps);
            } else {
                initializeAttendanceMaps();
            }

            // ================================================================
            // ABSENCE RECORD NAVIGATION
            // ================================================================
            function openAbsenceRecord(absenceId) {
                if (absenceId) {
                    const element = document.getElementById(absenceId);
                    if (element) {
                        element.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });

                        setTimeout(() => {
                            const button = element.querySelector('button');
                            if (button) {
                                const isOpen = element.querySelector('[x-data]').__x.$data.open;
                                if (!isOpen) {
                                    button.click();
                                }
                            }
                        }, 500);
                    }

                    document.getElementById('absenceDropdown').value = '';
                }
            }

            // ================================================================
            // CHARACTER COUNTER
            // ================================================================
            function updateCharCount(textarea, counterId) {
                const counter = document.getElementById(counterId);
                if (counter) {
                    const length = textarea.value.length;
                    counter.textContent = length;
                    
                    counter.classList.remove('text-gray-500', 'char-count-warning', 'char-count-danger');
                    
                    if (length > 450) {
                        counter.classList.add('char-count-danger');
                    } else if (length > 350) {
                        counter.classList.add('char-count-warning');
                    } else {
                        counter.classList.add('text-gray-500');
                    }
                }
            }

            // ================================================================
            // INITIALIZATION
            // ================================================================
            document.addEventListener('DOMContentLoaded', function() {
                const textareas = document.querySelectorAll('textarea[name="absence_reason"]');
                textareas.forEach(textarea => {
                    const form = textarea.closest('form');
                    const actionUrl = form.getAttribute('action');
                    const attendanceId = actionUrl.split('/').pop();
                    const counterId = `char-count-${attendanceId}`;
                    updateCharCount(textarea, counterId);
                });

                const hasErrors = {{ $errors->any() ? 'true' : 'false' }};
                if (hasErrors) {
                    // Wait for Alpine.js to initialize before accessing x-data
                    setTimeout(() => {
                        const firstAccordion = document.querySelector('[id^="absence-"]');
                        if (firstAccordion) {
                            const button = firstAccordion.querySelector('button');
                            const alpineElement = firstAccordion.querySelector('[x-data]');
                            
                            // Check if Alpine has initialized and accordion is closed
                            if (button && alpineElement && alpineElement.__x && !alpineElement.__x.$data.open) {
                                button.click();
                            } else if (button && (!alpineElement || !alpineElement.__x)) {
                                // Fallback if Alpine hasn't initialized yet - just click the button
                                button.click();
                            }
                        }
                    }, 100);
                }
            });

            // ================================================================
            // AUTO-HIDE NOTIFICATIONS
            // ================================================================
            @if(session('success'))
                setTimeout(() => {
                    const msg = document.getElementById('success-message');
                    if (msg) {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateX(100%)';
                        setTimeout(() => msg.remove(), 300);
                    }
                }, 5000);
            @endif

            @if(session('error'))
                setTimeout(() => {
                    const msg = document.getElementById('error-message');
                    if (msg) {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateX(100%)';
                        setTimeout(() => msg.remove(), 300);
                    }
                }, 5000);
            @endif

            @if($errors->any())
                setTimeout(() => {
                    const msg = document.getElementById('validation-errors');
                    if (msg) {
                        msg.style.opacity = '0';
                        msg.style.transform = 'translateX(100%)';
                        setTimeout(() => msg.remove(), 300);
                    }
                }, 8000);
            @endif
        </script>
    @endpush
</x-app-layout>