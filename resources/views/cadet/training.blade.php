<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Training Schedule') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Training Schedule
                </h1>
                <p class="text-gray-600">View your upcoming training sessions and schedule</p>
            </div>
            @if(isset($error))
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @else
                <!-- Calendar View -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Training Calendar
                        </h3>
                        <div id="calendar"></div>
                        @if(empty($calendarEvents))
                            <div class="mt-4 text-center py-8">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="text-base font-medium text-gray-900 mb-2">No training sessions found</h3>
                                    <p class="text-sm text-gray-500">No training sessions scheduled for your intake.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Training List -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Training Sessions
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                                <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Start</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Duration</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($trainings as $training)
                                        <tr class="hover:bg-blue-50 transition-colors duration-200">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $training->title }}</div>
                                                @if($training->description)
                                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($training->description, 60) }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                    {{ $training->location }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div class="font-medium">{{ $training->formatted_start_date }}</div>
                                                <div class="text-gray-500">{{ $training->formatted_start_time }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if($training->end_datetime)
                                                    {{ $training->start_datetime->diffForHumans($training->end_datetime, true) }}
                                                @else
                                                    <span class="text-gray-400">Not specified</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                    @if($training->status === 'Active') bg-green-100 text-green-800
                                                    @elseif($training->status === 'Completed') bg-gray-100 text-gray-800
                                                    @elseif($training->status === 'Cancelled') bg-red-100 text-red-800
                                                    @else bg-blue-100 text-blue-800 @endif">
                                                    {{ $training->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button onclick="viewTraining({{ $training->id }})" class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center">
                                                <div class="text-gray-500">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <h3 class="text-base font-medium text-gray-900 mb-2">No training sessions found</h3>
                                                    <p class="text-sm text-gray-500">There are no training sessions scheduled for your intake at this time.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Unified View Training Modal -->
    <div id="viewTrainingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Training Details</h3>
                </div>
                <div class="px-6 py-4" id="trainingDetails"></div>
                <div class="px-6 py-4 bg-gray-50 flex justify-end">
                    <button onclick="closeViewModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-md">
                        Close
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

            document.addEventListener('DOMContentLoaded', function() {
                @if(!isset($error))
                    initializeCalendar();
                @endif
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
                    events: @json($calendarEvents ?? []),
                    eventClick: function(info) {
                        viewTraining(info.event.id);
                    },
                    height: 'auto',
                    eventDisplay: 'block',
                    eventTextColor: '#ffffff'
                });
                calendar.render();
            }

            function viewTraining(trainingId) {
                fetch(`/cadet/training/${trainingId}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(async response => {
                    if (!response.ok) {
                        const text = await response.text(); // capture server message
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const detailsHtml = `
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900">${data.title}</h4>
                                ${data.description ? `<p class="text-gray-600 mt-2">${data.description}</p>` : ''}
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Location</label>
                                    <p class="text-sm text-gray-900 mt-1"><i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>${data.location}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1 ${getStatusBadgeColor(data.status)}">${data.status}</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Start</label>
                                    <p class="text-sm text-gray-900 mt-1"><i class="fas fa-calendar text-gray-400 mr-1"></i>${formatDateTime(data.start_datetime)}</p>
                                </div>
                                ${data.end_datetime ? `
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">End</label>
                                    <p class="text-sm text-gray-900 mt-1"><i class="fas fa-calendar text-gray-400 mr-1"></i>${formatDateTime(data.end_datetime)}</p>
                                </div>` : ''}
                            </div>
                            ${data.involvement ? `
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cadet Intakes Involved</label>
                                <p class="text-sm text-blue-600 mt-1"><i class="fas fa-users text-gray-400 mr-1"></i>${data.involvement}</p>
                            </div>` : ''}
                        </div>
                    `;
                    document.getElementById('trainingDetails').innerHTML = detailsHtml;
                    document.getElementById('viewTrainingModal').classList.remove('hidden');
                })
                .catch(err => {
                    console.error('Error fetching training details:', err);
                    alert('Unable to load training details');
                });
            }

            function closeViewModal() {
                document.getElementById('viewTrainingModal').classList.add('hidden');
            }

            function formatDateTime(datetime) {
                const date = new Date(datetime);
                const day = date.toLocaleDateString('en-MY', { year: 'numeric', month: 'short', day: 'numeric' });
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                return `${day} ${hours}${minutes}H`;
            }

            function getStatusBadgeColor(status) {
                switch(status) {
                    case 'Active': return 'bg-green-100 text-green-800';
                    case 'Completed': return 'bg-gray-100 text-gray-800';
                    case 'Cancelled': return 'bg-red-100 text-red-800';
                    default: return 'bg-blue-100 text-blue-800';
                }
            }

            document.getElementById('viewTrainingModal').addEventListener('click', function(e) {
                if (e.target === this) closeViewModal();
            });
        </script>
    @endpush
</x-app-layout>
