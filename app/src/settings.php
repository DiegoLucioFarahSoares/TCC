<?php

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,

        'phpview' => [
            'template_path' => __DIR__ . '/../../view/pages/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'SlimSic',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/logs/app.log',
            'level' => Logger::DEBUG,
            'maxFiles' => 30,
        ],
    ],
];