<x-app-layout>
    <x-container>
        <div class="mt-10 space-y-5">
            <h1 class="text-xl font-semibold first-letter:uppercase">{{ $exam->name }}</h1>
            <form action="{{ route('exams.store', $exam) }}" method="post">
                @csrf
                @foreach ($exam->questions as $key => $question)
                    <div>
                        <h3 class="text-lg">{{ __('Question') }} {{ $key + 1 }} : {{ $question->body }}</h3>
                        @foreach ($question->answers as $key => $answer)
                        <div class="my-5">
                            <input type="radio" id="{{ $answer->id }}" name="question[{{ $question->id }}]"
                                value="{{ $answer->id }}" required />
                            <label for="{{ $answer->id }}">{{ $key + 1 }} - {{ $answer->body }}</label>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                @endforeach
                <div class="mb-5">
                    <x-primary-button>{{ __('Submit') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-container>
</x-app-layout>
