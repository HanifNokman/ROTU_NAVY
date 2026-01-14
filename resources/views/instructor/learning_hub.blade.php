<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Learning Hub Management') }}
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

    /* ========================================= */
    /* GRADIENT BACKGROUNDS */
    /* ========================================= */
    .gradient-blue {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .gradient-purple {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .gradient-orange {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* ========================================= */
    /* DESKTOP STYLES */
    /* ========================================= */
    @media (min-width: 641px) {
        /* Make action buttons shorter on desktop */
        .section-header button[onclick*="Modal"],
        .section-header button {
            padding-top: 0.625rem !important;    /* py-2.5 */
            padding-bottom: 0.625rem !important; /* py-2.5 */
        }
    }

    /* ========================================= */
    /* MOBILE RESPONSIVE STYLES */
    /* ========================================= */
    @media (max-width: 640px) {
        /* Page header */
        .text-center.mb-8 h1 {
            font-size: 1.875rem !important;
            padding: 0 1rem;
        }

        .text-center.mb-8 p {
            font-size: 0.875rem !important;
            padding: 0 1rem;
        }

        /* Reduce header margin */
        .text-center.mb-8 {
            margin-bottom: 1.5rem !important;
        }

        /* Reduce section header padding */
        .section-header {
            padding: 1rem !important;
        }

        /* Reduce content padding */
        .p-6 {
            padding: 1rem !important;
        }

        /* Filter and action buttons container */
        .mb-6.flex.flex-col {
            gap: 0.75rem !important;
            margin-bottom: 1rem !important;
        }

        .flex.flex-row.space-x-4.items-center {
            flex-direction: column !important;
            align-items: stretch !important;
            width: 100% !important;
            gap: 0.5rem !important;
        }

        .flex.flex-row.space-x-4.items-center > div {
            width: 100% !important;
        }

        /* Scoped to page content only, not mobile sidebar */
        main .flex.gap-2 {
            width: 100% !important;
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        main .flex.gap-2 button {
            width: 100% !important;
            justify-content: center !important;
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem !important;
            flex-direction: row !important;
            align-items: center !important;
        }

        /* Make plus icons more visible */
        main .flex.gap-2 button svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
            stroke-width: 2.5 !important;
        }

        /* Ensure all action buttons stay horizontal on mobile */
        button[onclick*="Modal"].bg-blue-600,
        button[onclick*="Modal"].bg-green-600,
        button[onclick*="Modal"].bg-purple-600,
        .section-header button {
            flex-direction: row !important;
            align-items: center !important;
            justify-content: center !important;
            display: flex !important;
            gap: 0.5rem !important;
            text-align: center !important;
        }

        button[onclick*="Modal"] svg,
        .section-header button svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
            min-width: 1.25rem !important;
            min-height: 1.25rem !important;
            flex-shrink: 0 !important;
            display: inline-block !important;
            margin: 0 !important;
            padding: 0 !important;
            vertical-align: middle !important;
            float: none !important;
        }

        button[onclick*="Modal"] span,
        .section-header button span {
            display: inline-block !important;
            vertical-align: middle !important;
            line-height: 1.25rem !important;
        }

        /* Category filters */
        #category,
        #quizCategoryFilter,
        #quizTypeFilter {
            width: 100% !important;
        }

        /* Filter sections */
        .mb-6.flex.items-center {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 0.5rem !important;
        }

        .mb-6.flex.items-center label {
            width: 100% !important;
        }

        /* Section headers with buttons */
        .section-header .flex.justify-between.items-center {
            flex-direction: column !important;
            gap: 1rem !important;
            align-items: flex-start !important;
        }

/* Keep modal headers horizontal on mobile but adjust positioning */
        .fixed.inset-0 .flex.justify-between.items-start {
            flex-direction: row !important;
            align-items: center !important;
            gap: 1rem !important;
        }
        
        /* Fix ALL modal close X buttons to be compact squares on the right */
        .fixed.inset-0 .flex.justify-between button:last-child,
        .fixed.inset-0 button[onclick*="Modal"],
        .fixed.inset-0 .px-6.py-5 button {
            min-width: 36px !important;
            max-width: 36px !important;
            width: 36px !important;
            height: 36px !important;
            padding: 0.5rem !important;
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        /* Ensure modal title section doesn't interfere */
        .fixed.inset-0 .flex.justify-between > div:first-child {
            flex: 1 !important;
            min-width: 0 !important;
        }

        /* Material buttons in header */
        .bg-blue-600,
        .bg-green-600 {
            flex-direction: row !important;
            align-items: center !important;
        }

        /* Modal close buttons - ensure they're touchable */
        .fixed.inset-0 button.rounded-full {
            min-width: 44px !important;
            min-height: 44px !important;
            padding: 0.75rem !important;
            transition: background-color 0.2s ease !important;
        }

        /* Disable hover effects on close buttons for mobile */
        .fixed.inset-0 button.rounded-full:hover {
            transform: none !important;
            rotate: 0deg !important;
        }

        /* Modal close button icons */
        .fixed.inset-0 button.rounded-full svg {
            width: 1.5rem !important;
            height: 1.5rem !important;
        }

        /* Modal container improvements */
        .fixed.inset-0 > div {
            padding: 0.5rem !important;
        }

        /* Modal content max width and scrolling */
        .fixed.inset-0 .bg-white {
            max-width: calc(100vw - 1rem) !important;
            max-height: calc(100vh - 1rem) !important;
        }

        /* Modal header padding */
        .fixed.inset-0 .px-6.py-5 {
            padding: 1rem !important;
        }

        /* Modal body padding */
        .fixed.inset-0 .p-6 {
            padding: 1rem !important;
            max-height: calc(100vh - 10rem);
            overflow-y: auto;
        }

        /* Modal title text size */
        .fixed.inset-0 h3,
        .fixed.inset-0 h2 {
            font-size: 1.125rem !important;
        }

        /* Form inputs in modals */
        .fixed.inset-0 input[type="text"],
        .fixed.inset-0 input[type="file"],
        .fixed.inset-0 input[type="number"],
        .fixed.inset-0 select,
        .fixed.inset-0 textarea {
            font-size: 1rem !important;
        }

        /* Modal buttons */
        .fixed.inset-0 button[type="submit"],
        .fixed.inset-0 button[type="button"] {
            padding: 0.75rem 1rem !important;
            font-size: 0.875rem !important;
        }

        /* Modal button container */
        .fixed.inset-0 .flex.justify-end,
        .fixed.inset-0 .flex.justify-center {
            flex-direction: column !important;
            gap: 0.5rem !important;
        }

        .fixed.inset-0 .flex.justify-end button,
        .fixed.inset-0 .flex.justify-center button {
            width: 100% !important;
        }

        /* Table scrolling improvements */
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }

        /* Table responsive adjustments */
        .border.border-gray-200.rounded-lg {
            border-radius: 0.5rem !important;
        }

        /* Ensure tables maintain minimum width for scrolling */
        .min-w-max {
            min-width: max-content;
        }

        .flex.justify-between.items-center button,
        .flex.justify-between.items-center a {
            width: 100% !important;
            justify-content: center !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 1rem !important;
        }

        /* Grid layouts - single column on mobile */
        .grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }

        /* Icon wrapper sizes */
        .icon-wrapper {
            width: 2rem !important;
            height: 2rem !important;
        }

        .icon-wrapper svg {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }

        /* Content cards - remove horizontal margins only */
        .dashboard-card {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        /* Add vertical spacing between dashboard cards */
        .dashboard-card + .dashboard-card {
            margin-top: 2rem !important;
        }

        /* Module/lesson items */
        .space-y-4 > div,
        .space-y-3 > div {
            padding: 0.75rem !important;
        }

        /* Modals */
        .fixed.inset-0 > div {
            margin: 1rem !important;
            max-width: calc(100vw - 2rem) !important;
            padding: 1rem !important;
        }

        /* Form inputs */
        input, select, textarea {
            font-size: 0.875rem !important;
        }
    }

    /* Extra small devices (Honor X9a - 360px-412px) */
    @media (max-width: 400px) {
        .text-center.mb-8 h1 {
            font-size: 1.5rem !important;
        }

        .section-header h3 {
            font-size: 1.125rem !important;
        }

        button, a.btn {
            font-size: 0.75rem !important;
            padding: 0.5rem 0.75rem !important;
        }

        .fixed.inset-0 > div {
            margin: 0.5rem !important;
            max-width: calc(100vw - 1rem) !important;
        }
    }
    </style>

    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ================================================================ --}}
            {{-- DASHBOARD HEADER --}}
            {{-- ================================================================ --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 gradient-blue rounded-2xl shadow-lg mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">
                    Learning Hub
                </h1>
                <p class="text-lg text-gray-600">Manage educational materials and learning resources for cadets</p>
            </div>

            @if(session('success'))
                <div class="mb-4 text-green-600">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="mb-4 text-red-600">{{ session('error') }}</div>
            @endif

            {{-- ================================================================ --}}
            {{-- LEARNING MATERIALS SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-green mr-3 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Learning Materials Management</h3>
                            </div>
                            <p class="text-gray-600 ml-13">Manage educational materials and learning resources for cadets</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openMaterialModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex flex-row items-center justify-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Add Materials</span>
                            </button>
                            <button onclick="openCategoryModal()" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex flex-row items-center justify-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                                </svg>
                                <span>Add Category</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6 text-gray-900">
                    {{-- ================================================================ --}}
                    {{-- FILTER --}}
                    {{-- ================================================================ --}}
                    <div class="mb-6 flex items-center gap-4">
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

                    {{-- ================================================================ --}}
                    {{-- MATERIALS TABLE WITH ALPINE.JS --}}
                    {{-- ================================================================ --}}
                    <div x-data="materialManagement()">
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="overflow-x-auto" style="max-height: 400px; overflow-y: auto;">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50 sticky top-0 z-10">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Title & Description</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Category</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">File</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="materialsContainer">
                                        @forelse($materials as $material)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200" data-material-id="{{ $material->id }}">
                                            <td class="px-6 py-4 text-sm text-gray-900">
                                                <div class="font-medium">{{ $material->title }}</div>
                                                @if($material->description)
                                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($material->description, 100) }}</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $material->category->name ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                @if($material->file_url)
                                                    @if($material->isYouTubeLink())
                                                        <a href="{{ $material->file_url }}" target="_blank"
                                                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                            View File
                                                        </a>
                                                    @else
                                                        <a href="{{ asset($material->file_url) }}" target="_blank"
                                                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                                                            View File
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="text-gray-400">No file</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                <div class="flex gap-2">
                                                    <button type="button"
                                                            @click="openEdit({ id: {{ $material->id }}, title: {{ json_encode($material->title) }}, description: {{ json_encode($material->description ?? '') }}, learning_material_category_id: {{ $material->learning_material_category_id }} })"
                                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm transition duration-200">
                                                        Edit
                                                    </button>
                                                    <button type="button"
                                                            @click="openDelete({ id: {{ $material->id }}, title: {{ json_encode($material->title) }} })"
                                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm transition duration-200">
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-8 text-center">
                                                <div class="text-sm text-gray-500">
                                                    @if(request()->filled('category'))
                                                        No learning materials found in this category.
                                                    @else
                                                        Please select a category to view learning materials.
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- EDIT MATERIAL MODAL (inside Alpine.js scope but positioned outside) --}}
                        {{-- ================================================================ --}}
                        <template x-teleport="body">
                            <div x-show="showModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300">
                                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-hidden transform transition-all duration-300">
                                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                                        <div class="flex justify-between items-start gap-4">
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <div class="icon-wrapper gradient-blue flex-shrink-0">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </div>
                                                <h2 class="text-xl font-bold text-gray-900">Edit Learning Material</h2>
                                            </div>
                                            <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors duration-200 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="overflow-y-auto max-h-[calc(90vh-120px)]">
                                        <div class="p-6">
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
                                            <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL (optional)</label>
                                            <input type="url" name="youtube_url" placeholder="https://www.youtube.com/watch?v=..." class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <p class="text-xs text-gray-500 mt-1">Enter a YouTube link to embed a video, or upload a file below</p>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Replace File (optional)</label>
                                            <input type="file" name="file" id="edit_material_file" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv" onchange="validateLearningHubFileSize(this, 'edit-material')">
                                            <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV, FLV, WEBM, MKV (Max: 50MB)</p>
                                            <p id="edit-material-file-error" class="text-xs text-red-600 mt-2 hidden"></p>
                                        </div>

                                        <div class="mb-4">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="remove_media" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                                <span class="ml-2 text-sm text-gray-700">Remove current media (YouTube link or file)</span>
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">Check this to remove the current YouTube link or uploaded file</p>
                                        </div>

                                        <div class="flex justify-end gap-3 pt-4">
                                            <button type="button" @click="showModal = false" class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">Cancel</button>
                                            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- ================================================================ --}}
                        {{-- DELETE MATERIAL MODAL (inside Alpine.js scope but positioned outside) --}}
                        {{-- ================================================================ --}}
                        <template x-teleport="body">
                            <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center z-50 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300">
                                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 overflow-hidden">
                                    <div class="px-6 py-5 bg-gradient-to-r from-red-50 to-orange-50">
                                        <div class="flex items-center gap-3">
                                            <div class="icon-wrapper gradient-red">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                </svg>
                                            </div>
                                            <h2 class="text-xl font-bold text-gray-900">Confirm Deletion</h2>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <p class="mb-6 text-gray-700 leading-relaxed">Are you sure you want to delete <strong x-text="deleteMaterial.title"></strong>? This action cannot be undone.</p>

                                        <form :action="deleteUrl" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="showDeleteModal = false"
                                                        class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Confirm Delete
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ================================================================ --}}
            {{-- QUIZ MANAGEMENT SECTION --}}
            {{-- ================================================================ --}}
            <div class="dashboard-card bg-white rounded-xl overflow-hidden">
                <div class="section-header">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <div class="flex items-center mb-2">
                                <div class="icon-wrapper gradient-purple mr-3 p-2 rounded-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Quiz Management</h3>
                            </div>
                            <p class="text-gray-600 ml-13">Create and manage quiz questions for cadets</p>
                        </div>
                        <button onclick="openQuizModal()" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 flex flex-row items-center justify-center gap-2 whitespace-nowrap">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Add Quiz Question</span>
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
                        <div class="overflow-x-auto" style="max-height: 350px; overflow-y: auto;">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Question</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 sticky top-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="quizQuestionsContainer">
                                    <tr id="quizQuestionsPlaceholder">
                                        <td colspan="5" class="px-6 py-8 text-center">
                                            <div class="text-sm text-gray-500">
                                                @if(request()->filled('quiz_category'))
                                                    No quiz questions found in this category.
                                                @else
                                                    Please select a category to view quiz questions.
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- ================================================================ --}}
                        {{-- EDIT QUIZ MODAL (inside Alpine.js scope but positioned outside) --}}
                        {{-- ================================================================ --}}
                        <template x-teleport="body">
                            <div x-show="showEditModal" x-cloak class="fixed inset-0 flex items-center justify-center z-[60] bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300">
                                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden transform transition-all duration-300">
                                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                                        <div class="flex justify-between items-start gap-4">
                                            <div class="flex items-center gap-3 flex-1 min-w-0">
                                                <div class="icon-wrapper gradient-purple flex-shrink-0">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </div>
                                                <h2 class="text-xl font-bold text-gray-900">Edit Quiz Question</h2>
                                            </div>
                                            <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-1.5 transition-colors duration-200 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="overflow-y-auto max-h-[calc(90vh-120px)]">
                                        <div class="p-6">
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
                                            <input type="file" name="file" id="edit_quiz_file"
                                                accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                                onchange="validateLearningHubFileSize(this, 'edit-quiz')">
                                            <p class="text-xs text-gray-500 mt-1">Current file will be replaced if new file is uploaded (Max: 50MB)</p>
                                            <p id="edit-quiz-file-error" class="text-xs text-red-600 mt-2 hidden"></p>
                                        </div>

                                        <div class="flex justify-end gap-3 pt-4">
                                            <button type="button" @click="showEditModal = false" class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">Cancel</button>
                                            <button type="submit" class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Update Question
                                            </button>
                                        </div>
                                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- ================================================================ --}}
                        {{-- DELETE QUIZ MODAL (inside Alpine.js scope but positioned outside) --}}
                        {{-- ================================================================ --}}
                        <template x-teleport="body">
                            <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center z-[60] bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300">
                                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all duration-300 overflow-hidden">
                                    <div class="px-6 py-5 bg-gradient-to-r from-red-50 to-orange-50">
                                        <div class="flex items-center gap-3">
                                            <div class="icon-wrapper gradient-red">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                </svg>
                                            </div>
                                            <h2 class="text-xl font-bold text-gray-900">Confirm Deletion</h2>
                                        </div>
                                    </div>

                                    <div class="p-6">
                                        <p class="mb-6 text-gray-700 leading-relaxed">Are you sure you want to delete this quiz question? This action cannot be undone and all associated data will be permanently removed.</p>

                                        <form :action="deleteUrl" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                            <div class="flex justify-end gap-3">
                                                <button type="button" @click="showDeleteModal = false"
                                                        class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                                    Cancel
                                                </button>
                                                <button type="submit"
                                                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete Question
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- MODALS (non-Alpine) --}}
    {{-- ================================================================ --}}

    {{-- ADD MATERIAL MODAL --}}
    <div id="materialModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-hidden transform transition-all duration-300">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex items-center gap-3">
                            <div class="icon-wrapper gradient-green flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Add Learning Material</h3>
                        </div>
                        <button onclick="closeMaterialModal()" class="w-5 h-5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-0.5 transition-colors duration-200 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-y-auto max-h-[calc(90vh-120px)]">
                    <div class="p-6">
                    
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
                            <label for="material_youtube_url" class="block text-sm font-medium text-gray-700 mb-2">YouTube URL (optional)</label>
                            <input type="url" id="material_youtube_url" name="youtube_url"
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Enter a YouTube link to embed a video, or upload a file below</p>
                        </div>

                        <div class="mb-4">
                            <label for="material_file" class="block text-sm font-medium text-gray-700 mb-2">File Upload (optional)</label>
                            <input type="file" id="material_file" name="file"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.avi,.mov,.wmv,.flv,.webm,.mkv"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   onchange="validateLearningHubFileSize(this, 'add-material')">
                            <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV, FLV, WEBM, MKV (Max: 50MB)</p>
                            <p id="add-material-file-error" class="text-xs text-red-600 mt-2 hidden"></p>
                        </div>
                        
                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" onclick="closeMaterialModal()"
                                    class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Material
                            </button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================ --}}
    {{-- CATEGORY MANAGEMENT MODAL --}}
    {{-- ================================================================ --}}
    <div id="categoryModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden transform transition-all duration-300">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex items-center gap-3">
                            <div class="icon-wrapper gradient-blue flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Category Management</h3>
                        </div>
                        <button onclick="closeCategoryModal()" class="w-5 h-5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-0.5 transition-colors duration-200 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="overflow-y-auto max-h-[calc(90vh-120px)]">
                    <div class="p-6">

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
                            
                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" onclick="closeCategoryModal()"
                                        class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
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
    </div>

    {{-- ================================================================ --}}
    {{-- DELETE CATEGORY CONFIRMATION MODAL --}}
    {{-- ================================================================ --}}
    <div id="deleteCategoryModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-[60] transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all duration-300 overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-red-50 to-orange-50">
                    <div class="flex items-center gap-3">
                        <div class="icon-wrapper gradient-red">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Confirm Category Deletion</h3>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-6">
                        <p class="text-gray-700 mb-2">Are you sure you want to delete the category:</p>
                        <p class="font-bold text-gray-900 text-lg" id="categoryToDeleteName"></p>
                        <p class="text-sm text-red-600 mt-3 font-medium" id="categoryWarningMessage"></p>
                    </div>

                    <form id="deleteCategoryForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeDeleteCategoryModal()"
                                    class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
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
    <div id="quizModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden transform transition-all duration-300">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex items-center gap-3 flex-1 min-w-0">
                            <div class="icon-wrapper gradient-purple flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Add Quiz Question</h3>
                        </div>
                        <button onclick="closeQuizModal()" class="w-5 h-5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg p-0.5 transition-colors duration-200 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                
                <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
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
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                   onchange="validateLearningHubFileSize(this, 'add-quiz')">
                            <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, DOC, DOCX, PPT, PPTX, JPG, JPEG, PNG, GIF, MP4, AVI, MOV, WMV, FLV, WEBM, MKV (Max: 50MB)</p>
                            <p id="add-quiz-file-error" class="text-xs text-red-600 mt-2 hidden"></p>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" onclick="closeQuizModal()"
                                    class="px-6 py-2.5 text-sm font-semibold text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 rounded-lg transition-all duration-200 shadow-sm hover:shadow">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-6 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Question
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
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center">
                                <div class="text-sm text-gray-500">
                                    ${categoryId ? 'No learning materials found in this category.' : 'No learning materials available.'}
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                let materialsHTML = '';
                data.materials.forEach(material => {
                    const description = material.description
                        ? `<p class="text-sm text-gray-500 mt-1">${material.description.length > 100 ? material.description.substring(0, 100) + '...' : material.description}</p>`
                        : '';

                    // Check if it's a YouTube link
                    const isYouTube = material.file_url && /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/.test(material.file_url);

                    const fileLink = material.file_url
                        ? (isYouTube
                            ? `<a href="${material.file_url}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium">View File</a>`
                            : `<a href="{{ asset('') }}${material.file_url}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-medium">View File</a>`)
                        : '<span class="text-gray-400">No file</span>';

                    materialsHTML += `
                        <tr class="hover:bg-gray-50 transition-colors duration-200" data-material-id="${material.id}">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="font-medium">${material.title}</div>
                                ${description}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    ${material.category_name}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                ${fileLink}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
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
                            </td>
                        </tr>
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
                // Unescape in correct order: backslash first, then quotes, then newlines
                const unescapeString = (str) => {
                    return str
                        .replace(/\\\\/g, '\\')
                        .replace(/\\"/g, '"')
                        .replace(/\\'/g, "'")
                        .replace(/\\n/g, '\n');
                };

                alpineComponent.dispatchEvent(new CustomEvent('open-edit-material', {
                    detail: {
                        id: id,
                        title: unescapeString(title),
                        description: unescapeString(description),
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
                    <tr id="quizQuestionsPlaceholder">
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="text-sm text-gray-500">
                                Please select a category to view quiz questions.
                            </div>
                        </td>
                    </tr>
                `;
                return;
            }

            container.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div><p class="text-gray-600 mt-2">Loading quiz questions...</p></td></tr>';
            
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
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="text-sm text-gray-500">
                                    No quiz questions found in this category.
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                let questionsHTML = '';
                data.forEach(question => {
                    const questionPreview = question.question_text.length > 100 
                        ? question.question_text.substring(0, 100) + '...' 
                        : question.question_text;
                    
                    questionsHTML += `
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <div class="font-medium">${questionPreview}</div>
                                ${question.file_url ? '<p class="text-xs text-blue-600 mt-1">Has supporting file</p>' : ''}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${question.question_type === 'MCQ' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'}">
                                    ${question.question_type}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                    ${question.category_name}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full ${question.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                    ${question.status.charAt(0).toUpperCase() + question.status.slice(1)}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
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
                            </td>
                        </tr>
                    `;
                });
                
                container.innerHTML = questionsHTML;
            })
            .catch(error => {
                console.error('Error fetching quiz questions:', error);
                container.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center"><div class="text-sm text-red-500">Error loading quiz questions. Please try again.</div></td></tr>';
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
        {{-- FILE SIZE VALIDATION FUNCTION --}}
        {{-- ================================================================ --}}
        function validateLearningHubFileSize(input, mode) {
            const maxSize = 50 * 1024 * 1024; // 50MB in bytes
            const errorElementId = mode + '-file-error';
            const errorElement = document.getElementById(errorElementId);
            const submitButton = input.closest('form').querySelector('button[type="submit"]');

            if (input.files && input.files[0]) {
                const fileSize = input.files[0].size;
                const fileName = input.files[0].name;

                if (fileSize > maxSize) {
                    const fileSizeMB = (fileSize / (1024 * 1024)).toFixed(2);
                    errorElement.textContent = `File size (${fileSizeMB}MB) exceeds the maximum limit of 50MB. Please choose a smaller file.`;
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