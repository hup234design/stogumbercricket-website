<div>

    <div class="divide-y-2">
        @foreach($downloads as $download)
            <div class="prose max-w-none py-8">
                <!-- Title as a clickable link for download -->
                <h3><a href="{{ asset($download->file) }}" download="{{ $download->title }}">{{ $download->title }}</a></h3>
                <!-- Description -->
                <p>{{ $download->description }}</p>
            </div>
        @endforeach
    </div>

</div>
