@props(['title'])

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#9b8b6e">
    @if($title)
        <title>{{ $title }} — 好時・左鎮公舘</title>
    @else
        <title>好時・左鎮公舘</title>
    @endif

    @stack('header-extensions')
    @vite(['resources/css/app.css', 'resources/js/app.js'], 'build/front')
</head>
<body class="overflow-x-hidden antialiased">

<header class="w-screen border-t-8 border-t-wood-600 mb-8" x-data="{ showMenu: false }">
    <div class="flex justify-between md:justify-center items-center px-4 border-b md:border-b-0 border-wood-600">
        <div class="flex md:flex-col justify-start md:justify-center items-center gap-1 sm:gap-2 py-6">
            <img class="w-14 sm:w-16 md:w-24" src="{{ asset('images/logo.svg') }}" alt="好時・左鎮公舘 LOGO" />
            <img class="h-10 sm:h-14 md:w-36" src="{{ asset('images/text-logo.svg') }}" alt="好時・左鎮公舘" />
        </div>

        <button
            class="md:hidden border border-wood-600 rounded px-2 py-1 bg-white hover:bg-wood-600 text-wood-600 hover:text-white transition-colors"
            @click="showMenu = !showMenu"

        >
            <x-bx-menu class="w-8 h-8" />
        </button>
    </div>

    <nav class="bg-wood-600" role="navigation">
        <div class="max-w-4xl mx-auto md:block" x-bind:class="{ 'hidden': !showMenu }">
            <ul class="flex flex-col md:flex-row justify-start items-stretch md:px-4">
                <x-layout.nav-item href="{{ url('/') }}">首頁</x-layout.nav-item>
                <x-layout.nav-item href="{{ url('products') }}" active>特色產品</x-layout.nav-item>
                <x-layout.nav-item href="{{ url('categories/workshops') }}">體驗課程</x-layout.nav-item>
                <x-layout.nav-item href="{{ url('about') }}">關於我們</x-layout.nav-item>
                <x-layout.nav-item href="{{ url('guide') }}">食衣住行育樂</x-layout.nav-item>
                <x-layout.nav-item href="{{ url('maps') }}">交通資訊</x-layout.nav-item>
                <x-layout.nav-item href="{{ url('contact') }}">聯絡我們</x-layout.nav-item>
            </ul>
        </div>
    </nav>
</header>

{{ $slot }}

<footer class="bg-wood-600 text-white">
    <div class="max-w-4xl mx-auto px-4 mx:px-6">
        <div class="flex flex-col-reverse md:flex-row justify-between items-center gap-y-12 py-8">
            <div class="flex flex-col gap-2 text-center md:text-left">
                <p class="text-sm">
                    {{ date('Y') }} &copy; {{ __('footer.copyright') }}<br />
                </p>
                <p class="text-xs text-pearl-400">
                    {{ __('footer.opensource') }}<br />
                    {{ __('footer.opensource_detail') }}<a href="{{ url('license') }}" class="px-0.5 underline hover:no-underline">{{ __('footer.opensource_license') }}</a>{{ __('footer.opensource_and') }}<x-external-link href="https://github.com/binotaliu/goodmoments.tw" class="px-0.5 underline hover:no-underline">{{ __('footer.opensource_github') }}</x-external-link>{{ __('footer.opensource_end') }}
                </p>
            </div>

            <div class="flex">
                <ul class="flex gap-6 md:gap-2 -my-4">
                    <li>
                        <x-external-link
                            href="https://www.instagram.com/gongguan5730/"
                            class="-mx-4 px-4 hover:text-sun-300 transition-colors"
                        >
                            <x-bxl-instagram class="w-8 h-8" aria-hidden="true" />
                            <span class="sr-only">Instagram</span>
                        </x-external-link>
                    </li>
                    <li>
                        <x-external-link
                            href="https://www.facebook.com/%E5%8F%B0%E5%8D%97%E5%B8%82%E5%B7%A6%E9%8E%AE%E5%8D%80%E5%85%AC%E8%88%98%E7%A4%BE%E5%8D%80-199524760230777/"
                            class="-mx-4 px-4 hover:text-sun-300 transition-colors"
                        >
                            <x-bxl-facebook-square class="w-8 h-8" aria-hidden="true" />
                            <span class="sr-only">Facebook</span>
                        </x-external-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

@stack('footer-extensions')

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "左鎮公舘社區發展協會",
  "url": "https://goodmoments.tw/",
  "description": "左鎮公舘社區由岡林、二寮與草山三個里所組成。社區內蘊含知名的草山月世界、二寮日出、西拉雅文化及豐富自然生態景觀。",
  "email": "contact@goodmoments.tw",
  "sameAs": [
    "https://www.facebook.com/%E5%8F%B0%E5%8D%97%E5%B8%82%E5%B7%A6%E9%8E%AE%E5%8D%80%E5%85%AC%E8%88%98%E7%A4%BE%E5%8D%80-199524760230777/",
    "https://www.instagram.com/gongguan5730/",
  ],
  "address": {
    "@type": "PostalAddress",
    "addressCountry": "TW",
    "postalCode": 713002",
    "addressRegion": "台南市",
    "addressLocality": "左鎮區",
    "streetAddress": "崗林31號"
  },
   "logo": "https://goodmoments.tw/images/logo.png",
   "telephone": "+886-6-573-0107"
}
</script>
</body>
</html>
