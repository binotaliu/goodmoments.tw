<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\Requests\ArticleCreationRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use Stevebauman\Purify\Facades\Purify;

final class FillArticleInputsFromRequest
{
    public function __invoke(ArticleCreationRequest|ArticleUpdateRequest $request, ?Article $article = null): Article
    {
        if ($article === null) {
            $article = new Article();
        }

        $article->creator_id = $request->user()->id;
        $article->slug = $request->input('slug');
        $article->title = [
            'en' => $request->input('title.en'),
            'zh_Hant_TW' => $request->input('title.zh_Hant_TW'),
            'zh_Oan' => $request->input('title.zh_Oan'),
        ];
        $article->description = [
            'en' => $request->input('description.en'),
            'zh_Hant_TW' => $request->input('description.zh_Hant_TW'),
            'zh_Oan' => $request->input('description.zh_Oan'),
        ];
        $article->content = [
            'en' => $this->purifyContent($request->input('content.en')),
            'zh_Hant_TW' => $this->purifyContent($request->input('content.zh_Hant_TW')),
            'zh_Oan' => $this->purifyContent($request->input('content.zh_Oan')),
        ];

        return $article;
    }

    private function purifyContent(?string $content): ?string
    {
        if ($content === null) {
            return null;
        }

        return Purify::clean($content);
    }
}
