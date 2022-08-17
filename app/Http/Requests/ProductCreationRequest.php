<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\AllExists;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ProductCreationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // @TODO:
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id ?? throw new NotFoundHttpException();

        return [
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('products', 'slug')->where('category_id', $categoryId),
            ],
            'name' => [
                'required',
                'array',
            ],
            'cover_image_uuid' => [
                'required',
                'string',
                Rule
                    ::exists('attachments', 'uuid')
                    ->where('meta->type', Product::ATTACHMENT_TYPE_COVER),
            ],
            'image_uuids' => [
                'required',
                'array',
                AllExists
                    ::make('attachments', 'uuid')
                    ->where('meta->type', Product::ATTACHMENT_TYPE_IMAGE),
            ],
            'name.zh_Hant_TW' => [
                'required',
                'max:255',
                'string',
            ],
            'name.en' => [
                'nullable',
                'max:255',
                'string',
            ],
            'name.zh_Oan' => [
                'nullable',
                'max:255',
                'string',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'unit' => [
                'required',
                'array',
            ],
            'unit.zh_Hant_TW' => [
                'required',
                'max:255',
                'string',
            ],
            'unit.en' => [
                'nullable',
                'max:255',
                'string',
            ],
            'unit.zh_Oan' => [
                'nullable',
                'max:255',
                'string',
            ],
            'store_url' => ['nullable', 'url'],
            'store_url_text.zh_Hant_TW' => [
                'required',
                'max:255',
                'string',
            ],
            'store_url_text.en' => [
                'nullable',
                'max:255',
                'string',
            ],
            'store_url_text.zh_Oan' => [
                'nullable',
                'max:255',
                'string',
            ],
            'description' => [
                'required',
                'array',
            ],
            'description.zh_Hant_TW' => [
                'required',
                'string',
            ],
            'description.en' => [
                'nullable',
                'string',
            ],
            'description.zh_Oan' => [
                'nullable',
                'string',
            ],
        ];
    }
}
