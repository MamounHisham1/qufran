<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="home()">
            <h1 class="text-2xl font-bold mb-5" x-text="surah['name']"></h1>
            <button x-on:click="read = ! read" x-text="read ? 'اﻹنتقال لصفحة التسميع' : 'اﻹنتقال لصفحة القراءة'"
                class="text-blue-600"></button>
            <div class="mt-2" x-show="read == true">
                <ul class="flex flex-wrap items-center gap-5">
                    <template x-for="(ayah, key) in surah">
                        <li>
                            <span class="block group p-3">
                                <span class="font-bold text-xl group-hover:text-teal-600"
                                    x-text="ayah.text_uthmani"></span>
                                <span>(<span class="font-bold text-xl group-hover:text-teal-600"
                                        x-text="key + 1"></span>)</span>
                            </span>
                        </li>
                    </template>
                </ul>
            </div>

            <div id="surah-container" class="max-w-2xl mx-auto" x-show="read == false"></div>
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
            fetch('https://api.quran.com/api/v4/quran/verses/uthmani?chapter_number=' + {{ $id }})
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('surah-container');

                    // Process each ayah
                    data.verses.forEach(ayah => {
                        // Create paragraph for ayah
                        const ayahParagraph = document.createElement('p');
                        ayahParagraph.classList.add(
                            'text-center',
                            'text-xl',
                            'leading-8',
                            'bg-white',
                            'p-4',
                            'rounded-lg',
                            'my-4',
                            'shadow-md'
                        );

                        // Split ayah into words
                        const words = ayah.text_uthmani.split(' ');

                        // Create spans for each word
                        words.forEach(word => {
                            const wordSpan = document.createElement('span');
                            wordSpan.textContent = word;
                            wordSpan.classList.add('blur-word', 'inline-block', 'mx-1', 'cursor-pointer',
                                'select-none', '-webkit-user-select-none');

                            // Reveal function to be used by both mouse and touch events
                            const revealWord = function(e) {
                                // Prevent default to stop scrolling interference
                                e.preventDefault();
                                e.stopPropagation();

                                // Reveal the word
                                this.classList.add('revealed');

                                // Set a new timer to blur after 3 seconds
                                if (this.revealTimer) {
                                    clearTimeout(this.revealTimer); // Clear previous timer if it exists
                                }
                                this.revealTimer = setTimeout(() => {
                                    this.classList.remove('revealed');
                                    this.revealTimer =
                                        null; // Reset the timer after the word is blurred
                                }, 3000);
                            };

                            // Touch events
                            let touchTimeout;
                            wordSpan.addEventListener('touchstart', function(e) {
                                // Clear any previous timeout
                                if (touchTimeout) {
                                    clearTimeout(touchTimeout);
                                }

                                // Reveal word immediately
                                revealWord.call(this, e);

                                // Set a timeout to hide the word if touch ends without moving
                                touchTimeout = setTimeout(() => {
                                    this.classList.remove('revealed');
                                }, 3000);
                            }, {
                                passive: false
                            });

                            wordSpan.addEventListener('touchmove', function(e) {
                                // Prevent default to stop scrolling
                                e.preventDefault();

                                // Find the element under the touch point
                                const touchedElement = document.elementFromPoint(
                                    e.touches[0].clientX,
                                    e.touches[0].clientY
                                );

                                // If the touched element is a blur-word, reveal it
                                if (touchedElement && touchedElement.classList.contains(
                                        'blur-word')) {
                                    revealWord.call(touchedElement, e);
                                }
                            }, {
                                passive: false
                            });

                            wordSpan.addEventListener('touchend', function(e) {
                                // Clear any existing timeout
                                if (touchTimeout) {
                                    clearTimeout(touchTimeout);
                                }

                                // Hide the word after a short delay
                                touchTimeout = setTimeout(() => {
                                    this.classList.remove('revealed');
                                }, 3000);
                            }, {
                                passive: false
                            });

                            // Mouse events for desktop
                            wordSpan.addEventListener('mouseenter', revealWord);
                            wordSpan.addEventListener('mouseleave', function() {
                                this.classList.remove('revealed');
                                if (this.revealTimer) {
                                    clearTimeout(this
                                        .revealTimer); // Only clear the current word's timer
                                    this.revealTimer = null;
                                }
                            });

                            ayahParagraph.appendChild(wordSpan);

                            // Add space between words
                            const spaceSpan = document.createElement('span');
                            spaceSpan.innerHTML = '&nbsp;';
                            ayahParagraph.appendChild(spaceSpan);
                        });

                        container.appendChild(ayahParagraph);
                    });
                })
                .catch(error => {
                    console.error('Error fetching Surah:', error);
                });
        </script>
    @endpush
</x-app-layout>
