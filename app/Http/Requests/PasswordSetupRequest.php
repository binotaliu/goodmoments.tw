<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class PasswordSetupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email:strict', Rule::exists('users', 'email')],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }
}
