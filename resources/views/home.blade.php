<x-app-layout>
    <section class="relative isolate overflow-hidden bg-cyan-950 min-h-screen flex items-center justify-center">
        <img src="{{ asset('images/background.jpeg') }}" alt="معهد الغفران"
            class="absolute inset-0 -z-10 w-full h-full object-cover object-right md:object-center opacity-30">
        <div class="text-center max-w-2xl px-4 sm:px-6 mb-10 sm:mb-0 mt-10 md:mt-0">
            <h2 class="text-6xl font-semibold tracking-tight text-white text-center leading-relaxed">مرحبا بكم في معهد
                <span class="text-yellow-400 font-bold block">الغفران</span>
            </h2>
            <p class="mt-10 text-xl font-medium text-white text-center leading-normal">نسعى لنشر تعاليم الإسلام السمحة
                والقيم النبيلة من خلال محتوى موثوق ومفيد. هدفنا هو تعزيز المعرفة وتقديم الإلهام لتحقيق حياة مليئة
                بالإيمان والتقوى. شكرًا لزيارتكم، ونتمنى أن تجدوا في موقعنا ما ينفعكم ويساهم في تقوية علاقتكم بالله عز
                وجل.</p>
        </div>
    </section>
    <x-container>
        <section class="my-5 grid gap-5 md:grid-cols-2">
            <!-- Suggested Categories -->
            <div>
              <h2 class="mb-4 text-xl font-bold text-center md:text-right">
                {{ __('Suggested categories') }}
              </h2>
              <div class="grid grid-cols-2 gap-3">
                @foreach ($suggestedCategories as $category)
                  <a href="#" class="bg-teal-700 text-white p-2 flex items-center justify-center text-sm h-14 rounded-md shadow-md">
                    {{ $category->name }}
                  </a>
                @endforeach
              </div>
            </div>
          
            <!-- Suggested Lessons -->
            <div class="border-t md:border-t-0 md:border-r border-gray-300 pt-5 md:pt-0 md:ps-5">
              <h2 class="mb-4 text-xl font-bold text-center md:text-right">
                {{ __('Suggested lessons') }}
              </h2>
              <div class="grid grid-cols-2 gap-3">
                @foreach ($suggestedLessons as $lesson)
                  <a href="#" class="bg-teal-700 text-white p-2 flex items-center justify-center text-sm h-14 rounded-md shadow-md">
                    {{ $lesson->title }}
                  </a>
                @endforeach
              </div>
            </div>
          
            <!-- Latest Lessons -->
            <div class="border-t md:border-t-0 border-gray-300 pt-5 md:pt-0">
              <h2 class="mb-4 text-xl font-bold text-center md:text-right">
                {{ __('Latest lessons') }}
              </h2>
              <div class="grid grid-cols-2 gap-3">
                @foreach ($latestLessons as $lesson)
                  <a href="#" class="bg-teal-700 text-white p-2 flex items-center justify-center text-sm h-14 rounded-md shadow-md">
                    {{ $lesson->title }}
                  </a>
                @endforeach
              </div>
            </div>
          
            <!-- Famous Teachers -->
            <div class="border-t md:border-t-0 md:border-r border-gray-300 pt-5 md:pt-0 md:ps-5">
              <h2 class="mb-4 text-xl font-bold text-center md:text-right">
                {{ __('Famous teachers') }}
              </h2>
              <div class="grid grid-cols-2 gap-3">
                @foreach ($famousTeachers as $teacher)
                  <a href="#" class="bg-teal-700 text-white p-2 flex items-center justify-center text-sm h-14 rounded-md shadow-md">
                    {{ $teacher->name }}
                  </a>
                @endforeach
              </div>
            </div>
          </section>
          
    </x-container>
</x-app-layout>
