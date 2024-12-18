<x-app-layout>
    <section class="relative isolate overflow-hidden bg-cyan-950 min-h-screen flex items-center justify-center">
        <img src="{{ asset('images/background.jpeg') }}" alt="معهد الغفران"
            class="absolute inset-0 -z-10 w-full h-full object-cover object-right md:object-center opacity-30">
        <div class="text-center max-w-2xl px-4 sm:px-6 mb-10 sm:mb-0 mt-10 md:mt-0">
            <h2 class="text-6xl font-semibold tracking-tight text-white text-center leading-relaxed">مرحبا بكم في معهد
                <span class="text-yellow-400 font-bold block">الغفران</span>
            </h2>
            <p class="mt-10 text-xl font-medium text-white text-center leading-normal">نسعى لنشر تعاليم الإسلام السمحة
                والقيم النبيلة من خلال محتوى موثوق ومفيد. هدفنا هو تعزيز المعرفة وتقديم الإلهام لتحقيق حياة مليئة
                بالإيمان والتقوى. شكرًا لزيارتكم، ونتمنى أن تجدوا في موقعنا ما ينفعكم ويساهم في تقوية علاقتكم بالله عز
                وجل.</p>
        </div>
    </section>

    <x-container>
        @section('content')
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2" x-data="home()">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ __('Home') }}</h1>
                </div>

                <!-- Section Tabs -->
                <div class="flex justify-around bg-gray-200 md:rounded-md p-2">
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
                <div x-show="active === 'quran'" class="mt-5">
                    <ul class="flex flex-wrap items-center gap-5">
                        <template x-for="surah in quran">
                            <li>
                                <a :href="`/quran-hadith/surah/${surah.id}`"
                                    class="block group py-3 px-4 border rounded-lg shadow-sm bg-white hover:shadow-md transition">
                                    <span class="font-bold text-lg group-hover:text-teal-600"
                                        x-text="surah.name_arabic"></span>
                                </a>
                            </li>
                        </template>
                        <li>
                            <a href="/quran-hadith"
                                class="block group text-center py-3 px-4 border rounded-lg shadow-sm bg-gray-100 hover:shadow-md transition">
                                <span class="font-bold text-sm group-hover:text-blue-600">{{ __('More') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Hadith Section -->
                <div x-show="active === 'hadith'" class="mt-5">
                    <ul class="flex flex-wrap items-center gap-5">
                        <template x-for="book in hadithBooks">
                            <li>
                                <a :href="`/quran-hadith/hadith/${book.bookSlug}`"
                                    class="block group py-3 px-4 border rounded-lg shadow-sm bg-white hover:shadow-md transition">
                                    <span class="font-bold text-lg group-hover:text-teal-600" x-text="book.bookName"></span>
                                </a>
                            </li>
                        </template>
                        <li>
                            <a href="/quran-hadith"
                                class="block group text-center py-3 px-4 border rounded-lg shadow-sm bg-gray-100 hover:shadow-md transition">
                                <span class="font-bold text-sm group-hover:text-blue-600">{{ __('More') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Adhkar Section -->
                <div x-show="active === 'adhkar'" class="mt-5">
                    <p class="text-gray-600 text-center">{{ __('Coming soon...') }}</p>
                </div>

                <!-- Prayer Times Section -->
                <div class="mt-5 border-t border-teal-500 pt-5">
                    <h2 class="text-2xl font-semibold mb-3 bg-teal-800 text-gray-100 px-4 py-2 rounded-lg inline-block">
                        {{ __('Prayer Times') }}
                    </h2>
                    <table class="table-auto w-full text-center bg-white rounded-lg shadow-lg overflow-hidden">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4">{{ __('Prayer') }}</th>
                                <th class="py-2 px-4">{{ __('Time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prayers as $name => ['time' => $time, 'next' => $isNext ?? 'Fajr'])
                                <tr class="{{ $isNext ? 'bg-teal-200' : 'bg-gray-50' }}">
                                    <td class="py-2 px-4">{{ __($name) }}</td>
                                    <td class="py-2 px-4">{{ __($time) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        @endsection

        @section('aside')
            <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
                <h2 class="text-lg mb-3 font-bold">{{ __('Suggested') }} :</h2>
                @if (!$suggestedCategories->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Suggested categories') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($suggestedCategories ?? [] as $category)
                                <a href="{{ route('category', $category) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$suggestedLessons->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Suggested lessons') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($suggestedLessons ?? [] as $lesson)
                                <a href="#"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                    {{ $lesson->title }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$latestLessons->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Latest lessons') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($latestLessons ?? [] as $lesson)
                                <a href="#"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                    {{ $lesson->title }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$famousTeachers->isEmpty())
                    <section>
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('Famous teachers') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($famousTeachers ?? [] as $teacher)
                                <a href="#"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                    {{ $teacher->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </aside>
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
                                self.quran = response.chapters.slice(0, 20);
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
