<?php

use App\Models\Contact;

use App\Models\User;

use Inertia\Testing\AssertableInertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('stores contact form to database', function () {
    post(route('contact.store'), [
        'name' => $name = 'John Doe' . random_int(0, 100000),
        'contact_method' => 'email',
        'email' => $email = 'john.doe' . random_int(0, 100000) . '@example.com',
        'subject' => $subject = 'Test subject' . random_int(0, 100000),
        'content' => $content = 'Test content' . random_int(0, 100000),
    ])
        ->assertValid()
        ->assertRedirect()
        ->assertSessionHas('status', 'success');

    assertDatabaseHas('contacts', [
        'name' => $name,
        'contact_method' => 'email',
        'email' => $email,
        'subject' => $subject,
        'content' => $content,
    ]);
});

it('displays received contact forms', function () {
    $user = User::factory()->active()->create();

    Contact
        ::factory()
        ->count(random_int(6, 24))
        ->create();

    $count = Contact::count();

    actingAs($user);
    get(route('admin.contacts.index'))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Contacts/Index')
            ->where('contacts.total', $count)
        );
});

it('displays a contact', function () {
    $user = User::factory()->active()->create();

    $contact = Contact::factory()->create();

    actingAs($user);
    get(route('admin.contacts.show', $contact))
        ->assertInertia(fn (AssertableInertia $page) => $page
            ->component('Contacts/Show')
            ->where('contact.id', $contact->id)
        );
});
