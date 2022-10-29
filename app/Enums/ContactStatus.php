<?php

declare(strict_types=1);

namespace App\Enums;

enum ContactStatus: string
{
    case created = 'created';
    case processing = 'processing';
    case resolved = 'resolved';
}
