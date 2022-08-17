<?php

namespace App\Models;

use App\Enums\BannerLocation;
use App\Models\Concerns\HasAttachments;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperBanner
 */
final class Banner extends Model
{
    use HasAttachments;
    use HasFactory;
    use HasTranslations;

    use SoftDeletes;

    protected $with = ['attachments'];

    public array $translatable = ['title', 'description', 'image_description'];

    protected $casts = [
        'location' => BannerLocation::class,
    ];

    protected $appends = [
        'image',
        'image_uuid',
    ];

    public function image(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->sole(),
        );
    }

    public function imageUuid(): Attribute
    {
        return Attribute::get(
            fn () => $this->image?->uuid,
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
