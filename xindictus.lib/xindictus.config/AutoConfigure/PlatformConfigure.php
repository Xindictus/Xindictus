<?php
/******************************************************************************
 * Copyright (c) 2018 Konstantinos Vytiniotis, All rights reserved.
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
 * File: PlatformConfigure.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 15/12/2018
 * Time: 15:19
 *
 ******************************************************************************/

namespace Indictus\Config\AutoConfigure;

/**
 * Require AutoLoader
 */
require_once __DIR__ . "/../../autoload.php";

/**
 * Class PlatformConfigure
 * @package Indictus\Config\AutoConfigure
 *
 * This class loads basic configuration parameters for the Application,
 * such as the current panorama event.
 */
class PlatformConfigure extends Configure
{
    /**
     * @var $configArray : This array consists of the Platform variables
     * taken right from the configuration file.
     */
    protected $configArray;

    /**
     * PlatformConfigure constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->configArray = $this->configFile['Platform'];

        return $this;
    }

    /**
     * @param null $associate : The name of the parameter we are searching.
     * @return int|mixed: Returns the whole configuration array for the Platform,
     * or the association's value or -1 if the parameter was not found.
     */
    public function getParam($associate = null)
    {
        if ($associate == null) {
            return $this->configArray;
        }

        if (array_key_exists($associate, $this->configArray)) {
            return $this->configArray[$associate];
        }

        return -1;
    }
}