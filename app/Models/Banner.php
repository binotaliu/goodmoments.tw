<?php

namespace App\Models;

use App\Enums\BannerLocation;
use App\Models\Concerns\HasAttachments;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
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

    protected $dates = [
        'started_at',
        'ended_at',
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

    public function scopeWhereActive(Builder $query): Builder
    {
        return $query
            ->where('started_at', '>=', DB::raw('NOW()'))
            ->orWhere(
                fn (Builder $q) => $q
                    ->whereNull('ended_at')
                    ->orWhere('ended_at', '<', DB::raw('NOW()')),
            );
    }
}
