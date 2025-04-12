<x-filament-panels::page>
    <div>
        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-3">
                <x-filament::button type="submit" wire:loading.attr="disabled">
                    <x-loading />
                    {{ __('Save') }}
                </x-filament::button>
            </div>
        </form>

        <x-filament-actions::modals />
    </div>
</x-filament-panels::page>
