<?php
/******************************************************************************
 * Copyright (c) 2016 Konstantinos Vytiniotis, All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 *
 * File: index.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 12/4/2016
 * Time: 04:05
 *
 ******************************************************************************/

namespace Indictus\Config;

return [

    /*
     * Gets the current PHP version.
     */
    'PHP' => [
        'version' => phpversion()
    ],

    /*
     * If 'enabled', Control Panel is available to be accessed.
     * If 'setup', Files are created inside xindictus.Classes instead of xindictus.cache.
     * If 'disabled', Control Panel is inaccessible.
     */
    'debug' => 'disabled',
    'models' => PROJECT . DS . 'models',

    /*
     * Variables for the Platform
     *
     * year: current year
     * panorama_id: the id of the current panorama event taken from `panorama_event` table
     */
    'Platform' => [
        'year' => 2019,
        'panorama_id' => 82
    ],

    /*
     * Variables for the Application
     */
    'App' => [
        'namespace' => 'App',
        'base' => false,
        'dir' => 'src',
        'fullBaseUrl' => false,
        'imageBaseUrl' => Indictus . '/../public/img/',
        'cssBaseUrl' => Indictus . '/../public/css/',
        'jsBaseUrl' => Indictus . '/../public/js/',
        'timezone' => 'Europe/Athens',
        'encoding' => 'utf8'
    ],

    /*
     * Security salt (CURRENTLY NOT IN USE)
     */
    'Security' => [
        'salt' => 'f8491eb3555b7d476468a312a1e0edef7a21104babba49fe0eb02587acf00f54',
    ],

    //TODO: MULTIPLE DATABASE/USER-PASSWORD SUPPORT
    'Database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'username' => 'root',
//        'username' => 'xindictus',
        'password' => 'abc123',
//        'password' => '9<Xhe4?;BY7vwpUj',
        'database' => [
            /*
             * Databases (values) are represented with an alias (key).
             */
            'BusinessDays' => 'business_days_db'
        ],
        'charset' => 'utf8',
//        'collation' => 'utf8_unicode_ci',
        'collation' => null,
        'timezone' => 'Europe/Athens',
        'flags' => [
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_PERSISTENT => true
        ]
    ],

    'Session' => [
        /*
         *
         */
        'driver' => '',
        'lifetime' => '3600',
        'expire_on_close' => false,
        'files' => '/sessions',
        'connection' => null,
        'table' => '',
        'cookie' => 'xindictusSession',
        'https' => ''
    ],

    /**
     * enable ssl on php.ini
     * secure less apps
     */
    'Mail' => [
        /*
         * 0 for production
         * 1 - 3 for more details
         */
        'SMTPDebug' => 0,
        'Debugoutput' => 'html',
        'SMTPAuth' => true,
        'Host' => gethostbyname('tls://smtp.gmail.com:587'),
        'Username' => 'businessdays@pan-orama.org',
        'Password' => '1panoramaadmin',
        'FromName' => 'Πανόραμα ~ Business Days',
        'Encoding' => 'UTF-8'
    ]

];