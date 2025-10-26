<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gallery') }}
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

    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .category-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .category-card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }

    .category-card.selected {
        border: 2px solid #3b82f6;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }

    .photo-card {
        transition: all 0.2s ease;
        border: 1px solid #e5e7eb;
    }

    .photo-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: #cbd5e1;
    }

    /* ========================================= */
    /* GRADIENT BACKGROUNDS */
    /* ========================================= */
    .gradient-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
    }

    .gradient-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .gradient-cyan {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
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

    .icon-wrapper-sm {
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* ========================================= */
    /* BUTTON STYLES */
    /* ========================================= */
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
        transform: translateY(-1px);
    }

    .filter-btn {
        padding: 0.625rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid #e5e7eb;
        background: white;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }

    .filter-btn:not(.active):hover {
        background: #f8fafc;
        border-color: #cbd5e1;
    }

    /* ========================================= */
    /* INFO CARD STYLES */
    /* ========================================= */
    .info-card {
        background: #ffffff;
        border-radius: 0.75rem;
        padding: 1.25rem;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .info-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    /* ========================================= */
    /* MODAL STYLES */
    /* ========================================= */
    .modal-overlay {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    /* Fixed: Modal close button - removed rotation on hover */
    .modal-close-btn {
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .modal-close-btn:hover {
        color: #4b5563;
        transform: scale(1.1);
    }

    /* ========================================= */
    /* UTILITY CLASSES */
    /* ========================================= */
    .text-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .shadow-custom {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* ========================================= */
    /* ADDITIONAL ANIMATIONS */
    /* ========================================= */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    .photo-card {
        position: relative;
        overflow: hidden;
    }

    .photo-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s;
        z-index: 1;
    }

    .photo-card:hover::before {
        left: 100%;
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        z-index: 2;
    }

    .photo-card:hover .image-overlay {
        opacity: 1;
    }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ========================================= */
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 640px) {
        /* Disable hover effects on mobile */
        .category-card:hover,
        .photo-card:hover,
        .dashboard-card:hover {
            transform: none !important;
        }

        /* Header adjustments */
        .section-header {
            padding: 1rem;
        }

        /* Statistics card */
        .mb-6.p-4 {
            padding: 0.75rem !important;
        }

        /* Photo cards in grid */
        .photo-card {
            margin-bottom: 0;
        }

        .photo-card .p-5 {
            padding: 0.75rem !important;
        }

        /* Action buttons in photo cards */
        .photo-card button {
            font-size: 0.75rem !important;
            padding: 0.5rem 0.625rem !important;
        }

        .photo-card button svg {
            width: 0.875rem !important;
            height: 0.875rem !important;
            margin-right: 0.25rem !important;
        }
    }
    </style>

    <div class="py-4 sm:py-8 pb-8 sm:pb-12 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">

            {{-- ================================================================ --}}
            {{-- HEADER SECTION --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-4 sm:mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 gradient-header rounded-2xl shadow-lg mb-3 sm:mb-4">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 mb-1 sm:mb-2 px-2">Gallery</h1>
                <p class="text-gray-600 text-sm sm:text-lg px-2">Browse and manage photos from training sessions</p>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            {{-- ================================================================ --}}
            {{-- MAIN CONTENT CARD --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">

                {{-- Card Header --}}
                <div class="section-header">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                        <div class="flex-1 w-full sm:w-auto">
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper bg-purple-100 mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <h2 class="text-xl sm:text-2xl font-semibold flex items-center text-gray-900">
                                    Photo Collection
                                </h2>
                            </div>
                            <p class="text-gray-600 text-sm sm:text-base">View and manage training photos organized by category</p>
                        </div>
                        <div class="flex items-center w-full sm:w-auto">
                            <a href="{{ route('alumni') }}" class="w-full sm:w-auto text-center px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 bg-blue-600 text-white hover:bg-blue-700">
                                <span class="hidden sm:inline">Legacy Gallery</span>
                                <span class="sm:hidden">Legacy</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-3 sm:p-6">
                    {{-- ================================================================ --}}
                    {{-- CATEGORY FILTER BUTTONS --}}
                    {{-- ================================================================ --}}
                    <div class="mb-4 sm:mb-6">
                        <div class="flex flex-wrap gap-2 sm:gap-3 mb-3 sm:mb-4">
                            <button onclick="filterByCategory('all')"
                                   class="filter-btn active px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center gap-1 sm:gap-2"
                                   data-category="all">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                All
                            </button>

                            @foreach($categories as $category)
                                <button onclick="filterByCategory('{{ $category->id }}')"
                                       class="filter-btn px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 flex items-center gap-1 sm:gap-2"
                                       data-category="{{ $category->id }}">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <button onclick="openGalleryModal()" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-3 sm:px-4 py-2 rounded-md text-xs sm:text-sm font-medium transition duration-200 flex items-center justify-center gap-1 sm:gap-2">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Picture
                            </button>
                            <button onclick="openCategoryModal()" class="w-full sm:w-auto px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 bg-green-100 text-green-700 hover:bg-green-200 flex items-center justify-center gap-1 sm:gap-2">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Category
                            </button>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- GALLERY STATISTICS --}}
                    {{-- ================================================================ --}}
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 rounded-lg" style="background-color: #e8f4fd; border: 1px solid #3c92d9;">
                        <div class="flex flex-wrap gap-2 sm:gap-4 text-xs sm:text-sm" style="color: #2c5f8a;">
                            <span><strong>Total Pictures:</strong> <span id="totalPictures">{{ $galleries->count() }}</span></span>
                            <span><strong>Categories:</strong> <span id="totalCategories">{{ $categories->count() }}</span></span>
                            <span><strong>Viewing:</strong> <span id="currentViewText">All Categories</span></span>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- ALPINE.JS COMPONENT FOR MODALS --}}
                    {{-- ================================================================ --}}
                    <div x-data="galleryManagement()">
                        {{-- ================================================================ --}}
                        {{-- CATEGORY OVERVIEW (DEFAULT VIEW) --}}
                        {{-- ================================================================ --}}
                        <div id="categoryOverview" class="space-y-6">
                            @php
                                $galleriesByCategory = $galleries->groupBy('gallery_category_id');
                                $categoryColors = [
                                    'background: linear-gradient(135deg, #3c92d9, #2c7ec9);',
                                    'background: linear-gradient(135deg, #06b6d4, #3c92d9);',
                                    'background: linear-gradient(135deg, #10b981, #059669);',
                                    'background: linear-gradient(135deg, #8b5cf6, #ec4899);',
                                    'background: linear-gradient(135deg, #f97316, #ef4444);',
                                    'background: linear-gradient(135deg, #6366f1, #8b5cf6);',
                                    'background: linear-gradient(135deg, #ec4899, #f43f5e);',
                                    'background: linear-gradient(135deg, #14b8a6, #06b6d4);',
                                    'background: linear-gradient(135deg, #ef4444, #ec4899);',
                                    'background: linear-gradient(135deg, #eab308, #f97316);'
                                ];
                            @endphp
                            
                            @if($categories->count() > 0)
                                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                                    @foreach($categories as $index => $category)
                                        @php
                                            $categoryGalleries = $galleriesByCategory->get($category->id, collect());
                                            $color = $categoryColors[$index % count($categoryColors)];
                                            $photoCount = $categoryGalleries->count();
                                        @endphp
                                        
                                        <div class="category-card text-white rounded-xl p-4 sm:p-6 shadow-lg cursor-pointer transform hover:scale-105 transition-all duration-300 hover:shadow-xl" 
                                             style="{{ $color }}"
                                             onclick="filterByCategory('{{ $category->id }}')">
                                            <div class="flex items-center justify-between mb-3 sm:mb-4">
                                                <h3 class="text-base sm:text-xl font-bold">{{ $category->name }}</h3>
                                                <svg class="w-6 h-6 sm:w-8 sm:h-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <p class="opacity-75 mb-2 sm:mb-3 text-xs sm:text-sm">
                                                Training photos and activities
                                            </p>
                                            <div class="flex justify-between items-center">
                                                <span class="bg-white bg-opacity-20 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs sm:text-sm font-medium">
                                                    {{ $photoCount }} {{ Str::plural('Photo', $photoCount) }}
                                                </span>
                                                <span class="text-xs sm:text-sm opacity-75">Click to manage →</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    <p class="mt-2 text-gray-500">No categories available.</p>
                                    <p class="text-sm text-gray-400 mt-1">Create your first category to organize your photos!</p>
                                </div>
                            @endif
                        </div>

                        {{-- ================================================================ --}}
                        {{-- PHOTO GALLERY GRID (HIDDEN BY DEFAULT) --}}
                        {{-- ================================================================ --}}
                        <div id="photosView" class="hidden">
                            <div class="mb-4 sm:mb-6">
                                <button onclick="showCategoryOverview()" class="flex items-center px-3 sm:px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 text-xs sm:text-sm">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    <span class="hidden sm:inline">Back to Categories</span>
                                    <span class="sm:hidden">Back</span>
                                </button>
                            </div>

                            <div id="currentCategoryHeader" class="mb-4 sm:mb-6"></div>

                            <div id="galleryGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6"></div>

                            <div id="noResults" class="text-center py-12 hidden">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-2 text-gray-500">No gallery items found in this category.</p>
                                <p class="text-sm text-gray-400 mt-1">Add your first picture to get started!</p>
                            </div>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- EDIT GALLERY MODAL --}}
                        {{-- ================================================================ --}}
                        <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 p-4">
                            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-xl w-full max-w-xl relative max-h-[90vh] overflow-y-auto">
                                <button type="button" @click="showModal = false" class="modal-close-btn absolute top-3 right-3 sm:top-4 sm:right-4 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                                <h2 class="text-base sm:text-lg font-semibold mb-4">Edit Gallery Item</h2>
                                <form method="POST" :action="updateUrl" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="mb-4">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Title</label>
                                        <input type="text" name="title" x-model="gallery.title" required
                                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Description</label>
                                        <textarea name="description" x-model="gallery.description" rows="3"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Category</label>
                                        <select name="gallery_category_id" x-model="gallery.gallery_category_id" required
                                                class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Replace Image (optional)</label>
                                        <input type="file" name="image" accept=".jpg,.jpeg,.png,.gif,.webp"
                                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Supported formats: JPG, JPEG, PNG, GIF, WEBP (Max: 10MB)</p>
                                    </div>

                                    <div class="flex justify-end gap-2 sm:gap-3">
                                        <button type="button" @click="showModal = false" class="px-3 sm:px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition duration-200 text-xs sm:text-sm">Cancel</button>
                                        <button type="submit" class="px-3 sm:px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition duration-200 text-xs sm:text-sm">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- DELETE GALLERY CONFIRMATION MODAL --}}
                        {{-- ================================================================ --}}
                        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 p-4">
                            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-xl w-full max-w-md">
                                <h2 class="text-base sm:text-lg font-semibold mb-4">Confirm Deletion</h2>
                                <p class="mb-6 text-gray-700 text-sm sm:text-base">Are you sure you want to delete <strong x-text="deleteGallery.title"></strong>?</p>

                                <form :action="deleteUrl" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="flex justify-end gap-2 sm:gap-3">
                                        <button type="button" @click="showDeleteModal = false"
                                                class="px-3 sm:px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-200 text-xs sm:text-sm">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="px-3 sm:px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-200 text-xs sm:text-sm">
                                            Confirm Delete
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- IMAGE PREVIEW MODAL - ENHANCED LIGHTBOX --}}
    {{-- ================================================================ --}}
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden flex items-center justify-center transition-all duration-300 backdrop-blur-sm overflow-y-auto" style="animation: fadeIn 0.3s ease-in-out;">
        <div class="relative max-w-5xl w-full p-2 sm:p-4 my-4 sm:my-8">
            {{-- Modal Action Buttons Container --}}
            <div class="fixed top-3 right-3 sm:top-6 sm:right-6 z-20 flex gap-2">
                {{-- Download Button --}}
                <a id="downloadButton" href="#" download class="modal-close-btn text-white hover:text-gray-300 bg-black bg-opacity-60 hover:bg-opacity-80 rounded-full p-2 sm:p-3 transition-all duration-200">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </a>

                {{-- Close Button --}}
                <button onclick="closeImageModal()" class="modal-close-btn text-white hover:text-gray-300 bg-black bg-opacity-60 hover:bg-opacity-80 rounded-full p-2 sm:p-3 transition-all duration-200">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="flex flex-col items-center">
                {{-- Image Container with Loading State --}}
                <div class="relative w-full flex items-center justify-center mb-2 sm:mb-4">
                    <div id="imageLoader" class="absolute inset-0 flex items-center justify-center">
                        <div class="animate-spin rounded-full h-8 w-8 sm:h-12 sm:w-12 border-t-2 border-b-2 border-white"></div>
                    </div>
                    <img id="previewImage" src="" alt="" class="max-w-full max-h-[50vh] sm:max-h-[60vh] object-contain rounded-lg sm:rounded-xl shadow-2xl" onload="document.getElementById('imageLoader').style.display='none'" onerror="document.getElementById('imageLoader').style.display='none'">
                </div>

                {{-- Info Card --}}
                <div class="bg-white rounded-lg sm:rounded-xl p-3 sm:p-6 mt-2 sm:mt-4 max-w-2xl w-full shadow-2xl">
                    <div class="flex items-start justify-between mb-2 sm:mb-3 gap-2">
                        <h3 id="previewTitle" class="text-base sm:text-xl font-bold text-gray-900 flex-1 min-w-0 truncate"></h3>
                        <span class="flex-shrink-0 px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs font-semibold shadow-sm whitespace-nowrap" style="background: linear-gradient(135deg, #3c92d9, #2c7ec9); color: white;" id="previewCategory"></span>
                    </div>

                    <p id="previewDescription" class="text-xs sm:text-sm text-gray-600 mb-2 sm:mb-4 leading-relaxed"></p>

                    <div class="border-t border-gray-200 pt-2 sm:pt-4 space-y-1 sm:space-y-2">
                        <div class="flex items-center text-xs sm:text-sm text-gray-700">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <strong class="mr-1 sm:mr-2 flex-shrink-0">Instructor:</strong> <span id="previewInstructor" class="text-gray-600 truncate"></span>
                        </div>
                        <div class="flex items-center text-xs sm:text-sm text-gray-700">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <strong class="mr-1 sm:mr-2 flex-shrink-0">Upload Date:</strong> <span id="previewDate" class="text-gray-600"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- ADD PICTURE MODAL - ENHANCED --}}
    {{-- ================================================================ --}}
    <div id="galleryModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full hidden z-50 backdrop-blur-sm transition-all duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all duration-300" style="animation: slideIn 0.3s ease-out;">
                <div class="p-4 sm:p-8">
                    <div class="flex justify-between items-center mb-4 sm:mb-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-2 sm:mr-3 shadow-lg">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Add Gallery Item</h3>
                        </div>
                        <button onclick="closeGalleryModal()" class="modal-close-btn text-gray-400 hover:text-gray-600 transition-all duration-200">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('instructor.gallery.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-5">
                        @csrf
                        <div>
                            <label for="gallery_title" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Title
                            </label>
                            <input type="text" id="gallery_title" name="title" required
                                   class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   placeholder="Enter picture title">
                        </div>

                        <div>
                            <label for="gallery_description" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                Description
                            </label>
                            <textarea id="gallery_description" name="description" rows="3"
                                      class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Enter picture description (optional)"></textarea>
                        </div>

                        <div>
                            <label for="gallery_category" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Category
                            </label>
                            <select id="gallery_category" name="gallery_category_id" required
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="gallery_image" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Image
                            </label>
                            <div class="relative">
                                <input type="file" id="gallery_image" name="image" required accept=".jpg,.jpeg,.png,.gif,.webp"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                       onchange="previewGalleryImage(event)">
                            </div>
                            <p class="text-xs text-gray-500 mt-2 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Supported formats: JPG, JPEG, PNG, GIF, WEBP (Max: 10MB)
                            </p>
                            <div id="imagePreviewContainer" class="hidden mt-3">
                                <img id="imagePreview" src="" alt="Preview" class="w-full h-32 sm:h-48 object-cover rounded-lg border-2 border-gray-200">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-gray-200">
                            <button type="button" onclick="closeGalleryModal()"
                                    class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 font-medium text-xs sm:text-sm">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-200 font-medium shadow-lg flex items-center text-xs sm:text-sm">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Picture
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CATEGORY MANAGEMENT MODAL --}}
    {{-- ================================================================ --}}
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900">Category Management</h3>
                        <button onclick="closeCategoryModal()" class="modal-close-btn text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex mb-4 sm:mb-6 bg-gray-100 p-1 rounded-lg">
                        <button id="addCategoryBtn" onclick="showAddCategoryForm()" 
                                class="flex-1 py-2 px-3 sm:px-4 text-xs sm:text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white">
                            Add Category
                        </button>
                        <button id="manageCategoriesBtn" onclick="showCategoriesList()" 
                                class="flex-1 py-2 px-3 sm:px-4 text-xs sm:text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700">
                            Manage Categories
                        </button>
                    </div>

                    <div id="addCategorySection">
                        <form action="{{ route('instructor.gallery_categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="category_name" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                <input type="text" id="category_name" name="name" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-green-500"
                                       placeholder="Enter category name">
                            </div>
                            
                            <div class="flex justify-end gap-2 sm:gap-3">
                                <button type="button" onclick="closeCategoryModal()" 
                                        class="px-3 sm:px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200 text-xs sm:text-sm">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-3 sm:px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200 text-xs sm:text-sm">
                                    Add Category
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="categoriesListSection" class="hidden">
                        <div class="max-h-96 overflow-y-auto">
                            @if($categories->isEmpty())
                                <div class="text-center py-8 text-gray-500">
                                    <p class="text-sm sm:text-base">No categories available.</p>
                                    <p class="text-xs sm:text-sm">Click "Add Category" to create your first category.</p>
                                </div>
                            @else
                                <div class="space-y-2">
                                    @foreach($categories as $category)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors duration-200">
                                            <div class="flex-1 min-w-0 pr-2">
                                                <h4 class="font-medium text-gray-900 text-sm sm:text-base truncate">{{ $category->name }}</h4>
                                                <p class="text-xs sm:text-sm text-gray-500">
                                                    {{ $category->galleries->count() ?? 0 }} picture(s) in this category
                                                </p>
                                            </div>
                                            <button onclick="confirmDeleteCategory({{ $category->id }}, '{{ $category->name }}', {{ $category->galleries->count() ?? 0 }})"
                                                    class="px-2 sm:px-3 py-1 bg-red-600 text-white text-xs sm:text-sm rounded hover:bg-red-700 transition duration-200 flex-shrink-0">
                                                Delete
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- DELETE CATEGORY CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="deleteCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-4 sm:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base sm:text-lg font-medium text-gray-900">Confirm Category Deletion</h3>
                        <button onclick="closeDeleteCategoryModal()" class="modal-close-btn text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-gray-700 mb-2 text-sm sm:text-base">Are you sure you want to delete the category:</p>
                        <p class="font-semibold text-gray-900 text-sm sm:text-base" id="categoryToDeleteName"></p>
                        <p class="text-xs sm:text-sm text-red-600 mt-2" id="categoryWarningMessage"></p>
                    </div>
                    
                    <form id="deleteCategoryForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end gap-2 sm:gap-3">
                            <button type="button" onclick="closeDeleteCategoryModal()" 
                                    class="px-3 sm:px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200 text-xs sm:text-sm">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-3 sm:px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200 text-xs sm:text-sm">
                                Delete Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        const galleryData = @json($galleries->groupBy('gallery_category_id'));
        const categoriesData = @json($categories);
        const allGalleries = @json($galleries);
        let currentFilter = 'all';

        {{-- ================================================================ --}}
        {{-- ALPINE.JS COMPONENT --}}
        {{-- ================================================================ --}}
        function galleryManagement() {
            return {
                showModal: false,
                showDeleteModal: false,
                gallery: {},
                deleteGallery: {},
                routeTemplate: '{{ route('instructor.gallery.update', ['gallery' => '__id__']) }}',
                deleteRouteTemplate: '{{ route('instructor.gallery.destroy', ['gallery' => '__id__']) }}',

                init() {
                    window.addEventListener('open-edit-gallery', (e) => {
                        this.gallery = e.detail;
                        this.showModal = true;
                    });
                    
                    window.addEventListener('open-delete-gallery', (e) => {
                        this.deleteGallery = e.detail;
                        this.showDeleteModal = true;
                    });
                },
                
                get updateUrl() {
                    return this.routeTemplate.replace('__id__', this.gallery.id);
                },
                
                get deleteUrl() {
                    return this.deleteRouteTemplate.replace('__id__', this.deleteGallery.id);
                }
            }
        }

        {{-- ================================================================ --}}
        {{-- CATEGORY FILTERING --}}
        {{-- ================================================================ --}}
        function filterByCategory(category) {
            currentFilter = category;
            updateFilterButtons(category);
            
            if (category === 'all') {
                showCategoryOverview();
            } else {
                showPhotosForCategory(category);
            }
            
            updateStats();
        }

        function updateFilterButtons(activeCategory) {
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                const category = btn.dataset.category;
                if (category === activeCategory) {
                    btn.classList.add('active');
                    btn.classList.remove('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                } else {
                    btn.classList.remove('active');
                    btn.classList.add('bg-gray-100', 'text-gray-700', 'hover:bg-gray-200');
                }
            });
        }

        {{-- ================================================================ --}}
        {{-- VIEW MANAGEMENT --}}
        {{-- ================================================================ --}}
        function showCategoryOverview() {
            const overview = document.getElementById('categoryOverview');
            const photosView = document.getElementById('photosView');
            
            overview.classList.remove('hidden');
            photosView.classList.add('hidden');
            
            currentFilter = 'all';
            updateFilterButtons('all');
            updateStats();
        }

        function showPhotosForCategory(categoryId) {
            const overview = document.getElementById('categoryOverview');
            const photosView = document.getElementById('photosView');
            const galleryGrid = document.getElementById('galleryGrid');
            const noResults = document.getElementById('noResults');
            
            const photos = galleryData[categoryId] || [];
            
            overview.classList.add('hidden');
            photosView.classList.remove('hidden');
            
            if (photos.length === 0) {
                galleryGrid.classList.add('hidden');
                noResults.classList.remove('hidden');
                return;
            }
            
            galleryGrid.classList.remove('hidden');
            noResults.classList.add('hidden');
            
            updateCategoryHeader(categoryId);
            populatePhotosGrid(photos);
        }

        function updateCategoryHeader(categoryId) {
            const header = document.getElementById('currentCategoryHeader');
            const category = categoriesData.find(cat => cat.id == categoryId);
            
            if (!category) return;
            
            const photoCount = galleryData[categoryId]?.length || 0;
            
            header.innerHTML = `
                <div class="text-white px-4 sm:px-8 py-3 sm:py-4 rounded-xl shadow-lg" style="background: linear-gradient(135deg, #3c92d9, #2c7ec9);">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold tracking-wide">${category.name}</h2>
                            <p class="text-blue-100 text-xs sm:text-sm mt-1" style="color: rgba(255,255,255,0.8);">Manage photos in this category</p>
                        </div>
                        <span class="bg-white bg-opacity-20 text-white px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs sm:text-sm font-medium">
                            ${photoCount} ${photoCount === 1 ? 'Photo' : 'Photos'}
                        </span>
                    </div>
                </div>
            `;
        }

        {{-- ================================================================ --}}
        {{-- GALLERY GRID POPULATION --}}
        {{-- ================================================================ --}}
        function populatePhotosGrid(photos) {
            const grid = document.getElementById('galleryGrid');

            grid.innerHTML = photos.map(photo => {
                const titleEscaped = (photo.title || 'Untitled').replace(/'/g, "\\'").replace(/"/g, '&quot;');
                const descEscaped = photo.description ? photo.description.replace(/'/g, "\\'").replace(/"/g, '&quot;') : '';

                return `
                <div class="photo-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48 sm:h-56 bg-gradient-to-br from-gray-100 to-gray-200 group cursor-pointer"
                         onclick="openImageModal('{{ asset('') }}${photo.image_path}', '${titleEscaped}', '${descEscaped}', '${photo.instructor?.name || 'Unknown'}', '${photo.category?.name || 'N/A'}', '${formatDate(photo.created_at)}')">
                        ${photo.image_path ?
                            `<img src="{{ asset('') }}${photo.image_path}"
                                 alt="${titleEscaped}"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy">
                             <div class="image-overlay">
                                <svg class="w-8 h-8 sm:w-12 sm:h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                             </div>` :
                            `<div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>`
                        }
                    </div>

                    <div class="p-3 sm:p-5">
                        <div class="flex items-start justify-between mb-2 sm:mb-3 gap-1 sm:gap-2">
                            <h3 class="font-bold text-sm sm:text-lg text-gray-900 flex-1 leading-tight line-clamp-2">${photo.title || 'Untitled'}</h3>
                            <span class="ml-1 sm:ml-2 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-full text-xs font-semibold flex-shrink-0" style="background: linear-gradient(135deg, #3c92d9, #2c7ec9); color: white;">
                                ${photo.category?.name || 'N/A'}
                            </span>
                        </div>

                        ${photo.description ?
                            `<p class="text-xs sm:text-sm text-gray-600 mb-3 sm:mb-4 line-clamp-2 leading-relaxed">${photo.description}</p>` :
                            `<p class="text-xs sm:text-sm text-gray-400 italic mb-3 sm:mb-4">No description</p>`
                        }

                        <div class="flex items-center text-xs text-gray-500 mb-3 sm:mb-4">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            ${formatDate(photo.created_at)}
                        </div>

                        <div class="flex gap-2 pt-2 sm:pt-3 border-t border-gray-100">
                            <button type="button"
                                    onclick="event.stopPropagation(); openEditGallery(${photo.id}, '${titleEscaped}', '${descEscaped}', ${photo.gallery_category_id})"
                                    class="flex-1 flex items-center justify-center px-2 sm:px-3 py-1.5 sm:py-2 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white rounded-lg text-xs sm:text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <span class="hidden sm:inline">Edit</span>
                            </button>
                            <button type="button"
                                    onclick="event.stopPropagation(); openDeleteGallery(${photo.id}, '${titleEscaped}')"
                                    class="flex-1 flex items-center justify-center px-2 sm:px-3 py-1.5 sm:py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white rounded-lg text-xs sm:text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                <span class="hidden sm:inline">Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            }).join('');
        }

        {{-- ================================================================ --}}
        {{-- GALLERY ITEM ACTIONS --}}
        {{-- ================================================================ --}}
        function openEditGallery(id, title, description, categoryId) {
            const event = new CustomEvent('open-edit-gallery', {
                detail: {
                    id: id,
                    title: title.replace(/\\'/g, "'").replace(/&quot;/g, '"'),
                    description: description.replace(/\\'/g, "'").replace(/&quot;/g, '"'),
                    gallery_category_id: categoryId
                }
            });
            window.dispatchEvent(event);
        }

        function openDeleteGallery(id, title) {
            const event = new CustomEvent('open-delete-gallery', {
                detail: {
                    id: id,
                    title: title.replace(/\\'/g, "'").replace(/&quot;/g, '"')
                }
            });
            window.dispatchEvent(event);
        }

        {{-- ================================================================ --}}
        {{-- STATISTICS UPDATE --}}
        {{-- ================================================================ --}}
        function updateStats() {
            const totalPictures = allGalleries.length;
            const totalCategories = categoriesData.length;
            
            let currentViewText = 'All Categories';
            if (currentFilter !== 'all') {
                const category = categoriesData.find(cat => cat.id == currentFilter);
                currentViewText = category ? category.name : 'Unknown Category';
            }
            
            document.getElementById('totalPictures').textContent = totalPictures;
            document.getElementById('totalCategories').textContent = totalCategories;
            document.getElementById('currentViewText').textContent = currentViewText;
        }

        {{-- ================================================================ --}}
        {{-- IMAGE PREVIEW MODAL - ENHANCED --}}
        {{-- ================================================================ --}}
        function openImageModal(imageSrc, title, description, instructor, category, uploadDate) {
            const modal = document.getElementById('imagePreviewModal');
            const imageLoader = document.getElementById('imageLoader');

            // Show loader
            imageLoader.style.display = 'flex';

            // Set image and details
            document.getElementById('previewImage').src = imageSrc;
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewDescription').textContent = description || 'No description available.';
            document.getElementById('previewInstructor').textContent = instructor;
            document.getElementById('previewCategory').textContent = category;
            document.getElementById('previewDate').textContent = uploadDate;

            // Set download button
            const downloadBtn = document.getElementById('downloadButton');
            downloadBtn.href = imageSrc;
            downloadBtn.download = title + '.jpg';

            // Show modal with animation
            modal.classList.remove('hidden');
            modal.style.animation = 'fadeIn 0.3s ease-in-out';

            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imagePreviewModal');
            modal.style.animation = 'fadeOut 0.2s ease-in-out';

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 200);
        }

        {{-- ================================================================ --}}
        {{-- IMAGE PREVIEW FUNCTION FOR ADD GALLERY MODAL --}}
        {{-- ================================================================ --}}
        function previewGalleryImage(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    previewContainer.style.animation = 'fadeIn 0.3s ease-in-out';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        }

        {{-- ================================================================ --}}
        {{-- GALLERY MODAL MANAGEMENT --}}
        {{-- ================================================================ --}}
        function openGalleryModal() {
            document.getElementById('galleryModal').classList.remove('hidden');
        }

        function closeGalleryModal() {
            document.getElementById('galleryModal').classList.add('hidden');
            document.querySelector('#galleryModal form').reset();
            document.getElementById('imagePreviewContainer').classList.add('hidden');
        }

        {{-- ================================================================ --}}
        {{-- CATEGORY MODAL MANAGEMENT --}}
        {{-- ================================================================ --}}
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            showAddCategoryForm();
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.querySelector('#categoryModal form').reset();
        }

        function showAddCategoryForm() {
            document.getElementById('addCategoryBtn').className = 'flex-1 py-2 px-3 sm:px-4 text-xs sm:text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white';
            document.getElementById('manageCategoriesBtn').className = 'flex-1 py-2 px-3 sm:px-4 text-xs sm:text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700';
            
            document.getElementById('addCategorySection').classList.remove('hidden');
            document.getElementById('categoriesListSection').classList.add('hidden');
        }

        function showCategoriesList() {
            document.getElementById('addCategoryBtn').className = 'flex-1 py-2 px-3 sm:px-4 text-xs sm:text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700';
            document.getElementById('manageCategoriesBtn').className = 'flex-1 py-2 px-3 sm:px-4 text-xs sm:text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white';
            
            document.getElementById('addCategorySection').classList.add('hidden');
            document.getElementById('categoriesListSection').classList.remove('hidden');
        }

        {{-- ================================================================ --}}
        {{-- DELETE CATEGORY MANAGEMENT --}}
        {{-- ================================================================ --}}
        function confirmDeleteCategory(categoryId, categoryName, galleryCount) {
            document.getElementById('categoryToDeleteName').textContent = categoryName;
            
            const warningMessage = document.getElementById('categoryWarningMessage');
            if (galleryCount > 0) {
                warningMessage.textContent = `Warning: This category contains ${galleryCount} picture(s). Deleting this category will also delete all pictures in this category.`;
            } else {
                warningMessage.textContent = '';
            }
            
            const deleteForm = document.getElementById('deleteCategoryForm');
            deleteForm.action = `{{ route('instructor.gallery_categories.destroy', ['category' => '__id__']) }}`.replace('__id__', categoryId);
            
            document.getElementById('deleteCategoryModal').classList.remove('hidden');
        }

        function closeDeleteCategoryModal() {
            document.getElementById('deleteCategoryModal').classList.add('hidden');
        }

        {{-- ================================================================ --}}
        {{-- MODAL CLOSE HANDLERS --}}
        {{-- ================================================================ --}}
        window.onclick = function(event) {
            const galleryModal = document.getElementById('galleryModal');
            const categoryModal = document.getElementById('categoryModal');
            const deleteCategoryModal = document.getElementById('deleteCategoryModal');
            const imagePreviewModal = document.getElementById('imagePreviewModal');

            if (event.target === galleryModal) {
                closeGalleryModal();
            }
            if (event.target === categoryModal) {
                closeCategoryModal();
            }
            if (event.target === deleteCategoryModal) {
                closeDeleteCategoryModal();
            }
            if (event.target === imagePreviewModal) {
                closeImageModal();
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeGalleryModal();
                closeCategoryModal();
                closeDeleteCategoryModal();
                closeImageModal();
            }
        });

        {{-- ================================================================ --}}
        {{-- UTILITY FUNCTIONS --}}
        {{-- ================================================================ --}}
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }
    </script>
</x-app-layout>