@props(['article'])

<div class="flex flex-col rounded group motion-safe:hover:scale-[1.03] shadow-sm hover:shadow-lg transition-shadow transition-transform">
    <div class="rounded-t overflow-hidden">
        <a href="{{ route('articles.show', $article) }}">
            <img
                class="bg-center motion-safe:group-hover:scale-[1.03] transition-transform"
                src="{{ $article->cover_image->url }}"
                aria-hidden="true"
                width="960"
                height="256"
                alt="{{ $article->title }} 封面圖片"
            />
        </a>
    </div>
    <div class="flex-grow flex flex-col px-4 py-2 rounded-b bg-pearl-100 text-natural-900 group-hover:text-pearl-800 transition-colors">
        <a
            href="{{ route('articles.show', $article) }}"
            class="-m-4 p-4"
        >
            <strong class="font-medium text-lg">
                {{ $article->title }}
            </strong>
        </a>
        <dl class="-mt-1 mb-4">
            <dt class="sr-only">發佈日期</dt>
            <dd>
                <span class="text-xs">{{ $article->published_at->format('Y-m-d') }}</span>
            </dd>
        </dl>
        <p aria-hidden="true">
            <a
                href="{{ route('articles.show', $article) }}"
                class="-m-4 p-4"
            >
                {{ $article->description }}

            </a>
        </p>
    </div>
</div>
