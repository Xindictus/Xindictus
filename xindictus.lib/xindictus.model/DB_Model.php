<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 13/4/2016
 * Time: 06:17
 */
namespace Indictus\Model;

use Indictus\Database\dbHandlers as dbHandlers;

abstract class DB_Model
{
    protected static $connection;

    abstract public function setConnection(dbHandlers\CustomPDO $connection);

    abstract protected function process_insert($table, array $columnNames, array $columnValues);
    abstract protected function process_update();
    abstract protected function process_delete();
    abstract protected function process_select();
}