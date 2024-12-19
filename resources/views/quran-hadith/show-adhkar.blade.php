<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5">
            <h1 class="text-2xl font-bold mb-5">{{ $name }}</h1>
            <div class="mt-2">
                <ul>
                    @foreach ($adhkar as $dhikr)
                        <li class="text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg cursor-pointer select-none"
                            :class="{ 'bg-green-200 ': count === 0 }" x-data="{ count: @js((int) $dhikr['count']) }"
                            x-on:click="count = count > 0 ? count - 1 : 0">
                            <span class="block group p-3">
                                <span class="font-bold text-xl">{!! $dhikr['content'] !!}</span>
                            </span>
                            <span class="font-bold text-xl"
                                x-text="count > 0 ? count : 'تم بحمدالله'">{{ (int) $dhikr['count'] }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </main>
    </x-container>
</x-app-layout>
