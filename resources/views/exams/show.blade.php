<x-app-layout>
    <x-container>
        <div class="max-w-4xl mx-auto px-4 py-8 bg-white shadow-lg rounded-lg">
            <div class="mb-6 flex justify-between items-center border-b pb-3">
                <h1 class="text-3xl font-bold text-gray-800">{{ $exam->name }}</h1>
                
                @if($exam->category)
                    <div class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-sm font-medium">
                        {{ $exam->category->name }}
                    </div>
                @endif
            </div>
        
            @if($exam->description)
                <div class="bg-gray-50 p-4 rounded-lg mb-6 text-gray-700 italic">
                    {{ $exam->description }}
                </div>
            @endif
        
            <div class="mb-4 flex justify-between text-sm text-gray-600">
                <div>
                    <strong>{{ __('general.Start date') }}:</strong> 
                    <span class="text-green-600">
                        {{ \Carbon\Carbon::parse($exam->start_at)->locale('ar')->translatedFormat('d F Y') }}
                    </span>
                </div>
                @if($exam->end_at)
                    <div>
                        <strong>{{ __('general.End date') }}:</strong> 
                        <span class="text-red-600">
                            {{ \Carbon\Carbon::parse($exam->end_at)->locale('ar')->translatedFormat('d F Y') }}
                        </span>
                    </div>
                @endif
            </div>
            
            <form action="{{ route('exams.store', $exam) }}" method="post" class="space-y-6">
                @csrf
                @foreach ($exam->questions as $key => $question)
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">
                            <span class="text-teal-600 mr-2">{{ __('general.Question') }} {{ $key + 1 }}:</span> 
                            {{ $question->body }}
                        </h3>
                        
                        <div class="space-y-3">
                            @foreach ($question->answers as $answerKey => $answer)
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="{{ $answer->id }}" 
                                        name="question[{{ $question->id }}]"
                                        value="{{ $answer->id }}" 
                                        required 
                                        class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300"
                                    />
                                    <label 
                                        for="{{ $answer->id }}" 
                                        class="ml-3 block text-base text-gray-700 hover:bg-gray-100 p-2 mx-2 rounded-md transition duration-200 cursor-pointer"
                                    >
                                        <span class="font-medium text-gray-500 mr-2">
                                            {{ $answerKey + 1 }} -
                                        </span>
                                        {{ $answer->body }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                <div class="flex justify-end mt-6">
                    <x-primary-button class="transition duration-200 ease-in-out transform hover:scale-105">
                        {{ __('general.Submit') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-container>
</x-app-layout>
