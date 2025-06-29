<x-app-layout>
    <x-container>
        <h1 class="text-3xl font-bold mb-5 py-2 bg-gray-200 rounded-md text-center mt-3">{{ __('general.' . $metadata['name']) }}</h1>
        <div class="my-2">
            <ul>
                @foreach ($metadata['sections'] as $key => $section)
                    <li>
                        @php
                            $number = $book == 'ibnmajah' ? $key : $key + 1;
                            
                            // تحديد ملف الترجمة المناسب بناءً على نوع الكتاب
                            $translationFile = match($book) {
                                'bukhari' => 'bukhari',
                                'muslim' => 'muslim',
                                'abudawud' => 'abudawud',
                                'tirmidhi' => 'tirmidhi',
                                'nasai' => 'nasai',
                                'ibnmajah' => 'ibnmajah',
                                'malik' => 'malik',
                                'nawawi' => 'nawawi',
                                'qudsi' => 'qudsi',
                                'dehlawi' => 'dehlawi',
                                default => 'bukhari'
                            };
                            
                            // تنظيف النص من أي مسافات زائدة قد تؤثر على المفتاح
                            $cleanSection = trim($section);
                        @endphp
                        <a href="{{ route('hadith.section', ['book' => $book, 'section' => $number]) }}"
                            class="block group p-4 hover:bg-teal-50 border-b text-center rounded-lg bg-gray-100 hover:shadow-lg border-teal-400 transition-all duration-300 ease-in-out mb-3 transform hover:-translate-y-1">
                            <span class="font-bold text-xl group-hover:text-teal-600">({{ $key + 1 }}) -
                                {{ __("$translationFile.$cleanSection") }}</span>
                            <p class="text-sm text-gray-500 mt-2 ms-2">
                                <span class="inline-block bg-gray-200 px-2 py-1 rounded mr-1">{{ __('general.From') }}</span>
                                <span class="font-semibold">{{ $metadata['section_details'][$key]['hadithnumber_first'] }}</span>
                                <span class="inline-block bg-gray-200 px-2 py-1 rounded mx-1">{{ __('general.To') }}</span>
                                <span class="font-semibold">{{ $metadata['section_details'][$key]['hadithnumber_last'] }}</span>
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-container>
</x-app-layout>
