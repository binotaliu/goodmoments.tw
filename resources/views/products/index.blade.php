<x-layout :title="$category === null ? '產品列表' : $category->name . ' – 產品列表'">
    <div class="max-w-4xl mx-auto mb-32 px-6">
        @empty($category)
            <div class="flex flex-wrap gap-2 mb-8">
                @foreach ($categories as $c)
                    <x-link-button :href="route('categories.products.index', $c)">
                        {{ $c->name }}
                    </x-link-button>
                @endforeach
            </div>
        @endempty

        <div class="flex flex-col gap-6">
            @if($category === null)
                <h2 class="text-2xl">所有產品</h2>
            @else
                <h2 class="text-2xl">{{ $category->name }}</h2>
            @endif
            <div class="grid grid-cols-4 gap-x-4 gap-y-12">
                @foreach($products as $product)
                    <div class="flex flex-col gap-1 group">
                        <div class="overflow-hidden">
                            <a
                                href="{{ route('categories.products.show', [$product->category, $product]) }}"
                                class="block"
                            >
                                <img
                                    class="group-hover:motion-safe:scale-[1.03] transition-transform"
                                    src="{{ $product->cover_image->url  }}"
                                    alt="{{ $product->name }} 圖片"
                                />
                            </a>

                        </div>
                        <div class="flex justify-between items-center">
                            <dl>
                                <dt class="sr-only">售價</dt>
                                <dd class="text-pearl-900">
                                    <span class="text-sm text-pearl-800">NT$</span>{{ number_format($product->price) }}
                                    <small class="text-sm">/ {{ $product->unit }}</small>
                                </dd>
                            </dl>

                            <a
                                class="rounded px-2 py-1 text-sm text-white bg-wood-500 hover:bg-wood-400 transition-colors"
                                href="{{ route('categories.products.show', [$product->category, $product]) }}"
                            >
                                瞭解詳情
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{ $products->links() }}
        </div>
    </div>
</x-layout>
