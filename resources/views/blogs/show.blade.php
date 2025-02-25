<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center bg-gray-800 text-white py-4 px-6 print:hidden">
            <h1 class="font-bold text-3xl">{{ $blog->title }}</h1>
            <button onclick="window.print()" class="bg-white text-gray-800 px-4 py-2 rounded-lg flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Print
            </button>
        </div>
    </x-slot>

    <article class="py-8 print:py-4 max-w-6xl mx-auto px-6 bg-white shadow-md print:shadow-none print:bg-transparent">
        <!-- Newspaper Header -->
        <header class="border-b-4 border-gray-800 pb-4 mb-6 text-center">
            <h1 class="text-5xl font-bold uppercase">{{ $blog->title }}</h1>
            <p class="text-gray-600 mt-2">{{ __('Published on') }} {{ $blog->created_at->format('M d, Y') }} | {{ __('Blog No.') }} #{{ $blog->id }}</p>
        </header>

        @if ($blog->image)
            <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}" class="w-full h-96 object-cover rounded-lg mb-6">
        @endif

        <!-- Newspaper Columns -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 prose prose-lg">
                {!! $blog->description !!}
            </div>
            <aside class="bg-gray-100 p-4 rounded-lg text-gray-700">
                <h2 class="text-xl font-semibold mb-3">{{ __('Article info') }}</h2>
                @if ($blog->category)
                    <p><strong>{{ __('Category') }}:</strong> {{ $blog->category->name }}</p>
                @endif
                @if ($blog->author)
                    <p><strong>{{ __('By') }}:</strong> {{ $blog->author->name }}</p>
                @endif
                <p><strong>{{ __('Published') }}:</strong> {{ $blog->created_at->format('M d, Y') }}</p>
            </aside>
        </div>

        <!-- Sections -->
        @foreach ($blog->sections as $section)
            <div class="border-t-2 border-gray-800 pt-6 mt-6">
                @if ($section->title)
                    <h2 class="text-3xl font-bold mb-3">{{ $section->title }}</h2>
                @endif
                @if ($section->image)
                    <img src="{{ Storage::url($section->image) }}" alt="{{ $section->title }}" class="w-full h-auto rounded-lg mb-6">
                @endif
                <div class="prose prose-lg">
                    {!! $section->content !!}
                </div>
            </div>
        @endforeach
    </article>

    @push('styles')
        <style>
            @media print {
                body {
                    background-color: white;
                    font-family: 'Times New Roman', Times, serif;
                }

                .prose {
                    font-size: 16px;
                    max-width: none !important;
                }

                header h1 {
                    font-size: 36px;
                    font-weight: bold;
                    text-align: center;
                }

                @page {
                    margin: 2cm;
                }

                .print\:hidden, nav, header, footer, aside {
                    display: none !important;
                }

                .max-w-6xl {
                    max-width: none !important;
                }

                article {
                    padding: 0 !important;
                    margin: 0 !important;
                    width: 100% !important;
                }

                img {
                    page-break-inside: avoid;
                    max-width: 100% !important;
                }

                .border-t-2 {
                    border-top: 2px solid black !important;
                }
            }
        </style>
    @endpush
</x-app-layout>
