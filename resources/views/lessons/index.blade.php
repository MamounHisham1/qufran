<x-app-layout>
    <x-container>
        <ul class="divide-y divide-teal-400">
            @foreach ($lessons as $lesson)
                <li>
                    <a href="{{ route('lessons.show', $lesson->id) }}" class="block group px-2 py-4">
                        <span class="text-sm block mb-1 text-gray-500">
                            {{ $lesson->created_at->diffForHumans() }} بواسطة {{ $lesson->author?->name ?? __('Ananymos') }}
                        </span>
                        <span class="font-bold text-lg group-hover:text-indigo-600">{{ $lesson->title }}</span>
                        <div class="flex gap-2 items-center mt-1">
                            <span class="text-sm block pt-1 text-gray-500">
                                {{ __('Lesson type') }} {{ __($lesson->type) }}
                            </span>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mb-2">{{ $lessons->links() }}</div>
    </x-container>
</x-app-layout>
