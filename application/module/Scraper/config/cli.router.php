<?php
return [
    // Scraper commands
    '/^(scraper):(list|records):([A-za-z0-9-]+)?:?([0-9]+)?$/i' => [
        'type'       => 'RegExp',
        'module'     => 'Scraper',
        'controller' => '',
        'action'     => '',
        'matches'    => ['controller', 'action', 'service', 'limit'],
    ],
    // Scraper commands
    '/^(help)$/i' => [
        'type'       => 'RegExp',
        'module'     => 'Scraper',
        'controller' => 'help',
        'action'     => 'info'
    ],
];