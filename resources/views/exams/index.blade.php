<x-app-layout>
    <x-container>
        @section('content')
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2" x-data="home()">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ __('Exams') }}</h1>
                </div>

                <div class="space-y-6">
                    @foreach ($exams as $exam)
                        <div class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg hover:p-8 transition cursor-pointer relative group"
                            onclick="window.location='{{ route('exams.show', $exam->id) }}'">
                            <div class="flex justify-between items-center mb-3">
                                <p class="text-sm text-gray-500 group-hover:text-teal-600">
                                    {{ __('Start date') }}: {{ $exam->start_at }}
                                </p>
                                <p class="text-sm text-gray-500 group-hover:text-teal-600">
                                    {{ __('End date') }}: {{ $exam->end_at }}
                                </p>
                            </div>

                            <h2 class="text-lg font-bold text-gray-800 group-hover:text-teal-600">
                                {{ $exam->name }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-2 group-hover:text-teal-600">
                                {{ __('Questions count') }}: {{ $exam->questions->count() }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $exams->links() }}
                </div>
            </main>
        @endsection

        @section('aside')
            <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
                <h2 class="text-lg mb-3 font-bold">{{ __('Suggested') }} :</h2>
                @if (!$takenExams->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Taken exams') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($takenExams ?? [] as $exam)
                                <a href="{{ route('exams.completed', $exam) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                    {{ $exam->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$categories->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Categories') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($categories ?? [] as $category)
                                <a href="{{ route('category', $category) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$mostTaken->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Most taken') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($mostTaken ?? [] as $exam)
                                <a href="{{ route('exams.show', $exam) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                    {{ $exam->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$recommended->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Recommended') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($recommended ?? [] as $exam)
                                <a href="{{ route('exams.show', $exam) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                    {{ $exam->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$lessons->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Lessons') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($lessons ?? [] as $lesson)
                                <a href="{{ route('lessons.show', $lesson) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                    {{ $lesson->title }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </aside>
        @endsection
    </x-container>
</x-app-layout>
