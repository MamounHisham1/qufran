<aside class="w-full md:w-1/3 bg-gray-100 p-5 border-x border-gray-300 my-2">
    <h2 class="text-lg mb-3 font-bold">{{ __('Suggested') }} :</h2>
    <section class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
            {{ __('Suggested categories') }}
        </h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($suggestedCategories as $category)
                <a href="#"
                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </section>

    <section class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
            {{ __('Suggested lessons') }}
        </h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($suggestedLessons as $lesson)
                <a href="#"
                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                    {{ $lesson->title }}
                </a>
            @endforeach
        </div>
    </section>

    <section class="mb-8">
        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
            {{ __('Latest lessons') }}
        </h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($latestLessons as $lesson)
                <a href="#"
                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                    {{ $lesson->title }}
                </a>
            @endforeach
        </div>
    </section>

    <section>
        <h2 class="mb-4 text-xl font-semibold text-center md:text-right">
            {{ __('Famous teachers') }}
        </h2>
        <div class="flex flex-wrap gap-2">
            @foreach ($famousTeachers as $teacher)
                <a href="#"
                    class="bg-teal-700 text-white px-3 py-2 flex items-center justify-center text-sm rounded-md shadow-md break-words text-center hover:bg-teal-950">
                    {{ $teacher->name }}
                </a>
            @endforeach
        </div>
    </section>
</aside>
