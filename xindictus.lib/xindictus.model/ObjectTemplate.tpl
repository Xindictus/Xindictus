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
namespace #NAMESPACE#;

use Indictus\Model;

/**
 * Require AutoLoader
 */
require_once __DIR__ . "/../../xindictus.config/AutoLoader/AutoLoader.php";

class #CLASSNAME# extends Model\Entity
{
    const DATABASE = #DATABASE#;
    const TABLE_NAME = #TABLE_NAME#;

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
        return parent::process_insert(self::TABLE_NAME, self::$tableFields, $this->getObjectValues());
}

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
* @param int $column: Column of table, represented by object's $table_fields.
* @return int: Number of columns.
*/
public function lastInsertId($column = 0)
{
return parent::lastInsertId(self::TABLE_NAME.".".self::$tableFields[$column]);
}

/**
* @param $database: Database alias.
* @param $table: Table name.
* @return int: Number of columns.
*/
public function columnCount($database = self::DATABASE, $table = self::TABLE_NAME)
{
return parent::columnCount($database, $table);
}

/**
* @param $table: Table name.
* @return int: Return number of rows.
*/
public function rowCount($table = self::TABLE_NAME)
{
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

#SETTERS##GETTERS#
}