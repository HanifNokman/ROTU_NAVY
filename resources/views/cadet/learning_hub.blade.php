@php
    use Illuminate\Support\Str;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Learning Hub') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Header Section -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                    <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Learning Hub
                </h1>
                <p class="text-gray-600">Access educational materials and resources</p>
            </div>

            <!-- Learning Hub Header -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-6 border-b border-purple-100">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Learning Hub
                    </h3>
                    <p class="text-gray-600">Access educational materials and resources</p>
                </div>
                <div class="p-6">
                    <!-- Filter Section -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-medium text-gray-800 mb-4">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"/>
                                </svg>
                                Filter & Navigation
                            </span>
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Category Filter -->
                            <div class="space-y-2">
                                <label for="categorySelect" class="block text-sm font-medium text-gray-700">
                                    Filter by Category
                                </label>
                                <form method="GET" action="{{ route('cadet.learning_hub') }}">
                                    <select id="categorySelect" name="category" onchange="this.form.submit()"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <!-- Material Selector -->
                            <div class="space-y-2">
                                <label for="materialDropdown" class="block text-sm font-medium text-gray-700">
                                    Select Material to Open
                                </label>
                                <select id="materialDropdown" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white" 
                                        onchange="openMaterial(this.value)">
                                    <option value="">Choose a material...</option>
                                    @foreach ($materials as $material)
                                        <option value="material-{{ $material->id }}">{{ $material->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Material List Accordion -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="font-medium text-gray-800 mb-4">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Learning Materials
                            </span>
                        </h4>
                        
                        @forelse($materials->groupBy('learning_material_category_id') as $grouped)
                            @foreach($grouped as $material)
                                <div id="material-{{ $material->id }}" x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                                    <button @click="open = !open"
                                            class="w-full flex justify-between items-center px-6 py-2 bg-blue-100 hover:bg-blue-200 text-left text-blue-800 font-medium text-lg rounded-t-lg">
                                        {{ $material->title }}
                                        <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="p-4 bg-white rounded-b-lg border-t">
                                        <div class="flex flex-col md:flex-row gap-4">
                                            @if($material->file_url && Str::endsWith($material->file_url, ['jpg','jpeg','png','gif','mp4','webm','avi']))
                                                <div class="md:w-1/2">
                                                    @if(preg_match('/\.(mp4|webm|avi)$/i', $material->file_url))
                                                        <video controls class="max-w-xs w-full rounded">
                                                            <source src="{{ asset($material->file_url) }}" type="video/mp4">
                                                        </video>
                                                    @else
                                                        <img src="{{ asset($material->file_url) }}" alt="Material Image" class="max-w-xs w-full h-auto rounded">
                                                    @endif
                                                </div>
                                                <div class="md:w-1/2 text-gray-700">
                                                    <p>{{ $material->description }}</p>
                                                </div>
                                            @else
                                                <div class="w-full text-gray-700">
                                                    <p>{{ $material->description }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @empty
                            <div class="text-center text-gray-500 py-10">No learning materials found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openMaterial(materialId) {
            if (materialId) {
                // First, scroll to the material
                const element = document.getElementById(materialId);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Wait a bit for the scroll to complete, then open the accordion
                    setTimeout(() => {
                        const button = element.querySelector('button');
                        if (button) {
                            // Check if the accordion is closed and open it
                            const content = element.querySelector('[x-show]');
                            const isOpen = element.querySelector('[x-data]').__x.$data.open;
                            
                            if (!isOpen) {
                                button.click();
                            }
                        }
                    }, 500);
                }
                
                // Reset the dropdown to default
                document.getElementById('materialDropdown').value = '';
            }
        }
    </script>
</x-app-layout>