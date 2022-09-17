<?php

namespace App\Rules;

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
