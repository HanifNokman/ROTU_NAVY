<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gamification Management') }}
            </h2>
            <button onclick="openAddBadgeModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Badge
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Badges -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Total Badges</div>
                            <div class="text-2xl font-semibold text-gray-900">{{ $badges->count() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Active Badges -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Active Badges</div>
                            <div class="text-2xl font-semibold text-gray-900">{{ $badges->where('is_active', true)->count() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Badges -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Dynamic Badges</div>
                            <div class="text-2xl font-semibold text-gray-900">{{ $badges->where('criteria_type', 'dynamic')->count() }}</div>
                        </div>
                    </div>
                </div>

                <!-- Total Unlocks -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-500">Total Unlocks</div>
                            <div class="text-2xl font-semibold text-gray-900">{{ $badges->sum('cadet_badges_count') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 md:mb-0">Badge Library</h3>

                        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                            <!-- Category Filter -->
                            <select id="categoryFilter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>

                            <!-- Type Filter -->
                            <select id="typeFilter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">All Types</option>
                                <option value="dynamic">Dynamic</option>
                                <option value="hardcoded">Hardcoded</option>
                            </select>

                            <!-- Search -->
                            <input type="text" id="searchFilter" placeholder="Search badges..." class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Badges Grid -->
                    <div id="badgesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($badges as $badge)
                        <div class="badge-card border border-gray-200 rounded-lg p-5 hover:shadow-lg transition-shadow duration-200"
                             data-category="{{ $badge->category }}"
                             data-type="{{ $badge->criteria_type }}"
                             data-name="{{ strtolower($badge->name) }}"
                             data-description="{{ strtolower($badge->description) }}">

                            <!-- Badge Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    @if($badge->hasImageIcon())
                                        <img src="{{ $badge->icon_url }}" class="w-12 h-12 rounded-full mr-3" alt="{{ $badge->name }}">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center mr-3">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $badge->name }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" style="background-color: {{ $badge->rarity_color }}20; color: {{ $badge->rarity_color }}">
                                                {{ $badge->rarity_label }}
                                            </span>
                                            @if($badge->criteria_type === 'dynamic')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                    Dynamic
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if($badge->is_active)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </div>

                            <!-- Badge Description -->
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($badge->description, 80) }}</p>

                            <!-- Category Badge -->
                            <div class="mb-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $badge->category_name }}
                                </span>
                            </div>

                            <!-- Unlock Count -->
                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                {{ $badge->cadet_badges_count }} unlocks
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2 border-t border-gray-200 pt-4">
                                <button onclick="viewBadge({{ $badge->id }})" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </button>
                                <button onclick="editBadge({{ $badge->id }})" class="flex-1 inline-flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button onclick="deleteBadge({{ $badge->id }}, '{{ $badge->name }}')" class="inline-flex justify-center items-center px-3 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- No Results Message -->
                    <div id="noResults" class="hidden text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No badges found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or search term.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Add Badge Modal -->
<div id="addBadgeModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Add New Badge</h3>
            <button onclick="closeAddBadgeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="addBadgeForm" enctype="multipart/form-data" class="mt-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Badge Name -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Badge Name *</label>
                    <input type="text" name="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Category -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select name="category" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                    <textarea name="description" required rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <!-- Rarity Level -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rarity Level *</label>
                    <select name="rarity_level" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1">1 - Common</option>
                        <option value="2">2 - Uncommon</option>
                        <option value="3">3 - Rare</option>
                        <option value="4">4 - Epic</option>
                        <option value="5">5 - Legendary</option>
                        <option value="6">6 - Mythic</option>
                    </select>
                </div>

                <!-- Icon Upload -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Badge Icon</label>
                    <input type="file" name="icon_path" id="badge_icon_add" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="validateBadgeIconSize(this, 'add')">
                    <p class="mt-1 text-xs text-gray-500">PNG, JPG, SVG, WEBP (max 2MB)</p>
                    <p id="badge-icon-add-error" class="mt-1 text-xs text-red-600 hidden"></p>
                </div>

                <!-- Criteria Type -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Criteria Type *</label>
                    <select name="criteria_type" id="addCriteriaType" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="hardcoded">Hardcoded (Legacy)</option>
                        <option value="dynamic" selected>Dynamic (Configurable)</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Dynamic criteria allows you to set custom unlock conditions</p>
                </div>

                <!-- Unlock Criteria Description -->
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unlock Criteria Description *</label>
                    <input type="text" name="unlock_criteria" required placeholder="E.g., Complete 10 trainings with 90% attendance" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-gray-500">User-friendly description of how to unlock this badge</p>
                </div>

                <!-- Dynamic Criteria Section -->
                <div id="addDynamicCriteriaSection" class="col-span-2">
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-sm font-semibold text-gray-900">Dynamic Unlock Conditions</h4>
                            <button type="button" onclick="addCriteriaRow('add')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Condition
                            </button>
                        </div>
                        <div id="addCriteriaContainer" class="space-y-3">
                            <!-- Dynamic criteria rows will be added here -->
                        </div>
                    </div>
                </div>

                <!-- Active Status -->
                <div class="col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" checked class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active (Badge can be unlocked)</span>
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                <button type="button" onclick="closeAddBadgeModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Badge
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Badge Modal (Similar structure to Add Modal) -->
<div id="editBadgeModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Edit Badge</h3>
            <button onclick="closeEditBadgeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="editBadgeForm" enctype="multipart/form-data" class="mt-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="badge_id" id="editBadgeId">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Same fields as Add Modal with id prefixes -->
                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Badge Name *</label>
                    <input type="text" name="name" id="editName" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                    <select name="category" id="editCategory" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                    <textarea name="description" id="editDescription" required rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rarity Level *</label>
                    <select name="rarity_level" id="editRarityLevel" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1">1 - Common</option>
                        <option value="2">2 - Uncommon</option>
                        <option value="3">3 - Rare</option>
                        <option value="4">4 - Epic</option>
                        <option value="5">5 - Legendary</option>
                        <option value="6">6 - Mythic</option>
                    </select>
                </div>

                <div class="col-span-2 md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Badge Icon</label>
                    <input type="file" name="icon_path" id="badge_icon_edit" accept="image/*" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" onchange="validateBadgeIconSize(this, 'edit')">
                    <div id="currentIconPreview" class="mt-2"></div>
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current icon (max 2MB)</p>
                    <p id="badge-icon-edit-error" class="mt-1 text-xs text-red-600 hidden"></p>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Criteria Type *</label>
                    <select name="criteria_type" id="editCriteriaType" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="hardcoded">Hardcoded (Legacy)</option>
                        <option value="dynamic">Dynamic (Configurable)</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Unlock Criteria Description *</label>
                    <input type="text" name="unlock_criteria" id="editUnlockCriteria" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div id="editDynamicCriteriaSection" class="col-span-2">
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-sm font-semibold text-gray-900">Dynamic Unlock Conditions</h4>
                            <button type="button" onclick="addCriteriaRow('edit')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Condition
                            </button>
                        </div>
                        <div id="editCriteriaContainer" class="space-y-3"></div>
                    </div>
                </div>

                <div class="col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_active" id="editIsActive" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active (Badge can be unlocked)</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                <button type="button" onclick="closeEditBadgeModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Badge
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View Badge Modal -->
<div id="viewBadgeModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-lg font-semibold text-gray-900">Badge Details</h3>
            <button onclick="closeViewBadgeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="viewBadgeContent" class="mt-4"></div>
        <div class="flex justify-end mt-6 pt-4 border-t">
            <button onclick="closeViewBadgeModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Close
            </button>
        </div>
    </div>
</div>

<script>
const metrics = @json($metrics);
const operators = @json($operators);
const ranks = @json($ranks);

let criteriaCounter = 0;

// Modal Functions
function openAddBadgeModal() {
    document.getElementById('addBadgeModal').classList.remove('hidden');
    document.getElementById('addBadgeForm').reset();
    document.getElementById('addCriteriaContainer').innerHTML = '';
    addCriteriaRow('add');
}

function closeAddBadgeModal() {
    document.getElementById('addBadgeModal').classList.add('hidden');
}

function closeEditBadgeModal() {
    document.getElementById('editBadgeModal').classList.add('hidden');
}

function closeViewBadgeModal() {
    document.getElementById('viewBadgeModal').classList.add('hidden');
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Criteria type toggle
    document.getElementById('addCriteriaType').addEventListener('change', function() {
        toggleCriteriaSection('add', this.value);
    });

    document.getElementById('editCriteriaType').addEventListener('change', function() {
        toggleCriteriaSection('edit', this.value);
    });

    // Initialize with one criteria row
    addCriteriaRow('add');

    // Filter functionality
    document.getElementById('categoryFilter').addEventListener('change', filterBadges);
    document.getElementById('typeFilter').addEventListener('change', filterBadges);
    document.getElementById('searchFilter').addEventListener('input', filterBadges);
});

function toggleCriteriaSection(formType, criteriaType) {
    const section = document.getElementById(formType + 'DynamicCriteriaSection');
    if (criteriaType === 'dynamic') {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
    }
}

function addCriteriaRow(formType) {
    const container = document.getElementById(formType + 'CriteriaContainer');
    const rowId = criteriaCounter++;

    const row = document.createElement('div');
    row.className = 'criteria-row bg-gray-50 p-4 rounded-lg border border-gray-200';
    row.id = formType + 'CriteriaRow' + rowId;
    row.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-4">
                <label class="block text-xs font-medium text-gray-700 mb-1">Metric</label>
                <select class="criteria-metric w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" onchange="updateValueField('${formType}', ${rowId})">
                    <option value="">Select Metric</option>
                    ${Object.entries(metrics).map(([key, label]) => `<option value="${key}">${label}</option>`).join('')}
                </select>
            </div>
            <div class="md:col-span-3">
                <label class="block text-xs font-medium text-gray-700 mb-1">Operator</label>
                <select class="criteria-operator w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    ${Object.entries(operators).map(([key, label]) => `<option value="${key}">${label}</option>`).join('')}
                </select>
            </div>
            <div class="md:col-span-4">
                <label class="block text-xs font-medium text-gray-700 mb-1">Value</label>
                <input type="text" class="criteria-value w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Enter value">
            </div>
            <div class="md:col-span-1 flex items-end">
                <button type="button" onclick="removeCriteriaRow('${formType}', ${rowId})" class="w-full px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;

    container.appendChild(row);
}

function removeCriteriaRow(formType, rowId) {
    const row = document.getElementById(formType + 'CriteriaRow' + rowId);
    if (row) {
        row.remove();
    }
}

function updateValueField(formType, rowId) {
    const row = document.getElementById(formType + 'CriteriaRow' + rowId);
    const metric = row.querySelector('.criteria-metric').value;
    const valueField = row.querySelector('.criteria-value');

    if (metric === 'rank') {
        valueField.outerHTML = `
            <select class="criteria-value w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                ${ranks.map(rank => `<option value="${rank}">${rank}</option>`).join('')}
            </select>
        `;
    } else if (metric === 'swimming_qualification') {
        valueField.outerHTML = `
            <select class="criteria-value w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <option value="Pass">Pass</option>
                <option value="Fail">Fail</option>
            </select>
        `;
    } else if (metric === 'is_best_cadet' || metric === 'is_best_academic') {
        valueField.outerHTML = `
            <select class="criteria-value w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        `;
    } else {
        if (valueField.tagName !== 'INPUT') {
            valueField.outerHTML = `<input type="number" class="criteria-value w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" step="0.01" placeholder="Enter value">`;
        }
    }
}

function collectCriteriaConfig(formType) {
    const container = document.getElementById(formType + 'CriteriaContainer');
    const rows = container.querySelectorAll('.criteria-row');
    const criteria = [];

    rows.forEach(row => {
        const metric = row.querySelector('.criteria-metric').value;
        const operator = row.querySelector('.criteria-operator').value;
        const value = row.querySelector('.criteria-value').value;

        if (metric && operator && value) {
            criteria.push({ metric, operator, value });
        }
    });

    return criteria;
}

// Form Submissions
document.getElementById('addBadgeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    if (formData.get('criteria_type') === 'dynamic') {
        const criteria = collectCriteriaConfig('add');
        formData.set('criteria_config', JSON.stringify(criteria));
    }

    fetch('{{ route('admin.badges.store') }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Badge created successfully!');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating badge');
    });
});

