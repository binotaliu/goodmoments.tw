<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasAttachments;
use App\Models\Concerns\HasXid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperProduct
 */
final class Product extends Model implements Feedable
{
    use HasAttachments;
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use HasXid;

    public const COVER_STORAGE = 'cover';
    public const IMAGE_STORAGE = 'image';

    public const ATTACHMENT_TYPE_COVER = 'productCoverImage';
    public const ATTACHMENT_TYPE_IMAGE = 'productImages';

    public array $translatable = ['name', 'unit', 'store_url_text', 'description'];

    public string $xidPrefix = 'P';

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

    public function url(): Attribute
    {
        return Attribute::get(
            fn () => route('categories.products.show', [$this->category, $this]),
        );
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->xid)
            ->title($this->getTranslation('name', app()->getLocale()))
            ->summary($this->getTranslation('description', app()->getLocale()))
            ->authorName('台南左鎮公舘社區發展協會')
            ->updated($this->updated_at)
            ->link($this->url);
    }

    public static function getAllFeedItems(): Collection
    {
        return static::with('category')->get();
    }
}
