<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use SplFileInfo;

/**
 * @see docs/attachments.md
 * @mixin IdeHelperAttachment
 */
final class Attachment extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
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

    public function meta(): Attribute
    {
        return new Attribute(
            get: static fn ($value) => json_decode($value ?? '[]', associative: true, flags: JSON_THROW_ON_ERROR),
            set: static function ($value) {
                ksort($value);
                $encoded = json_encode($value, JSON_THROW_ON_ERROR);

                return [
                    'meta' => $encoded,
                    'meta_md5' => md5($encoded),
                ];
            }
        );
    }

    public static function fromFile(UploadedFile $file): self
    {
        $model = new self();
        $model->name = $file->getClientOriginalName();
        $model->mime = $file->getMimeType();
        $model->size = $file->getSize();
        $model->file_md5 = md5_file($file->getRealPath());

        return $model;
    }

    public function attachmentables(): HasMany
    {
        return $this->hasMany(Attachmentable::class);
    }

    public function scopeWithFile(Builder $query, SplFileInfo $file): Builder
    {
        return $query->where('file_md5', md5_file($file->getRealPath()));
    }

    /**
     * @throws \JsonException
     */
    public function scopeWithMeta(Builder $query, array $meta): Builder
    {
        ksort($meta);

        return $query->where('meta_md5', md5(json_encode($meta, JSON_THROW_ON_ERROR)));
    }
}
