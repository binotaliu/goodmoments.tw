<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @method static Attachments make()
 */
class Attachments extends AllExists
{
    public function __construct()
    {
        parent::__construct('attachments', 'uuid');
    }

    public function passes($attribute, $value): bool
    {
        $uuids = data_get($value, '*.uuid', []);

        return parent::passes($attribute, $uuids);
    }

    public function whereMeta(string $key, mixed $value): static
    {
        return $this->where("meta->{$key}", $value);
    }
}
