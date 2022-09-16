<?php

declare(strict_types=1);

namespace App\Actions;

use App\Http\Requests\ProductCreationRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Attachment;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

final class FetchAttachmentsFromProductRequest
{
    /**
     * @param  ProductCreationRequest  $request
     * @return Collection<Attachment>|Attachment[]
     *
     * @throws ValidationException
     */
    public function __invoke(ProductCreationRequest|ProductUpdateRequest $request): Collection
    {
        $attachmentUuids = [$request->input('cover_image.uuid'), ...$request->input('images.*.uuid')];

        $attachments = Attachment::whereIn('uuid', $attachmentUuids)->get();

        // check images validity
        $images = $attachments->whereIn('uuid', $request->input('images.*.uuid'));
        if ($images->count() !== count($request->input('images.*.uuid'))) {
            throw ValidationException::withMessages(['images' => '選擇的圖片中含有未上傳的圖片']);
        }

        return $attachments;
    }
}
