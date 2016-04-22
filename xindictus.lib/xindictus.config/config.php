<?php namespace Indictus\Config;

/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 12/4/2016
 * Time: 04:05
 */

return [
    'PHP' => [
        'version' => phpversion()
    ],

    'debug' => 'enabled',

    'App' => [
        'namespace' => 'App',
        'base' => false,
        'dir' => 'src',
        'fullBaseUrl' => false,
        'imageBaseUrl' => 'img/',
        'cssBaseUrl' => 'css/',
        'jsBaseUrl' => 'js/',
        'timezone' => 'Europe/Athens',
        'encoding' => 'utf8'
    ],

    'Security' => [
        'salt' => 'f8491eb3555b7d476468a312a1e0edef7a21104babba49fe0eb02587acf00f54',
    ],

    'Database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'username' => 'root',
        'password' => 'abc123',
        'database' => [
            'BD' => 'business_days_database',
            'BD2' => 'business_days_database2',
        ],
        'charset' => 'utf8',
//        'collation' => 'utf8_unicode_ci',
        'collation' => null,
        'timezone' => 'Europe/Athens',
        'flags' => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]
    ],

    'Session' => [
        /*
         * Supported: "file", "cookie", "database", "apc",
         * "memcached", "redis", "array"
         */
        'driver' => 'cookie',
        'lifetime' => '3600',
        'expire_on_close' => false,
        'files' => '/sessions',
        'connection' => null,
        'table' => '',
        'cookie' => 'xindictusSession',
        'https' => ''
    ]

];