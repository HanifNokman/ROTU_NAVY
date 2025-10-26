<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <style>
    /* ========================================= */
    /* CUSTOM SCROLLBAR STYLES */
    /* ========================================= */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, #94a3b8 0%, #64748b 100%);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, #64748b 0%, #475569 100%);
    }

    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #f1f5f9;
    }

    /* ========================================= */
    /* CARD & ANIMATION STYLES */
    /* ========================================= */
    .profile-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
        background: #ffffff;
    }

    .profile-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px -5px rgba(0, 0, 0, 0.1), 0 6px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #d1d5db;
    }

    .section-header {
        padding: 1.5rem;
        border-bottom: 2px solid #f3f4f6;
        background: linear-gradient(to right, #f8fafc 0%, #f1f5f9 100%);
    }

    /* ========================================= */
    /* GRADIENT BACKGROUNDS */
    /* ========================================= */
    .gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* ========================================= */
    /* ICON STYLES */
    /* ========================================= */
    .icon-wrapper {
        width: 3rem;
        height: 3rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ========================================= */
    /* INPUT STYLES */
    /* ========================================= */
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="date"],
    input[type="file"],
    select {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus,
    input[type="date"]:focus,
    select:focus {
        border-color: #3b82f6;
        ring-color: rgba(59, 130, 246, 0.5);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* ========================================= */
    /* BUTTON STYLES */
    /* ========================================= */
    .btn-gradient {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        transition: all 0.3s ease;
    }

    .btn-gradient:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Card -->
            <div class="profile-card bg-white shadow-md rounded-xl overflow-hidden">
                <div class="section-header flex items-center gap-3">
                    <div class="icon-wrapper gradient-blue">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Profile Information</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Manage your account details</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Personal Information Card -->
            <div class="profile-card bg-white shadow-md rounded-xl overflow-hidden">
                <div class="section-header flex items-center gap-3">
                    <div class="icon-wrapper gradient-purple">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Personal Information</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Additional details based on your role</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    @include('profile.partials.update-personal-information-form', ['personal' => $personal])
                </div>
            </div>

            <!-- Security Card -->
            <div class="profile-card bg-white shadow-md rounded-xl overflow-hidden">
                <div class="section-header flex items-center gap-3">
                    <div class="icon-wrapper gradient-green">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Security Settings</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Update your password</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Danger Zone Card -->
            <div class="profile-card bg-white shadow-md rounded-xl overflow-hidden border-red-200">
                <div class="section-header flex items-center gap-3" style="background: linear-gradient(to right, #fef2f2 0%, #fee2e2 100%);">
                    <div class="icon-wrapper gradient-red">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-red-800">Danger Zone</h3>
                        <p class="text-sm text-red-600 mt-0.5">Permanently delete your account</p>
                    </div>
                </div>
                <div class="p-6 sm:p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    
    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>
</x-app-layout>
