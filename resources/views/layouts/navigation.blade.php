<?php
$links = [
    [
        'name' => __('Dashboard'),
        'href' => route('dashboard'),
        'active' => request()->routeIs('dashboard'),
        'when' => fn() => true,
    ],
    [
        'name' => __('Lessons'),
        'href' => route('lessons.index'),
        'active' => request()->routeIs('lessons.index'),
        'when' => fn() => true,
    ],
    [
        'name' => __('Fatawa'),
        'href' => route('fatawa.index'),
        'active' => request()->routeIs('fatawa.index'),
        'when' => fn() => true,
    ],
    [
        'name' => __('Quran-Hadith'),
        'href' => route('quran-hadith.index'),
        'active' => request()->routeIs('quran-hadith.index'),
        'when' => fn() => true,
    ],
    [
        'name' => __('Teachers'),
        'href' => route('authors.index'),
        'active' => request()->routeIs('authors.index'),
        'when' => fn() => true,
    ],
    [
        'name' => __('Blogs'),
        'href' => route('blogs.index'),
        'active' => request()->routeIs('blogs.index'),
        'when' => fn() => true,
    ],
    [
        'name' => __('Exams'),
        'href' => route('exams.index'),
        'active' => request()->routeIs('exams.index'),
        'when' => fn() => auth()->check(),
    ],
];
?>
<nav x-data="scrollHide()" class="bg-teal-600 sticky top-0 z-50 transition-all duration-300 ease-in-out opacity-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-100" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:-my-px md:ms-10 md:flex gap-3">
                    @foreach ($links as $link)
                        @if ($link['when']())
                            <x-nav-link :href="$link['href']" :active="$link['active']">
                                {{ $link['name'] }}
                            </x-nav-link>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-100 bg-teal-500 hover:text-white focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()?->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
                @guest
                    <div class="flex gap-2">
                        <a href="{{ route('login') }}"
                            class="rounded-md px-3 py-1 border border-teal-500 text-white ring-1 ring-transparent transition bg-teal-700 hover:bg-teal-600 hover:border-teal-700 focus:outline-none focus-visible:ring-[#FF2D20]">
                            {{ __('Log in') }}
                        </a>

                        <a href="{{ route('register') }}"
                            class="rounded-md px-3 py-1 border border-teal-500 text-white ring-1 ring-transparent transition bg-teal-700 hover:bg-teal-600 hover:border-teal-700 focus:outline-none focus-visible:ring-[#FF2D20]">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-200 hover:text-white hover:bg-teal-100 focus:outline-none focus:bg-teal-400 focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $link)
                @if ($link['when']())
                    <x-responsive-nav-link :href="$link['href']" :active="$link['active']">
                        {{ $link['name'] }}
                    </x-responsive-nav-link>
                @endif
            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()?->name }}</div>
                <div class="font-medium text-sm text-gray-300">{{ Auth::user()?->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                @endauth
                @guest
                    <div class="flex flex-col">
                        <a href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                            {{ __('Log in') }}
                        </a>

                        <a href="{{ route('register') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20]">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<script>
    function scrollHide() {
        return {
            lastScroll: 0,
            open: false,
            init() {
                const nav = document.querySelector('nav');
                const navbarHeight = nav.offsetHeight;

                window.addEventListener('scroll', () => {
                    const currentScroll = window.pageYOffset;

                    if (this.open) {
                        // Prevent scroll effect when the hamburger is open
                        return;
                    }

                    if (currentScroll <= navbarHeight) {
                        nav.style.opacity = '1';
                        nav.style.transform = 'translateY(0)';
                        return;
                    }

                    if (currentScroll > this.lastScroll) {
                        // Scrolling down
                        nav.style.opacity = '0';
                        nav.style.transform = 'translateY(-100%)';
                    } else {
                        // Scrolling up
                        nav.style.opacity = '1';
                        nav.style.transform = 'translateY(0)';
                    }

                    this.lastScroll = currentScroll;
                });
            },
        };
    }
</script>
