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

        /* تحسين زر تذكير الأذكار */
        .adhkar-reminder-btn {
            position: fixed;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 50;
            padding: 12px 8px;
            border-radius: 0 12px 12px 0;
            background: linear-gradient(135deg, #0d9488 0%, #115e59 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .adhkar-reminder-btn:hover {
            transform: translateY(-50%) translateX(5px);
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
        }

        .adhkar-reminder-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .adhkar-reminder-btn:hover::before {
            transform: translateX(0);
        }

        .adhkar-reminder-btn .icon {
            font-size: 1.5rem;
            margin-left: 8px;
        }

        .adhkar-reminder-btn .tooltip {
            position: absolute;
            left: 100%;
            top: 50%;
            transform: translateY(-50%);
            background-color: #134e4a;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin-left: 10px;
        }

        .adhkar-reminder-btn:hover .tooltip {
            opacity: 1;
            margin-left: 15px;
        }

        /* تحسين لوحة الأذكار الجانبية */
        .adhkar-sidebar {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.95) 0%, rgba(15, 118, 110, 0.95) 100%);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .adhkar-sidebar-content {
            position: relative;
            z-index: 1;
        }

        .adhkar-sidebar-content::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            z-index: -1;
            opacity: 0.5;
        }

        .adhkar-link {
            position: relative;
            display: inline-block;
            color: white;
            font-weight: 600;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-top: 10px;
        }

        .adhkar-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .adhkar-link::after {
            content: '→';
            margin-right: 8px;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .adhkar-link:hover::after {
            transform: translateX(4px);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(13, 148, 136, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(13, 148, 136, 0);
            }
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

        <div x-data="adhkarReminder()" x-show="show">
            <!-- زر تذكير الأذكار المحسن -->
            <button class="adhkar-reminder-btn pulse-animation" x-show="!toggle" x-on:click="toggle = true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span class="tooltip" x-text="timeOfDay === 'morning' ? 'أذكار الصباح' : 'أذكار المساء'"></span>
            </button>

            <!-- لوحة الأذكار الجانبية المحسنة -->
            <div class="fixed left-0 z-50 rounded-r-lg mt-2 adhkar-sidebar p-6 h-auto max-w-sm transform transition-all duration-300 ease-in-out border-r border-teal-600"
                x-show="toggle" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full">

                <!-- زر الإغلاق -->
                <button x-on:click="toggle = false"
                    class="absolute right-3 top-3 p-2 rounded-full hover:bg-teal-600 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">
                    <span class="text-white font-medium">✕</span>
                </button>

                <!-- المحتوى -->
                <div class="mt-8 adhkar-sidebar-content">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white mr-3" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <p class="text-xl font-bold text-white" x-html="message"></p>
                    </div>

                    <p class="text-white text-opacity-90 mb-4">
                        حافظ على قراءة الأذكار اليومية للحصول على الأجر والبركة في يومك
                    </p>

                    <a :href="url" class="adhkar-link">
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
                timeOfDay: '',
                init() {
                    const time = new Date().getHours();

                    // Morning adhkar (4 AM to 11:59 AM)
                    if (time >= 4 && time < 12) {
                        this.message = 'حان وقت أذكار الصباح';
                        this.url = '/adhkar/1';
                        this.show = true;
                        this.timeOfDay = 'morning';
                    }
                    // Evening adhkar (After Asr, roughly 3 PM to 10:59 PM)
                    else if (time >= 15 && time < 23) {
                        this.message = 'حان وقت أذكار المساء';
                        this.url = '/adhkar/2';
                        this.show = true;
                        this.timeOfDay = 'evening';
                    }
                    // Don't show during other times
                    else {
                        this.show = false;
                    }
                }
            }
        }
    </script>
    @stack('scripts')
</body>

</html>
