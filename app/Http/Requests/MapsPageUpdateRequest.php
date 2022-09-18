<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class MapsPageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => ['required', 'array'],
            'description.zh_Hant_TW' => ['required', 'string'],
        ];
    }
}
