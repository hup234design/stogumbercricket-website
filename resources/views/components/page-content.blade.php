@props(['page', 'ignoreFeaturedImage' => false])

@section('heading')

    @if( $page->header_slider_id )

        <x-slider :slider="$page->header_slider" />

    @else

        <div class="relative bg-red-800 flex items-center justify-center min-h-[240px]">
            <div class="absolute inset-0 bg-black">
                <x--media-image-renderer
                    :mediaImage="$page->header_image_id ?: cms('default_banner_image_id')"
                    class="object-cover object-center w-full h-full opacity-80"
                />
            </div>
            <div class="container relative pt-48 pb-16 text-center space-y-4 text-white lg:pt-64">
                @if( $page->header['title'] ?? "" )
                    <h2 class="text-xl font-extrabold uppercase text-shadow">
                        {{ $page->header['title'] }}
                    </h2>
                @endif
                <h1 class="text-5xl font-black text-shadow">
                    {{ $page->header['heading'] ?? $page->title }}
                </h1>
                @if( trim($page->header['text'] ?? "") )
                    <p class="max-w-2xl mx-auto text-xl font-bold  text-shadow">
                        {!! nl2br($page->header['text']) !!}
                    </p>
                @endif
            </div>
        </div>

    @endif

@stop

<div>
    <div class="container">
        <div class="prose max-w-none">
            @if($page->display_title ?? true)
                @section('before-title')
                @show
                @section('title')
                    <h1>{{ $page->title }}</h1>
                @show
                @section('before-title')
                @show
            @endif
            @section('content')
                @if( ! $ignoreFeaturedImage )
                    <x--media-image-renderer :mediaImage="$page->featured_image_id" class="w-full" />
                @endif
                {!! $page->content !!}
            @show
        </div>
        {{ $slot }}
    </div>

    <x-content-blocks :blocks="$page->content_blocks ?? []" />

</div>
