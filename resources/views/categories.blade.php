<x-app-layout>
    <x-container>
        @section('content')
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2" x-data="home()">
                <h1 class="text-3xl font-bold p-2 mb-5 rounded-lg bg-teal-800 text-gray-100 text-center">
                    {{ $category->name }}</h1>

                <div>
                    <h2 class="text-2xl font-bold mb-5">{{ __('Lessons') }} ({{ $lessons->count() }}):</h2>
                    <ul class="divide-y divide-teal-400">
                        @foreach ($lessons as $lesson)
                            <li>
                                <a href="{{ route('lessons.show', $lesson) }}" class="block group px-2 py-4">
                                    <span class="text-lg block mb-1 text-gray-800">
                                        {{ $lesson->created_at->diffForHumans() }} بواسطة
                                        {{ $lesson->author?->name ?? __('Ananymos') }}
                                    </span>
                                    <span class="font-bold text-xl group-hover:text-teal-600">{{ $lesson->title }}</span>
                                    <span class="text-lg block mb-1 text-gray-800">
                                        {{ __('Lesson type') }} {{ __($lesson->type) }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <h2 class="text-2xl font-bold mb-5 border-t border-teal-600">{{ __('Fatawa') }} ({{ $fatawa->count() }}):</h2>
                    <ul class="divide-y divide-teal-400">
                        @foreach ($fatawa as $fatwa)
                            <li>
                                <a href="{{ route('fatawa.show', $fatwa) }}" class="block group px-2 py-4">
                                    <span class="text-sm block mb-1 text-gray-800">
                                        {{ $fatwa->created_at->diffForHumans() }}
                                    </span>
                                    <span class="font-bold text-lg group-hover:text-teal-600">{{ $fatwa->title }}</span>
                                    <div class="flex gap-2 items-center mt-1">
                                        <span class="text-sm block pt-1 text-gray-800">
                                            {{ str($fatwa->body)->limit(100, '...', true) }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </main>
        @endsection

        @section('aside')
            <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
                @if (!$categories->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Categories') }}:
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($categories ?? [] as $category)
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
    </x-container>
</x-app-layout>
