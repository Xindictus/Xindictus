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
 * File: frameworkExample.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 13/4/2016
 * Time: 06:35
 *
 ******************************************************************************/
namespace Indictus\Model;

class TestObject extends Entity
{
    const DATABASE = "BusinessDays";
    const TABLE_NAME = "event";

    private static $tableFields = array('event_id', 'event_name', 'event_year');

    private $event_id;
    private $event_name;
    private $event_year;

    public function __construct($event_name = null, $event_year = null, $event_id = null)
    {
        $this->event_name = $event_name;
        $this->event_year = $event_year;
        $this->event_id = $event_id;
    }

    /**
     * @return int: 0 for success and -1 for query fail.
     */
    public function insert()
    {
        return parent::process_insert(self::TABLE_NAME, self::$tableFields, $this->getObjectValues());
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
        $keys = array_keys(array_slice(get_class_vars(__CLASS__), 0, -4));

        $vars = array();
        foreach ($keys as $var)
            $vars[$var] = $this->{$var};

        /**
         * Iterate $vars and add the values to a new array $columnValues
         */
        foreach ($vars as $key => $value)
            array_push($columnValues, $value);

        return $columnValues;
    }

    /**
     * @param array|null $updateValues : an array with the new values
     * @param array|null $whereClause : an array with field parameters
     * @return int : Returns 0 for success and -1 for failure.
     */
    public function update(array $updateValues = null, array $whereClause = null)
    {
        if ($whereClause == null) {
            $whereClause = array_slice(array_slice(get_class_vars(__CLASS__), 0, -4), 0, 1);
            $whereClause = array(
                array_keys($whereClause)[0] => $this->{array_keys($whereClause)[0]}
            );
        }

        return parent::process_update(self::TABLE_NAME, $updateValues, $whereClause);
    }

    /**
     * @param array|null $whereClause : an array with field parameters.
     * @return int : Returns 0 for success and -1 for failure.
     */
    public function delete(array $whereClause = null)
    {
        if ($whereClause == null) {
            $whereClause = array_slice(array_slice(get_class_vars(__CLASS__), 0, -4), 0, 1);
            $whereClause = array(
                array_keys($whereClause)[0] => $this->{array_keys($whereClause)[0]}
            );
        }

        return parent::process_delete(self::TABLE_NAME, $whereClause);
    }

    /**
     * @param array|null $whereClause : an array with field parameters.
     * @param string $selectColumns : a string with the columns to be selected.
     * @return array|int : Returns an array of objects of this class, or an empty array
     *                     if no rows matched the query.
     */
    public function select(array $whereClause = null, $selectColumns = "*")
    {
        if ($whereClause == null) {
            $whereClause = array_slice(array_slice(get_class_vars(__CLASS__), 0, -4), 0, 1);
            $whereClause = array(
                array_keys($whereClause)[0] => $this->{array_keys($whereClause)[0]}
            );
        }

        return parent::process_select(self::TABLE_NAME, $whereClause, $selectColumns, get_class());
    }

    /**
     * @param int $column : Column of table, represented by object's $table_fields.
     * @return int: Number of columns.
     */
    public function lastInsertId($column = 0)
    {
        return parent::lastInsertId(self::TABLE_NAME . "." . self::$tableFields[$column]);
    }

    /**
     * @param $database : Database alias.
     * @param $table : Table name.
     * @return int: Number of columns.
     */
    public function columnCount($database = self::DATABASE, $table = self::TABLE_NAME)
    {
        return parent::columnCount($database, $table);
    }

    /**
     * @param $table : Table name.
     * @return int: Return number of rows.
     */
    public function rowCount($table = self::TABLE_NAME)
    {
        return parent::rowCount($table);
    }

    /**
     * Remove tags from the values.
     */
//    public function stripUserInput()
//    {
//        foreach (self::$tableFields as $value)
//            $this->{$value} = strip_tags(html_entity_decode($this->{$value}));
//    }
    //TODO: TRANSFER TO FILTER

    /**
     * @return null
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setEventId($id)
    {
        $this->event_id = $id;
        return $this;
    }

    /**
     * @return null
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * @param $event_name
     * @return $this
     */
    public function setEventName($event_name)
    {
        $this->event_name = $event_name;
        return $this;
    }

    /**
     * @return null
     */
    public function getEventYear()
    {
        return $this->event_year;
    }

    /**
     * @param $event_year
     * @return $this
     */
    public function setEventYear($event_year)
    {
        $this->event_year = $event_year;
        return $this;
    }
}