<x-app-layout>
    <x-container>
        <main class="flex-grow md:p-5" x-data="{ adhkar: {{ json_encode($adhkar) }} }">
            <h1 class="text-2xl font-bold mb-5">{{ $name }}</h1>
            <div class="mt-2">
                <ul>
                    <template x-for="dhikr in adhkar">
                        <li 
                            class="text-center text-xl leading-8 bg-gray-100 p-4 rounded-lg my-4 shadow-lg cursor-pointer"
                            x-on:click="dhikr.count > 0 ? dhikr.count - 1 : null">
                            <span class="block group p-3">
                                <span class="font-bold text-xl" x-text="dhikr.content"></span>
                            </span>
                            <span 
                                class="font-bold text-xl"
                                x-text="dhikr.count > 0 ? Number(dhikr.count) : 'Completed'"
                            ></span>
                        </li>
                    </template>
                </ul>
            </div>
        </main>        

    </x-container>
</x-app-layout>
