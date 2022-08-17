<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\FillBannerInputFromRequest;
use App\Http\Requests\BannerCreationRequest;
use App\Http\Requests\BannerUpdateRequest;
use App\Models\Attachment;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class BannerController
{
    public function __construct(
        private readonly FillBannerInputFromRequest $fillBannerInputFromRequest
    ) {
    }

    public function index(): InertiaResponse
    {
        return Inertia::render('Banners/Index', [
            'banners' => Banner::paginate(),
        ]);
    }

    public function create(): InertiaResponse
    {
        return Inertia::render('Banners/Form');
    }

    public function store(BannerCreationRequest $request): RedirectResponse
    {
        $attachment = Attachment::whereUuid($request->input('image_uuid'))->sole();

        $banner = ($this->fillBannerInputFromRequest)($request);
        $banner->save();
        $banner->attachments()->sync([$attachment->id]);

        return Redirect::route('admin.banners.edit', [$banner]);
    }

    public function edit(Banner $banner): InertiaResponse
    {
        return Inertia::render('Banners/Form', [
            'banner' => $banner,
        ]);
    }

    public function update(BannerUpdateRequest $request, Banner $banner): RedirectResponse
    {
        $attachment = Attachment::whereUuid($request->input('image_uuid'))->sole();

        ($this->fillBannerInputFromRequest)($request, $banner);
        $banner->save();
        $banner->attachments()->sync([$attachment->id]);

        return Redirect::route('admin.banners.edit', [$banner]);
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $banner->deleteOrFail();

        return Redirect::route('admin.banners.index');
    }
}
