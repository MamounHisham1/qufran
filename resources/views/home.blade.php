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
            <!-- Main Content -->
            <main class="flex-grow md:p-5" x-data="home()" x-init="quran = fetchSurah()">
                <!-- Place other content here -->
                <h1 class="text-2xl font-bold mb-5">الرئيسية</h1>
                <div>
                    <div class="flex justify-around bg-gray-200 md:rounded-md">
                        <h2 x-on:click="active = 'quran'"
                            class="text-lg font-semibold p-2 my-3 rounded-lg bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white cursor-pointer transition ease-in"
                            :class="{ 'bg-red-800 text-white': active == 'quran' }">
                            {{ __('The Quran') }}
                        </h2>
                        <h2 x-on:click="active = 'hadith'"
                            class="text-lg font-semibold p-2 my-3 rounded-lg bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white cursor-pointer transition ease-in"
                            :class="{ 'bg-red-800 text-white': active == 'hadith' }">
                            {{ __('The Hadith') }}
                        </h2>
                        <h2 x-on:click="active = 'adhkar'"
                            class="text-lg font-semibold p-2 my-3 rounded-lg bg-teal-800 text-gray-100 hover:bg-red-950 hover:text-white cursor-pointer transition ease-in"
                            :class="{ 'bg-red-800 text-white': active == 'adhkar' }">
                            {{ __('The Adhkar') }}
                        </h2>
                    </div>

                    <div x-show="active == 'quran'">
                        <template x-for="surah in quran">
                            <p x-text="surah.name"></p>
                        </template>
                    </div>
                </div>

            </main>
        @endsection

        @section('aside')
            <section class="mb-8">
                <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                    {{ __('Suggested categories') }}
                </h2>
                <div class="flex flex-wrap gap-2">
                    @foreach ($suggestedCategories ?? [] as $category)
                        <a href="#"
                            class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </section>

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
        @endsection
    </x-container>

    @push('scripts')
    <script>
        function home() {
            return {
                active: 'quran',
                quran: [],
                fetchSurah() {
                    let response = [];
                    $.ajax({
                        type: "GET",
                        url: 'https://api.alquran.cloud/v1/surah',
                        success: function(response) {
                            response = response.data.slice(0, 9);
                        },
                    });
                    return response
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
