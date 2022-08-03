<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UserCreationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // @TODO:
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:32'],
            'username' => ['required', 'min:3', 'max:16', Rule::unique('user', 'username')],
            'email' => ['required', 'email:strict', Rule::unique('user', 'email')],
        ];
    }
}
