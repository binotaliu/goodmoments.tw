<x-layout title="交通">
    <x-slot:headerExtensions>
        @vite(['resources/js/leaflet.js', 'resources/css/leaflet.css'])
    </x-slot:headerExtensions>

    <div class="w-screen">
        <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
            <h2 class="text-3xl">交通資訊</h2>
        </div>
    </div>

    <div
        id="map"
        x-data="{ map: null, marker: null }"
        x-init="
            () => {
                map = leaflet.map('map', { zoomControl: false, boxZoom: false, doubleClickZoom: false, dragging: false, keyboard: false, scrollWheelZoom: false, touchZoom: false }).setView([23.0092, 120.3948], 12);
                leaflet.tileLayer({{ Js::from(config('services.map.tileLayer')) }}, {
                    attribution: {{ Js::from(config('services.map.tileLayerAttribution')) }}
                }).addTo(map);

                marker = leaflet.marker([23.00733, 120.41476]).addTo(map);
            }
        "
        class="mb-16 h-[70vh]"
    ></div>

    <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
        <div class="flex justify-center gap-x-2 mb-16">
            <x-external-link
                href="http://maps.apple.com/?ll=23.00733,120.41476"
                class="px-4 py-2 text-white bg-wood-500 hover:bg-wood-400 transition-colors"
            >
                在 Apple 地圖中開啟
            </x-external-link>
            <x-external-link
                href="https://www.google.com/maps/search/?api=1&query=%E5%8F%B0%E5%8D%97%E5%B8%82%E5%B7%A6%E9%8E%AE%E5%8D%80%E5%85%AC%E8%88%98%E7%A4%BE%E5%8D%80%E7%99%BC%E5%B1%95%E5%8D%94%E6%9C%83&place_id=ChIJ2QOMREJvbjQRV9XTj48CFGo"
                class="px-4 py-2 text-white bg-wood-500 hover:bg-wood-400 transition-colors"
            >
                在 Google Maps 中開啟
            </x-external-link>
        </div>

        <div class="prose lg:prose-xl">
            {!! $travelDescription['zh_Hant_TW'] ?? '' !!}
        </div>
    </div>
</x-layout>
