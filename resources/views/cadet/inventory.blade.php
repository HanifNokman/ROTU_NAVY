<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Inventory') }}
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
    .dashboard-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid #e5e7eb;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #d1d5db;
    }

    .section-header {
        padding: 1.75rem;
        border-bottom: 2px solid #f3f4f6;
        background: linear-gradient(to right, #f8fafc 0%, #f1f5f9 100%);
    }

    /* ========================================= */
    /* TABLE STYLES */
    /* ========================================= */
    .data-table {
        min-width: 100%;
        background: white;
    }

    .data-table thead {
        background: linear-gradient(to right, #f8fafc 0%, #f1f5f9 100%);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .data-table th {
        padding: 1rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .data-table tbody tr {
        transition: background-color 0.15s ease;
    }

    .data-table tbody tr:hover {
        background-color: #f9fafb;
    }

    /* ========================================= */
    /* BADGE & STATUS STYLES */
    /* ========================================= */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-borrowed {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-overdue {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .status-returned {
        background-color: #d1fae5;
        color: #065f46;
    }

    /* ========================================= */
    /* ICON STYLES */
    /* ========================================= */
    .icon-wrapper {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
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

    .gradient-yellow {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* ========================================= */
    /* FORM STYLES */
    /* ========================================= */
    .form-input {
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* ========================================= */
    /* BUTTON STYLES */
    /* ========================================= */
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background: white;
        color: #374151;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 1px solid #d1d5db;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #f9fafb;
        border-color: #9ca3af;
    }

    /* ========================================= */
    /* DROPDOWN/COLLAPSE STYLES */
    /* ========================================= */
    .section-toggle {
        cursor: pointer;
        user-select: none;
    }

    .section-toggle:hover {
        background: linear-gradient(to right, #f1f5f9 0%, #e2e8f0 100%);
    }

    .dropdown-icon {
        transition: transform 0.3s ease;
    }

    .dropdown-icon.rotated {
        transform: rotate(180deg);
    }

    .section-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .section-content.expanded {
        max-height: 5000px;
        transition: max-height 0.5s ease-in;
    }

    /* ========================================= */
    /* ALERT STYLES */
    /* ========================================= */
    .alert {
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .alert-warning {
        background-color: #fef3c7;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }

    .alert-success {
        background-color: #d1fae5;
        border-left: 4px solid #10b981;
        color: #065f46;
    }

    .alert-error {
        background-color: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-blue rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">
                    My Inventory
                </h1>
                <p class="text-lg text-gray-600">Manage your uniform sizes and equipment loans</p>
            </div>

            {{-- ================================================================ --}}
            {{-- ALERTS --}}
            {{-- ================================================================ --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            {{-- ACTIVE LOANS ALERT --}}
            @if($activeLoans->isNotEmpty())
                <div class="alert alert-warning">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <p class="font-semibold">
                            You have {{ $activeLoans->count() }} active equipment loan(s).
                            @php
                                $overdueCount = $activeLoans->filter(fn($loan) => $loan->isOverdue())->count();
                            @endphp
                            @if($overdueCount > 0)
                                <span class="text-red-700">{{ $overdueCount }} overdue!</span>
                            @endif
                        </p>
                    </div>
                </div>
            @endif

            {{-- ================================================================ --}}
            {{-- UNIFORM SIZES SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                
                {{-- Section Header --}}
                <div class="section-header section-toggle" onclick="toggleSection('uniformSizes')">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-blue mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                                    My Uniform Sizes
                                </h3>
                                <p class="text-gray-600">Manage your uniform component sizes</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-gray-600 dropdown-icon" id="uniformSizes-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div class="section-content" id="uniformSizes-content">
                    <div class="p-6">
                    {{-- Size Format Guidelines --}}
                    <div class="mb-6 p-5 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl">
                        <h4 class="font-bold text-blue-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Size Format Guidelines
                        </h4>
                        <div class="text-sm text-blue-800 space-y-2">
                            <p class="font-semibold">General Rules:</p>
                            <ul class="list-disc list-inside ml-4 space-y-1">
                                <li>Size must be 1-5 characters long</li>
                                <li>Only letters, numbers, spaces, forward slashes (/) and hyphens (-) allowed</li>
                                <li>Cannot start or end with spaces</li>
                                <li>Examples: XS, S, M, L, XL, XXL, 1, 32, 34/36, 7 1/2</li>
                            </ul>
                        </div>
                    </div>
                    
                    {{-- Uniform Type Filter --}}
                    <div class="mb-6 p-5 bg-gray-50 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter by Uniform Type
                            </h4>
                            <select 
                                id="uniform_type_filter" 
                                name="uniform_type" 
                                onchange="loadUniformComponentsAjax(this.value)"
                                class="form-input w-64">
                                <option value="">Select Uniform Type</option>
                                @foreach($uniformTypes as $type)
                                    <option value="{{ $type->id }}" {{ $selectedUniformType == $type->id ? 'selected' : '' }}>
                                        {{ $type->type_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Components Container --}}
                        <div id="uniform-components-container">
                            @if($selectedUniformType && $uniformComponents->isNotEmpty())
                                <form method="POST" action="{{ route('cadet.inventory.uniform-size.update') }}" id="uniformSizeForm" onsubmit="return validateForm()">
                                    @csrf
                                    <div class="overflow-x-auto custom-scrollbar rounded-lg border border-gray-200">
                                        <table class="data-table">
                                            <thead>
                                                <tr>
                                                    <th>Component</th>
                                                    <th>Size</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($uniformComponents as $component)
                                                    @php
                                                        $sizeEntry = $uniformSizes->get($component->id);
                                                    @endphp
                                                    <tr>
                                                        <td class="font-medium text-gray-900">
                                                            {{ $component->component_name }}
                                                        </td>
                                                        <td>
                                                            @if($sizeEntry && $sizeEntry->is_issued)
                                                                <span class="text-gray-600 font-medium">{{ $sizeEntry->size }}</span>
                                                            @else
                                                                <input 
                                                                    type="hidden" 
                                                                    name="component_id[]" 
                                                                    value="{{ $component->id }}">
                                                                <input 
                                                                    type="text" 
                                                                    name="size[]" 
                                                                    value="{{ $sizeEntry ? $sizeEntry->size : '' }}"
                                                                    placeholder="Enter size"
                                                                    class="form-input w-full max-w-xs size-input"
                                                                    maxlength="10">
                                                                <div class="text-red-500 text-xs mt-1 hidden error-message"></div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($sizeEntry)
                                                                @if($sizeEntry->is_issued)
                                                                    <span class="status-badge" style="background-color: #d1fae5; color: #065f46;">
                                                                        Issued
                                                                    </span>
                                                                @else
                                                                    <span class="status-badge" style="background-color: #fef3c7; color: #92400e;">
                                                                        Not Issued
                                                                    </span>
                                                                @endif
                                                            @else
                                                                <span class="text-gray-400 text-sm">No size recorded</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($sizeEntry && !$sizeEntry->is_issued)
                                                                <button 
                                                                    type="button"
                                                                    onclick="openDeleteModal({{ $sizeEntry->id }}, '{{ $component->component_name }}')"
                                                                    class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                                                    Remove
                                                                </button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="mt-6 flex justify-end">
                                        <button type="submit" class="btn-primary">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Save Uniform Sizes
                                        </button>
                                    </div>
                                </form>
                            @else
                                <p class="text-center text-gray-500 py-8">Please select a uniform type to view components.</p>
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- AVAILABLE ITEMS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                
                {{-- Section Header --}}
                <div class="section-header section-toggle" onclick="toggleSection('availableItems')">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-purple mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                                    Available Items
                                </h3>
                                <p class="text-gray-600">Select items to borrow</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <button 
                                id="selectItemsBtn" 
                                type="button"
                                onclick="openBorrowModal()"
                                disabled
                                class="btn-primary disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Borrow Selected Items
                            </button>
                            <svg class="w-6 h-6 text-gray-600 dropdown-icon" id="availableItems-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="section-content" id="availableItems-content">
                <div class="p-6">
                    @if($availableItems->isNotEmpty())
                        <div class="overflow-x-auto custom-scrollbar rounded-lg border border-gray-200">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="w-12">
                                            <input type="checkbox" id="selectAll" class="rounded">
                                        </th>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Total Quantity</th>
                                        <th>Available</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($availableItems as $item)
                                        <tr>
                                            <td>
                                                <input 
                                                    type="checkbox" 
                                                    class="item-checkbox rounded" 
                                                    value="{{ $item->id }}"
                                                    data-item-name="{{ $item->name }}"
                                                    data-available-quantity="{{ $item->available_quantity }}">
                                            </td>
                                            <td class="font-medium text-gray-900">{{ $item->name }}</td>
                                            <td>
                                                @if($item->category === 'equipment')
                                                    <span class="status-badge" style="background-color: #dbeafe; color: #1e40af;">
                                                        Equipment
                                                    </span>
                                                @else
                                                    <span class="status-badge" style="background-color: #e9d5ff; color: #6b21a8;">
                                                        Uniform
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-gray-700">{{ $item->total_quantity }}</td>
                                            <td class="text-gray-700 font-semibold">{{ $item->available_quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-12">No items available for borrowing.</p>
                    @endif
                </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- ACTIVE LOANS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                
                {{-- Section Header --}}
                <div class="section-header section-toggle" onclick="toggleSection('activeLoans')">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-yellow mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                                    Active Loans
                                </h3>
                                <p class="text-gray-600">Your currently borrowed equipment</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-gray-600 dropdown-icon" id="activeLoans-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div class="section-content" id="activeLoans-content">
                    <div class="p-6">
                    @if($activeLoans->isNotEmpty())
                        <div class="overflow-x-auto custom-scrollbar rounded-lg border border-gray-200">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Borrow Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeLoans as $loan)
                                        <tr>
                                            <td class="font-medium text-gray-900">
                                                {{ $loan->inventoryItem->name }}
                                            </td>
                                            <td>
                                                @if($loan->isEquipment())
                                                    <span class="status-badge" style="background-color: #dbeafe; color: #1e40af;">
                                                        Equipment
                                                    </span>
                                                @else
                                                    <span class="status-badge" style="background-color: #e9d5ff; color: #6b21a8;">
                                                        Uniform
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-gray-700">{{ $loan->quantity }}</td>
                                            <td class="text-gray-700">{{ $loan->formatted_borrow_date }}</td>
                                            <td class="text-gray-700">{{ $loan->formatted_due_date }}</td>
                                            <td>
                                                @if($loan->isOverdue())
                                                    <span class="status-badge status-overdue">
                                                        Overdue
                                                    </span>
                                                @else
                                                    <span class="status-badge status-borrowed">
                                                        Borrowed
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('cadet.inventory.loan.return', $loan) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="return_date" value="{{ now()->toDateString() }}">
                                                    <button type="submit" class="text-green-600 hover:text-green-800 font-medium transition-colors">
                                                        Return
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-12">No active loans at the moment.</p>
                    @endif
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- PAST LOANS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                
                {{-- Section Header --}}
                <div class="section-header section-toggle" onclick="toggleSection('pastLoans')">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="icon-wrapper gradient-green mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                                    Past Loans
                                </h3>
                                <p class="text-gray-600">Your loan history</p>
                            </div>
                        </div>
                        <svg class="w-6 h-6 text-gray-600 dropdown-icon" id="pastLoans-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <div class="section-content" id="pastLoans-content">
                <div class="p-6">
                    @if($pastLoans->isNotEmpty())
                        <div class="overflow-x-auto custom-scrollbar rounded-lg border border-gray-200">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Borrow Date</th>
                                        <th>Return Date</th>
                                        <th>Days Borrowed</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pastLoans as $loan)
                                        <tr>
                                            <td class="font-medium text-gray-900">
                                                {{ $loan->inventoryItem->name }}
                                            </td>
                                            <td>
                                                @if($loan->isEquipment())
                                                    <span class="status-badge" style="background-color: #dbeafe; color: #1e40af;">
                                                        Equipment
                                                    </span>
                                                @else
                                                    <span class="status-badge" style="background-color: #e9d5ff; color: #6b21a8;">
                                                        Uniform
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-gray-700">{{ $loan->quantity }}</td>
                                            <td class="text-gray-700">{{ $loan->formatted_borrow_date }}</td>
                                            <td class="text-gray-700">{{ $loan->formatted_return_date }}</td>
                                            <td class="text-gray-700">{{ $loan->days_borrowed }} days</td>
                                            <td>
                                                <span class="status-badge status-returned">
                                                    Returned
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $pastLoans->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-12">No past loans found.</p>
                    @endif
                </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- DELETE CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 text-center mb-2">Remove Uniform Size</h3>
                <p class="text-sm text-gray-600 text-center mb-6" id="deleteMessage"></p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" onclick="closeDeleteModal()" class="btn-secondary flex-1">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            Remove
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- BORROW MODAL --}}
    {{-- ================================================================ --}}
    <div id="borrowModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-6 border w-full max-w-4xl shadow-lg rounded-xl bg-white my-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Borrow Items
                </h3>
                <button type="button" onclick="closeBorrowModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('cadet.inventory.loan.create') }}" id="borrowForm">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Borrow Date</label>
                    <input 
                        type="date" 
                        name="borrow_date" 
                        max="{{ date('Y-m-d') }}"
                        value="{{ date('Y-m-d') }}"
                        required
                        class="form-input w-full">
                </div>

                <div class="overflow-x-auto custom-scrollbar rounded-lg border border-gray-200 mb-6">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Available</th>
                                <th>Quantity to Borrow</th>
                            </tr>
                        </thead>
                        <tbody id="borrowItemsContainer">
                            {{-- Dynamic content added by JavaScript --}}
                        </tbody>
                    </table>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeBorrowModal()" class="btn-secondary flex-1">
                        Cancel
                    </button>
                    <button type="submit" id="confirmBorrowBtn" class="btn-primary flex-1">
                        Confirm Borrow
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT - UNIFORM SIZE MANAGEMENT --}}
    {{-- ================================================================ --}}
    <script>
        function loadUniformComponentsAjax(uniformTypeId) {
            const container = document.getElementById('uniform-components-container');
            
            if (!uniformTypeId) {
                container.innerHTML = '<p class="text-center text-gray-500 py-8">Please select a uniform type to view components.</p>';
                return;
            }
            
            // Show loading state
            container.innerHTML = `
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                </div>
            `;
            
            // Fetch components via AJAX
            fetch(`/cadet/inventory/uniform-types/${uniformTypeId}/components`)
                .then(response => response.json())
                .then(data => {
                    if (data.components && data.components.length > 0) {
                        let html = `
                            <form method="POST" action="{{ route('cadet.inventory.uniform-size.update') }}" id="uniformSizeForm" onsubmit="return validateForm()">
                                @csrf
                                <div class="overflow-x-auto custom-scrollbar rounded-lg border border-gray-200">
                                    <table class="data-table">
                                        <thead>
                                            <tr>
                                                <th>Component</th>
                                                <th>Size</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        `;
                        
                        data.components.forEach(component => {
                            html += `
                                <tr>
                                    <td class="font-medium text-gray-900">
                                        ${component.name}
                                    </td>
                                    <td>
                            `;
                            
                            if (component.is_issued) {
                                html += `<span class="text-gray-600 font-medium">${component.size}</span>`;
                            } else {
                                html += `
                                    <input type="hidden" name="component_id[]" value="${component.id}">
                                    <input 
                                        type="text" 
                                        name="size[]" 
                                        value="${component.size || ''}"
                                        placeholder="Enter size"
                                        class="form-input w-full max-w-xs size-input"
                                        maxlength="10">
                                    <div class="text-red-500 text-xs mt-1 hidden error-message"></div>
                                `;
                            }
                            
                            html += `
                                    </td>
                                    <td>
                            `;
                            
                            if (component.size) {
                                if (component.is_issued) {
                                    html += `
                                        <span class="status-badge" style="background-color: #d1fae5; color: #065f46;">
                                            Issued
                                        </span>
                                    `;
                                } else {
                                    html += `
                                        <span class="status-badge" style="background-color: #fef3c7; color: #92400e;">
                                            Not Issued
                                        </span>
                                    `;
                                }
                            } else {
                                html += `<span class="text-gray-400 text-sm">No size recorded</span>`;
                            }
                            
                            html += `
                                    </td>
                                    <td>
                            `;
                            
                            if (component.can_delete) {
                                html += `
                                    <button 
                                        type="button"
                                        onclick="openDeleteModal(${component.size_entry_id}, '${component.name}')"
                                        class="text-red-600 hover:text-red-800 font-medium transition-colors">
                                        Remove
                                    </button>
                                `;
                            }
                            
                            html += `
                                    </td>
                                </tr>
                            `;
                        });
                        
                        html += `
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button type="submit" class="btn-primary">
                                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Save Uniform Sizes
                                    </button>
                                </div>
                            </form>
                        `;
                        
                        container.innerHTML = html;
                        
                        // Re-attach validation to new inputs
                        attachSizeValidation();
                        
                        // Re-attach form submit handler
                        const form = document.getElementById('uniformSizeForm');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                if (!validateForm()) {
                                    e.preventDefault();
                                }
                            });
                        }
                    } else {
                        container.innerHTML = '<p class="text-center text-gray-500 py-8">No components found for this uniform type.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = '<p class="text-center text-red-500 py-8">Error loading components. Please try again.</p>';
                });
        }

        function openDeleteModal(sizeId, componentName) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const message = document.getElementById('deleteMessage');
            
            form.action = `/cadet/inventory/uniform-size/${sizeId}`;
            message.textContent = `Are you sure you want to remove the uniform size for ${componentName}?`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function validateForm() {
            const inputs = document.querySelectorAll('.size-input');
            let isValid = true;

            inputs.forEach(input => {
                const value = input.value.trim();
                const errorDiv = input.nextElementSibling;
                
                if (value && !validateSizeFormat(value)) {
                    errorDiv.textContent = 'Invalid size format';
                    errorDiv.classList.remove('hidden');
                    isValid = false;
                } else {
                    errorDiv.classList.add('hidden');
                }
            });

            return isValid;
        }

        function validateSizeFormat(size) {
            const pattern = /^[A-Za-z0-9\/\- ]{1,10}$/;
            return pattern.test(size) && size.trim() === size;
        }

        function attachSizeValidation() {
            document.querySelectorAll('.size-input').forEach(input => {
                input.addEventListener('blur', function() {
                    const value = this.value.trim();
                    const errorDiv = this.nextElementSibling;
                    
                    if (value && !validateSizeFormat(value)) {
                        errorDiv.textContent = 'Invalid size format';
                        errorDiv.classList.remove('hidden');
                    } else {
                        errorDiv.classList.add('hidden');
                    }
                });
            });
        }

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
    {{-- JAVASCRIPT - BORROW MANAGEMENT --}}
    {{-- ================================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const selectItemsBtn = document.getElementById('selectItemsBtn');
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const borrowModal = document.getElementById('borrowModal');
            const borrowItemsContainer = document.getElementById('borrowItemsContainer');
            const borrowForm = document.getElementById('borrowForm');
            
            // Select all functionality
            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    updateButtonState();
                });
            }
            
            // Update button state
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateButtonState();
                    updateSelectAllState();
                });
            });
            
            function updateButtonState() {
                const checkedItems = document.querySelectorAll('.item-checkbox:checked');
                selectItemsBtn.disabled = checkedItems.length === 0;
            }
            
            function updateSelectAllState() {
                const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = someChecked && !allChecked;
            }
            
            // Modal close handler
            borrowModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeBorrowModal();
                }
            });
            
            // Form submission handler
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

        function openBorrowModal() {
            const selectedCheckboxes = document.querySelectorAll('.item-checkbox:checked');
            
            if (selectedCheckboxes.length === 0) {
                alert('Please select at least one item to borrow.');
                return;
            }
            
            const borrowItemsContainer = document.getElementById('borrowItemsContainer');
            borrowItemsContainer.innerHTML = '';
            
            selectedCheckboxes.forEach(checkbox => {
                const itemId = checkbox.value;
                const itemName = checkbox.dataset.itemName;
                const availableQuantity = parseInt(checkbox.dataset.availableQuantity);
                
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="font-medium text-gray-900">
                        ${itemName}
                        <input type="hidden" name="item_ids[]" value="${itemId}">
                    </td>
                    <td class="text-gray-700">
                        ${availableQuantity}
                    </td>
                    <td>
                        <input type="number" name="quantities[${itemId}]" min="1" max="${availableQuantity}" value="1" 
                               class="form-input w-32 quantity-input"
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
            
            document.getElementById('borrowModal').classList.remove('hidden');
        }

        function closeBorrowModal() {
            document.getElementById('borrowModal').classList.add('hidden');
            document.getElementById('confirmBorrowBtn').disabled = false;
            document.getElementById('confirmBorrowBtn').textContent = 'Confirm Borrow';
        }

        // ================================================================
        // SECTION TOGGLE FUNCTION
        // ================================================================
        function toggleSection(sectionId) {
            const content = document.getElementById(sectionId + '-content');
            const icon = document.getElementById(sectionId + '-icon');
            
            if (content.classList.contains('expanded')) {
                content.classList.remove('expanded');
                icon.classList.remove('rotated');
            } else {
                content.classList.add('expanded');
                icon.classList.add('rotated');
            }
        }

        // Sections are collapsed by default (no auto-expand on page load)
    </script>
</x-app-layout>