<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Access Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- ================================================================ --}}
            {{-- ALERT MESSAGES --}}
            {{-- ================================================================ --}}
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ================================================================ --}}
            {{-- TRANSFER ADMIN ROLE FORM --}}
            {{-- ================================================================ --}}
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Transfer Admin Role</h3>
                    <p class="text-gray-600 mb-6">
                        As the current Admin, you can transfer your admin privileges to another instructor. 
                        Your expertise will be changed to YO after the transfer.
                    </p>

                    <form method="POST" action="{{ route('admin.access_management.transfer') }}" class="space-y-6">
                        @csrf

                        {{-- Instructor Selection --}}
                        <div>
                            <label for="instructor_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Select Instructor to Promote to Admin
                            </label>
                            <select 
                                id="instructor_id" 
                                name="instructor_id" 
                                required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                            >
                                <option value="">-- Select an Instructor --</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->user->name }} ({{ $instructor->rank ?? 'No Rank' }}) - Current Expertise: {{ $instructor->expertise ?? 'None' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('instructor_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirm Your Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm pr-10"
                                    placeholder="Enter your current password"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword()" 
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5"
                                >
                                    <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg id="eye-off-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                Enter your password to confirm this admin role transfer.
                            </p>
                        </div>

                        {{-- Warning Message --}}
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        <strong>Warning:</strong> This action will transfer your Admin privileges to the selected instructor. 
                                        Your expertise will be changed to YO. This action cannot be undone without the new Admin's approval.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex items-center justify-end space-x-4">
                            <a 
                                href="{{ route('admin.dashboard') }}" 
                                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Cancel
                            </a>
                            <button 
                                type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Transfer Admin Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- CURRENT ADMIN INFORMATION 
            {{-- ================================================================ --}}
            
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Current Admin Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="text-base font-medium">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="text-base font-medium">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Current Role</p>
                            <p class="text-base font-medium">{{ auth()->user()->role }}</p>
                        </div>
                        @if(auth()->user()->instructor)
                            <div>
                                <p class="text-sm text-gray-600">Current Expertise</p>
                                <p class="text-base font-medium">{{ auth()->user()->instructor->expertise ?? 'Not Set' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>