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

require_once(__DIR__."/../indictus.config/AutoLoader/AutoLoader.php");

abstract class Entity extends dbH\DB_Table implements crud\SimpleCRUD, val\Validator
{
    public function insert($tableName, array $tableFields, array $insertValues)
    {
        return $this->process_insert($tableName, $tableFields, $insertValues, $this->getConnection());
    }

    public function update()
    {
        return $this->process_update();
    }

    public function delete()
    {
        return $this->process_delete();
    }

    public function select()
    {
        return $this->process_select();
    }

    public function strip_input(&$dataFields)
    {
        foreach ($dataFields as $key => $value)
            $dataFields[$key] = strip_tags(html_entity_decode($value));
    }

    abstract function validate_input();
}