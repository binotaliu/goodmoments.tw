<x-layout title="所有文章">
    <div class="max-w-4xl mx-auto px-4 mx:px-6 mb-16">
        <h2 class="text-2xl mb-16">所有文章</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8 mb-8">
            @foreach($articles as $article)
                <x-article-block :article="$article" />
            @endforeach
        </div>

        {{ $articles->links() }}
    </div>
</x-layout>
