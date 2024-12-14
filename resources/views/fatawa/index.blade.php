<x-app-layout>

    @section('content')
    <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2 mb-2">
        <h1 class="text-2xl font-bold mb-5">{{ __('Fatawa') }}</h1>

        <ul class="divide-y divide-teal-400">
            @foreach ($fatawa as $fatwa)
                <li>
                    <a href="{{ route('fatawa.show', $fatwa->id) }}" class="block group px-2 py-4">
                        <span class="text-sm block mb-1 text-gray-800">
                            {{ $fatwa->created_at->diffForHumans() }}
                        </span>
                        <span class="font-bold text-lg group-hover:text-teal-600">{{ $fatwa->title }}</span>
                        <div class="flex gap-2 items-center mt-1">
                            <span class="text-sm block pt-1 text-gray-800">
                                {{ str($fatwa->body)->limit(100, '...', true) }}
                            </span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mb-2">{{ $fatawa->links() }}</div>
    </main>
    @endsection

    @section('aside')
    <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
        <h2 class="text-lg mb-3 font-bold">{{ __('Suggested') }} :</h2>
        <section class="mb-8">
            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                {{ __('Suggested categories') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($suggestedCategories ?? [] as $category)
                    <a href="#"
                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </section>

        <section class="mb-8">
            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                {{ __('Latest fatawa') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($latest ?? [] as $fatwa)
                    <a href="#"
                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                        {{ $fatwa->title }}
                    </a>
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                {{ __('Most asked') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($mostAsked ?? [] as $fatwa)
                    <a href="#"
                        class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                        {{ $fatwa->title }}
                    </a>
                @endforeach
            </div>
        </section>
    </aside>
@endsection

</x-app-layout>