<?php

namespace App\Http\Controllers;

use App\Enums\SysvalKey;
use App\Models\Member;
use App\Models\Sysval;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class AboutController extends Controller
{
    public function __invoke(Request $request): View
    {
        $description = Sysval::get(SysvalKey::about__description);
        $members = Member
            ::all()
            ->groupBy('row')
            ->map->sortBy('priority');

        return view('about', [
            'description' => $description,
            'members' => $members,
        ]);
    }
}
