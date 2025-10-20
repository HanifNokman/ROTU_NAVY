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

                    {{-- Intake Filter and Search --}}
                    <div class="mb-4 flex items-center justify-between">
                        <form method="GET" action="{{ route('admin.user_management') }}" class="flex items-center space-x-4">
                            <div>
                                <label for="intake" class="block text-sm font-medium text-gray-700">Filter by Intake:</label>
                                <select name="intake" id="intake" onchange="this.form.submit()" class="mt-1 block w-48 pl-3 pr-10 py-1 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                    <option value="no_intake" @if($request->intake == 'no_intake') selected @endif>No Intake Year</option>
                                    @foreach($intakes as $intake)
                                        <option value="{{ $intake['year'] }}" @if($request->intake == $intake['year'] || (!$request->intake && $loop->first)) selected @endif>{{ $intake['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <div id="cadetSearchContainer" class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" id="cadetSearch" placeholder="Search cadets..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" style="min-width: 250px;">
                        </div>
                    </div>

                    {{-- Cadets Table --}}
                    <div class="overflow-x-auto">
                        <div class="max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Service Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Rank</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Position</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Intake Year</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Matric No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Phone Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Gender</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Current CGPA</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Past CGPA</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">IC Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">BMI</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">BMI Update Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Swimming Qualification</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Swimming Pass Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Bank Account</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Profile Pic</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cadetsTableBody" class="bg-white divide-y divide-gray-200">
                                    @forelse($cadets as $cadet)
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->swimming_pass_date ? $cadet->swimming_pass_date->format('d/m/Y') : 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->bank_account_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cadet->profile_pic }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $cadet->user->id }}" data-type="cadet">Edit</button>
                                                <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $cadet->user->id }}" data-type="cadet" data-name="{{ $cadet->user->name }}">Delete</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="19" class="px-6 py-12 text-center text-gray-500">
                                                <p>No cadets found for the selected filter.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- INSTRUCTORS SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Instructors</h3>

                    {{-- Status Filter and Search --}}
                    <div class="mb-4 flex items-center justify-between">
                        <form method="GET" action="{{ route('admin.user_management') }}" class="flex items-center space-x-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Filter by Status:</label>
                                <select name="status" id="status" onchange="this.form.submit()" class="mt-1 block w-48 pl-3 pr-10 py-1 text-sm border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $statusOption)
                                        <option value="{{ $statusOption }}" {{ ($request->status == $statusOption || (!$request->status && $statusOption == 'Active')) ? 'selected' : '' }}>{{ $statusOption }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                        <div id="instructorSearchContainer" class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" id="instructorSearch" placeholder="Search instructors..." class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" style="min-width: 250px;">
                        </div>
                    </div>

                    {{-- Instructors Table --}}
                    <div class="overflow-x-auto">
                        <div class="max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Service Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Rank</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Position</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Expertise</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Time in Service</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">TTP</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Past Unit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Phone Number</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Profile Pic</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="instructorsTableBody" class="bg-white divide-y divide-gray-200">
                                    @forelse($instructors as $instructor)
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
                                    @empty
                                        <tr>
                                            <td colspan="13" class="px-6 py-12 text-center text-gray-500">
                                                <p>No instructors found for the selected filter.</p>
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

    {{-- ================================================================ --}}
    {{-- EDIT MODAL - UPDATED WITH HIGHER Z-INDEX --}}
    {{-- ================================================================ --}}
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[100]">
        <div class="relative top-10 mx-auto p-5 border w-5/6 max-w-7xl shadow-lg rounded-md bg-white mb-10 z-[110]">
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl z-[120]">&times;</button>
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
    {{-- DELETE MODAL - UPDATED WITH HIGHER Z-INDEX --}}
    {{-- ================================================================ --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[100]">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white z-[110]">
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
                    fields += `<option value="${intake.year}" ${cadet.intake_year == intake.year ? 'selected' : ''}>${intake.label}</option>`;
                });
                fields += `</select></div>`;

                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Matric No</label><input type="text" name="matric_no" value="${cadet.matric_no || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Current CGPA</label><input type="number" step="0.01" name="current_cgpa" value="${cadet.current_cgpa || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Past CGPA</label><input type="number" step="0.01" name="past_cgpa" value="${cadet.past_cgpa || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">IC Number</label><input type="text" name="ic_number" value="${cadet.ic_number || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">BMI</label><input type="number" step="0.01" name="BMI" value="${cadet.BMI || ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">BMI Update Date</label><input type="date" name="BMI_update_date" value="${cadet.BMI_update_date ? cadet.BMI_update_date.split(' ')[0] : ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Swimming Qualification</label><select name="swimming_qualification" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"><option value="Pass" ${cadet.swimming_qualification === 'Pass' ? 'selected' : ''}>Pass</option><option value="In Progress" ${cadet.swimming_qualification === 'In Progress' ? 'selected' : ''}>In Progress</option><option value="Fail" ${cadet.swimming_qualification === 'Fail' ? 'selected' : ''}>Fail</option></select></div>`;
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Swimming Pass Date</label><input type="date" name="swimming_pass_date" value="${cadet.swimming_pass_date ? cadet.swimming_pass_date.split(' ')[0] : ''}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md"></div>`;
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
                let isAdminExpertise = instructor.expertise === 'Admin';
                if (isAdminExpertise) {
                    expertiseOptions.push('Admin');
                }
                fields += `<div class="mb-4"><label class="block text-sm font-medium text-gray-700">Expertise</label><select name="expertise" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" ${isAdminExpertise ? 'disabled' : ''}>`;
                expertiseOptions.forEach(option => {
                    const displayText = option === '' ? 'Select Expertise' : option;
                    fields += `<option value="${option}" ${instructor.expertise === option ? 'selected' : ''}>${displayText}</option>`;
                });
                fields += `</select>`;
                if (isAdminExpertise) {
                    fields += `<p class="text-sm text-gray-500 mt-1">Admin expertise cannot be changed through this form.</p>`;
                }
                fields += `</div>`;

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
        {{-- FORM SUBMISSIONS - FIXED VERSION --}}
        {{-- ================================================================ --}}
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Updating...';
            
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
                return response.json(); // FIXED: Added parentheses
            })
            .then(data => {
                if (data.success) {
                    alert('User updated successfully!');
                    location.reload();
                } else {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    alert('Error updating user: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                
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

    {{-- ================================================================ --}}
    {{-- SEARCH AND PAGINATION SCRIPT --}}
    {{-- ================================================================ --}}

    <script>
        // Store original data
        let allCadets = [];
        let allInstructors = [];
        let filteredCadets = [];
        let filteredInstructors = [];
        
        // Pagination
        let cadetCurrentPage = 1;
        let instructorCurrentPage = 1;
        const itemsPerPage = 10;

        document.addEventListener('DOMContentLoaded', function() {
            // Store initial data
            document.querySelectorAll('#cadetsTableBody tr').forEach(row => {
                if (!row.querySelector('td[colspan]')) {
                    allCadets.push(row.cloneNode(true));
                }
            });
            
            document.querySelectorAll('#instructorsTableBody tr').forEach(row => {
                if (!row.querySelector('td[colspan]')) {
                    allInstructors.push(row.cloneNode(true));
                }
            });
            
            filteredCadets = [...allCadets];
            filteredInstructors = [...allInstructors];

            // Cadet search is now in HTML, just attach event listener
            const cadetSearchInput = document.getElementById('cadetSearch');
            if (cadetSearchInput) {
                cadetSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const intakeFilter = document.getElementById('intake').value;
                    searchCadets(searchTerm, intakeFilter);
                });
            }

            // Instructor search is now in HTML, just attach event listener
            const instructorSearchInput = document.getElementById('instructorSearch');
            if (instructorSearchInput) {
                instructorSearchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const statusFilter = document.getElementById('status').value;
                    searchInstructors(searchTerm, statusFilter);
                });
            }

            // Update intake filter to work with search
            const intakeSelect = document.getElementById('intake');
            if (intakeSelect) {
                intakeSelect.removeAttribute('onchange');
                intakeSelect.addEventListener('change', function() {
                    const searchTerm = cadetSearchInput ? cadetSearchInput.value.toLowerCase().trim() : '';
                    searchCadets(searchTerm, this.value);
                });
            }

            // Update status filter to work with search
            const statusSelect = document.getElementById('status');
            if (statusSelect) {
                statusSelect.removeAttribute('onchange');
                statusSelect.addEventListener('change', function() {
                    const searchTerm = instructorSearchInput ? instructorSearchInput.value.toLowerCase().trim() : '';
                    searchInstructors(searchTerm, this.value);
                });
            }

            // Add pagination controls
            addCadetPagination();
            addInstructorPagination();
            
            renderCadetsTable();
            renderInstructorsTable();
        });

        async function searchCadets(searchTerm, intakeFilter) {
            try {
                const response = await fetch(`{{ route('admin.user_management.search_cadets') }}?search=${encodeURIComponent(searchTerm)}&intake=${encodeURIComponent(intakeFilter)}`);
                const data = await response.json();
                
                if (data.success) {
                    allCadets = [];
                    filteredCadets = [];
                    
                    data.cadets.forEach((cadet, index) => {
                        const row = createCadetRow(cadet, index);
                        allCadets.push(row);
                        filteredCadets.push(row);
                    });
                    
                    cadetCurrentPage = 1;
                    renderCadetsTable();
                }
            } catch (error) {
                console.error('Error searching cadets:', error);
            }
        }

        async function searchInstructors(searchTerm, statusFilter) {
            try {
                const response = await fetch(`{{ route('admin.user_management.search_instructors') }}?search=${encodeURIComponent(searchTerm)}&status=${encodeURIComponent(statusFilter)}`);
                const data = await response.json();
                
                if (data.success) {
                    allInstructors = [];
                    filteredInstructors = [];
                    
                    data.instructors.forEach((instructor, index) => {
                        const row = createInstructorRow(instructor, index);
                        allInstructors.push(row);
                        filteredInstructors.push(row);
                    });
                    
                    instructorCurrentPage = 1;
                    renderInstructorsTable();
                }
            } catch (error) {
                console.error('Error searching instructors:', error);
            }
        }

        function createCadetRow(cadet, index) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${cadet.service_number || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.user.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.rank || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.position || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.intake_year || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.matric_no || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.user.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.phone_number || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.gender || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.current_cgpa || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.past_cgpa || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.ic_number || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.BMI || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.BMI_update_date ? new Date(cadet.BMI_update_date).toLocaleDateString('en-GB') : 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.swimming_qualification || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.swimming_pass_date ? new Date(cadet.swimming_pass_date).toLocaleDateString('en-GB') : 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.bank_account_number || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${cadet.profile_pic || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="${cadet.user.id}" data-type="cadet">Edit</button>
                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="${cadet.user.id}" data-type="cadet" data-name="${cadet.user.name}">Delete</button>
                </td>
            `;
            
            // Re-attach event listeners
            const editBtn = row.querySelector('.edit-btn');
            const deleteBtn = row.querySelector('.delete-btn');
            
            if (editBtn) {
                editBtn.addEventListener('click', function() {
                    openEditModal(this.getAttribute('data-id'), this.getAttribute('data-type'));
                });
            }
            
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    openDeleteModal(this.getAttribute('data-id'), this.getAttribute('data-name'), this.getAttribute('data-type'));
                });
            }
            
            return row;
        }

        function createInstructorRow(instructor, index) {
            const row = document.createElement('tr');
            const pastUnit = instructor.past_unit ? (typeof instructor.past_unit === 'string' ? instructor.past_unit : JSON.parse(instructor.past_unit).join(', ')) : '';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${instructor.service_number || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.user.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.rank || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.position || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.expertise || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.time_in_service || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.ttp || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${pastUnit}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.user.email}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.phone_number || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.profile_pic || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${instructor.status || ''}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="${instructor.user.id}" data-type="instructor">Edit</button>
                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="${instructor.user.id}" data-type="instructor" data-name="${instructor.user.name}">Delete</button>
                </td>
            `;
            
            // Re-attach event listeners
            const editBtn = row.querySelector('.edit-btn');
            const deleteBtn = row.querySelector('.delete-btn');
            
            if (editBtn) {
                editBtn.addEventListener('click', function() {
                    openEditModal(this.getAttribute('data-id'), this.getAttribute('data-type'));
                });
            }
            
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    openDeleteModal(this.getAttribute('data-id'), this.getAttribute('data-name'), this.getAttribute('data-type'));
                });
            }
            
            return row;
        }

        function renderCadetsTable() {
            const tableBody = document.getElementById('cadetsTableBody');
            tableBody.innerHTML = '';

            const totalPages = Math.ceil(filteredCadets.length / itemsPerPage);
            const startIndex = (cadetCurrentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredCadets.length);

            if (filteredCadets.length === 0) {
                const emptyRow = document.createElement('tr');
                emptyRow.innerHTML = `
                    <td colspan="19" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-400 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-medium">No cadets found</p>
                        <p class="text-sm">Try adjusting your search or filters</p>
                    </td>
                `;
                tableBody.appendChild(emptyRow);
            } else {
                for (let i = startIndex; i < endIndex; i++) {
                    const row = filteredCadets[i].cloneNode(true);
                    tableBody.appendChild(row);

                    // Re-attach event listeners
                    const editBtn = row.querySelector('.edit-btn');
                    const deleteBtn = row.querySelector('.delete-btn');

                    if (editBtn) {
                        editBtn.addEventListener('click', function() {
                            openEditModal(this.getAttribute('data-id'), this.getAttribute('data-type'));
                        });
                    }

                    if (deleteBtn) {
                        deleteBtn.addEventListener('click', function() {
                            openDeleteModal(this.getAttribute('data-id'), this.getAttribute('data-name'), this.getAttribute('data-type'));
                        });
                    }
                }
            }

            updateCadetPagination(totalPages);
        }

        function renderInstructorsTable() {
            const tableBody = document.getElementById('instructorsTableBody');
            tableBody.innerHTML = '';

            const totalPages = Math.ceil(filteredInstructors.length / itemsPerPage);
            const startIndex = (instructorCurrentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredInstructors.length);

            if (filteredInstructors.length === 0) {
                const emptyRow = document.createElement('tr');
                emptyRow.innerHTML = `
                    <td colspan="13" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 text-gray-400 mb-2 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-medium">No instructors found</p>
                        <p class="text-sm">Try adjusting your search or filters</p>
                    </td>
                `;
                tableBody.appendChild(emptyRow);
            } else {
                for (let i = startIndex; i < endIndex; i++) {
                    const row = filteredInstructors[i].cloneNode(true);
                    tableBody.appendChild(row);

                    // Re-attach event listeners
                    const editBtn = row.querySelector('.edit-btn');
                    const deleteBtn = row.querySelector('.delete-btn');

                    if (editBtn) {
                        editBtn.addEventListener('click', function() {
                            openEditModal(this.getAttribute('data-id'), this.getAttribute('data-type'));
                        });
                    }

                    if (deleteBtn) {
                        deleteBtn.addEventListener('click', function() {
                            openDeleteModal(this.getAttribute('data-id'), this.getAttribute('data-name'), this.getAttribute('data-type'));
                        });
                    }
                }
            }

            updateInstructorPagination(totalPages);
        }

        function addCadetPagination() {
            const cadetTable = document.querySelector('#cadetsTableBody').closest('.overflow-x-auto');
            const paginationContainer = document.createElement('div');
            paginationContainer.id = 'cadetPaginationContainer';
            paginationContainer.className = 'mt-4 flex items-center justify-between';
            paginationContainer.innerHTML = `
                <div class="text-sm text-gray-700">
                    Showing <span id="cadetShowingStart">1</span> to <span id="cadetShowingEnd">10</span> of <span id="cadetTotal">0</span> cadets
                </div>
                <div class="flex gap-2">
                    <button id="cadetPrevPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                        Previous
                    </button>
                    <div id="cadetPageNumbers" class="flex gap-2"></div>
                    <button id="cadetNextPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                    </button>
                </div>
            `;
            cadetTable.parentNode.appendChild(paginationContainer);
            
            document.getElementById('cadetPrevPage').addEventListener('click', function() {
                if (cadetCurrentPage > 1) {
                    cadetCurrentPage--;
                    renderCadetsTable();
                }
            });
            
            document.getElementById('cadetNextPage').addEventListener('click', function() {
                const totalPages = Math.ceil(filteredCadets.length / itemsPerPage);
                if (cadetCurrentPage < totalPages) {
                    cadetCurrentPage++;
                    renderCadetsTable();
                }
            });
        }

        function addInstructorPagination() {
            const instructorTable = document.querySelector('#instructorsTableBody').closest('.overflow-x-auto');
            const paginationContainer = document.createElement('div');
            paginationContainer.id = 'instructorPaginationContainer';
            paginationContainer.className = 'mt-4 flex items-center justify-between';
            paginationContainer.innerHTML = `
                <div class="text-sm text-gray-700">
                    Showing <span id="instructorShowingStart">1</span> to <span id="instructorShowingEnd">10</span> of <span id="instructorTotal">0</span> instructors
                </div>
                <div class="flex gap-2">
                    <button id="instructorPrevPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                        Previous
                    </button>
                    <div id="instructorPageNumbers" class="flex gap-2"></div>
                    <button id="instructorNextPage" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                    </button>
                </div>
            `;
            instructorTable.parentNode.appendChild(paginationContainer);
            
            document.getElementById('instructorPrevPage').addEventListener('click', function() {
                if (instructorCurrentPage > 1) {
                    instructorCurrentPage--;
                    renderInstructorsTable();
                }
            });
            
            document.getElementById('instructorNextPage').addEventListener('click', function() {
                const totalPages = Math.ceil(filteredInstructors.length / itemsPerPage);
                if (instructorCurrentPage < totalPages) {
                    instructorCurrentPage++;
                    renderInstructorsTable();
                }
            });
        }

        function updateCadetPagination(totalPages) {
            const startIndex = (cadetCurrentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(cadetCurrentPage * itemsPerPage, filteredCadets.length);
            
            document.getElementById('cadetShowingStart').textContent = filteredCadets.length > 0 ? startIndex : 0;
            document.getElementById('cadetShowingEnd').textContent = endIndex;
            document.getElementById('cadetTotal').textContent = filteredCadets.length;
            
            document.getElementById('cadetPrevPage').disabled = cadetCurrentPage === 1;
            document.getElementById('cadetNextPage').disabled = cadetCurrentPage === totalPages || totalPages === 0;
            
            const pageNumbersContainer = document.getElementById('cadetPageNumbers');
            pageNumbersContainer.innerHTML = '';
            
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= cadetCurrentPage - 1 && i <= cadetCurrentPage + 1)) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `px-3 py-2 rounded-lg ${i === cadetCurrentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                    pageButton.addEventListener('click', function() {
                        cadetCurrentPage = i;
                        renderCadetsTable();
                    });
                    pageNumbersContainer.appendChild(pageButton);
                } else if (i === cadetCurrentPage - 2 || i === cadetCurrentPage + 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-2 py-2 text-gray-500';
                    pageNumbersContainer.appendChild(ellipsis);
                }
            }
        }

        function updateInstructorPagination(totalPages) {
            const startIndex = (instructorCurrentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(instructorCurrentPage * itemsPerPage, filteredInstructors.length);
            
            document.getElementById('instructorShowingStart').textContent = filteredInstructors.length > 0 ? startIndex : 0;
            document.getElementById('instructorShowingEnd').textContent = endIndex;
            document.getElementById('instructorTotal').textContent = filteredInstructors.length;
            
            document.getElementById('instructorPrevPage').disabled = instructorCurrentPage === 1;
            document.getElementById('instructorNextPage').disabled = instructorCurrentPage === totalPages || totalPages === 0;
            
            const pageNumbersContainer = document.getElementById('instructorPageNumbers');
            pageNumbersContainer.innerHTML = '';
            
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= instructorCurrentPage - 1 && i <= instructorCurrentPage + 1)) {
                    const pageButton = document.createElement('button');
                    pageButton.textContent = i;
                    pageButton.className = `px-3 py-2 rounded-lg ${i === instructorCurrentPage ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'}`;
                    pageButton.addEventListener('click', function() {
                        instructorCurrentPage = i;
                        renderInstructorsTable();
                    });
                    pageNumbersContainer.appendChild(pageButton);
                } else if (i === instructorCurrentPage - 2 || i === instructorCurrentPage + 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.className = 'px-2 py-2 text-gray-500';
                    pageNumbersContainer.appendChild(ellipsis);
                }
            }
        }
    </script>

</x-app-layout>