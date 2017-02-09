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
 * File: dirFiles.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 29/6/2016
 * Time: 02:49
 *
 ******************************************************************************/

use Indictus\Config\AutoConfigure;

require_once __DIR__ . "/../../xindictus.lib/xindictus.config/AutoLoader/AutoLoader.php";

/**
 * @param $dir
 * @return array
 */
function dirToArray($dir) {

    $result = array();
    //TODO: HEADERS TO EVERY CONTROLLER
    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }

    return $result;
}

$directory = '';

$app = new AutoConfigure\AppConfigure();

if ($app->getGlobalParam('debug') === 'enabled')
    $directory = __DIR__ . "/../../xindictus.lib/xindictus.cache";
else if ($app->getGlobalParam('debug') === 'setup')
    $directory = $app->getGlobalParam('models');

echo json_encode(dirToArray($directory));