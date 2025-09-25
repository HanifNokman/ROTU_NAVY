<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Learning Hub (Instructors)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Learning Hub
                </h1>
                <p class="text-gray-600">Manage educational materials and learning resources for cadets</p>
            </div>

            <!-- Learning Hub Content -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-blue-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Learning Materials Management
                    </h3>
                    <p class="text-gray-600">Manage educational materials and learning resources for cadets</p>
                </div>
                
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 text-green-600">{{ session('success') }}</div>
                    @endif

                    <!-- Top controls: filter + buttons -->
                    <div class="mb-6 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 overflow-x-auto items-center justify-between">
                        <!-- Left side: Filter only -->
                        <div class="flex flex-row space-x-4 items-center flex-shrink-0 flex-wrap">
                            <form method="GET" action="{{ route('instructor.learning_hub') }}" class="flex items-center gap-2">
                                <label for="category" class="text-sm font-medium text-gray-700">Filter by Category:</label>
                                <select name="category" id="category" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <!-- Right side: Buttons -->
                        <div class="flex gap-2">
                            <button onclick="openMaterialModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Materials
                            </button>
                            <button onclick="openCategoryModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Category
                            </button>
                        </div>
                    </div>

                    <!-- Alpine State for Edit and Delete Modal -->
                    <div x-data="{
                        showModal: false,
                        showDeleteModal: false,
                        material: {},
                        deleteMaterial: {},
                        routeTemplate: '{{ route('instructor.learning_materials.update', ['material' => '__id__']) }}',
                        deleteRouteTemplate: '{{ route('instructor.learning_materials.destroy', ['material' => '__id__']) }}',

                        get updateUrl() {
                            return this.routeTemplate.replace('__id__', this.material.id);
                        },
                        get deleteUrl() {
                            return this.deleteRouteTemplate.replace('__id__', this.deleteMaterial.id);
                        },
                        openEdit(materialData) {
                            this.material = JSON.parse(materialData);
                            this.showModal = true;
                        },
                        openDelete(materialData) {
                            this.deleteMaterial = JSON.parse(materialData);
                            this.showDeleteModal = true;
                        }
                    }">

                        <!-- Materials Table Container -->
                        <div class="border border-gray-200 rounded-lg">
                            <!-- Fixed Table Header -->
                            <div class="bg-gray-50 border-b border-gray-200">
                                <div class="px-6 py-3">
                                    <div class="grid grid-cols-4 gap-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div>Title & Description</div>
                                        <div>Category</div>
                                        <div>File</div>
                                        <div>Actions</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Scrollable Table Body -->
                            <div class="overflow-y-auto bg-white" style="max-height: 600px;">
                                @forelse($materials as $material)
                                <div class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-200 px-6 py-4">
                                    <div class="grid grid-cols-4 gap-4 items-center">
                                        <div class="text-sm text-gray-900">
                                            <div class="font-medium">{{ $material->title }}</div>
                                            @if($material->description)
                                                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($material->description, 100) }}</p>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-900">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $material->category->name ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-900">
                                            @if($material->file_url)
                                                <a href="{{ asset($material->file_url) }}" target="_blank" 
                                                   class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                    View File
                                                </a>
                                            @else 
                                                <span class="text-gray-400">No file</span> 
                                            @endif
                                        </div>
                                        <div class="text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button type="button"
                                                        @click="openEdit('{{ json_encode([ 'id' => $material->id, 'title' => $material->title, 'description' => $material->description, 'learning_material_category_id' => $material->learning_material_category_id ]) }}')"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                                                    Edit
                                                </button>
                                                <button type="button"
                                                        @click="openDelete('{{ json_encode(['id' => $material->id, 'title' => $material->title]) }}')"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition duration-200">
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="px-6 py-8 text-center">
                                    <div class="text-sm text-gray-500">
                                        @if(request()->filled('category'))
                                            No learning materials found in this category.
                                        @else
                                            No learning materials available.
                                        @endif
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-xl">
                                <h2 class="text-lg font-semibold mb-4">Edit Learning Material</h2>
                                <form method="POST" :action="updateUrl" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                        <input type="text" name="title" x-model="material.title" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                        <textarea name="description" x-model="material.description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        <p class="text-xs text-gray-500 mt-1">Note: Leave description empty if you only want to upload an image for full-width display on the cadet learning hub.</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                        <select name="learning_material_category_id" x-model="material.learning_material_category_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Replace File (optional)</label>
                                        <input type="file" name="file" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv">
                                        <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV, FLV, WEBM, MKV (Max: 50MB)</p>
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
                                <p class="mb-6 text-gray-700">Are you sure you want to delete <strong x-text="deleteMaterial.title"></strong>?</p>

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
    </div>

    <!-- Add Material Modal -->
    <div id="materialModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Add Learning Material</h3>
                        <button onclick="closeMaterialModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form action="{{ route('instructor.learning_materials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="material_title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" id="material_title" name="title" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="material_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="material_description" name="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            <p class="text-xs text-gray-500 mt-1">Note: Leave description empty if you only want to upload an image for full-width display on the cadet learning hub.</p>
                        </div>
                        
                        <div class="mb-4">
                            <label for="material_category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="material_category" name="learning_material_category_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="material_file" class="block text-sm font-medium text-gray-700 mb-2">File</label>
                            <input type="file" id="material_file" name="file"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV, FLV, WEBM, MKV (Max: 50MB)</p>
                        </div>
                        
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeMaterialModal()" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                                Add Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
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
                        <form action="{{ route('instructor.learning_material_categories.store') }}" method="POST">
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
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border hover:bg-gray-100 transition-colors duration-200">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $category->name }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $category->learningMaterials->count() ?? 0 }} material(s) in this category
                                                </p>
                                            </div>
                                            <button onclick="confirmDeleteCategory({{ $category->id }}, '{{ $category->name }}', {{ $category->learningMaterials->count() ?? 0 }})"
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
    </div>

    <!-- Delete Category Confirmation Modal -->
    <div id="deleteCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-[60]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
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
    </div>

    <script>
        // Material Modal Functions
        function openMaterialModal() {
            document.getElementById('materialModal').classList.remove('hidden');
        }

        function closeMaterialModal() {
            document.getElementById('materialModal').classList.add('hidden');
            // Reset form
            document.querySelector('#materialModal form').reset();
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
        function confirmDeleteCategory(categoryId, categoryName, materialCount) {
            document.getElementById('categoryToDeleteName').textContent = categoryName;
            
            const warningMessage = document.getElementById('categoryWarningMessage');
            if (materialCount > 0) {
                warningMessage.textContent = `Warning: This category contains ${materialCount} material(s). Deleting this category will also affect these materials.`;
            } else {
                warningMessage.textContent = '';
            }
            
            // Set the form action
            const deleteForm = document.getElementById('deleteCategoryForm');
            deleteForm.action = `{{ route('instructor.learning_material_categories.destroy', ['category' => '__id__']) }}`.replace('__id__', categoryId);
            
            document.getElementById('deleteCategoryModal').classList.remove('hidden');
        }

        function closeDeleteCategoryModal() {
            document.getElementById('deleteCategoryModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const materialModal = document.getElementById('materialModal');
            const categoryModal = document.getElementById('categoryModal');
            const deleteCategoryModal = document.getElementById('deleteCategoryModal');
            
            if (event.target === materialModal) {
                closeMaterialModal();
            }
            if (event.target === categoryModal) {
                closeCategoryModal();
            }
            if (event.target === deleteCategoryModal) {
                closeDeleteCategoryModal();
            }
        }

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMaterialModal();
                closeCategoryModal();
                closeDeleteCategoryModal();
            }
        });
    </script>
</x-app-layout>