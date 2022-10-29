<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class ContactCommentCreateRequest extends FormRequest
{
    public function authorize(): ?bool
    {
        return $this->user()?->is_active;
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'max:4096'],
            'resolved' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'content' => '留言內文',
            'resolved' => '完成',
        ];
    }
}
