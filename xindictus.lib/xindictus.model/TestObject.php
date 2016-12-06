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

    public function update(array $tableFields = array(), array $tableValues = array(), array $whereClause = null)
    {
        if ($whereClause == null)
            $whereClause = array_slice(array_slice(get_class_vars(__CLASS__), 0, -4), 0, 1);

        return parent::process_update(self::TABLE_NAME, $tableFields, $tableValues, $whereClause);
    }

    public function delete(array $whereClause = null)
    {
        if ($whereClause == null)
            $whereClause = array_slice(array_slice(get_class_vars(__CLASS__), 0, -4), 0, 1);

        return parent::process_delete(self::TABLE_NAME, $whereClause);
    }

    public function select($selectColumns = "*", array $whereClause = null)
    {
        if ($whereClause == null)
            $whereClause = array_slice(array_slice(get_class_vars(__CLASS__), 0, -4), 0, 1);

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

    /**
     * @return null
     */
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * @return null
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * @return null
     */
    public function getEventYear()
    {
        return $this->event_year;
    }

    public function setEventId($id)
    {
        $this->event_id = $id;
        return $this;
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
     * @param $event_year
     * @return $this
     */
    public function setEventYear($event_year)
    {
        $this->event_year = $event_year;
        return $this;
    }


}

