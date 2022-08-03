<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:32'],
            'username' => ['required', 'min:3', 'max:16', Rule::unique('users', 'username')->ignore($this->route()?->parameter('user'))],
            'email' => ['required', 'email:strict', Rule::unique('users', 'email')->ignore($this->route()?->parameter('user'))],
        ];
    }
}
