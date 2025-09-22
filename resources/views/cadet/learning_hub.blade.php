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
                                <select id="categorySelect" name="category"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white"
                                        onchange="filterMaterials(this.value)">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
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

                        <div id="materialsContainer">
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

            <!-- Instructor Section -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-0 hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-blue-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Meet Your Instructors
                            </h3>
                            <p class="text-gray-600">Click on any instructor to view their detailed profile</p>
                        </div>

                        <!-- Instructor Status Filter -->
                        <div class="flex flex-col space-y-2 min-w-[200px]">
                            <label for="instructorStatusSelect" class="block text-sm font-medium text-gray-700">
                                Filter by Status
                            </label>
                            <select id="instructorStatusSelect" name="instructor_status"
                                    class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                                    onchange="filterInstructors(this.value)">
                                <option value="">All Statuses</option>
                                <option value="Active" @selected(request('instructor_status') == 'Active')>Active</option>
                                <option value="Relocated" @selected(request('instructor_status') == 'Relocated')>Relocated</option>
                                <option value="Retired" @selected(request('instructor_status') == 'Retired')>Retired</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div id="instructorsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($instructors as $instructor)
                            <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer"
                                 onclick="openInstructorModal({{ $instructor->id }})">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ $instructor->profile_pic ? asset('storage/' . $instructor->profile_pic) : asset('images/default.png') }}"
                                         alt="Instructor Photo"
                                         class="w-16 h-16 rounded-full object-cover border-2 border-blue-200">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-800">
                                            {{ $instructor->user->name ?? 'Unknown' }}
                                        </h4>
                                        <p class="text-sm text-blue-600 font-medium">
                                            {{ $instructor->rank ?? 'Instructor' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            {{ $instructor->position ?? 'Naval Instructor' }}
                                        </p>
                                        @if($instructor->expertise)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-1">
                                                {{ $instructor->expertise }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-500 py-10">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                No instructors available at the moment.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Instructor Profile Modal -->
    <div id="instructorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Instructor Profile
                        </h2>
                        <button onclick="closeInstructorModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
                            ×
                        </button>
                    </div>
                </div>

                <div id="modalContent" class="p-6">
                    <!-- Loading state -->
                    <div id="loadingState" class="text-center py-10">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                        <p class="text-gray-600 mt-4">Loading instructor profile...</p>
                    </div>

                    <!-- Error state -->
                    <div id="errorState" class="text-center py-10 hidden">
                        <svg class="w-12 h-12 mx-auto text-red-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-600">Error loading instructor profile.</p>
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

        // AJAX function to filter materials by category
        function filterMaterials(categoryId) {
            const materialsContainer = document.getElementById('materialsContainer');
            const materialDropdown = document.getElementById('materialDropdown');

            // Show loading state
            materialsContainer.innerHTML = '<div class="text-center py-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-purple-600 mx-auto"></div><p class="text-gray-600 mt-2">Loading materials...</p></div>';

            // Update material dropdown
            materialDropdown.innerHTML = '<option value="">Choose a material...</option>';

            // Fetch materials via AJAX
            fetch(`/api/materials?category=${categoryId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    materialsContainer.innerHTML = '<div class="text-center text-gray-500 py-10">No learning materials found.</div>';
                    return;
                }

                // Group materials by category for display
                const groupedMaterials = data.reduce((acc, material) => {
                    if (!acc[material.learning_material_category_id]) {
                        acc[material.learning_material_category_id] = [];
                    }
                    acc[material.learning_material_category_id].push(material);
                    return acc;
                }, {});

                let materialsHTML = '';
                for (const [categoryId, materials] of Object.entries(groupedMaterials)) {
                    materials.forEach(material => {
                        materialsHTML += `
                            <div id="material-${material.id}" x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                                <button @click="open = !open"
                                        class="w-full flex justify-between items-center px-6 py-2 bg-blue-100 hover:bg-blue-200 text-left text-blue-800 font-medium text-lg rounded-t-lg">
                                    ${material.title}
                                    <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="open" x-transition class="p-4 bg-white rounded-b-lg border-t">
                                    <div class="flex flex-col md:flex-row gap-4">
                                        ${material.file_url && ['jpg','jpeg','png','gif','mp4','webm','avi'].some(ext => material.file_url.toLowerCase().includes(ext)) ?
                                            `<div class="md:w-1/2">
                                                ${material.file_url.toLowerCase().includes('.mp4') || material.file_url.toLowerCase().includes('.webm') || material.file_url.toLowerCase().includes('.avi') ?
                                                    `<video controls class="max-w-xs w-full rounded">
                                                        <source src="/${material.file_url}" type="video/mp4">
                                                    </video>` :
                                                    `<img src="/${material.file_url}" alt="Material Image" class="max-w-xs w-full h-auto rounded">`
                                                }
                                            </div>
                                            <div class="md:w-1/2 text-gray-700">
                                                <p>${material.description}</p>
                                            </div>` :
                                            `<div class="w-full text-gray-700">
                                                <p>${material.description}</p>
                                            </div>`
                                        }
                                    </div>
                                </div>
                            </div>
                        `;

                        // Add to dropdown
                        materialDropdown.innerHTML += `<option value="material-${material.id}">${material.title}</option>`;
                    });
                }

                materialsContainer.innerHTML = materialsHTML;
            })
            .catch(error => {
                console.error('Error fetching materials:', error);
                materialsContainer.innerHTML = '<div class="text-center text-red-500 py-10">Error loading materials. Please try again.</div>';
            });
        }

        // AJAX function to filter instructors by status
        function filterInstructors(status) {
            const instructorsContainer = document.getElementById('instructorsContainer');

            // Show loading state
            instructorsContainer.innerHTML = '<div class="col-span-full text-center text-gray-500 py-10"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div><p class="text-gray-600 mt-2">Loading instructors...</p></div>';

            // Fetch instructors via AJAX
            fetch(`/api/instructors?status=${status}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    instructorsContainer.innerHTML = `
                        <div class="col-span-full text-center text-gray-500 py-10">
                            <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            No instructors available for the selected status.
                        </div>
                    `;
                    return;
                }

                let instructorsHTML = '';
                data.forEach(instructor => {
                    const profilePic = instructor.profile_pic ? `/storage/${instructor.profile_pic}` : '/images/default.png';
                    const prefix = instructor.service_number && instructor.service_number.startsWith('NV') ? ' PSSTLDM' :
                                  instructor.service_number && instructor.service_number.startsWith('N') ? ' TLDM' : '';

                    instructorsHTML += `
                        <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors cursor-pointer"
                             onclick="openInstructorModal(${instructor.id})">
                            <div class="flex items-center space-x-4">
                                <img src="${profilePic}"
                                     alt="Instructor Photo"
                                     class="w-16 h-16 rounded-full object-cover border-2 border-blue-200">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800">
                                        ${instructor.user?.name || 'Unknown'}
                                    </h4>
                                    <p class="text-sm text-blue-600 font-medium">
                                        ${instructor.rank || 'Instructor'}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        ${instructor.position || 'Naval Instructor'}
                                    </p>
                                    ${instructor.expertise ? `<span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mt-1">${instructor.expertise}</span>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                });

                instructorsContainer.innerHTML = instructorsHTML;
            })
            .catch(error => {
                console.error('Error fetching instructors:', error);
                instructorsContainer.innerHTML = '<div class="col-span-full text-center text-red-500 py-10">Error loading instructors. Please try again.</div>';
            });
        }

        // Instructor modal functions
        function openInstructorModal(instructorId) {
            const modal = document.getElementById('instructorModal');
            const modalContent = document.getElementById('modalContent');
            const loadingState = document.getElementById('loadingState');
            const errorState = document.getElementById('errorState');

            // Show modal and loading state
            modal.classList.remove('hidden');
            loadingState.classList.remove('hidden');
            errorState.classList.add('hidden');

            // Fetch instructor data
            fetch(`/api/instructor/${instructorId}`)
                .then(response => response.json())
                .then(data => {
                    loadingState.classList.add('hidden');
                    modalContent.innerHTML = generateInstructorProfileHTML(data);
                })
                .catch(error => {
                    console.error('Error fetching instructor data:', error);
                    loadingState.classList.add('hidden');
                    errorState.classList.remove('hidden');
                });
        }

        function closeInstructorModal() {
            const modal = document.getElementById('instructorModal');
            modal.classList.add('hidden');
        }

        // Function to format past units and remove brackets
        function formatPastUnits(pastUnits) {
            if (!pastUnits) return '-';

            // If it's a string with brackets, remove them and clean up
            if (typeof pastUnits === 'string') {
                // Remove square brackets and quotes
                let cleaned = pastUnits.replace(/[\[\]"]/g, '');
                // Split by comma and clean up each unit
                let units = cleaned.split(',').map(unit => unit.trim());
                // Filter out empty strings and join with commas
                return units.filter(unit => unit.length > 0).join(', ') || '-';
            }

            // If it's already an array
            if (Array.isArray(pastUnits)) {
                return pastUnits.filter(unit => unit && unit.trim().length > 0).join(', ') || '-';
            }

            return pastUnits || '-';
        }

        function generateInstructorProfileHTML(instructor) {
            const prefix = instructor.service_number && instructor.service_number.startsWith('NV') ? ' PSSTLDM' :
                          instructor.service_number && instructor.service_number.startsWith('N') ? ' TLDM' : '';

            return `
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Profile Picture -->
                    <div class="flex justify-center lg:justify-start">
                        <img src="${instructor.profile_pic ? '/storage/' + instructor.profile_pic : '/images/default.png'}"
                            alt="Profile Picture"
                            class="w-40 h-52 md:w-60 md:h-80 object-cover border rounded-md">
                    </div>

                    <!-- Profile Information -->
                    <div class="flex-1 space-y-6">
                        <!-- Row 1 -->
                        <div class="flex items-center justify-center md:justify-start gap-4">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold px-6 py-2 rounded-xl shadow-lg whitespace-nowrap">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Personal Profile
                            </div>
                            <p class="text-2xl font-semibold text-gray-800">
                                ${instructor.rank || 'Unknown'} ${instructor.user?.name || 'No Name'}${prefix}
                            </p>
                        </div>

                        <!-- Row 2: Contact Info -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-address-book w-5 text-blue-500 mr-2"></i>
                                <p class="text-gray-700 font-semibold">Contact Information</p>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <i class="fas fa-phone w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>Phone:</strong> ${instructor.phone_number || 'Not set'}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Email:</strong> ${instructor.user?.email || 'Not set'}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Service Info -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-medal w-5 text-purple-500 mr-2"></i>
                                <p class="text-gray-700 font-semibold">Service Information</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="flex items-center">
                                    <i class="fas fa-user-tie w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Position:</strong> ${instructor.position || '-'}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-brain w-4 text-purple-500 mr-2"></i>
                                    <span class="text-sm"><strong>Expertise:</strong> ${instructor.expertise || '-'}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock w-4 text-orange-500 mr-2"></i>
                                    <span class="text-sm"><strong>Service Years:</strong> ${instructor.time_in_service ? instructor.time_in_service + ' Years' : '-'}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-certificate w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>TTP:</strong> ${instructor.ttp || '-'}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle w-4 text-green-500 mr-2"></i>
                                    <span class="text-sm"><strong>Status:</strong> ${instructor.status || '-'}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag w-4 text-blue-500 mr-2"></i>
                                    <span class="text-sm"><strong>Service Number:</strong> ${instructor.service_number || '-'}</span>
                                </div>
                                <div class="flex items-center col-span-2">
                                    <i class="fas fa-building w-4 text-gray-500 mr-2"></i>
                                    <span class="text-sm"><strong>Past Units:</strong> ${formatPastUnits(instructor.past_unit)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Close modal when clicking outside
        document.getElementById('instructorModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeInstructorModal();
            }
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeInstructorModal();
            }
        });
    </script>
</x-app-layout>
