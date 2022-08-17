<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\Requests\BannerCreationRequest;
use App\Http\Requests\BannerUpdateRequest;
use App\Models\Banner;

final class FillBannerInputFromRequest
{
    public function __invoke(BannerCreationRequest|BannerUpdateRequest $request, ?Banner $banner = null): Banner
    {
        if ($banner === null) {
            $banner = new Banner();
        }

        $banner->title = [
            'en' => $request->input('title.en'),
            'zh_Hant_TW' => $request->input('title.zh_Hant_TW'),
            'zh_Oan' => $request->input('title.zh_Oan'),
        ];
        $banner->description = [
            'en' => $request->input('description.en'),
            'zh_Hant_TW' => $request->input('description.zh_Hant_TW'),
            'zh_Oan' => $request->input('description.zh_Oan'),
        ];

        $banner->image_description = [
            'en' => $request->input('image_description.en'),
            'zh_Hant_TW' => $request->input('image_description.zh_Hant_TW'),
            'zh_Oan' => $request->input('image_description.zh_Oan'),
        ];

        $banner->url = $request->input('url');

        $banner->started_at = $request->input('started_at');
        $banner->ended_at = $request->input('ended_at');

        if ($request instanceof BannerCreationRequest) {
            $banner->creator_id = $request->user()->id;
        }

        return $banner;
    }
}
