<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasAttachments;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperProduct
 */
final class Product extends Model
{
    use HasAttachments;
    use HasFactory;
    use HasTranslations;

    public const COVER_STORAGE = 'cover';
    public const IMAGE_STORAGE = 'image';

    public const ATTACHMENT_TYPE_COVER = 'productCoverImage';
    public const ATTACHMENT_TYPE_IMAGE = 'productImages';

    public array $translatable = ['name', 'unit', 'store_url_text', 'description'];

    protected $with = ['attachments'];

    protected $appends = [
        'cover_image',
        'cover_image_uuid',
        'images',
        'image_uuids',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function coverImage(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->firstWhere('meta.type', self::ATTACHMENT_TYPE_COVER),
        );
    }

    public function coverImageUuid(): Attribute
    {
        return Attribute::get(
            fn () => $this->cover_image?->uuid,
        );
    }

    public function images(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->where('meta.type', self::ATTACHMENT_TYPE_IMAGE)->values(),
        );
    }

    public function imageUuids(): Attribute
    {
        return Attribute::get(
            fn () => $this->images->pluck('uuid'),
        );
    }
}
