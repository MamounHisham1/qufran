<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
        }

        /* Custom CSS for the blurred word transition */
        .blur-word {
            filter: blur(5px);
            transition: filter 0.3s ease;
        }

        .blur-word.revealed {
            filter: blur(0);
        }
    </style>
    <!-- Scripts -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
        @include('layouts.navigation')

        <!-- Toast Notification -->
        <div x-data="toastNotification()" x-show="visible" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed top-4 right-4 z-50 bg-green-500 text-white p-4 rounded-lg shadow-lg" style="display: none;">
            <div class="flex items-center justify-between gap-5">
                <span id="toast-message" class="mr-4"></span>
                <button @click="close()" class="text-white hover:text-green-100 focus:outline-none">
                    ✕
                </button>
            </div>
        </div>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <div x-data="adhkarReminder()">
            <!-- Toggle Button -->
            <button
                class="fixed left-0 z-50 rounded-r-full mt-2 py-8 lg:px-4 px-2 bg-teal-700 hover:bg-teal-800 text-white shadow-lg transform hover:translate-x-1 transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-opacity-50"
                x-show="!toggle"
                x-on:click="toggle = true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0">
            </button>

            <!-- Sidebar Panel -->
            <div class="fixed left-0 z-50 rounded-r-lg mt-2 bg-teal-700 bg-opacity-85 text-white shadow-2xl p-6 h-auto max-w-sm transform transition-all duration-300 ease-in-out backdrop-blur-sm border-r border-teal-600"
                x-show="toggle"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full">

                <!-- Close Button -->
                <button x-on:click="toggle = false"
                    class="absolute right-3 top-3 p-2 rounded-full hover:bg-teal-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                    <span class="text-white font-medium">✕</span>
                </button>

                <!-- Content -->
                <div class="mt-8">
                    <p class="text-xl font-bold mb-4 text-white" x-html="message"></p>
                    <a :href="url" class="block text-white hover:text-teal-200 transition-colors duration-200 font-medium underline decoration-2 underline-offset-4">
                        اقرأ الأذكار الآن 
                    </a>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        <div class="flex flex-col md:flex-row">
            @yield('content')
            @yield('aside')
        </div>
        @include('layouts.footer')
    </div>

    <div id="initial-loader" class="fixed inset-0 bg-white flex items-center justify-center z-50">
        <div class="h-20 w-20 border-8 border-gray-300 border-t-teal-600 rounded-full animate-spin"></div>
    </div>

    <script>
        $(window).on('load', function() {
            $('#initial-loader').fadeOut('slow');
        });

        // Fallback to hide loader if it's been showing too long
        setTimeout(function() {
            $('#initial-loader').fadeOut('slow');
        }, 5000); // 5 second fallback

        // Toaster
        function toastNotification() {
            return {
                visible: false,
                init() {
                    const toggle = "{{ session('toggle') }}";
                    if (toggle) {
                        $('#toast-toggle').text(toggle);
                        this.visible = true;

                        setTimeout(() => {
                            this.close();
                        }, 5000);
                    }
                },
                close() {
                    this.visible = false;
                }
            }
        }

        // Adhkar Reminder
        function adhkarReminder() {
            return {
                toggle: false,
                message: '',
                url: '',
                show: false,
                init() {
                    const time = new Date().getHours();
                    if (time >= 4 && time <= 12) {
                        this.message = 'اقرأ الأذكار الصباحية';
                        this.url = '/adhkar/1';
                        this.show = true;
                    } else if (time >= 12 && time <= 18) {
                        this.message = 'اقرأ الأذكار المسائية';
                        this.url = '/adhkar/2';
                        this.show = true;
                    }
                }
            }
        }
    </script>
    @stack('scripts')
</body>

</html>
