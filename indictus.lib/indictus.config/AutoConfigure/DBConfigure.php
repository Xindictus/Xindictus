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
 * Date: 13/4/2016
 * Time: 05:38
 *
 ******************************************************************************/
namespace Indictus\Config\AutoConfigure;

include_once(__DIR__."/../AutoLoader/AutoLoader.php");

/**
 * Class DBConfigure
 * @package Indictus\Config\AutoConfigure
 */
class DBConfigure extends Configure
{

    /**
     * @var
     */
    protected $configArray;

    /**
     * DBConfigure constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->configArray = $this->configFile['Database'];
    }

    /**
     * @param null $associate
     * @return string
     */
    public function getParam($associate = null)
    {
        if($associate == null)
            return $this->configArray;
        else
            if(array_key_exists($associate, $this->configArray))
                return $this->configArray[$associate];
        return "";
    }

    /**
     * @param string $databaseAssoc
     * @return array
     */
    public function getAccess($databaseAssoc = "")
    {
        $database = "";
        if (array_key_exists($databaseAssoc, $this->configArray['database']))
            $database = $this->configArray['database'][$databaseAssoc];

        return [
            'driver' => $this->configArray['driver'],
            'host' => $this->configArray['host'],
            'port' => $this->configArray['port'],
            'username' => $this->configArray['username'],
            'password' => $this->configArray['password'],
            'database' => $database
        ];
    }

    /**
     * @return mixed
     */
    public function getFlags()
    {
        return $this->configArray['flags'];
    }


}