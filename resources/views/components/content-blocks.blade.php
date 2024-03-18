@props(['blocks' => []])

@section('content-blocks')

    <div class="mt-20 content-blocks">

        @php
            $previousStyle = "-";
        @endphp

        @foreach( $blocks as $block )

            @php
                $includeHeader     = $block['data']['include_header'] ?? false;
                $headerTitle       = $block['data']['header_title'] ?? null;
                $headerText        = $block['data']['header_text'] ?? null;
                $headerAlignment   = $block['data']['header_alignment'] ?? 'center';
                $style             = $block['data']['style'] ?? null;
                $backgroundImageId = $block['data']['background_image_id'] ?? null;
                $boxed             = $block['data']['boxed'] ?? false;
            @endphp

            <section
                @class([
                    "relative content-block pb-20",
                    "pb-40" => $loop->last && ! $style,
                    "pt-20" => ($style != $previousStyle) && ! ($loop->first && ! $style),
                    "bg-brand content-block-dark" => $style == "brand",
                    "bg-brand-light" => $style == "brand-light",
                    "bg-dark content-block-dark" => $style == "dark",
                    "bg-light" => $style == "light",
                    "bg-black content-block-dark" => $style == "bgimage",
                    "container" => $boxed
                ])
            >
                @if( $style == "bgimage" && $backgroundImageId)
                    <div class="absolute inset-0">
                        <x--media-image-renderer
                            :mediaImage="$backgroundImageId"
                            class="object-cover object-center w-full h-full opacity-30"
                        />
                    </div>
                @endif

                <div class="relative container">

                    @if( $includeHeader && ($headerTitle || $headerText) )
                        <div
                            @class([
                                "prose prose-xl mb-12",
                                "mx-auto text-center max-w-2xl lg:max-w-3xl" => $headerAlignment == 'center',
                                "max-w-none" => $headerAlignment == 'left'
                            ])
                        >
                            @if( $headerTitle)
                                <h2>{{ $headerTitle }}</h2>
                            @endif
                            @if( $headerText)
                                <p>
                                    {!! nl2br($headerText) !!}
                                </p>
                            @endif
                        </div>

{{--                        <div--}}
{{--                            @class([--}}
{{--                                "prose max-w-5xl mb-12",--}}
{{--                                "mx-auto text-center" => $headerAlignment == 'center'--}}
{{--                            ])--}}
{{--                        >--}}
{{--                            @if( $headerTitle)--}}
{{--                                <h2 class="font-extrabold text-3xl">--}}
{{--                                    {{ $headerTitle }}--}}
{{--                                </h2>--}}
{{--                            @endif--}}
{{--                            @if( $headerText)--}}
{{--                                <p class="lead">--}}
{{--                                    {!! nl2br($headerText) !!}--}}
{{--                                </p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    @endif

                    @livewire('blocks.'.$block['type'], ['data' => $block['data']])
                </div>
            </section>

            @php
                $previousStyle = $style;
            @endphp

        @endforeach

        @if( $boxed ?? false )
            <div class="h-24 w-full"></div>
        @endif
    </div>
@show
