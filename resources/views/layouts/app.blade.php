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

    <script>
        function toastNotification() {
            return {
                visible: false,
                init() {
                    const message = "{{ session('message') }}";
                    if (message) {
                        $('#toast-message').text(message);
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
    </script>
    @stack('scripts')
</body>

</html>
