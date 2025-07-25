<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Instructor Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row gap-6">
            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                <img src="{{ $instructor?->profile_pic ? asset('storage/' . $instructor->profile_pic) : asset('images/default.png') }}"
                     alt="Profile Picture"
                     class="w-60 h-80 object-cover border rounded">
            </div>

            <!-- Profile Information -->
            <div class="flex-1 space-y-6">
                <!-- Row 1 -->
                <div class="flex flex-col md:flex-row items-center gap-4">
                    <button class="bg-gray-100 text-gray-800 font-bold px-6 py-2 rounded shadow whitespace-nowrap">
                        🛡️ Personal Profile
                    </button>
                    <p class="text-2xl font-semibold text-gray-800">
                        {{ ($instructor?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') }}
                    </p>
                </div>

                <!-- Row 2: Contact Info -->
                <div>
                    <p class="text-gray-500 font-semibold mb-2">Contact Information</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <p><strong>Phone:</strong> {{ $instructor?->phone_number ?? 'Not set' }}</p>
                        <p><strong>Email:</strong> {{ $user?->email ?? 'Not set' }}</p>
                    </div>
                </div>

                <!-- Row 3: General Info -->
                <div>
                    <p class="text-gray-500 font-semibold mb-2">General Information</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div><strong>Position:</strong> {{ $instructor->position ?? '-' }}</div>
                    <div><strong>Expertise:</strong> {{ $instructor->expertise ?? '-' }}</div>
                    <div><strong>Time in Service:</strong> {{ $instructor->time_in_service ?? '-' }}</div>
                    <div><strong>TTP:</strong> {{ $instructor->ttp ?? '-' }}</div>
                    <div><strong>Status:</strong> {{ $instructor->status ?? '-' }}</div>
                    <div><strong>Service Number:</strong> {{ $instructor->service_number ?? '-' }}</div>
                    <div><strong>Past Unit:</strong> {{ is_array($instructor->past_unit) ? implode(', ', $instructor->past_unit) : ($instructor->past_unit ?? '-') }}</div>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
