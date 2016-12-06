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
 * File: getDatabaseInfo.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 24/6/2016
 * Time: 13:20
 *
 ******************************************************************************/

use Indictus\Database\dbHandlers;
use Indictus\Config\AutoConfigure as AC;

require_once(__DIR__ . "/../../xindictus.lib/xindictus.config/AutoLoader/AutoLoader.php");

if ($_SERVER['REQUEST_METHOD']=='GET') {

    $data = array();

    $config = new AC\DBConfigure;

    foreach ($config->getParam('database') as $key => $value){

        $connection = dbHandlers\DatabaseConnection::startConnection($key);

        if ($connection->isConnected($connection) != -1) {

            $tableNamesQuery = "SELECT table_name FROM information_schema.tables WHERE table_schema='{$value}'";

            $tableStmt = $connection->prepare($tableNamesQuery);
            $tableStmt->execute();

            $result = $tableStmt->fetchAll(PDO::FETCH_COLUMN);

            $data[$value] = $result;
            dbHandlers\DatabaseConnection::closeConnection($connection);
        };
    }

    echo json_encode($data);
}