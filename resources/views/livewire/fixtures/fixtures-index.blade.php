<div class="">
    {{--    <div class="prose max-w-none">--}}
    {{--        @if($data['heading'] ?? false )--}}
    {{--            <h2>{{ $data['heading'] }}</h2>--}}
    {{--        @endif--}}
    {{--    </div>--}}


    <div class="mt-16 space-y-1">

        <div class="flex items-center justify-center space-x-8 mb-8 bg-blue-900 py-4 divide-x">
            <button
                wire:click="toggleActiveView('fixtures')"
                class="flex-1"
            >
                <span @class([
                    "text-white font-semibold text-lg leading-1",
                    "border-b-2 border-white" => $active_view == "fixtures"
                ])>
                    UPCOMING FIXTURES
                </span>
            </button>
            <button
                wire:click="toggleActiveView('results')"
                class="flex-1"
            >
                <span @class([
                    "text-white font-semibold text-lg leading-1",
                    "border-b-2 border-white" => $active_view == "results"
                ])>
                    ALL RESULTS
                </span>
            </button>
        </div>

        @if( $active_view == "fixtures")

            @forelse( $fixtures as $fixture)
                <div class="px-4 py-2 bg-gray-100 font-bold">
                    <span>{{ $fixture->formatted_date }}</span>
                </div>
                <div class="mx-8 bg-blue-50">
                    <div @class([
                "flex flex-row justify-center divide-x divide-gray-400 py-2",
            ])>
                <span class="px-2">
                    {{ $fixture->formatted_start_time }}
                </span>
                        <span class="px-2">
                    {{ $fixture->venue->name }}
                </span>
                    </div>
                    <div @class([
                "flex flex-row justify-center py-4",
                "flex-row-reverse" => ! $fixture->home
            ])>
                        <div class="flex-1 text-center">
                            <span class="font-bold">{{ $fixture->team->name }}</span>
                        </div>
                        <span class="block rounded-full bg-gray-500 text-white h-6 w-6 text-sm flex items-center justify-center leading-none">Vs</span>
                        <div class="flex-1 text-center">
                            <span class="font-bold">{{ $fixture->opponent->name }}</span>
                        </div>
                    </div>
                </div>
            @empty
                {{--    --}}
            @endforelse

        @else

            @forelse( $results as $fixture)
                <div class="px-4 py-2 bg-gray-100 font-bold">
                    <span>{{ $fixture->formatted_date }}</span>
                </div>
                <div class="mx-8 bg-blue-50">
                    <div class="text-center py-2 font-bold">
                        {{ $fixture->result ?: "?" }}
                    </div>
                    <div @class([
                "flex flex-row justify-center py-4 leading-none",
                "flex-row-reverse" => ! $fixture->home
            ])>
                        <div class="flex-1 text-center">
                            <div class="inline-flex flex-col space-y-2">
                                <span class="font-bold">{{ $fixture->team->name }}</span>
                                <span class="">
                                    <span class="text-lg">{{ $fixture->runs }}</span>
                                    <span> / {{ $fixture->wickets }} ({{ $fixture->overs }})</span>
                                </span>
                                @if( trim($fixture->note) )
                                    <span class="font-semibold"><small>{{ $fixture->note }}</small></span>
                                @endif
                            </div>
                        </div>
                        <span class="block rounded-full bg-gray-500 text-white h-6 w-6 text-sm flex items-center justify-center leading-none">Vs</span>
                        <div class="flex-1 text-center">

                            <div class="inline-flex flex-col space-y-2">
                                <span class="font-bold">{{ $fixture->opponent->name }}</span>
                                <span class="">
                                    <span class="text-lg">{{ $fixture->opponent_runs }}</span>
                                    <span> / {{ $fixture->opponent_wickets }} ({{ $fixture->opponent_overs }})</span>
                                </span>
                                @if( trim($fixture->opponent_note) )
                                    <span class="font-semibold"><small>{{ $fixture->note }}</small></span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{--    --}}
            @endforelse

        @endif
    </div>
</div>
