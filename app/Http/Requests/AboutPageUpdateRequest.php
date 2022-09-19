<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AboutPageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description.*' => ['nullable', 'string'],
            'description.zh_Hant_TW' => ['string'],
            'members' => ['array'],
            'members.*' => ['array'],
            'members.*.*' => ['array'],
            'members.*.*.name' => ['required', 'string'],
            'members.*.*.title' => ['required', 'string'],
        ];
    }
}
