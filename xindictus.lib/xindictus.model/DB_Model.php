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
 * Time: 06:17
 *
 ******************************************************************************/
namespace Indictus\Model;

use Indictus\Database\dbHandlers as dbHandlers;

/**
 * Require AutoLoader
 */
require_once __DIR__ . "/../xindictus.config/AutoLoader/AutoLoader.php";

/**
 * Class DB_Model
 * @package Indictus\Model
 *
 * The abstract layer containing the database model for the basic queries.
 */
abstract class DB_Model
{
    /**
     * @var $connection : contains the connection for object's queries.
     */
    protected static $connection;

    /**
     * @var $errorCode : Contains the errorCode of the last failed query.
     */
    protected static $errorCode;

    /**
     * @var $errorInfo : A string containing the errorInfo of the last failed query.
     */
    protected static $errorInfo;

    /**
     * @return \Indictus\Database\dbHandlers\CustomPDO
     *
     * This method returns the current connection.
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    /**
     * @param dbHandlers\CustomPDO $connection : A PDO connection to a database.
     *
     * This method sets the connection to the database for the specified object.
     */
    public function setConnection(dbHandlers\CustomPDO $connection)
    {
        self::$connection = $connection;
    }

    /**
     * @param $table
     * @param array $columnNames
     * @param array $columnValues
     * @return mixed
     */
    abstract protected function process_insert($table, array $columnNames, array $columnValues);

    abstract protected function process_update($table, array $columnValues, array $updateRow);

    abstract protected function process_delete($tableName, array $deleteRow);

    abstract protected function process_select($tableName, array $selectRow, $selectColumns, $className);
}