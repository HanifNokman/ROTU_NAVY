<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance (Cadet)') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-3 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Attendance Portal
                </h1>
                <p class="text-gray-600 text-lg">Mark your attendance and manage absence records</p>
            </div>

            <!-- Today's Training Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Current Training Sessions
                    </h2>
                    <p class="text-gray-600">Mark your attendance for active training sessions</p>
                </div>
                
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
                                                        <!-- Multi-day training -->
                                                        <span>{{ $training->start_datetime->format('M d, Y') }} - {{ $training->end_datetime->format('M d, Y') }}</span>
                                                        <span class="mx-2 text-gray-400">|</span>
                                                        <span>{{ $training->formatted_start_time }} - {{ $training->end_datetime->format('h:i A') }}</span>
                                                    @else
                                                        <!-- Single day training -->
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

                                    @if(!$attendance || !$attendance->present)
                                        <!-- Mark Present Button -->
                                        <div class="pt-4 border-t border-gray-200">
                                            <form method="POST" action="{{ route('cadet.attendance.mark') }}" class="w-full">
                                                @csrf
                                                <input type="hidden" name="training_id" value="{{ $training->id }}">
                                                <input type="hidden" name="method" value="manual">
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

            <!-- Absence Records Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-orange-50 to-red-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        Absence Records
                    </h2>
                    <p class="text-gray-600">Submit reasons for your absences with supporting documentation</p>
                </div>
                
                <div class="p-8">
                    @if($absentAttendances->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-orange-50 to-red-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        Absence Records
                    </h2>
                    <p class="text-gray-600">Submit reasons for your absences with supporting documentation</p>
                </div>
                
                <div class="p-8">
                    <div class="space-y-6">
                        @foreach($absentAttendances as $attendance)
                            <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 hover:shadow-lg transition-all duration-200">
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex-1">
                                        <h4 class="text-xl font-bold text-gray-800 mb-3">{{ $attendance->training->title }}</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-gray-600">
                                            <div class="flex items-center">
                                                <i class="fas fa-map-marker-alt w-4 text-red-500 mr-3"></i>
                                                <span>{{ $attendance->training->location }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-clock w-4 text-green-500 mr-3"></i>
                                                <span>{{ $attendance->training->formatted_start_date }} at {{ $attendance->training->formatted_start_time }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="bg-red-100 text-red-800 px-4 py-2 rounded-full text-sm font-bold">
                                        Absent
                                    </span>
                                </div>

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
                                            onInput="updateCharCount(this, 'char-count-{{ $attendance->id }}')"
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
                        @endforeach
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

    <!-- Success/Error Messages -->
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
        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateX(100%)';
                    setTimeout(() => msg.remove(), 300);
                }
            }, 5000);
        </script>
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
        <script>
            setTimeout(() => {
                const msg = document.getElementById('error-message');
                if (msg) {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateX(100%)';
                    setTimeout(() => msg.remove(), 300);
                }
            }, 5000);
        </script>
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
        <script>
            setTimeout(() => {
                const msg = document.getElementById('validation-errors');
                if (msg) {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateX(100%)';
                    setTimeout(() => msg.remove(), 300);
                }
            }, 8000);
        </script>
    @endif

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
        
        /* Custom file input styling */
        input[type="file"]::-webkit-file-upload-button {
            transition: all 0.2s ease;
        }
        
        /* Smooth transitions for all interactive elements */
        button, .hover\:shadow-lg, .hover\:shadow-xl {
            transition: all 0.2s ease;
        }

        /* Character count color changes */
        .char-count-warning {
            color: #f59e0b;
        }
        
        .char-count-danger {
            color: #ef4444;
        }
    </style>

    <script>
        // Character counter function with better visual feedback
        function updateCharCount(textarea, counterId) {
            const counter = document.getElementById(counterId);
            if (counter) {
                const length = textarea.value.length;
                counter.textContent = length;
                
                // Remove all classes first
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

        // Initialize character counters on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('textarea[name="absence_reason"]');
            textareas.forEach(textarea => {
                // Extract attendance ID from the form action URL
                const form = textarea.closest('form');
                const actionUrl = form.getAttribute('action');
                const attendanceId = actionUrl.split('/').pop();
                const counterId = `char-count-${attendanceId}`;
                updateCharCount(textarea, counterId);
            });
        });
    </script>
</x-app-layout>