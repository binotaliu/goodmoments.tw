<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

final class Depth implements Rule
{
    private string $message = '';

    public function __construct(
        private readonly int $depth,
    ) {
    }

    public function passes($attribute, $value): bool
    {
        $depthDetected = $this->checkArrayDepth($value);

        if ($depthDetected > $this->depth) {
            $this->message = __('validation.depth', ['attribute' => $attribute, 'max' => $this->depth]);

            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }

    private function checkArrayDepth(array $value, int $initialDepth = 1): int
    {
        $depth = $initialDepth;
        foreach ($value as $item) {
            if (! is_array($item)) {
                continue;
            }

            $depth = max($depth, $this->checkArrayDepth($item, $depth + 1));

            // if $depth is greater than $this->depth, stop go deeper
            if ($depth > $this->depth) {
                break;
            }
        }

        return $depth;
    }
}
