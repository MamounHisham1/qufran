<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="home()">
            <!-- Surah Title -->
            <h1 class="text-2xl font-bold mb-5" x-text="surah['name']"></h1>

            <!-- Toggle Read/Practice Button -->
            <button x-on:click="read = !read" x-text="read ? 'اﻹنتقال لصفحة التسميع' : 'اﻹنتقال لصفحة القراءة'"
                class="text-blue-600 mb-4">
            </button>

            <!-- Reading View -->
            <div class="mt-2" x-show="read">
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

            <!-- Practice View -->
            <div id="surah-container" class="flex-grow md:p-5" x-show="!read"></div>
        </main>
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
