<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Learning Hub (Instructors)') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6 flex flex-col md:flex-row gap-6 transition duration-300 hover:shadow-2xl hover:border hover:border-blue-300">
            <div class="p-6 text-gray-900 w-full">
                @if(session('success'))
                    <div class="mb-4 text-green-600">{{ session('success') }}</div>
                @endif

                <!-- Top controls: filter + buttons -->
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                    <!-- Left side: Filter only -->
                    <form method="GET" action="{{ route('instructor.learning_hub') }}" class="flex items-center gap-2">
                        <label for="category" class="text-sm font-medium text-gray-700">Filter by Category:</label>
                        <select name="category" id="category" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm">
                            <option value="">All</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <!-- Right side: Buttons -->
                    <div class="flex gap-2">
                        <button onclick="openMaterialModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                            Add Materials
                        </button>
                        <button onclick="openCategoryModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                            Add Category
                        </button>
                    </div>
                </div>

                <!-- Alpine.js Edit Modal Integration -->
                <div x-data="{
                    showModal: false,
                    material: {},
                    routeTemplate: '{{ route('instructor.learning_materials.update', ['material' => '__id__']) }}',
                    get updateUrl() {
                        return this.routeTemplate.replace('__id__', this.material.id);
                    },
                    openEdit(materialData) {
                        this.material = JSON.parse(materialData);
                        this.showModal = true;
                    }
                }">
                    <!-- Materials Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>...</thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($materials as $material)
                                <tr>
                                    <td class="px-6 py-4 ...">
                                        {{ $material->title }}
                                        @if($material->description)
                                        <p class="text-sm ...">{{ Str::limit($material->description, 100) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 ...">
                                        <span class="inline-flex ...">
                                            {{ $material->category->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 ...">
                                        @if($material->file_url)
                                        <a href="{{ asset($material->file_url) }}" ...>View File</a>
                                        @else <span class="text-gray-400">No file</span> @endif
                                    </td>
                                    <td class="px-6 py-4 ...">
                                        <div class="flex gap-2">
                                            <button type="button"
                                                    @click="openEdit('{{ json_encode([ 'id' => $material->id, 'title' => $material->title, 'description' => $material->description, 'learning_material_category_id' => $material->learning_material_category_id ]) }}')"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">
                                                Edit
                                            </button>
                                            <form action="{{ route('instructor.learning_materials.destroy', $material->id) }}" ...>
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="...">...</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Edit Modal -->
                    <div x-show="showModal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                        <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-xl">
                            <h2 class="text-lg font-semibold mb-4">Edit Learning Material</h2>
                            <form method="POST" :action="updateUrl" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="mb-4">
                                    <label class="block text-sm font-medium">Title</label>
                                    <input type="text" name="title" x-model="material.title" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium">Description</label>
                                    <textarea name="description" x-model="material.description" class="mt-1 block w-full border border-gray-300 rounded px-3 py-2"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium">Category</label>
                                    <select name="learning_material_category_id" x-model="material.learning_material_category_id" class="mt-1 block w-full border rounded px-3 py-2">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium">Replace File (optional)</label>
                                    <input type="file" name="file" class="mt-1 block w-full">
                                </div>

                                <div class="flex justify-end gap-3">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400">Cancel</button>
                                    <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Material Modal -->
    <div id="materialModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
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
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF (Max: 10MB)</p>
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

    <!-- Add Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-md shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Add Category</h3>
                    <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
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
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            // Reset form
            document.querySelector('#categoryModal form').reset();
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const materialModal = document.getElementById('materialModal');
            const categoryModal = document.getElementById('categoryModal');
            
            if (event.target === materialModal) {
                closeMaterialModal();
            }
            if (event.target === categoryModal) {
                closeCategoryModal();
            }
        }

        // Close modals with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMaterialModal();
                closeCategoryModal();
            }
        });
    </script>
</x-app-layout>