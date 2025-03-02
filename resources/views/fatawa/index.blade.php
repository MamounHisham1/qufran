<x-app-layout>
    @section('content')
        <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2 mb-2">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-800">{{ __('general.Fatawa') }}</h1>
            </div>

            <div class="space-y-6">
                @foreach ($fatawa as $fatwa)
                    <div class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg hover:scale-105 transition-transform duration-300 cursor-pointer relative group"
                        onclick="window.location='{{ route('fatawa.show', $fatwa) }}'">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-500">
                                {{ $fatwa->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800 group-hover:text-teal-600">{{ $fatwa->title }}</h2>
                        <p class="text-sm font-semibold text-gray-500">{{ str($fatwa->body)->limit(100, '...', true) }}</p>

                        <p class="text-gray-700 mt-2">
                            {{ __('general.Category') }}:
                            <a href="{{ route('category', $fatwa->category) }}"
                                class="text-blue-600 hover:underline z-10 relative" onclick="event.stopPropagation();">
                                {{ $fatwa->category->name }}
                            </a>
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $fatawa->links() }}
            </div>

            <div class="mt-5 border-t border-teal-700">
                <h2 class="mt-3 text-xl font-bold"><span class="border-b border-gray-900">{{ __('general.Ask a fatwa') }}</span>
                </h2>
                @guest
                    <a href="{{ route('register') }}" class="mt-5 block hover:text-blue-600 hover:underline">
                        {{ __('general.You must sign up first') }}
                    </a>
                @endguest

                @auth
                    <form action="{{ route('fatawa.store') }}" method="POST" class="max-w-sm mx-auto">
                        @csrf
                        <label for="title"
                            class="block mb-2 font-medium text-gray-900 mt-5 lg:mt-0">{{ __('general.The question') }}</label>
                        <textarea id="title" name="title" rows="4"
                            class="block p-2.5 w-full text-sm text-black bg-gray-50 rounded-lg border border-gray-500 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="عدد الصلوات..."></textarea>
                        @error('title')
                            <p class="text-red-700 text-sm">{{ __($message) }}</p>
                        @enderror
                        <div class="flex items-center my-4">
                            <input checked id="checkbox-1" type="checkbox" name="is_published"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="checkbox-1" class="ms-2 text-sm font-medium text-gray-900">{{ __('general.Public') }}</label>
                        </div>
                        <x-primary-button class="mt-2">{{ __('general.Submit') }}</x-primary-button>
                    </form>
                @endauth
            </div>
        </main>
    @endsection

    @section('aside')
        <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
            <h2 class="text-lg mb-3 font-bold">{{ __('general.Suggested') }} :</h2>
            @if (!$suggestedCategories->isEmpty())
                <section class="mb-8">
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('general.Suggested categories') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($suggestedCategories ?? [] as $category)
                            <a href="{{ route('category', $category) }}"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!$latest->isEmpty())
                <section class="mb-8">
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('general.Latest fatawa') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($latest ?? [] as $fatwa)
                            <a href="#"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                {{ $fatwa->title }}
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!$mostAsked->isEmpty())
                <section>
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('general.Most asked') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($mostAsked ?? [] as $fatwa)
                            <a href="#"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950  hover:scale-110 transition-transform duration-300">
                                {{ $fatwa->title }}
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </aside>
    @endsection
</x-app-layout>
