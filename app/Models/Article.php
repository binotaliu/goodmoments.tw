<?php

namespace App\Models;

use App\Models\Concerns\HasAttachments;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

final class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    use HasTranslations;
    use HasAttachments;

    public array $translatable = ['title', 'description', 'content', 'content_src'];

    protected $with = ['attachments'];
    protected $appends = [
        'cover_image',
        'cover_image_uuid',
        'social_image',
        'social_image_uuid',
    ];

    public function coverImage(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->where('meta.type', 'articleCoverImage')->sole(),
        );
    }

    public function coverImageUuid(): Attribute
    {
        return Attribute::get(
            fn () => $this->cover_image->uuid,
        );
    }

    public function socialImage(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->where('meta.type', 'articleSocialImage')->sole(),
        );
    }

    public function socialImageUuid(): Attribute
    {
        return Attribute::get(
            fn () => $this->social_image->uuid,
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
