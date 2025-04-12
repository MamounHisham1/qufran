<x-app-layout>
    <section class="relative isolate overflow-hidden bg-cyan-950 min-h-screen flex items-center justify-center">
        <img src="{{ asset($heroImage ?? 'images/background.jpeg') }}" alt="معهد الغفران"
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
            <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2" x-data="{ active: 'quran' }">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-800">{{ __('general.Home') }}</h1>
                </div>

                <!-- Date Section -->
                <div>
                    <h2 class="text-2xl font-semibold mb-3 bg-teal-800 text-gray-100 px-4 py-2 rounded-lg inline-block">
                        {{ __('general.Date') }}
                    </h2>
                    <div class="flex justify-between items-center">
                        <div class="text-center">
                            <h3 class="text-xl font-semibold text-gray-800">{{ __('general.Hijri Date') }}</h3>
                            <p class="text-3xl font-bold text-teal-800">{{ $hijriDate }}</p>
                        </div>
                        <div class="text-center">
                            <h3 class="text-xl font-semibold text-gray-800">{{ __('general.Normal Date') }}</h3>
                            <p class="text-3xl font-bold text-teal-800">{{ now()->isoFormat('LL') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Section Tabs -->
                <div class="mt-5 border-t border-teal-500 pt-5">
                    <div class="flex justify-around bg-gray-200 md:rounded-md p-2">
                        @foreach (['quran' => __('general.The Quran'), 'hadith' => __('general.The Hadith'), 'adhkar' => __('general.The Adhkar')] as $section => $label)
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
                </div>

                <!-- Quran Section -->
                <div x-show="active === 'quran'" class="mt-5">
                    <ul class="flex flex-wrap items-center gap-5">
                        @foreach ($chapters as $chpater)
                            <li>
                                <a href="{{ route('surah', $chpater) }}"
                                    class="block group py-3 px-4 border rounded-lg shadow-sm bg-white hover:shadow-md transition transform hover:-translate-y-1">
                                    <span
                                        class="font-bold text-lg group-hover:text-teal-600">{{ $chpater->name }}</span>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('quran-hadith.index') }}"
                                class="block group text-center py-3 px-4 border rounded-lg shadow-sm bg-gray-100 hover:shadow-md transition">
                                <span class="font-bold text-sm group-hover:text-blue-600">{{ __('general.More') }}</span>
                            </a>
                        </li>
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
                                        class="font-bold text-lg text-gray-800 group-hover:text-teal-600">{{ __('general.' . $book['name']) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-5 text-center">
                        <a href="{{ route('quran-hadith.index') }}"
                            class="inline-block bg-teal-800 text-white text-sm font-semibold px-3 py-1 rounded-lg hover:bg-teal-900 transition">
                            {{ __('general.More') }}
                        </a>
                    </div>
                </div>

                <!-- Adhkar Section -->
                <div x-show="active === 'adhkar'" class="mt-4">
                    <ul class="divide-y divide-teal-400">
                        @foreach ($adhkar as $key => $name)
                            <li>
                                <a href="{{ route('adhkar', $key + 1) }}"
                                    class="block group px-4 py-3 bg-gray-50 hover:bg-teal-100 hover:shadow transition transform hover:-translate-y-1">
                                    <span
                                        class="font-bold text-lg text-gray-800 group-hover:text-teal-600">{{ $name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-5 text-center">
                        <a href="{{ route('quran-hadith.index') }}"
                            class="inline-block bg-teal-800 text-white text-sm font-semibold px-3 py-1 rounded-lg hover:bg-teal-900 transition">
                            {{ __('general.More') }}
                        </a>
                    </div>
                </div>

                <!-- Prayer Times Section -->
                <div class="mt-5 border-t border-teal-500 pt-5">
                    <h2 class="text-2xl font-semibold mb-3 bg-teal-800 text-gray-100 px-4 py-2 rounded-lg inline-block">
                        {{ __('general.Prayer Times') }}
                    </h2>
                    <table class="table-auto w-full text-center bg-white rounded-lg shadow-lg overflow-hidden">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4">{{ __('general.Prayer') }}</th>
                                <th class="py-2 px-4">{{ __('general.Time') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prayers as $name => ['time' => $time, 'next' => $isNext])
                                <tr class="{{ $isNext ? 'bg-teal-200' : 'bg-gray-50' }}">
                                    <td class="py-2 px-4">{{ __("general.{$name}") }}</td>
                                    <td class="py-2 px-4">{{ $time }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Fatwa Section -->
                <div class="mt-5 border-t border-teal-500 pt-5">
                    <h2 class="text-2xl font-semibold mb-3 bg-teal-800 text-gray-100 px-4 py-2 rounded-lg inline-block">
                        {{ __('general.Fatawa') }}
                    </h2>
                    <div class="space-y-6">
                        @foreach ($fatawa as $fatwa)
                            <div class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg hover:scale-105 transition-transform duration-300 cursor-pointer relative group"
                                onclick="window.location='{{ route('fatawa.show', $fatwa) }}'">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-sm text-gray-500">{{ $fatwa->created_at->diffForHumans() }}</span>
                                </div>
                                <h2 class="text-xl font-semibold text-gray-800 group-hover:text-teal-600">
                                    {{ str($fatwa->title)->limit(50, '...', true) }}
                                </h2>
                                <p class="text-sm font-medium text-gray-500 mt-2">
                                    {{ str($fatwa->body)->limit(100, '...', true) }}
                                </p>
                                <p class="text-gray-700 mt-4">
                                    {{ __('general.Category') }}:
                                    <a href="{{ route('category', $fatwa->category) }}"
                                        class="text-blue-600 hover:underline z-10 relative"
                                        onclick="event.stopPropagation();">
                                        {{ $fatwa->category->name }}
                                    </a>
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 text-center">
                        <a href="{{ route('fatawa.index') }}"
                            class="inline-block bg-teal-800 text-white text-sm font-semibold px-3 py-1 rounded-lg hover:bg-teal-900 transition">
                            {{ __('general.More') }}
                        </a>
                    </div>
                </div>

                <!-- Some of the Ahadith Section -->
                <div class="mt-5 border-t border-teal-500 pt-5">
                    <h2 class="text-2xl font-semibold mb-3 bg-teal-800 text-gray-100 px-4 py-2 rounded-lg inline-block">
                        مقطتفات الأحاديث
                    </h2>
                    <div class="space-y-8">
                        <div class="bg-white shadow-lg rounded-xl p-8 flex flex-col justify-center items-center">
                            <p class="text-xl font-medium text-gray-800 leading-relaxed text-center">
                                {إِنَّمَا الأَعْمَالُ بالنِّيَّاتِ وإِنَّمَا لِكُلِّ امْرِئٍ ما نَوَى، فَمَنْ كَانَتْ
                                هِجْرَتُهُ إِلَى اللهِ وَرَسُولِهِ فَهِجْرَتُهُ إِلى اللهِ وَرَسُولِهِ، وَمَنْ كَانَتْ
                                هِجْرَتُهُ لِدُنْيَا يُصِيبُهَا أَو امْرَأَةٍ يَنْكِحُهَا فَهِجْرَتُهُ إِلَى مَا هَاجَرَ
                                إِلَيْهِ}.
                            </p>
                        </div>
                        <div class="bg-white shadow-lg rounded-xl p-8 flex flex-col justify-center items-center">
                            <p class="text-xl font-medium text-gray-800 leading-relaxed text-center">
                                {بُنِيَ الإِسْلاَمُ عَلَى خَمْسٍ: شَهَادَةِ أَنْ لاَ إِلَهَ إِلاَّ اللهُ وَأَنَّ مُحَمَّدًا
                                رَسُولُ اللهِ، وَإِقامِ الصَّلاَةِ، وإِيتَاءِ الزَّكَاةِ، وَحَجِّ البَيْتِ، وَصَوْمِ
                                رَمَضَانَ}.
                            </p>
                        </div>
                        <div class="bg-white shadow-lg rounded-xl p-8 flex flex-col justify-center items-center">
                            <p class="text-xl font-medium text-gray-800 leading-relaxed text-center">
                                {مَنْ أَحْدَثَ فِي أَمْرِنَا هَذَا مَا لَيْسَ مِنْهُ فَهُوَ رَدٌّ}.
                            </p>
                        </div>
                        <div class="bg-white shadow-lg rounded-xl p-8 flex flex-col justify-center items-center">
                            <p class="text-xl font-medium text-gray-800 leading-relaxed text-center">
                                {مَا نَهَيْتُكُمْ عَنْهُ فَاجْتَنِبُوهُ، وَمَا أَمَرْتُكُمْ بِهِ فَأْتُوا مِنْهُ مَا
                                اسْتَطَعْتُمْ، فَإِنَّمَا أَهْلَكَ الَّذِينَ مِنْ قَبْلِكُمْ كَثْرَةُ مَسَائِلِهِمْ
                                واخْتِلاَفُهُمْ عَلَى أَنْبِيَائِهِمْ}.
                            </p>
                        </div>
                        <div class="bg-white shadow-lg rounded-xl p-8 flex flex-col justify-center items-center">
                            <p class="text-xl font-medium text-gray-800 leading-relaxed text-center">
                                {لاَ يُؤْمِنُ أَحَدُكُمْ حَتَّى يُحِبَّ لأَِخِيهِ مَا يُحِبُّ لِنَفْسِهِ}.
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        @endsection


        @section('aside')
            <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
                <h2 class="text-lg mb-3 font-bold">{{ __('general.Suggested') }} :</h2>
                @if (!$suggestedCategories->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('general.Suggested categories') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($suggestedCategories ?? [] as $category)
                                <a href="{{ route('category', $category) }}"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950 hover:scale-105 transition-transform duration-300">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$suggestedLessons->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('general.Suggested lessons') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($suggestedLessons ?? [] as $lesson)
                                <a href="#"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950 hover:scale-105 transition-transform duration-300">
                                    {{ $lesson->title }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$latestLessons->isEmpty())
                    <section class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('general.Latest lessons') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($latestLessons ?? [] as $lesson)
                                <a href="#"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-105 transition-transform duration-300">
                                    {{ $lesson->title }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if (!$famousTeachers->isEmpty())
                    <section>
                        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                            {{ __('general.Famous teachers') }}
                        </h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($famousTeachers ?? [] as $teacher)
                                <a href="#"
                                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-105 transition-transform duration-300">
                                    {{ $teacher->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            </aside>
        @endsection
    </x-container>
</x-app-layout>
