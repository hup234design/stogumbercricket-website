<x-posts-layout>

    <x-page-content :page="$page">

        @section('title')
        @stop

        <div
            @class([
                "divide-y-2",
                "mt-12" => trim(strip_tags($page->content)) != ""
            ])
        >
            @foreach( $posts as $post)
                <div class="pt-8 pb-8 first:pt-0 last:pb-0 flex gap-8">
                    <div class="w-1/3">
                        <x--media-image-renderer :mediaImage="$post->featured_image_id" conversion="thumbnail" class="w-full" />
                    </div>
                    <div class="flex-1 prose max-w-none">
                        <h2 class="mb-2">{{ $post->title }}</h2>
                        <p class="text-sm text-gray-600 my-0">{{ $post->publish_at->format('l jS F Y') }}</p>
                        <p class="line-clamp-3">{!! nl2br($post->summary) !!}</p>
                        <a
                            href="{{ route('post', $post->slug) }}"
                            class="px-4 py-2 bg-gray-800 text-white no-underline rounded-xl hover:bg-red-800"
                        >
                            READ MORE
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-16">
            {{ $posts->links() }}
        </div>

    </x-page-content>

</x-posts-layout>
