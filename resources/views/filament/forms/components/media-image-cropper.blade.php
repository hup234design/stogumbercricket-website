<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{
            state: $wire.$entangle('{{ $getStatePath() }}').live,
            cropper: null,
            rotate: function() {
                this.cropper.rotateTo(180)
            }
        }"
        x-init="
            setTimeout(() => {
                const image = document.getElementById('{{ $conversion }}-image');
                cropper = new Cropper(image, {
                    aspectRatio: {{ $getRecord()->conversions[$conversion]['width'] }} / {{ $getRecord()->conversions[$conversion]['height'] }},
                    zoomable: false,
                    data: {
                        x: {{ $getRecord()->conversions[$conversion]['x']  }},       // Initial x position of the crop box
                        y: {{ $getRecord()->conversions[$conversion]['y']  }},        // Initial y position of the crop box
                        width: {{ $getRecord()->conversions[$conversion]['width']  }},   // Initial width of the crop box
                        height: {{ $getRecord()->conversions[$conversion]['height']  }}   // Initial height of the crop box (this should be consistent with the aspect ratio)
                    },
                    cropend() {
                        var cropData = cropper.getData();
                        state.x = cropData.x;
                        state.y = cropData.y;
                        state.width = cropData.width;
                        state.height = cropData.height;
                    }
                });
            }, 500)
        "
        class="w-full "
    >
        <div class="w-3/4 mx-auto" wire:ignore>
            <x--media-image-renderer id="{{ $conversion }}-image" :mediaImage="$getRecord()->id" class="max-w-full" />
        </div>
    </div>

</x-dynamic-component>
