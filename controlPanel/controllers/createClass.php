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
 * File: createClass.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 28/6/2016
 * Time: 16:59
 *
 ******************************************************************************/
use Indictus\Config\AutoConfigure as AC;
use Indictus\Database\dbHandlers as dbHandlers;
use Indictus\General as Gn;

/**
 * Require AutoLoader
 */
require_once(__DIR__ . "/../../xindictus.lib/xindictus.config/AutoLoader/AutoLoader.php");
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->

        <meta name="description" content="The control panel of Xindictus PHP framework listing the basic configuration done by the user with some alerts about connectivity to database and other services.">
        <meta name="author" content="Konstantinos Vytiniotis">

        <link rel="icon" href="../../../favicon.ico">
        <title>Xindictus CP - ClassCreation</title>

        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="../bootstrap/css/classCreation.css" type="text/css">

    </head>
    <body>

    <div class="container">
        <div class="row">

            <div class="text-center">
                <h3 class="titleFont">
                    Creating Classes from chosen database's tables
                </h3>
            </div>

            <hr>

            <div class="progress">
                <div id="progressDiv" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 0">
                    <span id="progressText">0%</span>
                </div>
            </div>

            <textarea id="consoleUpdate" rows="5" readonly></textarea>

            <div class="clearfix"></div>

            <hr>

            <div class="text-center">
                <button class="btn btn-success" onclick="returnCP();">
                    Return to Control Panel
                </button>
            </div>
        </div>
    </div>

    </body>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../bootstrap/js/classCreation.js"></script>

    </html>

<?php
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

    if ($formDB_error != 1 && $numDB_error != 1 && $tableName_error != 1) {

        $acDB = new AC\DBConfigure();
        $databases = $acDB->getParam('database');
        $key = array_search($formDB, $databases);
        $connection = dbHandlers\DatabaseConnection::startConnection($key);
        $autoIncrement = false;
        $update = 100 / $numDB;

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
                    //TODO: FINISH TEMPLATING
                    $cC = new Gn\ClassCreator($formDB, $key, $table, $fields, $autoIncrement);
                    $cC->constructFile();

                } catch (\PDOException $exception) {
                    echo $exception->getMessage();
                    $stmt = null;
                }

                echo "<script>updateProgress('" . $update . "', '" . $table . "');</script>";
            }
        }

        $connection = dbHandlers\DatabaseConnection::closeConnection($connection);
    }
} else {
    header("Location: ../");
    exit();
}