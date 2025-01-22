<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ __('Latest Blogs') }}</h1>
            <div class="w-24 h-1 bg-teal-600 mx-auto"></div>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse ($blogs as $blog)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl duration-300 
                          flex flex-col h-full transform hover:-translate-y-1 transition-transform">
                <!-- Image Container -->
                @if($blog->image)
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                        class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                    <!-- Category Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-teal-600 text-white px-3 py-1 rounded-full text-sm">
                            {{ $blog->category->name }}
                        </span>
                    </div>
                </div>
                @endif

                <!-- Content Container -->
                <div class="p-6 flex-grow flex flex-col">
                    <!-- Meta Info -->
                    <div class="flex justify-between items-center text-sm text-gray-500 mb-3">
                        <span>{{ $blog->created_at->format('Y-m-d') }}</span>
                        @if($blog->author)
                        <span class="flex items-center gap-2">
                            @if($blog->author->avatar)
                            <img src="{{ asset('storage/' . $blog->author->avatar) }}" alt="{{ $blog->author->name }}"
                                class="w-6 h-6 rounded-full">
                            @endif
                            {{ $blog->author->name }}
                        </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h2 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 hover:text-teal-600">
                        {{ $blog->title }}
                    </h2>

                    <!-- Excerpt -->
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ str($blog->body)->limit(150) }}
                    </p>

                    <!-- Footer -->
                    <div class="mt-auto flex justify-between items-center">
                        <a href="{{ route('blogs.show', $blog) }}"
                            class="text-teal-600 hover:text-teal-800 font-medium inline-flex items-center gap-2">
                            {{ __('Read More') }}
                            <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <div class="text-gray-500 text-lg">{{ __('No blogs found') }}</div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $blogs->links() }}
        </div>
    </div>

    @push('styles')
    <style>
        @media print {
            .container {
                max-width: none !important;
                padding: 0 !important;
            }

            .grid {
                display: block !important;
            }

            .shadow-md,
            .shadow-xl {
                box-shadow: none !important;
            }

            .hover\:shadow-xl:hover {
                box-shadow: none !important;
            }

            .bg-teal-600 {
                background-color: transparent !important;
                border: 1px solid #000 !important;
                color: #000 !important;
            }

            .text-teal-600 {
                color: #000 !important;
            }
        }
    </style>
    @endpush
</x-app-layout>