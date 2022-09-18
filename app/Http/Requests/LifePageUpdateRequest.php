<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class LifePageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'blocks' => ['array'],
            'blocks.*' => ['array'],
            'blocks.*.image' => ['required', 'string', 'url'],
            'blocks.*.image_description.zh_Hant_TW' => ['required', 'string', 'max:255'],
            'blocks.*.title.zh_Hant_TW' => ['required', 'string', 'max:255'],
            'blocks.*.text.zh_Hant_TW' => ['required', 'string', 'max:10240'],
            'blocks.*.text_position' => ['required', Rule::in(['left', 'right'])],
        ];
    }
}
