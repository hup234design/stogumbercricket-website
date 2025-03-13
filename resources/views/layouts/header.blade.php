<header class="fixed top-0 inset-x-0 bg-black/70 z-50 h-32 lg:h-48">
    <div class="hidden lg:block">
        <div class="absolute left-0 mt-4 ml-8 flex flex-col items-center">
            @if($sponsor)
                <div class="text-gray-200 text-xs">PROUDLY SPONSORED BY</div>
                @if($sponsor->url)
                    <a href="{{ $sponsor->url }}" target="_blank">
                        <img class="mt-4 w-48" src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }} Logo">
                    </a>
                @else
                    <img class="mt-4 w-48" src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }} Logo">
                @endif
            @endif
        </div>
        <div class="absolute right-0 mr-8 mt-4 text-center">
            @if($name = trim(cms('contact_name')))
                <p class="font-extrabold text-lg text-white">{{ cms('contact_name') }}</p>
            @endif
            @if($address = trim(cms('contact_address')))
                    <p class="text-gray-200">{!! nl2br($address)  !!} </p>
            @endif
            @if($telephone = trim(cms('contact_telephone')))
                <p class="text-gray-200">
                    <a href="tel:{{ $telephone }}" class="hover:cursor-pointer hover:underline">
                        {{ $telephone }}
                    </a>
                </p>
            @endif
            @if($email = trim(cms('contact_email')))
                <p class="text-gray-200">
                    <a href="mailto:{{ $email }}" class="hover:cursor-pointer hover:underline">
                        {{ $email }}
                    </a>
                </p>
            @endif
        </div>
        <div class="w-full h-48 flex flex-col justify-between items-center">
            <div class="mt-4 w-28 rounded-full overflow-hidden z-50">
                <a href="{{ route('home') }}">
                    <img src="{{ url('/images/logo.png') }}" class="w-28">
                </a>
            </div>
            <nav class="">
                <ul class="w-full h-16 flex justify-center text-white">
                    @foreach( $menuLinks ?? [] as $link)
                        <li class="group px-6">
                            @if( $link['dropdown'] )
                                <div class="relative group">
                                    @if( $link['href'] )
                                        <a href="{{ $link['href'] }}" target="{{ $link['target'] }}" class="h-16 font-semibold rounded flex items-center  hover:text-red-700">
                                            <span>{{ $link['label'] }}</span>
                                            <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 12l-6-6h12l-6 6z"/></svg>
                                        </a>
                                    @else
                                        <button class="h-16  font-semibold rounded flex items-center  hover:text-red-700">
                                            <span>{{ $link['label'] }}</span>
                                            <svg class="fill-current h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 12l-6-6h12l-6 6z"/></svg>
                                        </button>
                                    @endif
                                    <div class="hidden group-hover:block absolute right-0 -mr-2 z-50" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        <div class="relative mt-2 text-right border rounded-md shadow-lg py-1 bg-white whitespace-nowrap min-w-[160px]" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            @foreach( $link['children'] as $child )
                                                <a href="{{ $child['href'] }}" target="{{ $link['target'] }}" class="block px-8 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 hover:text-red-700" role="menuitem">
                                                    {{ $child['label'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ $link['href'] }}" target="{{ $link['target'] }}" class="h-16 font-semibold rounded flex items-center  hover:text-red-700">
                                    {{ $link['label'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    <div  x-data="{ isOpen: false }" class="relative block text-white lg:hidden">

        <div class="h-8 bg-black text-center flex items-center justify-center">
            <span class="font-bold text-sm lwading-none">STOGUMBER CRICKET CLUB</span>
        </div>
        <div class="container h-24 flex items-center justify-between">
            <div class="w-20 h-20 rounded-full overflow-hidden z-50">
                <a href="{{ route('home') }}">
                    <img src="{{ url('/images/logo.png') }}" class="w-20 h-20">
                </a>
            </div>
            <div>
                <!-- Button to open/close menu -->
                <button @click="isOpen = !isOpen" class="px-4 py-2">
                    <x-heroicon-s-bars-3 class="w-12 h-12 text-white" />
                </button>
            </div>
        </div>

        <!-- Menu -->
        <div
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="transform opacity-0 translate-y-full"
            x-transition:enter-end="transform opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="transform opacity-100 translate-y-0"
            x-transition:leave-end="transform opacity-0 -translate-y-full"
            class="fixed top-0 left-0 w-full h-full overflow-y-scroll bg-black z-50"
            style="overflow-y: auto;"
        >
            <!-- Close button -->
            <button @click="isOpen = false" class="absolute top-0 right-0 p-2">
                <x-heroicon-s-x-mark class="w-10 h-10 text-white" />
            </button>

            <nav class="mt-8 mr-6">
                <ul class="text-center space-y-3">
                    @foreach( $menuLinks ?? [] as $link)
                        @if( $link['href'] )
                            <li class="uppercase">
                                <a href="{{ $link['href'] }}" target="{{ $link['target'] }}" class="text-lg font-normal">{{ $link['label'] }}
                            </li>
                        @endif
                        @if( $link['dropdown'] )
                            @foreach( $link['children'] as $child )
                                @if( $child['href'] )
                                    <li class="uppercase">
                                        <a href="{{ $child['href'] }}" target="{{ $child['target'] }}" class="text-lg font-normal">{{ $child['label'] }}
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </nav>

            <div class="mx-6 border-t border-gray-400 mt-8 pt-8 text-center">
                <p class="font-bold text-lg text-white">Stogumber Cricket Club</p>
                <p class="text-sm text-gray-200">Station Road, Stogumber</p>
                <p class="text-sm text-gray-200">Somerset TA4 3TB</p>
                <p class="text-sm text-gray-200">stogumbercc@gmail.com</p>
            </div>

            <div class="mt-8 flex flex-col items-center">
                <div class="text-gray-200 text-xs">PROUDLY SPONSORED BY</div>
                <a href="https://www.harrisresidential.co.uk/" target="_blank">
                    <img class="mt-4 w-48" src="https://www.harrisresidential.co.uk/index_htm_files/592@2x.png" alt="Harris Residential Logo">
                </a>
            </div>

        </div>

    </div>
</header>
