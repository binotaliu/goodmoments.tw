<x-layout title="關於我們">
    <div class="w-screen">
        <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
            <h2 class="text-3xl">關於我們</h2>
        </div>
    </div>
    <main class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
        <article class="flex items-center mb-16">
            <div class="w-full md:w-2/3">
                {!! $description['zh_Hant_TW'] !!}
            </div>
            <div class="w-1/3 hidden md:block" aria-hidden="true">
                <div class="flex flex-col justify-center items-center gap-2 py-6">
                    <img class="w-14 sm:w-16 md:w-24" src="{{ asset('images/logo.svg') }}" alt="好時・左鎮公舘 LOGO" />
                    <img class="h-10 sm:h-14 md:w-36" src="{{ asset('images/text-logo.svg') }}" alt="好時・左鎮公舘" />
                </div>
            </div>
        </article>

        <div>
            <h3 class="text-center text-2xl mb-6">社區成員</h3>

            <div class="flex flex-col gap-6">
                @foreach ($members as $row)
                    <div class="flex flex-wrap justify-center gap-6">
                        @foreach ($row as $member)
                            <dl class="w-1/2 md:w-auto px-6 py-4 border border-pearl-300 text-center bg-white rounded shadow-sm">
                                <div class="mb-4" aria-hidden="true">
                                    <dt class="sr-only">圖片</dt>

                                    <dd>
                                        <img class="w-24 h-24 rounded-full" src="{{ $member->image_url }}" alt="{{ $member->name }} 的顯示圖片" />
                                    </dd>
                                </div>
                                <div>
                                    <dt class="sr-only">名字</dt>
                                    <dd class="text-lg font-medium">{{ $member->name }}</dd>
                                </div>
                                <div>
                                    <dt class="sr-only">職位</dt>
                                    <dd class="text-sun-500">{{ $member->title }}</dd>
                                </div>
                            </dl>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-layout>
