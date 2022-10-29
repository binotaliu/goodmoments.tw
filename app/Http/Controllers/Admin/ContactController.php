<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\ContactStatus;
use App\Models\Contact;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use function Pest\Laravel\wasDispatched;

final class ContactController
{
    public function index(Request $request): InertiaResponse
    {
        $status = $request->input('status');
        $status = $status ? ContactStatus::tryFrom($status) : null;

        return Inertia::render('Contacts/Index', [
            'status' => $status,
            'contacts' => Contact
                ::selectForIndex()
                ->when($status !== null, fn (Builder $q) => $q->where('status', $status->value))
                ->orderBy('status')
                ->latest()
                ->paginate(),
        ]);
    }

    public function show(Contact $contact): InertiaResponse
    {
        $contact->load([
            'comments',
            'comments.user' => fn (Builder $q) => $q->select('id', 'name', 'email')->oldest(),
        ]);

        return Inertia::render('Contacts/Show', [
            'contact' => $contact,
        ]);
    }
}
