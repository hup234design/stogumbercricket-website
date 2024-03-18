<div>

    @php
    $columns     = $data['list_columns'] ?? 1;
    $alignment   = $data['list_alignment'] ?? 'left';
    $style       = $data['style'] ?? null;
    $proseInvert = in_array($style, ["dark","brand","bgimage"]);
    @endphp

    <div
        @class([
            "grid gap-4",
            "md:grid-cols-2 md-gap-8  lg:gap-12" => $columns == 2,
            "md:grid-cols-3 md-gap-8 lg:gap-12" => $columns == 3,
            "md:grid-cols-4 md-gap-8 lg:gap-12" => $columns == 4,
        ])
    >
        @foreach($data['items'] as $item)
            <div
                @class([
                    "prose max-w-none flex items-center",
                    "prose-invert" => $proseInvert,
                    "flex-col text-center space-y-2" => $alignment == 'center'
                ])
            >
                @if( $data['use_icon'] && $data['icon'] )
                    <x-dynamic-component component="heroicon-{{ $data['icon_style'] }}-{{ $data['icon'] }}" class="w-8 h-8 flex-shrink-0 mr-4" style="color: {{ $data['color'] }};" />
                @endif
                <p class="mt-0 leading-tight font-medium">
                    {{ $item['text'] }}
                </p>
            </div>
        @endforeach
    </div>

</div>
