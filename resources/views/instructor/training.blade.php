<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Training Schedule') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Today's Training Section -->
            @if($todaysTrainings->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Today's Training</h3>
                    <div class="space-y-4">
                        @foreach($todaysTrainings as $training)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $training->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ $training->location }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $training->formatted_start_date }} at {{ $training->formatted_start_time }}
                                        @if($training->end_datetime)
                                            - {{ $training->end_datetime->format('h:i A') }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $training->involvement ?? 'Not specified' }}</p>
                                    @if($training->duration_hours && $training->allowance_amount)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Duration: {{ $training->duration_hours }}h | 
                                            Allowance: RM{{ $training->allowance_amount }} 
                                            ({{ $training->allowance_type === 'daily' ? 'daily' : 'hourly' }})
                                        </span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    @if($training->status === 'Active' && !$training->end_datetime)
                                    <button onclick="endTraining({{ $training->id }})" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium transition duration-200">
                                        <i class="fas fa-stop mr-1"></i>End Training
                                    </button>
                                    @endif
                                    <button onclick="openAttendanceModal({{ $training->id }})" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm font-medium transition duration-200">
                                        <i class="fas fa-users mr-1"></i>Attendance
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
                
            <!-- Calendar View -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Training Calendar</h3>
                    <div id="calendar" style="max-height: 400px;"></div>
                </div>
            </div>

            <!-- Activity Time Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Activity Time Table</h3>
                        <button onclick="openCreateModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <i class="fas fa-plus mr-2"></i>Add Training
                        </button>
                    </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="trainingsTable">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Involvement</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allowance</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($trainings as $training)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $training->title }}</div>
                                            @if($training->description)
                                            <div class="text-sm text-gray-500">{{ Str::limit($training->description, 50) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $training->involvement ?? 'Not specified' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $training->location }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>{{ $training->formatted_start_date }}</div>
                                            <div class="text-gray-500">{{ $training->formatted_start_time }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $training->duration_hours ? $training->duration_hours . 'h' : 'TBD' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($training->allowance_amount)
                                                <div>RM{{ $training->allowance_amount }}</div>
                                                <div class="text-xs text-gray-500">({{ $training->allowance_type }})</div>
                                            @else
                                                <span class="text-gray-400">TBD</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $training->status_badge_color }}">
                                                {{ $training->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="editTraining({{ $training->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button onclick="deleteTraining({{ $training->id }})" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No training sessions scheduled
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create/Edit Training Modal -->
    <div id="trainingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-screen overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Create Training Session</h3>
                </div>
                <form id="trainingForm" class="px-6 py-4">
                    <input type="hidden" id="trainingId" name="training_id">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" id="title" name="title" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" id="location" name="location" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Involvement (Cadet Intakes)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" name="involvement[]" value="Intake - 14" class="mr-2 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Intake - 14</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="involvement[]" value="Intake - 13" class="mr-2 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Intake - 13</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="involvement[]" value="Intake - 12" class="mr-2 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Intake - 12</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="involvement[]" value="Intake - 11" class="mr-2 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-700">Intake - 11</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="start_datetime" class="block text-sm font-medium text-gray-700 mb-2">Start Date & Time</label>
                            <input type="datetime-local" id="start_datetime" name="start_datetime" step="300" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Use military time: 1300 = 1:00 PM, 1400 = 2:00 PM</p>
                        </div>
                        <div>
                            <label for="end_datetime" class="block text-sm font-medium text-gray-700 mb-2">End Date & Time</label>
                            <input type="datetime-local" id="end_datetime" name="end_datetime" step="300" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Optional - Use military time: 1300 = 1:00 PM</p>
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="status" name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="duration_hours" class="block text-sm font-medium text-gray-700 mb-2">Duration (Hours)</label>
                        <input type="number" id="duration_hours" name="duration_hours" min="2" max="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Minimum 2 hours, Maximum 10 hours. Auto-calculated if end datetime is provided.</p>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">
                            <span id="submitText">Create Training</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-xl max-w-sm w-full mx-4">
                <div class="px-6 py-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Training Session</h3>
                    <p class="text-sm text-gray-600">Are you sure you want to delete this training session? This action cannot be undone.</p>
                </div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md">
                        Cancel
                    </button>
                    <button id="confirmDelete" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Modal -->
    <div id="attendanceModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-xl max-w-6xl w-full mx-4 max-h-screen overflow-y-auto">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Attendance Management</h3>
                            <p id="trainingTitle" class="text-sm text-gray-600"></p>
                        </div>
                        <button onclick="closeAttendanceModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 rounded-full hover:bg-gray-100" title="Close">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Loading State -->
                    <div id="attendanceLoading" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <p class="mt-2 text-gray-600">Loading cadets...</p>
                    </div>

                    <!-- Main Content -->
                    <div id="attendanceContent" class="hidden">
                        <!-- Toggle Buttons -->
                        <div class="flex mb-6">
                            <button id="manualTab" onclick="switchTab('manual')" class="px-4 py-2 bg-blue-600 text-white rounded-l-md focus:outline-none transition-colors duration-200">
                                Manual Attendance
                            </button>
                            <button id="qrTab" onclick="switchTab('qr')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-r-md focus:outline-none transition-colors duration-200">
                                QR Code Attendance
                            </button>
                        </div>

                        <!-- Manual Attendance Section -->
                        <div id="manualSection" class="block">
                            <!-- Intake Filter -->
                            <div class="mb-6" id="intakeFilterSection" style="display: none;">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Intake:</label>
                                <div class="flex flex-wrap gap-2" id="intakeFilters">
                                    <!-- Intake filter buttons will be populated here -->
                                </div>
                            </div>

                            <!-- Attendance Summary Banner -->
                            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-blue-800">
                                        <strong>Attendance Summary:</strong>
                                        Total: <span id="totalCadets" class="font-semibold">0</span> | 
                                        <span class="text-green-700">Present: <span id="presentCount" class="font-semibold">0</span></span> | 
                                        <span class="text-red-700">Absent: <span id="absentCount" class="font-semibold">0</span></span>
                                    </div>
                                    <button onclick="markAllPresent()" class="px-3 py-1 text-xs bg-green-600 hover:bg-green-700 text-white rounded-md transition-colors duration-200">
                                        Mark All Present
                                    </button>
                                    <button onclick="markAllAbsent()" class="px-3 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded-md ml-2 transition-colors duration-200">
                                        Mark All Absent
                                    </button>
                                </div>
                            </div>

                            <!-- Cadet List -->
                            <div id="cadetsList">
                                <!-- Cadets will be populated here -->
                            </div>

                            <!-- Save Button -->
                            <div class="mt-6 flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                    Changes are automatically saved when you toggle attendance
                                </div>
                                <button onclick="saveAttendance()" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md font-medium transition-colors duration-200 flex items-center">
                                    <i class="fas fa-save mr-2"></i>
                                    Save All Changes
                                </button>
                            </div>
                        </div>

                        <!-- QR Code Section -->
                        <div id="qrSection" class="hidden">
                            <div class="text-center">
                                <h4 class="text-md font-semibold text-gray-900 mb-4">QR Code for Attendance</h4>
                                <div class="flex justify-center mb-4">
                                    <div id="qrcode" class="w-64 h-64 border-2 border-gray-300 rounded-lg flex items-center justify-center bg-white shadow-lg">
                                        <p class="text-gray-500">Generating QR Code...</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Cadets can scan this QR code to mark their attendance</p>
                                <p class="text-xs text-gray-500 mb-4">QR code refreshes every 30 seconds for security</p>
                                <div class="bg-gray-50 rounded-lg p-4 inline-block">
                                    <span class="text-sm text-gray-700">Refresh in: </span>
                                    <span id="countdown" class="text-lg font-bold text-blue-600">30</span>
                                    <span class="text-sm text-gray-700"> seconds</span>
                                </div>

                                <!-- QR Attendance Summary -->
                                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <h5 class="text-sm font-semibold text-green-800 mb-2">Recent QR Scans</h5>
                                    <div id="recentScans" class="text-sm text-green-700">
                                        <p class="text-gray-500">No recent scans</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div id="attendanceError" class="hidden text-center py-8">
                        <div class="text-red-500 mb-4">
                            <i class="fas fa-exclamation-triangle text-4xl"></i>
                        </div>
                        <p class="text-gray-600 mb-4" id="errorMessage">Failed to load cadets</p>
                        <button onclick="loadCadetsForAttendance(currentTrainingId)" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                            <i class="fas fa-refresh mr-2"></i>
                            Retry
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/main.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.5.3/qrcode.min.js"></script>
    <script>
        let calendar;
        let currentTrainingId = null;
        let qrRefreshInterval = null;
        let countdownInterval = null;
        let cadetsData = [];
        let currentIntakeFilter = 'all';

        document.addEventListener('DOMContentLoaded', function() {
            initializeCalendar();
            
            // Form submission handler
            document.getElementById('trainingForm').addEventListener('submit', handleFormSubmit);
        });

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: @json($calendarEvents),
                eventClick: function(info) {
                    editTraining(info.event.id);
                },
                height: 350,
                eventDisplay: 'block'
            });
            calendar.render();
        }

        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Create Training Session';
            document.getElementById('submitText').textContent = 'Create Training';
            document.getElementById('trainingForm').reset();
            document.getElementById('trainingId').value = '';
            
            // Reset all checkboxes
            const involvementCheckboxes = document.querySelectorAll('input[name="involvement[]"]');
            involvementCheckboxes.forEach(checkbox => checkbox.checked = false);
            
            currentTrainingId = null;
            document.getElementById('trainingModal').classList.remove('hidden');
        }

        function editTraining(trainingId) {
            currentTrainingId = trainingId;
            document.getElementById('modalTitle').textContent = 'Edit Training Session';
            document.getElementById('submitText').textContent = 'Update Training';
            
            // Fetch training data
            fetch(`/instructor/training/${trainingId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('trainingId').value = data.id;
                    document.getElementById('title').value = data.title;
                    document.getElementById('description').value = data.description || '';
                    document.getElementById('location').value = data.location;
                    document.getElementById('duration_hours').value = data.duration_hours || '';
                    
                    // Handle involvement checkboxes
                    const involvementCheckboxes = document.querySelectorAll('input[name="involvement[]"]');
                    involvementCheckboxes.forEach(checkbox => checkbox.checked = false);
                    
                    if (data.involvement) {
                        const selectedIntakes = data.involvement.split(', ');
                        involvementCheckboxes.forEach(checkbox => {
                            if (selectedIntakes.includes(checkbox.value)) {
                                checkbox.checked = true;
                            }
                        });
                    }
                    
                    document.getElementById('start_datetime').value = formatDateTimeForInput(data.start_datetime);
                    document.getElementById('end_datetime').value = data.end_datetime ? formatDateTimeForInput(data.end_datetime) : '';
                    document.getElementById('status').value = data.status;
                    
                    document.getElementById('trainingModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching training data:', error);
                    alert('Error loading training data');
                });
        }

        function endTraining(trainingId) {
            if (confirm('Are you sure you want to end this training session?')) {
                fetch(`/instructor/training/${trainingId}/end`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message || 'Error ending training session');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error ending training session');
                });
            }
        }

        function deleteTraining(trainingId) {
            currentTrainingId = trainingId;
            document.getElementById('deleteModal').classList.remove('hidden');
            
            document.getElementById('confirmDelete').onclick = function() {
                fetch(`/instructor/training/${trainingId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error deleting training session');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting training session');
                });
            };
        }

        function openAttendanceModal(trainingId) {
            currentTrainingId = trainingId;
            document.getElementById('attendanceModal').classList.remove('hidden');
            
            // Show loading state
            document.getElementById('attendanceLoading').classList.remove('hidden');
            document.getElementById('attendanceContent').classList.add('hidden');
            document.getElementById('attendanceError').classList.add('hidden');
            
            // Fetch cadets data
            loadCadetsForAttendance(trainingId);
        }

        function loadCadetsForAttendance(trainingId) {
            fetch(`/instructor/training/${trainingId}/cadets`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cadetsData = data.cadets_by_intake;
                        
                        // Set training title
                        document.getElementById('trainingTitle').textContent = data.training.title;
                        
                        // Setup intake filters
                        setupIntakeFilters();
                        
                        // Display cadets
                        displayCadets();
                        
                        // Show content
                        document.getElementById('attendanceLoading').classList.add('hidden');
                        document.getElementById('attendanceContent').classList.remove('hidden');
                        
                        // Default to manual tab
                        switchTab('manual');
                    } else {
                        showError(data.message || 'Failed to load cadets');
                    }
                })
                .catch(error => {
                    console.error('Error loading cadets:', error);
                    showError('Failed to load cadets');
                });
        }

        function showError(message) {
            document.getElementById('attendanceLoading').classList.add('hidden');
            document.getElementById('attendanceContent').classList.add('hidden');
            document.getElementById('attendanceError').classList.remove('hidden');
            document.getElementById('errorMessage').textContent = message;
        }

        function setupIntakeFilters() {
            const filtersContainer = document.getElementById('intakeFilters');
            filtersContainer.innerHTML = '';
            
            // Add "All" filter
            const allButton = document.createElement('button');
            allButton.className = 'px-3 py-1 text-sm rounded-md bg-blue-600 text-white';
            allButton.textContent = 'All Intakes';
            allButton.onclick = () => filterByIntake('all', allButton);
            filtersContainer.appendChild(allButton);
            
            // Add individual intake filters
            cadetsData.forEach((intakeGroup, index) => {
                const button = document.createElement('button');
                button.className = 'px-3 py-1 text-sm rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300';
                button.textContent = `${intakeGroup.intake.label} (${intakeGroup.cadets.length})`;
                button.onclick = () => filterByIntake(index, button);
                filtersContainer.appendChild(button);
            });
        }

        function filterByIntake(filter, buttonElement) {
            currentIntakeFilter = filter;
            
            // Update button states
            document.querySelectorAll('#intakeFilters button').forEach(btn => {
                btn.className = 'px-3 py-1 text-sm rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300';
            });
            buttonElement.className = 'px-3 py-1 text-sm rounded-md bg-blue-600 text-white';
            
            displayCadets();
        }

