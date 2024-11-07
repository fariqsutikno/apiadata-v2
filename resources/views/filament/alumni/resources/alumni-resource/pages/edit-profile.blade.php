<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}
    </x-filament-panels::form>
 
    @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament-panels::resources.relation-managers
            :active-manager="0"
            :managers="$relationManagers"
            :owner-record="$this->alumni"
            :page-class="static::class"
        />
    @endif
</x-filament-panels::page>