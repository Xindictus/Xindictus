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
 * Created by: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 12/4/2016
 * Time: 04:12
 *
 ******************************************************************************/
namespace Indictus;

if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);

//TODO: CHANGE ACCORDING TO PARENT FOLDER
if (!defined('BASE'))
    define('BASE', '/BusinessDays/');

if (!defined('ROOT'))
    define('ROOT', __DIR__);

if (!defined('Indictus'))
    define('Indictus', ROOT . DS . "xindictus.lib");

if (!defined('PROJECT'))
    define('PROJECT', ROOT . DS . "..");

if (!defined('MODELS'))
    define('MODELS', "/BusinessDays/app/models/BusinessDays");

return [
    'Indictus' => Indictus,

    'Config' => 'xindictus.config',
    'AutoConfigure' => 'AutoConfigure',

    'Database' => 'xindictus.database',
    'CRUD' => 'crudHandlers',
    'dbHandlers' => 'dbHandlers',
    'moreHandlers' => 'moreHandlers',

    'Exception' => 'xindictus.exception',
    'ErHandlers' => 'error_handlers',

    'Filtering' => 'xindictus.filtering',

    'Validation' => 'validationHandlers',

    'General' => 'xindictus.general',

    'Mail' => 'xindictus.mail',

    'Model' => 'xindictus.model',

    'Session' => 'xindictus.session_management',
    'SHandlers' => 'session_handlers',

    'Privilege' => 'xindictus.privilege_handlers',

    'Cache' => 'xindictus.cache',

    'Project' => PROJECT,
    'Models' => 'models',
    'Bds' => 'BusinessDays'
];