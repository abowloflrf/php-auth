<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'twig' => [
            'template_path' => __DIR__ . '/../templates/',
            'cache_path' => __DIR__ . '/../storage/view/'
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'auth',
            'username' => 'homestead',
            'password' => 'secret',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
        'session' => [
            'gc_maxlifetime' => 60 * 60 * 24 * 10,
            'cookie_lifetime' => 60 * 60 * 24 * 10,
            'save_path' => __DIR__ . "/../storage/sessions/"
        ]
    ],
];
