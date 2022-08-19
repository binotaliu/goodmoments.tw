<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Cog\Laravel\Optimus\Facades\Optimus;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasXid
{
    public function xid(): Attribute
    {
        return Attribute::get(
            fn () => $this->xidPrefix . str_pad(
                string: (string) Optimus::connection(static::class)->encode($this->id),
                length: 10,
                pad_string: '0',
                pad_type: STR_PAD_LEFT,
            ),
        );
    }
}
