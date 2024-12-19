<x-app-layout>
    <x-container>
        @section('content')
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2 mb-2" x-data="{ active: 'quran' }">
                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ __('Quran-Hadith') }}</h1>
                </div>

                <!-- Tabs -->
                <div class="flex justify-around bg-gray-200 md:rounded-md p-2">
                    @foreach (['quran' => __('The Quran'), 'hadith' => __('The Hadith'), 'adhkar' => __('The Adhkar')] as $section => $label)
                        <h2 x-on:click="active = '{{ $section }}'"
                            class="text-lg font-semibold px-4 py-2 rounded-lg cursor-pointer select-none ease-in-out hover:scale-105 transition-transform duration-300"
                            :class="active === '{{ $section }}'
                                ?
                                'bg-red-800 text-white' :
                                'bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white'">
                            {{ $label }}
                        </h2>
                    @endforeach
                </div>

                <!-- Quran Section -->
                <div x-show="active === 'quran'" class="mt-4">
                    <ul class="flex flex-wrap items-center gap-5">
                        @foreach ($quran as $surah)
                            <li>
                                <a href="{{ route('surah', $surah['id']) }}"
                                    class="block group px-5 py-3 rounded-full bg-gray-200 border border-teal-400 transition transform hover:-translate-y-1 hover:bg-teal-100">
                                    <span class="font-bold text-lg text-gray-700 group-hover:text-teal-600">
                                        <span>{{ $surah['id'] }}</span> -
                                        <span>{{ $surah['name_arabic'] }}</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Hadith Section -->
                <div x-show="active === 'hadith'" class="mt-4">
                    <ul class="divide-y divide-teal-400">
                        @foreach ($books as $book)
                            <li>
                                <a href="{{ route('hadith.book', $book['collection'][0]['book']) }}"
                                    class="block group px-4 py-3 bg-gray-50 hover:bg-teal-100 hover:shadow transition transform hover:-translate-y-1">
                                    <span
                                        class="font-bold text-lg text-gray-800 group-hover:text-teal-600">{{ __($book['name']) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Adhkar Section -->
                <div x-show="active === 'adhkar'" class="mt-4">
                    <ul class="divide-y divide-teal-400">
                        @foreach ($adhkar as $key => $name)
                            <li>
                                <a href="{{ route('adhkar', $key + 1) }}"
                                    class="block group px-4 py-3 bg-gray-50 hover:bg-teal-100 hover:shadow transition transform hover:-translate-y-1">
                                    <span
                                        class="font-bold text-lg text-gray-800 group-hover:text-teal-600">{{ __($name) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </main>
        @endsection
    </x-container>
</x-app-layout>
