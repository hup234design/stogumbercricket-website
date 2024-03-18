@props(['slider' => null])

<div class="">
    @if($slider)
        <div x-data="{swiper: null}"
             x-init="swiper = new Swiper($refs.container, {
                autoplay: {
                    delay: 10000,
                },
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                effect: 'fade',
                navigation: {
                    enabled: true,
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                }
             })"
             class="relative"
        >
            <div class="swiper-container w-full h-full" x-ref="container">
                <div class="swiper-wrapper h-full ">
                    @foreach($slider->slides as $slide)
                        <div class="swiper-slide max-w-full bg-black">
                            <x--media-image-renderer
                                :mediaImage="$slide->media_image_id"
                                class="absolute object-cover object-center w-full h-full opacity-80"
                            />
                            <div class="relative pt-48 pb-16 lg:pt-64">
                                <div class="container mx-auto flex items-center justify-center min-h-[400px]">
                                    <div class="text-center">
                                        <div class="space-y-6">
                                            @if( $slide->subheading )
                                                <span class="text-white font-extrabold uppercase tracking-widest text-shadow">
                                                    {{ $slide->subheading }}
                                                </span>
                                            @endif
                                            <h2 class="text-4xl lg:text-5xl font-black text-white text-shadow">
                                                {{ $slide->heading }}
                                            </h2>
                                            @if( trim($slide->text) )
                                                <p class="max-w-3xl mx-auto text-lg text-white px-16 font-bold text-shadow">
                                                    {!! nl2br($slide->text)  !!}
                                                </p>
                                            @endif
                                        </div>
                                        {{--                                    <div class="mt-12 flex justify-center items-center">--}}
                                        {{--                                        <a class="inline-block w-full md:w-auto mb-4 md:mr-6 py-5 px-8 text-sm font-bold uppercase border-2 border-transparent bg-white hover:bg-yellow-400 text-red-900 transition duration-200" href="#">--}}
                                        {{--                                            LINK ONE--}}
                                        {{--                                        </a>--}}
                                        {{--                                        <a class="inline-block w-full md:w-auto mb-2 py-5 px-8 text-sm text-white font-bold uppercase border-2 border-transparent bg-red-900 hover:border-blue-700" href="#">--}}
                                        {{--                                            LINK TWO--}}
                                        {{--                                        </a>--}}
                                        {{--                                    </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-button-next mt-16"></div>
                <div class="swiper-button-prev mt-16"></div>
            </div>
        </div>
    @endif
</div>
