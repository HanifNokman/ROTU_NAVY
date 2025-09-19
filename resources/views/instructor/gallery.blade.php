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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2z"/>
                    </svg>
                    Gallery
                </h1>
                <p class="text-gray-600">Browse and manage photos from training sessions</p>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            <!-- Main Content Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-semibold mb-2 flex items-center text-gray-900">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        Photo Collection
                    </h2>
                    <p class="text-gray-600">View and manage training photos organized by category</p>
                </div>

                <div class="p-6">

                <!-- Category Toggle Buttons -->
                <div class="mb-6">
                    <div class="flex flex-wrap gap-3">
                        <!-- All Categories Button -->
                        <a href="{{ route('instructor.gallery') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200 {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            All
                        </a>

                        <!-- Individual Category Buttons -->
                        @foreach($categories as $category)
                            <a href="{{ route('instructor.gallery', ['category' => $category->id]) }}" 
                               class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200 {{ request('category') == $category->id ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                {{ $category->name }}
                            </a>
                        @endforeach

                        <!-- Add Category Button -->
                        <button onclick="openCategoryModal()" class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200 bg-green-100 text-green-700 hover:bg-green-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Category
                        </button>
                    </div>
                </div>

                <!-- Gallery Stats -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex flex-wrap gap-4 text-sm text-blue-800">
                        <span><strong>Total Pictures:</strong> {{ $galleries->count() }}</span>
                        <span><strong>Categories:</strong> {{ $categories->count() }}</span>
                    </div>
                </div>

                <!-- Add Picture Button -->
                <div class="mb-6 flex justify-end">
                    <button onclick="openGalleryModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Picture
                    </button>
                </div>

                <!-- Alpine State for Edit and Delete Modal -->
                <div x-data="{
                    showModal: false,
                    showDeleteModal: false,
                    gallery: {},
                    deleteGallery: {},
                    routeTemplate: '{{ route('instructor.gallery.update', ['gallery' => '__id__']) }}',
                    deleteRouteTemplate: '{{ route('instructor.gallery.destroy', ['gallery' => '__id__']) }}',

                    get updateUrl() {
                        return this.routeTemplate.replace('__id__', this.gallery.id);
                    },
                    get deleteUrl() {
                        return this.deleteRouteTemplate.replace('__id__', this.deleteGallery.id);
                    },
                    openEdit(galleryData) {
                        this.gallery = JSON.parse(galleryData);
                        this.showModal = true;
                    },
                    openDelete(galleryData) {
                        this.deleteGallery = JSON.parse(galleryData);
                        this.showDeleteModal = true;
                    }
                }">

                    <!-- Gallery Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($galleries as $gallery)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <!-- Image -->
                            <div class="relative h-48 bg-gray-200">
                                @if($gallery->image_path)
                                    <img src="{{ asset($gallery->image_path) }}" 
                                         alt="{{ $gallery->title }}" 
                                         class="w-full h-full object-cover cursor-pointer"
                                         onclick="openImageModal('{{ asset($gallery->image_path) }}', '{{ $gallery->title }}')">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $gallery->title }}</h3>
                                @if($gallery->description)
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($gallery->description, 100) }}</p>
                                @endif
                                
                                <!-- Category Badge -->
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $gallery->category->name ?? 'N/A' }}
                                    </span>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <button type="button"
                                            @click="openEdit('{{ json_encode([ 'id' => $gallery->id, 'title' => $gallery->title, 'description' => $gallery->description, 'gallery_category_id' => $gallery->gallery_category_id ]) }}')"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm flex-1">
                                        Edit
                                    </button>
                                    <button type="button"
                                            @click="openDelete('{{ json_encode(['id' => $gallery->id, 'title' => $gallery->title]) }}')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm flex-1">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-gray-500">
                                @if(request()->filled('category'))
                                    No gallery items found in this category.
                                @else
                                    No gallery items available.
                                @endif
                            </p>
                            <p class="text-sm text-gray-400 mt-1">Add your first picture to get started!</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Edit Modal -->
                    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" x-cloak>
                        <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-xl">
                            <h2 class="text-lg font-semibold mb-4">Edit Gallery Item</h2>
                            <form method="POST" :action="updateUrl" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                    <input type="text" name="title" x-model="gallery.title" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" x-model="gallery.description" 
                                              class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                              rows="3"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                    <select name="gallery_category_id" x-model="gallery.gallery_category_id" 
                                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Replace Image (optional)</label>
                                    <input type="file" name="image" 
                                           class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                           accept=".jpg,.jpeg,.png,.gif,.webp">
                                    <p class="text-xs text-gray-500 mt-1">Supported formats: JPG, JPEG, PNG, GIF, WEBP (Max: 10MB)</p>
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition duration-200">Cancel</button>
                                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 transition duration-200">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
                            <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                            <p class="mb-6 text-gray-700">Are you sure you want to delete <strong x-text="deleteGallery.title"></strong>?</p>

                            <form :action="deleteUrl" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="flex justify-end gap-3">
                                    <button type="button" @click="showDeleteModal = false"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition duration-200">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-200">
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

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
        <div class="relative max-w-4xl max-h-full p-4">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="previewImage" src="" alt="" class="max-w-full max-h-full object-contain">
            <div id="previewTitle" class="text-white text-center mt-4 text-lg font-medium"></div>
        </div>
    </div>

    <!-- Add Picture Modal -->
    <div id="galleryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Add Gallery Item</h3>
                    <button onclick="closeGalleryModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('instructor.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="gallery_title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" id="gallery_title" name="title" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="gallery_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="gallery_description" name="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="gallery_category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select id="gallery_category" name="gallery_category_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="gallery_image" class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                        <input type="file" id="gallery_image" name="image" required
                               accept=".jpg,.jpeg,.png,.gif,.webp"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Supported formats: JPG, JPEG, PNG, GIF, WEBP (Max: 10MB)</p>
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeGalleryModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                            Add Picture
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Enhanced Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Category Management</h3>
                    <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Toggle Buttons -->
                <div class="flex mb-6 bg-gray-100 p-1 rounded-lg">
                    <button id="addCategoryBtn" onclick="showAddCategoryForm()" 
                            class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white">
                        Add Category
                    </button>
                    <button id="manageCategoriesBtn" onclick="showCategoriesList()" 
                            class="flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700">
                        Manage Categories
                    </button>
                </div>

                <!-- Add Category Form -->
                <div id="addCategorySection">
                    <form action="{{ route('instructor.gallery_categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="category_name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                            <input type="text" id="category_name" name="name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                   placeholder="Enter category name">
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeCategoryModal()" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                                Add Category
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories List -->
                <div id="categoriesListSection" class="hidden">
                    <div class="max-h-96 overflow-y-auto">
                        @if($categories->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                <p>No categories available.</p>
                                <p class="text-sm">Click "Add Category" to create your first category.</p>
                            </div>
                        @else
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $category->name }}</h4>
                                            <p class="text-sm text-gray-500">
                                                {{ $category->galleries->count() ?? 0 }} picture(s) in this category
                                            </p>
                                        </div>
                                        <button onclick="confirmDeleteCategory({{ $category->id }}, '{{ $category->name }}', {{ $category->galleries->count() ?? 0 }})"
                                                class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition duration-200">
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

    <!-- Delete Category Confirmation Modal -->
    <div id="deleteCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Confirm Category Deletion</h3>
                    <button onclick="closeDeleteCategoryModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="mb-4">
                    <p class="text-gray-700 mb-2">Are you sure you want to delete the category:</p>
                    <p class="font-semibold text-gray-900" id="categoryToDeleteName"></p>
                    <p class="text-sm text-red-600 mt-2" id="categoryWarningMessage"></p>
                </div>
                
                <form id="deleteCategoryForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeDeleteCategoryModal()" 
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                            Delete Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Image Preview Functions
        function openImageModal(imageSrc, title) {
            document.getElementById('previewImage').src = imageSrc;
            document.getElementById('previewTitle').textContent = title;
            document.getElementById('imagePreviewModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imagePreviewModal').classList.add('hidden');
        }

        // Gallery Modal Functions
        function openGalleryModal() {
            document.getElementById('galleryModal').classList.remove('hidden');
        }

        function closeGalleryModal() {
            document.getElementById('galleryModal').classList.add('hidden');
            // Reset form
            document.querySelector('#galleryModal form').reset();
        }

        // Category Modal Functions
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            showAddCategoryForm(); // Default to add category form
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            // Reset form
            document.querySelector('#categoryModal form').reset();
        }

        // Category Tab Functions
        function showAddCategoryForm() {
            // Update button styles
            document.getElementById('addCategoryBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white';
            document.getElementById('manageCategoriesBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700';
            
            // Show/hide sections
            document.getElementById('addCategorySection').classList.remove('hidden');
            document.getElementById('categoriesListSection').classList.add('hidden');
        }

        function showCategoriesList() {
            // Update button styles
            document.getElementById('addCategoryBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700';
            document.getElementById('manageCategoriesBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white';
            
            // Show/hide sections
            document.getElementById('addCategorySection').classList.add('hidden');
            document.getElementById('categoriesListSection').classList.remove('hidden');
        }

        // Delete Category Functions
        function confirmDeleteCategory(categoryId, categoryName, galleryCount) {
            document.getElementById('categoryToDeleteName').textContent = categoryName;
            
            const warningMessage = document.getElementById('categoryWarningMessage');
            if (galleryCount > 0) {
                warningMessage.textContent = `Warning: This category contains ${galleryCount} picture(s). Deleting this category will also delete all pictures in this category.`;
            } else {
                warningMessage.textContent = '';
            }
            
            // Set the form action
            const deleteForm = document.getElementById('deleteCategoryForm');
            deleteForm.action = `{{ route('instructor.gallery_categories.destroy', ['category' => '__id__']) }}`.replace('__id__', categoryId);
            
            document.getElementById('deleteCategoryModal').classList.remove('hidden');
        }

        function closeDeleteCategoryModal() {
            document.getElementById('deleteCategoryModal').classList.add('hidden');
        }

        // Close modals when clicking outside
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

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeGalleryModal();
                closeCategoryModal();
                closeDeleteCategoryModal();
                closeImageModal();
            }
        });
    </script>
</x-app-layout>