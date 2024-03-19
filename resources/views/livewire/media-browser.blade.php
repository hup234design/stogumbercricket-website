<div>

    <div class="absolute top-0 inset-x-0 bottom-0 mt-16 px-8 pb-8">
        <div class="h-full w-full overflow-y-scroll">
            <div
                x-data="{}"
                x-on:insert-media-image.window="$dispatch('close-modal', { id: '{{ $modalId }}' })"
                x-on:insert-gallery-images.window="$dispatch('close-modal', { id: '{{ $modalId }}' })"
                class="relative w-full grid grid-cols-3 overflow-y-scroll"
            >

                <div class="col-span-2" wire:key="table-images-{{ count($mediaImageIds) }}">
                    {{ $this->table }}
                </div>

                <aside class="overflow-y-auto border-l border-gray-200 bg-white px-8 lg:block">

                    @if($multiple)
                        <div
                            class="col-span-3"
                            wire:key="gallery-images-{{ count($selectMediaImageIds) }}"
                            x-data="{
                        init() {
                            Sortable.create(this.$refs.items);
                        }
                    }"
                        >
                            <p class="font-bold text-md">Selected Images:</p>
                            <div class="grid grid-cols-4 gap-4 my-8"  x-ref="items">
                                @forelse( $selectMediaImageIds as $idx=>$media_image_id)
                                    <div class="group relative" wire:key="select-image-{{ $idx }}-{{ $media_image_id }}">
                                        <x--media-image-renderer
                                            :mediaImage="$media_image_id"
                                            conversion="thumbnail"
                                            class="w-full"
                                        />
                                        <a
                                            wire:click="removeSelectedImage({{ $idx }})"
                                            class="hidden group-hover:flex absolute inset-0 bg-black/50 items-center justify-center">
                                            <x-heroicon-s-x-circle class="w-12 h-12 text-white" />
                                        </a>
                                    </div>
                                @empty
                                    <p>No Images Selected</p>
                                @endforelse
                            </div>
                            @if( count($selectMediaImageIds) > 0 )
                                <div class="flex justify-center items-center space-x-8">
                                    {{ $this->selectMultipleAction }}
                                </div>
                            @endif
                        </div>

                    @elseif( $this->mediaImageId )
                        <div class="space-y-6 pb-16">
                            <div>
                                <div class="aspect-h-7 aspect-w-10 block w-full">
                                    <x--media-image-renderer :mediaImage="$this->mediaImage" :conversion="$this->conversion" class="w-full" />
                                </div>
                                <h2 class="mt-4 text-lg font-medium text-gray-900">
                                    <span class="sr-only">Details for </span>
                                    {{ $this->mediaImage->original_filename }}
                                </h2>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Information</h3>
                                <dl class="mt-2 divide-y divide-gray-200 border-b border-t border-gray-200">
                                    <div class="flex justify-between py-3 text-sm font-medium">
                                        <dt class="text-gray-500">ALT</dt>
                                        <dd class="whitespace-nowrap text-gray-900">
                                            {{ $this->mediaImage->alt }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between py-3 text-sm font-medium">
                                        <dt class="text-gray-500">Original Filename</dt>
                                        <dd class="whitespace-nowrap text-gray-900">
                                            {{ $this->mediaImage->original_filename }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between py-3 text-sm font-medium">
                                        <dt class="text-gray-500">Size</dt>
                                        <dd class="whitespace-nowrap text-gray-900">
                                            {{ $this->imgSize }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between py-3 text-sm font-medium">
                                        <dt class="text-gray-500">Dimensions</dt>
                                        <dd class="whitespace-nowrap text-gray-900">
                                            {{ $this->imgDimensions }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            <div class="flex justify-center items-center space-x-8">

                                {{--                    <x-filament::button wire:click="mountTableAction('edit', {{ $this->mediaImageId }})">--}}
                                {{--                        Edit--}}
                                {{--                    </x-filament::button>--}}

                                {{ $this->selectAction }}

                                {{ $this->duplicateAction }}
                            </div>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Used in Pages</h3>
                            <ul role="list" class="mt-2 divide-y divide-gray-200 border-b border-t border-gray-200">
                                @forelse( $this->mediaImagePageUsage as $page )
                                    <li class="flex items-center justify-between py-3">
                                        <span>{{ $page['title'] }}</span>
                                        <x-filament::badge color="gray">
                                            <span class="uppercase">{{ $page['type'] }}</span>
                                        </x-filament::badge>
                                    </li>
                                @empty
                                    <li class="py-3">
                                        Image Has not been used in any pages
                                    </li>
                                @endforelse
                            </ul>

                            <h3 class="mt-4 font-medium text-gray-900">Used in Sliders</h3>
                            <ul role="list" class="mt-2 divide-y divide-gray-200 border-b border-t border-gray-200">
                                @forelse( $this->mediaImageSlideUsage as $slide )
                                    <li class="flex items-center justify-between py-3">
                                        <span>{{ $slide['heading'] }}</span>
                                        <x-filament::badge color="gray">
                                            <span class="uppercase">{{ $slide['slider'] }}</span>
                                        </x-filament::badge>
                                    </li>
                                @empty
                                    <li class="py-3">
                                        Image Has not been used in any sliders
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    @endif
                </aside>

            </div>
        </div>
    </div>
    <x-filament-actions::modals />
</div>
