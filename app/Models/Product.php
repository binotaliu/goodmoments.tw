<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

final class Product extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['name', 'unit', 'description'];

    public const COVER_STORAGE = 'cover';
    public const IMAGE_STORAGE = 'image';

    protected $casts = [
        'images' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
