<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 13/4/2016
 * Time: 06:35
 */
namespace Indictus\Model;

use Indictus\Database\CRUD\SimpleCRUD;

require_once(__DIR__ . "/../xindictus.config/AutoLoader/AutoLoader.php");

class Test2 extends Entity implements SimpleCRUD{

    const DATABASE = "business_days";
    private static $TABLE_NAME = "event";

    private static $table_fields = array('event_id', 'event_name', 'event_year');

    private $event_id;
    private $event_name;
    private $event_year;

    public function __construct($event_name = null, $event_year = null, $event_id = null)
    {
        $this->event_name = $event_name;
        $this->event_year = $event_year;
        $this->event_id = $event_id;
    }

    public function insert()
    {
        return parent::process_insert(self::$TABLE_NAME, self::$table_fields, $this->getObjectValues());
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

//
//    public function updateRow($connection, array $update_fields)
//    {
//        parent::process_update($connection, self::$TABLE_NAME, $this->construct_update_values($update_fields), array(self::$table_fields[0],$this->event_id));
//    }
//
//    public function deleteRow($connection)
//    {
//        parent::process_delete($connection, self::$TABLE_NAME, array(self::$table_fields[0],$this->event_id));
//    }
//
//    public function selectRow($connection)
//    {
//
//    }

    private function getObjectValues()
    {
        $columnValues = array();

        $vars = get_object_vars($this);
        foreach ($vars as $key => $value)
            array_push($columnValues, $value);

        return $columnValues;
    }

//    private static $DB = "aaa";
//    private static  $TN = "bbb";
//    private static  $TF = "ccc";
//
//    public $sth1 = '<p>Test paragraph.</p><!-- Comment --> <a href="#fragment">Other text</a>';
//    public $sth2 = "sth2";
//    public $sth3 = "sth3";
//
//    public function __construct()
//    {
//        echo __CLASS__ . " created successfully";
//    }
//
    function validate_input()
    {
        // TODO: Implement validate_user_input() method.
    }

    public function stripInput()
    {
        $this->strip_input($this->getObjectValues());
    }
//
//    function stripUserInput(){
//        $dataFields = get_object_vars($this);
//        parent::strip_input($dataFields);
//    }
}