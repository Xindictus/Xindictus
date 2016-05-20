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
 *
 * This class loads the configuration properties for the Database.
 */
class DBConfigure extends Configure
{
    /**
     * @var $configArray: This array consists of the Database variables
     * taken right from the configuration file.
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
        if(array_key_exists($associate, $this->configArray))
            return $this->configArray[$associate];
        return -1;
    }

    /**
     * @param string $databaseAssoc: The database alias.
     * @return array: Returns an array with all the configuration settings for
     * the selected database. If the alias is not found, it returns -1.
     */
    public function getAccess($databaseAssoc = "")
    {
        if (array_key_exists($databaseAssoc, $this->configArray['database']))
            $database = $this->configArray['database'][$databaseAssoc];
        else
            return -1;

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
     * @return array: Returns the flags for the PDO connection.
     */
    public function getFlags()
    {
        return $this->configArray['flags'];
    }
}