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
 * Date: 13/4/2016
 * Time: 05:50
 *
 ******************************************************************************/
namespace Indictus\Config\AutoLoader;

/**
 * Class AutoLoader
 * @package Indictus\Config\AutoLoader
 */
class AutoLoader
{
    /**
     * @param $className
     */
    public static function autoload($className)
    {
        $paths = include(__DIR__."/../../../paths.php");
        $className = ltrim($className, '\\');
        $fileName  = '';

        if ($lastNsPos = strrpos($className, '\\')){

            $lastNsPos = strrpos($className, '\\');
            $namespace = explode('\\', substr($className, 0, $lastNsPos));
            $className = substr($className, $lastNsPos + 1);

            foreach ($namespace as $value)
                $fileName .= $paths[$value] . DS;
        }

        $fileName .= $className . '.php';

        require_once $fileName;
    }
}

spl_autoload_register(array('Indictus\Config\AutoLoader\AutoLoader', 'autoload'));