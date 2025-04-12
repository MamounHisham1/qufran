<x-app-layout>
    <x-container :show-header="false">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl">
                    <div class="p-8">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                            {{-- @if($author->image)
                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-full opacity-50 group-hover:opacity-100 transition duration-300"></div>
                                    <img src="{{ Storage::url($author->image) }}" 
                                         alt="{{ $author->name }}" 
                                         class="relative w-48 h-48 object-cover rounded-full shadow-lg">
                                </div>
                            @else
                                <div class="relative group">
                                    <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-full opacity-50 group-hover:opacity-100 transition duration-300"></div>
                                    <div class="relative w-48 h-48 bg-gray-200 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-gray-400 text-6xl">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    </div>
                                </div>
                            @endif --}}

                            <div class="flex-1 text-center md:text-right">
                                <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ $author->name }}</h1>
                                @if($author->title)
                                    <p class="text-xl text-teal-600 mb-4 font-semibold">{{ $author->title }}</p>
                                @endif
                                @if($author->bio)
                                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                                        {!! $author->bio !!}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b pb-2 border-teal-200 space-y-4">
                                <span class="block mb-4">{{ __('general.Lessons') }}</span>
                            </h2>
                            
                            @if($author->posts->where('type', '!=', 'fatwa')->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($author->posts->where('type', '!=', 'fatwa') as $post)
                                        <div class="group relative">
                                            <div class="absolute -inset-0.5 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-xl opacity-30 group-hover:opacity-100 transition duration-300 group-hover:blur"></div>
                                            
                                            <div class="relative bg-white rounded-xl p-6 hover:bg-gray-50 transition-all duration-300 transform group-hover:scale-[1.02] shadow-sm">
                                                <div class="flex justify-between items-start mb-3">
                                                    <h3 class="text-lg font-semibold text-gray-900 group-hover:text-teal-600 transition-colors duration-300">
                                                        {{ $post->title }}
                                                    </h3>
                                                    <span class="text-xs px-2 py-1 bg-teal-100 text-teal-800 rounded-full">
                                                        {{ __($post->type) }}
                                                    </span>
                                                </div>
                                                
                                                @if($post->description)
                                                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                                        {{ Str::limit($post->description, 100) }}
                                                    </p>
                                                @endif
                                                
                                                <div class="flex items-center justify-between text-sm mt-auto">
                                                    <span class="text-gray-500">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $post->created_at->format('Y-m-d') }}
                                                    </span>
                                                    <a href="{{ route('lessons.show', $post) }}" 
                                                       class="inline-flex items-center text-teal-600 hover:text-teal-800 font-medium transition-colors duration-300">
                                                        {{ __('general.View Lesson') }}
                                                        <svg class="w-4 h-4 mr-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <span class="text-5xl mb-4 block text-gray-300">
                                        <i class="fas fa-book-open"></i>
                                    </span>
                                    <p class="text-gray-600 text-lg">{{ __('general.No lessons available.') }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-16">
                            <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b pb-2 border-teal-200 space-y-4">
                                <span class="block mb-4">{{ __('general.Fatawa') }}</span>
                            </h2>
                            
                            @if($author->posts->where('type', 'fatwa')->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach($author->posts->where('type', 'fatwa') as $fatwa)
                                        <div class="group relative">
                                            <div class="absolute -inset-0.5 bg-gradient-to-r from-red-600 to-orange-600 rounded-xl opacity-30 group-hover:opacity-100 transition duration-300 group-hover:blur"></div>
                                            
                                            <div class="relative bg-white rounded-xl p-6 hover:bg-gray-50 transition-all duration-300 transform group-hover:scale-[1.02] shadow-sm">
                                                <h3 class="text-lg font-semibold text-gray-900 mb-3 group-hover:text-red-600 transition-colors duration-300">
                                                    {{ $fatwa->title }}
                                                </h3>
                                                
                                                @if($fatwa->description)
                                                    <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                                                        {{ Str::limit($fatwa->description, 100) }}
                                                    </p>
                                                @endif
                                                
                                                <div class="flex items-center justify-between text-sm mt-auto">
                                                    <span class="text-gray-500">
                                                        <i class="far fa-calendar-alt mr-1"></i>
                                                        {{ $fatwa->created_at->format('Y-m-d') }}
                                                    </span>
                                                    <a href="{{ route('fatawa.show', $fatwa) }}" 
                                                       class="inline-flex items-center text-red-600 hover:text-red-800 font-medium transition-colors duration-300">
                                                        {{ __('general.View Fatwa') }}
                                                        <svg class="w-4 h-4 mr-2 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <span class="text-5xl mb-4 block text-gray-300">
                                        <i class="fas fa-scroll"></i>
                                    </span>
                                    <p class="text-gray-600 text-lg">{{ __('general.No fatawa available.') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout> 