<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Models\User;
use App\Utils\Makeable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class AuthenticateUser
{
    use Makeable;

    /**
     * @param  Request  $request
     * @return User
     *
     * @throws ValidationException
     */
    public function __invoke(Request $request): User
    {
        $user = User::whereUsername($request->input('username'))->first();

        if ($user === null) {
            throw ValidationException::withMessages([
                'username' => '找不到該使用者',
            ]);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => '密碼錯誤',
            ]);
        }

        if ($user->is_active !== true) {
            throw ValidationException::withMessages([
                'username' => '該使用者已被停用',
            ]);
        }

        return $user;
    }
}
