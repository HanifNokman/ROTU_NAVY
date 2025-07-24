<section class="mt-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Personal Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Manage additional personal details depending on your role.") }}
        </p>
    </header>

    @if (auth()->user()->role === 'cadet')
        <form method="POST" action="{{ route('personal.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                    :value="old('phone_number', $personal->phone_number ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="mt-1 block w-full">
                    <option value="Male" {{ old('gender', $personal->gender ?? '') === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $personal->gender ?? '') === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>
            <div>
                <x-input-label for="bank_account_number" :value="__('Bank Account Number')" />
                <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full"
                    :value="old('bank_account_number', $personal->bank_account_number ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
            </div>
            <div>
                <x-input-label for="rank" :value="__('Rank')" />
                <select id="rank" name="rank" class="mt-1 block w-full">
                    <option value="">Select Rank</option>
                    <option value="PK" {{ old('rank', $personal->rank ?? '') === 'PK' ? 'selected' : '' }}>PK</option>
                    <option value="PKK" {{ old('rank', $personal->rank ?? '') === 'PKK' ? 'selected' : '' }}>PKK</option>
                    <option value="Lt.M" {{ old('rank', $personal->rank ?? '') === 'Lt.M' ? 'selected' : '' }}>Lt.M</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('rank')" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                @if (session('status') === 'personal-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition
                       x-init="setTimeout(() => show = false, 2000)"
                       class="text-sm text-gray-600">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </div>
        </form>
    @elseif (auth()->user()->role === 'instructor')
        <form method="POST" action="{{ route('personal.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                    :value="old('phone_number', $personal->phone_number ?? '')" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>
            <div>
                <x-input-label for="rank" :value="__('Rank')" />
                <select id="rank" name="rank" class="mt-1 block w-full">
                    <option value="">Select Rank</option>
                    <option value="LKII" {{ old('rank', $personal->rank ?? '') === 'LKII' ? 'selected' : '' }}>LKII</option>
                    <option value="LKI" {{ old('rank', $personal->rank ?? '') === 'LKI' ? 'selected' : '' }}>LKI</option>
                    <option value="LK" {{ old('rank', $personal->rank ?? '') === 'LK' ? 'selected' : '' }}>LK</option>
                    <option value="BM" {{ old('rank', $personal->rank ?? '') === 'BM' ? 'selected' : '' }}>BM</option>
                    <option value="BK" {{ old('rank', $personal->rank ?? '') === 'BK' ? 'selected' : '' }}>BK</option>
                    <option value="PWI" {{ old('rank', $personal->rank ?? '') === 'PWI' ? 'selected' : '' }}>PWI</option>
                    <option value="PWII" {{ old('rank', $personal->rank ?? '') === 'PWII' ? 'selected' : '' }}>PWII</option>
                    <option value="Lt.M" {{ old('rank', $personal->rank ?? '') === 'Lt.M' ? 'selected' : '' }}>Lt.M</option>
                    <option value="Lt.Dya" {{ old('rank', $personal->rank ?? '') === 'Lt.Dya' ? 'selected' : '' }}>Lt.Dya</option>
                    <option value="Lt" {{ old('rank', $personal->rank ?? '') === 'Lt' ? 'selected' : '' }}>Lt</option>
                    <option value="Lt.Kdr" {{ old('rank', $personal->rank ?? '') === 'Lt.Kdr' ? 'selected' : '' }}>Lt.Kdr</option>
                    <option value="Kdr" {{ old('rank', $personal->rank ?? '') === 'Kdr' ? 'selected' : '' }}>Kdr</option>
                    <option value="Kpt" {{ old('rank', $personal->rank ?? '') === 'Kpt' ? 'selected' : '' }}>Kpt</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('rank')" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                @if (session('status') === 'personal-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition
                       x-init="setTimeout(() => show = false, 2000)"
                       class="text-sm text-gray-600">
                        {{ __('Saved.') }}
                    </p>
                @endif
            </div>
        </form>
    @endif
</section>
