<x-app-layout>
    {{-- ================================================================ --}}
    {{-- PAGE HEADER --}}
    {{-- ================================================================ --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadet Management (Instructor)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE TITLE SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Cadet Management
                </h1>
                <p class="text-gray-600">Manage cadet information, positions, and qualifications</p>
            </div>

            {{-- ================================================================ --}}
            {{-- MAIN CONTENT CARD --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-blue-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Cadet Management
                    </h3>
                    <p class="text-gray-600">Manage cadet information, positions, and qualifications</p>
                </div>

                {{-- Card Body --}}
                <div class="p-6 text-gray-900">

                    {{-- ================================================================ --}}
                    {{-- FILTERS AND CONTROLS SECTION --}}
                    {{-- ================================================================ --}}
                    <div class="mb-6 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 overflow-x-auto items-center justify-between">
                        
                        {{-- Left Side: Intake and Dynamic Filters --}}
                        <div class="flex flex-row space-x-4 items-center flex-shrink-0 flex-wrap">
                            
                            {{-- Intake Filter --}}
                            <div class="flex flex-col">
                                <label class="text-sm font-medium text-gray-700 mb-1">Cadet Intake</label>
                                <select id="intakeFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @if(!empty($recentIntakes) && is_array($recentIntakes))
                                        @foreach($recentIntakes as $intake)
                                            <option value="{{ $intake['year'] }}" {{ $intakeYear == $intake['year'] ? 'selected' : '' }}>
                                                {{ $intake['label'] }}
                                            </option>
                                        @endforeach
                                    @else
                                        @php
                                            $currentYear = now()->year;
                                            for ($i = 0; $i < 4; $i++) {
                                                $year = $currentYear - $i;
                                                $intakeNumber = 14 - $i;
                                                echo "<option value='{$year}'" . ($intakeYear == $year ? ' selected' : '') . ">Intake - {$intakeNumber} ({$year})</option>";
                                            }
                                        @endphp
                                    @endif
                                </select>
                            </div>

                            {{-- Dynamic Sorting/Filter Controls --}}
                            @if($infoType !== 'seniority')
                                <div class="flex flex-col space-y-2">
                                    
                                    {{-- Standard Filter Dropdown (BMI, Position, Gender, Swimming) --}}
                                    @if($infoType != 'cgpa')
                                        <div class="flex flex-col">
                                            <label class="text-sm font-medium text-gray-700 mb-1">
                                                @switch($infoType)
                                                    @case('bmi')
                                                        Sort Order
                                                        @break
                                                    @case('position')
                                                        Filter
                                                        @break
                                                    @case('gender')
                                                        Gender
                                                        @break
                                                    @case('swimming')
                                                        Status
                                                        @break
                                                @endswitch
                                            </label>
                                            <select id="sortFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @switch($infoType)
                                                    @case('bmi')
                                                        <option value="all" {{ $filterBy == 'all' ? 'selected' : '' }}>All</option>
                                                        <option value="overweight" {{ $filterBy == 'overweight' ? 'selected' : '' }}>BMI > 26.9</option>
                                                        <option value="underweight" {{ $filterBy == 'underweight' ? 'selected' : '' }}>BMI < 18.0</option>
                                                        @break
                                                    @case('position')
                                                        <option value="all" {{ $filterBy == 'all' ? 'selected' : '' }}>All</option>
                                                        <option value="rank_holders" {{ $filterBy == 'rank_holders' ? 'selected' : '' }}>Rank Holders Only</option>
                                                        @break
                                                    @case('gender')
                                                        <option value="all" {{ $filterBy == 'all' ? 'selected' : '' }}>All</option>
                                                        <option value="male" {{ $filterBy == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female" {{ $filterBy == 'female' ? 'selected' : '' }}>Female</option>
                                                        @break
                                                    @case('swimming')
                                                        <option value="all" {{ $filterBy == 'all' ? 'selected' : '' }}>All</option>
                                                        <option value="pass" {{ $filterBy == 'pass' ? 'selected' : '' }}>Pass</option>
                                                        <option value="in_progress" {{ $filterBy == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="fail" {{ $filterBy == 'fail' ? 'selected' : '' }}>Fail</option>
                                                        @break
                                                @endswitch
                                            </select>
                                        </div>
                                    @endif

                                    {{-- CGPA Range Filter --}}
                                    @if($infoType == 'cgpa')
                                        <div class="flex flex-col">
                                            <label class="text-sm font-medium text-gray-700 mb-1">CGPA Range Filter</label>
                                            <select id="cgpaRangeFilter" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                <option value="all" {{ $filterBy == 'all' ? 'selected' : '' }}>All</option>
                                                <option value="3.67_and_above" {{ $filterBy == '3.67_and_above' ? 'selected' : '' }}>3.67 and above</option>
                                                <option value="3.00_to_3.66" {{ $filterBy == '3.00_to_3.66' ? 'selected' : '' }}>3.00 - 3.66</option>
                                                <option value="2.50_to_2.99" {{ $filterBy == '2.50_to_2.99' ? 'selected' : '' }}>2.50 - 2.99</option>
                                                <option value="2.49_and_below" {{ $filterBy == '2.49_and_below' ? 'selected' : '' }}>2.49 and below</option>
                                            </select>
                                        </div>
                                    @endif
                                    
                                </div>
                            @endif
                        </div>

                        {{-- Right Side: Information Type Buttons --}}
                        <div class="flex flex-wrap gap-2 items-center">
                            @php
                                $infoTypes = [
                                    'seniority' => 'Seniority',
                                    'position' => 'Position', 
                                    'gender' => 'Gender',
                                    'cgpa' => 'CGPA',
                                    'swimming' => 'Swimming',
                                    'bmi' => 'BMI'
                                ];
                            @endphp
                            @foreach($infoTypes as $type => $label)
                                <button 
                                    class="info-type-btn px-4 py-2 rounded-md text-sm font-medium transition-colors
                                           {{ $infoType == $type ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                                    data-type="{{ $type }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- ACTION BUTTONS SECTION --}}
                    {{-- ================================================================ --}}
                    
                    {{-- Save Changes Button (Position Management) --}}
                    @if($infoType == 'position' && $cadets->count() > 0)
                        <div class="mb-4 flex justify-end">
                            <button id="savePositionsBtn" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Save Changes
                            </button>
                        </div>
                    @endif

                    {{-- Mark as Passed Button (Swimming Management) --}}
                    @if($infoType == 'swimming' && $cadets->count() > 0)
                        <div class="mb-4 flex justify-end">
                            <button id="markAsPassedBtn" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium disabled:bg-gray-400 disabled:cursor-not-allowed"
                                    disabled>
                                Mark Selected as Passed
                            </button>
                        </div>
                    @endif

                    {{-- ================================================================ --}}
                    {{-- CADET TABLE SECTION --}}
                    {{-- ================================================================ --}}
                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                        
                        {{-- Table Header (Fixed) --}}
                        <div class="bg-gray-50 border-b border-gray-200 sticky top-0 z-10">
                            <div class="px-6 py-3">
                                <div class="grid grid-cols-5 gap-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div>No.</div>
                                    <div>Service Number</div>
                                    <div>Name</div>
                                    <div>
                                        @switch($infoType)
                                            @case('seniority')
                                                IC Number
                                                @break
                                            @case('position')
                                                Position
                                                @break
                                            @case('gender')
                                                Gender
                                                @break
                                            @case('cgpa')
                                                CGPA
                                                @break
                                            @case('swimming')
                                                Swimming Status
                                                @break
                                            @case('bmi')
                                                BMI & Last Updated
                                                @break
                                        @endswitch
                                    </div>
                                    <div>
                                        @if($infoType == 'swimming')
                                            <div class="flex items-center">
                                                <input type="checkbox" 
                                                       id="selectAll" 
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2">
                                                <span>Select All</span>
                                            </div>
                                        @else
                                            Actions
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Table Body (Scrollable - Max 6 rows visible) --}}
                        <div class="overflow-y-auto bg-white" style="max-height: calc(5 * 72px);">
                            @forelse($cadets as $index => $cadet)
                                <div class="border-b border-gray-200 hover:bg-gray-50 cursor-pointer cadet-row px-6 py-4" 
                                     data-cadet-id="{{ $cadet->id }}">
                                    <div class="grid grid-cols-5 gap-4 items-center">
                                            
                                            {{-- Column 1: Number --}}
                                            <div class="text-sm text-gray-900">
                                                {{ $cadets->firstItem() + $index }}
                                            </div>
                                            
                                            {{-- Column 2: Service Number --}}
                                            <div class="text-sm text-gray-900">
                                                {{ $cadet->service_number ?? 'N/A' }}
                                            </div>
                                            
                                            {{-- Column 3: Name --}}
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $cadet->user->name ?? 'Unknown' }}
                                            </div>
                                            
                                            {{-- Column 4: Dynamic Info --}}
                                            <div class="text-sm text-gray-900">
                                                @switch($infoType)
                                                    @case('seniority')
                                                        {{ $cadet->ic_number ?? 'N/A' }}
                                                        @break
                                                        
                                                    @case('position')
                                                        {{ $cadet->position ?? 'Normal Cadet' }}
                                                        @break
                                                        
                                                    @case('gender')
                                                        {{ $cadet->gender ?? 'N/A' }}
                                                        @break
                                                        
                                                    @case('cgpa')
                                                        {{ $cadet->current_cgpa ? number_format($cadet->current_cgpa, 2) : 'N/A' }}
                                                        @break
                                                        
                                                    @case('swimming')
                                                        @if($cadet->swimming_qualification)
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                                {{ $cadet->swimming_qualification == 'Pass' ? 'bg-green-100 text-green-800' : 
                                                                   ($cadet->swimming_qualification == 'In Progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                                {{ $cadet->swimming_qualification }}
                                                            </span>
                                                        @else
                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                                N/A
                                                            </span>
                                                        @endif
                                                        @break
                                                        
                                                    @case('bmi')
                                                        <div>
                                                            <div class="font-medium">{{ $cadet->BMI ? number_format($cadet->BMI, 1) : 'N/A' }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $cadet->BMI_update_date ? $cadet->BMI_update_date->format('d/m/Y') : 'Not updated' }}
                                                            </div>
                                                        </div>
                                                        @break
                                                @endswitch
                                            </div>
                                            
                                            {{-- Column 5: Actions --}}
                                            <div class="text-sm font-medium">
                                                @switch($infoType)
                                                    @case('seniority')
                                                        <button class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 remove-cadet-btn" 
                                                                data-cadet-id="{{ $cadet->id }}" 
                                                                data-cadet-name="{{ $cadet->user->name }}">
                                                            Remove Cadet
                                                        </button>
                                                        @break
                                                        
                                                    @case('position')
                                                        <select class="position-select border-gray-300 rounded text-sm" 
                                                                data-cadet-id="{{ $cadet->id }}"
                                                                name="positions[{{ $cadet->id }}]">
                                                            @foreach(App\Models\Cadet::getPositions() as $value => $label)
                                                                <option value="{{ $value }}" 
                                                                        {{ ($cadet->position ?? 'Normal Cadet') == $value ? 'selected' : '' }}>
                                                                    {{ $label }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @break
                                                        
                                                    @case('swimming')
                                                        @if($cadet->swimming_qualification != 'Pass')
                                                            <input type="checkbox" 
                                                                   class="cadet-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" 
                                                                   data-cadet-id="{{ $cadet->id }}"
                                                                   onclick="event.stopPropagation()">
                                                        @else
                                                            <span class="text-green-600 font-medium">Passed</span>
                                                        @endif
                                                        @break
                                                        
                                                    @default
                                                        <button class="text-indigo-600 hover:text-indigo-900 view-profile-btn" 
                                                                data-cadet-id="{{ $cadet->id }}">
                                                            View Profile
                                                        </button>
                                                        @break
                                                @endswitch
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-6 py-8 text-center">
                                        <div class="text-sm text-gray-500">
                                            No cadets found matching the current filters.
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- PAGINATION SECTION --}}
                    {{-- ================================================================ --}}
                    <div class="mt-6">
                        {{ $cadets->appends(request()->query())->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CADET PROFILE MODAL --}}
    {{-- ================================================================ --}}
    <div id="cadetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Cadet Profile</h3>
                        <button id="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="cadetProfileContent"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- REMOVE CADET CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="removeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Cadet Removal</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        To confirm removal, please type the cadet's full name: 
                        <strong id="cadetNameToConfirm"></strong>
                    </p>
                    <input type="text" 
                           id="confirmationNameInput" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 mb-4"
                           placeholder="Type the full name here">
                    <div class="flex justify-end space-x-3">
                        <button id="cancelRemove" 
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                        <button id="confirmRemove" 
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">
                            Remove Cadet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // ============================================================
            // EVENT LISTENERS: Info Type Buttons
            // ============================================================
            document.querySelectorAll('.info-type-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    updateFilters(this.dataset.type);
                });
            });

            // ============================================================
            // EVENT LISTENERS: Filter Dropdowns
            // ============================================================
            document.getElementById('intakeFilter').addEventListener('change', function() {
                updateFilters();
            });

            if(document.getElementById('sortFilter')) {
                document.getElementById('sortFilter').addEventListener('change', function() {
                    updateFilters();
                });
            }
            
            if(document.getElementById('cgpaRangeFilter')) {
                document.getElementById('cgpaRangeFilter').addEventListener('change', function() {
                    updateFilters();
                });
            }

            // ============================================================
            // SWIMMING QUALIFICATION: Checkbox Functionality
            // ============================================================
            const selectAllCheckbox = document.getElementById('selectAll');
            const cadetCheckboxes = document.querySelectorAll('.cadet-checkbox');
            const markAsPassedBtn = document.getElementById('markAsPassedBtn');

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    cadetCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateMarkAsPassedButton();
                });
            }

            cadetCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllCheckbox();
                    updateMarkAsPassedButton();
                });
            });

            if (markAsPassedBtn) {
                markAsPassedBtn.addEventListener('click', function() {
                    markSelectedAsPassed();
                });
            }

            function updateSelectAllCheckbox() {
                if (selectAllCheckbox) {
                    const checkedBoxes = document.querySelectorAll('.cadet-checkbox:checked');
                    selectAllCheckbox.checked = checkedBoxes.length === cadetCheckboxes.length;
                    selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < cadetCheckboxes.length;
                }
            }

            function updateMarkAsPassedButton() {
                if (markAsPassedBtn) {
                    const checkedBoxes = document.querySelectorAll('.cadet-checkbox:checked');
                    markAsPassedBtn.disabled = checkedBoxes.length === 0;
                }
            }

            function markSelectedAsPassed() {
                const selectedCadets = [];
                document.querySelectorAll('.cadet-checkbox:checked').forEach(checkbox => {
                    selectedCadets.push(checkbox.dataset.cadetId);
                });

                if (selectedCadets.length === 0) {
                    alert('Please select at least one cadet to mark as passed.');
                    return;
                }

                const intakeYear = document.getElementById('intakeFilter').value;

                fetch('/instructor/cadets/swimming/mark-passed', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        cadet_ids: selectedCadets,
                        intake_year: intakeYear
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`${data.updated_count} cadet(s) marked as passed successfully`);
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to update swimming qualification');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update swimming qualification');
                });
            }

            // ============================================================
            // CADET PROFILE: View Profile Modal
            // ============================================================
            document.querySelectorAll('.cadet-row, .view-profile-btn').forEach(element => {
                element.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-cadet-btn') || 
                        e.target.classList.contains('position-select') ||
                        e.target.classList.contains('cadet-checkbox') ||
                        e.target.type === 'checkbox') {
                        return;
                    }
                    
                    const cadetId = this.dataset.cadetId || this.closest('.cadet-row').dataset.cadetId;
                    showCadetProfile(cadetId);
                });
            });

            // ============================================================
            // REMOVE CADET: Button Click Handler
            // ============================================================
            document.querySelectorAll('.remove-cadet-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const cadetId = this.dataset.cadetId;
                    const cadetName = this.dataset.cadetName;
                    showRemoveModal(cadetId, cadetName);
                });
            });

            // ============================================================
            // POSITION MANAGEMENT: Validation
            // ============================================================
            document.querySelectorAll('.position-select').forEach(select => {
                select.addEventListener('change', function(e) {
                    e.stopPropagation();
                    validatePositionSelection(this);
                });
            });

            document.getElementById('savePositionsBtn')?.addEventListener('click', function() {
                savePositions();
            });

            // ============================================================
            // MODAL CONTROLS: Close Buttons
            // ============================================================
            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('cadetModal').classList.add('hidden');
            });

            document.getElementById('cancelRemove').addEventListener('click', function() {
                document.getElementById('removeModal').classList.add('hidden');
            });

            document.getElementById('confirmRemove').addEventListener('click', function() {
                confirmRemoval();
            });
        });

        // ============================================================
        // FUNCTION: Update Filters
        // ============================================================
        function updateFilters(infoType = null) {
            const url = new URL(window.location);
            
            if (infoType) {
                url.searchParams.set('info_type', infoType);
            }
            
            url.searchParams.set('intake_year', document.getElementById('intakeFilter').value);
            
            const currentInfoType = infoType || url.searchParams.get('info_type') || 'seniority';

            if (currentInfoType === 'seniority') {
                url.searchParams.set('sort_by', 'asc');
                url.searchParams.delete('filter_by');
            } else {
                if (currentInfoType === 'cgpa') {
                    const cgpaRangeFilter = document.getElementById('cgpaRangeFilter');
                    if (cgpaRangeFilter) {
                        url.searchParams.set('filter_by', cgpaRangeFilter.value);
                    } else {
                        url.searchParams.delete('filter_by');
                    }
                    url.searchParams.delete('sort_by');
                } else if (currentInfoType === 'bmi') {
                    const bmiFilter = document.getElementById('sortFilter');
                    if (bmiFilter) {
                        url.searchParams.set('filter_by', bmiFilter.value);
                    } else {
                        url.searchParams.delete('filter_by');
                    }
                    url.searchParams.delete('sort_by');
                } else {
                    const sortValue = document.getElementById('sortFilter') ? document.getElementById('sortFilter').value : 'asc';
                    url.searchParams.set('filter_by', sortValue);
                    url.searchParams.delete('sort_by');
                }
            }
            
            window.location.href = url.toString();
        }

        // ============================================================
        // FUNCTION: Validate Position Selection
        // ============================================================
        function validatePositionSelection(selectElement) {
            const selectedPosition = selectElement.value;
            const cadetId = selectElement.dataset.cadetId;
            const specialPositions = ['CO', 'Thana', 'Zayn', 'PMC'];
            
            if (specialPositions.includes(selectedPosition)) {
                const otherSelects = document.querySelectorAll('.position-select');
                let conflictFound = false;
                
                otherSelects.forEach(otherSelect => {
                    if (otherSelect.dataset.cadetId !== cadetId && otherSelect.value === selectedPosition) {
                        conflictFound = true;
                    }
                });
                
                if (conflictFound) {
                    alert(`Only one cadet per intake can hold the ${selectedPosition} position. Please change the other cadet's position first.`);
                    selectElement.value = selectElement.dataset.originalValue || 'Normal Cadet';
                    return false;
                }
            }
            
            selectElement.dataset.originalValue = selectedPosition;
            return true;
        }

        // ============================================================
        // FUNCTION: Show Cadet Profile Modal
        // ============================================================
        function showCadetProfile(cadetId) {
            fetch(`/instructor/cadets/${cadetId}`)
                .then(response => response.json())
                .then(data => {
                    let profilePicHtml = '';
                    if (data.cadet.profile_pic) {
                        const profilePicUrl = `/storage/${data.cadet.profile_pic}`;
                        profilePicHtml = `<img src="${profilePicUrl}" alt="Profile" class="w-20 h-20 rounded-full object-cover">`;
                    } else {
                        const fallbackAvatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.user.name)}`;
                        profilePicHtml = `<img src="${fallbackAvatarUrl}" alt="Profile" class="w-20 h-20 rounded-full object-cover">`;
                    }

                    const profileContent = `
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center">
                                ${profilePicHtml}
                            </div>
                            <div>
                                <h4 class="text-xl font-semibold text-gray-900">${data.user.name}</h4>
                                <p class="text-sm text-gray-600">Service No: ${data.cadet.service_number || 'N/A'}</p>
                                <p class="text-sm text-gray-600">Matric No: ${data.cadet.matric_no || 'N/A'}</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h5 class="font-medium text-gray-900 border-b pb-2">Personal Information</h5>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Gender:</span>
                                        <span class="font-medium">${data.cadet.gender || 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-medium">${data.cadet.phone_number || 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-medium">${data.user.email || 'N/A'}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h5 class="font-medium text-gray-900 border-b pb-2">Military Information</h5>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Rank:</span>
                                        <span class="font-medium">${data.cadet.rank || 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Position:</span>
                                        <span class="font-medium">${data.cadet.position || 'Normal Cadet'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Intake Year:</span>
                                        <span class="font-medium">${data.cadet.intake_year || 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Swimming Status:</span>
                                        <span class="font-medium px-2 py-1 rounded text-xs ${
                                            data.cadet.swimming_qualification === 'Pass' ? 'bg-green-100 text-green-800' :
                                            data.cadet.swimming_qualification === 'In Progress' ? 'bg-yellow-100 text-yellow-800' :
                                            'bg-red-100 text-red-800'
                                        }">
                                            ${data.cadet.swimming_qualification || 'N/A'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h5 class="font-medium text-gray-900 border-b pb-2">Academic Information</h5>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Current CGPA:</span>
                                        <span class="font-medium">${data.cadet.current_cgpa ? parseFloat(data.cadet.current_cgpa).toFixed(2) : 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Past CGPA:</span>
                                        <span class="font-medium">${data.cadet.past_cgpa ? parseFloat(data.cadet.past_cgpa).toFixed(2) : 'N/A'}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h5 class="font-medium text-gray-900 border-b pb-2">Physical Information</h5>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">BMI:</span>
                                        <span class="font-medium">${data.cadet.BMI ? parseFloat(data.cadet.BMI).toFixed(1) : 'N/A'}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">BMI Updated:</span>
                                        <span class="font-medium text-xs">${data.cadet.BMI_update_date ? new Date(data.cadet.BMI_update_date).toLocaleDateString() : 'Not updated'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('cadetProfileContent').innerHTML = profileContent;
                    document.getElementById('cadetModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching cadet profile:', error);
                    alert('Failed to load cadet profile');
                });
        }

        // ============================================================
        // FUNCTION: Show Remove Cadet Modal
        // ============================================================
        function showRemoveModal(cadetId, cadetName) {
            document.getElementById('cadetNameToConfirm').textContent = cadetName;
            document.getElementById('confirmationNameInput').value = '';
            document.getElementById('confirmRemove').dataset.cadetId = cadetId;
            document.getElementById('removeModal').classList.remove('hidden');
        }

        // ============================================================
        // FUNCTION: Confirm Cadet Removal
        // ============================================================
        function confirmRemoval() {
            const cadetId = document.getElementById('confirmRemove').dataset.cadetId;
            const confirmationName = document.getElementById('confirmationNameInput').value;
            
            fetch(`/instructor/cadets/${cadetId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    confirmation_name: confirmationName
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('removeModal').classList.add('hidden');
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to remove cadet');
            });
        }

        // ============================================================
        // FUNCTION: Save Positions
        // ============================================================
        function savePositions() {
            const positionSelects = document.querySelectorAll('.position-select');
            const positionCounts = { 'CO': 0, 'Thana': 0, 'Zayn': 0, 'PMC': 0 };
            
            positionSelects.forEach(select => {
                const position = select.value;
                if (positionCounts.hasOwnProperty(position)) {
                    positionCounts[position]++;
                }
            });
            
            const conflicts = Object.entries(positionCounts).filter(([position, count]) => count > 1);
            if (conflicts.length > 0) {
                const conflictMessage = conflicts.map(([position, count]) => 
                    `${position}: ${count} cadets selected`).join(', ');
                alert(`Position conflicts detected: ${conflictMessage}. Each position can only be assigned to one cadet per intake.`);
                return;
            }

            const positions = {};
            positionSelects.forEach(select => {
                positions[select.dataset.cadetId] = select.value;
            });

            const intakeYear = document.getElementById('intakeFilter').value;

            fetch('/instructor/cadets/positions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    positions: positions,
                    intake_year: intakeYear
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Positions updated successfully');
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update positions');
            });
        }
    </script>
    @endpush
</x-app-layout>