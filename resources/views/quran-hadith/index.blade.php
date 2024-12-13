<x-app-layout>
    <x-container>
        @section('content')
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2 mb-2" x-data="home()">
                <h1 class="text-2xl font-bold mb-5">{{ __('Quran-Hadith') }}</h1>
                <div class="flex justify-around bg-gray-200 md:rounded-md">
                    <h2 x-on:click="active = 'quran'"
                        class="text-lg font-semibold p-2 my-3 rounded-lg bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white cursor-pointer select-none transition ease-in"
                        :class="{ 'bg-red-800 text-white': active == 'quran' }">
                        {{ __('The Quran') }}
                    </h2>
                    <h2 x-on:click="active = 'hadith'"
                        class="text-lg font-semibold p-2 my-3 rounded-lg bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white cursor-pointer select-none transition ease-in"
                        :class="{ 'bg-red-800 text-white': active == 'hadith' }">
                        {{ __('The Hadith') }}
                    </h2>
                    <h2 x-on:click="active = 'adhkar'"
                        class="text-lg font-semibold p-2 my-3 rounded-lg bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white cursor-pointer select-none transition ease-in"
                        :class="{ 'bg-red-800 text-white': active == 'adhkar' }">
                        {{ __('The Adhkar') }}
                    </h2>
                </div>

                <div x-show="active == 'quran'" class="mt-2">
                    <ul class="flex flex-wrap items-center gap-5">
                        <template x-for="(surah, key) in quran">
                            <li>
                                <a :href="`/quran-hadith/surah/${surah.id}`"
                                    class="block group p-3 hover:p-2 border-b rounded-full bg-gray-200 border-teal-400 transition ease-linear">
                                    <span><span class="font-bold text-xl group-hover:text-teal-600"
                                            x-text="key + 1"></span> - </span>
                                    <span class="font-bold text-xl group-hover:text-teal-600"
                                        x-text="surah.name_arabic"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                </div>

                <div x-show="active == 'hadith'">
                    <ul class="flex flex-wrap items-center gap-5">
                        <template x-for="book in hadithBooks">
                            <li>
                                <a :href="`/quran-hadith/hadith/${book.bookSlug}`"
                                    class="block group py-3 border-b border-teal-400">
                                    <span class="font-bold text-xl group-hover:text-teal-600" x-text="book.bookName"></span>
                                </a>
                            </li>
                        </template>
                    </ul>
                    <li>
                        <a href="/quran-hadith" class="block group text-center">
                            <span class="font-bold text-xs group-hover:text-blue-600">{{ __('More') }}</span>
                        </a>
                    </li>
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
