<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Inertia\Inertia;
use Inertia\Response;

final class BannerController
{
    public function index(): Response
    {
        return Inertia::render('Banners/Index', [
            'banners' => Banner::paginate(),
        ]);
    }
}
