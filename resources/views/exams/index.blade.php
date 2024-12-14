<x-app-layout>
    <x-container>
        @section('content')
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2" x-data="home()">
                <ul class="divide-y divide-teal-400">
                    @foreach ($exams as $exam)
                        <li>
                            <a href="{{ route('exams.show', $exam->id) }}">
                                <div class="flex flex-col gap-2 group py-2">
                                    <p class="flex gap-2">
                                        <span class="text-sm block pt-1 text-gray-500 group-hover:text-indigo-600">
                                            {{ __('Start date') }} {{ $exam->start_at }}
                                        </span>
                                        <span>></span>
                                        <span class="text-sm block pt-1 text-gray-500 group-hover:text-indigo-600">
                                            {{ __('End date') }} {{ $exam->end_at }}
                                        </span>
                                    </p>
                                    <span class="font-bold text-lg group-hover:text-indigo-600">{{ $exam->name }}</span>
                                    <span class="text-sm block pt-1 text-gray-500 group-hover:text-indigo-600">
                                        {{ __('Questions count') }} {{ $exam->questions->count() }}
                                    </span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="mb-2">{{ $exams->links() }}</div>
            </main>
        @endsection

        @section('aside')
            <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
                <h2 class="text-lg mb-3 font-bold">{{ __('Suggested') }} :</h2>
                <section class="mb-8">
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('Taken exams') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($takenExams ?? [] as $exam)
                            <a href="#"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                {{ $exam->name }}
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('Categories') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($categories ?? [] as $category)
                            <a href="#"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </section>

                <section class="mb-8">
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('Most taken') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($mostTaken ?? [] as $exam)
                            <a href="#"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                {{ $exam->name }}
                            </a>
                        @endforeach
                    </div>
                </section>

                <section>
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('Recommended') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($recommended ?? [] as $exam)
                            <a href="#"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                {{ $exam->name }}
                            </a>
                        @endforeach
                    </div>
                </section>
            </aside>
        @endsection
    </x-container>
</x-app-layout>
