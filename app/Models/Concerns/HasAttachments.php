<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\Attachment;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasAttachments
{
    public function attachments(): MorphToMany
    {
        return $this->morphToMany(Attachment::class, 'attachmentable');
    }
}
