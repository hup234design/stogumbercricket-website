<footer class="bg-gray-950 text-gray-200">
    <div class="container py-12">
        <div class="grid sm:grid-cols-2 gap-24 lg:grid-cols-4 lg:gap-12">
            <div class="">
                <div class="inline-block text-center space-y-4">
                    <div class="w-28 rounded-full overflow-hidden mx-auto">
                        <a href="{{ route('home') }}">
                            <img src="{{ url('images/logo.png') }}" class="w-28">
                        </a>
                    </div>

                    <p>Stogumber Cricket Club</p>
                    <p>Station Road, Stogumber<br>Somerset TA4 3TB</p>
                    <p>stogumbercc@gmail.com</p>

                    <a href="https://www.facebook.com/stogumbercricketclub" target="_blank" alt="facebook" class="inline-block w-5 h-5 text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none" viewBox="0 0 24 24">
                            <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path>
                        </svg>
                    </a>

                    <div class="pt-8">
                        <p class="text-xs">PROUDLY SPONSORED BY</p>
                        <a href="https://www.harrisresidential.co.uk/" target="_blank">
                            <img class="mt-4 w-48" src="https://www.harrisresidential.co.uk/index_htm_files/592@2x.png" alt="">
                        </a>
                    </div>

                </div>
            </div>
            <div>
                <h3 class="inline-block font-bold pb-2 border-b border-gray-400">UPCOMING FIXTURES</h3>

                <div class="space-y-6 mt-6">
                    @forelse( $upcomingFixtures as $upcomingFixtures)
                        <div class="space-y-1">
                            <p class="text-xs">
                                {{ $upcomingFixtures->date->format('Y-m-d') }}
                                (<span class="ml-1 font-extrabold">{{ $upcomingFixtures->home ? 'Home' : 'Away' }}</span>)
                            </p>
                            <p class="font-semibold">
                                {{ $upcomingFixtures->team->name }}
                            </p>
                            <p class="text-sm text-gray-200">
                                Vs. {{ $upcomingFixtures->opponent->name }}</p>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div>
                <h3 class="inline-block font-bold pb-2 border-b border-gray-400">UPCOMING EVENTS</h3>
                <div class="space-y-6 mt-6">
                    @forelse( $upcomingEvents as $upcomingEvent)
                        <div class="">
                            <p class="mb-2 text-xs">
                                {{ $upcomingEvent->date->format('Y-m-d') }}
                            </p>
                            <a class="leading-tight hover:text-gray-200 cursor-pointer" href="{{ route('event', $upcomingEvent->slug) }}" >
                                {{ $upcomingEvent->title }}
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <div>
                <h3 class="inline-block font-bold pb-2 border-b border-gray-400">LATEST NEWS</h3>
                <div class="space-y-6 mt-6">
                    @forelse( $latestPosts as $latestPost)
                        <div class="">
                            <p class="mb-2 text-xs">
                                {{ $latestPost->publish_at->format('Y-m-d') }}
                            </p>
                            <a class="leading-tight hover:text-gray-200 cursor-pointer" href="{{ route('post', $latestPost->slug) }}" >
                                {{ $latestPost->title }}
                            </a>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="mt-16 mb-8">
            <nav class="flex justify-center items-center divide-x leading-none">
                @foreach( $menuLinks ?? [] as $link)
                    @if( $link['href'] )
                        <a class="px-4 text-white" href="{{ $link['href'] }}" target="{{ $link['target'] }}">
                            {{ $link['label'] }}
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>
        <div class="text-center">
            <div>© 2023 Stogumber Cricket Club. All rights reserved.</div>
        </div>
    </div>
</footer>
