<x-filament-panels::page>
   <div class="space-y-6">
        {{-- Render the Filament form --}}
        {{ $this->form }}
    </div>
    <div class="mt-6">
        <x-filament::button wire:click="import">
            Import Books
        </x-filament::button>
    </div>
</x-filament-panels::page>
