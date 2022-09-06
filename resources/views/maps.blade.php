<x-layout title="交通">
    <x-slot:headerExtensions>
        @vite(['resources/js/leaflet.js', 'resources/css/leaflet.css'])
    </x-slot:headerExtensions>

    <div class="w-screen">
        <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-8">
            <h2 class="text-3xl">交通資訊</h2>
        </div>
    </div>

    <div
        id="map"
        x-data="{ map: null, marker: null }"
        x-init="
            () => {
                map = leaflet.map('map', { zoomControl: true, boxZoom: false, doubleClickZoom: false, dragging: true, keyboard: false, scrollWheelZoom: false, touchZoom: false }).setView([23.0092, 120.3948], 12);
                leaflet.tileLayer({{ Js::from(config('services.map.tileLayer')) }}, {
                    attribution: {{ Js::from(config('services.map.tileLayerAttribution')) }}
                }).addTo(map);

                marker = leaflet.marker([23.00733, 120.41476]).addTo(map);
            }
        "
        class="mb-4 h-[70vh]"
    ></div>

    <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-16 flex flex-col center-center">
        <div class="inline-flex md:w-full flex-col md:flex-row-reverse md:items-center md:justify-between gap-4 mb-16">
            @if(Agent::is('iOS') || Agent::is('iPad OS') || Agent::is('OS X'))
                <div class="flex flex-col md:flex-row justify-center">
                    <x-map-links.apple size="lg" theme="primary" />
                </div>
                <div class="flex flex-col md:flex-row justify-center gap-2">
                    <x-map-links.osm />
                    <x-map-links.google />
                </div>
            @elseif(Agent::is('Linux') && !Agent::is('Android'))
                <div class="flex justify-center">
                    <x-map-links.osm size="lg" theme="primary" />
                </div>
                <div class="flex flex-col md:flex-row justify-center gap-2">
                    <x-map-links.apple />
                    <x-map-links.google />
                </div>
            @else
                <div class="flex justify-center">
                    <x-map-links.google size="lg" theme="primary" />
                </div>
                <div class="flex flex-col md:flex-row justify-center gap-2">
                    <x-map-links.osm />
                    <x-map-links.apple />
                </div>
            @endif
        </div>

        <div class="prose lg:prose-xl">
            {!! $travelDescription['zh_Hant_TW'] ?? '' !!}
        </div>
    </div>
</x-layout>