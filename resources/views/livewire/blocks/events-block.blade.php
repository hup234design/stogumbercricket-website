<div class="grid gap-16 lg:grid-cols-3">
    @foreach( $events as $event )
        <div class="flex flex-col">
            <div class="relative w-full">
                <div class="aspect-w-3 aspect-h-2">
                    <x--media-image-renderer :mediaImage="$event->featured_image_id" conversion="thumbnail" class="w-full h-full object-center object-cover rounded-lg" />
                </div>
                @if( $event->event_category_id)
                    <span class="absolute top-0 right-0 mt-4 mr-4 inline-block text-xs px-2 py-1 bg-white rounded uppercase font-semibold">
                            {{ $event->event_category->title }}
                        </span>
                @endif
            </div>
            <div class="mt-4 flex-1 prose prose max-w-none">
                <p class="mb-0 inline-block text-xs font-bold">
                    {{ $event->date->format('l jS F Y') }}
                </p>
                <h2 class="mt-2 mb-4">
                    {{ $event->title }}
                </h2>
                <p class="">
                    {!! nl2br($event->summary) !!}
                </p>
            </div>
            <a href="{{ route('event', $event->slug) }}" class="mt-8 flex items-center font-bold no-underline text-lg hover:text-indigo-700" href="#">
                <span>Read more</span>
                <x-heroicon-s-chevron-right class="ml-1 w-4 h-4" />
            </a>
        </div>
    @endforeach
</div>
