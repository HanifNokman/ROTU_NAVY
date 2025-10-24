<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Security Notice -->
        <div class="p-4 rounded-lg bg-blue-50 border border-blue-200">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <p class="text-sm text-blue-800">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </div>
        </div>

        <div class="space-y-5">
            <!-- Current Password -->
            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-semibold text-gray-700" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <x-text-input
                        id="update_password_current_password"
                        name="current_password"
                        type="password"
                        class="block w-full pl-10 pr-12 py-2.5 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all"
                        autocomplete="current-password"
                        placeholder="Enter your current password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        onmousedown="document.getElementById('update_password_current_password').type='text'"
                        onmouseup="document.getElementById('update_password_current_password').type='password'"
                        onmouseleave="document.getElementById('update_password_current_password').type='password'"
                        ontouchstart="document.getElementById('update_password_current_password').type='text'"
                        ontouchend="document.getElementById('update_password_current_password').type='password'"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <!-- New Password -->
            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-semibold text-gray-700" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <x-text-input
                        id="update_password_password"
                        name="password"
                        type="password"
                        class="block w-full pl-10 pr-12 py-2.5 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all"
                        autocomplete="new-password"
                        placeholder="Enter a strong new password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        onmousedown="document.getElementById('update_password_password').type='text'"
                        onmouseup="document.getElementById('update_password_password').type='password'"
                        onmouseleave="document.getElementById('update_password_password').type='password'"
                        ontouchstart="document.getElementById('update_password_password').type='text'"
                        ontouchend="document.getElementById('update_password_password').type='password'"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm New Password')" class="text-sm font-semibold text-gray-700" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <x-text-input
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        type="password"
                        class="block w-full pl-10 pr-12 py-2.5 rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 transition-all"
                        autocomplete="new-password"
                        placeholder="Confirm your new password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors"
                        onmousedown="document.getElementById('update_password_password_confirmation').type='text'"
                        onmouseup="document.getElementById('update_password_password_confirmation').type='password'"
                        onmouseleave="document.getElementById('update_password_password_confirmation').type='password'"
                        ontouchstart="document.getElementById('update_password_password_confirmation').type='text'"
                        ontouchend="document.getElementById('update_password_password_confirmation').type='password'"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold rounded-lg hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-md hover:shadow-lg"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-sm font-medium text-green-600"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ __('Password updated successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>
