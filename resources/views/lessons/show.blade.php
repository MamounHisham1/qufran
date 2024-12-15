<x-app-layout>
    <x-container>
        <main class="container mx-auto px-4 py-6">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="bg-gray-100 p-6 text-center">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $lesson->title }}</h1>
                    <p class="text-xl">
                    <a href="#" class="font-semibold block text-2xl hover:text-blue-600">  {{--  // TODO: Create the category pages. --}}
                        {{ __('Category') }}:
                        <span>{{ $lesson->category->name }}</span>
                    </a>
                        {{ __('Lesson type') }}:
                        <span class="font-semibold text-gray-500">{{ __($lesson->type) }}</span>
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
                            <audio controls class="w-full max-w-xl">
                                <source src="{{ $lesson->audio }}" type="audio/mpeg">
                                <p class="text-red-500">{{ __('Your browser does not support the audio element.') }}</p>
                            </audio>
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
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ __('Description') }}</h2>
                            <p class="text-gray-700 text-lg">{!! $lesson->description !!}</p>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </x-container>
</x-app-layout>
