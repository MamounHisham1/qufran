<x-app-layout>
    <x-container>
        @section('content')
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2 mb-2" x-data="home()">
                <!-- Title -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ __('Quran-Hadith') }}</h1>
                </div>

                <!-- Tabs -->
                <div class="flex justify-around bg-gray-200 md:rounded-md p-3">
                    <h2 x-on:click="active = 'quran'"
                        class="text-lg font-semibold px-4 py-2 rounded-lg cursor-pointer select-none transition ease-in-out duration-300"
                        :class="active === 'quran' ? 'bg-red-800 text-white' :
                            'bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white'">
                        {{ __('The Quran') }}
                    </h2>
                    <h2 x-on:click="active = 'hadith'"
                        class="text-lg font-semibold px-4 py-2 rounded-lg cursor-pointer select-none transition ease-in-out duration-300"
                        :class="active === 'hadith' ? 'bg-red-800 text-white' :
                            'bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white'">
                        {{ __('The Hadith') }}
                    </h2>
                    <h2 x-on:click="active = 'adhkar'"
                        class="text-lg font-semibold px-4 py-2 rounded-lg cursor-pointer select-none transition ease-in-out duration-300"
                        :class="active === 'adhkar' ? 'bg-red-800 text-white' :
                            'bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white'">
                        {{ __('The Adhkar') }}
                    </h2>
                </div>

                <!-- Quran Section -->
                <div x-show="active === 'quran'" class="mt-4">
                    <ul class="flex flex-wrap items-center gap-5">
                        <template x-for="(surah, key) in quran">
                            <li>
                                <a :href="`/quran-hadith/surah/${surah.id}`"
                                    class="block group px-5 py-3 rounded-full bg-gray-200 border border-teal-400 transition transform hover:-translate-y-1 hover:bg-teal-100">
                                    <span class="font-bold text-lg text-gray-700 group-hover:text-teal-600">
                                        <span x-text="key + 1"></span> -
                                        <span x-text="surah.name_arabic"></span>
                                    </span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>

                <!-- Hadith Section -->
                <div x-show="active === 'hadith'" class="mt-4">
                    <ul class="divide-y divide-teal-400">
                        @foreach ($books as $book)
                            <li>
                                <a href="{{ route('hadith.book', $book['collection'][0]['book']) }}"
                                    class="block group px-4 py-3 transition bg-gray-50 hover:bg-teal-100 hover:shadow">
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
                                    class="block group px-4 py-3 transition bg-gray-50 hover:bg-teal-100 hover:shadow">
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

    @push('scripts')
        <script>
            function home() {
                return {
                    active: 'quran',
                    quran: [],
                    hadithBooks: [],
                    init() {
                        const self = this;
                        $.ajax({
                            type: "GET",
                            url: 'https://api.quran.com/api/v4/chapters',
                            success: function(response) {
                                self.quran = response.chapters;
                            },
                        });
                        $.ajax({
                            type: "GET",
                            url: "https://www.hadithapi.com/api/books?apiKey=$2y$10$i2HDCYItJa7hGO0iAfGTOSG14OapI813sYE9uc09Gvp7Y20BtOG",
                            success: function(response) {
                                self.hadithBooks = response.books;
                            }
                        });
                    }
                };
            }
        </script>
    @endpush
</x-app-layout>
