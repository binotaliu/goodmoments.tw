<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateContactFromRequest;
use App\Http\Requests\ContactRequest;
use Illuminate\Contracts\View\View;

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

    public function store(ContactRequest $request): View
    {
        ($this->createContactFromRequest)($request);

        return view('contact', [
            'success' => true,
        ]);
    }
}
