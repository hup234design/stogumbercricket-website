<x-app-layout>

    <div class="container mb-16 lg:flex lg:divide-x-2 lg:mb-0">

        <div class="lg:flex-1 lg:pr-8">

            {{ $slot  }}

        </div>

        <div class="prose lg:w-72 lg:pl-8">

            <h2>Upcoming Events</h2>

            <div class="space-y-6">
                @foreach($upcomingEvents as $event)
                    <a href="{{ route('event', $event->slug) }}" class="block no-underline space-y-1">
                        <p class="text-sm text-gray-600 my-0">{{ $event->formatted_date }}</p>
                        <h4 class="my-0">{{ $event->title }}</h4>
                    </a>
                @endforeach
            </div>

{{--            <h2>Categories</h2>--}}

{{--            @foreach( $categories as $category )--}}
{{--                <p>--}}
{{--                    {{ $category->title }} ( {{ $category->upcoming_events_count }} )--}}
{{--                </p>--}}
{{--            @endforeach--}}

        </div>

    </div>

</x-app-layout>
