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
 * Time: 08:47
 *
 ******************************************************************************/
namespace Indictus\Model;

use Indictus\Database\CRUD as crud;
use Indictus\Database\dbHandlers as dbH;
use Indictus\Filtering\Validation as val;

/**
 * Require AutoLoader
 */
require_once(__DIR__ . "/../xindictus.config/AutoLoader/AutoLoader.php");

/**
 * Class Entity
 * @package Indictus\Model
 *
 * This abstract class represents the abstraction layer of a database object
 * consisting of the database abstraction layer, the Validator/Sanitizer and
 * Error Reporting of queries.
 */
abstract class Entity extends dbH\DB_Table implements crud\SimpleCRUD, val\Validator
{
    /**
     * @param $tableName: Table's name
     * @param array $tableFields: Table's columns
     * @param array $insertValues: Table's values
     * @return int: Return type (0 or -1)
     *
     * The encapsulation of the database's insertion.
     */
    protected function process_insert($tableName, array $tableFields, array $insertValues)
    {
        return parent::process_insert($tableName, $tableFields, $insertValues);
    }

    protected function process_update($tableName, array $tableFields, array $updateValues, array $updateRow)
    {
        return parent::process_update($tableName, $tableFields, $updateValues, $updateRow);
    }

    protected function process_delete($tableName, array $deleteRow = null)
    {
        return parent::process_delete($tableName, $deleteRow);
    }

    protected function process_select($tableName, array $selectRow = null, $selectColumns = "*", $className)
    {
        return parent::process_select($tableName, $selectRow, $selectColumns, $className);
    }

    /**
     * The validation/sanitation abstraction layer.
     */

    /**
     * Removes tags from the values.
     */
    abstract public function stripUserInput();

    /**
     * Removes leading and trailing whitespaces from the values.
     */
    abstract public function trimWhitespaces();

    /**
     * @return mixed
     *
     * Validates values.
     */
    abstract public function validate_input();

}