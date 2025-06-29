<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="{ read: true }">
            <!-- Toggle Read/Practice Button -->
            <x-primary-button x-on:click="read = !read" x-text="read ? 'اﻹنتقال لصفحة التسميع' : 'اﻹنتقال لصفحة القراءة'"
                class="mb-4 text-lg">
            </x-primary-button>

            <!-- Surah Header - Mushaf Style -->
            <div class="text-center mb-8 bg-gradient-to-b from-green-50 to-white border border-green-200 rounded-lg p-6 shadow-lg">
                <div class="border-b-2 border-green-300 pb-4 mb-4">
                    <h1 class="text-4xl font-bold text-green-800 mb-2" style="font-family: 'Amiri', 'Times New Roman', serif;">سورة {{ $chapter->name }}</h1>
                    <div class="flex justify-center items-center space-x-4 text-sm text-green-600">
                        <span class="bg-green-100 px-3 py-1 rounded-full">{{ $chapter->place === 'mecca' ? 'مكية' : 'مدنية' }}</span>
                        <span class="bg-green-100 px-3 py-1 rounded-full">{{ $chapter->verses }} آية</span>
                        <span class="bg-green-100 px-3 py-1 rounded-full">السورة {{ $chapter->number }}</span>
                    </div>
                </div>
            </div>

            <!-- Reciters Dropdown -->
            <div class="w-full max-w-lg mx-auto mb-8" x-data="recitersDropdown()">
                <!-- Dropdown -->
                <div class="relative">
                    <label for="reciter" class="block text-base font-semibold text-gray-800 mb-2">اختر قارئ</label>
                    <div class="relative">
                        <input type="text" x-model="searchQuery" x-on:click="show = true; searchQuery = ''" x-on:keyup="show = true"
                            class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200"
                            placeholder="ابحث او اختر قارئ" dir="rtl" />

                        <!-- Dropdown List -->
                        <ul class="absolute z-50 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200"
                            x-show="show" @click.away="show = false" style="max-height: 200px; overflow-y: auto;">

                            @if (count($chapter->reciters) === 0)
                                <li class="px-4 py-3 text-gray-500 text-center">لا توجد نتائج</li>
                            @else
                                @foreach ($chapter->reciters as $reciter)
                                    <li x-show="filterReciters(searchQuery, '{{ $reciter->name }}')"
                                        class="px-4 py-3 hover:bg-green-50 cursor-pointer transition-colors duration-200"
                                        @click="selectReciter('{{ $reciter->name }}', '{{ $reciter->pivot->url }}')">
                                        <span class="text-base text-gray-800" dir="rtl">
                                            ({{ $loop->iteration }})
                                            - {{ $reciter->name }}
                                        </span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Audio Player -->
                <div class="mt-6" x-show="selectedReciter">
                    <p class="mb-2 text-center font-semibold text-green-600" x-text="selectedReciter"></p>
                    <audio id="audio-player" controls class="w-full rounded-lg shadow">
                        <source src="" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>

            <!-- Reading View - Mushaf Style -->
            <div class="mt-2" x-show="read">
                <!-- Bismillah -->
                @if ($chapter->bismillah)
                    <div class="text-center mb-8 p-6 bg-gradient-to-r from-amber-50 via-white to-amber-50 border border-amber-200 rounded-lg">
                        <span class="text-3xl font-bold text-amber-800" style="font-family: 'Amiri', 'Times New Roman', serif; letter-spacing: 2px;">
                            بِسْمِ ٱللَّهِ ٱلرَّحْمَـٰنِ ٱلرَّحِيمِ
                        </span>
                    </div>
                @endif

                <!-- Verses Container - Mushaf Style -->
                <div class="bg-gradient-to-b from-green-50 to-white border border-green-200 rounded-lg p-8 shadow-lg">
                    <div class="space-y-6">
                        @foreach ($verses as $verse)
                            <div class="verse-container relative">
                                <!-- Verse Text -->
                                <p class="text-center leading-loose text-2xl font-medium text-gray-800 mb-4" 
                                   style="font-family: 'Amiri', 'Times New Roman', serif; line-height: 2.5; word-spacing: 0.3em;"
                                   dir="rtl">
                                    {{ $verse->text }}
                                    <span class="verse-number inline-block mx-2 w-8 h-8 bg-green-600 text-white text-sm font-bold rounded-full leading-8 text-center align-middle">{{ $loop->iteration }}</span>
                                </p>

                                <!-- Tafsir/Translation -->
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-3">
                                    <p class="text-gray-700 text-base leading-relaxed" dir="rtl">
                                        {{ $tafseer[$loop->index]['translation'] }}
                                    </p>
                                </div>

                                <!-- Verse Separator -->
                                @if (!$loop->last)
                                    <div class="flex justify-center my-6">
                                        <div class="w-24 h-px bg-gradient-to-r from-transparent via-green-300 to-transparent"></div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Surah Footer -->
                <div class="text-center mt-8 p-4 bg-gradient-to-b from-white to-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-700 font-semibold">
                        صدق الله العظيم
                    </p>
                    <p class="text-sm text-green-600 mt-2">
                        سورة {{ $chapter->name }} - {{ $chapter->verses }} آية
                    </p>
                </div>
            </div>

            <!-- Practice View -->
            <div id="surah-container" class="flex-grow md:p-5" x-show="!read"></div>
        </main>
    </x-container>

    @push('styles')
    <style>
        /* Import Amiri font for better Arabic typography */
        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap');
        
        .verse-number {
            font-feature-settings: 'tnum';
        }
        
        /* Custom scrollbar for dropdown */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Verse container hover effect */
        .verse-container:hover {
            background: linear-gradient(to right, rgba(34, 197, 94, 0.05), rgba(34, 197, 94, 0.02), rgba(34, 197, 94, 0.05));
            border-radius: 8px;
            transition: background 0.3s ease;
        }
    </style>
    @endpush

    @push('scripts')
        <script>
            function recitersDropdown() {
                return {
                    show: false,
                    searchQuery: '',
                    selectedReciter: '',

                    filterReciters(query, reciterName) {
                        if (!query) return true;
                        query = query.trim();
                        reciterName = reciterName;
                        return reciterName.includes(query);
                    },

                    selectReciter(name, audioUrl) {
                        this.selectedReciter = name;
                        this.searchQuery = name;
                        this.show = false;

                        const player = document.getElementById('audio-player');
                        if (audioUrl) {
                            player.src = audioUrl;
                            player.load();
                            player.play();
                        }
                    }
                };
            }

            $(document).ready(function() {

                const $container = $('#surah-container');
                const data = @js($verses)

                // Process each verse for practice mode
                $.each(data, function(index, verse) {
                    // Create paragraph for verse
                    const $verseParagraph = $('<p>', {
                        'class': 'text-center font-bold text-2xl leading-loose bg-gradient-to-b from-green-50 to-white p-6 rounded-lg my-6 shadow-lg border border-green-200',
                        'style': 'font-family: "Amiri", "Times New Roman", serif; line-height: 2.5; word-spacing: 0.3em;',
                        'dir': 'rtl'
                    });

                    // Split verse into words
                    const words = verse.text.split(' ');

                    // Function to reveal/hide words
                    function revealWord($word, event) {
                        // Prevent default to stop scrolling interference
                        if (event) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        // Reveal the word
                        $word.addClass('revealed');

                        // Clear any existing timer
                        if ($word.data('revealTimer')) {
                            clearTimeout($word.data('revealTimer'));
                        }

                        // Set a new timer to blur after 3 seconds
                        const timer = setTimeout(function() {
                            $word.removeClass('revealed');
                            $word.removeData('revealTimer');
                        }, 3000);

                        $word.data('revealTimer', timer);
                    }

                    // Create spans for each word
                    $.each(words, function(wordIndex, word) {
                        const $wordSpan = $('<span>', {
                            'text': word,
                            'class': 'blur-word inline-block mx-1 cursor-pointer select-none -webkit-user-select-none hover:text-green-600 transition-colors duration-200'
                        });

                        // Touch events
                        let touchTimeout;
                        $wordSpan.on('touchstart', function(e) {
                            // Clear any previous timeout
                            if (touchTimeout) {
                                clearTimeout(touchTimeout);
                            }

                            // Reveal word immediately
                            revealWord($(this), e);

                            // Set a timeout to hide the word if touch ends without moving
                            touchTimeout = setTimeout(function() {
                                $(e.currentTarget).removeClass('revealed');
                            }, 3000);
                        });

                        $wordSpan.on('touchmove', function(e) {
                            // Prevent default to stop scrolling
                            e.preventDefault();

                            // Find the element under the touch point
                            const touchedElement = document.elementFromPoint(
                                e.originalEvent.touches[0].clientX,
                                e.originalEvent.touches[0].clientY
                            );

                            // If the touched element is a blur-word, reveal it
                            if (touchedElement && $(touchedElement).hasClass(
                                    'blur-word')) {
                                revealWord($(touchedElement), e);
                            }
                        });

                        $wordSpan.on('touchend', function(e) {
                            // Clear any existing timeout
                            if (touchTimeout) {
                                clearTimeout(touchTimeout);
                            }

                            // Hide the word after a short delay
                            touchTimeout = setTimeout(function() {
                                $(e.currentTarget).removeClass('revealed');
                            }, 2000);
                        });

                        // Mouse events for desktop
                        $wordSpan.on('mouseenter', function(e) {
                            revealWord($(this), e);
                        });

                        $wordSpan.on('mouseleave', function(e) {
                            setTimeout(function() {
                                $(e.currentTarget).removeClass('revealed');
                            }, 2000);
                            const timer = $(this).data('revealTimer');
                            if (timer) {
                                clearTimeout(timer);
                                $(this).removeData('revealTimer');
                            }
                        });

                        $verseParagraph.append($wordSpan);

                        // Add space between words
                        $verseParagraph.append($('<span>', {
                            'html': '&nbsp;'
                        }));
                    });

                    // Add verse number in Mushaf style
                    let $verseNumber = index + 1;
                    $verseParagraph.append(`<span class="inline-block mx-2 w-8 h-8 bg-green-600 text-white text-sm font-bold rounded-full leading-8 text-center align-middle">${$verseNumber}</span>`);
                    $container.append($verseParagraph);

                });
            });
        </script>
    @endpush
</x-app-layout>
