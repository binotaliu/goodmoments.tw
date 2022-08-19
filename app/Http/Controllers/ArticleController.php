<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\View;

final class ArticleController
{
    public const PER_PAGE_ARTICLES = 16;

    public function index(): View
    {
        return view('articles.index', [
            'articles' => Article
                ::wherePublished()
                ->orderBy('published_at', 'desc')
                ->paginate(self::PER_PAGE_ARTICLES),
        ]);
    }

    public function show(Article $article): View
    {
        return view('articles.show', [
            'article' => $article,
        ]);
    }
}
