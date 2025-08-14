
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Attendance (Cadet)') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Today's Training Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-2">Today's Training</h3>
                @if($todaysTraining)
                    <div class="mb-4">
                        <div class="font-semibold">{{ $todaysTraining->title }}</div>
                        <div class="text-sm text-gray-600">{{ $todaysTraining->location }}</div>
                        <div class="text-sm text-gray-600">{{ $todaysTraining->formatted_start_date }} at {{ $todaysTraining->formatted_start_time }}</div>
                    </div>
                    @if(!$attendance || !$attendance->present)
                        <form method="POST" action="{{ route('cadet.attendance.mark') }}">
                            @csrf
                            <input type="hidden" name="training_id" value="{{ $todaysTraining->id }}">
                            <input type="hidden" name="method" value="manual">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold">Mark Present</button>
                        </form>
                        <button onclick="openQRScanner()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold mt-2">Scan QR to Mark Attendance</button>
                        <div id="qr-scanner" class="mt-4 hidden">
                            <!-- QR scanner implementation (JS required) -->
                            <p>Camera access required. (Scanner implementation here)</p>
                        </div>
                        <script>
                        function openQRScanner() {
                            document.getElementById('qr-scanner').classList.remove('hidden');
                            // JS QR scanner logic to be implemented
                        }
                        </script>
                    @else
                        <div class="text-green-700 font-semibold">You have marked yourself present for today.</div>
                    @endif
                @else
                    <div class="text-gray-500">No training scheduled for today.</div>
                @endif
            </div>
        </div>

        <!-- Absence Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-2">Absence Section</h3>
                @if($absentAttendances->count() > 0)
                    <ul class="space-y-4">
                        @foreach($absentAttendances as $attendance)
                            <li class="border rounded-lg p-4">
                                <div class="font-semibold">{{ $attendance->training->title }}</div>
                                <div class="text-sm text-gray-600">{{ $attendance->training->formatted_start_date }} at {{ $attendance->training->formatted_start_time }}</div>
                                <form method="POST" action="{{ route('cadet.attendance.absence', $attendance->id) }}" enctype="multipart/form-data" class="mt-2 flex flex-col gap-2">
                                    @csrf
                                    <label class="font-medium">Reason for Absence:</label>
                                    <input type="text" name="absence_reason" required class="border rounded px-2 py-1">
                                    <label class="font-medium">Supporting File:</label>
                                    <input type="file" name="supporting_file" required class="border rounded px-2 py-1">
                                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-semibold">Submit Reason & File</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-gray-500">No absences requiring action.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
