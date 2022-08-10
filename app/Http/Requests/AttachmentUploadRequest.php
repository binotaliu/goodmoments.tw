<?php

namespace App\Http\Requests;

use App\Rules\Depth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class AttachmentUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        // @TODO:
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimetypes:image/*,video/*,audio/*,application/pdf', 'max:20480'],
            'disk' => ['nullable', Rule::in('public')],
            'meta' => ['nullable', 'array', 'max:16', new Depth(2)],
        ];
    }
}
