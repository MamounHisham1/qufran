@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-white focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-300 hover:text-white hover:border-indigo-300 focus:outline-none focus:text-white focus:border-indigo-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
