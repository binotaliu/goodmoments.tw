<x-layout title="">
    <div class="max-w-4xl mx-auto mb-32 px-6">
        <div class="flex gap-8">
            <div class="w-3/5">
                <img class="w-full" src="{{ $product->cover_image->url }}" alt="{{ $product->name }} 封面圖片" />
            </div>
            <div class="w-2/5 flex flex-col gap-y-6">
                <div class="flex flex-col items-start gap-y-2">
                    <h2 class="text-4xl">{{ $product->name }}</h2>
                    <span class="text-2xl">${{ number_format($product->price) }}/{{ $product->unit }}</span>
                    @if ($product->store_url)
                        <x-external-link
                            href="{{ $product->store_url }}"
                            class="inline-flex center-center gap-2 px-4 py-2 bg-sun-500 hover:bg-sun-400 text-pearl-100 transition-colors"
                        ><x-bx-cart class="w-4 h-4" /> {{ $product->store_url_text }}</x-external-link>
                    @endif
                </div>
                <p>{{ $product->description }}</p>
            </div>
        </div>
    </div>
</x-layout>
