<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;

final class CreateContactFromRequest
{
    public function __invoke(ContactRequest $request): Contact
    {
        $contact = new Contact();

        $contact->name = $request->input('name');
        $contact->contact_method = $request->input('contact_method');
        $contact->email = $request->input('email');
        $contact->subject = $request->input('subject');
        $contact->content = $request->input('content');
        $contact->save();

        return $contact;
    }
}
