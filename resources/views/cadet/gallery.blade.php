<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gallery') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Gallery
                </h1>
                <p class="text-gray-600">Browse photos and memories from training sessions</p>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Photo Collection
                    </h2>
                    <p class="text-gray-600">View training photos organized by category</p>
                </div>

                <div class="p-6">
                
                <!-- Category Toggle Buttons -->
                <div class="mb-6">
                    <div class="flex flex-wrap gap-3">
                        <!-- All Categories Button -->
                        <a href="{{ route('cadet.gallery') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200 {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All
                        </a>
                        
                        <!-- Individual Category Buttons -->
                        @foreach($categories as $category)
                            <a href="{{ route('cadet.gallery', ['category' => $category->id]) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200 {{ request('category') == $category->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Gallery Stats -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex flex-wrap gap-4 text-sm text-blue-800">
                        <span><strong>Total Pictures:</strong> {{ $galleries->count() }}</span>
                        <span><strong>Categories:</strong> {{ $categories->count() }}</span>
                    </div>
                </div>

                <!-- Category Grouped Gallery -->
                @php
                    $galleriesByCategory = $galleries->groupBy(function($gallery) {
                        return $gallery->category->name ?? 'Uncategorized';
                    });
                @endphp

                @if($galleriesByCategory->isNotEmpty())
                    @foreach($galleriesByCategory as $categoryName => $categoryGalleries)
                        <!-- Category Header Button -->
                        <div class="mb-8">
                            <div class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-8 py-1 rounded-xl shadow-lg mb-6">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-2xl md:text-3xl font-bold tracking-wide">{{ $categoryName }}</h2>
                                    <span class="bg-white bg-opacity-20 text-white px-3 py-1 rounded-full text-sm font-medium">
                                        {{ $categoryGalleries->count() }} {{ Str::plural('Photo', $categoryGalleries->count()) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Pictures Grid for this Category -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach($categoryGalleries as $gallery)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300 transform hover:scale-105">
                                    <!-- Image -->
                                    <div class="relative h-48 bg-gray-200">
                                        @if($gallery->image_path)
                                            <img src="{{ asset($gallery->image_path) }}" 
                                                 alt="{{ $gallery->title }}" 
                                                 class="w-full h-full object-cover cursor-pointer"
                                                 onclick="openImageModal('{{ asset($gallery->image_path) }}', '{{ $gallery->title }}', '{{ $gallery->description }}', '{{ $gallery->instructor->name ?? 'Unknown' }}', '{{ $gallery->category->name ?? 'N/A' }}', '{{ $gallery->created_at->format('M d, Y') }}')">>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Only Upload Date -->
                                    <div class="p-3 bg-gray-50">
                                        <div class="text-center">
                                            <span class="text-sm text-gray-600 font-medium">
                                                {{ $gallery->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-gray-500">
                            @if(request('category'))
                                No gallery items found in this category.
                            @else
                                No gallery items available yet.
                            @endif
                        </p>
                        <p class="text-sm text-gray-400 mt-1">Check back later for new pictures from instructors!</p>
                    </div>
                @endif

                <!-- Pagination info -->
                @if($galleries->count() > 20)
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-500">Showing {{ $galleries->count() }} pictures</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
        <div class="relative max-w-4xl max-h-full p-4 w-full">
            <!-- Close Button -->
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <!-- Image Container -->
            <div class="flex flex-col items-center">
                <img id="previewImage" src="" alt="" class="max-w-full max-h-[70vh] object-contain rounded-lg shadow-lg">
                
                <!-- Image Info -->
                <div class="bg-white rounded-lg p-4 mt-4 max-w-md w-full">
                    <h3 id="previewTitle" class="text-lg font-semibold text-gray-900 mb-2"></h3>
                    <p id="previewDescription" class="text-sm text-gray-600 mb-3"></p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-500">
                            <strong>Instructor:</strong> <span id="previewInstructor"></span>
                        </span>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium" id="previewCategory"></span>
                    </div>
                    <div class="mt-2 text-xs text-gray-400">
                        <strong>Upload Date:</strong> <span id="previewDate"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image Preview Functions
        function openImageModal(imageSrc, title, description, instructor, category, uploadDate) {
            document.getElementById('previewImage').src = imageSrc;
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('previewDescription').textContent = description || 'No description available.';
            document.getElementById('previewInstructor').textContent = instructor;
            document.getElementById('previewCategory').textContent = category;
            document.getElementById('previewDate').textContent = uploadDate;
            document.getElementById('imagePreviewModal').classList.remove('hidden');
            
            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imagePreviewModal').classList.add('hidden');
            
            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        document.getElementById('imagePreviewModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });

        // Handle image load errors
        document.getElementById('previewImage').addEventListener('error', function() {
            this.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yMDAgMTUwTDE2MCAyMDBIMjQwTDIwMCAxNTBaIiBmaWxsPSIjOUNBM0FGIi8+CjxjaXJjbGUgY3g9IjE3MCIgY3k9IjEyMCIgcj0iMTAiIGZpbGw9IiM5Q0EzQUYiLz4KPC9zdmc+';
        });
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-app-layout>