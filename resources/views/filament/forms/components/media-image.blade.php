<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <x--media-image-renderer :mediaImage="$getRecord()->id" class="w-full" />

</x-dynamic-component>
