<?php

//function autoload($class)
//{
//    $parts = explode('\\', $class);
//    require end($parts) . '.php';
//}
require_once(__DIR__ . "/../indictus.lib/indictus.config/AutoLoader/AutoLoader.php");
//$c = new \Indictus\Config\AutoLoader\AutoLoader();

//function __autoload($class_name) {
//    require_once $class_name . '.php';
//}
//include "AL.php";

//$al = new \test\AL();



//spl_autoload_register(function ($class) {
//    include 'classes/' . $class . '.class.php';
//});

//use test;

//$a = new Test();
//$a = new test\Image();
//$c = new Indictus\Config\AutoConfigure\DBConfigure;
//echo "<br>".json_encode($c->getDBInfo(), JSON_PRETTY_PRINT);
$c = new Indictus\Model\Test2;
//$b = new test\Validator2();
echo "<br><br>";

$arr = array("A", "B", "C", "D", "E");
array_shift($arr);
echo "<br><br>";
print_r($arr);

echo "<br><br>";

$column_fields = array('event_id', 'event_name', 'event_year');
$column_values = array(null, 'Πανόραμα', 2016);

$a = new \Indictus\Database\dbHandlers\PrepareStatement($column_fields, $column_values);
//$a->isIncremented();

echo $a->getColumnFields();
echo "<br><br>";
echo $a->getPreparedNamedParameters();
echo "<br><br>";
var_dump($a->getBindings());
echo "<br><br>";

include __DIR__."/../indictus.lib/indictus.database/dbHandlers/CustomPDO.php";
echo "<br><br>";
echo "CONNECTIVITY";
echo "<br><br>";
$connection = new \Indictus\Database\dbHandlers\CustomPDO("BD");
echo $connection->isConnected();
//$a = new \Indictus\Config\AutoConfigure\DBConfigure;
//$b = new \Indictus\Config\AutoConfigure\AppConfigure;

//var_dump($b->getAppInfo());
//echo "<br><br>";
//var_dump($a->getDBInfo());
echo "<br><br>";


$my_file = '../VERSION';
$handle = fopen($my_file, 'r');
$data = fread($handle,filesize($my_file));
fclose($handle);

echo $data;

