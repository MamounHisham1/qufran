<x-app-layout>
    <x-container>
        <div class="flex flex-col md:flex-row">
            <!-- Main Content -->
            @section('content')
                <main class="flex-grow p-5">
                    <!-- Place other content here -->
                    <h1 class="text-3xl font-bold mb-5">جميع الدروس</h1>
                    <ul class="divide-y divide-teal-400">
                        @foreach ($lessons as $lesson)
                            <li>
                                <a href="{{ route('lessons.show', $lesson->id) }}" class="block group px-2 py-4">
                                    <span class="text-lg block mb-1 text-gray-800">
                                        {{ $lesson->created_at->diffForHumans() }} بواسطة
                                        {{ $lesson->author?->name ?? __('Ananymos') }}
                                    </span>
                                    <span class="font-bold text-xl group-hover:text-teal-600">{{ $lesson->title }}</span>
                                    <div class="flex gap-2 items-center mt-1">
                                        <span class="text-lg block pt-1 text-gray-800">
                                            {{ __('Lesson type') }} {{ __($lesson->type) }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mb-2">{{ $lessons->links() }}</div>
                </main>
            @endsection

            @section('aside')
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
                                <a href="#"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endsection
        </div>
    </x-container>
</x-app-layout>
