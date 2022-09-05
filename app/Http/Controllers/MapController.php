<?php

namespace App\Http\Controllers;

use App\Enums\SysvalKey;
use App\Models\Sysval;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class MapController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('maps', [
            'travelDescription' => Sysval::get(SysvalKey::map_description),
        ]);
    }
}
