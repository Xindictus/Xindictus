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
 * File: #CLASSNAME#.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: #DATE#
 * Time: #TIME#
 *
 ******************************************************************************/
namespace Indictus\Model;

/**
 * Require AutoLoader
 */
require_once(__DIR__ . "/../../xindictus.config/AutoLoader/AutoLoader.php");

class #CLASSNAME# extends Entity
{
    const DATABASE = #DATABASE#;
    private static $tableName = #TABLE_NAME#;

    private static $tableFields = #TABLE_FIELDS#;

    #PROPERTIES#
    public function __construct(#CONSTRUCTOR_PARAMETERS#)
    {
        #CONSTRUCTOR_BODY#
    }

    /**
     * @return int: 0 for success and -1 for query fail.
     */
    public function insert()
    {
        return parent::process_insert(self::$tableName, self::$tableFields, $this->getObjectValues());
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }

    public function select()
    {
        // TODO: Implement select() method.
    }

    /**
     * @return array
     *
     * Returns an array of this object's properties' values.
     */
    private function getObjectValues()
    {
        $columnValues = array();

        /**
         * Get object's properties' values.
         */

        $vars = get_object_vars($this);
        /**
         * Iterate $vars and add the values to a new array $columnValues
         */
        foreach ($vars as $key => $value)
            array_push($columnValues, $value);

        return $columnValues;
    }

    /**
     * @param int $column: Column of table, represented by object's $table_fields.
     * @return int: Number of columns.
     */
    public function lastInsertId($column = 0)
    {
        return parent::lastInsertId(self::$tableName.".".self::$tableFields[$column]);
    }

    /**
     * @param null $database: Database alias.
     * @param null $table: Table name.
     * @return int: Number of columns.
     */
    public function columnCount($database = null, $table = null)
    {
        if ($table == null)
            $table = self::$tableName;
        return parent::columnCount(self::DATABASE, $table);
    }

    /**
     * @param null $table: Table name.
     * @return int: Return number of rows.
     */
    public function rowCount($table = null)
    {
        if ($table == null)
            $table = self::$tableName;
        return parent::rowCount($table);
    }

    /**
     * Remove tags from the values.
     */
    public function stripUserInput()
    {
        foreach (self::$tableFields as $value)
            $this->{$value} = strip_tags(html_entity_decode($this->{$value}));
    }

    /**
     * Removes leading and trailing whitespaces from the values.
     */
    public function trimWhitespaces()
    {
        foreach (self::$tableFields as $value)
            $this->{$value} = trim($this->{$value});
    }

    function validate_input()
    {
        // TODO: Implement validate_input() method.
    }
}