// Updated displayCadets function with existing attendance data
        function displayCadets() {
            const cadetsContainer = document.getElementById('cadetsList');
            cadetsContainer.innerHTML = '';
            
            let displayData = [];
            if (currentIntakeFilter === 'all') {
                displayData = cadetsData;
            } else {
                displayData = [cadetsData[currentIntakeFilter]];
            }
            
            displayData.forEach(intakeGroup => {
                if (!intakeGroup || !intakeGroup.cadets) return;
                
                // Intake header with attendance summary
                const presentInIntake = intakeGroup.cadets.filter(c => c.present).length;
                const totalInIntake = intakeGroup.cadets.length;
                
                const intakeHeader = document.createElement('div');
                intakeHeader.className = 'mb-4';
                intakeHeader.innerHTML = `
                    <div class="flex justify-between items-center border-b pb-2">
                        <h5 class="text-md font-semibold text-gray-800">
                            ${intakeGroup.intake.label} (${totalInIntake} cadets)
                        </h5>
                        <div class="text-sm text-gray-600">
                            <span class="text-green-600 font-medium">${presentInIntake} present</span> | 
                            <span class="text-red-600 font-medium">${totalInIntake - presentInIntake} absent</span>
                        </div>
                    </div>
                `;
                cadetsContainer.appendChild(intakeHeader);
                
                // Cadets grid
                const cadetsGrid = document.createElement('div');
                cadetsGrid.className = 'grid grid-cols-1 md:grid-cols-2 gap-3 mb-6';
                
                intakeGroup.cadets.forEach(cadet => {
                    const cadetCard = document.createElement('div');
                    const cardClass = cadet.present ? 
                        'flex items-center justify-between p-3 border-2 border-green-200 bg-green-50 rounded-lg' : 
                        'flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50';
                    cadetCard.className = cardClass;
                    
                    // Create attendance status indicator
                    let statusIndicator = '';
                    if (cadet.present) {
                        const method = cadet.attendance_method === 'qr_code' ? 'QR Code' : 'Manual';
                        const timeStr = cadet.marked_at ? new Date(cadet.marked_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
                        statusIndicator = `<div class="text-xs text-green-700 font-medium">✓ Present via ${method}${timeStr ? ` at ${timeStr}` : ''}</div>`;
                    }
                    
                    cadetCard.innerHTML = `
                        <div class="flex-1">
                            <div class="font-medium text-gray-900">${cadet.name}</div>
                            <div class="text-sm text-gray-600">
                                ${cadet.matric_no ? `Matric: ${cadet.matric_no}` : ''}
                                ${cadet.service_number ? ` | Service: ${cadet.service_number}` : ''}
                            </div>
                            <div class="text-xs text-gray-500">
                                ${cadet.rank ? `${cadet.rank}` : ''}${cadet.position && cadet.position !== 'Normal Cadet' ? ` - ${cadet.position}` : ''}
                            </div>
                            ${statusIndicator}
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer attendance-toggle" data-cadet-id="${cadet.id}" ${cadet.present ? 'checked' : ''} onchange="updateAttendanceCount()">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    `;
                    cadetsGrid.appendChild(cadetCard);
                });
                
                cadetsContainer.appendChild(cadetsGrid);
            });
            
            updateAttendanceCount();
        }

        // Enhanced updateAttendanceCount function
        function updateAttendanceCount() {
            const allToggles = document.querySelectorAll('.attendance-toggle');
            const checkedToggles = document.querySelectorAll('.attendance-toggle:checked');
            
            const total = allToggles.length;
            const present = checkedToggles.length;
            const absent = total - present;
            
            document.getElementById('totalCadets').textContent = total;
            document.getElementById('presentCount').textContent = present;
            document.getElementById('absentCount').textContent = absent;
            
            // Update progress indicators
            const percentage = total > 0 ? Math.round((present / total) * 100) : 0;
            
            // Color-code the summary based on attendance percentage
            const summaryElement = document.querySelector('#attendanceContent .bg-blue-50');
            if (summaryElement) {
                if (percentage >= 90) {
                    summaryElement.className = summaryElement.className.replace('bg-blue-50 border-blue-200', 'bg-green-50 border-green-200');
                } else if (percentage >= 70) {
                    summaryElement.className = summaryElement.className.replace('bg-green-50 border-green-200', 'bg-yellow-50 border-yellow-200').replace('bg-blue-50 border-blue-200', 'bg-yellow-50 border-yellow-200');
                } else {
                    summaryElement.className = summaryElement.className.replace('bg-green-50 border-green-200', 'bg-red-50 border-red-200').replace('bg-yellow-50 border-yellow-200', 'bg-red-50 border-red-200').replace('bg-blue-50 border-blue-200', 'bg-red-50 border-red-200');
                }
            }
        }

        // New function to mark all cadets as present
        function markAllPresent() {
            const toggles = document.querySelectorAll('.attendance-toggle');
            toggles.forEach(toggle => {
                if (!toggle.checked) {
                    toggle.checked = true;
                }
            });
            updateAttendanceCount();
            displayCadets(); // Refresh display to show status changes
        }

        // New function to mark all cadets as absent
        function markAllAbsent() {
            const toggles = document.querySelectorAll('.attendance-toggle');
            toggles.forEach(toggle => {
                if (toggle.checked) {
                    toggle.checked = false;
                }
            });
            updateAttendanceCount();
            displayCadets(); // Refresh display to show status changes
        }

        // Enhanced saveAttendance function with better feedback
        function saveAttendance() {
            const attendanceData = [];
            document.querySelectorAll('.attendance-toggle').forEach(toggle => {
                attendanceData.push({
                    cadet_id: toggle.dataset.cadetId,
                    present: toggle.checked
                });
            });
            
            // Show saving indicator
            const saveButton = document.querySelector('button[onclick="saveAttendance()"]');
            const originalText = saveButton.innerHTML;
            saveButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            saveButton.disabled = true;
            
            fetch(`/instructor/training/${currentTrainingId}/attendance`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    attendance: attendanceData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Attendance saved successfully!', 'success');
                    
                    // Update button
                    saveButton.innerHTML = '<i class="fas fa-check mr-2"></i>Saved!';
                    saveButton.className = saveButton.className.replace('bg-green-600 hover:bg-green-700', 'bg-green-500');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        saveButton.innerHTML = originalText;
                        saveButton.disabled = false;
                        saveButton.className = saveButton.className.replace('bg-green-500', 'bg-green-600 hover:bg-green-700');
                    }, 2000);
                    
                } else {
                    showNotification('Error saving attendance: ' + (data.message || 'Unknown error'), 'error');
                    saveButton.innerHTML = originalText;
                    saveButton.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error saving attendance:', error);
                showNotification('Error saving attendance. Please try again.', 'error');
                saveButton.innerHTML = originalText;
                saveButton.disabled = false;
            });
        }

        // Enhanced closeAttendanceModal with confirmation if unsaved changes
        function closeAttendanceModal() {
            // Check for unsaved changes (this is a simple check - you might want to implement more sophisticated tracking)
            const hasChanges = document.querySelectorAll('.attendance-toggle').length > 0;
            
            if (hasChanges) {
                if (!confirm('Are you sure you want to close? Any unsaved changes will be lost.')) {
                    return;
                }
            }
            
            document.getElementById('attendanceModal').classList.add('hidden');
            
            // Clear intervals
            if (qrRefreshInterval) clearInterval(qrRefreshInterval);
            if (countdownInterval) clearInterval(countdownInterval);
            
            // Reset data
            cadetsData = [];
            currentIntakeFilter = 'all';
            currentTrainingId = null;
        }

        // New notification system
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        }

        // Enhanced keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // ESC to close attendance modal
            if (e.key === 'Escape' && !document.getElementById('attendanceModal').classList.contains('hidden')) {
                closeAttendanceModal();
            }
            
            // Ctrl+S to save attendance
            if (e.ctrlKey && e.key === 's' && !document.getElementById('attendanceModal').classList.contains('hidden')) {
                e.preventDefault();
                saveAttendance();
            }
        });

        function switchTab(tab) {
            const manualTab = document.getElementById('manualTab');
            const qrTab = document.getElementById('qrTab');
            const manualSection = document.getElementById('manualSection');
            const qrSection = document.getElementById('qrSection');

            if (tab === 'manual') {
                manualTab.classList.add('bg-blue-600', 'text-white');
                manualTab.classList.remove('bg-gray-200', 'text-gray-700');
                qrTab.classList.add('bg-gray-200', 'text-gray-700');
                qrTab.classList.remove('bg-blue-600', 'text-white');
                
                manualSection.classList.remove('hidden');
                qrSection.classList.add('hidden');
                
                // Clear QR intervals
                if (qrRefreshInterval) clearInterval(qrRefreshInterval);
                if (countdownInterval) clearInterval(countdownInterval);
            } else {
                qrTab.classList.add('bg-blue-600', 'text-white');
                qrTab.classList.remove('bg-gray-200', 'text-gray-700');
                manualTab.classList.add('bg-gray-200', 'text-gray-700');
                manualTab.classList.remove('bg-blue-600', 'text-white');
                
                qrSection.classList.remove('hidden');
                manualSection.classList.add('hidden');
                
                // Start QR code generation
                generateQRCode();
            }
        }

        function generateQRCode() {
            if (!currentTrainingId) return;
            
            fetch(`/instructor/training/${currentTrainingId}/qr-code`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const qrContainer = document.getElementById('qrcode');
                        qrContainer.innerHTML = '';
                        
                        QRCode.toCanvas(qrContainer, data.qr_data, {
                            width: 256,
                            height: 256,
                            margin: 2,
                            color: {
                                dark: '#000000',
                                light: '#ffffff'
                            }
                        }, function (error) {
                            if (error) console.error(error);
                        });
                        
                        // Start countdown
                        startCountdown(data.expires_in);
                    }
                })
                .catch(error => {
                    console.error('Error generating QR code:', error);
                });
        }

        function startCountdown(seconds) {
            let timeLeft = seconds;
            const countdownElement = document.getElementById('countdown');
            
            if (countdownInterval) clearInterval(countdownInterval);
            
            countdownInterval = setInterval(() => {
                countdownElement.textContent = timeLeft;
                timeLeft--;
                
                if (timeLeft < 0) {
                    generateQRCode(); // Refresh QR code
                }
            }, 1000);
        }

        function saveAttendance() {
            const attendanceData = [];
            document.querySelectorAll('.attendance-toggle').forEach(toggle => {
                attendanceData.push({
                    cadet_id: toggle.dataset.cadetId,
                    present: toggle.checked
                });
            });
            
            fetch(`/instructor/training/${currentTrainingId}/attendance`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    attendance: attendanceData
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Attendance saved successfully!');
                    closeAttendanceModal();
                } else {
                    alert('Error saving attendance: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error saving attendance:', error);
                alert('Error saving attendance');
            });
        }

        function handleFormSubmit(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            
            // Handle involvement checkboxes
            const involvementCheckboxes = document.querySelectorAll('input[name="involvement[]"]:checked');
            const selectedIntakes = Array.from(involvementCheckboxes).map(cb => cb.value);
            
            // Convert FormData to regular object
            const data = {};
            for (let [key, value] of formData.entries()) {
                if (key !== 'involvement[]') {
                    data[key] = value;
                }
            }
            
            // Add involvement as comma-separated string
            data.involvement = selectedIntakes.join(', ');
            
            const url = currentTrainingId ? 
                `/instructor/training/${currentTrainingId}` : 
                '/instructor/training';
            
            const method = currentTrainingId ? 'PUT' : 'POST';
            
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error saving training session');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving training session');
            });
        }

        function closeModal() {
            document.getElementById('trainingModal').classList.add('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function closeAttendanceModal() {
            document.getElementById('attendanceModal').classList.add('hidden');
            
            // Clear intervals
            if (qrRefreshInterval) clearInterval(qrRefreshInterval);
            if (countdownInterval) clearInterval(countdownInterval);
            
            // Reset data
            cadetsData = [];
            currentIntakeFilter = 'all';
        }

        function formatDateTimeForInput(datetime) {
            return new Date(datetime).toISOString().slice(0, 16);
        }

        // Close modals when clicking outside
        document.getElementById('trainingModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        document.getElementById('attendanceModal').addEventListener('click', function(e) {
            if (e.target === this) closeAttendanceModal();
        });
    </script>
    @endpush
</x-app-layout>
