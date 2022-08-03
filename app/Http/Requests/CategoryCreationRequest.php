<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CategoryCreationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // @TODO:
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('categories', 'slug'),
            ],
            'name' => [
                'required',
                'array',
            ],
            'name.zh_Hant_TW' => [
                'required',
                'string',
                'max:255',
            ],
            'name.en' => [
                'nullable',
                'string',
                'max:255',
            ],
            'name.zh_Oan' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
