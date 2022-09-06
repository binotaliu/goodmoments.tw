<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class CategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('categories', 'slug')->ignore($this->route('category')),
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
