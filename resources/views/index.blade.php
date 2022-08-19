<x-layout>
    <section class="-mt-8 mb-16 bg-wood-100">
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
                                            src="{{ $banner->image->url }}"
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

    @if($articles->isNotEmpty())
        <section class="max-w-4xl mx-auto mb-16">
            <h3 class="text-2xl text-wood-700 mb-4">最新消息</h3>
            <div>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8 mb-4">
                    @foreach($articles as $article)
                        <li class="mb-2 last:mb-0">
                            <x-article-block :article="$article" />
                        </li>
                    @endforeach
                </ul>

                <div class="text-right">
                    <a
                        href="{{ route('articles.index') }}"
                        class="inline-block px-4 py-2 bg-wood-500 hover:bg-wood-400 text-white text-semibold transition-colors"
                    >更多資訊</a>
                </div>
            </div>
        </section>
    @endif
</x-layout>
