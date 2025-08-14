

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Allowance Estimation (Cadet)
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form id="allowance-filter-form" class="mb-6 flex flex-wrap gap-4">
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                        <select name="year" id="year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($years as $year)
                                <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                        <select name="month" id="month" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @foreach($months as $num => $name)
                                <option value="{{ $num }}" @if($num == $selectedMonth) selected @endif>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <div id="allowance-content">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                <tr>
                                    <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                                    <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Training Involved</th>
                                    <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Training Date</th>
                                    <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Location</th>
                                    <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Duration</th>
                                    <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Type</th>
                                    <th class="px-2 py-2 text-left text-xs font-semibold text-gray-700 uppercase">Hours/Days</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($trainings as $i => $training)
                                    <tr>
                                        <td class="px-2 py-2 text-xs">{{ $i+1 }}</td>
                                        <td class="px-2 py-2 text-xs">{{ $training['title'] }}</td>
                                        <td class="px-2 py-2 text-xs">{{ $training['date'] }}</td>
                                        <td class="px-2 py-2 text-xs">{{ $training['location'] }}</td>
                                        <td class="px-2 py-2 text-xs">{{ $training['duration'] }}</td>
                                        <td class="px-2 py-2 text-xs">{{ ucfirst($training['type']) }}</td>
                                        <td class="px-2 py-2 text-xs">
                                            @if($training['type'] === 'hourly')
                                                {{ $training['hours'] }} hours
                                            @else
                                                {{ $training['days'] }} days
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-6 text-gray-500">No trainings attended for selected period.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                        <h3 class="text-lg font-semibold mb-2">Allowance Calculation</h3>
                        <div class="mb-2">
                            <span class="font-semibold">Hourly Calculation:</span>
                            {{ $totalHours }} hours × RM8 = <span class="font-bold text-blue-700">RM{{ number_format($hourlyAllowance, 2) }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold">Daily Calculation:</span>
                            {{ $totalDays }} days × RM50 = <span class="font-bold text-blue-700">RM{{ number_format($dailyAllowance, 2) }}</span>
                        </div>
                        <div class="mt-4 text-xl font-bold text-green-700">
                            Total Allowance: RM{{ number_format($totalAllowance, 2) }}
                        </div>
                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const yearSelect = document.getElementById('year');
                    const monthSelect = document.getElementById('month');
                    const allowanceContent = document.getElementById('allowance-content');

                    function fetchAllowance() {
                        const year = yearSelect.value;
                        const month = monthSelect.value;
                        fetch(`{{ route('cadet.allowance') }}?year=${year}&month=${month}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            allowanceContent.innerHTML = data.html;
                        });
                    }

                    yearSelect.addEventListener('change', fetchAllowance);
                    monthSelect.addEventListener('change', fetchAllowance);
                });
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
