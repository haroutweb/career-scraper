<?php
return [
    // homepage
    '/^\/$/i' => [
        'type'       => 'RegExp',
        'module'     => 'Recruitment',
        'controller' => 'home',
        'action'     => 'index'
    ],
    // Jobs list
    '/^\/(jobs)$/i' => [
        'type'       => 'RegExp',
        'module'     => 'Recruitment',
        'controller' => 'job',
        'action'     => 'list',
    ],
    // job view
    '/^\/(jobs)\/(view)\/([0-9]+)$/i' => [
        'type'       => 'RegExp',
        'module'     => 'Recruitment',
        'controller' => 'job',
        'action'     => 'view',
        'matches'    => ['', 'action', 'id'],
    ],
    // not error page
    '/^\/(404)$/i' => [
        'type'       => 'RegExp',
        'module'     => 'Recruitment',
        'controller' => 'error',
        'action'     => 'error404',
    ],
];