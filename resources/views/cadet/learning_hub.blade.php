@php
    use Illuminate\Support\Str;
@endphp


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Learning Hub (Cadet)') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow border border-transparent rounded-lg p-6 flex flex-col gap-6 transition duration-300 hover:shadow-2xl hover:border-blue-300">
            <!-- Category Filter -->
            <form method="GET" action="{{ route('cadet.learning_hub') }}" class="w-full max-w-xs mb-4">
                <select name="category" onchange="this.form.submit()"
                        class="block w-full mt-1 rounded-md border-gray-300 shadow-sm">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <!-- Material List Accordion -->
            @forelse($materials->groupBy('learning_material_category_id') as $grouped)
                @foreach($grouped as $material)
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg">
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
</x-app-layout>
