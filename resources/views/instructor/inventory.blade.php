<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventory Management - Instructor') }}
            </h2>
        </div>
    </x-slot>

    <!-- Add CSRF token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Section 1: Cadet Uniform Size Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border hover:border-blue-300">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-tshirt mr-2"></i>
                        Cadet Uniform Size Summary
                    </h3>
                </div>
                
                <!-- Top Section: Filters and Controls -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <!-- Left Side Filters -->
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex flex-col">
                                <label for="uniform_intake_year" class="text-sm font-medium text-gray-700 mb-1">Intake</label>
                                <select name="uniform_intake_year" id="uniform_intake_year" 
                                        class="w-40 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @foreach($intakeYears as $intake)
                                        <option value="{{ $intake['year'] }}" {{ $selectedIntakeYear == $intake['year'] ? 'selected' : '' }}>
                                            {{ $intake['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex flex-col">
                                <label for="uniform_type" class="text-sm font-medium text-gray-700 mb-1">Uniform Type</label>
                                <select name="uniform_type" id="uniform_type" 
                                        class="w-48 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Type</option>
                                    @foreach($uniformTypes as $type)
                                        <option value="{{ $type->id }}" {{ $selectedUniformType == $type->id ? 'selected' : '' }}>
                                            {{ $type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex flex-col">
                                <label for="uniform_component" class="text-sm font-medium text-gray-700 mb-1">Uniform Component</label>
                                <select name="uniform_component" id="uniform_component" 
                                        class="w-48 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Component</option>
                                    @foreach($uniformComponents as $component)
                                        <option value="{{ $component->id }}" {{ $selectedUniformComponent == $component->id ? 'selected' : '' }}>
                                            {{ $component->component_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- Right Side Buttons -->
                        <div class="flex gap-3">
                            <button onclick="openUniformTypeModal()" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-2 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Add Type
                            </button>
                            <button onclick="openUniformComponentModal()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Add Component
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Uniform Size Summary Table -->
                <div class="p-6">
                    @if($uniformSizeSummary->isEmpty())
                        <p class="text-gray-500">No uniform size data available for this intake year.</p>
                    @else
                        <div class="space-y-6">
                            @foreach($uniformSizeSummary as $componentName => $sizes)
                                <div>
                                    <h4 class="font-medium text-gray-800 mb-2">{{ $componentName }}</h4>
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                                            @foreach($sizes as $sizeData)
                                                <div class="bg-white rounded-md p-3 text-center shadow-sm">
                                                    <div class="text-sm text-gray-600">Size {{ $sizeData->size }}</div>
                                                    <div class="text-lg font-semibold text-blue-600">{{ $sizeData->cadet_count }}</div>
                                                    <div class="text-xs text-gray-500">cadets</div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 2: Equipment Loan Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border hover:border-blue-300">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-tools mr-2"></i>
                        Equipment Loan Section
                    </h3>
                </div>
                
                <!-- Top Section: Filters and Controls -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <!-- Left Side Filters -->
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex flex-col">
                                <label for="loan_intake_year" class="text-sm font-medium text-gray-700 mb-1">Intake</label>
                                <select name="loan_intake_year" id="loan_intake_year" 
                                        class="w-40 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    @foreach($intakeYears as $intake)
                                        <option value="{{ $intake['year'] }}" {{ $selectedIntakeYear == $intake['year'] ? 'selected' : '' }}>
                                            {{ $intake['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex flex-col">
                                <label for="equipment_category" class="text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="equipment_category" id="equipment_category" 
                                        class="w-48 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="">All Categories</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="uniform">Uniform</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Right Side Button -->
                        <div class="flex gap-3">
                            <button onclick="openEquipmentModal()" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                <i class="fas fa-plus mr-2"></i>
                                Add Equipment
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Equipment Loan Records Table -->
                <div class="p-6">
                    @if($equipmentLoans->isEmpty())
                        <p class="text-gray-500">No equipment loan records found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cadet</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($equipmentLoans as $loan)
                                        <tr class="{{ $loan->isOverdue() ? 'bg-red-50' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->cadet->user->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->inventoryItem->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $loan->inventoryItem->category === 'equipment' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ ucfirst($loan->inventoryItem->category) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->borrow_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->return_date ? $loan->return_date->format('M d, Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($loan->status === 'Borrowed')
                                                    @if($loan->isOverdue())
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Overdue ({{ $loan->days_overdue }} days)
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            Borrowed
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Returned
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($loan->status === 'Borrowed')
                                                    <form method="POST" action="{{ route('instructor.inventory.update-loan', $loan) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="Returned">
                                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                            Mark Returned
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $equipmentLoans->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Inventory Summary (Optional - can be moved to separate page) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 hover:shadow-2xl hover:border hover:border-blue-300">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-bar mr-2 text-gray-600"></i>
                        Inventory Summary
                    </h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">On Loan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Availability</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($inventorySummary as $item)
                                    @php
                                        $availabilityPercentage = $item->total_quantity > 0 ? 
                                            ($item->available_quantity / $item->total_quantity) * 100 : 0;
                                    @endphp
                                    <tr class="{{ $item->available_quantity == 0 ? 'bg-red-50' : ($availabilityPercentage < 20 ? 'bg-yellow-50' : '') }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $item->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $item->category === 'equipment' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                {{ ucfirst($item->category) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->total_quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->available_quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $item->borrowed_quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                                    <div class="h-2 rounded-full {{ $availabilityPercentage > 50 ? 'bg-green-500' : ($availabilityPercentage > 20 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                                         style="width: {{ $availabilityPercentage }}%"></div>
                                                </div>
                                                <span class="text-sm text-gray-600">{{ round($availabilityPercentage) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add Uniform Type -->
    <div id="uniformTypeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Uniform Type Management</h3>
                    <button onclick="closeUniformTypeModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Toggle Buttons -->
                <div class="flex mb-4 bg-gray-100 p-1 rounded-lg">
                    <button id="addTypeTab" onclick="switchTypeTab('add')" class="flex-1 py-2 px-4 rounded-md text-sm font-medium bg-blue-600 text-white">
                        Add New Type
                    </button>
                    <button id="viewTypeTab" onclick="switchTypeTab('view')" class="flex-1 py-2 px-4 rounded-md text-sm font-medium text-gray-600">
                        View Types
                    </button>
                </div>
                
                <!-- Add Type Content -->
                <div id="addTypeContent">
                    <form id="addUniformTypeForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type Name</label>
                            <input type="text" name="type_name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                      rows="3"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                            Add Uniform Type
                        </button>
                    </form>
                </div>
                
                <!-- View Types Content -->
                <div id="viewTypeContent" class="hidden">
                    <div class="max-h-60 overflow-y-auto" id="uniformTypesList">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add Uniform Component -->
    <div id="uniformComponentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Uniform Component Management</h3>
                    <button onclick="closeUniformComponentModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Toggle Buttons -->
                <div class="flex mb-4 bg-gray-100 p-1 rounded-lg">
                    <button id="addComponentTab" onclick="switchComponentTab('add')" class="flex-1 py-2 px-4 rounded-md text-sm font-medium bg-blue-600 text-white">
                        Add New Component
                    </button>
                    <button id="viewComponentTab" onclick="switchComponentTab('view')" class="flex-1 py-2 px-4 rounded-md text-sm font-medium text-gray-600">
                        View Components
                    </button>
                </div>
                
                <!-- Add Component Content -->
                <div id="addComponentContent">
                    <form id="addUniformComponentForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Uniform Type</label>
                            <select name="uniform_type_id" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Uniform Type</option>
                                @foreach($uniformTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Component Name</label>
                            <input type="text" name="component_name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                            Add Component
                        </button>
                    </form>
                </div>
                
                <!-- View Components Content -->
                <div id="viewComponentContent" class="hidden">
                    <div class="max-h-60 overflow-y-auto" id="uniformComponentsList">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add Equipment -->
    <div id="equipmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Equipment Management</h3>
                    <button onclick="closeEquipmentModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Toggle Buttons -->
                <div class="flex mb-4 bg-gray-100 p-1 rounded-lg">
                    <button id="addEquipmentTab" onclick="switchEquipmentTab('add')" class="flex-1 py-2 px-4 rounded-md text-sm font-medium bg-orange-600 text-white">
                        Add New Equipment
                    </button>
                    <button id="viewEquipmentTab" onclick="switchEquipmentTab('view')" class="flex-1 py-2 px-4 rounded-md text-sm font-medium text-gray-600">
                        View Equipment
                    </button>
                </div>
                
                <!-- Add Equipment Content -->
                <div id="addEquipmentContent">
                    <form id="addEquipmentForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Equipment Name</label>
                            <input type="text" name="name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select name="category" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option value="">Select Category</option>
                                <option value="equipment">Equipment</option>
                                <option value="uniform">Uniform</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <input type="number" name="total_quantity" required min="0" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                      rows="2"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white py-2 px-4 rounded-md">
                            Add Equipment
                        </button>
                    </form>
                </div>
                
                <!-- View Equipment Content -->
                <div id="viewEquipmentContent" class="hidden">
                    <div class="max-h-60 overflow-y-auto" id="equipmentList">
                        <!-- Dynamic content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const successAlert = document.querySelector('.fixed.bottom-4');
                if (successAlert) {
                    successAlert.remove();
                }
            }, 3000);
        </script>
    @endif

    <!-- JavaScript for Modal and Tab Functionality -->
    <script>
        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Uniform Type Modal Functions
        function openUniformTypeModal() {
            document.getElementById('uniformTypeModal').classList.remove('hidden');
        }

        function closeUniformTypeModal() {
            document.getElementById('uniformTypeModal').classList.add('hidden');
        }

        function switchTypeTab(tab) {
            const addTab = document.getElementById('addTypeTab');
            const viewTab = document.getElementById('viewTypeTab');
            const addContent = document.getElementById('addTypeContent');
            const viewContent = document.getElementById('viewTypeContent');

            if (tab === 'add') {
                addTab.classList.add('bg-blue-600', 'text-white');
                addTab.classList.remove('text-gray-600');
                viewTab.classList.remove('bg-blue-600', 'text-white');
                viewTab.classList.add('text-gray-600');
                addContent.classList.remove('hidden');
                viewContent.classList.add('hidden');
            } else {
                viewTab.classList.add('bg-blue-600', 'text-white');
                viewTab.classList.remove('text-gray-600');
                addTab.classList.remove('bg-blue-600', 'text-white');
                addTab.classList.add('text-gray-600');
                viewContent.classList.remove('hidden');
                addContent.classList.add('hidden');
                loadUniformTypes();
            }
        }

        // Uniform Component Modal Functions
        function openUniformComponentModal() {
            document.getElementById('uniformComponentModal').classList.remove('hidden');
        }

        function closeUniformComponentModal() {
            document.getElementById('uniformComponentModal').classList.add('hidden');
        }

        function switchComponentTab(tab) {
            const addTab = document.getElementById('addComponentTab');
            const viewTab = document.getElementById('viewComponentTab');
            const addContent = document.getElementById('addComponentContent');
            const viewContent = document.getElementById('viewComponentContent');

            if (tab === 'add') {
                addTab.classList.add('bg-blue-600', 'text-white');
                addTab.classList.remove('text-gray-600');
                viewTab.classList.remove('bg-blue-600', 'text-white');
                viewTab.classList.add('text-gray-600');
                addContent.classList.remove('hidden');
                viewContent.classList.add('hidden');
            } else {
                viewTab.classList.add('bg-blue-600', 'text-white');
                viewTab.classList.remove('text-gray-600');
                addTab.classList.remove('bg-blue-600', 'text-white');
                addTab.classList.add('text-gray-600');
                viewContent.classList.remove('hidden');
                addContent.classList.add('hidden');
                loadUniformComponents();
            }
        }

        // Equipment Modal Functions
        function openEquipmentModal() {
            document.getElementById('equipmentModal').classList.remove('hidden');
        }

        function closeEquipmentModal() {
            document.getElementById('equipmentModal').classList.add('hidden');
        }

        function switchEquipmentTab(tab) {
            const addTab = document.getElementById('addEquipmentTab');
            const viewTab = document.getElementById('viewEquipmentTab');
            const addContent = document.getElementById('addEquipmentContent');
            const viewContent = document.getElementById('viewEquipmentContent');

            if (tab === 'add') {
                addTab.classList.add('bg-orange-600', 'text-white');
                addTab.classList.remove('text-gray-600');
                viewTab.classList.remove('bg-orange-600', 'text-white');
                viewTab.classList.add('text-gray-600');
                addContent.classList.remove('hidden');
                viewContent.classList.add('hidden');
            } else {
                viewTab.classList.add('bg-orange-600', 'text-white');
                viewTab.classList.remove('text-gray-600');
                addTab.classList.remove('bg-orange-600', 'text-white');
                addTab.classList.add('text-gray-600');
                viewContent.classList.remove('hidden');
                addContent.classList.add('hidden');
                loadEquipment();
            }
        }

        // AJAX Functions for Data Loading
        function loadUniformTypes() {
            fetch('/instructor/inventory/uniform-types')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('uniformTypesList');
                        container.innerHTML = '';
                        
                        if (data.data.length === 0) {
                            container.innerHTML = '<p class="text-gray-500 text-center py-4">No uniform types found.</p>';
                            return;
                        }

                        const ul = document.createElement('ul');
                        ul.className = 'space-y-2';
                        
                        data.data.forEach(type => {
                            const li = document.createElement('li');
                            li.className = 'flex justify-between items-center p-2 bg-gray-50 rounded';
                            li.innerHTML = `
                                <div>
                                    <span class="font-medium">${type.type_name}</span>
                                    ${type.description ? `<span class="text-sm text-gray-500 block">${type.description}</span>` : ''}
                                </div>
                                <button onclick="deleteUniformType(${type.id})" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            `;
                            ul.appendChild(li);
                        });
                        
                        container.appendChild(ul);
                    }
                })
                .catch(error => {
                    console.error('Error loading uniform types:', error);
                    showAlert('Error loading uniform types', 'error');
                });
        }

        function loadUniformComponents() {
            fetch('/instructor/inventory/uniform-components')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('uniformComponentsList');
                        container.innerHTML = '';
                        
                        if (data.data.length === 0) {
                            container.innerHTML = '<p class="text-gray-500 text-center py-4">No uniform components found.</p>';
                            return;
                        }

                        const ul = document.createElement('ul');
                        ul.className = 'space-y-2';
                        
                        data.data.forEach(component => {
                            const li = document.createElement('li');
                            li.className = 'flex justify-between items-center p-2 bg-gray-50 rounded';
                            li.innerHTML = `
                                <div>
                                    <span class="font-medium">${component.component_name}</span>
                                    <span class="text-sm text-gray-500 block">${component.uniform_type.type_name}</span>
                                </div>
                                <button onclick="deleteUniformComponent(${component.id})" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            `;
                            ul.appendChild(li);
                        });
                        
                        container.appendChild(ul);
                    }
                })
                .catch(error => {
                    console.error('Error loading uniform components:', error);
                    showAlert('Error loading uniform components', 'error');
                });
        }

        function loadEquipment() {
            fetch('/instructor/inventory/equipment')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('equipmentList');
                        container.innerHTML = '';
                        
                        if (data.data.length === 0) {
                            container.innerHTML = '<p class="text-gray-500 text-center py-4">No equipment found.</p>';
                            return;
                        }

                        const ul = document.createElement('ul');
                        ul.className = 'space-y-2';
                        
                        data.data.forEach(equipment => {
                            const li = document.createElement('li');
                            li.className = 'flex justify-between items-center p-2 bg-gray-50 rounded';
                            li.innerHTML = `
                                <div>
                                    <span class="font-medium">${equipment.name}</span>
                                    <span class="text-sm text-gray-500 block">${equipment.category.charAt(0).toUpperCase() + equipment.category.slice(1)} - Available: ${equipment.available_quantity}/${equipment.total_quantity}</span>
                                </div>
                                <button onclick="deleteEquipment(${equipment.id})" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            `;
                            ul.appendChild(li);
                        });
                        
                        container.appendChild(ul);
                    }
                })
                .catch(error => {
                    console.error('Error loading equipment:', error);
                    showAlert('Error loading equipment', 'error');
                });
        }

        // Delete Functions
        function deleteUniformType(id) {
            if (confirm('Are you sure you want to delete this uniform type?')) {
                fetch(`/instructor/inventory/uniform-types/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        loadUniformTypes();
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting uniform type:', error);
                    showAlert('Error deleting uniform type', 'error');
                });
            }
        }

        function deleteUniformComponent(id) {
            if (confirm('Are you sure you want to delete this uniform component?')) {
                fetch(`/instructor/inventory/uniform-components/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        loadUniformComponents();
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting uniform component:', error);
                    showAlert('Error deleting uniform component', 'error');
                });
            }
        }

        function deleteEquipment(id) {
            if (confirm('Are you sure you want to delete this equipment?')) {
                fetch(`/instructor/inventory/equipment/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        loadEquipment();
                    } else {
                        showAlert(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error deleting equipment:', error);
                    showAlert('Error deleting equipment', 'error');
                });
            }
        }

        // Form Submission Handlers
        document.getElementById('addUniformTypeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/instructor/inventory/uniform-types', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    this.reset();
                    // Refresh dropdown
                    location.reload();
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error adding uniform type:', error);
                showAlert('Error adding uniform type', 'error');
            });
        });

        document.getElementById('addUniformComponentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/instructor/inventory/uniform-components', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    this.reset();
                    // Refresh dropdown
                    location.reload();
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error adding uniform component:', error);
                showAlert('Error adding uniform component', 'error');
            });
        });

        document.getElementById('addEquipmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('/instructor/inventory/equipment', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert(data.message, 'success');
                    this.reset();
                    // Refresh page to update inventory summary
                    location.reload();
                } else {
                    showAlert(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error adding equipment:', error);
                showAlert('Error adding equipment', 'error');
            });
        });

        // Utility Functions
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            alertDiv.textContent = message;
            
            document.body.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const uniformTypeModal = document.getElementById('uniformTypeModal');
            const uniformComponentModal = document.getElementById('uniformComponentModal');
            const equipmentModal = document.getElementById('equipmentModal');
            
            if (event.target === uniformTypeModal) {
                closeUniformTypeModal();
            }
            if (event.target === uniformComponentModal) {
                closeUniformComponentModal();
            }
            if (event.target === equipmentModal) {
                closeEquipmentModal();
            }
        }

        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Uniform filters
            const uniformIntakeSelect = document.getElementById('uniform_intake_year');
            const uniformTypeSelect = document.getElementById('uniform_type');
            const uniformComponentSelect = document.getElementById('uniform_component');

            // Equipment filters
            const loanIntakeSelect = document.getElementById('loan_intake_year');
            const equipmentCategorySelect = document.getElementById('equipment_category');

            // Dynamic component loading based on uniform type
            uniformTypeSelect.addEventListener('change', function() {
                const uniformTypeId = this.value;
                const componentSelect = document.getElementById('uniform_component');
                
                // Clear component options
                componentSelect.innerHTML = '<option value="">Select Component</option>';
                
                if (uniformTypeId) {
                    fetch(`/instructor/inventory/uniform-types/${uniformTypeId}/components`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                data.data.forEach(component => {
                                    const option = document.createElement('option');
                                    option.value = component.id;
                                    option.textContent = component.component_name;
                                    componentSelect.appendChild(option);
                                });
                            }
                        })
                        .catch(error => console.error('Error loading components:', error));
                }
                
                // Submit form to filter
                const form = document.createElement('form');
                form.method = 'GET';
                
                const intakeInput = document.createElement('input');
                intakeInput.type = 'hidden';
                intakeInput.name = 'intake_year';
                intakeInput.value = uniformIntakeSelect.value;
                form.appendChild(intakeInput);
                
                const typeInput = document.createElement('input');
                typeInput.type = 'hidden';
                typeInput.name = 'uniform_type';
                typeInput.value = uniformTypeId;
                form.appendChild(typeInput);
                
                document.body.appendChild(form);
                form.submit();
            });

            // Add event listeners for other filters
            [uniformIntakeSelect, uniformComponentSelect, loanIntakeSelect, equipmentCategorySelect].forEach(select => {
                if (select) {
                    select.addEventListener('change', function() {
                        // Create form with current filter values
                        const form = document.createElement('form');
                        form.method = 'GET';
                        
                        const filters = {
                            'intake_year': uniformIntakeSelect.value,
                            'uniform_type': uniformTypeSelect.value,
                            'uniform_component': uniformComponentSelect.value,
                            'loan_intake_year': loanIntakeSelect.value,
                            'equipment_category': equipmentCategorySelect.value
                        };
                        
                        Object.keys(filters).forEach(key => {
                            if (filters[key]) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = key;
                                input.value = filters[key];
                                form.appendChild(input);
                            }
                        });
                        
                        document.body.appendChild(form);
                        form.submit();
                    });
                }
            });
        });
    </script>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>