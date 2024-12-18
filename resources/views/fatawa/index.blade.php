<x-app-layout>
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

    @section('content')
        <main class="flex-grow md:p-5 md:w-2/3 md:m-0 mx-2 mb-2">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-gray-800">{{ __('Fatawa') }}</h1>
            </div>

            <div class="space-y-6">
                @foreach ($fatawa as $fatwa)
                    <div class="bg-white shadow-md rounded-lg p-5 hover:shadow-lg hover:p-8 transition cursor-pointer relative group"
                        onclick="window.location='{{ route('fatawa.show', $fatwa) }}'">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm text-gray-500">
                                {{ $fatwa->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800 group-hover:text-teal-600">{{ $fatwa->title }}</h2>
                        <p class="text-sm font-semibold text-gray-500">{{ str($fatwa->body)->limit(100, '...', true) }}</p>

                        <p class="text-gray-700 mt-2">
                            {{ __('Category') }}:
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
                <h2 class="mt-3 text-xl font-bold"><span class="border-b border-gray-900">{{ __('Ask a fatwa') }}</span>
                </h2>
                @guest
                    <a href="{{ route('register') }}" class="mt-5 block hover:text-blue-600 hover:underline">
                        {{ __('You must sign up first') }}
                    </a>
                @endguest

                @auth
                    <form action="{{ route('fatawa.store') }}" method="POST" class="max-w-sm mx-auto">
                        @csrf
                        <label for="title"
                            class="block mb-2 font-medium text-gray-900 mt-5 lg:mt-0">{{ __('The question') }}</label>
                        <textarea id="title" name="title" rows="4"
                            class="block p-2.5 w-full text-sm text-black bg-gray-50 rounded-lg border border-gray-500 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="عدد الصلوات..."></textarea>
                        @error('title')
                            <p class="text-red-700 text-sm">{{ __($message) }}</p>
                        @enderror
                        <div class="flex items-center my-4">
                            <input checked id="checkbox-1" type="checkbox" name="is_published"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="checkbox-1" class="ms-2 text-sm font-medium text-gray-900">{{ __('Public') }}</label>
                        </div>
                        <x-primary-button class="mt-2">{{ __('Submit') }}</x-primary-button>
                    </form>
                @endauth
            </div>
        </main>
    @endsection

    @section('aside')
        <aside class="w-full md:w-1/3 bg-gray-100 p-5 border-y mt-5 md:mt-0 md:border-x border-gray-300">
            <h2 class="text-lg mb-3 font-bold">{{ __('Suggested') }} :</h2>
            @if (!$suggestedCategories->isEmpty())
                <section class="mb-8">
                    <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
                        {{ __('Suggested categories') }}
                    </h2>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($suggestedCategories ?? [] as $category)
                            <a href="{{ route('category', $category) }}"
                                class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            @if (!$latest->isEmpty())
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
            @endif

            @if (!$mostAsked->isEmpty())
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
            @endif
        </aside>
    @endsection

    @push('scripts')
        <script>
            function toastNotification() {
                return {
                    visible: false,
                    init() {
                        const message = "{{ session('message') }}";
                        if (message) {
                            $('#toast-message').text(message);
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
        </script>
    @endpush
</x-app-layout>
