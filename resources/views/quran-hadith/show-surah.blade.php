<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="home()">
            <h1 class="text-2xl font-bold mb-5" x-text="surah['name']"></h1>
            <button x-on:click="read = ! read" x-text="read ? 'اﻹنتقال لصفحة التسميع' : 'اﻹنتقال لصفحة القراءة'"
                class="text-blue-600"></button>
            <div class="mt-2" x-show="read == true">
                <ul>
                    <template x-for="(ayah, key) in surah">
                        <li class="text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg">
                            <span class="block group p-3">
                                <span class="font-bold text-xl" x-text="ayah.text_uthmani"></span>
                                <span>(<span class="font-bold text-xl" x-text="key + 1"></span>)</span>
                            </span>
                        </li>
                    </template>
                </ul>
            </div>

            <div id="surah-container" class="flex-grow md:p-5" x-show="read == false"></div>
        </main>

            {{-- <div class="max-w-4xl mx-auto bg-gray-800 border-4 text-white border-gray-700 rounded-lg shadow-lg p-6">
              <!-- Header -->
              <div class="text-center border-b-4 border-gray-600 pb-4 mb-6">
                <h1 class="text-4xl font-bold mb-2">سورة الدخان</h1>
                <p class="text-lg">الجزء ٢٥، نصف الحزب ٥٠</p>
              </div>
          
              <!-- Bismillah -->
              <div class="text-center text-2xl mb-6">
                <p class="mb-2">﷽</p>
              </div>
          
              <!-- Verses -->
              <div class="text-xl leading-relaxed text-center">
                <p class="inline-block mx-2 text-white">
                حمٓ<span class="text-gray-400 ml-2">(١)</span>
                </p>
                <p class="inline-block mx-2 text-white">
                وَالْكِتَابِ الْمُبِينِ<span class="text-gray-400 ml-2">(٢)</span>
                </p>
                <p class="inline-block mx-2 text-white">
                إِنَّا أَنزَلْنَاهُ فِي لَيْلَةٍ مُّبَارَكَةٍ ۚ إِنَّا كُنَّا مُنذِرِينَ<span class="text-gray-400 ml-2">(٣)</span>
                </p>
                <p class="inline-block mx-2 text-white">
                فِيهَا يُفْرَقُ كُلُّ أَمْرٍ حَكِيمٍ<span class="text-gray-400 ml-2">(٤)</span>
                </p>
                <p class="inline-block mx-2 text-white">
                أَمْرًا مِّنْ عِندِنَا ۚ إِنَّا كُنَّا مُرْسِلِينَ<span class="text-gray-400 ml-2">(٥)</span>
                </p>
                <p class="inline-block mx-2 text-white">
                رَحْمَةً مِّن رَّبِّكَ ۚ إِنَّهُ هُوَ السَّمِيعُ الْعَلِيمُ<span class="text-gray-400 ml-2">(٦)</span>
                </p>
              </div>
          
              <!-- Footer Decoration -->
              <div class="mt-6 border-t-4 border-gray-600 pt-4 text-center">
                <p class="text-lg">صفحة ٤٦٩</p>
              </div>
            </div> --}}

    </x-container>
    @push('scripts')
        <script>
            function home() {
                return {
                    surah: [],
                    read: true,
                    init() {
                        const self = this;
                        $.ajax({
                            type: "GET",
                            url: 'https://api.quran.com/api/v4/quran/verses/uthmani?chapter_number=' +
                                {{ $id }},
                            success: function(response) {
                                self.surah = response.verses;
                            },
                        });
                    }
                };
            }

            $.ajax({
                url: "https://api.quran.com/api/v4/quran/verses/uthmani?chapter_number=" + {{ $id }},
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const $container = $('#surah-container');
                    $container.empty(); // Clear previous content

                    // Process each ayah
                    $.each(data.verses, function(index, ayah) {
                        // Create paragraph for ayah
                        const $ayahParagraph = $('<p>', {
                            'class': 'text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg'
                        });

                        // Split ayah into words
                        const words = ayah.text_uthmani.split(' ');

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

                            $ayahParagraph.append($wordSpan);

                            // Add space between words
                            $ayahParagraph.append($('<span>', {
                                'html': '&nbsp;'
                            }));
                        });

                        let $ayahNumber = ayah.verse_key.split(':')[1];
                        $ayahParagraph.append(`<span class="text-xl"> (${$ayahNumber})</span>`);
                        $container.append($ayahParagraph);

                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching Surah:', error);
                }
            });
        </script>
    @endpush
</x-app-layout>
