<x-app-layout>
    <x-container>
        @section('content')
            <div class="max-w-4xl mx-auto px-4 py-8 bg-white shadow-lg rounded-lg" x-data="{ show: false }">
                <div class="mb-6 flex justify-between items-center border-b pb-3">
                    <h1 class="text-3xl font-bold text-gray-800 text-center">{{ $exam->name }} - {{ __('Results') }}</h1>

                    @if ($exam->category)
                        <div class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-sm font-medium">
                            {{ $exam->category->name }}
                        </div>
                    @endif
                </div>

                @if ($exam->description)
                    <div class="bg-gray-50 p-4 rounded-lg mb-6 text-gray-700 italic">
                        {{ $exam->description }}
                    </div>
                @endif

                <span
                    class="cursor-pointer inline-block px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition duration-300 ease-in-out transform hover:-translate-y-1 shadow-md hover:shadow-lg text-center select-none active:scale-95"
                    x-on:click="show = true" x-show="show == false">
                    {{ __('Show results') }}
                </span>

                <div x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-90" class="transform origin-top mt-5">
                    <div class="mb-6 flex flex-col gap-4 text-center">
                        <div class="p-4 rounded-lg {{ $percentage > 50 ? 'bg-teal-100 ' : 'bg-red-100 ' }}">
                            <span class="block text-2xl font-bold {{ $percentage > 50 ? 'text-teal-800' : 'text-red-800' }}">{{ $percentage }}%</span>
                            <span class="{{ $percentage > 50 ? 'text-teal-600' : 'text-red-600' }}">{{ __('Score') }}</span>
                        </div>
                        <div class="bg-green-100 p-4 rounded-lg">
                            <span class="block text-2xl font-bold text-green-800">
                                {{ count(array_filter(array_map(fn($c, $u) => $c == $u, $correctAnswers, $userAnswers))) }}
                            </span>
                            <span class="text-green-600">{{ __('Correct Answers') }}</span>
                        </div>
                        <div class="bg-red-100 p-4 rounded-lg">
                            <span class="block text-2xl font-bold text-red-800">
                                {{ count($questions) - count(array_filter(array_map(fn($c, $u) => $c == $u, $correctAnswers, $userAnswers))) }}
                            </span>
                            <span class="text-red-600">{{ __('Incorrect Answers') }}</span>
                        </div>
                    </div>

                    @foreach ($questions as $key => $question)
                        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 mb-4">
                            <h3 class="text-xl font-semibold text-gray-700 mb-4">
                                <span class="text-teal-600 mr-2">{{ __('Question') }} {{ $key + 1 }}:</span>
                                {{ $question->body }}
                            </h3>

                            <div class="space-y-3">
                                @foreach ($question->answers as $answerKey => $answer)
                                    <div
                                        class="flex items-center 
                                    {{ $answer->id == $correctAnswers[$key] ? 'bg-green-100' : '' }}
                                    {{ $answer->id == $userAnswers[$key] && $answer->id != $correctAnswers[$key] ? 'bg-red-100' : '' }}
                                    p-2 rounded-md">
                                        <div class="flex items-center w-full">
                                            <span class="font-medium text-gray-500 mr-2 w-8">
                                                {{ $answerKey + 1 }} -
                                            </span>
                                            <span
                                                class="flex-grow {{ $answer->id == $correctAnswers[$key] ? 'font-bold text-green-800' : '' }}
                                            {{ $answer->id == $userAnswers[$key] && $answer->id != $correctAnswers[$key] ? 'font-bold text-red-800' : '' }}">
                                                {{ $answer->body }}
                                            </span>

                                            @if ($answer->id == $correctAnswers[$key])
                                                <span
                                                    class="text-green-600 font-semibold ml-2">{{ __('Correct Answer') }}</span>
                                            @endif

                                            @if ($answer->id == $userAnswers[$key] && $answer->id != $correctAnswers[$key])
                                                <span
                                                    class="text-red-600 font-semibold ml-2">{{ __('Your Answer') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endsection

    </x-container>
</x-app-layout>
