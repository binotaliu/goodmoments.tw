<?php

/*
 * This file is part of Laravel Optimus.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Optimus Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [
        App\Models\Product::class => [
            'prime' => env('OPTIMUS_PRODUCT_PRIME'),
            'inverse' => env('OPTIMUS_PRODUCT_INVERSE'),
            'random' => env('OPTIMUS_PRODUCT_RANDOM'),
        ],

        App\Models\Article::class => [
            'prime' => env('OPTIMUS_ARTICLE_PRIME'),
            'inverse' => env('OPTIMUS_ARTICLE_INVERSE'),
            'random' => env('OPTIMUS_ARTICLE_RANDOM'),
        ],
    ],
];
