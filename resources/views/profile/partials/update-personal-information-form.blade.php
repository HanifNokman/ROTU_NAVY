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
        <form method="POST" action="{{ route('personal.update') }}" class="mt-6" enctype="multipart/form-data">
            @csrf
            @method('patch')
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="flex flex-col items-center justify-center">
                    @if (!empty($personal->profile_pic))
                        <img src="{{ asset('storage/' . $personal->profile_pic) }}" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border" />
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($personal->name ?? auth()->user()->name) }}&background=gray&color=fff&size=128" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border" />
                    @endif
                </div>
                <div class="flex flex-col justify-center">
                    <x-input-label for="profile_pic" :value="__('Profile Picture')" />
                    <input id="profile_pic" name="profile_pic" type="file" class="mt-1 block w-full" accept="image/*" />
                    <x-input-error class="mt-2" :messages="$errors->get('profile_pic')" />
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" maxlength="13" :value="$personal->phone_number" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                </div>
                <div>
                    <x-input-label for="gender" :value="__('Gender')" />
                    @php $selectedGender = $personal->gender; @endphp
                    <select id="gender" name="gender" class="mt-1 block w-full">
                        <option value="Male" {{ $selectedGender === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $selectedGender === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>
                <div>
                    <x-input-label for="ic_number" :value="__('IC Number')" />
                    <x-text-input id="ic_number" name="ic_number" type="text" class="mt-1 block w-full" maxlength="15" :value="$personal->ic_number" />
                    <x-input-error class="mt-2" :messages="$errors->get('ic_number')" />
                </div>
                <div>
                    <x-input-label for="matric_no" :value="__('Matric Number')" />
                    <x-text-input id="matric_no" name="matric_no" type="text" class="mt-1 block w-full" maxlength="11" :value="$personal->matric_no" />
                    <x-input-error class="mt-2" :messages="$errors->get('matric_no')" />
                </div>
                <div>
                    <x-input-label for="intake_year" :value="__('Intake Year')" />
                    @php $selectedIntakeYear = $personal->intake_year; $currentYear = date('Y'); @endphp
                    <select id="intake_year" name="intake_year" class="mt-1 block w-full">
                        <option value="">Select Year</option>
                        @for ($year = $currentYear; $year >= $currentYear - 3; $year--)
                            <option value="{{ $year }}" {{ $selectedIntakeYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('intake_year')" />
                </div>
                <div>
                    <x-input-label for="service_number" :value="__('Service Number')" />
                    <x-text-input id="service_number" name="service_number" type="text" class="mt-1 block w-full" maxlength="10" :value="$personal->service_number" />
                    <x-input-error class="mt-2" :messages="$errors->get('service_number')" />
                </div>
                <div>
                    <x-input-label for="rank" :value="__('Rank')" />
                    @php $selectedRank = $personal->rank; @endphp
                    <select id="rank" name="rank" class="mt-1 block w-full">
                        <option value="">Select Rank</option>
                        <option value="PK" {{ $selectedRank === 'PK' ? 'selected' : '' }}>PK</option>
                        <option value="PKK" {{ $selectedRank === 'PKK' ? 'selected' : '' }}>PKK</option>
                        <option value="Lt.M" {{ $selectedRank === 'Lt.M' ? 'selected' : '' }}>Lt.M</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('rank')" />
                </div>
                <div>
                    <x-input-label for="bank_account_number" :value="__('Bank Account Number')" />
                    <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-1 block w-full" maxlength="15" :value="$personal->bank_account_number" />
                    <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
                </div>
                <div>
                    <x-input-label for="current_cgpa" :value="__('Current CGPA')" />
                    <x-text-input id="current_cgpa" name="current_cgpa" type="number" step="0.01" class="mt-1 block w-full" :value="$personal->current_cgpa" />
                    <x-input-error class="mt-2" :messages="$errors->get('current_cgpa')" />
                </div>
                <div>
                    <x-input-label for="past_cgpa" :value="__('Past CGPA')" />
                    <x-text-input id="past_cgpa" name="past_cgpa" type="number" step="0.01" class="mt-1 block w-full" :value="$personal->past_cgpa" />
                    <x-input-error class="mt-2" :messages="$errors->get('past_cgpa')" />
                </div>
                <div>
                    <x-input-label for="BMI" :value="__('BMI')" />
                    <x-text-input id="BMI" name="BMI" type="number" step="0.01" class="mt-1 block w-full" :value="$personal->BMI" />
                    <x-input-error class="mt-2" :messages="$errors->get('BMI')" />
                </div>
            </div>
            <div class="flex items-center gap-4 mt-6">
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
        <form method="POST" action="{{ route('personal.update') }}" class="mt-6" enctype="multipart/form-data">
            @csrf
            @method('patch')
            
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div class="flex flex-col items-center justify-center">
                    @if (!empty($personal->profile_pic))
                        <img src="{{ asset('storage/' . $personal->profile_pic) }}" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border" />
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($personal->name ?? auth()->user()->name) }}&background=gray&color=fff&size=128" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border" />
                    @endif
                </div>
                <div class="flex flex-col justify-center">
                    <x-input-label for="profile_pic" :value="__('Profile Picture')" />
                    <input id="profile_pic" name="profile_pic" type="file" class="mt-1 block w-full" accept="image/*" />
                    <x-input-error class="mt-2" :messages="$errors->get('profile_pic')" />
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" maxlength="13" :value="$personal->phone_number" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                </div>
                <div>
                    <x-input-label for="position" :value="__('Position')" />
                    <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" maxlength="20" :value="$personal->position" />
                    <x-input-error class="mt-2" :messages="$errors->get('position')" />
                </div>
                <div>
                    <x-input-label for="expertise" :value="__('Expertise')" />
                    @php $selectedExpertise = $personal->expertise; @endphp
                    <select id="expertise" name="expertise" class="mt-1 block w-full">
                        <option value="">Select Expertise</option>
                        <option value="PAP" {{ $selectedExpertise === 'PAP' ? 'selected' : '' }}>PAP</option>
                        <option value="JJM" {{ $selectedExpertise === 'JJM' ? 'selected' : '' }}>JJM</option>
                        <option value="PNK" {{ $selectedExpertise === 'PNK' ? 'selected' : '' }}>PNK</option>
                        <option value="TNL" {{ $selectedExpertise === 'TNL' ? 'selected' : '' }}>TNL</option>
                        <option value="BDI" {{ $selectedExpertise === 'BDI' ? 'selected' : '' }}>BDI</option>
                        <option value="KOM" {{ $selectedExpertise === 'KOM' ? 'selected' : '' }}>KOM</option>
                        <option value="PKOR" {{ $selectedExpertise === 'PKOR' ? 'selected' : '' }}>PKOR</option>
                        <option value="Admin" {{ $selectedExpertise === 'Admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('expertise')" />
                </div>
                <div>
                    <x-input-label for="past_unit" :value="__('Past Unit(s)')" />
                    <table class="w-full mb-2">
                        <tbody id="past-unit-table">
                            @php
                                $pastUnits = !empty($personal->past_unit) ? json_decode($personal->past_unit, true) ?? [] : [];
                            @endphp
                            @for ($i = 0; $i < max(1, count($pastUnits)); $i++)
                                <tr>
                                    <td>
                                        <x-text-input name="past_unit[]" type="text" class="mt-1 block w-full" maxlength="32" :value="$pastUnits[$i] ?? ''" />
                                    </td>
                                    <td>
                                        <button type="button" class="remove-past-unit px-2 py-1 bg-red-500 text-white rounded">Remove</button>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                    <button type="button" id="add-past-unit" class="px-3 py-1 bg-blue-500 text-white rounded">Add Past Unit</button>
                    <x-input-error class="mt-2" :messages="$errors->get('past_unit')" />
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const addBtn = document.getElementById('add-past-unit');
                            const table = document.getElementById('past-unit-table');
                            addBtn.addEventListener('click', function() {
                                const row = document.createElement('tr');
                                row.innerHTML = `<td><input name='past_unit[]' type='text' class='mt-1 block w-full' maxlength='32'></td><td><button type='button' class='remove-past-unit px-2 py-1 bg-red-500 text-white rounded'>Remove</button></td>`;
                                table.appendChild(row);
                            });
                            table.addEventListener('click', function(e) {
                                if (e.target.classList.contains('remove-past-unit')) {
                                    e.target.closest('tr').remove();
                                }
                            });
                        });
                    </script>
                </div>
                <div>
                    <x-input-label for="service_number" :value="__('Service Number')" />
                    <x-text-input id="service_number" name="service_number" type="text" class="mt-1 block w-full" maxlength="10" :value="$personal->service_number" />
                    <x-input-error class="mt-2" :messages="$errors->get('service_number')" />
                </div>
                <div>
                    <x-input-label for="rank" :value="__('Rank')" />
                    @php $selectedRank = $personal->rank; @endphp
                    <select id="rank" name="rank" class="mt-1 block w-full">
                        <option value="">Select Rank</option>
                        <option value="LKII" {{ $selectedRank === 'LKII' ? 'selected' : '' }}>LKII</option>
                        <option value="LKI" {{ $selectedRank === 'LKI' ? 'selected' : '' }}>LKI</option>
                        <option value="LK" {{ $selectedRank === 'LK' ? 'selected' : '' }}>LK</option>
                        <option value="BM" {{ $selectedRank === 'BM' ? 'selected' : '' }}>BM</option>
                        <option value="BK" {{ $selectedRank === 'BK' ? 'selected' : '' }}>BK</option>
                        <option value="PWI" {{ $selectedRank === 'PWI' ? 'selected' : '' }}>PWI</option>
                        <option value="PWII" {{ $selectedRank === 'PWII' ? 'selected' : '' }}>PWII</option>
                        <option value="Lt.M" {{ $selectedRank === 'Lt.M' ? 'selected' : '' }}>Lt.M</option>
                        <option value="Lt.Dya" {{ $selectedRank === 'Lt.Dya' ? 'selected' : '' }}>Lt.Dya</option>
                        <option value="Lt" {{ $selectedRank === 'Lt' ? 'selected' : '' }}>Lt</option>
                        <option value="Lt.Kdr" {{ $selectedRank === 'Lt.Kdr' ? 'selected' : '' }}>Lt.Kdr</option>
                        <option value="Kdr" {{ $selectedRank === 'Kdr' ? 'selected' : '' }}>Kdr</option>
                        <option value="Kpt" {{ $selectedRank === 'Kpt' ? 'selected' : '' }}>Kpt</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('rank')" />
                </div>
                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    @php $selectedStatus = $personal->status; @endphp
                    <select id="status" name="status" class="mt-1 block w-full">
                        <option value="">Select Status</option>
                        <option value="Active" {{ $selectedStatus === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Relocated" {{ $selectedStatus === 'Relocated' ? 'selected' : '' }}>Relocated</option>
                        <option value="Retired" {{ $selectedStatus === 'Retired' ? 'selected' : '' }}>Retired</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>
                <div>
                    <x-input-label for="time_in_service" :value="__('Time in Service (years)')" />
                    <x-text-input id="time_in_service" name="time_in_service" type="number" min="0" step="1" class="mt-1 block w-full" :value="$personal->time_in_service" />
                    <x-input-error class="mt-2" :messages="$errors->get('time_in_service')" />
                </div>
                <div>
                    <x-input-label for="ttp" :value="__('TTP Date')" />
                    <input id="ttp" name="ttp" type="date" class="mt-1 block w-full"
                        value="{{ $personal->ttp }}" />
                    <x-input-error class="mt-2" :messages="$errors->get('ttp')" />
                </div>
            </div>
            <div class="flex items-center gap-4 mt-6">
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