<?php

use App\Models\User;
use Illuminate\Support\Str;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\post;

it('can log in', function () {
    $user = User::factory()
        ->state([
            'username' => $username = Str::random(),
        ])
        ->password($password = Str::random())
        ->create();

    post(route('login'), [
        'username' => $username,
        'password' => $password,
    ]);

    assertAuthenticatedAs($user);
});
