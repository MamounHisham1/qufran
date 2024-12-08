<x-app-layout>
    <x-container>
        <ul class="divide-y divide-teal-400">
            @foreach ($exams as $exam)
                <li>
                    <a href="{{ route('exams.show', $exam->id) }}" class="block group px-2 py-4">
                        <span class="font-bold text-lg group-hover:text-indigo-600">{{ $exam->name }}</span>
                        <div class="flex gap-2 items-center mt-1">
                            <span class="text-sm block pt-1 text-gray-500">
                                {{ __('Start date') }} {{ $exam->start_at }}
                            </span>
                            <span class="text-sm block pt-1 text-gray-500">
                                {{ __('Questions count') }} {{ $exam->questions->count() }}
                            </span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mb-2">{{ $exams->links() }}</div>
    </x-container>
</x-app-layout>
