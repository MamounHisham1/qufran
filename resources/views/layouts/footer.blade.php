@php
$links = [
    [
        'name' => __('general.Dashboard'),
        'href' => route('dashboard'),
    ],
    [
        'name' => __('general.Lessons'),
        'href' => route('lessons.index'),
    ],
    [
        'name' => __('general.Fatawa'),
        'href' => route('fatawa.index'),
    ],
    [
        'name' => __('general.Quran-Hadith'),
        'href' => route('quran-hadith.index'),
    ],
];
@endphp
<footer class="bg-teal-600 text-white rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- معلومات الشركة -->
            <div>
                <h3 class="text-xl font-semibold mb-4">{{ __('general.About us') }}</h3>
                <p class="text-sm leading-relaxed">
                   {{-- Generate an about parg for this website fetching the website idea--}}
                   {{ __('general.This website is a platform for learning and teaching the Quran and Hadith. It is a place for Muslims to learn and share their knowledge about the Quran and Hadith.') }}
                </p>
                <div class="mt-4 flex space-x-4 gap-3 justify-end">
                    <a href="#" class="hover:text-teal-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.6a10 10 0 01-2.83.78A4.93 4.93 0 0023.34 3a9.8 9.8 0 01-3.13 1.2A4.92 4.92 0 0016.62 3a4.92 4.92 0 00-4.9 6.03A13.94 13.94 0 011.67 3.16a4.93 4.93 0 001.52 6.55A4.86 4.86 0 012 9.5v.06a4.91 4.91 0 003.95 4.83 4.93 4.93 0 01-2.21.08A4.92 4.92 0 007.83 19 9.87 9.87 0 010 21a13.94 13.94 0 007.55 2.21c9.06 0 14-7.5 14-14 0-.21 0-.42-.01-.63A9.92 9.92 0 0024 4.6z" />
                        </svg>
                    </a>
                    <a href="#" class="hover:text-teal-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.12 7.12l-2.38 11.06c-.158.803-.643.995-1.316.623l-3.698-2.69-2.193 2.168c-.168.166-.277.305-.575.305s-.443-.135-.577-.515l-1.292-4.152-3.406-1.065c-.379-.122-.394-.38.085-.571l12.648-4.882c.635-.27 1.267.18 1.035 1.202z" />
                        </svg>
                    </a>                    
                </div>
            </div>
            <!-- الروابط السريعة -->
            <div>
                <h3 class="text-xl font-semibold mb-4">{{ __('general.Quick links') }}</h3>
                <ul class="space-y-2">
                    @foreach ($links as $link)
                        <li><a href="{{ $link['href'] }}" class="hover:text-teal-300">{{ $link['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            <!-- اﻹقترحات -->
            <div>
                <h3 class="text-xl font-semibold mb-4">{{ __('general.Suggestions') }}</h3>
                <form action="{{ route('suggest') }}" method="POST" class="max-w-sm mx-auto">
                    @csrf
                    <label for="title"
                        class="block mb-2 font-medium mt-5 lg:mt-0">{{ __('general.Do you have a suggestion for a new idea? Do not hesitate to submit it.') }}</label>
                    <textarea id="title" name="body" rows="4"
                        class="block p-2.5 w-full text-sm text-white bg-teal-700 rounded-lg border border-gray-500 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('body')
                        <p class="text-red-700 text-sm">{{ __($message) }}</p>
                    @enderror
                    <x-primary-button class="mt-2">{{ __('general.Submit') }}</x-primary-button>
                </form>
            </div>
        </div>
        <div class="mt-8 text-center border-t border-teal-500 pt-4">
            <p class="text-sm">&copy; {{ date('Y') }} {{ __('general.All rights reserved.') }}</p>
        </div>
    </div>
</footer>
