<?php
return [
    // configuration of storage
    'storage' => [
        'path' => dirname(APP_BASE_PATH) . DS . 'storage'
    ],
    // scrapers
    'scrapers' => [
        'careercenter' => [
            'service'  => \Scraper\Service\CareerCenter\Scraper::class,
            'params'   => [
                'name'     => 'CareerCenter',
                'mainUrl'  => 'https://careercenter.am/',
                'listUrl'  => 'https://careercenter.am/ccidxann.php',
                'haystack' => 'ccdspann.php?id=',
                'path'     => 'careercenter'
            ]
        ]
    ]
];