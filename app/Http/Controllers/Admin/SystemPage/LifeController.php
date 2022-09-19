<?php

namespace App\Http\Controllers\Admin\SystemPage;

use App\Enums\SysvalKey;
use App\Http\Requests\LifeImageStoreRequest;
use App\Http\Requests\LifePageUpdateRequest;
use App\Models\Sysval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Ramsey\Uuid\Uuid;

final class LifeController
{
    public function edit(): InertiaResponse
    {
        return Inertia::render('SystemPages/Life', [
            'blocks' => Sysval::get(SysvalKey::life__blocks, []),
        ]);
    }

    public function update(LifePageUpdateRequest $request): RedirectResponse
    {
        $blocks = $request->input('blocks', []);
        Sysval::set(SysvalKey::life__blocks, $blocks);

        return Redirect::route('admin.system-pages.life.edit');
    }

    public function images(LifeImageStoreRequest $request): array
    {
        $image = $request->file('image');
        $fileName = base64_url_encode(Uuid::uuid4()->getBytes()) . '.' . $image->guessExtension();
        Storage::disk('public')->putFileAs('life', $image, $fileName);

        return [
            'url' => Storage::disk('public')->url('life/' . $fileName),
        ];
    }
}
