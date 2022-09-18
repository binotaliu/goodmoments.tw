<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\FillArticleInputsFromRequest;
use App\Http\Requests\ArticleCreationRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Attachment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class ArticleController
{
    public function __construct(
        private readonly FillArticleInputsFromRequest $fillArticleInputsFromRequest,
    ) {
    }

    public function index(): InertiaResponse
    {
        return Inertia::render('Articles/Index', [
            'articles' => Article::orderByDesc('published_at')->paginate(),
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Articles/Form');
    }

    public function store(ArticleCreationRequest $request): RedirectResponse
    {
        $coverImage = Attachment::where('uuid', $request->input('cover_image.uuid'))->sole();
        $socialImage = Attachment::where('uuid', $request->input('social_image.uuid'))->first();
        $contentImages = Attachment::where('uuid', $request->input('content_images.*.uuid'))->get();

        $article = ($this->fillArticleInputsFromRequest)($request);
        $article->save();
        $article->attachments()->sync(array_filter([
            $coverImage->id,
            $socialImage?->id,
            ...$contentImages->pluck('id')->toArray(),
        ]));

        return Redirect::route('admin.articles.edit', [$article]);
    }

    public function edit(Article $article): InertiaResponse
    {
        return Inertia::render('Articles/Form', [
            'article' => $article,
        ]);
    }

    public function update(ArticleUpdateRequest $request, Article $article): RedirectResponse
    {
        $coverImage = Attachment::where('uuid', $request->input('cover_image.uuid'))->sole();
        $socialImage = Attachment::where('uuid', $request->input('social_image.uuid'))->first();
        $contentImages = Attachment::where('uuid', $request->input('content_images.*.uuid'))->get();

        ($this->fillArticleInputsFromRequest)($request, $article);
        $article->save();
        $article->attachments()->sync(array_filter([
            $coverImage->id,
            $socialImage?->id,
            ...$contentImages->pluck('id')->toArray(),
        ]));

        return Redirect::route('admin.articles.edit', [$article]);
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->deleteOrFail();

        return Redirect::route('admin.articles.index');
    }
}
