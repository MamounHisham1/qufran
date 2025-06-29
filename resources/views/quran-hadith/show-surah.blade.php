<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="{ read: true }">
            <!-- Toggle Read/Practice Button -->
            <x-primary-button x-on:click="read = !read" x-text="read ? 'اﻹنتقال لصفحة التسميع' : 'اﻹنتقال لصفحة القراءة'"
                class="mb-4 text-lg">
            </x-primary-button>

            <!-- Surah Header - Mushaf Style -->
            <div class="text-center mb-6 bg-gradient-to-b from-amber-50 to-white border-2 border-amber-300 rounded-lg p-4 shadow-lg">
                <div class="border-b border-amber-300 pb-3 mb-3">
                    <h1 class="text-3xl font-bold text-amber-800 mb-2" style="font-family: 'Amiri', 'Scheherazade', serif;">سورة {{ $chapter->name }}</h1>
                    <div class="flex justify-center items-center space-x-6 text-sm text-amber-700">
                        <span class="bg-amber-100 px-2 py-1 rounded">{{ $chapter->place === 'mecca' ? 'مكية' : 'مدنية' }}</span>
                        <span class="bg-amber-100 px-2 py-1 rounded">{{ $chapter->verses }} آية</span>
                    </div>
                </div>
            </div>

            <!-- Reciters Dropdown -->
            <div class="w-full max-w-lg mx-auto mb-6" x-data="recitersDropdown()">
                <div class="relative">
                    <label for="reciter" class="block text-base font-semibold text-gray-800 mb-2">اختر قارئ</label>
                    <div class="relative">
                        <input type="text" x-model="searchQuery" x-on:click="show = true; searchQuery = ''" x-on:keyup="show = true"
                            class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200"
                            placeholder="ابحث او اختر قارئ" dir="rtl" />

                        <ul class="absolute z-50 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200"
                            x-show="show" @click.away="show = false" style="max-height: 200px; overflow-y: auto;">

                            @if (count($chapter->reciters) === 0)
                                <li class="px-4 py-3 text-gray-500 text-center">لا توجد نتائج</li>
                            @else
                                @foreach ($chapter->reciters as $reciter)
                                    <li x-show="filterReciters(searchQuery, '{{ $reciter->name }}')"
                                        class="px-4 py-3 hover:bg-amber-50 cursor-pointer transition-colors duration-200"
                                        @click="selectReciter('{{ $reciter->name }}', '{{ $reciter->pivot->url }}')">
                                        <span class="text-base text-gray-800" dir="rtl">
                                            ({{ $loop->iteration }}) - {{ $reciter->name }}
                                        </span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Audio Player -->
                <div class="mt-6" x-show="selectedReciter">
                    <p class="mb-2 text-center font-semibold text-amber-600" x-text="selectedReciter"></p>
                    <audio id="audio-player" controls class="w-full rounded-lg shadow">
                        <source src="" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>

            <!-- Reading View - True Mushaf Style -->
            <div class="mt-2" x-show="read">
                <!-- Mushaf Page Container -->
                <div class="mushaf-page bg-white border-2 border-amber-200 rounded-lg shadow-xl p-8 mx-auto" style="max-width: 800px; min-height: 600px;">
                    
                    <!-- Bismillah -->
                    @if ($chapter->bismillah)
                        <div class="text-center mb-8">
                            <span class="text-2xl font-bold text-amber-800 mushaf-text" style="letter-spacing: 3px;">
                                بِسۡمِ ٱللَّهِ ٱلرَّحۡمَـٰنِ ٱلرَّحِيمِ
                            </span>
                        </div>
                    @endif

                    <!-- Continuous Mushaf Text -->
                    <div class="mushaf-content text-justify leading-loose" dir="rtl">
                        <p class="mushaf-text text-2xl leading-loose" style="line-height: 3; word-spacing: 0.2em;">
                            @foreach ($verses as $verse)
                                <span class="verse-text">{{ $verse->text }}</span>
                                <span class="verse-number-mushaf" data-verse="{{ $loop->iteration }}">﴿{{ $loop->iteration }}﴾</span>
                                @if (!$loop->last)<span class="verse-space"> </span>@endif
                            @endforeach
                        </p>
                    </div>

                    <!-- Mushaf Footer -->
                    <div class="text-center mt-8 pt-4 border-t border-amber-200">
                        <p class="text-amber-700 font-semibold text-lg mushaf-text">
                            صَدَقَ ٱللَّهُ ٱلۡعَظِيمُ
                        </p>
                    </div>
                </div>

                <!-- Translation Section (Separate from Mushaf) -->
                <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">التفسير الميسر</h3>
                    <div class="space-y-4">
                        @foreach ($verses as $verse)
                            <div class="flex items-start space-x-3 space-x-reverse">
                                <span class="flex-shrink-0 w-8 h-8 bg-amber-600 text-white text-sm font-bold rounded-full flex items-center justify-center">{{ $loop->iteration }}</span>
                                <p class="text-gray-700 leading-relaxed" dir="rtl">
                                    {{ $tafseer[$loop->index]['translation'] }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Practice View -->
            <div id="surah-container" class="flex-grow md:p-5" x-show="!read"></div>
        </main>
    </x-container>

    @push('styles')
    <style>
        /* Import proper Arabic fonts for Mushaf */
        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Scheherazade+New:wght@400;700&display=swap');
        
        .mushaf-text {
            font-family: 'Scheherazade New', 'Amiri', 'Times New Roman', serif;
            font-feature-settings: 'liga', 'dlig', 'calt';
        }
        
        .mushaf-page {
            background: linear-gradient(to bottom, #fefefe 0%, #f9f9f9 100%);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1), inset 0 1px 0 rgba(255,255,255,0.6);
        }
        
        .verse-text {
            color: #2d3748;
        }
        
        .verse-number-mushaf {
            font-size: 0.9em;
            color: #d69e2e;
            font-weight: bold;
            margin: 0 0.3em;
            vertical-align: middle;
        }
        
        .verse-space {
            margin-right: 0.5em;
        }
        
        /* Hover effect for verses */
        .verse-text:hover {
            background: linear-gradient(120deg, rgba(251, 191, 36, 0.1) 0%, rgba(251, 191, 36, 0.05) 100%);
            border-radius: 3px;
            padding: 2px 4px;
            transition: all 0.3s ease;
        }
        
        /* Custom scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #d69e2e;
            border-radius: 3px;
        }
        
        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #b7791f;
        }

        /* Print styles for Mushaf */
        @media print {
            .mushaf-page {
                box-shadow: none;
                border: 1px solid #ccc;
            }
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

                // Process each verse for practice mode with Mushaf styling
                const $mushafContainer = $('<div>', {
                    'class': 'mushaf-page bg-white border-2 border-amber-200 rounded-lg shadow-xl p-8 mx-auto',
                    'style': 'max-width: 800px; min-height: 600px;'
                });

                const $mushafContent = $('<div>', {
                    'class': 'mushaf-content text-justify leading-loose',
                    'dir': 'rtl'
                });

                const $mushafText = $('<p>', {
                    'class': 'mushaf-text text-2xl leading-loose',
                    'style': 'line-height: 3; word-spacing: 0.2em;'
                });

                $.each(data, function(index, verse) {
                    // Split verse into words for practice mode
                    const words = verse.text.split(' ');

                    // Function to reveal/hide words
                    function revealWord($word, event) {
                        if (event) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        $word.addClass('revealed');

                        if ($word.data('revealTimer')) {
                            clearTimeout($word.data('revealTimer'));
                        }

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
                            'class': 'blur-word inline-block mx-1 cursor-pointer select-none hover:text-amber-600 transition-colors duration-200'
                        });

                        // Touch and mouse events
                        let touchTimeout;
                        $wordSpan.on('touchstart', function(e) {
                            if (touchTimeout) {
                                clearTimeout(touchTimeout);
                            }
                            revealWord($(this), e);
                            touchTimeout = setTimeout(function() {
                                $(e.currentTarget).removeClass('revealed');
                            }, 3000);
                        });

                        $wordSpan.on('touchmove', function(e) {
                            e.preventDefault();
                            const touchedElement = document.elementFromPoint(
                                e.originalEvent.touches[0].clientX,
                                e.originalEvent.touches[0].clientY
                            );
                            if (touchedElement && $(touchedElement).hasClass('blur-word')) {
                                revealWord($(touchedElement), e);
                            }
                        });

                        $wordSpan.on('touchend', function(e) {
                            if (touchTimeout) {
                                clearTimeout(touchTimeout);
                            }
                            touchTimeout = setTimeout(function() {
                                $(e.currentTarget).removeClass('revealed');
                            }, 2000);
                        });

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

                        $mushafText.append($wordSpan);
                        $mushafText.append($('<span>', { 'html': '&nbsp;' }));
                    });

                    // Add verse number in Mushaf style
                    let $verseNumber = index + 1;
                    $mushafText.append(`<span class="verse-number-mushaf" data-verse="${$verseNumber}">﴿${$verseNumber}﴾</span>`);
                    
                    if (index < data.length - 1) {
                        $mushafText.append($('<span>', { 'class': 'verse-space', 'html': ' ' }));
                    }
                });

                $mushafContent.append($mushafText);
                $mushafContainer.append($mushafContent);
                
                // Add Mushaf footer
                $mushafContainer.append(`
                    <div class="text-center mt-8 pt-4 border-t border-amber-200">
                        <p class="text-amber-700 font-semibold text-lg mushaf-text">
                            صَدَقَ ٱللَّهُ ٱلۡعَظِيمُ
                        </p>
                    </div>
                `);

                $container.append($mushafContainer);
            });
        </script>
    @endpush
</x-app-layout>
