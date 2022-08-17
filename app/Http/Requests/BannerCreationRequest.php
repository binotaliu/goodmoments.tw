<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class BannerCreationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // @TODO
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'array'],
            'title.*' => ['nullable', 'string', 'max:255'],
            'title.zh_Hant_TW' => ['required'],
            'description' => ['required', 'array'],
            'description.*' => ['nullable', 'string', 'max:255'],
            'image_uuid' => ['required', Rule::exists('attachments', 'uuid')],
            'image_description' => ['required', 'array'],
            'image_description.*' => ['nullable', 'string', 'max:255'],
            'image_description.zh_Hant_TW' => ['required'],
            'url' => ['required', 'string', 'max:4000', 'url'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date'],
        ];
    }
}
