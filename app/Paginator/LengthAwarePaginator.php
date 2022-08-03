<?php

declare(strict_types=1);

namespace App\Paginator;

use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;

final class LengthAwarePaginator extends Paginator
{
    public function linkCollection(): Collection
    {
        return collect($this->elements())->flatMap(function ($item) {
            if (! is_array($item)) {
                return [['url' => null, 'label' => '...', 'active' => false]];
            }

            return collect($item)->map(function ($url, $page) {
                return [
                    'url' => $url,
                    'label' => (string) $page,
                    'active' => $this->currentPage() === $page,
                ];
            });
        });
    }
}
