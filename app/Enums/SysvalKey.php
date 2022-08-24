<?php

declare(strict_types=1);

namespace App\Enums;

enum SysvalKey: string
{
    case about__description = 'about:description';
    case life__blocks = 'life:blocks';
    case map_description = 'map:description';
}
