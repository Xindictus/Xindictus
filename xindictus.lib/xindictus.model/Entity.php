<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 13/4/2016
 * Time: 08:47
 */
namespace Indictus\Model;

use Indictus\Database\CRUD as crud;
use Indictus\Database\dbHandlers as dbH;
use Indictus\Filtering\Validation as val;

require_once(__DIR__ . "/../xindictus.config/AutoLoader/AutoLoader.php");

abstract class Entity extends dbH\DB_Table implements val\Validator
{
    protected function process_insert($tableName, array $tableFields, array $insertValues)
    {
        return parent::process_insert($tableName, $tableFields, $insertValues);
    }

    protected function process_update()
    {
        return parent::process_update();
    }

    protected function process_delete()
    {
        return parent::process_delete();
    }

    protected function process_select()
    {
        return parent::process_select();
    }

    public function strip_input(&$dataFields)
    {
        foreach ($dataFields as $key => $value)
            $dataFields[$key] = strip_tags(html_entity_decode($value));
    }

//    public function lastInsertId($column)
//    {
//
//    }
//
//    public function count()
//    {
//        return $this->rowCount();
//    }
//
//    public function rowCount()
//    {
//        return $this->_statement->rowCount();
//    }
//
//    public function errorInfo()
//    {
//        return $this->_statement->errorInfo();
//    }
//
//    public function errorCode()
//    {
//        return $this->_statement->errorCode();
//    }
//
//    public function columnCount()
//    {
//        return $this->_statement->columnCount();
//    }

    abstract function validate_input();
}