<?php

namespace App\Models;

use App\Models\Concerns\HasAttachments;
use App\Models\Concerns\HasXid;
use Illuminate\Contracts\Database\Query\Builder;
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
 * @mixin IdeHelperArticle
 */
final class Article extends Model implements Feedable
{
    use HasFactory;
    use SoftDeletes;

    use HasTranslations;
    use HasAttachments;
    use HasXid;

    public array $translatable = ['title', 'description', 'content', 'content_src'];

    public string $xidPrefix = 'A';

    protected $dates = ['published_at'];

    protected $with = ['attachments'];
    protected $appends = [
        'cover_image',
        'social_image',
        'content_images',
    ];

    public function coverImage(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->where('meta.type', 'articleCoverImage')->sole(),
        );
    }

    public function socialImage(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->where('meta.type', 'articleSocialImage')->sole(),
        );
    }

    public function contentImages(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->where('meta.type', 'articleContentImage')->values(),
        );
    }

    public function url(): Attribute
    {
        return Attribute::get(
            fn () => route('articles.show', $this),
        );
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function scopeWherePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', now());
    }

    public function toFeedItem(): FeedItem
    {
        return FeedItem
            ::create()
            ->id($this->xid)
            ->title($this->getTranslation('title', app()->getLocale()))
            ->summary($this->getTranslation('content', app()->getLocale()))
            ->updated(
                $this->published_at->max($this->updated_at),
            )
            ->link($this->url)
            ->authorName('台南左鎮公舘社區發展協會');
    }

    public static function getAllFeedItems(): Collection
    {
        return static
            ::query()
            ->wherePublished()
            ->orderBy('published_at', 'desc')
            ->get();
    }
}
