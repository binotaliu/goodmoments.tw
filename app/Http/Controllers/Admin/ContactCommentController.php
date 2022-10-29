<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\ContactStatus;
use App\Http\Requests\ContactCommentCreateRequest;
use App\Models\Contact;
use App\Models\ContactComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

final class ContactCommentController
{
    public function store(ContactCommentCreateRequest $request, Contact $contact): RedirectResponse
    {
        DB::beginTransaction();
        $comment = new ContactComment();
        $comment->contact_id = $contact->id;
        $comment->user_id = $request->user()->id;
        $comment->content = $request->input('content');
        $comment->save();

        $contact->status = $request->boolean('resolved') ? ContactStatus::resolved : ContactStatus::processing;
        $contact->save();
        DB::commit();

        return Redirect
            ::route('admin.contacts.show', $contact)
            ->with('message', '已新增留言');
    }
}
