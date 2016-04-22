<?php
/**
 * Created by PhpStorm.
 * User: Xindictus
 * Date: 19/4/2016
 * Time: 05:56
 */


$my_file = __DIR__ . '/../file.php';

if(file_exists($my_file))
    ftruncate(fopen($my_file, 'w'), 0);

$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
$data = '<?php

namespace Indictus\Database\dbHandlers;

use Indictus\Model as dbModel;

require_once(__DIR__ . "/../../indictus.config/AutoLoader/AutoLoader.php");

abstract class DB_Table extends dbModel\DB_Model
{
    protected function setConnection($connection)
    {
        // TODO: Implement setConnection() method.
    }

    protected function process_insert()
    {
        return 0;
        // TODO: Implement process_insert() method.
    }

    protected function process_update()
    {
        return 0;
        // TODO: Implement process_update() method.
    }

    protected function process_delete()
    {
        return 0;
        // TODO: Implement process_delete() method.
    }

    protected function process_select()
    {
        return 0;
        // TODO: Implement process_select() method.
    }
}
    ';
fwrite($handle, $data);
fclose($handle);

