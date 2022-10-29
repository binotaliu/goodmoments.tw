<?php

namespace App\Models;

use App\Enums\ContactStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperContact
 */
final class Contact extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $casts = [
        'status' => ContactStatus::class,
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(ContactComment::class);
    }

    public function scopeSelectForIndex(Builder $query)
    {
        return $query->select('id', 'status', 'name', 'subject', 'created_at');
    }
}
