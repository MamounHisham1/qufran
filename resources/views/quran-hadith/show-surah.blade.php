<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="{ read: true }">
            <!-- Toggle Read/Practice Button -->
            <x-primary-button x-on:click="read = !read" x-text="read ? 'اﻹنتقال لصفحة التسميع' : 'اﻹنتقال لصفحة القراءة'"
                class="mb-4 text-lg">
            </x-primary-button>

            <!-- Surah Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-800">سورة {{ $chapter->name }}</h1>
            </div>

            <!-- Reciters Dropdown -->
            <div class="w-full max-w-lg mx-auto mb-8" x-data="recitersDropdown()">
                <!-- Dropdown -->
                <div class="relative">
                    <label for="reciter" class="block text-base font-semibold text-gray-800 mb-2">اختر قارئ</label>
                    <div class="relative">
                        <input type="text" x-model="searchQuery" x-on:click="show = true; searchQuery = ''" x-on:keyup="show = true"
                            class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            placeholder="ابحث او اختر قارئ" dir="rtl" />

                        <!-- Dropdown List -->
                        <ul class="absolute z-50 mt-2 w-full bg-white rounded-lg shadow-xl border border-gray-200"
                            x-show="show" @click.away="show = false" style="max-height: 200px; overflow-y: auto;">

                            @if (count($chapter->reciters) === 0)
                                <li class="px-4 py-3 text-gray-500 text-center">لا توجد نتائج</li>
                            @else
                                @foreach ($chapter->reciters as $reciter)
                                    <li x-show="filterReciters(searchQuery, '{{ $reciter->name }}')"
                                        class="px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors duration-200"
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

            @if ($chapter->bismillah)
                <div class="text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg">
                    <span class="block group p-3">
                        <span class="font-bold text-2xl">بِسْمِ ٱللَّهِ ٱلرَّحْمَـٰنِ ٱلرَّحِيمِ</span>
                    </span>
                </div>
            @endif

            <!-- Reading View -->
            <div class="mt-2" x-show="read">
                <ul>
                    @foreach ($verses as $verse)
                        <li class="text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg">
                            <span class="block group p-3">
                                <span class="font-bold text-2xl">{{ $verse->text }}</span>
                                <span class="font-bold text-xl">({{ $loop->iteration }})</span>
                            </span>
                            <div>
                                {{ $tafseer[$loop->index]['translation'] }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Practice View -->
            <div id="surah-container" class="flex-grow md:p-5" x-show="!read"></div>
        </main>
    </x-container>
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

                // Process each verse
                $.each(data, function(index, verse) {
                    // Create paragraph for verse
                    const $verseParagraph = $('<p>', {
                        'class': 'text-center font-bold text-xl leading-10 bg-gray-100 p-4 rounded-lg my-4 shadow-lg'
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
                            'class': 'blur-word inline-block mx-1 cursor-pointer select-none -webkit-user-select-none'
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

                    let $verseNumber = index + 1;
                    $verseParagraph.append(`<span class="text-xl"> (${$verseNumber})</span>`);
                    $container.append($verseParagraph);

                });
            });
        </script>
    @endpush
</x-app-layout>
