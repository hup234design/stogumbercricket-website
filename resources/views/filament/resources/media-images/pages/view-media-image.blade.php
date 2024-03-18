<x-filament-panels::page>

    @if ($this->hasInfolist())
        {{ $this->infolist }}
    @endif

    {{ $this->form }}

</x-filament-panels::page>
