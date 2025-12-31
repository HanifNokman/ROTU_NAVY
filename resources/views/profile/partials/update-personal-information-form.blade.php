<section>

    @if (auth()->user()->role === 'cadet')
        <form method="POST" action="{{ route('personal.update') }}" class="space-y-8" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <!-- Profile Picture Section -->
            <div class="bg-gradient-to-r from-purple-50 to-blue-50 p-6 rounded-xl border border-purple-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="relative">
                            @if (!empty($personal->profile_pic))
                                <img src="{{ asset('storage/' . $personal->profile_pic) }}" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($personal->name ?? auth()->user()->name) }}&background=8b5cf6&color=fff&size=128" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg" />
                            @endif
                            <div class="absolute bottom-0 right-0 w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center border-2 border-white shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center">
                        <x-input-label for="profile_pic" :value="__('Profile Picture')" class="text-sm font-semibold text-gray-700 mb-2" />
                        <input id="profile_pic" name="profile_pic" type="file" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer border border-gray-300 rounded-lg transition-all" accept="image/*" onchange="validateFileSize(this, 'cadet')" />
                        <p class="mt-2 text-xs text-gray-500">Recommended: Square image, at least 128x128 pixels. Max size: 2MB</p>
                        <p id="file-size-error-cadet" class="mt-2 text-xs text-red-600 hidden"></p>
                        <x-input-error class="mt-2" :messages="$errors->get('profile_pic')" />
                    </div>
                </div>
            </div>
            
            <!-- Personal Details Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Personal Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="phone_number" :value="__('Phone Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="phone_number" name="phone_number" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" maxlength="13" :value="$personal->phone_number" placeholder="+60123456789" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                    </div>
                    <div>
                        <x-input-label for="gender" :value="__('Gender')" class="text-sm font-semibold text-gray-700" />
                        @php $selectedGender = $personal->gender; @endphp
                        <select id="gender" name="gender" class="mt-2 block w-full px-4 py-2.5 rounded-lg border-gray-300 {{ !empty($selectedGender) ? 'bg-gray-50' : '' }}" {{ !empty($selectedGender) ? 'disabled' : '' }}>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ $selectedGender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $selectedGender === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                        @if(!empty($selectedGender))
                            <input type="hidden" name="gender" value="{{ $selectedGender }}" />
                            <p class="mt-1 text-xs text-gray-500">This field cannot be modified</p>
                        @else
                            <p class="mt-1 text-xs text-blue-600">You can fill this field once. After saving, it cannot be changed.</p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                    </div>
                </div>
            </div>

            <!-- Identification Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Identification</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="ic_number" :value="__('IC Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="ic_number" name="ic_number" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg {{ !empty($personal->ic_number) ? 'bg-gray-50' : '' }}" maxlength="15" :value="$personal->ic_number" :disabled="!empty($personal->ic_number)" placeholder="Enter IC number" />
                        @if(!empty($personal->ic_number))
                            <input type="hidden" name="ic_number" value="{{ $personal->ic_number }}" />
                            <p class="mt-1 text-xs text-gray-500">This field cannot be modified</p>
                        @else
                            <p class="mt-1 text-xs text-blue-600">You can fill this field once. After saving, it cannot be changed.</p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('ic_number')" />
                    </div>
                    <div>
                        <x-input-label for="matric_no" :value="__('Matric Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="matric_no" name="matric_no" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg {{ !empty($personal->matric_no) ? 'bg-gray-50' : '' }}" maxlength="11" :value="$personal->matric_no" :disabled="!empty($personal->matric_no)" placeholder="Enter matric number" />
                        @if(!empty($personal->matric_no))
                            <input type="hidden" name="matric_no" value="{{ $personal->matric_no }}" />
                            <p class="mt-1 text-xs text-gray-500">This field cannot be modified</p>
                        @else
                            <p class="mt-1 text-xs text-blue-600">You can fill this field once. After saving, it cannot be changed.</p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('matric_no')" />
                    </div>
                </div>
            </div>

            <!-- Academic Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Academic Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="intake_year" :value="__('Intake Year')" class="text-sm font-semibold text-gray-700" />
                        @php $selectedIntakeYear = $personal->intake_year; $currentYear = date('Y'); @endphp
                        <select id="intake_year" name="intake_year" class="mt-2 block w-full px-4 py-2.5 rounded-lg border-gray-300 {{ !empty($selectedIntakeYear) ? 'bg-gray-50' : '' }}" {{ !empty($selectedIntakeYear) ? 'disabled' : '' }}>
                            <option value="">Select Year</option>
                            @for ($year = $currentYear; $year >= $currentYear - 3; $year--)
                                <option value="{{ $year }}" {{ $selectedIntakeYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        @if(!empty($selectedIntakeYear))
                            <input type="hidden" name="intake_year" value="{{ $selectedIntakeYear }}" />
                            <p class="mt-1 text-xs text-gray-500">This field cannot be modified</p>
                        @else
                            <p class="mt-1 text-xs text-blue-600">You can fill this field once. After saving, it cannot be changed.</p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('intake_year')" />
                    </div>
                    <div>
                        <x-input-label for="current_cgpa" :value="__('Current CGPA')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="current_cgpa" name="current_cgpa" type="number" step="0.01" class="mt-2 block w-full px-4 py-2.5 rounded-lg" :value="$personal->current_cgpa" placeholder="0.00" />
                        <x-input-error class="mt-2" :messages="$errors->get('current_cgpa')" />
                    </div>
                    <div>
                        <x-input-label for="past_cgpa" :value="__('Past CGPA')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="past_cgpa" name="past_cgpa" type="number" step="0.01" class="mt-2 block w-full px-4 py-2.5 rounded-lg" :value="$personal->past_cgpa" placeholder="0.00" />
                        <x-input-error class="mt-2" :messages="$errors->get('past_cgpa')" />
                    </div>
                    <div>
                        <x-input-label for="faculty" :value="__('Faculty')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="faculty" name="faculty" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" :value="$personal->faculty" placeholder="Enter faculty" />
                        <x-input-error class="mt-2" :messages="$errors->get('faculty')" />
                    </div>
                    <div>
                        <x-input-label for="course" :value="__('Course')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="course" name="course" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" :value="$personal->course" placeholder="Enter course" />
                        <x-input-error class="mt-2" :messages="$errors->get('course')" />
                    </div>
                </div>
            </div>

            <!-- Military Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Military Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="service_number" :value="__('Service Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="service_number" name="service_number" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" maxlength="10" :value="$personal->service_number" placeholder="Enter service number" />
                        <x-input-error class="mt-2" :messages="$errors->get('service_number')" />
                    </div>
                    <div>
                        <x-input-label for="rank" :value="__('Rank')" class="text-sm font-semibold text-gray-700" />
                        @php $selectedRank = $personal->rank; @endphp
                        <select id="rank" name="rank" class="mt-2 block w-full px-4 py-2.5 rounded-lg border-gray-300 {{ !empty($selectedRank) ? 'bg-gray-50' : '' }}" {{ !empty($selectedRank) ? 'disabled' : '' }}>
                            <option value="">Select Rank</option>
                            <option value="PK" {{ $selectedRank === 'PK' ? 'selected' : '' }}>PK</option>
                            <option value="PKK" {{ $selectedRank === 'PKK' ? 'selected' : '' }}>PKK</option>
                        </select>
                        @if(!empty($selectedRank))
                            <input type="hidden" name="rank" value="{{ $selectedRank }}" />
                            <p class="mt-1 text-xs text-gray-500">This field cannot be modified</p>
                        @else
                            <p class="mt-1 text-xs text-blue-600">You can fill this field once. After saving, it cannot be changed.</p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('rank')" />
                    </div>
                    <div>
                        <x-input-label for="ttp_date" :value="__('TTP Date')" class="text-sm font-semibold text-gray-700" />
                        <input id="ttp_date" name="ttp_date" type="date" class="mt-2 block w-full px-4 py-2.5 rounded-lg border-gray-300" value="{{ $personal->ttp_date ? \Carbon\Carbon::parse($personal->ttp_date)->format('Y-m-d') : '' }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('ttp_date')" />
                    </div>
                    <div>
                        <x-input-label for="insurance_number" :value="__('Insurance Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="insurance_number" name="insurance_number" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" maxlength="50" :value="$personal->insurance_number" placeholder="Enter insurance number" />
                        <x-input-error class="mt-2" :messages="$errors->get('insurance_number')" />
                    </div>
                </div>
            </div>

            <!-- Financial Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Financial Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="bank_account_number" :value="__('Bank Account Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="bank_account_number" name="bank_account_number" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" maxlength="15" :value="$personal->bank_account_number" placeholder="Enter bank account number" />
                        <x-input-error class="mt-2" :messages="$errors->get('bank_account_number')" />
                    </div>
                </div>
            </div>

            <!-- Health Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-pink-100 rounded-lg">
                        <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Health Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="BMI" :value="__('BMI')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="BMI" name="BMI" type="number" step="0.01" class="mt-2 block w-full px-4 py-2.5 rounded-lg" :value="$personal->BMI" placeholder="Enter BMI" />
                        <x-input-error class="mt-2" :messages="$errors->get('BMI')" />
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Save Changes') }}
                </button>
                @if (session('status') === 'personal-updated')
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
                        {{ __('Saved successfully!') }}
                    </p>
                @endif
            </div>
        </form>
    @elseif (auth()->user()->role === 'instructor')
        <form method="POST" action="{{ route('personal.update') }}" class="space-y-8" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <!-- Profile Picture Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="relative">
                            @if (!empty($personal->profile_pic))
                                <img src="{{ asset('storage/' . $personal->profile_pic) }}" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($personal->name ?? auth()->user()->name) }}&background=3b82f6&color=fff&size=128" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg" />
                            @endif
                            <div class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center border-2 border-white shadow-md">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-center">
                        <x-input-label for="profile_pic" :value="__('Profile Picture')" class="text-sm font-semibold text-gray-700 mb-2" />
                        <input id="profile_pic" name="profile_pic" type="file" class="block w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer border border-gray-300 rounded-lg transition-all" accept="image/*" onchange="validateFileSize(this, 'instructor')" />
                        <p class="mt-2 text-xs text-gray-500">Recommended: Square image, at least 128x128 pixels. Max size: 2MB</p>
                        <p id="file-size-error-instructor" class="mt-2 text-xs text-red-600 hidden"></p>
                        <x-input-error class="mt-2" :messages="$errors->get('profile_pic')" />
                    </div>
                </div>
            </div>

            <!-- Personal Details Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Personal Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="phone_number" :value="__('Phone Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="phone_number" name="phone_number" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" maxlength="13" :value="$personal->phone_number" placeholder="+60123456789" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                    </div>
                    <div>
                        <x-input-label for="position" :value="__('Position')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="position" name="position" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" maxlength="20" :value="$personal->position" placeholder="Enter position" />
                        <x-input-error class="mt-2" :messages="$errors->get('position')" />
                    </div>
                </div>
            </div>

            <!-- Expertise Information Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Expertise Information</h3>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <x-input-label for="expertise" :value="__('Expertise')" class="text-sm font-semibold text-gray-700" />
                        @php $selectedExpertise = $personal->expertise; @endphp
                        <select id="expertise" name="expertise" class="mt-2 block w-full px-4 py-2.5 rounded-lg border-gray-300 {{ $selectedExpertise === 'Admin' ? 'bg-gray-50' : '' }}" {{ $selectedExpertise === 'Admin' ? 'disabled' : '' }}>
                            <option value="">Select Expertise</option>
                            <option value="PAP" {{ $selectedExpertise === 'PAP' ? 'selected' : '' }}>PAP</option>
                            <option value="JJM" {{ $selectedExpertise === 'JJM' ? 'selected' : '' }}>JJM</option>
                            <option value="PNK" {{ $selectedExpertise === 'PNK' ? 'selected' : '' }}>PNK</option>
                            <option value="TNL" {{ $selectedExpertise === 'TNL' ? 'selected' : '' }}>TNL</option>
                            <option value="BDI" {{ $selectedExpertise === 'BDI' ? 'selected' : '' }}>BDI</option>
                            <option value="KOM" {{ $selectedExpertise === 'KOM' ? 'selected' : '' }}>KOM</option>
                            <option value="PKOR" {{ $selectedExpertise === 'PKOR' ? 'selected' : '' }}>PKOR</option>
                            <option value="YO" {{ $selectedExpertise === 'YO' ? 'selected' : '' }}>YO</option>
                            @if($personal->expertise === 'Admin')
                                <option value="Admin" {{ $selectedExpertise === 'Admin' ? 'selected' : '' }}>Admin</option>
                            @endif
                        </select>
                        @if($personal->expertise === 'Admin')
                            <p class="text-xs text-gray-500 mt-1">Admin expertise cannot be changed through this form</p>
                        @endif
                        <x-input-error class="mt-2" :messages="$errors->get('expertise')" />
                    </div>
                    <div>
                        <x-input-label for="past_unit" :value="__('Past Unit(s)')" class="text-sm font-semibold text-gray-700 mb-2" />
                        <div class="space-y-3">
                            <div id="past-unit-table" class="space-y-2">
                                @php
                                    $pastUnits = !empty($personal->past_unit) ? json_decode($personal->past_unit, true) ?? [] : [];
                                @endphp
                                @for ($i = 0; $i < max(1, count($pastUnits)); $i++)
                                    <div class="flex gap-2">
                                        <x-text-input name="past_unit[]" type="text" class="flex-1 px-4 py-2.5 rounded-lg" maxlength="32" :value="$pastUnits[$i] ?? ''" placeholder="Enter past unit" />
                                        <button type="button" class="remove-past-unit inline-flex items-center gap-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endfor
                            </div>
                            <button type="button" id="add-past-unit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Past Unit
                            </button>
                            <x-input-error class="mt-2" :messages="$errors->get('past_unit')" />
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const addBtn = document.getElementById('add-past-unit');
                                const container = document.getElementById('past-unit-table');
                                addBtn.addEventListener('click', function() {
                                    const div = document.createElement('div');
                                    div.className = 'flex gap-2';
                                    div.innerHTML = `<input name='past_unit[]' type='text' class='flex-1 px-4 py-2.5 rounded-lg border-gray-300' maxlength='32' placeholder='Enter past unit'>
                                        <button type='button' class='remove-past-unit inline-flex items-center gap-1 px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors'>
                                            <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12'></path></svg>
                                        </button>`;
                                    container.appendChild(div);
                                });
                                container.addEventListener('click', function(e) {
                                    if (e.target.closest('.remove-past-unit')) {
                                        e.target.closest('.flex').remove();
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            <!-- Military Information Section -->
            <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3 mb-5 pb-3 border-b border-gray-100">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Military Information</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="service_number" :value="__('Service Number')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="service_number" name="service_number" type="text" class="mt-2 block w-full px-4 py-2.5 rounded-lg" maxlength="10" :value="$personal->service_number" placeholder="Enter service number" />
                        <x-input-error class="mt-2" :messages="$errors->get('service_number')" />
                    </div>
                    <div>
                        <x-input-label for="rank" :value="__('Rank')" class="text-sm font-semibold text-gray-700" />
                        @php $selectedRank = $personal->rank; @endphp
                        <select id="rank" name="rank" class="mt-2 block w-full px-4 py-2.5 rounded-lg border-gray-300">
                            <option value="">Select Rank</option>
                            <option value="LKII" {{ $selectedRank === 'LKII' ? 'selected' : '' }}>LKII</option>
                            <option value="LKI" {{ $selectedRank === 'LKI' ? 'selected' : '' }}>LKI</option>
                            <option value="LK" {{ $selectedRank === 'LK' ? 'selected' : '' }}>LK</option>
                            <option value="BM" {{ $selectedRank === 'BM' ? 'selected' : '' }}>BM</option>
                            <option value="BK" {{ $selectedRank === 'BK' ? 'selected' : '' }}>BK</option>
                            <option value="PWI" {{ $selectedRank === 'PWI' ? 'selected' : '' }}>PWI</option>
                            <option value="PWII" {{ $selectedRank === 'PWII' ? 'selected' : '' }}>PWII</option>
                            <option value="Lt M" {{ $selectedRank === 'Lt M' ? 'selected' : '' }}>Lt M</option>
                            <option value="Lt Dya" {{ $selectedRank === 'Lt Dya' ? 'selected' : '' }}>Lt Dya</option>
                            <option value="Lt" {{ $selectedRank === 'Lt' ? 'selected' : '' }}>Lt</option>
                            <option value="Lt Kdr" {{ $selectedRank === 'Lt Kdr' ? 'selected' : '' }}>Lt Kdr</option>
                            <option value="Kdr" {{ $selectedRank === 'Kdr' ? 'selected' : '' }}>Kdr</option>
                            <option value="Kpt" {{ $selectedRank === 'Kpt' ? 'selected' : '' }}>Kpt</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('rank')" />
                    </div>
                    <div>
                        <x-input-label for="time_in_service" :value="__('Time in Service (years)')" class="text-sm font-semibold text-gray-700" />
                        <x-text-input id="time_in_service" name="time_in_service" type="number" min="0" step="1" class="mt-2 block w-full px-4 py-2.5 rounded-lg" :value="$personal->time_in_service" placeholder="Years" />
                        <x-input-error class="mt-2" :messages="$errors->get('time_in_service')" />
                    </div>
                    <div>
                        <x-input-label for="ttp" :value="__('TTP Date')" class="text-sm font-semibold text-gray-700" />
                        <input id="ttp" name="ttp" type="date" class="mt-2 block w-full px-4 py-2.5 rounded-lg border-gray-300" value="{{ $personal->ttp }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('ttp')" />
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-md hover:shadow-lg"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ __('Save Changes') }}
                </button>
                @if (session('status') === 'personal-updated')
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
                        {{ __('Saved successfully!') }}
                    </p>
                @endif
            </div>
        </form>
    @endif

    <script>
        function validateFileSize(input, role) {
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            const errorElement = document.getElementById('file-size-error-' + role);
            const submitButton = input.closest('form').querySelector('button[type="submit"]');

            if (input.files && input.files[0]) {
                const fileSize = input.files[0].size;
                const fileName = input.files[0].name;

                if (fileSize > maxSize) {
                    const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);
                    errorElement.textContent = `File size (${fileSizeMB}MB) exceeds the maximum limit of 2MB. Please choose a smaller image.`;
                    errorElement.classList.remove('hidden');
                    input.value = ''; // Clear the file input
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    errorElement.classList.add('hidden');
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }
    </script>
</section>