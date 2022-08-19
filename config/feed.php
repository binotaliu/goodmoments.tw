<?php

return [
    'feeds' => [
        'products' => [
            'items' => [App\Models\Product::class, 'getAllFeedItems'],

            'url' => '/feeds/products',

            'title' => '產品 – 好時・左鎮公舘',
            'description' => '包含新上架產品的動態。',
            'language' => 'zh-Hant-TW',

            'image' => '/images/logo.png',

            'format' => 'atom',

            'view' => 'feed::atom',
            'type' => null,
            'contentType' => null,
        ],
        'articles' => [
            'items' => [App\Models\Article::class, 'getAllFeedItems'],

            'url' => '/feeds/articles',

            'title' => '文章 – 好時・左鎮公舘',
            'description' => '新文章動態。',
            'language' => 'zh-Hant-TW',

            'image' => '/images/logo.png',

            'format' => 'atom',

            'view' => 'feed::atom',
            'type' => null,
            'contentType' => null,
        ],
    ],
];
