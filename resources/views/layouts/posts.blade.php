<x-app-layout>

    <div class="container mb-16 lg:flex lg:divide-x-2 lg:mb-0">

        <div class="lg:flex-1 lg:pr-8">

            {{ $slot  }}

        </div>

        <div class="prose lg:w-72 lg:pl-8">

{{--            <h2>Featured Posts</h2>--}}

{{--            @foreach($featuredPosts as $post)--}}
{{--                <a href="{{ route('post', $post->slug) }}" class="block no-underline">--}}
{{--                    <h4 class="my-0">{{ $post->title }}</h4>--}}
{{--                    <p class="small text-gray-700">{{ $post->publish_at->date->format('l jS F Y') }}</p>--}}
{{--                </a>--}}
{{--            @endforeach--}}

            <h2>Recent Posts</h2>

            <div class="space-y-6">
            @foreach($latestPosts as $post)
                <a href="{{ route('post', $post->slug) }}" class="block no-underline space-y-1">
                    <p class="text-sm text-gray-600 my-0">{{ $post->publish_at->format('l jS F Y') }}</p>
                    <h4 class="my-0">{{ $post->title }}</h4>
                </a>
            @endforeach
            </div>

{{--            <h2>Categories</h2>--}}

{{--            @foreach( $categories as $category )--}}

{{--                <p>--}}
{{--                    {{ $category->title }} ( {{ $category->visible_posts_count }} )--}}
{{--                </p>--}}
{{--            @endforeach--}}

        </div>

    </div>

</x-app-layout>
