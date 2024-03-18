@php
    $statePath = $getStatePath();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
            state: $wire.entangle('{{ $getStatePath() }}').live,
            removeMediaImage: function (event) {
                if (event.detail.statePath !== '{{ $statePath }}') return;
                this.state.splice(event.detail.idx, 1);
            },
            selectMediaImages: function (event) {
                if (event.detail.statePath !== '{{ $statePath }}') return;
                if(! this.state) {
                    this.state = [];
                }
                for (media_image_id of event.detail.media_images) {
                    this.state.push(media_image_id);
                }
            }
        }"
        x-on:insert-gallery-images.window="selectMediaImages($event)"
        x-on:media-image-removed.window="removeMediaImage($event)"
    >

        @if( $getState() )
            <div class="flex items-center justify-center gap-8 mb-4">
                {{ $getAction('open_media_gallery_picker') }}
            </div>
            <div class="grid grid-cols-6 gap-2">
                @foreach( $getState() as $index=>$media_image_id)
                    <div class="group relative">
                        <x--media-image-renderer
                            :mediaImage="$media_image_id"
                            conversion="thumbnail" class="w-full"
                        />
                        <div class="absolute top-0 right-0 m-1 hidden group-hover:flex items-center">
                            <a x-on:click="state.splice({{ $index }}, 1)">
                                <x-heroicon-s-x-circle class="w-8 h-8 text-black bg-white rounded-full" />
                            </a>
                        </div>
                        <div class="absolute left-0 bottom-0 m-2 hidden group-hover:flex items-center">
                            <!-- Only allow moving left if it's not the first item -->
                            @if($index > 0)
                                <a x-on:click="let tmp = state[{{ $index }}]; state[{{ $index }}] = state[{{ $index - 1 }}]; state[{{ $index - 1 }}] = tmp;">
                                    <x-heroicon-s-arrow-left-circle class="w-8 h-8 text-black bg-white rounded-full" />
                                </a>
                            @endif
                        </div>
                        <div class="absolute right-0 bottom-0  m-2 hidden group-hover:flex items-center">
                            <!-- Only allow moving right if it's not the last item -->
                            @if($index < count($getState()) - 1)
                                <a x-on:click="let tmp = state[{{ $index }}]; state[{{ $index }}] = state[{{ $index + 1 }}]; state[{{ $index + 1 }}] = tmp;">
                                    <x-heroicon-s-arrow-right-circle class="w-8 h-8 text-black bg-white rounded-full" />
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center gap-8 mb-4">
{{--                @if ($isMultiple)--}}
{{--                    <x-filament::button color="primary" x-on:click="selectImages">--}}
{{--                        Select Images--}}
{{--                    </x-filament::button>--}}
{{--                @else--}}
                    {{ $getAction('open_media_gallery_picker') }}
{{--                @endif--}}
            </div>

        @endif
    </div>

</x-dynamic-component>
