<x-app-layout>
    <x-container>
        <h1 class="text-3xl font-bold mb-5 py-2 bg-gray-200 rounded-md text-center mt-3">{{ __($metadata['name']) }}</h1>
        <div class="my-2">
            <ul>
                @foreach ($metadata['sections'] as $key => $section)
                    <li>
                        @php
                            $number = $book == 'ibnmajah' ? $key : $key + 1
                        @endphp
                        <a href="{{ route('hadith.section', ['book' => $book, 'section' => $number]) }}"
                            class="block group p-4 hover:p-6 hover:my-2 border-b text-center rounded-full bg-gray-200 border-teal-400 transition ease-linear mb-1">
                            <span class="font-bold text-xl group-hover:text-teal-600">({{ $key + 1 }}) -
                                {{ __($section) }}</span>
                            <p class="text-sm text-gray-500 mt-2 ms-2">
                                <span>{{ __('From') }}</span>
                                <span>{{ $metadata['section_details'][$key]['hadithnumber_first'] }}</span>
                                <span>{{ __('To') }}</span>
                                <span>{{ $metadata['section_details'][$key]['hadithnumber_last'] }}</span>
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-container>
</x-app-layout>
