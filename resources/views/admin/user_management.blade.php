<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================================================================ --}}
            {{-- SUMMARY CARDS --}}
            {{-- ================================================================ --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- Total Users --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Total Users</div>
                            <div class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</div>
                        </div>
                    </div>
                </div>

                {{-- Total Active Cadets --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Total Active Cadets</div>
                            <div class="text-2xl font-semibold text-gray-900">{{ $totalActiveCadets }}</div>
                        </div>
                    </div>
                </div>

                {{-- Total Active Instructors --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Total Active Instructors</div>
                            <div class="text-2xl font-semibold text-gray-900">{{ $totalActiveInstructors }}</div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ================================================================ --}}
            {{-- CADETS SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Cadets</h3>

                    {{-- Intake Filter --}}
                    <form method="GET" action="{{ route('admin.user_management') }}" class="mb-4">
                        <label for="intake" class="block text-sm font-medium text-gray-700">Filter by Intake:</label>
                        <select name="intake" id="intake" onchange="this.form.submit()" class="mt-1 block w-48 pl-3 pr-10 py-1 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                            <option value="no_intake" @if($request->intake == 'no_intake') selected @endif>No Intake Year</option>
                            @foreach($intakes->filter(fn($intake) => !empty($intake)) as $intake)
                                <option value="{{ $intake }}" @if($request->intake == $intake || (!$request->intake && $loop->first)) selected @endif>Intake - {{ $intake - 2011 }} ({{ $intake }})</option>
                            @endforeach
                        </select>
                    </form>

                    {{-- Cadets Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake Year</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Matric No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current CGPA</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Past CGPA</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BMI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BMI Update Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Swimming Qualification</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bank Account</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile Pic</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($cadets as $cadet)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cadet->service_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->rank }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->position }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->intake_year }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->matric_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->phone_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->gender }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->current_cgpa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->past_cgpa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->ic_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->BMI }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->BMI_update_date ? $cadet->BMI_update_date->format('d/m/Y') : 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->swimming_qualification }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->bank_account_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->profile_pic }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $cadet->user->id }}" data-type="cadet">Edit</button>
                                            <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $cadet->user->id }}" data-type="cadet" data-name="{{ $cadet->user->name }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- INSTRUCTORS SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Instructors</h3>

                    {{-- Status Filter --}}
                    <form method="GET" action="{{ route('admin.user_management') }}" class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status:</label>
                        <select name="status" id="status" onchange="this.form.submit()" class="mt-1 block w-48 pl-3 pr-10 py-1 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $statusOption)
                                <option value="{{ $statusOption }}" {{ ($request->status == $statusOption || (!$request->status && $statusOption == 'Active')) ? 'selected' : '' }}>{{ $statusOption }}</option>
                            @endforeach
                        </select>
                    </form>

                    {{-- Instructors Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expertise</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time in Service</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TTP</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Past Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profile Pic</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($instructors as $instructor)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $instructor->service_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->rank }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->position }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->expertise }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->time_in_service }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->ttp }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->past_unit }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->phone_number }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->profile_pic }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $instructor->status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $instructor->user->id }}" data-type="instructor">Edit</button>
                                            <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $instructor->user->id }}" data-type="instructor" data-name="{{ $instructor->user->name }}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- EDIT MODAL --}}
    {{-- ================================================================ --}}
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-10 mx-auto p-5 border w-5/6 max-w-7xl shadow-lg rounded-md bg-white">
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit User</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div id="formFields"></div>
                    <div class="flex justify-end mt-4">
                        <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- DELETE MODAL --}}
    {{-- ================================================================ --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Deletion</h3>
                <p class="text-sm text-gray-500 mb-4">To delete this user, please type the full name: <strong id="deleteUserName"></strong></p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="text" id="confirmName" name="confirm_name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Type full name here">
                    <div class="flex justify-end mt-4">
                        <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeDeleteModal()">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        const intakes = @json($intakes);

        {{-- ================================================================ --}}
        {{-- EVENT LISTENERS --}}
        {{-- ================================================================ --}}
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    openEditModal(id, type);
                });
            });

            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const type = this.getAttribute('data-type');
                    openDeleteModal(id, name, type);
                });
            });
        });

        {{-- ================================================================ --}}
        {{-- EDIT MODAL FUNCTIONS --}}
        {{-- ================================================================ --}}
        function openEditModal(id, type) {
            fetch(`/admin/user/${id}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);
                    populateEditForm(data, type);
                    document.getElementById('editModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching user data:', error);
                    console.error('Error details:', error.message);
                    alert('Error loading user data: ' + error.message + '. Please try again.');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function populateEditForm(data, type) {
            let fields = '<div class="grid grid-cols-2 gap-4 max-h-96 overflow-y-auto">';
            fields += `<input type="hidden" name="user_id" value="${data.user.id}">`;

            {{-- Profile Picture --}}
            let profilePic = '';
            if (type === 'cadet' && data.cadet) profilePic = data.cadet.profile_pic;
            else if (type === 'instructor' && data.instructor) profilePic = data.instructor.profile_pic;
            
            fields += `<div class="mb-4 col-span-2"><label class="block text-sm font-medium text-gray-700">Profile Picture</label>`;
            if (profilePic) {
                fields += `<img src="${profilePic}" alt="Profile Picture" class="w-20 h-20 object-cover rounded-full mt-1 mb-2">`;
            }
            fields += `<input type="text" name="profile_pic" value="${profilePic || ''}" placeholder="Enter image URL" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">`;
            fields += `</div>`;

            {{-- Basic User Info --}}
            fields += `<div class="mb-4 col-span-2"><label class="block text-sm font-medium text-gray-700">Name</label><input type="text" name="name" value="${data.user.name}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required></div>`;
            fields += `<div class="mb-4 col-span-2"><label class="block text-sm font-medium text-gray-700">Email</label><input type="email" name="email" value="${data.user.email}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" required></div>`;
            fields += `<div class="mb-4 col-span-2"><label class="block text-sm font-medium text-gray-700">Role</label><input type="text" name="role" value="${data.user.role}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" readonly></div>`;

            {{-- ================================================================ --}}
            {{-- CADET SPECIFIC FIELDS --}}
            {{-- ================================================================ --}}
            if (type === 'cadet' && data.cadet) {
                const cadet = data.cadet;
                fields += `<div class="col-span-2 border-t border-gray-300 pt-4 mb-2 font-semibold text-gray-700">Cadet Details</div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Phone Number</label><input type="text" name="phone_number" value="${cadet.phone_number || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Gender</label><select name="gender" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><option value="Male" ${cadet.gender === 'Male' ? 'selected' : ''}>Male</option><option value="Female" ${cadet.gender === 'Female' ? 'selected' : ''}>Female</option></select></div>`;

                const cadetRanks = ['Lt.M', 'PKK', 'PK'];
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Rank</label><select name="rank" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">`;
                cadetRanks.forEach(rank => {
                    fields += `<option value="${rank}" ${cadet.rank === rank ? 'selected' : ''}>${rank}</option>`;
                });
                fields += `</select></div>`;

                const cadetPositions = ['CO', 'Thana', 'Zayn', 'Normal'];
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Position</label><select name="position" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">`;
                cadetPositions.forEach(position => {
                    fields += `<option value="${position}" ${cadet.position === position ? 'selected' : ''}>${position}</option>`;
                });
                fields += `</select></div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Intake Year</label><select name="intake_year" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">`;
                intakes.forEach(intake => {
                    const intakeNum = intake - 2011;
                    fields += `<option value="${intake}" ${cadet.intake_year == intake ? 'selected' : ''}>Intake - ${intakeNum} (${intake})</option>`;
                });
                fields += `</select></div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Matric No</label><input type="text" name="matric_no" value="${cadet.matric_no || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Current CGPA</label><input type="number" step="0.01" name="current_cgpa" value="${cadet.current_cgpa || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Past CGPA</label><input type="number" step="0.01" name="past_cgpa" value="${cadet.past_cgpa || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">IC Number</label><input type="text" name="ic_number" value="${cadet.ic_number || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">BMI</label><input type="number" step="0.01" name="BMI" value="${cadet.BMI || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">BMI Update Date</label><input type="date" name="BMI_update_date" value="${cadet.BMI_update_date ? cadet.BMI_update_date.split(' ')[0] : ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Swimming Qualification</label><select name="swimming_qualification" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><option value="Pass" ${cadet.swimming_qualification === 'Pass' ? 'selected' : ''}>Pass</option><option value="In Progress" ${cadet.swimming_qualification === 'In Progress' ? 'selected' : ''}>In Progress</option><option value="Fail" ${cadet.swimming_qualification === 'Fail' ? 'selected' : ''}>Fail</option></select></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Bank Account Number</label><input type="text" name="bank_account_number" value="${cadet.bank_account_number || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Service Number</label><input type="text" name="service_number" value="${cadet.service_number || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
            }

            {{-- ================================================================ --}}
            {{-- INSTRUCTOR SPECIFIC FIELDS --}}
            {{-- ================================================================ --}}
            else if (type === 'instructor' && data.instructor) {
                const instructor = data.instructor;
                fields += `<div class="col-span-2 border-t border-gray-300 pt-4 mb-2 font-semibold text-gray-700">Instructor Details</div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Phone Number</label><input type="text" name="phone_number" value="${instructor.phone_number || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;

                const instructorRanks = ['Kpt', 'Kdr', 'Lt.Kdr', 'Lt', 'Lt.Dya', 'Lt.M', 'PWI', 'PWII', 'BK', 'BM', 'LK', 'LKI', 'LKII'];
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Rank</label><select name="rank" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><optgroup label="Ranks">`;
                instructorRanks.forEach(rank => {
                    fields += `<option value="${rank}" ${instructor.rank === rank ? 'selected' : ''}>${rank}</option>`;
                });
                fields += `</optgroup></select></div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Position</label><input type="text" name="position" value="${instructor.position || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;

                let expertiseOptions = ['', 'PAP', 'JJM', 'PNK', 'TNL', 'BDI', 'KOM', 'PKOR', 'YO'];
                if (instructor.expertise === 'Admin') {
                    expertiseOptions.push('Admin');
                }
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Expertise</label><select name="expertise" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">`;
                expertiseOptions.forEach(option => {
                    const displayText = option === '' ? 'Select Expertise' : option;
                    fields += `<option value="${option}" ${instructor.expertise === option ? 'selected' : ''}>${displayText}</option>`;
                });
                fields += `</select></div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Time in Service</label><input type="number" name="time_in_service" value="${instructor.time_in_service || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">TTP</label><input type="date" name="ttp" value="${instructor.ttp || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Status</label><select name="status" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><option value="Active" ${instructor.status === 'Active' ? 'selected' : ''}>Active</option><option value="Relocated" ${instructor.status === 'Relocated' ? 'selected' : ''}>Relocated</option><option value="Retired" ${instructor.status === 'Retired' ? 'selected' : ''}>Retired</option></select></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Service Number</label><input type="text" name="service_number" value="${instructor.service_number || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Past Unit(s)</label>`;
                fields += `<table class="w-full mb-2"><tbody id="past-unit-table">`;
                let pastUnits = [];
                if (instructor.past_unit) {
                    try {
                        pastUnits = JSON.parse(instructor.past_unit);
                    } catch (e) {
                        pastUnits = [instructor.past_unit];
                    }
                }
                if (pastUnits.length === 0) pastUnits = [''];
                pastUnits.forEach(unit => {
                    fields += `<tr><td><input type="text" name="past_unit[]" value="${unit}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" maxlength="32"></td><td><button type="button" class="remove-past-unit px-2 py-1 bg-red-500 text-white rounded">Remove</button></td></tr>`;
                });
                fields += `</tbody></table>`;
                fields += `<button type="button" id="add-past-unit" class="px-4 py-2 bg-blue-500 text-white rounded">Add Past Unit</button></div>`;
            }

            fields += '</div>';
            document.getElementById('formFields').innerHTML = fields;
            document.getElementById('editForm').action = `/admin/user/${data.user.id}`;

            if (type === 'instructor') {
                const addBtn = document.getElementById('add-past-unit');
                const table = document.getElementById('past-unit-table');
                if (addBtn) {
                    addBtn.addEventListener('click', function() {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td><input type="text" name="past_unit[]" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" maxlength="32"></td><td><button type="button" class="remove-past-unit px-2 py-1 bg-red-500 text-white rounded">Remove</button></td>`;
                        table.appendChild(row);
                    });
                }
                if (table) {
                    table.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-past-unit')) {
                            e.target.closest('tr').remove();
                        }
                    });
                }
            }
        }

        {{-- ================================================================ --}}
        {{-- DELETE MODAL FUNCTIONS --}}
        {{-- ================================================================ --}}
        function openDeleteModal(id, name, type) {
            document.getElementById('deleteUserName').textContent = name;
            document.getElementById('deleteForm').action = `/admin/user/${id}?type=${type}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        {{-- ================================================================ --}}
        {{-- FORM SUBMISSIONS --}}
        {{-- ================================================================ --}}
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('User updated successfully!');
                    location.reload();
                } else {
                    alert('Error updating user: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                if (error.errors) {
                    let errorMsg = 'Validation errors:\n';
                    for (let field in error.errors) {
                        errorMsg += field + ': ' + error.errors[field].join(', ') + '\n';
                    }
                    alert(errorMsg);
                } else {
                    alert('Error updating user: ' + (error.message || 'Unknown error'));
                }
            });
        });

        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('User deleted successfully!');
                    location.reload();
                } else {
                    alert('Error deleting user: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                alert('Error deleting user: ' + error.message);
            });
        });
    </script>

</x-app-layout>