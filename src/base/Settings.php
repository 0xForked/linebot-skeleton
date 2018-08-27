<?php
return [
    'settings' => [
        'displayErrorDetails' => true,

        'addContentLengthHeader' => false,

        // Database Setting
        'db' => [
            'driver'        => 'mysql',
            'host'          => 'localhost',
            'database'      => '',
            'username'      => '',
            'password'      => '',
            'charset'       => 'utf8',
            'collation'     => 'utf8_unicode_ci',
            'prefix'        => '',
        ],

        // Monolog setting
        'logger' => [
            'name' => 'line-bot',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Line setting
        'line' => [
            'CHANNEL_ACCESS_TOKEN' => "",
            'CHANNEL_SECRET' => "",
            'PASS_SIGNATURE' => true
        ]
    ]
];