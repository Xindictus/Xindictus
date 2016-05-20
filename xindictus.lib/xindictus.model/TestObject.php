<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 13/4/2016
 * Time: 06:35
 */
namespace Indictus\Model;

/**
 * Require AutoLoader
 */
require_once(__DIR__ . "/../xindictus.config/AutoLoader/AutoLoader.php");

class TestObject extends Entity
{
    const DATABASE = "BusinessDays";
    private static $tableName = "event";

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