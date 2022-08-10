<?php

use App\Models\User;
use App\Notifications\PasswordSetupNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

it('can log in', function (): void {
    $user = User::factory()
        ->state([
            'username' => $username = Str::random(),
            'is_active' => true,
        ])
        ->password($password = Str::random())
        ->create();

    post(route('login'), [
        'username' => $username,
        'password' => $password,
    ]);

    assertAuthenticatedAs($user);
});

it('lists users', function (): void {
    $user = User::factory()->create();
    actingAs($user);

    User::factory()->count(random_int(5, 25))->create();
    $totalUsersCount = User::count();

    get(route('admin.users.index'))
        ->assertInertia(
            fn (AssertableInertia $assert) => $assert
                ->component('Users/Index')
                ->where('users.total', $totalUsersCount)
        );
});

it('can create a new user', function (): void {
    $user = User::factory()->state(['is_active' => true])->create();
    actingAs($user);

    Notification::fake();

    post(route('admin.users.store'), [
        'name' => $name = Str::random(8),
        'username' => $username = Str::random(8),
        'email' => $email = Str::random() . '@example.com',
        'is_active' => true,
    ])->assertRedirect();

    assertDatabaseHas('users', [
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'is_active' => true,
        'password' => null,
    ]);

    $newlyCreatedUser = User::whereEmail($email)->firstOrFail();

    Notification::assertSentTo($newlyCreatedUser, PasswordSetupNotification::class);

});

it('able to set up password after been created', function (): void {
    $user = User::factory()->state(['is_active' => true, 'password' => null])->create();

    post(URL::temporarySignedRoute(
        'admin.password-setup.index',
        now()->addHours(12),
        ['email' => $user->email]
    ), [
        'password' => $password = Str::random(32),
        'password_confirmation' => $password,
    ])->assertRedirect()->assertSessionHas('flash.message');

    $user->refresh();

    expect(Hash::check($password, $user->password))->toBeTrue();
});

it('can update a user', function (): void {
    $admin = User::factory()->create();
    actingAs($admin);

    $user = User::factory()->create();

    put(route('admin.users.update', ['user' => $user]), [
        'name' => $name = Str::random(8),
        'username' => $username = Str::random(8),
        'email' => $email = Str::random() . '@example.com',
        'is_active' => true,
    ])->assertValid()->assertRedirect();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $name,
        'username' => $username,
        'email' => $email,
        'is_active' => true,
    ]);
});
