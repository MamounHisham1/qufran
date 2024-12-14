@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full px-4 py-2 rounded-md bg-teal-300 text-gray-950 placeholder-white-800 focus:outline-none focus:ring-teal-600']) }}>
