<x-app-layout>
    <x-container>
        <div class="flex flex-col md:flex-row">
            <!-- Main Content -->
            @section('content')
            <main class="flex-grow p-5 bg-gray-50">
                <!-- Page Header -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ __('Lessons') }}</h1>
                </div>
            
                <!-- Lessons List -->
                <div class="space-y-6">
                    @foreach ($lessons as $lesson)
                        <div 
                            class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg hover:p-8 transition cursor-pointer relative group"
                            onclick="window.location='{{ route('lessons.show', $lesson) }}'">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm text-gray-500">
                                    {{ $lesson->created_at->diffForHumans() }} بواسطة 
                                    <span class="font-medium">{{ $lesson->author?->name ?? __('Anonymous') }}</span>
                                </span>
                                <span class="text-xs px-3 py-1 rounded-full bg-teal-100 text-teal-600 text-nowrap">{{ __($lesson->type) }}</span>
                            </div>
            
                            <h2 class="text-xl font-semibold text-gray-800 group-hover:text-teal-600">{{ $lesson->title }}</h2>
            
                            <p class="text-gray-700 mt-2">
                                {{ __('Category') }}: 
                                <a href="{{ route('category', $lesson->category) }}" class="text-blue-600 hover:underline z-10 relative" 
                                   onclick="event.stopPropagation();">
                                    {{ $lesson->category->name }}
                                </a>
                            </p>
                        </div>
                    @endforeach
                </div>
            
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $lessons->links() }}
                </div>
            </main>
            
            
            @endsection

            @section('aside')
                <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
                    <h2 class="text-lg mb-3 font-bold">{{ __('Suggested') }} :</h2>
                    @if (!$latest->isEmpty())
                        <section class="mb-8">
                            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                                {{ __('Latest') }}
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($latest as $lesson)
                                    <a href="#"
                                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                        {{ $lesson->title }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if (!$suggested->isEmpty())
                        <section class="mb-8">
                            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                                {{ __('Suggested lessons') }}
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($suggested as $lesson)
                                    <a href="#"
                                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                        {{ $lesson->title }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if (!$mostLiked->isEmpty())
                        <section class="mb-8">
                            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                                {{ __('Most liked') }}
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($mostLiked as $lesson)
                                    <a href="#"
                                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                        {{ $lesson->title }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if (!$mostWatched->isEmpty())
                        <section class="mb-8">
                            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                                {{ __('Most watched') }}
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($mostWatched as $lesson)
                                    <a href="#"
                                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                        {{ $lesson->title }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if (!$suggestedCategories->isEmpty())
                        <section>
                            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                                {{ __('Suggested categories') }}
                            </h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($suggestedCategories as $category)
                                    <a href="{{ route('category', $category) }}"
                                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </aside>
            @endsection
        </div>
    </x-container>
</x-app-layout>
