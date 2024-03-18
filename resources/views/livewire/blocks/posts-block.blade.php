{{--<div>--}}
{{--    <div class="grid gap-12 lg:grid-cols-3">--}}

{{--        @foreach( $posts as $post )--}}
{{--            <div class="shadow-lg bg-white">--}}
{{--                <x--media-image-renderer :mediaImage="$post->featured_image_id" conversion="thumbnail" class="w-full" />--}}
{{--                <div class="prose prose-sm px-4 py-8">--}}
{{--                    <h2>--}}
{{--                        {{ $post->title }}--}}
{{--                    </h2>--}}
{{--                    <p class="font-semibold">--}}
{{--                        {{ $post->publish_at->format('l jS F Y') }}--}}
{{--                    </p>--}}
{{--                    <p class="line-clamp-3">--}}
{{--                        {{ $post->summary }}--}}
{{--                    </p>--}}
{{--                    <div class="mt-12">--}}
{{--                        <a href="{{ route('post', $post->slug) }}" class="no-underline px-6 py-2 rounded-lg bg-gray-200">--}}
{{--                            Read More--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}

    <div class="grid gap-16 lg:grid-cols-3">
        @foreach( $posts as $post )
            <div class="flex flex-col">
                <div class="relative w-full">
                    <div class="aspect-w-3 aspect-h-2">
                        <x--media-image-renderer :mediaImage="$post->featured_image_id" conversion="thumbnail" class="w-full h-full object-center object-cover rounded-lg" />
                    </div>
                    @if( $post->post_category_id)
                        <span class="absolute top-0 right-0 mt-4 mr-4 inline-block text-xs px-2 py-1 bg-white rounded uppercase font-semibold">
                            {{ $post->post_category->title }}
                        </span>
                    @endif
                </div>
                <div class="mt-4 flex-1 prose prose max-w-none first:mt-0">
                    <p class="mb-0 inline-block text-xs font-bold">
                        {{ $post->publish_at->format('l jS F Y') }}
                    </p>
                    <h2 class="mt-2 mb-4">
                        {{ $post->title }}
                    </h2>
                    <p class="">
                        {!! nl2br($post->summary) !!}
                    </p>
                </div>
                <a href="{{ route('post', $post->slug) }}" class="mt-8 flex items-center font-bold no-underline text-lg hover:text-indigo-700" href="#">
                    <span>Read more</span>
                    <x-heroicon-s-chevron-right class="ml-1 w-4 h-4" />
                </a>
            </div>
        @endforeach
    </div>
