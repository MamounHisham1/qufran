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
            *{
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

        @stack('scripts')
    </body>
</html>
