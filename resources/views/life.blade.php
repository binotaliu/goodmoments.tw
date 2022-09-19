<x-layout title="食衣住行育樂">
    <main class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
        <div class="flex flex-col gap-y-8">
            @foreach($blocks as $block)
                <div class="flex items-center gap-x-4">
                    @if($block['text_position'] === 'right')
                        <div class="w-1/8">
                            <img src="{{ $block['image'] }}" alt="{{ $block['image_description']['zh_Hant_TW'] }}" />
                        </div>
                    @endif
                    <div class="w-7/8 flex flex-col gap-2">
                        <h2 class="text-2xl font-bold text-pearl-800">{{ $block['title']['zh_Hant_TW'] }}</h2>
                        <p class="text-sm text-wood-700">{{ $block['text']['zh_Hant_TW'] }}</p>
                    </div>
                    @if($block['text_position'] === 'left')
                        <div class="w-1/8">
                            <img src="{{ $block['image'] }}" class="w-full" alt="{{ $block['image_description']['zh_Hant_TW'] }}" />
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </main>
</x-layout>
