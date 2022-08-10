<?php

namespace App\Rules;

use App\Utils\Makeable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\DatabaseRule;

/**
 * @method static AllExists make(string $table, string $column = 'NULL')
 */
final class AllExists implements Rule
{
    use Makeable;
    use DatabaseRule;

    private string $message = '';

    public function passes($attribute, $value): bool
    {
        if (!Arr::accessible($value)) {
            return $this->failsWith(__('validation.array', ['attribute' => $attribute]));
        }

        if (empty($value)) {
            return true;
        }

        if (!empty(array_filter($value, fn ($v) => !is_string($v) && !is_int($v)))) {
            return $this->failsWith(__('validation.all_exists', ['attribute' => $attribute]));
        }

        $query = DB::table($this->table)->whereIn($this->column, $value);

        // @TODO: support all type of wheres (including whereIn), currently only partial support for $this->wheres
        foreach ($this->wheres as $where) {
            $query->where($where['column'], $where['value']);
        }

        if ($query->count() !== count($value)) {
            return $this->failsWith(__('validation.all_exists', ['attribute' => $attribute]));
        }

        return true;
    }

    private function failsWith(string $message): bool
    {
        $this->message = $message;

        return false;
    }

    public function message(): string
    {
        return $this->message;
    }
}
