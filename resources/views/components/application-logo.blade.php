@props(['color' => 'text-yellow-100']) <!-- Default to 'text-yellow-100' -->

<a href="/" class="-m-1.5 p-1.5">
    <img class="h-20 w-auto" src="{{ asset('images/logo.png') }}" alt="معهد الغفران">
</a>
<a href="/" class="{{ $color }} font-bold text-2xl">
    الغفران
</a>