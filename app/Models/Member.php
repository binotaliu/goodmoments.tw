<?php

namespace App\Models;

use App\Models\Concerns\HasAttachments;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperMember
 */
final class Member extends Model
{
    use HasFactory;
    use SoftDeletes;

    use HasAttachments;

    protected $with = ['attachments'];

    protected $fillable = [
        'title',
        'name',
        'description',
        'row',
        'priority',
    ];

    protected $appends = [
        'image',
    ];

    protected $hidden = [
        'attachments',
    ];

    public function image(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->first(),
        );
    }

    public function imageUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->attachments->first()?->url,
        );
    }
}
