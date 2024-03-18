<div>

    <div class="grid  gap-4 lg:grid-cols-3">
        @foreach($data['features'] as $feature)
            <div class="prose max-w-none text-center hover:shadow-lg p-4">

                {{--<div class="inline-flex h-12 w-12 mx-auto items-center justify-center text-white bg-green-500 rounded-full">--}}
                {{--<x-icon name="{{ $feature['icon'] }}" class="w-8 h-8"/>--}}
                {{--</div>--}}

                <h2 class="mt-4">
                    {{ $feature['title'] }}
                </h2>
                <p>
                    {!! nl2br($feature['text']) !!}
                </p>
            </div>
        @endforeach
    </div>

</div>
