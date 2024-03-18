<div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-16">
        @foreach( $club_officers as $club_officer)
            <div class="prose max-w-none text-center">
                @if($club_officer->media_image_id)
                    <x--media-image-renderer
                        :mediaImage="$club_officer->media_image_id"
                        conversion="thumbnail"
                        class="w-3/4 mx-auto aspect-square rounded-full"
                    />
                @else
                    <div class="w-3/4 mx-auto aspect-square bg-black rounded-full"></div>
                @endif
                <h3>
                    {{ $club_officer->name  }}
                </h3>
                <h4>
                    {{ $club_officer->role  }}
                </h4>
                <p>
                    {{ nl2br( $club_officer->description ) }}
                </p>
            </div>
        @endforeach
    </div>
</div>
