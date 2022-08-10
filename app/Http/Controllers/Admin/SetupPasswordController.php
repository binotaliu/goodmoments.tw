<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PasswordSetupRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class SetupPasswordController
{
    public function show(Request $request): InertiaResponse
    {
        $expires = $request->input('expires');

        return Inertia::render('Auth/SetupPassword', [
            'email' => $request->input('email'),
            'url' => URL::temporarySignedRoute(
                'admin.setup-password',
                $expires,
                [
                    'email' => $request->input('email'),
                ],
            ),
        ]);
    }

    public function store(PasswordSetupRequest $request): RedirectResponse
    {
        $user = User::whereEmail($request->input('email'))->firstOrFail();

        throw_if($user->password !== null, ValidationException::withMessages(['email' => ['密碼已設定，無法再次設定。若需要重設密碼，請至登入頁點選「忘記密碼」']]));

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return Redirect::route('login')->with('flash.message', '密碼設定成功，請使用所設定的密碼登入。');
    }
}
