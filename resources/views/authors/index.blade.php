<x-app-layout>
    <x-container>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">{{ __('general.Our Teachers') }}</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($authors as $author)
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-lg transition-shadow duration-300">
                            <a href="{{ route('authors.show', $author) }}" class="block">
                                @if($author->image)
                                    <img src="{{ Storage::url($author->image) }}" 
                                         alt="{{ $author->name }}" 
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400 text-4xl">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $author->name }}</h2>
                                    
                                    @if($author->title)
                                        <p class="text-gray-600 mb-4">{{ $author->title }}</p>
                                    @endif

                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>{{ $author->posts_count }} {{ __('general.Lessons') }}</span>
                                        <span>{{ __('general.View Profile') }} →</span>
                                    </div>

                                    @if($author->posts->isNotEmpty())
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('general.Recent Lessons') }}:</h3>
                                            <ul class="space-y-1">
                                                @foreach($author->posts as $post)
                                                    <li class="text-sm text-gray-600 truncate">
                                                        • {{ $post->title }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $authors->links() }}
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout> 