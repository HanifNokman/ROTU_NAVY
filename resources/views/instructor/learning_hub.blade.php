<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Learning Hub (Instructors)') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ================================================================ --}}
            {{-- PAGE HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Learning Hub
                </h1>
                <p class="text-gray-600">Manage educational materials and learning resources for cadets</p>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="mb-4 text-red-600">{{ session('error') }}</div>
            @endif

            {{-- ================================================================ --}}
            {{-- LEARNING MATERIALS SECTION (COMPLETE) --}}
            {{-- ================================================================ --}}
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
                    {{-- ================================================================ --}}
                    {{-- FILTER AND ACTION BUTTONS --}}
                    {{-- ================================================================ --}}
                    <div class="mb-6 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 overflow-x-auto items-center justify-between">
                        <div class="flex flex-row space-x-4 items-center flex-shrink-0 flex-wrap">
                            <div class="flex items-center gap-2">
                                <label for="category" class="text-sm font-medium text-gray-700">Filter by Category:</label>
                                <select name="category" id="category" onchange="filterMaterials(this.value)" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="" selected disabled>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

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

                    {{-- ================================================================ --}}
                    {{-- MATERIALS TABLE WITH ALPINE.JS --}}
                    {{-- ================================================================ --}}
                    <div x-data="materialManagement()">
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="bg-gray-50 border-b border-gray-200 sticky top-0 z-10">
                                <div class="px-6 py-3">
                                    <div class="grid grid-cols-4 gap-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <div>Title & Description</div>
                                        <div>Category</div>
                                        <div>File</div>
                                        <div>Actions</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="overflow-y-auto bg-white" style="max-height: 400px;" id="materialsContainer">
                                @forelse($materials as $material)
                                <div class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-200 px-6 py-4" data-material-id="{{ $material->id }}">
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
                                                        @click="openEdit({ id: {{ $material->id }}, title: '{{ addslashes($material->title) }}', description: '{{ addslashes($material->description ?? '') }}', learning_material_category_id: {{ $material->learning_material_category_id }} })"
                                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                                                    Edit
                                                </button>
                                                <button type="button"
                                                        @click="openDelete({ id: {{ $material->id }}, title: '{{ addslashes($material->title) }}' })"
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
                                            Please select a category to view learning materials.
                                        @endif
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- EDIT MATERIAL MODAL --}}
                        {{-- ================================================================ --}}
                        <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-xl relative">
                                <button type="button" @click="showModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
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

                        {{-- ================================================================ --}}
                        {{-- DELETE MATERIAL CONFIRMATION MODAL --}}
                        {{-- ================================================================ --}}
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

            {{-- ================================================================ --}}
            {{-- QUIZ MANAGEMENT SECTION (COMPLETE) --}}
            {{-- ================================================================ --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 border-b border-purple-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Quiz Management
                            </h3>
                            <p class="text-gray-600">Create and manage quiz questions for cadets</p>
                        </div>
                        <button onclick="openQuizModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Quiz Question
                        </button>
                    </div>
                </div>
                
                <div class="p-6">
                    {{-- ================================================================ --}}
                    {{-- QUIZ FILTERS --}}
                    {{-- ================================================================ --}}
                    <div class="mb-6 flex items-center gap-4">
                        <label for="quizCategoryFilter" class="text-sm font-medium text-gray-700">Filter by Category:</label>
                        <select id="quizCategoryFilter" name="quiz_category" class="border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="" selected disabled>Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="quizTypeFilter" class="text-sm font-medium text-gray-700 ml-4">Type:</label>
                        <select id="quizTypeFilter" name="quiz_type" class="border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="all" selected>All</option>
                            <option value="Subjective">Subjective</option>
                            <option value="MCQ">MCQ</option>
                        </select>
                    </div>

                    {{-- ================================================================ --}}
                    {{-- QUIZ QUESTIONS TABLE --}}
                    {{-- ================================================================ --}}
                    <div class="border border-gray-200 rounded-lg overflow-hidden" x-data="quizManagement()">
                        <div class="bg-gray-50 border-b border-gray-200 sticky top-0 z-10">
                            <div class="px-6 py-3">
                                <div class="grid grid-cols-6 gap-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <div class="col-span-2">Question</div>
                                    <div>Type</div>
                                    <div>Category</div>
                                    <div>Status</div>
                                    <div>Actions</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-y-auto bg-white" style="max-height: 350px;" id="quizQuestionsContainer">
                            <div class="px-6 py-8 text-center" id="quizQuestionsPlaceholder">
                                <div class="text-sm text-gray-500">
                                    @if(request()->filled('quiz_category'))
                                        No quiz questions found in this category.
                                    @else
                                        Please select a category to view quiz questions.
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- EDIT QUIZ MODAL --}}
                        {{-- ================================================================ --}}
                        <div x-show="showEditModal" x-cloak class="fixed inset-0 flex items-center justify-center z-[60] bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto relative">
                                <button type="button" @click="showEditModal = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl font-bold">&times;</button>
                                <h2 class="text-lg font-semibold mb-4">Edit Quiz Question</h2>
                                <form method="POST" :action="editUrl" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                                        <textarea name="question_text" rows="3" required x-text="editingQuestion.question_text" @input="editingQuestion.question_text = $event.target.value"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Question Type</label>
                                        <select name="question_type" x-model="editingQuestion.question_type" @change="toggleEditQuestionType()" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            <option value="MCQ">Multiple Choice Question (MCQ)</option>
                                            <option value="Subjective">Subjective/Free Text</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                        <select name="category_id" x-model="editingQuestion.category_id" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="editMcqOptions" x-show="editingQuestion.question_type === 'MCQ'" class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Answer Options</label>
                                        <div class="space-y-2">
                                            <input type="text" name="option_a" x-model="editingQuestion.option_a" placeholder="Option A" :required="editingQuestion.question_type === 'MCQ'"
                                                class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            <input type="text" name="option_b" x-model="editingQuestion.option_b" placeholder="Option B" :required="editingQuestion.question_type === 'MCQ'"
                                                class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            <input type="text" name="option_c" x-model="editingQuestion.option_c" placeholder="Option C" :required="editingQuestion.question_type === 'MCQ'"
                                                class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            <input type="text" name="option_d" x-model="editingQuestion.option_d" placeholder="Option D" :required="editingQuestion.question_type === 'MCQ'"
                                                class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                                        <div id="editMcqAnswerSelect" x-show="editingQuestion.question_type === 'MCQ'">
                                            <select name="correct_answer" x-model="editingQuestion.correct_answer" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                                <option value="">Select Correct Answer</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </div>
                                        <div id="editSubjectiveAnswerInput" x-show="editingQuestion.question_type === 'Subjective'">
                                            <textarea name="correct_answer" rows="2" placeholder="Enter the correct answer for subjective questions" x-model="editingQuestion.correct_answer"
                                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                                            <p class="text-xs text-gray-500 mt-1">Note: Subjective answers are checked case-insensitively</p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                        <select name="status" x-model="editingQuestion.status" required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Replace Supporting File (optional)</label>
                                        <input type="file" name="file"
                                            accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                        <p class="text-xs text-gray-500 mt-1">Current file will be replaced if new file is uploaded</p>
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="button" @click="showEditModal = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition duration-200">Cancel</button>
                                        <button type="submit" class="px-4 py-2 rounded bg-purple-600 text-white hover:bg-purple-700 transition duration-200">Update Question</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- DELETE QUIZ CONFIRMATION MODAL --}}
                        {{-- ================================================================ --}}
                        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center z-[60] bg-black bg-opacity-50">
                            <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
                                <h2 class="text-lg font-semibold mb-4">Confirm Deletion</h2>
                                <p class="mb-6 text-gray-700">Are you sure you want to delete this quiz question? This action cannot be undone.</p>

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
                                            Delete Question
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
    {{-- ADD MATERIAL MODAL --}}
    {{-- ================================================================ --}}
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
                                <option value="" selected disabled>Select Category</option>
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

    {{-- ================================================================ --}}
    {{-- CATEGORY MANAGEMENT MODAL --}}
    {{-- ================================================================ --}}
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

    {{-- ================================================================ --}}
    {{-- DELETE CATEGORY CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
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
    {{-- ================================================================ --}}
    {{-- ADD QUIZ QUESTION MODAL --}}
    {{-- ================================================================ --}}
    <div id="quizModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Add Quiz Question</h3>
                        <button onclick="closeQuizModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('instructor.quiz.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="quiz_question_text" class="block text-sm font-medium text-gray-700 mb-2">Question Text</label>
                            <textarea id="quiz_question_text" name="question_text" rows="3" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="quiz_question_type" class="block text-sm font-medium text-gray-700 mb-2">Question Type</label>
                            <select id="quiz_question_type" name="question_type" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="MCQ">Multiple Choice Question (MCQ)</option>
                                <option value="Subjective">Subjective/Free Text</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="quiz_category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="quiz_category" name="category_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="" selected disabled>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="mcqOptions" class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Answer Options</label>
                            <div class="space-y-2">
                                <input type="text" name="option_a" placeholder="Option A" required
                                       class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <input type="text" name="option_b" placeholder="Option B" required
                                       class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <input type="text" name="option_c" placeholder="Option C" required
                                       class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <input type="text" name="option_d" placeholder="Option D" required
                                       class="block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="quiz_correct_answer" class="block text-sm font-medium text-gray-700 mb-2">Correct Answer</label>
                            <div id="mcqAnswerSelect">
                                <select id="quiz_correct_answer" name="correct_answer" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                    <option value="">Select Correct Answer</option>
                                    <option value="A">A - Option A</option>
                                    <option value="B">B - Option B</option>
                                    <option value="C">C - Option C</option>
                                    <option value="D">D - Option D</option>
                                </select>
                            </div>
                            <div id="subjectiveAnswerInput" class="hidden">
                                <textarea name="correct_answer" rows="2" placeholder="Enter the correct answer for subjective questions"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                                <p class="text-xs text-gray-500 mt-1">Note: Subjective answers are checked case-insensitively</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="quiz_file" class="block text-sm font-medium text-gray-700 mb-2">Supporting File (optional)</label>
                            <input type="file" id="quiz_file" name="file"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV, FLV, WEBM, MKV (Max: 50MB)</p>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeQuizModal()"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition duration-200">
                                Add Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- JAVASCRIPT --}}
    {{-- ================================================================ --}}
    <script>
        {{-- ================================================================ --}}
        {{-- ALPINE.JS COMPONENTS --}}
        {{-- ================================================================ --}}
        
        function materialManagement() {
            return {
                showModal: false,
                showDeleteModal: false,
                material: {},
                deleteMaterial: {},
                routeTemplate: '{{ route('instructor.learning_materials.update', ['material' => '__id__']) }}',
                deleteRouteTemplate: '{{ route('instructor.learning_materials.destroy', ['material' => '__id__']) }}',

                init() {
                    this.$el.addEventListener('open-edit-material', (e) => {
                        this.openEdit(e.detail);
                    });
                    this.$el.addEventListener('open-delete-material', (e) => {
                        this.openDelete(e.detail);
                    });
                },

                get updateUrl() {
                    return this.routeTemplate.replace('__id__', this.material.id);
                },
                
                get deleteUrl() {
                    return this.deleteRouteTemplate.replace('__id__', this.deleteMaterial.id);
                },
                
                openEdit(materialData) {
                    this.material = materialData;
                    this.showModal = true;
                },
                
                openDelete(materialData) {
                    this.deleteMaterial = materialData;
                    this.showDeleteModal = true;
                }
            }
        }

        function quizManagement() {
            return {
                showEditModal: false,
                showDeleteModal: false,
                editingQuestion: {},
                deletingQuestion: {},
                editRouteTemplate: '{{ route("instructor.quiz.update", ["question" => "__id__"]) }}',
                deleteRouteTemplate: '{{ route("instructor.quiz.destroy", ["question" => "__id__"]) }}',

                init() {
                    this.$el.addEventListener('open-edit', (e) => {
                        this.openEdit(e.detail);
                    });
                    this.$el.addEventListener('open-delete', (e) => {
                        this.openDelete(e.detail);
                    });
                },
                
                get editUrl() {
                    return this.editRouteTemplate.replace('__id__', this.editingQuestion.id);
                },
                
                get deleteUrl() {
                    return this.deleteRouteTemplate.replace('__id__', this.deletingQuestion.id);
                },
                
                openEdit(questionData) {
                    this.editingQuestion = {
                        id: questionData.id,
                        question_text: questionData.question_text,
                        question_type: questionData.question_type,
                        category_id: questionData.category_id,
                        option_a: questionData.option_a,
                        option_b: questionData.option_b,
                        option_c: questionData.option_c,
                        option_d: questionData.option_d,
                        correct_answer: questionData.correct_answer,
                        status: questionData.status
                    };
                    this.showEditModal = true;
                    this.$nextTick(() => {
                        this.toggleEditQuestionType();
                    });
                },
                
                openDelete(questionData) {
                    this.deletingQuestion = questionData;
                    this.showDeleteModal = true;
                },
                
                toggleEditQuestionType() {
                    const editMcqOptions = document.getElementById('editMcqOptions');
                    const editMcqAnswerSelect = document.getElementById('editMcqAnswerSelect');
                    const editSubjectiveAnswerInput = document.getElementById('editSubjectiveAnswerInput');
                    const mcqInputs = document.querySelectorAll('#editMcqOptions input');
                    const correctAnswerSelect = document.querySelector('#editMcqAnswerSelect select[name="correct_answer"]');
                    const correctAnswerTextarea = document.querySelector('#editSubjectiveAnswerInput textarea');

                    if (this.editingQuestion.question_type === 'MCQ') {
                        if (editMcqOptions) editMcqOptions.classList.remove('hidden');
                        if (editMcqAnswerSelect) editMcqAnswerSelect.classList.remove('hidden');
                        if (editSubjectiveAnswerInput) editSubjectiveAnswerInput.classList.add('hidden');

                        mcqInputs.forEach(input => {
                            input.required = true;
                            input.disabled = false;
                        });

                        if (correctAnswerSelect) {
                            correctAnswerSelect.required = true;
                            correctAnswerSelect.disabled = false;
                            correctAnswerSelect.setAttribute('name', 'correct_answer');
                        }

                        if (correctAnswerTextarea) {
                            correctAnswerTextarea.required = false;
                            correctAnswerTextarea.disabled = true;
                            correctAnswerTextarea.removeAttribute('name');
                        }
                    } else if (this.editingQuestion.question_type === 'Subjective') {
                        if (editMcqOptions) editMcqOptions.classList.add('hidden');
                        if (editMcqAnswerSelect) editMcqAnswerSelect.classList.add('hidden');
                        if (editSubjectiveAnswerInput) editSubjectiveAnswerInput.classList.remove('hidden');

                        mcqInputs.forEach(input => {
                            input.required = false;
                            input.disabled = true;
                        });

                        if (correctAnswerSelect) {
                            correctAnswerSelect.required = false;
                            correctAnswerSelect.disabled = true;
                            correctAnswerSelect.removeAttribute('name');
                        }

                        if (correctAnswerTextarea) {
                            correctAnswerTextarea.required = true;
                            correctAnswerTextarea.disabled = false;
                            correctAnswerTextarea.setAttribute('name', 'correct_answer');
                        }
                    }
                }
            }
        }

        {{-- ================================================================ --}}
        {{-- MATERIAL FILTERING --}}
        {{-- ================================================================ --}}
        
        function filterMaterials(categoryId) {
            const container = document.getElementById('materialsContainer');
            
            container.innerHTML = '<div class="px-6 py-8 text-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div><p class="text-gray-600 mt-2">Loading materials...</p></div>';

            const url = new URL('{{ route('instructor.learning_hub.filter') }}', window.location.origin);
            if (categoryId) {
                url.searchParams.set('category', categoryId);
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.materials.length === 0) {
                    container.innerHTML = `
                        <div class="px-6 py-8 text-center">
                            <div class="text-sm text-gray-500">
                                ${categoryId ? 'No learning materials found in this category.' : 'No learning materials available.'}
                            </div>
                        </div>
                    `;
                    return;
                }

                let materialsHTML = '';
                data.materials.forEach(material => {
                    const description = material.description 
                        ? `<p class="text-sm text-gray-500 mt-1">${material.description.length > 100 ? material.description.substring(0, 100) + '...' : material.description}</p>`
                        : '';
                    
                    const fileLink = material.file_url 
                        ? `<a href="{{ asset('') }}${material.file_url}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium">View File</a>`
                        : '<span class="text-gray-400">No file</span>';

                    materialsHTML += `
                        <div class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-200 px-6 py-4" data-material-id="${material.id}">
                            <div class="grid grid-cols-4 gap-4 items-center">
                                <div class="text-sm text-gray-900">
                                    <div class="font-medium">${material.title}</div>
                                    ${description}
                                </div>
                                <div class="text-sm text-gray-900">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        ${material.category_name}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-900">
                                    ${fileLink}
                                </div>
                                <div class="text-sm font-medium">
                                    <div class="flex gap-2">
                                        <button type="button"
                                                onclick='openEditMaterial(${material.id}, "${material.escaped_title}", "${material.escaped_description}", ${material.learning_material_category_id})'
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                                            Edit
                                        </button>
                                        <button type="button"
                                                onclick='openDeleteMaterial(${material.id}, "${material.escaped_title}")'
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition duration-200">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = materialsHTML;
            })
            .catch(error => {
                console.error('Error fetching materials:', error);
                container.innerHTML = '<div class="px-6 py-8 text-center"><div class="text-sm text-red-500">Error loading materials. Please try again.</div></div>';
            });
        }

        function openEditMaterial(id, title, description, categoryId) {
            const alpineComponent = document.querySelector('[x-data*="materialManagement"]');
            if (alpineComponent) {
                alpineComponent.dispatchEvent(new CustomEvent('open-edit-material', {
                    detail: {
                        id: id,
                        title: title.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        description: description.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        learning_material_category_id: categoryId
                    }
                }));
            }
        }

        function openDeleteMaterial(id, title) {
            const alpineComponent = document.querySelector('[x-data*="materialManagement"]');
            if (alpineComponent) {
                alpineComponent.dispatchEvent(new CustomEvent('open-delete-material', {
                    detail: {
                        id: id,
                        title: title.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\')
                    }
                }));
            }
        }
        {{-- ================================================================ --}}
        {{-- QUIZ FILTERING AND LOADING --}}
        {{-- ================================================================ --}}
        
        function loadQuizQuestions(categoryId = '', type = 'all') {
            const container = document.getElementById('quizQuestionsContainer');
            
            if (!categoryId) {
                container.innerHTML = `
                    <div class="px-6 py-8 text-center" id="quizQuestionsPlaceholder">
                        <div class="text-sm text-gray-500">
                            Please select a category to view quiz questions.
                        </div>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = '<div class="px-6 py-8 text-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div><p class="text-gray-600 mt-2">Loading quiz questions...</p></div>';
            
            const url = `/instructor/quiz-questions?category=${categoryId}&type=${type}`;
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    container.innerHTML = `
                        <div class="px-6 py-8 text-center">
                            <div class="text-sm text-gray-500">
                                No quiz questions found in this category.
                            </div>
                        </div>
                    `;
                    return;
                }
                
                let questionsHTML = '';
                data.forEach(question => {
                    const questionPreview = question.question_text.length > 100 
                        ? question.question_text.substring(0, 100) + '...' 
                        : question.question_text;
                    
                    questionsHTML += `
                        <div class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-200 px-6 py-4">
                            <div class="grid grid-cols-6 gap-4 items-center">
                                <div class="col-span-2 text-sm text-gray-900">
                                    <div class="font-medium">${questionPreview}</div>
                                    ${question.file_url ? '<p class="text-xs text-blue-600 mt-1">Has supporting file</p>' : ''}
                                </div>
                                <div class="text-sm text-gray-900">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${question.question_type === 'MCQ' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'}">
                                        ${question.question_type}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-900">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        ${question.category_name}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-900">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${question.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                        ${question.status.charAt(0).toUpperCase() + question.status.slice(1)}
                                    </span>
                                </div>
                                <div class="text-sm font-medium">
                                    <div class="flex gap-2">
                                        <button type="button"
                                                onclick='editQuizQuestion(${question.id}, "${question.escaped_question_text}", "${question.question_type}", ${question.category_id}, "${question.escaped_option_a}", "${question.escaped_option_b}", "${question.escaped_option_c}", "${question.escaped_option_d}", "${question.escaped_correct_answer}", "${question.status}")'
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                                            Edit
                                        </button>
                                        <button type="button"
                                                onclick='deleteQuizQuestion(${question.id}, "${question.escaped_question_preview}")'
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition duration-200">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                container.innerHTML = questionsHTML;
            })
            .catch(error => {
                console.error('Error fetching quiz questions:', error);
                container.innerHTML = '<div class="px-6 py-8 text-center"><div class="text-sm text-red-500">Error loading quiz questions. Please try again.</div></div>';
            });
        }

        window.editQuizQuestion = function(id, questionText, questionType, categoryId, optionA, optionB, optionC, optionD, correctAnswer, status) {
            const quizContainer = document.querySelector('[x-data*="quizManagement"]');
            if (quizContainer) {
                quizContainer.dispatchEvent(new CustomEvent('open-edit', {
                    detail: {
                        id: id,
                        question_text: questionText.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        question_type: questionType,
                        category_id: categoryId,
                        option_a: optionA.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        option_b: optionB.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        option_c: optionC.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        option_d: optionD.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        correct_answer: correctAnswer.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\'),
                        status: status
                    }
                }));
            }
        };

        window.deleteQuizQuestion = function(id, questionText) {
            const quizContainer = document.querySelector('[x-data*="quizManagement"]');
            if (quizContainer) {
                quizContainer.dispatchEvent(new CustomEvent('open-delete', {
                    detail: {
                        id: id,
                        question_text: questionText.replace(/\\'/g, "'").replace(/\\"/g, '"').replace(/\\\\/g, '\\')
                    }
                }));
            }
        };

        function filterQuizQuestions() {
            const categoryId = document.getElementById('quizCategoryFilter').value;
            const type = document.getElementById('quizTypeFilter').value;
            loadQuizQuestions(categoryId, type);
        }

        {{-- ================================================================ --}}
        {{-- QUIZ QUESTION TYPE TOGGLE --}}
        {{-- ================================================================ --}}
        
        function toggleQuizQuestionType(questionType = null) {
            const typeSelect = document.getElementById('quiz_question_type');
            const actualType = questionType || typeSelect.value;
            
            const mcqOptions = document.getElementById('mcqOptions');
            const mcqAnswerSelect = document.getElementById('mcqAnswerSelect');
            const subjectiveAnswerInput = document.getElementById('subjectiveAnswerInput');
            const correctAnswerSelect = document.querySelector('#mcqAnswerSelect select');
            const correctAnswerTextarea = document.querySelector('#subjectiveAnswerInput textarea');
            const mcqInputs = document.querySelectorAll('#mcqOptions input');

            if (actualType === 'MCQ') {
                mcqOptions.classList.remove('hidden');
                mcqAnswerSelect.classList.remove('hidden');
                subjectiveAnswerInput.classList.add('hidden');

                mcqInputs.forEach(input => {
                    input.required = true;
                    input.disabled = false;
                });
                
                if (correctAnswerSelect) {
                    correctAnswerSelect.required = true;
                    correctAnswerSelect.disabled = false;
                    correctAnswerSelect.setAttribute('name', 'correct_answer');
                }
                
                if (correctAnswerTextarea) {
                    correctAnswerTextarea.required = false;
                    correctAnswerTextarea.disabled = true;
                    correctAnswerTextarea.value = '';
                    correctAnswerTextarea.removeAttribute('name');
                }
            } else if (actualType === 'Subjective') {
                mcqOptions.classList.add('hidden');
                mcqAnswerSelect.classList.add('hidden');
                subjectiveAnswerInput.classList.remove('hidden');

                mcqInputs.forEach(input => {
                    input.required = false;
                    input.disabled = true;
                    input.value = '';
                });
                
                if (correctAnswerSelect) {
                    correctAnswerSelect.required = false;
                    correctAnswerSelect.disabled = true;
                    correctAnswerSelect.value = '';
                    correctAnswerSelect.removeAttribute('name');
                }
                
                if (correctAnswerTextarea) {
                    correctAnswerTextarea.required = true;
                    correctAnswerTextarea.disabled = false;
                    correctAnswerTextarea.setAttribute('name', 'correct_answer');
                }
            }
        }

        {{-- ================================================================ --}}
        {{-- MODAL MANAGEMENT FUNCTIONS --}}
        {{-- ================================================================ --}}
        
        function openMaterialModal() {
            document.getElementById('materialModal').classList.remove('hidden');
        }

        function closeMaterialModal() {
            document.getElementById('materialModal').classList.add('hidden');
            document.querySelector('#materialModal form').reset();
        }

        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            showAddCategoryForm();
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.querySelector('#categoryModal form').reset();
        }

        function showAddCategoryForm() {
            document.getElementById('addCategoryBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white';
            document.getElementById('manageCategoriesBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700';
            
            document.getElementById('addCategorySection').classList.remove('hidden');
            document.getElementById('categoriesListSection').classList.add('hidden');
        }

        function showCategoriesList() {
            document.getElementById('addCategoryBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 text-gray-500 hover:text-gray-700';
            document.getElementById('manageCategoriesBtn').className = 'flex-1 py-2 px-4 text-sm font-medium rounded-md transition-colors duration-200 bg-green-600 text-white';
            
            document.getElementById('addCategorySection').classList.add('hidden');
            document.getElementById('categoriesListSection').classList.remove('hidden');
        }

        function confirmDeleteCategory(categoryId, categoryName, materialCount) {
            document.getElementById('categoryToDeleteName').textContent = categoryName;
            
            const warningMessage = document.getElementById('categoryWarningMessage');
            if (materialCount > 0) {
                warningMessage.textContent = `Warning: This category contains ${materialCount} material(s). Deleting this category will also affect these materials.`;
            } else {
                warningMessage.textContent = '';
            }
            
            const deleteForm = document.getElementById('deleteCategoryForm');
            deleteForm.action = `{{ route('instructor.learning_material_categories.destroy', ['category' => '__id__']) }}`.replace('__id__', categoryId);
            
            document.getElementById('deleteCategoryModal').classList.remove('hidden');
        }

        function closeDeleteCategoryModal() {
            document.getElementById('deleteCategoryModal').classList.add('hidden');
        }

        function openQuizModal() {
            document.getElementById('quizModal').classList.remove('hidden');
        }

        function closeQuizModal() {
            document.getElementById('quizModal').classList.add('hidden');
            document.querySelector('#quizModal form').reset();
            toggleQuizQuestionType('MCQ');
        }

        {{-- ================================================================ --}}
        {{-- EVENT HANDLERS --}}
        {{-- ================================================================ --}}
        
        window.onclick = function(event) {
            const materialModal = document.getElementById('materialModal');
            const categoryModal = document.getElementById('categoryModal');
            const deleteCategoryModal = document.getElementById('deleteCategoryModal');
            const quizModal = document.getElementById('quizModal');
            
            if (event.target === materialModal) {
                closeMaterialModal();
            }
            if (event.target === categoryModal) {
                closeCategoryModal();
            }
            if (event.target === deleteCategoryModal) {
                closeDeleteCategoryModal();
            }
            if (event.target === quizModal) {
                closeQuizModal();
            }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMaterialModal();
                closeCategoryModal();
                closeDeleteCategoryModal();
                closeQuizModal();
            }
        });

        {{-- ================================================================ --}}
        {{-- INITIALIZATION --}}
        {{-- ================================================================ --}}
        
        document.addEventListener('DOMContentLoaded', function() {
            const quizTypeSelect = document.getElementById('quiz_question_type');
            if (quizTypeSelect) {
                toggleQuizQuestionType(quizTypeSelect.value);
                
                quizTypeSelect.addEventListener('change', function() {
                    toggleQuizQuestionType(this.value);
                });
            }

            const quizCategorySelect = document.getElementById('quizCategoryFilter');
            const quizTypeFilterSelect = document.getElementById('quizTypeFilter');
            
            if (quizCategorySelect) {
                quizCategorySelect.addEventListener('change', filterQuizQuestions);
            }
            if (quizTypeFilterSelect) {
                quizTypeFilterSelect.addEventListener('change', filterQuizQuestions);
            }
            
            if (quizCategorySelect && quizCategorySelect.value) {
                loadQuizQuestions(quizCategorySelect.value, quizTypeFilterSelect.value);
            } else {
                loadQuizQuestions('', quizTypeFilterSelect.value);
            }
            
            const categorySelect = document.getElementById('category');
            if (categorySelect && categorySelect.value) {
                filterMaterials(categorySelect.value);
            }
        });
    </script>
</x-app-layout>