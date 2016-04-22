<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 13/4/2016
 * Time: 06:29
 */
namespace Indictus\Database\CRUD;

interface SimpleCRUD
{
    public function insert($tableName, array $tableFields, array $insertValues);
    public function update();
    public function delete();
    public function select();

}