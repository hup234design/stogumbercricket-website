<x-services-layout>

    <x-page-content :page="$page">

        @section('title')
        @stop

        <div
            @class([
                "divide-y-2",
                "mt-12" => trim($page->content)
            ])
        >
            @foreach( $services as $service)
                <div class="pt-8 pb-8 first:pt-0 last:pb-0">
                    <div class="prose max-w-none">
                        <h2>{{ $service->title }}</h2>
                        <p>{!! nl2br($service->summary) !!}</p>
                        <a
                            href="{{ route('service', $service->slug) }}"
                            class="px-4 py-2 bg-gray-800 text-white no-underline rounded-xl hover:bg-red-800"
                        >
                            READ MORE
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </x-page-content>

</x-services-layout>
