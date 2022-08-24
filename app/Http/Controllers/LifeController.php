<?php

namespace App\Http\Controllers;

use App\Enums\SysvalKey;
use App\Models\Sysval;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class LifeController extends Controller
{
    public function __invoke(Request $request): View
    {
        return view('life', [
            'blocks' => Sysval::get(SysvalKey::life__blocks),
        ]);
    }
}
