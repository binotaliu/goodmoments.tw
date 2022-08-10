<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AttachmentUploadRequest;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

/**
 * @see docs/attachments.md
 */
final class AttachmentController
{
    /**
     * @throws \Throwable
     */
    public function store(AttachmentUploadRequest $request): Attachment
    {
        $uuid = Uuid::uuid4();

        $file = $request->file('file');
        throw_if(empty($file), ValidationException::withMessages(['file' => __('validation.file', ['attribute' => 'file'])]));

        $meta = $request->input('meta', []);
        ray($meta);

        if ($existing = Attachment::withFile($file)->withMeta($meta)->first()) {
            return tap($existing)->touch();
        }

        $uuidHex = $uuid->getHex()->toString();
        $path = '/' . substr($uuidHex, 0, 2) . '/';
        $filename = base64_url_encode($uuid->getBytes()) . '.' . $file->guessExtension();
        $disk = $request->input('disk', 'public');

        Storage
            ::disk($disk)
            ->putFileAs(
                $path,
                $file,
                $filename,
            );

        $attachment = Attachment::fromFile($file);

        $attachment->uuid = $uuidHex;
        $attachment->disk = $disk;
        $attachment->path = $path . $filename;
        $attachment->meta = $meta;

        return tap($attachment)->save();
    }
}
