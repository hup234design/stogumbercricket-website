<div>
    @php
        $layout  = $data['layout'] ?? 'columns';
        $columns = $data['columns'] ?? 4;
        $rounded = $data['rounded'] ?? 'no';
    @endphp

    <div class="space-y-2">
    @if( $layout == "mosaic" )
        @foreach(array_chunk($data['media_image_ids'], 2) as $row=>$chunk)
            <div class="grid grid-cols-3 gap-2 flex-row-reverse">
                @foreach($chunk as $media_image_id)
                    <div
                        @class([
                            "col-span-1" => $loop->first,
                            "col-span-2" => $loop->last,
                            "order-first" => $loop->last && $row % 2 == 1
                        ])
                    >
                        <x--media-image-renderer
                            lightbox
                            :mediaImage="$media_image_id"
                            conversion="thumbnail"
                            @class([
                                "object-cover object-fit w-full h-64",
                                "rounded-2xl" => $rounded == 'yes',
                                "rounded-full" => $layout != "mosaic" && $rounded == 'circle',
                            ])
                        />
                    </div>
                @endforeach
            </div>
        @endforeach
    @else

            @foreach(array_chunk($data['media_image_ids'], $columns) as $chunk)
                <div
                    @class([
                       "flex justify-center gap-4 mx-auto"
                    ])
                    style="{{ count($chunk) < $columns ? 'width: ' . (count($chunk) / $columns * 100) . '%;' : ''}}"
                >
                @foreach($chunk as $media_image_id)

                    <x--media-image-renderer
                        lightbox
                        :mediaImage="$media_image_id"
                        conversion="thumbnail"
                        @class([
                            "object-cover object-fit w-full h-full",
                            "rounded-2xl" => $rounded == 'yes',
                            "rounded-full" => $layout != "mosaic" && $rounded == 'circle',
                        ])
                    />
                @endforeach
                </div>
            @endforeach
    @endif
    </div>
</div>
