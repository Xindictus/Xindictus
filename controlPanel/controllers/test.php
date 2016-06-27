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
 * File: test.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 24/6/2016
 * Time: 22:13
 *
 ******************************************************************************/

use Indictus\Database\dbHandlers as dbHandlers;
use Indictus\Config\AutoConfigure as AC;
use Indictus\General as Gn;

/**
 * Require AutoLoader
 */
require_once(__DIR__ . "/../../xindictus.lib/xindictus.config/AutoLoader/AutoLoader.php");


$form_post_success = 0;

if ($_SERVER['REQUEST_METHOD']=='POST') {

    $formDB_error = 0;
    $numDB_error = 0;
    $tableName_error = 0;
    $tableName = array();

    if (isset($_POST['formDB']) && !empty($_POST['formDB'])) {
        $formDB = $_POST['formDB'];
    } else {
        $formDB = null;
        $formDB_error = 1;
    }

    if (isset($_POST['numDB']) && !empty($_POST['numDB'])) {
        $numDB = $_POST['numDB'];
    } else {
        $numDB = null;
        $numDB_error = 1;
    }

    if ($numDB_error != 1) {
        for ($i = 0; $i < $numDB; $i++) {
            if (isset($_POST["tableName_{$i}"]) && !empty($_POST["tableName_{$i}"]))
                array_push($tableName, $_POST["tableName_{$i}"]);
        }
    }

    if (count($tableName) == 0)
        $tableName_error = 1;

    echo $formDB_error.$numDB_error.$tableName_error;
    if ($formDB_error != 1 && $numDB_error != 1 && $tableName_error != 1) {

        $acDB = new AC\DBConfigure();
        $databases = $acDB->getParam('database');
        $key = array_search($formDB, $databases);
        $connection = dbHandlers\DatabaseConnection::startConnection($key);
        $autoIncrement = false;

        if (dbHandlers\DatabaseConnection::isConnected($connection)) {
            foreach ($tableName as $table) {
                $fields = array();

                try {
                    $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :database AND TABLE_NAME = :table";
                    $aiQuery = "SHOW COLUMNS FROM {$table} WHERE extra LIKE '%auto_increment%'";

                    $stmt = $connection->prepare($query);

                    $stmt->execute(array(
                        ':database' => $formDB,
                        ':table' => $table));

                    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                        array_push($fields, $row['COLUMN_NAME']);
                    }

                    $aiResult = $connection->query($aiQuery);
                    if ($aiResult->rowCount() >= 1)
                        $autoIncrement = true;

                    $stmt = null;

                    $cC = new Gn\ClassCreator($formDB, $key, $table, $fields, $autoIncrement);
                    $cC->constructFile();

                } catch (\PDOException $exception) {
                    echo $exception->getMessage();
                    $stmt = null;
                }
            }
        }

        $connection = dbHandlers\DatabaseConnection::closeConnection($connection);
        $form_post_success = 1;
    }

//    $directory = __DIR__ . "/../../xindictus.lib/xindictus.model";
//    $scanned_directory = array_diff(scandir($directory), array('..', '.'));
//
//    var_dump($scanned_directory);
}
