<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\SystemPage;

use App\Enums\SysvalKey;
use App\Http\Requests\AboutPageUpdateRequest;
use App\Models\Attachment;
use App\Models\Member;
use App\Models\Sysval;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;
use Stevebauman\Purify\Facades\Purify;

final class AboutController
{
    public function edit(): InertiaResponse
    {
        $description = Sysval::get(SysvalKey::about__description);
        $members = Member
            ::all()
            ->groupBy('row')
            ->map->sortBy('priority')
            ->map->values();

        return Inertia::render('SystemPages/About', [
            'description' => $description,
            'members' => $members,
        ]);
    }

    public function update(AboutPageUpdateRequest $request): RedirectResponse
    {
        $description = [
            'en' => Purify::clean($request->input('description.en', '')),
            'zh_Hant_TW' => Purify::clean($request->input('description.zh_Hant_TW', '')),
            'zh_Oan' => Purify::clean($request->input('description.zh_Oan', '')),
        ];

        Sysval::set(SysvalKey::about__description, $description);

        $members = $request->input('members', []);
        $this->syncMembers(collect($members));

        return Redirect::route('admin.pages.about.edit');
    }

    public function syncMembers(Collection $input): Collection
    {
        $flattenedInput = $input->flatten(1);
        $ids = $flattenedInput->pluck('id')->filter();
        Member::whereNotIn('id', $ids)->delete();

        $attachments = Attachment::whereIn('uuid', $flattenedInput->pluck('image.uuid'))->get()->keyBy('uuid');

        [$newMembers, $oldMembers] = $flattenedInput->partition(fn ($i) => $i['id'] === null);
        $newMembers
            ->each(function ($data) use ($attachments): void {
                $member = new Member();
                $member->description = '';
                $member->fill($data);
                $member->save();

                $member
                    ->attachments()
                    ->sync(array_filter([
                        optional(optional($attachments)[optional($data['image'])['uuid']])->id,
                    ]));
            });

        $currentMembers = Member::whereIn('id', $oldMembers->pluck('id'))->get()->keyBy('id');
        $oldMembers
            ->each(function ($data) use ($attachments, $currentMembers): void {
                $member = $currentMembers[$data['id']];
                $member->description = $member->description ?? '';
                $member->fill($data);
                $member->save();

                $member
                    ->attachments()
                    ->sync(array_filter([
                        optional($attachments)[optional($data['image'])['uuid']]?->id,
                    ]));
            });

        return Member
            ::all()
            ->groupBy('row')
            ->map->sortBy('priority')
            ->map->values();
    }
}
