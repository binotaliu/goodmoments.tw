<x-layout>
    <section class="-mt-8 bg-wood-100">
        <h3 class="sr-only">最新活動</h3>

        <div class="max-w-4xl mx-auto">
            <div
                x-data
                x-init="new Swiper($refs.swiperEl, {
                    speed: 400,
                    autoHeight: false,

                    direction: 'horizontal',
                    loop: true,

                    autoplay: { delay: 10000 },

                    pagination: {
                      el: '.swiper-pagination'
                    },

                    navigation: {
                      nextEl: '.swiper-button-next',
                      prevEl: '.swiper-button-prev'
                    }
                })"
            >
                <div class="swiper overflow-visible" x-ref="swiperEl">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            <div class="swiper-slide group">
                                <div href="{{ $banner->url }}" class="flex flex-col">
                                    <x-external-link class="overflow-hidden" :href="$banner->url">
                                        <img
                                            src="https://picsum.photos/2560/960?random={{ $banner->image->url }}"
                                            width="2560"
                                            height="960"
                                            alt="{{ $banner->image_description }}"
                                            class="group-hover:motion-safe:scale-[1.03] transition-transform"
                                        />
                                    </x-external-link>
                                    <div class="py-1 px-4">
                                        <h4 class="text-lg font-medium">
                                            <x-external-link
                                                class="text-gray-600 group-hover:text-gray-400 transition-colors"
                                                :href="$banner->url"
                                            >
                                                {{ $banner->title }}
                                            </x-external-link>
                                        </h4>
                                        @if($banner->description)
                                            <p>
                                                <x-external-link
                                                    class="text-gray-500 group-hover:text-gray-300 transition-colors"
                                                    :href="$banner->url"
                                                >
                                                    {{ $banner->description }}
                                                </x-external-link>
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination text-right mr-4"></div>

                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                    <div class="swiper-scrollbar"></div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