document.getElementById('editBadgeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const badgeId = document.getElementById('editBadgeId').value;
    const formData = new FormData(this);

    if (formData.get('criteria_type') === 'dynamic') {
        const criteria = collectCriteriaConfig('edit');
        formData.set('criteria_config', JSON.stringify(criteria));
    }

    fetch(`/admin/badges/${badgeId}`, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-HTTP-Method-Override': 'PUT'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Badge updated successfully!');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating badge');
    });
});

function viewBadge(id) {
    fetch(`/admin/badges/${id}`)
        .then(response => response.json())
        .then(badge => {
            let html = `
                <div class="flex items-start mb-4">
                    <div class="mr-4">
                        ${badge.icon_url ? `<img src="${badge.icon_url}" class="w-24 h-24 rounded-lg shadow-md" alt="${badge.name}">` :
                        `<div class="w-24 h-24 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-md">
                            <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>`}
                    </div>
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-gray-900 mb-2">${badge.name}</h4>
                        <p class="text-gray-600 mb-3">${badge.description}</p>
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: ${badge.rarity_color}20; color: ${badge.rarity_color}">
                                ${badge.rarity_label}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ${badge.category_name}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badge.criteria_type == 'dynamic' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                ${badge.criteria_type}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${badge.is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                                ${badge.is_active ? 'Active' : 'Inactive'}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Unlocks</p>
                            <p class="text-lg font-semibold text-gray-900">${badge.cadet_badges_count || 0}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Criteria Type</p>
                            <p class="text-lg font-semibold text-gray-900">${badge.criteria_type}</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm font-medium text-gray-500 mb-1">Unlock Criteria</p>
                        <p class="text-sm text-gray-700">${badge.unlock_criteria}</p>
                    </div>
                    ${badge.criteria_type === 'dynamic' && badge.criteria_config ? `
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-2">Dynamic Conditions</p>
                            <ul class="space-y-2">
                                ${badge.criteria_config.map(c => `
                                    <li class="flex items-center text-sm bg-gray-50 p-2 rounded">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <strong>${metrics[c.metric]}</strong>&nbsp;${operators[c.operator]}&nbsp;<strong>${c.value}</strong>
                                    </li>
                                `).join('')}
                            </ul>
                        </div>
                    ` : ''}
                </div>
            `;

            document.getElementById('viewBadgeContent').innerHTML = html;
            document.getElementById('viewBadgeModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading badge details');
        });
}

