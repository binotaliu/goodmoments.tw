<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\SystemPage;

use App\Enums\SysvalKey;
use App\Http\Requests\MapsPageUpdateRequest;
use App\Models\Sysval;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Stevebauman\Purify\Facades\Purify;

final class MapsController
{
    public function edit(): InertiaResponse
    {
        return Inertia::render('SystemPages/Maps', [
            'description' => Sysval::get(SysvalKey::map_description),
        ]);
    }

    public function update(MapsPageUpdateRequest $request)
    {
        $description = [
            'en' => Purify::clean($request->input('description.en'), ''),
            'zh_Hant_TW' => Purify::clean($request->input('description.zh_Hant_TW'), ''),
            'zh_Oan' => Purify::clean($request->input('description.zh_Oan'), ''),
        ];

        Sysval::set(SysvalKey::map_description, $description);

        return Redirect::route('pages.maps.edit');
    }
}
