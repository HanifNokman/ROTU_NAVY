<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                @foreach($models as $key => $info)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">{{ $info['name'] }}</div>
                                <div class="text-2xl font-semibold text-gray-900">{{ $counts[$key] }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Model Toggles -->
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

            <!-- Data Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">{{ $models[$selectedModel]['name'] }}</h3>
                        <div class="text-sm text-gray-500">Total Records: {{ count($data) }}</div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @if($selectedModel == 'learning_materials')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File URL</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    
                                    @elseif($selectedModel == 'uniform_types')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    
                                    @elseif($selectedModel == 'inventory_items')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Qty</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available Qty</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    
                                    @elseif($selectedModel == 'uniform_components')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uniform Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    
                                    @elseif($selectedModel == 'equipment_loans')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cadet</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrow Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Return Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    
                                    @elseif($selectedModel == 'galleries')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image Path</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    
                                    @elseif($selectedModel == 'trainings')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start DateTime</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End DateTime</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration (hrs)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    
                                    @elseif($selectedModel == 'quiz_questions')
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question Text</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Creator</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($data as $item)
                                    <tr>
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
                                        
                                        @elseif($selectedModel == 'uniform_types')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->type_name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->description }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->created_at->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                            </td>
                                        
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
                                        
                                        @elseif($selectedModel == 'uniform_components')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->id }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->component_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->uniformType->type_name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->created_at->format('d/m/Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button class="text-indigo-600 hover:text-indigo-900 edit-btn" data-id="{{ $item->id }}">Edit</button>
                                                <button class="text-red-600 hover:text-red-900 ml-2 delete-btn" data-id="{{ $item->id }}">Delete</button>
                                            </td>
                                        
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
                                        @endif
                                    </tr>
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

    <!-- Edit Modal -->
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
                        <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeEditModal()">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Confirm Deletion</h3>
                <p class="text-sm text-gray-500 mb-4">Are you sure you want to delete this record? This action cannot be undone.</p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end mt-4">
                        <button type="button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeDeleteModal()">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const selectedModel = '{{ $selectedModel }}';

        document.addEventListener('DOMContentLoaded', function() {
            // Edit modal functionality
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    openEditModal(id);
                });
            });

            // Delete modal functionality
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    openDeleteModal(id);
                });
            });
        });

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

        function populateEditForm(data) {
            let fields = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4">';
            
            // Generate form fields based on model type
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
            }
            
            fields += '</div>';
            document.getElementById('formFields').innerHTML = fields;
            document.getElementById('editForm').action = `/admin/data/${selectedModel}/${data.id}`;
        }

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

        // Handle edit form submission
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
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
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Record updated successfully!');
                    location.reload();
                } else {
                    alert('Error updating record: ' + (data.error || 'Unknown error'));
                }
            })
            .catch(error => {
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

        // Handle delete form submission
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