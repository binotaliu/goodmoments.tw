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
        $attachmentUuids = [$request->input('cover_image_uuid'), ...$request->input('image_uuids')];

        $attachments = Attachment::whereIn('uuid', $attachmentUuids)->get();

        // check images validity
        $images = $attachments->whereIn('uuid', $request->input('image_uuids'));
        throw_if($images->count() !== count($request->input('image_uuids')), ValidationException::withMessages(['image_uuids' => '圖片中含有不存在的圖片']));

        return $attachments;
    }
}
