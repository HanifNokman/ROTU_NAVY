<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Training Schedule') }}
            @if(isset($cadetIntake))
                <span class="text-sm font-normal text-gray-600 ml-2">({{ $cadetIntake }})</span>
            @endif
        </h2>
    </x-slot>

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(isset($error))
                <div class="bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @else
                <!-- Calendar View -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border-blue-300">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Training Calendar</h3>
                        <div id="calendar"></div>
                        @if(empty($calendarEvents))
                            <p class="mt-4 text-gray-500 text-sm">No training sessions scheduled for your intake.</p>
                        @endif
                    </div>
                </div>

                <!-- Training List -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($trainings as $training)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $training->title }}</div>
                                            @if($training->description)
                                                <div class="text-sm text-gray-500 mt-1">{{ Str::limit($training->description, 60) }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                            {{ $training->location }}
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
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $training->status_badge_color }}">
                                                {{ $training->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button onclick="viewTraining({{ $training->id }})" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye mr-1"></i>View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div class="text-gray-500">
                                                <i class="fas fa-calendar-times text-4xl mb-3"></i>
                                                <div class="text-lg font-medium">No Training Sessions</div>
                                                <div class="text-sm">There are no training sessions scheduled for your intake at this time.</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