function editBadge(id) {
    fetch(`/admin/badges/${id}`)
        .then(response => response.json())
        .then(badge => {
            document.getElementById('editBadgeId').value = badge.id;
            document.getElementById('editName').value = badge.name;
            document.getElementById('editCategory').value = badge.category;
            document.getElementById('editDescription').value = badge.description;
            document.getElementById('editRarityLevel').value = badge.rarity_level;
            document.getElementById('editCriteriaType').value = badge.criteria_type;
            document.getElementById('editUnlockCriteria').value = badge.unlock_criteria;
            document.getElementById('editIsActive').checked = badge.is_active;

            if (badge.icon_url) {
                document.getElementById('currentIconPreview').innerHTML = `
                    <img src="${badge.icon_url}" class="w-20 h-20 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500 mt-1">Current icon</p>
                `;
            }

            toggleCriteriaSection('edit', badge.criteria_type);

            const container = document.getElementById('editCriteriaContainer');
            container.innerHTML = '';

            if (badge.criteria_type === 'dynamic' && badge.criteria_config) {
                badge.criteria_config.forEach(criterion => {
                    addCriteriaRow('edit');
                    const rows = container.querySelectorAll('.criteria-row');
                    const lastRow = rows[rows.length - 1];

                    lastRow.querySelector('.criteria-metric').value = criterion.metric;
                    lastRow.querySelector('.criteria-operator').value = criterion.operator;

                    const rowId = lastRow.id.replace('editCriteriaRow', '');
                    updateValueField('edit', rowId);

                    setTimeout(() => {
                        lastRow.querySelector('.criteria-value').value = criterion.value;
                    }, 100);
                });
            } else {
                addCriteriaRow('edit');
            }

            document.getElementById('editBadgeModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading badge details');
        });
}

