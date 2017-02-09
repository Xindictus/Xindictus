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
 * File: MailConfigure.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 18/12/2016
 * Time: 13:32
 *
 ******************************************************************************/
namespace Indictus\Config\AutoConfigure;

/**
 * Require AutoLoader
 */
require_once __DIR__ . "/../../autoload.php";

/**
 * Class MailConfigure
 * @package Indictus\Config\AutoConfigure
 */
class MailConfigure extends Configure
{
    /**
     * @var $configArray : This array consists of the Mail variables
     * taken right from the configuration file.
     */
    protected $configArray;

    /**
     * AppConfigure constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->configArray = $this->configFile['Mail'];
    }

    /**
     * @param null $associate : The name of the parameter we are searching.
     * @return mixed: Returns the parameter's value, or, if the parameter
     * was not found, returns -1.
     */
    public function getParam($associate = null)
    {
        if ($associate == null)
            return $this->configArray;

        if (array_key_exists($associate, $this->configArray))
            return $this->configArray[$associate];

        return -1;
    }
}