<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperAttachmentable
 */
final class Attachmentable extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;

    public function attachment(): BelongsTo
    {
        return $this->belongsTo(Attachment::class);
    }
}
