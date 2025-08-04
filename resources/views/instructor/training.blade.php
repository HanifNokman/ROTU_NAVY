<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Training Schedule') }}
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                
            <!-- Calendar View -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border-blue-300">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Training Calendar</h3>
                    <div id="calendar"></div>
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
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
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
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
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

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label for="start_datetime" class="block text-sm font-medium text-gray-700 mb-2">Start Date & Time</label>
                            <input type="datetime-local" id="start_datetime" name="start_datetime" step="300" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Use military time: 1300 = 1:00 PM, 1400 = 2:00 PM</p>
                        </div>
                        <div>
                            <label for="end_datetime" class="block text-sm font-medium text-gray-700 mb-2">End Date & Time</label>
                            <input type="datetime-local" id="end_datetime" name="end_datetime" step="300" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Use military time: 1300 = 1:00 PM, 1400 = 2:00 PM</p>
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

    @push('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/main.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script>
        let calendar;
        let currentTrainingId = null;

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
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($calendarEvents),
                eventClick: function(info) {
                    editTraining(info.event.id);
                },
                height: 'auto',
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
    </script>
    @endpush
</x-app-layout>