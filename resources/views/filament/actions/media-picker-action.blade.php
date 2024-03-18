<livewire:media-browser
    :state-path="$statePath"
    :modal-id="$modalId"
    :media-image-id="$mediaImageId ?: null"
    :conversion="$conversion"
{{--    :presets="$presets"--}}
/>



{{--<div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">--}}
{{--    <input x-model="state" type="range" />--}}

{{--    {{ $getAction('setMaximum') }}--}}
{{--</div>--}}
