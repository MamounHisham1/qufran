<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-teal-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-800 focus:bg-teal-800 active:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
