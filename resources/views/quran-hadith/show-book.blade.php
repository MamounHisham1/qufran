<x-app-layout>
    <x-container>
        <h1 class="text-2xl font-bold mb-5">{{ __(strtoupper($slug)) }}</h1>
        <div class="mt-2">
            <ul>
                @foreach ($metadata['sections'] as $key => $section)
                    <li>
                        <a href="/quran-hadith/{{ $slug }}/{{ strtolower(str_replace(' ', '-', $section)) }}}"
                            class="block group p-4 hover:p-6 hover:my-2 border-b rounded-full bg-gray-200 border-teal-400 transition ease-linear">
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
