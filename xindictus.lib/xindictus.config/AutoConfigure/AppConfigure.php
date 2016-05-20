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
 * File: getConnectionStatus.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 20/4/2016
 * Time: 08:41
 *
 ******************************************************************************/
namespace Indictus\Config\AutoConfigure;

/**
 * Require AutoLoader
 */
require_once(__DIR__."/../AutoLoader/AutoLoader.php");

/**
 * Class AppConfigure
 * @package Indictus\Config\AutoConfigure
 *
 * This class loads the configuration properties for the Application.
 */
class AppConfigure extends Configure
{
    /**
     * @var $configArray: This array consists of the App variables
     * taken right from the configuration file.
     */
    protected $configArray;

    /**
     * @var $phpVer: The PHP version.
     */
    protected $phpVer;

    /**
     * AppConfigure constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->configArray = $this->configFile['App'];
        $this->phpVer = $this->configFile['PHP']['version'];
    }

    /**
     * @param null $associate: The name of the parameter we are searching.
     * @return mixed: Returns the parameter's value, or, if the parameter
     * was not found, returns -1.
     */
    function getParam($associate = null)
    {
        if($associate == null)
            return $this->configArray;
        if(array_key_exists($associate, $this->configArray))
            return $this->configArray[$associate];
        return -1;
    }

    /**
     * @return: Returns the PHP version.
     */
    public function getPhpVer()
    {
        return $this->phpVer;
    }

}