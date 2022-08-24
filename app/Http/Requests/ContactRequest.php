<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:128'],
            'contact_method' => ['required', 'string', 'max:128'],
            'email' => ['required', 'email:strict', 'string', 'max:128'],
            'subject' => ['required', 'string', 'max:64'],
            'content' => ['required', 'string', 'max:4096'],
        ];
    }
}
