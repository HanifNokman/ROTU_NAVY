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

    @media (max-width: 640px) {
        .category-card:hover,
        .photo-card:hover,
        .dashboard-card:hover {
            transform: none !important;
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-gray-900 mb-1 sm:mb-2 px-2">Gallery</h1>
                <p class="text-gray-600 text-sm sm:text-lg px-2">Browse photos and memories from training sessions</p>
            </div>

            {{-- ================================================================ --}}
            {{-- MAIN CONTENT CARD --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl dashboard-card">

                {{-- Card Header --}}
                <div class="section-header">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper bg-purple-100 mr-3">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                                    Photo Collection
                                </h2>
                            </div>
                            <p class="text-gray-600">View training photos organized by category</p>
                        </div>
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <a href="{{ route('alumni') }}" class="px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 bg-blue-600 text-white hover:bg-blue-700 whitespace-nowrap">
                                <span class="hidden sm:inline">Legacy Gallery</span>
                                <span class="sm:hidden">Legacy</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6">

                    {{-- ================================================================ --}}
                    {{-- CATEGORY FILTER BUTTONS --}}
                    {{-- ================================================================ --}}
                    <div class="mb-4 sm:mb-6">
                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <button onclick="filterByCategory('all')"
                                   class="filter-btn px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200"
                                   data-category="all">
                                All
                            </button>

                            @foreach($categories as $category)
                                <button onclick="filterByCategory('{{ $category->id }}')"
                                       class="filter-btn px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg text-xs sm:text-sm font-medium transition duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200"
                                       data-category="{{ $category->id }}">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- GALLERY STATISTICS --}}
                    {{-- ================================================================ --}}
                    <div class="mb-4 sm:mb-6 p-3 sm:p-4 rounded-lg" style="background-color: #e8f4fd; border: 1px solid #3c92d9;">
                        <div class="flex flex-wrap gap-2 sm:gap-4 text-xs sm:text-sm" style="color: #2c5f8a;">
                            <span><strong>Total Pictures:</strong> <span id="totalPictures">{{ $galleries->count() }}</span></span>
                            <span><strong>Categories:</strong> <span id="totalCategories">{{ $categories->count() }}</span></span>
                            <span><strong>Filtered Pictures:</strong> <span id="filteredPictures">{{ $galleries->count() }}</span></span>
                        </div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- CATEGORY OVERVIEW (DEFAULT VIEW) --}}
                    {{-- ================================================================ --}}
                    <div id="categoryOverview" class="space-y-6 mb-8">
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
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                                @foreach($categories as $index => $category)
                                    @php
                                        $categoryGalleries = $galleriesByCategory->get($category->id, collect());
                                        $color = $categoryColors[$index % count($categoryColors)];
                                        $photoCount = $categoryGalleries->count();
                                    @endphp

                                    <div class="category-card text-white rounded-xl p-6 shadow-lg cursor-pointer transform hover:scale-105 transition-all duration-300 hover:shadow-xl"
                                         style="{{ $color }}"
                                         onclick="filterByCategory('{{ $category->id }}')">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-xl font-bold">{{ $category->name }}</h3>
                                            <svg class="w-8 h-8 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <p class="opacity-75 mb-3">
                                            @if($category->description)
                                                {{ Str::limit($category->description, 60) }}
                                            @else
                                                Training photos and activities
                                            @endif
                                        </p>
                                        <div class="flex justify-between items-center">
                                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                                                {{ $photoCount }} {{ Str::plural('Photo', $photoCount) }}
                                            </span>
                                            <span class="text-sm opacity-75">Click to view →</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                <p class="mt-2 text-gray-500">No categories available yet.</p>
                                <p class="text-sm text-gray-400 mt-1">Categories will appear here when instructors create them!</p>
                            </div>
                        @endif
                    </div>

                    {{-- ================================================================ --}}
                    {{-- PHOTO GALLERY GRID (HIDDEN BY DEFAULT) --}}
                    {{-- ================================================================ --}}
                    <div id="photoGallery" class="hidden">
                        <div class="mb-4 sm:mb-6">
                            <button onclick="showCategoryOverview()" class="flex items-center px-3 sm:px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition duration-200 text-sm">
                                <svg class="w-4 h-4 mr-1 sm:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span class="hidden sm:inline">Back to Categories</span>
                                <span class="sm:hidden">Back</span>
                            </button>
                        </div>

                        <div id="currentCategoryHeader" class="mb-4 sm:mb-6"></div>

                        <div id="photosGrid" class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6"></div>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- NO RESULTS MESSAGE --}}
                    {{-- ================================================================ --}}
                    <div id="noResults" class="text-center py-12 hidden">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">No gallery items found in this category.</p>
                        <p class="text-sm text-gray-400 mt-1">Check back later for new pictures from instructors!</p>
                    </div>

                    {{-- Pagination Info --}}
                    @if($galleries->count() > 20)
                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-500">Showing {{ $galleries->count() }} pictures</p>
                        </div>
                    @endif

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
                <a id="downloadButton" href="#" download class="text-white hover:text-gray-300 bg-black bg-opacity-60 hover:bg-opacity-80 rounded-full p-2 sm:p-3 transition-all duration-200 transform hover:scale-110">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                </a>

                {{-- Close Button --}}
                <button onclick="closeImageModal()" class="text-white hover:text-gray-300 bg-black bg-opacity-60 hover:bg-opacity-80 rounded-full p-2 sm:p-3 transition-all duration-200 transform hover:scale-110">
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

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>

    {{-- ================================================================ --}}
    {{-- CUSTOM STYLES --}}
    {{-- ================================================================ --}}
    @push('styles')
        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
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
            }

            .category-card:hover {
                transform: translateY(-5px) scale(1.02);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    @endpush

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    @push('scripts')
        <script>
            // ================================================================
            // GLOBAL VARIABLES
            // ================================================================
            const galleryData = @json($galleries->groupBy('gallery_category_id'));
            const categoriesData = @json($categories);
            let currentFilter = 'all';

            // ================================================================
            // INITIALIZATION
            // ================================================================
            document.addEventListener('DOMContentLoaded', function() {
                updateStats();
                showCategoryOverview();
                updateFilterButtons('all');

                // Initialize modal event listeners
                const imageModal = document.getElementById('imagePreviewModal');
                const previewImage = document.getElementById('previewImage');

                if (imageModal) {
                    imageModal.addEventListener('click', function(event) {
                        if (event.target === this) {
                            closeImageModal();
                        }
                    });
                }

                if (previewImage) {
                    previewImage.addEventListener('error', function() {
                        this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTUwTDE2MCAyMDBIMjQwTDIwMCAxNTBaIiBmaWxsPSIjOUNBM0FGIi8+CjxjaXJjbGUgY3g9IjE3MCIgY3k9IjEyMCIgcj0iMTAiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+';
                    });
                }

                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeImageModal();
                    }
                });
            });

            // ================================================================
            // CATEGORY FILTERING
            // ================================================================
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
                        btn.className = 'filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200 text-white';
                        btn.style.backgroundColor = '#3c92d9';
                    } else {
                        btn.className = 'filter-btn px-4 py-2 rounded-lg text-sm font-medium transition duration-200 bg-gray-100 text-gray-700 hover:bg-gray-200';
                        btn.style.backgroundColor = '';
                    }
                });
            }

            // ================================================================
            // VIEW SWITCHING
            // ================================================================
            function showCategoryOverview() {
                const overview = document.getElementById('categoryOverview');
                const gallery = document.getElementById('photoGallery');
                const noResults = document.getElementById('noResults');

                overview.classList.remove('hidden');
                overview.classList.add('fade-in');
                gallery.classList.add('hidden');
                noResults.classList.add('hidden');

                currentFilter = 'all';
                updateFilterButtons('all');
            }

            function showPhotosForCategory(categoryId) {
                const overview = document.getElementById('categoryOverview');
                const gallery = document.getElementById('photoGallery');
                const noResults = document.getElementById('noResults');
                const photos = galleryData[categoryId] || [];

                if (photos.length === 0) {
                    overview.classList.add('hidden');
                    gallery.classList.add('hidden');
                    noResults.classList.remove('hidden');
                    return;
                }

                overview.classList.add('hidden');
                gallery.classList.remove('hidden');
                gallery.classList.add('fade-in');
                noResults.classList.add('hidden');

                updateCategoryHeader(categoryId);
                populatePhotosGrid(photos, categoryId);
            }

            // ================================================================
            // CONTENT POPULATION
            // ================================================================
            function updateCategoryHeader(categoryId) {
                const header = document.getElementById('currentCategoryHeader');
                const category = categoriesData.find(cat => cat.id == categoryId);

                if (!category) return;

                const photoCount = galleryData[categoryId]?.length || 0;

                header.innerHTML = `
                    <div class="text-white px-8 py-4 rounded-xl shadow-lg" style="background: linear-gradient(135deg, #3c92d9, #2c7ec9);">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl md:text-3xl font-bold tracking-wide">${category.name}</h2>
                                ${category.description ? `<p class="text-blue-100 text-sm mt-1" style="color: rgba(255,255,255,0.8);">${category.description}</p>` : ''}
                            </div>
                            <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                ${photoCount} ${photoCount === 1 ? 'Photo' : 'Photos'}
                            </span>
                        </div>
                    </div>
                `;
            }

            function populatePhotosGrid(photos, categoryId) {
                const grid = document.getElementById('photosGrid');
                const category = categoriesData.find(cat => cat.id == categoryId);

                grid.innerHTML = photos.map(photo => {
                    const title = photo.title || 'Gallery Image';
                    const titleEscaped = title.replace(/'/g, "\\'").replace(/"/g, '&quot;');
                    const descEscaped = photo.description ? photo.description.replace(/'/g, "\\'").replace(/"/g, '&quot;') : '';

                    return `
                    <div class="photo-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="relative h-56 bg-gradient-to-br from-gray-100 to-gray-200 group cursor-pointer"
                             onclick="openImageModal('{{ asset('') }}${photo.image_path}', '${titleEscaped}', '${descEscaped}', '${photo.instructor?.name || 'Unknown'}', '${category?.name || 'N/A'}', '${formatDate(photo.created_at)}')">
                            ${photo.image_path ?
                                `<img src="{{ asset('') }}${photo.image_path}"
                                     alt="${titleEscaped}"
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                     loading="lazy">
                                 <div class="image-overlay">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                 </div>` :
                                `<div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>`
                            }
                        </div>
                        <div class="p-4 bg-gradient-to-br from-blue-50 to-white">
                            <div class="text-center">
                                <h3 class="text-base font-bold text-gray-900 mb-2">${title}</h3>
                                ${photo.description ?
                                    `<p class="text-xs text-gray-600 mb-2 line-clamp-2">${photo.description}</p>` :
                                    ''
                                }
                                <div class="flex items-center justify-center text-xs text-gray-500 mt-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">${formatDate(photo.created_at)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `}).join('');
            }

            // ================================================================
            // STATISTICS
            // ================================================================
            function updateStats() {
                const totalPictures = Object.values(galleryData).reduce((sum, photos) => sum + photos.length, 0);
                const totalCategories = categoriesData.length;

                let filteredPictures = totalPictures;
                if (currentFilter !== 'all') {
                    filteredPictures = galleryData[currentFilter]?.length || 0;
                }

                document.getElementById('totalPictures').textContent = totalPictures;
                document.getElementById('totalCategories').textContent = totalCategories;
                document.getElementById('filteredPictures').textContent = filteredPictures;
            }

            // ================================================================
            // IMAGE MODAL - ENHANCED
            // ================================================================
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


            // ================================================================
            // UTILITY FUNCTIONS
            // ================================================================
            function formatDate(dateString) {
                const date = new Date(dateString);
                const day = String(date.getDate()).padStart(2, '0');
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const year = date.getFullYear();
                return `${day}/${month}/${year}`;
            }
        </script>
    @endpush

    {{-- Mobile Bottom Spacer --}}
    <div class="block md:hidden h-20"></div>
</x-app-layout>
