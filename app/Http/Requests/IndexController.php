<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Banner;
use Illuminate\Contracts\View\View;

final class IndexController
{
    public function __invoke(): View
    {
        return view('index', [
            'banners' => Banner::whereActive()->orderBy('started_at', 'desc')->get(),
        ]);
    }
}
