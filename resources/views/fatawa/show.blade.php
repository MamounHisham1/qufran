<x-app-layout>
    <x-container>
        <div class="container mx-auto px-4 py-8 text-right">
            <div class="max-w-3xl mr-0 ml-auto bg-white shadow-md rounded-lg overflow-hidden">
                {{-- Header --}}
                <div class="bg-teal-600 text-white p-4">
                    <h2 class="text-xl font-bold">
                        <span class="text-gray-300">{{ __('The question') }}:</span>
                        {{ $fatwa->title }}
                    </h2>
                    <div class="text-sm mt-1">
                        رقم الفتوى: {{ $fatwa->fatwa_number }}
                    </div>
                </div>

                {{-- Body (Answer) Section --}}
                <div class="p-4">
                    <div class="bg-teal-50 p-3 rounded-md">
                        <h3 class="font-semibold text-lg mb-2 text-teal-800">
                            الإجابة
                        </h3>
                        <p class="text-gray-800 leading-relaxed">
                            {{ $fatwa->body }}
                        </p>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-100 p-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>{{ $fatwa->created_at->toHijri()->isoFormat('LL') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>
