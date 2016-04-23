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
 * File: index.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 13/4/2016
 * Time: 06:55
 *
 ******************************************************************************/
namespace Indictus\Database\dbHandlers;

use Indictus\Model as dbModel;
use Indictus\Database\dbHandlers as dbHandlers;
use Indictus\Exception\ErHandlers as Errno;

require_once(__DIR__ . "/../../xindictus.config/AutoLoader/AutoLoader.php");

/**
 * Class DB_Table
 * @package Indictus\Database\dbHandlers
 */
class DB_Table extends dbModel\DB_Model
{
    /**
     * @param CustomPDO $connection
     */
    public function setConnection(dbHandlers\CustomPDO $connection)
    {
        self::$connection = $connection;
    }

    /**
     * @return \Indictus\Database\dbHandlers\CustomPDO
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    /**
     * @param $table
     * @param array $columnNames
     * @param array $columnValues
     * @return int
     */
    protected function process_insert($table, array $columnNames, array $columnValues)
    {
        /**
         * Create the appropriate strings and arrays that will be used for the query.
         */
        $prepareQuery = new dbHandlers\PrepareStatement($columnNames, $columnValues);

        /**
         * Get needed column fields in a string separated by commas.
         */
        $table_fields = $prepareQuery->getColumnFields();

        /**
         * Get the needed named parameters in a string separated by commas.
         */
        $namedParam = $prepareQuery->getPreparedNamedParameters();

        /**
         * Get the associative array with named parameters as the array's keys and
         * the values that will be inserted as the array's values.
         */
        $bindings = $prepareQuery->getBindings();

        /**
         * Initialize query string and stmt.
         */
        $insert_query = "";
        $insert_stmt = null;

        try {
            /**
             * Dynamically creating the query.
             */
            $insert_query = "INSERT INTO {$table}({$table_fields}) VALUES({$namedParam})";

            /**
             * Prepared Statement and execution.
             */
            $insert_stmt = $this->getConnection()->prepare($insert_query);
            $insert_stmt->execute($bindings);

            /**
             * Further check if insertion happened.
             */
//            $affected_rows = $insert_stmt->rowCount();
            if($insert_stmt->rowCount() == 0)
                throw new \PDOException("AFFECTED ROWS = 0");

            /**
             * Close stmt
             */
            $insert_stmt = null;

        } catch(\PDOException $insert_exception){
            $error_string = 'Insert Fail :: '.$insert_query.PHP_EOL.
                'Table Fields given :: ('. $table_fields . ')' . PHP_EOL .
                'Named parameters :: ('. $namedParam . ')' . PHP_EOL.
                'Values given :: ('. implode(",", $bindings) . ')' . PHP_EOL.
                'Database Message :: '.$insert_exception->getMessage();
            $category = "INSERT_QUERIES";

            $err_handler = new Errno\LogErrorHandler($error_string, $category);
            $err_handler->createLogs();

            $errorCode = $insert_stmt->errorCode();
            $errorInfo = $insert_stmt->errorInfo();
            $insert_stmt = null;
            return $errorInfo;
        }
        return 0;
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