@if ($mediaImage)

    @if( $lightbox )
        <a data-fslightbox href="{{ $mediaImage->media[0]->getUrl() }}">
            <img src="{{ $mediaImage->media[0]->getUrl($conversion) }}"
                 alt="{{ $mediaImage->alt }}"
                {{ $attributes }}
            />
        </a>

    @else

        <img src="{{ $mediaImage->media[0]->getUrl($conversion) }}"
         alt="{{ $mediaImage->alt }}"
            {{ $attributes }}
        />

    @endif

@endif
