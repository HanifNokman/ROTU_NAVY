<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadet Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row gap-6">
            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                <img src="{{ $cadet?->profile_pic ? asset('storage/' . $cadet->profile_pic) : asset('images/default.png') }}"
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
                        {{ ($cadet?->rank ?? 'Unknown') . ' ' . ($user?->name ?? 'No Name') }}
                    </p>
                </div>

                <!-- Row 2: Contact Info -->
                <div>
                    <p class="text-gray-500 font-semibold mb-2">Contact Information</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <p><strong>Phone:</strong> {{ $cadet?->phone_number ?? 'Not set' }}</p>
                        <p><strong>Email:</strong> {{ $user?->email ?? 'Not set' }}</p>
                    </div>
                </div>

                <!-- Row 3: General Info -->
                <div>
                    <p class="text-gray-500 font-semibold mb-2">General Information</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><strong>Gender:</strong> {{ $cadet->gender ?? '-' }}</div>
                        <div><strong>Bank Account Number:</strong> {{ $cadet->bank_account_number ?? '-' }}</div>
                        <div><strong>Matric Number:</strong> {{ $cadet->matric_no ?? '-' }}</div>
                        <div><strong>Intake Year:</strong> {{ $cadet->intake_year ?? '-' }}</div>
                        <div><strong>Current CGPA:</strong> {{ $cadet->current_cgpa ?? '-' }}</div>
                        <div><strong>IC Number:</strong> {{ $cadet->ic_number ?? '-' }}</div>
                        <div><strong>BMI:</strong> {{ $cadet->BMI ?? '-' }}</div>
                        <div><strong>Swimming Qualification:</strong> {{ $cadet->swimming_qualification ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
