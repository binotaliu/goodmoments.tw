<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Article;
use App\Models\Banner;
use Illuminate\Contracts\View\View;

final class IndexController
{
    public const MAX_ARTICLES_COUNT = 4;
    public function __invoke(): View
    {
        return view('index', [
            'banners' => Banner::whereActive()->orderBy('started_at', 'desc')->get(),
            'articles' => Article
                ::wherePublished()
                ->orderBy('published_at', 'desc')
                ->limit(self::MAX_ARTICLES_COUNT)
                ->get(),
        ]);
    }
}
