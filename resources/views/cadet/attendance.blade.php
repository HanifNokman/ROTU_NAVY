<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance (Cadet)') }}
        </h2>
    </x-slot>

    <!-- Include required external resources -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header Section -->
            <div class="text-center animate-fade-in">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <i class="fas fa-clipboard-check text-blue-600 mr-3"></i>
                    Attendance Portal
                </h1>
                <p class="text-gray-600">Mark your attendance and manage absence records</p>
            </div>

            <!-- Today's Training Section -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6">
                    <h2 class="text-2xl font-semibold mb-2">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Today's Training
                    </h2>
                    <p class="text-blue-100">Current training session</p>
                </div>
                
                <div class="p-8">
                    @if(isset($todaysTrainings) && $todaysTrainings->count() > 0)
                        @foreach($todaysTrainings as $training)
                            @php
                                $attendance = \App\Models\TrainingAttendance::where('training_id', $training->id)
                                    ->where('cadet_id', $cadet->id)
                                    ->first();
                            @endphp
                            <div class="mb-6 p-6 bg-gray-50 rounded-xl border-l-4 border-blue-500">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $training->title }}</h3>
                                        <div class="space-y-2 text-gray-600">
                                            <div class="flex items-center">
                                                <i class="fas fa-map-marker-alt w-5 text-red-500 mr-2"></i>
                                                <span>{{ $training->location }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-clock w-5 text-green-500 mr-2"></i>
                                                <span>{{ $training->formatted_start_date }} at {{ $training->formatted_start_time }}</span>
                                            </div>
                                            @if($training->description)
                                                <div class="flex items-start">
                                                    <i class="fas fa-info-circle w-5 text-blue-500 mr-2 mt-1"></i>
                                                    <span>{{ $training->description }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-6 flex flex-col gap-2">
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
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
                                    </div>
                                </div>

                                @if(!$attendance || !$attendance->present)
                                    <div class="flex flex-col sm:flex-row gap-4">
                                        <!-- Manual Attendance Button -->
                                        <form method="POST" action="{{ route('cadet.attendance.mark') }}" class="flex-1">
                                            @csrf
                                            <input type="hidden" name="training_id" value="{{ $training->id }}">
                                            <input type="hidden" name="method" value="manual">
                                            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                                                <i class="fas fa-hand-paper mr-2"></i>
                                                Mark Present
                                            </button>
                                        </form>

                                        <!-- QR Scanner Button -->
                                        <button onclick="openQRScanner({{ $training->id }})" class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                                            <i class="fas fa-qrcode mr-2"></i>
                                            Scan QR Code
                                        </button>
                                    </div>
                                @else
                                    <div class="text-center py-6">
                                        <div class="inline-flex items-center px-6 py-3 bg-green-100 text-green-800 rounded-xl font-semibold">
                                            <i class="fas fa-check-circle text-2xl mr-3"></i>
                                            <div>
                                                <div>You have marked yourself present!</div>
                                                <div class="text-sm text-green-600 mt-1">
                                                    Marked at {{ $attendance->marked_at->format('g:i A') }} via {{ ucfirst($attendance->method) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Training Today</h3>
                            <p class="text-gray-500">There's no training scheduled for today. Enjoy your day off!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Absence Records Section -->
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border border-gray-100">
                <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white p-6">
                    <h2 class="text-2xl font-semibold mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Absence Records
                    </h2>
                    <p class="text-orange-100">Submit reasons for your absences</p>
                </div>
                
                <div class="p-8">
                    @if($absentAttendances->count() > 0)
                        <div class="space-y-6">
                            @foreach($absentAttendances as $attendance)
                                <div class="bg-orange-50 border border-orange-200 rounded-xl p-6 hover:shadow-lg transition-shadow duration-200">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-800 mb-2">{{ $attendance->training->title }}</h4>
                                            <div class="space-y-1 text-gray-600">
                                                <div class="flex items-center">
                                                    <i class="fas fa-map-marker-alt w-4 text-red-500 mr-2"></i>
                                                    <span class="text-sm">{{ $attendance->training->location }}</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <i class="fas fa-clock w-4 text-green-500 mr-2"></i>
                                                    <span class="text-sm">{{ $attendance->training->formatted_start_date }} at {{ $attendance->training->formatted_start_time }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            Absent
                                        </span>
                                    </div>

                                    <form method="POST" action="{{ route('cadet.attendance.absence', $attendance->id) }}" 
                                          enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-comment-alt mr-1"></i>
                                                Reason for Absence <span class="text-red-500">*</span>
                                            </label>
                                            <textarea 
                                                name="absence_reason" 
                                                required 
                                                placeholder="Please provide a detailed reason for your absence (minimum 10 characters)"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                                rows="3"
                                                maxlength="500"
                                                onInput="updateCharCount(this, 'char-count-{{ $attendance->id }}')"
                                            >{{ old('absence_reason') }}</textarea>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Character count: <span id="char-count-{{ $attendance->id }}">0</span>/500
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fas fa-paperclip mr-1"></i>
                                                Supporting File <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <input 
                                                    type="file" 
                                                    name="supporting_file" 
                                                    required 
                                                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100"
                                                >
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Accepted formats: JPG, PNG, PDF, DOC, DOCX (Max 5MB)
                                            </div>
                                        </div>
                                        
                                        <button type="submit" 
                                                class="w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white px-6 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-[1.02] transition-all duration-200 flex items-center justify-center">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Submit Reason & File
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class="fas fa-check-circle text-6xl text-green-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">All Clear!</h3>
                            <p class="text-gray-500">You have no pending absence records that require attention.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- QR Scanner Modal -->
    <div id="qr-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 flex items-center justify-between">
                <h3 class="text-xl font-semibold">
                    <i class="fas fa-qrcode mr-2"></i>
                    Scan QR Code
                </h3>
                <button onclick="closeQRScanner()" class="text-white hover:text-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6">
                <div id="qr-reader" class="rounded-lg overflow-hidden mb-4"></div>
                <div id="qr-status" class="text-center text-gray-600">
                    Position the QR code within the camera view
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div id="success-message" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('success-message');
                if (msg) msg.remove();
            }, 5000);
        </script>
    @endif

    @if(session('error'))
        <div id="error-message" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('error-message');
                if (msg) msg.remove();
            }, 5000);
        </script>
    @endif

    @if($errors->any())
        <div id="validation-errors" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle mr-2 mt-1"></i>
                <div>
                    <div class="font-semibold mb-2">Please fix the following errors:</div>
                    <ul class="text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                const msg = document.getElementById('validation-errors');
                if (msg) msg.remove();
            }, 8000);
        </script>
    @endif

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        
        .animate-slide-up {
            animation: slideUp 0.3s ease-out;
        }
        
        @keyframes slideUp {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        
        /* Custom file input styling */
        input[type="file"]::-webkit-file-upload-button {
            transition: all 0.2s ease;
        }
        
        /* QR Reader styling */
        #qr-reader {
            border-radius: 8px;
        }
        
        /* Smooth transitions for all interactive elements */
        button, .hover\:shadow-lg {
            transition: all 0.2s ease;
        }
    </style>

    <script>
        let html5QrCode = null;
        let currentTrainingId = null; // Track which training QR is for

        // Character counter function
        function updateCharCount(textarea, counterId) {
            const counter = document.getElementById(counterId);
            if (counter) {
                counter.textContent = textarea.value.length;
                
                if (textarea.value.length > 450) {
                    counter.classList.add('text-red-500');
                } else {
                    counter.classList.remove('text-red-500');
                }
            }
        }

        // Initialize character counters on page load
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('textarea[name="absence_reason"]');
            textareas.forEach(textarea => {
                const attendanceId = textarea.closest('form').action.split('/').pop();
                const counterId = `char-count-${attendanceId}`;
                updateCharCount(textarea, counterId);
            });
        });

        function openQRScanner(trainingId = null) {
            currentTrainingId = trainingId;
            const modal = document.getElementById('qr-modal');
            const status = document.getElementById('qr-status');
            
            modal.classList.remove('hidden');
            status.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Initializing camera...';

            html5QrCode = new Html5Qrcode("qr-reader");
            
            const config = { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };
            
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                (decodedText, decodedResult) => {
                    status.innerHTML = '<i class="fas fa-check-circle text-green-500"></i> QR Code detected! Verifying...';
                    
                    // Send QR data to server for verification
                    fetch('{{ route("cadet.attendance.verify-qr") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ 
                            qr_data: decodedText,
                            training_id: currentTrainingId 
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            status.innerHTML = '<i class="fas fa-check-circle text-green-500"></i> ' + data.message;
                            setTimeout(() => {
                                closeQRScanner();
                                location.reload(); // Refresh to show updated attendance
                            }, 1500);
                        } else {
                            status.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i> ' + data.message;
                            setTimeout(() => {
                                status.innerHTML = 'Position the QR code within the camera view';
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        status.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i> Failed to verify QR code';
                        setTimeout(() => {
                            status.innerHTML = 'Position the QR code within the camera view';
                        }, 3000);
                    });
                },
                (errorMessage) => {
                    // QR scanning error (usually no QR code detected, which is normal)
                }
            ).then(() => {
                status.textContent = 'Position the QR code within the camera view';
            }).catch(err => {
                console.error('Error starting QR scanner:', err);
                status.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i> Failed to access camera. Please check permissions.';
            });
        }

        function closeQRScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    html5QrCode = null;
                }).catch(err => {
                    console.error('Error stopping QR scanner:', err);
                });
            }
            
            document.getElementById('qr-modal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('qr-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeQRScanner();
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('qr-modal').classList.contains('hidden')) {
                closeQRScanner();
            }
        });
    </script>
</x-app-layout>