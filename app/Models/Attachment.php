<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @see docs/attachments.md
 * @mixin IdeHelperAttachment
 */
final class Attachment extends Model
{
    use HasFactory;

    protected $casts = [
        'meta' => 'array',
    ];

    protected $appends = [
        'url',
    ];

    public function url(): Attribute
    {
        return Attribute::get(static function ($_, $attributes): ?string {
            if (empty($attributes['disk']) || empty($attributes['path'])) {
                return null;
            }

            return Storage::disk($attributes['disk'])->url($attributes['path']);
        });
    }

    public function attachmentables(): HasMany
    {
        return $this->hasMany(Attachmentable::class);
    }
}
