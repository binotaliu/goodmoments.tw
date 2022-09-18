<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class LifeImageStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'image' => ['required', 'image'],
        ];
    }
}
