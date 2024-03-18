@php
    $statePath = $getStatePath();
    $conversion = $useConversion();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
            state: $wire.entangle('{{ $getStatePath() }}').live,
            removeImage: function () {
                this.state = null;
            },
            selectMediaImage: function (event) {
                if (event.detail.statePath !== '{{ $statePath }}') return;
                this.state = event.detail.media_image;
            },
            selectRandomImage: function () {
                this.state = this.getRandomNumber(1, 12);
            },
            getRandomNumber: function (min, max) {
                return Math.floor(Math.random() * (max - min + 1) + min);
            },
            selectImages: function () {
                this.state = [1,2,3,4,5,6,7,8,8,10,11,12].sort(() => 0.5 - Math.random());
            }
        }"
        x-on:insert-media-image.window="selectMediaImage($event)"
    >
        @if( $getState() )
            <div class="flex items-center justify-center gap-8 mb-4">
                {{ $getAction('open_media_image_picker') }}
                {{ $getAction('remove_media_image') }}
            </div>
{{--            @if ($isMultiple)--}}
{{--                <div class="grid grid-cols-6 gap-2" x-ref="items">--}}
{{--                    @foreach( $getState() as $index=>$media_image_id)--}}
{{--                        <div class="group relative">--}}
{{--                            <x--media-image-renderer--}}
{{--                                :mediaImage="$media_image_id"--}}
{{--                                conversion="thumbnail" class="w-full"--}}
{{--                            />--}}
{{--                            <div class="absolute top-0 right-0 m-1 hidden group-hover:flex items-center">--}}
{{--                                <a x-on:click="state.splice({{ $index }}, 1)">--}}
{{--                                    <x-heroicon-s-x-circle class="w-8 h-8 text-black bg-white rounded-full" />--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @else--}}
                <x--media-image-renderer :mediaImage="$getState()" :conversion="$conversion" class="w-full" />
{{--            @endif--}}
        @else
            <div class="flex items-center justify-center gap-8 mb-4">
{{--                @if ($isMultiple)--}}
{{--                    <x-filament::button color="primary" x-on:click="selectImages">--}}
{{--                        Select Images--}}
{{--                    </x-filament::button>--}}
{{--                @else--}}
                    {{ $getAction('open_media_image_picker') }}
{{--                @endif--}}
            </div>
        @endif
    </div>

</x-dynamic-component>
