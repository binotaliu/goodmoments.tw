<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * @mixin IdeHelperCategory
 */
final class Category extends Model
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = ['name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
