<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="{ read: true }">
            <h1 class="text-2xl font-bold mb-5"></h1>
            <button x-on:click="read = ! read" x-text="read ? 'اﻹنتقال لصفحة التسميع' : 'اﻹنتقال لصفحة القراءة'"
                class="text-blue-600 focus:border-none"></button>
            <div class="mt-2" x-show="read == true">
                <ul>
                    @foreach ($hadiths as $hadith)
                        <li class="text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg">
                            <span class="font-bold text-xl">({{ $hadith['hadithnumber'] }})</span>
                            <span class="block group p-3">
                                <span class="font-bold text-xl">{{ $hadith['text'] }}</span>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div id="hadith-container" class="max-w-2xl mx-auto" x-show="read == false"></div>
        </main>
    </x-container>

    @push('scripts')
        <script>
            const data = @json($hadiths);

            const $container = $('#hadith-container');
            $container.empty(); // Clear previous content

            // Process each hadith
            $.each(data, function(index, hadith) {
                // Create paragraph for hadith
                const $hadithParagraph = $('<p>', {
                    'class': 'text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg'
                });

                // Split hadith into words
                const words = hadith.text.split(' ');

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

                    $hadithParagraph.append($wordSpan);

                    // Add space between words
                    $hadithParagraph.append($('<span>', {
                        'html': '&nbsp;'
                    }));
                });

                let $hadithNumber = data[index].hadithnumber;
                $hadithParagraph.append(`<span class="text-xl"> (${$hadithNumber})</span>`);
                $container.append($hadithParagraph);
            });
        </script>
    @endpush

</x-app-layout>
