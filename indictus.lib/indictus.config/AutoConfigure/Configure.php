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
 * Time: 05:40
 *
 ******************************************************************************/
namespace Indictus\Config\AutoConfigure;

include_once(__DIR__."/../AutoLoader/AutoLoader.php");

/**
 * Class Configure
 * @package Indictus\Config\AutoConfigure
 */
abstract class Configure
{
    /**
     * @var mixed
     */
    protected $configFile;

    /**
     * Configure constructor.
     */
    public function __construct()
    {
        $this->configFile = include(__DIR__ . "/../config.php");
    }

    /**
     * @param $associate
     * @return mixed|string
     */
    public function getGlobalParam($associate)
    {
        if($associate == null)
            return $this->configFile;
        else
            if(array_key_exists($associate, $this->configFile))
                return $this->configFile[$associate];
        return "";
    }

    /**
     * @param $associate
     * @return mixed
     */
    abstract public function getParam($associate);

}