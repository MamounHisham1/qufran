<x-app-layout>
    <x-container>
        @section('content')
            <main class="container mx-auto px-4 py-6">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-100 p-6 text-center">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $lesson->title }}</h1>
                        <p class="text-xl">
                            <a href="{{ route('category', $lesson->category) }}" class="font-semibold block text-2xl hover:text-blue-600">
                                {{ __('general.Category') }}:
                                <span>{{ $lesson->category->name }}</span>
                            </a>
                            {{ __('general.Lesson type') }}:
                            <span class="font-semibold text-gray-500">{{ __("general.{$lesson->type}") }}</span>
                        </p>
                    </div>

                    <div class="p-6">
                        @if ($lesson->type == 'video')
                            <div
                                class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-md mb-6 h-[450px] md:h-[500px] lg:h-[550px]">
                                <iframe src="https://www.youtube.com/embed/{{ $lesson->youtube() }}"
                                    class="w-full h-full object-cover"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        @endif

                        @if ($lesson->type == 'audio')
                            <div class="bg-gray-100 rounded-lg p-4 flex justify-center items-center mb-6">
                                @if ($lesson->audio)
                                <audio controls class="w-full max-w-xl">
                                    <source src="{{ $lesson->audio }}" type="audio/mpeg">
                                    <p class="text-red-500">{{ __('general.Your browser does not support the audio element.') }}</p>
                                </audio>
                                @else
                                <iframe src="{{ $lesson->getAudio() }}" width="640" height="80" allow="autoplay"></iframe>
                                @endif
                            </div>
                        @endif

                        @if ($lesson->type == 'article')
                            <div class="prose max-w-none prose-headings:text-gray-800 prose-a:text-blue-600 mb-6">
                                {!! $lesson->body !!}
                            </div>
                        @endif

                        @if ($lesson->type == 'photo')
                            <div class="flex justify-center mb-6">
                                <img src="{{ asset($lesson->image) }}" alt="{{ $lesson->title }}"
                                    class="max-w-full h-auto rounded-lg shadow-md object-cover">
                            </div>
                        @endif

                        @if ($lesson->description !== null)
                            <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ __('general.Description') }}</h2>
                                <p class="text-gray-700 text-lg">{!! $lesson->description !!}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        @endsection

        @if (!$lesson->exams->isEmpty())
            @section('aside')
                <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('general.Exams') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($lesson->exams as $exam)
                                <a href="{{ route('exams.show', $exam) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                    {{ $exam->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                </aside>
            @endsection
        @endif
    </x-container>
</x-app-layout>
