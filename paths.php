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
 * Time: 04:12
 *
 ******************************************************************************/
namespace Indictus;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('ROOT')) {
    define('ROOT', __DIR__);
}

if (!defined('Indictus')) {
    define('Indictus', ROOT . DS . "indictus.lib");
}

return [
    'Indictus' => Indictus,

    'Config' => 'indictus.config',
    'AutoConfigure' => 'AutoConfigure',

    'Database' => 'indictus.database',
    'CRUD' => 'crudHandlers',
    'dbHandlers' => 'dbHandlers',

    'Exception' => 'indictus.exception',
    'ErHandlers' => 'error_handlers',

    'Filtering' => 'indictus.filtering',

    'Validation' => 'validationHandlers',

    'General' => 'indictus.general',

    'Model' => 'indictus.model',

    'Session' => 'indictus.session_management',

    'Privilege' => 'indictus.privilege_handlers',

];