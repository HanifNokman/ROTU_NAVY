<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Inventory
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    My Inventory
                </h1>
                <p class="text-gray-600">Manage your uniform sizes and equipment loans</p>
            </div>

            {{-- ================================================================ --}}
            {{-- ACTIVE LOANS ALERT --}}
            {{-- ================================================================ --}}
            @if($activeLoans->isNotEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                You have {{ $activeLoans->count() }} active equipment loan(s).
                                @php
                                    $overdueCount = $activeLoans->filter(fn($loan) => $loan->isOverdue())->count();
                                @endphp
                                @if($overdueCount > 0)
                                    <span class="font-semibold text-red-600">{{ $overdueCount }} overdue!</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ================================================================ --}}
            {{-- UNIFORM SIZES SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                
                {{-- Section Header --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-blue-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        My Uniform Sizes
                    </h3>
                    <p class="text-gray-600">Manage your uniform component sizes</p>
                </div>

                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Size Guidelines</h4>
                    
                    {{-- Size Format Guidelines --}}
                    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="font-medium text-blue-800 mb-2">Size Format Guidelines</h4>
                        <div class="text-sm text-blue-700 space-y-1">
                            <p><strong>General Rules:</strong></p>
                            <ul class="list-disc list-inside ml-4 space-y-1">
                                <li>Size must be 1-5 characters long</li>
                                <li>Only letters, numbers, spaces, forward slashes (/) and hyphens (-) allowed</li>
                                <li>Cannot start or end with spaces</li>
                                <li>Examples: XS, S, M, L, XL, XXL, 1, 32, 34/36, 7 1/2,</li>
                            </ul>
                        </div>
                    </div>
                    
                    {{-- Uniform Type Filter --}}
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3 flex items-center justify-between">
                            Filter by Uniform Type
                            <div>
                                <select 
                                    id="uniform_type_filter" 
                                    name="uniform_type" 
                                    onchange="loadUniformComponents(this.value)"
                                    class="w-48 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Uniform Type</option>
                                    @foreach($uniformTypes as $type)
                                        <option value="{{ $type->id }}" {{ $selectedUniformType == $type->id ? 'selected' : '' }}>
                                            {{ $type->type_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </h4>

                        {{-- Components Container --}}
                        <div id="uniform-components-container">
                            @if($selectedUniformType && $uniformComponents->isNotEmpty())
                                <form method="POST" action="{{ route('cadet.inventory.uniform-size.update') }}" id="uniformSizeForm" onsubmit="return validateForm()">
                                    @csrf
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Component
                                                    </th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Size
                                                    </th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Actions
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($uniformComponents as $component)
                                                    @php
                                                        $sizeEntry = $uniformSizes->get($component->id);
                                                    @endphp
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $component->component_name }}
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                            @if($sizeEntry && $sizeEntry->is_issued)
                                                                <span class="text-gray-600">{{ $sizeEntry->size }}</span>
                                                                <input type="hidden" name="size[]" value="{{ $sizeEntry->size }}">
                                                                <input type="hidden" name="component_id[]" value="{{ $component->id }}">
                                                            @else
                                                                <input 
                                                                    type="text" 
                                                                    name="size[]" 
                                                                    value="{{ old('size.' . $loop->index, $sizeEntry ? $sizeEntry->size : '') }}"
                                                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 size-input"
                                                                    placeholder="e.g., XS, S, M, L, 32, 7 1/2"
                                                                    maxlength="10"
                                                                    pattern="^[A-Za-z0-9\s\/-]{1,10}$"
                                                                    title="Size must be 1-10 characters. Only letters, numbers, spaces, forward slashes (/) and hyphens (-) allowed."
                                                                    data-component-name="{{ $component->component_name }}">
                                                                <input type="hidden" name="component_id[]" value="{{ $component->id }}">
                                                                <div class="text-xs text-red-600 mt-1 hidden validation-error"></div>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @if($sizeEntry && $sizeEntry->is_issued)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                    Issued
                                                                </span>
                                                            @else
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                            @if($sizeEntry && !$sizeEntry->is_issued)
                                                                <button 
                                                                    type="button" 
                                                                    onclick="removeUniformSize({{ $sizeEntry->id }}, '{{ $component->component_name }}')" 
                                                                    class="text-red-600 hover:text-red-900">
                                                                    Remove
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="mt-4 flex justify-end">
                                            <button 
                                                type="submit" 
                                                id="updateSizesBtn" 
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                                                Update Sizes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <p>Select a uniform type to view and manage your sizes.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Loading Indicator --}}
                        <div id="loading-indicator" class="hidden text-center py-8">
                            <div class="inline-flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Loading uniform components...
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- EQUIPMENT LOANS SECTION --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                
                {{-- Section Header --}}
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-blue-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Equipment & Uniform Loans
                    </h3>
                    <p class="text-gray-600">Borrow equipment and uniform items</p>
                </div>

                <div class="p-6">
                    
                    {{-- Category Filter --}}
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3 flex items-center justify-between">
                            Filter by Category
                            <div>
                                <select 
                                    id="category_filter" 
                                    name="category_filter" 
                                    onchange="filterItemsByCategory(this.value)"
                                    class="w-48 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">All Categories</option>
                                    <option value="equipment">Equipment</option>
                                    <option value="uniform">Uniform</option>
                                </select>
                            </div>
                        </h4>
                    </div>

                    {{-- Items Selection List --}}
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-3">Select Items to Borrow</h4>
                        
                        <div id="items-container" class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg">
                            @if($availableItems->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Select
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Item Name
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Category
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Available Quantity
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($availableItems as $item)
                                            <tr class="item-row" data-category="{{ $item->category }}">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input 
                                                        type="checkbox" 
                                                        name="selected_items[]" 
                                                        value="{{ $item->id }}" 
                                                        class="item-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                        data-item-id="{{ $item->id }}"
                                                        data-item-name="{{ $item->name }}"
                                                        data-available-quantity="{{ $item->available_quantity }}"
                                                        data-category="{{ $item->category }}">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $item->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->category === 'equipment' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                        {{ $item->category }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $item->available_quantity }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <p>No items available for borrowing</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-4 flex justify-end">
                            <button 
                                type="button" 
                                id="selectItemsBtn" 
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md disabled:opacity-50 disabled:cursor-not-allowed" 
                                disabled>
                                Select Items
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ACTIVE LOANS SECTION --}}
            {{-- ================================================================ --}}
            @if($activeLoans->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                    
                    {{-- Section Header --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-blue-100">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Active Loans
                        </h3>
                        <p class="text-gray-600">Items currently borrowed</p>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Item
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Borrow Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Days Borrowed
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($activeLoans as $loan)
                                        <tr class="{{ $loan->isOverdue() ? 'bg-red-50' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $loan->inventoryItem->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $loan->inventoryItem->category === 'equipment' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ $loan->inventoryItem->category }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->borrow_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $loan->borrow_date->diffInDays(now()) }} days
                                                @if($loan->isOverdue())
                                                    <span class="text-red-600 font-semibold">(Overdue)</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    {{ $loan->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button 
                                                    onclick="openReturnModal({{ $loan->id }}, '{{ $loan->inventoryItem->name }}', '{{ $loan->borrow_date->format('Y-m-d') }}')"
                                                    class="text-green-600 hover:text-green-900">
                                                    Return
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ================================================================ --}}
            {{-- PAST LOANS SECTION --}}
            {{-- ================================================================ --}}
            @if($pastLoans->isNotEmpty())
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                    
                    {{-- Section Header --}}
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 border-b border-green-100">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Past Loans
                        </h3>
                        <p class="text-gray-600">Completed loan history</p>
                    </div>

                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Item
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Borrow Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Return Date
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Duration
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($pastLoans as $loan)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $loan->inventoryItem->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $loan->inventoryItem->category === 'equipment' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ $loan->inventoryItem->category }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->borrow_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $loan->return_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $loan->borrow_date->diffInDays($loan->return_date) }} days
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $pastLoans->links() }}
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- BORROW DETAILS MODAL --}}
    {{-- ================================================================ --}}
    <div id="borrowModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-3xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Borrow Selected Items</h3>
                <form id="borrowForm" method="POST" action="{{ route('cadet.inventory.loan.create') }}">
                    @csrf
                    <div class="overflow-y-auto max-h-96">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Available
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="borrowItemsContainer" class="bg-white divide-y divide-gray-200">
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Borrow Date
                        </label>
                        <input 
                            type="date" 
                            name="borrow_date" 
                            id="borrow_date" 
                            required
                            value="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-4">
                        <button 
                            type="button" 
                            onclick="closeBorrowModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button 
                            type="submit" 
                            id="confirmBorrowBtn" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Confirm Borrow
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- RETURN ITEM MODAL --}}
    {{-- ================================================================ --}}
    <div id="returnModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Return Equipment</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="modalDescription">
                        Are you sure you want to return this item?
                    </p>
                </div>
                <form id="returnForm" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="return_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Return Date
                        </label>
                        <input 
                            type="date" 
                            name="return_date" 
                            id="return_date" 
                            value="{{ date('Y-m-d') }}" 
                            max="{{ date('Y-m-d') }}"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div class="flex justify-center space-x-4">
                        <button 
                            type="button" 
                            onclick="closeReturnModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            Return Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- DELETE CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Remove Uniform Size</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500" id="deleteModalDescription">
                        Are you sure you want to remove this uniform size?
                    </p>
                </div>
                <form id="deleteForm" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-center space-x-4">
                        <button 
                            type="button" 
                            onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button 
                            type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            Remove
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- FLASH MESSAGES --}}
    {{-- ================================================================ --}}
    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const successAlert = document.querySelector('.fixed.bottom-4');
                if (successAlert) successAlert.remove();
            }, 3000);
        </script>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(() => {
                const errorAlert = document.querySelector('.fixed.bottom-4.bg-red-500');
                if (errorAlert) errorAlert.remove();
            }, 3000);
        </script>
    @endif

    @if(session('info'))
        <div class="fixed bottom-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            {{ session('info') }}
        </div>
        <script>
            setTimeout(() => {
                const infoAlert = document.querySelector('.fixed.bottom-4.bg-blue-500');
                if (infoAlert) infoAlert.remove();
            }, 3000);
        </script>
    @endif

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT - VALIDATION FUNCTIONS --}}
    {{-- ================================================================ --}}
    <script>
        // ================================================================
        // SIZE VALIDATION
        // ================================================================
        function validateUniformSize(size, componentName) {
            const errors = [];
            
            if (!size || size.trim() === '') {
                return { isValid: false, errors: ['Size cannot be empty'] };
            }

            size = size.trim();
            
            if (size.length < 1 || size.length > 10) {
                errors.push('Size must be between 1 and 10 characters');
            }
            
            const allowedPattern = /^[A-Za-z0-9\s\/-]+$/;
            if (!allowedPattern.test(size)) {
                errors.push('Size can only contain letters, numbers, spaces, forward slashes (/) and hyphens (-)');
            }
            
            if (size !== size.trim()) {
                errors.push('Size cannot start or end with spaces');
            }
            
            if (/\s{2,}/.test(size)) {
                errors.push('Size cannot contain consecutive spaces');
            }

            return {
                isValid: errors.length === 0,
                errors: errors,
                cleanedSize: size.trim()
            };
        }

        function attachSizeValidation() {
            document.querySelectorAll('.size-input').forEach(input => {
                const errorDiv = input.parentElement.querySelector('.validation-error');
                
                function validateInput() {
                    const componentName = input.dataset.componentName;
                    const validation = validateUniformSize(input.value, componentName);
                    
                    if (validation.isValid) {
                        input.classList.remove('border-red-500');
                        input.classList.add('border-gray-300');
                        errorDiv.textContent = '';
                        errorDiv.classList.add('hidden');
                    } else {
                        input.classList.remove('border-gray-300');
                        input.classList.add('border-red-500');
                        errorDiv.textContent = validation.errors[0];
                        errorDiv.classList.remove('hidden');
                    }
                    
                    updateSubmitButtonState();
                }
                
                input.addEventListener('input', validateInput);
                input.addEventListener('blur', validateInput);
                
                if (input.value) {
                    validateInput();
                }
            });
        }

        function updateSubmitButtonState() {
            const submitBtn = document.getElementById('updateSizesBtn');
            if (!submitBtn) return;

            const hasErrors = document.querySelectorAll('.size-input.border-red-500').length > 0;
            
            if (hasErrors) {
                submitBtn.disabled = true;
                submitBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                submitBtn.title = 'Please fix validation errors before submitting';
            } else {
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
                submitBtn.title = '';
            }
        }

        function validateForm() {
            let isValid = true;
            const errors = [];
            
            document.querySelectorAll('.size-input').forEach(input => {
                if (input.value.trim()) {
                    const componentName = input.dataset.componentName;
                    const validation = validateUniformSize(input.value, componentName);
                    
                    if (!validation.isValid) {
                        isValid = false;
                        errors.push(`${componentName}: ${validation.errors.join(', ')}`);
                    }
                }
            });
            
            if (!isValid) {
                alert('Please fix the following errors:\n\n' + errors.join('\n'));
                return false;
            }
            
            return true;
        }

        // ================================================================
        // UNIFORM COMPONENTS LOADING
        // ================================================================
        function loadUniformComponents(uniformTypeId) {
            const container = document.getElementById('uniform-components-container');
            const loadingIndicator = document.getElementById('loading-indicator');
            
            if (!uniformTypeId) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500">
                        <p>Select a uniform type to view and manage your sizes.</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = '';
            loadingIndicator.classList.remove('hidden');

            fetch(`/cadet/inventory/uniform-types/${uniformTypeId}/components`)
                .then(response => response.json())
                .then(data => {
                    loadingIndicator.classList.add('hidden');
                    
                    if (data.components && data.components.length > 0) {
                        let formHtml = `
                            <form method="POST" action="{{ route('cadet.inventory.uniform-size.update') }}" id="uniformSizeForm" onsubmit="return validateForm()">
                                @csrf
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                        `;

                        data.components.forEach(component => {
                            let sizeInput;
                            if (component.is_issued) {
                                sizeInput = `
                                    <span class="text-gray-600">${component.size}</span>
                                    <input type="hidden" name="size[]" value="${component.size}">
                                    <input type="hidden" name="component_id[]" value="${component.id}">
                                `;
                            } else {
                                sizeInput = `
                                    <input type="text" name="size[]" value="${component.size}"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 size-input"
                                           placeholder="e.g., XS, S, M, L, 32, 7 1/2"
                                           maxlength="10"
                                           data-component-name="${component.name}">
                                    <input type="hidden" name="component_id[]" value="${component.id}">
                                    <div class="text-xs text-red-600 mt-1 hidden validation-error"></div>
                                `;
                            }

                            let status = component.is_issued 
                                ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Issued</span>'
                                : '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Pending</span>';

                            let actions = component.can_delete 
                                ? `<button type="button" onclick="removeUniformSize(${component.size_entry_id}, '${component.name}')" class="text-red-600 hover:text-red-900">Remove</button>`
                                : '';

                            formHtml += `
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        ${component.name}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ${sizeInput}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        ${status}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        ${actions}
                                    </td>
                                </tr>
                            `;
                        });

                        formHtml += `
                                        </tbody>
                                    </table>
                                    <div class="mt-4 flex justify-end">
                                        <button type="submit" id="updateSizesBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                                            Update Sizes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        `;

                        container.innerHTML = formHtml;
                        attachSizeValidation();
                    } else {
                        container.innerHTML = `
                            <div class="text-center py-8 text-gray-500">
                                <p>No uniform components found for this type.</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    loadingIndicator.classList.add('hidden');
                    container.innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            <p>Error loading uniform components. Please try again.</p>
                        </div>
                    `;
                    console.error('Error:', error);
                });
        }

        // ================================================================
        // MODAL FUNCTIONS
        // ================================================================
        function openReturnModal(loanId, itemName, borrowDate) {
            document.getElementById('modalTitle').textContent = `Return ${itemName}`;
            document.getElementById('modalDescription').textContent = `Return ${itemName} borrowed on ${borrowDate}?`;
            document.getElementById('returnForm').action = `/cadet/inventory/loan/${loanId}/return`;
            document.getElementById('return_date').setAttribute('min', borrowDate);
            document.getElementById('returnModal').classList.remove('hidden');
        }

        function closeReturnModal() {
            document.getElementById('returnModal').classList.add('hidden');
        }

        function removeUniformSize(sizeEntryId, componentName) {
            document.getElementById('deleteModalDescription').textContent = 
                `Are you sure you want to remove the uniform size for ${componentName}?`;
            document.getElementById('deleteForm').action = `/cadet/inventory/uniform-size/${sizeEntryId}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function closeBorrowModal() {
            document.getElementById('borrowModal').classList.add('hidden');
        }

        function filterItemsByCategory(category) {
            const rows = document.querySelectorAll('.item-row');
            rows.forEach(row => {
                if (category === '' || row.dataset.category === category) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // ================================================================
        // EVENT LISTENERS
        // ================================================================
        document.getElementById('returnModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReturnModal();
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            attachSizeValidation();
            
            const existingForm = document.getElementById('uniformSizeForm');
            if (existingForm) {
                existingForm.addEventListener('submit', function(e) {
                    if (!validateForm()) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT - MULTIPLE ITEMS BORROWING --}}
    {{-- ================================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectItemsBtn = document.getElementById('selectItemsBtn');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const borrowModal = document.getElementById('borrowModal');
            const borrowItemsContainer = document.getElementById('borrowItemsContainer');
            const borrowForm = document.getElementById('borrowForm');
            
            // ================================================================
            // UPDATE BUTTON STATE
            // ================================================================
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedItems = document.querySelectorAll('.item-checkbox:checked');
                    selectItemsBtn.disabled = checkedItems.length === 0;
                });
            });
            
            // ================================================================
            // SELECT ITEMS BUTTON HANDLER
            // ================================================================
            selectItemsBtn.addEventListener('click', function() {
                const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
                
                if (selectedCheckboxes.length === 0) {
                    alert('Please select at least one item to borrow.');
                    return;
                }
                
                borrowItemsContainer.innerHTML = '';
                
                selectedCheckboxes.forEach(checkbox => {
                    const itemId = checkbox.value;
                    const itemName = checkbox.dataset.itemName;
                    const availableQuantity = parseInt(checkbox.dataset.availableQuantity);
                    
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${itemName}
                            <input type="hidden" name="item_ids[]" value="${itemId}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${availableQuantity}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <input type="number" name="quantities[${itemId}]" min="1" max="${availableQuantity}" value="1" 
                                   class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 quantity-input"
                                   data-item-id="${itemId}" data-max-quantity="${availableQuantity}">
                        </td>
                    `;
                    
                    borrowItemsContainer.appendChild(row);
                    
                    const quantityInput = row.querySelector('.quantity-input');
                    quantityInput.addEventListener('change', function() {
                        const value = parseInt(this.value);
                        const max = parseInt(this.dataset.maxQuantity);
                        
                        if (value < 1) {
                            this.value = 1;
                        } else if (value > max) {
                            this.value = max;
                        }
                    });
                });
                
                borrowModal.classList.remove('hidden');
            });
            
            // ================================================================
            // MODAL CLOSE HANDLER
            // ================================================================
            borrowModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeBorrowModal();
                }
            });
            
            // ================================================================
            // FORM SUBMISSION HANDLER
            // ================================================================
            borrowForm.addEventListener('submit', function(e) {
                const quantityInputs = document.querySelectorAll('.quantity-input');
                let isValid = true;
                let errorMessage = '';
                
                quantityInputs.forEach(input => {
                    const value = parseInt(input.value);
                    const max = parseInt(input.dataset.maxQuantity);
                    
                    if (value < 1) {
                        isValid = false;
                        errorMessage = 'Quantity must be at least 1.';
                    } else if (value > max) {
                        isValid = false;
                        errorMessage = `Quantity cannot exceed ${max}.`;
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
                }
                
                const confirmBtn = document.getElementById('confirmBorrowBtn');
                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Processing...';
            });
        });
    </script>
</x-app-layout>