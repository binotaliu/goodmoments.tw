<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @method static Attachment make()
 */
final class Attachment extends Attachments
{
    public function passes($attribute, $value): bool
    {
        return parent::passes($attribute, [$value]);
    }
}
