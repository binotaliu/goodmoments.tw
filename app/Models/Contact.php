<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperContact
 */
final class Contact extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function scopeSelectForIndex(Builder $query)
    {
        return $query->select('id', 'name', 'subject', 'created_at');
    }
}
