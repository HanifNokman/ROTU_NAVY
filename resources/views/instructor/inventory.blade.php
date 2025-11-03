<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventory Management') }}
            </h2>
        </div>
    </x-slot>

    <!-- Add CSRF token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .gradient-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* ========================================= */
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 640px) {
        /* Page header */
        .text-center.mb-8 h1 {
            font-size: 1.875rem !important;
            padding: 0 1rem;
        }

        .text-center.mb-8 p {
            font-size: 0.875rem !important;
            padding: 0 1rem;
        }

        /* Filter section responsiveness */
        .flex.flex-col.lg\\:flex-row {
            flex-direction: column !important;
        }

        .flex.flex-wrap.items-center.gap-4 {
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
        }

        .flex.flex-col label {
            font-size: 0.875rem !important;
        }

        .flex.flex-col select,
        .flex.flex-col input {
            width: 100% !important;
            font-size: 0.875rem !important;
        }

        /* Action buttons */
        .flex.flex-col.gap-3 {
            width: 100% !important;
        }

        .flex.flex-col.gap-3 button,
        .flex.gap-3 button {
            width: 100% !important;
            justify-content: center !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 1rem !important;
        }

        /* Uniform size summary grid */
        .grid.grid-cols-2 {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem !important;
        }

        /* Equipment loan status toggle */
        .flex.rounded-md.shadow-sm {
            width: 100% !important;
        }

        .flex.rounded-md.shadow-sm button {
            flex: 1 !important;
            font-size: 0.75rem !important;
            padding: 0.5rem !important;
        }

        /* Table responsiveness */
        .overflow-x-auto {
            border-radius: 0.5rem !important;
        }

        table {
            font-size: 0.75rem !important;
        }

        table th,
        table td {
            padding: 0.5rem 0.375rem !important;
            white-space: nowrap !important;
        }

        /* Size cards */
        .bg-white.rounded-lg.p-4 {
            padding: 0.75rem !important;
        }

        .text-2xl {
            font-size: 1.5rem !important;
        }

        /* Modal responsiveness */
        .relative.top-20.mx-auto {
            top: 1rem !important;
            margin: 1rem !important;
            width: calc(100% - 2rem) !important;
            max-width: none !important;
        }

        /* Icon wrapper sizes */
        .icon-wrapper {
            width: 2rem !important;
            height: 2rem !important;
        }

        .icon-wrapper svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }
    }

    /* Extra small devices (Honor X9a - 360px-412px) */
    @media (max-width: 400px) {
        /* Further text size reduction */
        .text-center.mb-8 h1 {
            font-size: 1.5rem !important;
        }

        .section-header h3 {
            font-size: 1.125rem !important;
        }

        /* Single column for size display */
        .grid.grid-cols-2 {
            grid-template-columns: 1fr !important;
        }

        /* Smaller filter selects */
        .flex.flex-col select {
            font-size: 0.8125rem !important;
            padding: 0.5rem !important;
        }

        /* Compact buttons */
        button {
            font-size: 0.75rem !important;
            padding: 0.5rem 0.75rem !important;
        }

        /* Table adjustments */
        table {
            font-size: 0.6875rem !important;
        }

        table th,
        table td {
            padding: 0.375rem 0.25rem !important;
        }

        /* Modal further compact */
        .relative.top-20.mx-auto {
            padding: 0.75rem !important;
        }

        .relative.top-20.mx-auto h3 {
            font-size: 1rem !important;
        }
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- DASHBOARD HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-purple rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">
                    Inventory Management
                </h1>
                <p class="text-lg text-gray-600">Manage uniforms, equipment, and inventory tracking for cadets</p>
            </div>

            {{-- Store pending returns count for use in Equipment Loan section --}}
            @php
                $pendingReturnsCount = \App\Models\EquipmentLoan::where('status', 'Pending Return')->count();
            @endphp

            {{-- ================================================================ --}}
            {{-- SECTION 1: CADET UNIFORM SIZE SUMMARY --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-blue mr-3 p-2 rounded-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Cadet Uniform Size Summary</h3>
                    </div>
                    <p class="text-gray-600 ml-13">Track and analyze uniform size distributions across different intakes and components</p>
                </div>
                
                <!-- Top Section: Filters and Controls -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <!-- Filters Section -->
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex flex-col">
                                <label for="uniform_intake_year" class="text-sm font-medium text-gray-700 mb-1">Intake</label>
                                <select name="uniform_intake_year" id="uniform_intake_year"
                                        class="w-40 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Intake</option>
                                    @foreach($intakeYears as $intake)
                                        <option value="{{ $intake['year'] }}" {{ $selectedUniformIntakeYear == $intake['year'] ? 'selected' : '' }}>
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
                        
                        <!-- Actions Section - Right Aligned with Vertical Stack -->
                        <div class="flex flex-col gap-3 lg:items-end">
                            <!-- Download Report Button (Top) -->
                            <button onclick="downloadUniformReport()" 
                                    class="w-full lg:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                                <i class="fas fa-download mr-2"></i>
                                Download Report
                            </button>
                            
                            <!-- Add Buttons Row (Bottom) -->
                            <div class="flex gap-3 justify-center lg:justify-start">
                                <button onclick="openUniformTypeModal()" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Type
                                </button>
                                
                                <button onclick="openUniformComponentModal()" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Component
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Uniform Size Summary Content -->
                <div class="p-6" id="uniformSummaryContent">
                    @if($uniformSizeSummary->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-400 text-5xl mb-4">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <p class="text-gray-500 text-lg">No uniform size data available for this intake year.</p>
                        </div>
                    @else
                        <div class="space-y-8">
                            @foreach($uniformSizeSummary as $componentName => $sizes)
                                <div class="mb-8">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold mr-3">
                                            <i class="fas fa-tag mr-1"></i>{{ $componentName }}
                                        </div>
                                        <div class="h-px bg-gray-200 flex-1"></div>
                                    </div>
                                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-xl p-6 border border-gray-100 shadow-sm">
                                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-8 gap-4">
                                            @foreach($sizes as $sizeData)
                                                <div class="bg-white rounded-lg p-4 text-center shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
                                                    <div class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Size</div>
                                                    <div class="text-2xl font-bold text-blue-600 mb-1">{{ $sizeData->size }}</div>
                                                    <div class="text-lg font-semibold text-gray-800">{{ $sizeData->cadet_count }}</div>
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

            {{-- ================================================================ --}}
            {{-- SECTION 2: EQUIPMENT LOAN MANAGEMENT --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-green mr-3 p-2 rounded-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Equipment Loan Management</h3>
                        @if($pendingReturnsCount > 0)
                            <span class="ml-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-orange-100 text-orange-800 border-2 border-orange-300 animate-pulse">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                {{ $pendingReturnsCount }} Return{{ $pendingReturnsCount > 1 ? 's' : '' }} Pending
                            </span>
                        @endif
                    </div>
                    <p class="text-gray-600 ml-13">Monitor equipment borrowing, returns, and track loan status across all cadets</p>
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
                                    <option value="">All Intake</option>
                                    @foreach($intakeYears as $intake)
                                        <option value="{{ $intake['year'] }}" {{ $selectedLoanIntakeYear == $intake['year'] ? 'selected' : '' }}>
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
                                    <option value="equipment" {{ $selectedCategory === 'equipment' ? 'selected' : '' }}>Equipment</option>
                                    <option value="uniform" {{ $selectedCategory === 'uniform' ? 'selected' : '' }}>Uniform</option>
                                </select>
                            </div>
                            
                            <!-- Loan Status Toggle -->
                            <div class="flex flex-col">
                                <label class="text-sm font-medium text-gray-700 mb-1">Loan Status</label>
                                <div class="flex rounded-md shadow-sm">
                                    <button type="button" 
                                            id="activeLoansBtn"
                                            class="px-4 py-2 text-sm font-medium rounded-l-md {{ $selectedStatus === 'active' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                                            onclick="switchLoanStatus('active')">
                                        Active Loans
                                    </button>
                                    <button type="button" 
                                            id="returnedLoansBtn"
                                            class="px-4 py-2 text-sm font-medium rounded-r-md {{ $selectedStatus === 'returned' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
                                            onclick="switchLoanStatus('returned')">
                                        Past Loans
                                    </button>
                                </div>
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

                <!-- Equipment Loan Records Content -->
                <div class="p-6" id="equipmentLoansContent">
                    @if($equipmentLoans->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-6xl mb-4">
                                <i class="fas fa-tools"></i>
                            </div>
                            <p class="text-gray-500 text-lg">No equipment loan records found.</p>
                        </div>
                    @else
                        <!-- Scrollable container with max 6 rows visible -->
                        <div class="overflow-x-auto max-h-[480px] overflow-y-auto border border-gray-200 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Cadet</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Qty</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Borrow Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Return Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($equipmentLoans as $loan)
                                        <tr class="{{ $loan->isOverdue() ? 'bg-red-50 hover:bg-red-100' : 'hover:bg-gray-50' }} transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="bg-blue-100 rounded-full p-2 mr-3">
                                                        <i class="fas fa-user text-blue-600 text-sm"></i>
                                                    </div>
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $loan->cadet->user->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $loan->inventoryItem->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                                    {{ $loan->inventoryItem->category === 'equipment' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    <i class="{{ $loan->inventoryItem->category === 'equipment' ? 'fas fa-tools' : 'fas fa-tshirt' }} mr-1"></i>
                                                    {{ ucfirst($loan->inventoryItem->category) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="text-sm font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $loan->quantity }}</span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center text-sm text-gray-900">
                                                    <i class="fas fa-calendar-alt text-gray-400 mr-2"></i>
                                                    {{ $loan->borrow_date->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($loan->return_date)
                                                    <div class="flex items-center text-sm text-gray-900">
                                                        <i class="fas fa-calendar-check text-green-500 mr-2"></i>
                                                        {{ $loan->return_date->format('M d, Y') }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($loan->status === 'Borrowed')
                                                    @if($loan->isOverdue())
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                                            Overdue ({{ $loan->days_overdue }} days)
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i>
                                                            Borrowed
                                                        </span>
                                                    @endif
                                                @elseif($loan->status === 'Pending Return')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                                        <i class="fas fa-hourglass-half mr-1"></i>
                                                        Pending Return
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                        <i class="fas fa-check-circle mr-1"></i>
                                                        Returned
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if($loan->status === 'Pending Return')
                                                    <div class="flex gap-2">
                                                        <form method="POST" action="{{ route('instructor.inventory.update-loan', $loan) }}" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="action" value="approve_return">
                                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs font-medium transition-colors duration-200">
                                                                <i class="fas fa-check mr-1"></i>Accept
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('instructor.inventory.update-loan', $loan) }}" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="action" value="reject_return">
                                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs font-medium transition-colors duration-200">
                                                                <i class="fas fa-times mr-1"></i>Reject
                                                            </button>
                                                        </form>
                                                    </div>
                                                @elseif($loan->status === 'Borrowed')
                                                    <form method="POST" action="{{ route('instructor.inventory.update-loan', $loan) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="Returned">
                                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium transition-colors duration-200">
                                                            <i class="fas fa-check mr-1"></i>Mark Returned
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

            {{-- ================================================================ --}}
            {{-- SECTION 3: INVENTORY OVERVIEW --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex items-center mb-2">
                        <div class="icon-wrapper gradient-orange mr-3 p-2 rounded-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Inventory Overview</h3>
                    </div>
                    <p class="text-gray-600 ml-13">Real-time inventory status and availability tracking for all equipment and uniforms</p>
                </div>
                <div class="p-6">
                    
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

    {{-- ================================================================ --}}
    {{-- MODALS --}}
    {{-- ================================================================ --}}

    {{-- Modal for Add Uniform Type --}}
    <div id="uniformTypeModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-6 w-96 shadow-2xl rounded-2xl bg-white transform transition-all duration-300">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-2">
                        <div class="icon-wrapper gradient-blue" style="width: 2rem; height: 2rem;">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Uniform Type Management</h3>
                    </div>
                    <button onclick="closeUniformTypeModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all duration-200 hover:rotate-90">
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

    {{-- Modal for Add Uniform Component --}}
    <div id="uniformComponentModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-6 w-96 shadow-2xl rounded-2xl bg-white transform transition-all duration-300">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-2">
                        <div class="icon-wrapper gradient-green" style="width: 2rem; height: 2rem;">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Uniform Component Management</h3>
                    </div>
                    <button onclick="closeUniformComponentModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all duration-200 hover:rotate-90">
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

    {{-- Modal for Add Equipment --}}
    <div id="equipmentModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="relative top-20 mx-auto p-6 w-96 shadow-2xl rounded-2xl bg-white transform transition-all duration-300">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-2">
                        <div class="icon-wrapper gradient-orange" style="width: 2rem; height: 2rem;">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Equipment Management</h3>
                    </div>
                    <button onclick="closeEquipmentModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all duration-200 hover:rotate-90">
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

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>

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

    <!-- JavaScript for Enhanced Functionality -->
    <script>
        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Current filter states
        let currentFilters = {
            uniformIntakeYear: '',
            uniformType: '',
            uniformComponent: '',
            loanIntakeYear: '',
            equipmentCategory: '{{ $selectedCategory }}',
            loanStatus: '{{ $selectedStatus }}'
        };

        // Instant filtering functions
        function updateUniformSummary() {
            // Only show data if both intake year and uniform type are selected
            if (!currentFilters.uniformIntakeYear || !currentFilters.uniformType) {
                document.getElementById('uniformSummaryContent').innerHTML = `
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-5xl mb-4">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <p class="text-gray-500 text-lg">Please select both Intake and Uniform Type to view size summary.</p>
                    </div>
                `;
                return;
            }

            const data = new URLSearchParams({
                action: 'uniform_summary',
                intake_year: currentFilters.uniformIntakeYear,
                uniform_type: currentFilters.uniformType || '',
                uniform_component: currentFilters.uniformComponent || ''
            });

            fetch(`{{ route('instructor.inventory') }}?${data}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.uniformSizeSummary) {
                    document.getElementById('uniformSummaryContent').innerHTML = data.uniformSizeSummary;
                }
            })
            .catch(error => {
                console.error('Error updating uniform summary:', error);
                showAlert('Error updating uniform summary', 'error');
            });
        }

        function updateEquipmentLoans() {
            const data = new URLSearchParams({
                action: 'equipment_loans',
                loan_intake_year: currentFilters.loanIntakeYear || '',
                equipment_category: currentFilters.equipmentCategory || '',
                loan_status: currentFilters.loanStatus
            });

            fetch(`{{ route('instructor.inventory') }}?${data}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.equipmentLoans) {
                    document.getElementById('equipmentLoansContent').innerHTML = data.equipmentLoans;
                }
            })
            .catch(error => {
                console.error('Error updating equipment loans:', error);
                showAlert('Error updating equipment loans', 'error');
            });
        }

        function updateComponentDropdown() {
            const data = new URLSearchParams({
                action: 'components_by_type',
                uniform_type: currentFilters.uniformType || ''
            });

            fetch(`{{ route('instructor.inventory') }}?${data}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.components) {
                    const componentSelect = document.getElementById('uniform_component');
                    componentSelect.innerHTML = '<option value="">All Component</option>';
                    
                    data.components.forEach(component => {
                        const option = document.createElement('option');
                        option.value = component.id;
                        option.textContent = component.component_name;
                        if (component.id == currentFilters.uniformComponent) {
                            option.selected = true;
                        }
                        componentSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error updating components:', error);
            });
        }

        // Event listeners for instant filtering
        document.addEventListener('DOMContentLoaded', function() {
            // Uniform section filters
            const uniformIntakeSelect = document.getElementById('uniform_intake_year');
            const uniformTypeSelect = document.getElementById('uniform_type');
            const uniformComponentSelect = document.getElementById('uniform_component');

            // Equipment section filters
            const loanIntakeSelect = document.getElementById('loan_intake_year');
            const equipmentCategorySelect = document.getElementById('equipment_category');

            // Reset uniform filters to empty on page load
            uniformIntakeSelect.value = '';
            uniformTypeSelect.value = '';
            uniformComponentSelect.value = '';
            updateUniformSummary();

            // Reset equipment loan filters to empty on page load
            loanIntakeSelect.value = '';
            updateEquipmentLoans();

            if (uniformIntakeSelect) {
                uniformIntakeSelect.addEventListener('change', function() {
                    currentFilters.uniformIntakeYear = this.value;
                    updateUniformSummary();
                });
            }

            if (uniformTypeSelect) {
                uniformTypeSelect.addEventListener('change', function() {
                    currentFilters.uniformType = this.value;
                    currentFilters.uniformComponent = ''; // Reset component when type changes
                    updateComponentDropdown();
                    updateUniformSummary();
                });
            }

            if (uniformComponentSelect) {
                uniformComponentSelect.addEventListener('change', function() {
                    currentFilters.uniformComponent = this.value;
                    updateUniformSummary();
                });
            }

            if (loanIntakeSelect) {
                loanIntakeSelect.addEventListener('change', function() {
                    currentFilters.loanIntakeYear = this.value;
                    updateEquipmentLoans();
                });
            }

            if (equipmentCategorySelect) {
                equipmentCategorySelect.addEventListener('change', function() {
                    currentFilters.equipmentCategory = this.value;
                    updateEquipmentLoans();
                });
            }
        });

        // Function to switch loan status with instant update
        function switchLoanStatus(status) {
            // Update button styles
            document.getElementById('activeLoansBtn').className = 
                status === 'active' 
                ? 'px-4 py-2 text-sm font-medium rounded-l-md bg-green-600 text-white'
                : 'px-4 py-2 text-sm font-medium rounded-l-md bg-gray-200 text-gray-700 hover:bg-gray-300';
                
            document.getElementById('returnedLoansBtn').className = 
                status === 'returned' 
                ? 'px-4 py-2 text-sm font-medium rounded-r-md bg-green-600 text-white'
                : 'px-4 py-2 text-sm font-medium rounded-r-md bg-gray-200 text-gray-700 hover:bg-gray-300';
            
            // Update filter and refresh content
            currentFilters.loanStatus = status;
            updateEquipmentLoans();
        }

        // Modal Functions
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

        // Function to download uniform report
        function downloadUniformReport() {
            const params = new URLSearchParams();
            
            // Add current filter values
            if (currentFilters.uniformType) {
                params.append('uniform_type', currentFilters.uniformType);
            }
            if (currentFilters.uniformComponent) {
                params.append('uniform_component', currentFilters.uniformComponent);
            }
            
            // Create download URL
            const downloadUrl = '/instructor/inventory/export/uniform-summary?' + params.toString();
            
            // Create temporary link and trigger download
            const link = document.createElement('a');
            link.href = downloadUrl;
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            showAlert('Uniform size summary report is being downloaded...', 'success');
        }
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
    </script>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</x-app-layout>