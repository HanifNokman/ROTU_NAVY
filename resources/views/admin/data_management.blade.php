<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ============================================================================
            SUMMARY CARDS GRID
            =========================================================================== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                @foreach($models as $key => $info)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @switch($key)
                                    @case('users')
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        @break

                                    @case('learning_materials')
                                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a9 9 0 00-9 9v5a2 2 0 002 2h14a2 2 0 002-2v-5a9 9 0 00-9-9z" />
                                        </svg>
                                        @break

                                    @case('quiz_questions')
                                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6m0 0H6m6 0h6" />
                                        </svg>
                                        @break

                                    @case('trainings')
                                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        @break

                                    @case('instructors')
                                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M9 17v-6m4 6V7m4 10v-4" />
                                        </svg>
                                        @break

                                    @case('galleries')
                                        <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4-4a3 3 0 014 0l4 4M4 8h16M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2" />
                                        </svg>
                                        @break

                                    @case('inventory_items')
                                        <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v6a8 8 0 01-16 0V7m16 0L12 13m0 0L4 7m8 6v6" />
                                        </svg>
                                        @break

                                    @default
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M9 17v-6m4 6V7m4 10v-4" />
                                        </svg>
                                @endswitch
                            </div>

                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">{{ $info['name'] }}</div>
                                <div class="text-2xl font-semibold text-gray-900">{{ $counts[$key] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ============================================================================
            MODEL SELECTION TOGGLES
            =========================================================================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium mb-4">Select Data Model</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($models as $key => $info)
                            <a href="{{ route('admin.data_management', ['model' => $key]) }}" 
                               class="px-4 py-2 text-sm {{ $selectedModel == $key ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }} rounded hover:bg-blue-600 hover:text-white transition-colors">
                                {{ $info['name'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- ============================================================================
            DATA TABLE CONTAINER
            =========================================================================== --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">{{ $models[$selectedModel]['name'] }}</h3>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-500">Total Records: {{ count($data) }}</div>
                            @if($selectedModel == 'badges')
                                <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600" onclick="openCreateModal()">Add New Badge</button>
                            @endif
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="max-h-96 overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        {{-- Example for sticky headers: add these classes to all <th> --}}
                                        @if($selectedModel == 'learning_materials')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Instructor</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Description</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">File URL</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>
                                        @elseif($selectedModel == 'uniform_types')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Type Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Description</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Created At</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>
                                        {{-- ============================================================================
                                        TABLE HEADERS: INVENTORY ITEMS
                                        =========================================================================== --}}
                                        @elseif($selectedModel == 'inventory_items')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Total Qty</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Available Qty</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Description</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>

                                        {{-- ============================================================================
                                        TABLE HEADERS: UNIFORM COMPONENTS
                                        =========================================================================== --}}
                                        @elseif($selectedModel == 'uniform_components')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Component Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Uniform Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Created At</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>

                                        {{-- ============================================================================
                                        TABLE HEADERS: EQUIPMENT LOANS
                                        =========================================================================== --}}
                                        @elseif($selectedModel == 'equipment_loans')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Cadet</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Item</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Borrow Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Return Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>

                                        {{-- ============================================================================
                                        TABLE HEADERS: GALLERIES
                                        =========================================================================== --}}
                                        @elseif($selectedModel == 'galleries')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Instructor</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Description</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Image Path</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>

                                        {{-- ============================================================================
                                        TABLE HEADERS: TRAININGS
                                        =========================================================================== --}}
                                        @elseif($selectedModel == 'trainings')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Title</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Location</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Start DateTime</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">End DateTime</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Duration (hrs)</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>

                                        {{-- ============================================================================
                                        TABLE HEADERS: QUIZ QUESTIONS
                                        =========================================================================== --}}
                                        @elseif($selectedModel == 'quiz_questions')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Question Text</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Creator</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>

                                        {{-- ============================================================================
                                        TABLE HEADERS: BADGES
                                        =========================================================================== --}}
                                        @elseif($selectedModel == 'badges')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">ID</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Name</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Icon Path</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Rarity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Active</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-50 z-10">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($data as $item)
                                        <tr>
                                            {{-- ============================================================================
                                            TABLE ROWS: LEARNING MATERIALS
                                            =========================================================================== --}}
                                            @if($selectedModel == 'learning_materials')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->title }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->instructor->user->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->category->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->file_url, 30) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: UNIFORM TYPES
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'uniform_types')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->type_name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->description }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->created_at->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: INVENTORY ITEMS
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'inventory_items')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->category }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->total_quantity }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->available_quantity }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: UNIFORM COMPONENTS
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'uniform_components')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->component_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->uniformType->type_name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->created_at->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: EQUIPMENT LOANS
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'equipment_loans')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->cadet->user->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->inventoryItem->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->borrow_date ? \Carbon\Carbon::parse($item->borrow_date)->format('d/m/Y') : 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->return_date ? \Carbon\Carbon::parse($item->return_date)->format('d/m/Y') : 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->status }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: GALLERIES
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'galleries')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->title }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->category->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->instructor->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->image_path, 30) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>
                                            {{-- ============================================================================
                                            TABLE ROWS: TRAININGS
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'trainings')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->title }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->location }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->start_datetime ? \Carbon\Carbon::parse($item->start_datetime)->format('d/m/Y H:i') : 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->end_datetime ? \Carbon\Carbon::parse($item->end_datetime)->format('d/m/Y H:i') : 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->duration_hours }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->status }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: QUIZ QUESTIONS
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'quiz_questions')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->question_text, 50) }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->category->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->question_type }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->creator->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->status }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: TRAINING ATTENDANCES
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'training_attendances')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->training->title ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->cadet->user->name ?? 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->present ? 'Yes' : 'No' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->method }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->marked_at ? \Carbon\Carbon::parse($item->marked_at)->format('d/m/Y H:i') : 'N/A' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: CONTENT SETTINGS
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'content_settings')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->key }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->value, 50) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->type }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>

                                            {{-- ============================================================================
                                            TABLE ROWS: BADGES
                                            =========================================================================== --}}
                                            @elseif($selectedModel == 'badges')
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->name }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->icon }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->category }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><span class="{{ $item->rarity_color }}">{{ $item->rarity_label }}</span></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->is_active ? 'Yes' : 'No' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                    <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                                </td>
                                            @endif
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">No records found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    {{-- ============================================================================
    EDIT MODAL
    =========================================================================== --}}
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-5/6 max-w-4xl shadow-lg rounded-md bg-white">
            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Record</h3>
                
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div id="formFields" class="max-h-96 overflow-y-auto"></div>
                    
                    <div class="flex justify-end mt-4">
                        <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeEditModal()">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============================================================================
    DELETE MODAL
    =========================================================================== --}}
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Deletion</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Are you sure you want to delete this record? This action cannot be undone.
                </p>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end mt-4">
                        <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeDeleteModal()">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============================================================================
    CREATE MODAL
    =========================================================================== --}}
    <div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-10 mx-auto p-5 border w-5/6 max-w-4xl shadow-lg rounded-md bg-white">
            <button onclick="closeCreateModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>

            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Badge</h3>

                <form id="createForm" method="POST">
                    @csrf

                    <div id="createFormFields" class="max-h-96 overflow-y-auto"></div>

                    <div class="flex justify-end mt-4">
                        <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeCreateModal()">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    // CONSTANTS
    const selectedModel = '{{ $selectedModel }}';

    // ============================================================================
    // EVENT LISTENERS INITIALIZATION
    // ============================================================================
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                openEditModal(id);
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                openDeleteModal(id);
            });
        });
    });

    // ============================================================================
    // MODAL FUNCTIONS
    // ============================================================================
    function openEditModal(id) {
        fetch(`/admin/data/${selectedModel}/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                populateEditForm(data);
                document.getElementById('editModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Error loading data: ' + error.message);
            });
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function openDeleteModal(id) {
        document.getElementById('deleteForm').action = `/admin/data/${selectedModel}/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function openCreateModal() {
        populateCreateForm();
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    // ============================================================================
    // FORM POPULATION FUNCTIONS
    // ============================================================================
    function populateCreateForm() {
        let fields = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';

        switch(selectedModel) {
            case 'badges':
                fields += generateField('Name', 'name', '', 'text', true);
                fields += generateFileField('Icon', 'icon', '');
                fields += generateField('Category', 'category', '', 'text', true);
                fields += generateSelectField('Rarity', 'rarity', '', ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary'], true);
                fields += generateField('Description', 'description', '', 'textarea', false, 'col-span-2');
                fields += generateField('Unlock Criteria', 'unlock_criteria', '', 'textarea', false, 'col-span-2');
                fields += generateSelectField('Is Active', 'is_active', '', [1, 0], true, '', ['Yes', 'No']);
                break;
            // Add other models if needed
        }

        fields += '</div>';
        document.getElementById('createFormFields').innerHTML = fields;
        document.getElementById('createForm').action = `/admin/data/${selectedModel}`;
    }
    function populateEditForm(data) {
        let fields = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
        
        switch(selectedModel) {
            case 'learning_materials':
                fields += generateField('Instructor ID', 'instructor_id', data.instructor_id, 'number', true);
                fields += generateField('Title', 'title', data.title, 'text', true);
                fields += generateField('Category ID', 'learning_material_category_id', data.learning_material_category_id, 'number', true);
                fields += generateField('Description', 'description', data.description, 'textarea', false, 'col-span-2');
                fields += generateField('File URL', 'file_url', data.file_url, 'text', false, 'col-span-2');
                break;
            
            case 'uniform_types':
                fields += generateField('Type Name', 'type_name', data.type_name, 'text', true);
                fields += generateField('Description', 'description', data.description, 'textarea', false, 'col-span-2');
                break;
            
            case 'inventory_items':
                fields += generateField('Name', 'name', data.name, 'text', true);
                fields += generateSelectField('Category', 'category', data.category, ['equipment', 'uniform'], true);
                fields += generateField('Total Quantity', 'total_quantity', data.total_quantity, 'number', true);
                fields += generateField('Available Quantity', 'available_quantity', data.available_quantity, 'number', true);
                fields += generateField('Description', 'description', data.description, 'textarea', false, 'col-span-2');
                break;
            
            case 'uniform_components':
                fields += generateField('Uniform Type ID', 'uniform_type_id', data.uniform_type_id, 'number', true);
                fields += generateField('Component Name', 'component_name', data.component_name, 'text', true);
                break;
            
            case 'equipment_loans':
                fields += generateField('Cadet ID', 'cadet_id', data.cadet_id, 'number', true);
                fields += generateField('Item ID', 'item_id', data.item_id, 'number', true);
                fields += generateField('Quantity', 'quantity', data.quantity, 'number', true);
                fields += generateField('Borrow Date', 'borrow_date', data.borrow_date, 'date', true);
                fields += generateField('Return Date', 'return_date', data.return_date, 'date', false);
                fields += generateSelectField('Status', 'status', data.status, ['Borrowed', 'Returned'], true);
                break;
            
            case 'galleries':
                fields += generateField('Title', 'title', data.title, 'text', true);
                fields += generateField('Category ID', 'gallery_category_id', data.gallery_category_id, 'number', true);
                fields += generateField('Instructor ID', 'instructor_id', data.instructor_id, 'number', true);
                fields += generateField('Description', 'description', data.description, 'textarea', false, 'col-span-2');
                fields += generateField('Image Path', 'image_path', data.image_path, 'text', false, 'col-span-2');
                break;
            
            case 'trainings':
                fields += generateField('Title', 'title', data.title, 'text', true, 'col-span-2');
                fields += generateField('Location', 'location', data.location, 'text', true);
                fields += generateSelectField('Status', 'status', data.status, ['Active', 'Completed', 'Cancelled'], true);
                fields += generateField('Start DateTime', 'start_datetime', data.start_datetime, 'datetime-local', true);
                fields += generateField('End DateTime', 'end_datetime', data.end_datetime, 'datetime-local', false);
                fields += generateField('Duration Hours', 'duration_hours', data.duration_hours, 'number', false);
                fields += generateField('Allowance Amount', 'allowance_amount', data.allowance_amount, 'number', false);
                fields += generateSelectField('Allowance Type', 'allowance_type', data.allowance_type, ['hourly', 'daily'], false);
                fields += generateField('Involvement', 'involvement', data.involvement, 'text', false);
                fields += generateField('Description', 'description', data.description, 'textarea', false, 'col-span-2');
                break;
            
            case 'quiz_questions':
                fields += generateField('Category ID', 'category_id', data.category_id, 'number', true);
                fields += generateSelectField('Question Type', 'question_type', data.question_type, ['MCQ', 'Subjective'], true);
                fields += generateField('Question Text', 'question_text', data.question_text, 'textarea', true, 'col-span-2');
                fields += generateField('File URL', 'file_url', data.file_url, 'text', false, 'col-span-2');
                fields += generateField('Option A', 'option_a', data.option_a, 'text', false);
                fields += generateField('Option B', 'option_b', data.option_b, 'text', false);
                fields += generateField('Option C', 'option_c', data.option_c, 'text', false);
                fields += generateField('Option D', 'option_d', data.option_d, 'text', false);
                fields += generateField('Correct Answer', 'correct_answer', data.correct_answer, 'text', true, 'col-span-2');
                fields += generateField('Created By', 'created_by', data.created_by, 'number', true);
                fields += generateSelectField('Status', 'status', data.status, ['active', 'inactive'], true);
                break;

            case 'badges':
                fields += generateField('Name', 'name', data.name, 'text', true);
                fields += generateFileField('Icon', 'icon', data.icon);
                fields += generateField('Category', 'category', data.category, 'text', true);
                fields += generateSelectField('Rarity', 'rarity', data.rarity, ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary'], true);
                fields += generateField('Description', 'description', data.description, 'textarea', false, 'col-span-2');
                fields += generateField('Unlock Criteria', 'unlock_criteria', data.unlock_criteria, 'textarea', false, 'col-span-2');
                fields += generateSelectField('Is Active', 'is_active', data.is_active, [1, 0], true, '', ['Yes', 'No']);
                break;
        }
        
        fields += '</div>';
        document.getElementById('formFields').innerHTML = fields;
        document.getElementById('editForm').action = `/admin/data/${selectedModel}/${data.id}`;
    }

    // ============================================================================
    // FIELD GENERATOR FUNCTIONS
    // ============================================================================
    function generateField(label, name, value, type = 'text', required = false, colSpan = '') {
        const reqAttr = required ? 'required' : '';
        const val = value || '';
        const colClass = colSpan || '';
        
        if (type === 'textarea') {
            return `
                <div class="mb-4 ${colClass}">
                    <label class="block text-sm font-medium text-gray-700">${label}</label>
                    <textarea name="${name}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" ${reqAttr}>${val}</textarea>
                </div>
            `;
        }
        
        return `
            <div class="mb-4 ${colClass}">
                <label class="block text-sm font-medium text-gray-700">${label}</label>
                <input type="${type}" name="${name}" value="${val}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" ${reqAttr}>
            </div>
        `;
    }

    function generateSelectField(label, name, value, options, required = false, colSpan = '', optionLabels = null) {
        const reqAttr = required ? 'required' : '';
        const colClass = colSpan || '';
        let optionsHtml = '';

        options.forEach((option, index) => {
            const optionLabel = optionLabels ? optionLabels[index] : option;
            const selected = value == option ? 'selected' : '';
            optionsHtml += `<option value="${option}" ${selected}>${optionLabel}</option>`;
        });

        return `
            <div class="mb-4 ${colClass}">
                <label class="block text-sm font-medium text-gray-700">${label}</label>
                <select name="${name}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md" ${reqAttr}>
                    ${optionsHtml}
                </select>
            </div>
        `;
    }

    function generateFileField(label, name, value, colSpan = '') {
        const colClass = colSpan || '';

        return `
            <div class="mb-4 ${colClass}">
                <label class="block text-sm font-medium text-gray-700">${label}</label>
                <input type="file" name="${name}" accept="image/*" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                ${value ? `<p class="mt-1 text-sm text-gray-500">Current: ${value}</p>` : ''}
            </div>
        `;
    }

    // ============================================================================
    // FORM SUBMISSION HANDLERS - FIXED VERSION
    // ============================================================================
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Updating...';
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json(); // FIXED: Added parentheses
        })
        .then(data => {
            if (data.success) {
                alert('Record updated successfully!');
                location.reload();
            } else {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                alert('Error updating record: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
            
            if (error.errors) {
                let errorMsg = 'Validation errors:\n';
                for (let field in error.errors) {
                    errorMsg += field + ': ' + error.errors[field].join(', ') + '\n';
                }
                alert(errorMsg);
            } else {
                alert('Error updating record: ' + (error.message || 'Unknown error'));
            }
        });
    });

    document.getElementById('deleteForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Record deleted successfully!');
                location.reload();
            } else {
                alert('Error deleting record: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            alert('Error deleting record: ' + error.message);
        });
    });
    </script>
</x-app-layout>