function deleteBadge(id, name) {
    if (!confirm(`Are you sure you want to delete the badge "${name}"? This action cannot be undone.`)) {
        return;
    }

    fetch(`/admin/badges/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Badge deleted successfully!');
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting badge');
    });
}

function filterBadges() {
    const categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
    const typeFilter = document.getElementById('typeFilter').value.toLowerCase();
    const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
    const cards = document.querySelectorAll('.badge-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const category = card.dataset.category.toLowerCase();
        const type = card.dataset.type.toLowerCase();
        const name = card.dataset.name;
        const description = card.dataset.description;

        let showCard = true;

        if (categoryFilter && category !== categoryFilter) showCard = false;
        if (typeFilter && type !== typeFilter) showCard = false;
        if (searchFilter && !name.includes(searchFilter) && !description.includes(searchFilter)) showCard = false;

        card.style.display = showCard ? '' : 'none';
        if (showCard) visibleCount++;
    });

    document.getElementById('noResults').classList.toggle('hidden', visibleCount > 0);
}

// File Size Validation for Badge Icons
function validateBadgeIconSize(input, mode) {
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
    const errorElementId = 'badge-icon-' + mode + '-error';
    const errorElement = document.getElementById(errorElementId);
    const submitButton = input.closest('form').querySelector('button[type="submit"]');

    if (input.files && input.files[0]) {
        const fileSize = input.files[0].size;
        const fileName = input.files[0].name;

        if (fileSize > maxSize) {
            const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);
            errorElement.textContent = `File size (${fileSizeMB}MB) exceeds the maximum limit of 2MB. Please choose a smaller image.`;
            errorElement.classList.remove('hidden');
            input.value = ''; // Clear the file input

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }

            return false;
        } else {
            errorElement.classList.add('hidden');
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            return true;
        }
    }
    return true;
}
</script>

</x-app-layout>
