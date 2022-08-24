<x-layout title="聯絡我們">
    <div class="w-screen">
        <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
            <h2 class="mb-6 text-3xl">聯絡我們</h2>

            <p class="text-lg">
                任何建議、問題？<br />
                歡迎您告訴我們，<br />
                我們期待您寶貴的建議！
            </p>
        </div>
    </div>

    <main class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
        <form class="flex flex-col items-stretch gap-y-4" action="{{ route('contact.form') }}" method="post">
            @csrf

            <div class="w-full flex flex-col gap-y-0.5">
                <label for="name" class="mb-2 text-pearl-900">大名</label>
                <input
                    id="name"
                    type="text"
                    placeholder="大名"
                    class="w-full border border-gray-400"
                />
            </div>

            <div class="w-full flex flex-col gap-y-0.5">
                <label for="contact-method" class="mb-2 text-pearl-900">聯絡方式</label>
                <input
                    id="contact-method"
                    type="text"
                    placeholder="請輸入您期望的聯絡方式"
                    class="w-full border border-gray-400"
                />
            </div>

            <div class="w-full flex flex-col gap-y-0.5">
                <label for="email" class="mb-2 text-pearl-900">電子信箱</label>
                <input
                    id="email"
                    type="email"
                    placeholder="請輸入您的電子信箱"
                    class="w-full border border-gray-400"
                />
            </div>

            <div class="w-full flex flex-col gap-y-0.5">
                <label for="subject" class="mb-2 text-pearl-900">主旨</label>
                <input
                    id="subject"
                    type="text"
                    placeholder="主旨"
                    class="w-full border border-gray-400"
                />
            </div>

            <div class="w-full flex flex-col gap-y-0.5">
                <label for="content" class="mb-2 text-pearl-900">內文</label>
                <textarea
                    id="content"
                    placeholder="內文"
                    class="w-full border border-gray-400"
                    rows="8"
                ></textarea>
            </div>

            <div class="text-right">
                <button
                    type="submit"
                    class="px-4 py-2 text-white bg-wood-500 hover:bg-wood-400 text-lg transition-colors"
                >送出</button>
            </div>
        </form>
    </main>
</x-layout>
