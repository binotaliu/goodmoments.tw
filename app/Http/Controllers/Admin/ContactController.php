<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class ContactController
{
    public function index(): InertiaResponse
    {
        return Inertia::render('Contacts/Index', [
            'contacts' => Contact::selectForIndex()->latest()->paginate(),
        ]);
    }

    public function show(Contact $contact): InertiaResponse
    {
        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }
}
