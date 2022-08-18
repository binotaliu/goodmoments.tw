<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ArticleCreationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // @TODO
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => ['required', Rule::unique('articles', 'slug'), 'alpha_dash'],
            'title' => ['required', 'array'],
            'title.*' => ['nullable', 'string', 'max:255'],
            'title.zh_Hant_TW' => ['required', 'string', 'max:255'],
            'description' => ['required', 'array'],
            'description.*' => ['nullable', 'string', 'max:255'],
            'description.zh_Hant_TW' => ['required', 'string', 'max:255'],
            'cover_image_uuid' => ['required', 'string', Rule::exists('attachments', 'uuid')->where('meta->type', 'articleCoverImage')],
            'social_image_uuid' => ['nullable', 'string', Rule::exists('attachments', 'uuid')->where('meta->type', 'articleSocialImage')],
            'content' => ['required', 'array'],
            'content.*' => ['nullable', 'string'],
            'content.zh_Hant_TW' => ['required', 'string'],
        ];
    }
}
