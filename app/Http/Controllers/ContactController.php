<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateContactFromRequest;
use App\Http\Requests\ContactRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

final class ContactController
{
    public function __construct(
        private readonly CreateContactFromRequest $createContactFromRequest,
    ) {
    }

    public function form(): View
    {
        return view('contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        ($this->createContactFromRequest)($request);

        return Redirect
            ::route('contact.form')
            ->with('status', 'success');
    }
}
