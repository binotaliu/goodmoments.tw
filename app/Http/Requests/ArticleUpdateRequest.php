<?php

namespace App\Http\Requests;

use App\Rules\Attachment;
use App\Rules\Attachments;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ArticleUpdateRequest extends FormRequest
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
                Rule::unique('articles', 'slug')->ignoreModel($this->route('article')),
                'alpha_dash',
            ],
            'title' => ['required', 'array'],
            'title.*' => ['nullable', 'string', 'max:255'],
            'title.zh_Hant_TW' => ['required', 'string', 'max:255'],
            'description' => ['required', 'array'],
            'description.*' => ['nullable', 'string', 'max:255'],
            'description.zh_Hant_TW' => ['required', 'string', 'max:255'],
            'published_at' => ['required', 'date'],
            'cover_image' => [
                'required',
                Attachment
                    ::make()
                    ->whereMeta('type', 'articleCoverImage'),
            ],
            'social_image' => [
                'nullable',
                Attachment
                    ::make()
                    ->whereMeta('type', 'articleSocialImage'),
            ],
            'content' => ['required', 'array'],
            'content.*' => ['nullable', 'string'],
            'content.zh_Hant_TW' => ['required', 'string'],
            'content_attachments' => ['present', 'array', Attachments::make()->whereMeta('type', 'articleContentImage')],
        ];
    }
}
