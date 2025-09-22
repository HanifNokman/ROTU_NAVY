<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Verification (Instructor)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Account Verification
                </h1>
                <p class="text-gray-600">Review and approve pending account registrations</p>
            </div>

            <!-- Verification Section with Tabs -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pending Accounts
                    </h2>
                    <p class="text-gray-600">Review registration requests by role and take appropriate actions</p>
                </div>

                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 text-green-600 bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    <!-- Tab Navigation -->
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <button id="cadets-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm
                                    {{ $pendingCadets->count() > 0 ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                                    Cadets ({{ $pendingCadets->count() }})
                                </button>
                                <button id="instructors-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm
                                    {{ $pendingInstructors->count() > 0 ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
                                    {{ $pendingCadets->count() == 0 ? 'border-blue-500 text-blue-600' : '' }}">
                                    Instructors ({{ $pendingInstructors->count() }})
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- Cadets Tab Content -->
                    <div id="cadets-content" class="tab-content {{ $pendingCadets->count() > 0 ? 'block' : 'hidden' }}">
                        @if($pendingCadets->count() > 0)
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                    Pending Cadet Registrations
                                </h3>
                                <p class="text-sm text-gray-600">Review and approve cadet account requests</p>
                            </div>

                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingCadets as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    <form method="POST" action="{{ route('pending.verification.accept', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('pending.verification.reject', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                                <p class="text-lg font-medium text-gray-900 mb-1">No pending cadet registrations</p>
                                <p class="text-sm text-gray-500">All cadet registration requests have been processed</p>
                            </div>
                        @endif
                    </div>

                    <!-- Instructors Tab Content -->
                    <div id="instructors-content" class="tab-content {{ $pendingCadets->count() == 0 ? 'block' : 'hidden' }}">
                        @if($pendingInstructors->count() > 0)
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Pending Instructor Registrations
                                </h3>
                                <p class="text-sm text-gray-600">Review and approve instructor account requests</p>
                            </div>

                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pendingInstructors as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    <form method="POST" action="{{ route('pending.verification.accept', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('pending.verification.reject', $user) }}">
                                                        @csrf
                                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold shadow-md transition-colors duration-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <p class="text-lg font-medium text-gray-900 mb-1">No pending instructor registrations</p>
                                <p class="text-sm text-gray-500">All instructor registration requests have been processed</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cadetsTab = document.getElementById('cadets-tab');
            const instructorsTab = document.getElementById('instructors-tab');
            const cadetsContent = document.getElementById('cadets-content');
            const instructorsContent = document.getElementById('instructors-content');

            // Tab switching functionality
            cadetsTab.addEventListener('click', function() {
                cadetsTab.className = cadetsTab.className.replace('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'border-blue-500 text-blue-600');
                instructorsTab.className = instructorsTab.className.replace('border-blue-500 text-blue-600', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                cadetsContent.classList.remove('hidden');
                cadetsContent.classList.add('block');
                instructorsContent.classList.remove('block');
                instructorsContent.classList.add('hidden');
            });

            instructorsTab.addEventListener('click', function() {
                instructorsTab.className = instructorsTab.className.replace('border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'border-blue-500 text-blue-600');
                cadetsTab.className = cadetsTab.className.replace('border-blue-500 text-blue-600', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300');

                instructorsContent.classList.remove('hidden');
                instructorsContent.classList.add('block');
                cadetsContent.classList.remove('block');
                cadetsContent.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
