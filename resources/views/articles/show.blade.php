<x-layout :title="$article->title">
    <div class="relative mb-16 bg-pearl-200">
        <img
            class="-mt-8 w-full"
            src="{{ $article->cover_image->url }}"
            alt="文章封面圖片"
            width="960"
            height="256"
            aria-hidden="true"
        >

        <div class="static sm:absolute left-0 bottom-0 w-full">
            <div class="max-w-4xl mx-auto pb-2 md:pb-4 lg:pb-12">
                <div class="mb-2">
                    <h1 class="inline-block px-4 py-2 text-3xl md:text-4xl backdrop-blur-sm bg-wood-500/95 text-white shadow">
                        {{ $article->title }}
                    </h1>
                </div>
                <div>
                    <span class="inline-block ml-2 px-2 py-1 text-sm backdrop-blur-sm bg-wood-600/95 text-white shadow">{{ $article->published_at->format('Y-m-d') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
        <article class="prose lg:prose-xl prose-neutral">
            {!! $article->content !!}
        </article>
    </div>

    <x-slot:footerScripts>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "BlogPosting",
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "{{ route('articles.show', $article) }}"
                },
                "headline": "{{ $article->title }}",
                "image": {
                    "@type": "ImageObject",
                    "url": "{{ $article->cover_image->url }}",
                    "width": 960,
                    "height": 256
                },
                "datePublished": "{{ $article->published_at->format('Y-m-d') }}",
                "dateModified": "{{ $article->updated_at->format('Y-m-d') }}",
                "author": {
                    "@type": "Organization",
                    "name": "左鎮公舘社區發展協會",
                    "url": "{{ route('articles.index') }}",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "{{ asset('images/logo.png') }}",
                        "width": 600,
                        "height": 600
                    }
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "左鎮公舘社區發展協會",
                    "url": "{{ route('articles.index') }}",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "{{ asset('images/logo.png') }}",
                        "width": 600,
                        "height": 600
                    }
                }
            }
        </script>
    </x-slot:footerScripts>
</x-layout>
