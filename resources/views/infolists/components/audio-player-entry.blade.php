<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div>
        <audio controls class="p-2">
            <source src="https://qufran.test/storage/{{ $getState() }}" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
</x-dynamic-component>
