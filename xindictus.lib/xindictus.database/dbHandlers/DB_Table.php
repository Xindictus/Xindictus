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

use Indictus\Config\AutoConfigure as AC;
use Indictus\Database\moreHandlers as mH;
use Indictus\Exception\ErHandlers as Errno;
use Indictus\Model as dbModel;

/**
 * Require AutoLoader
 */
require_once(__DIR__ . "/../../xindictus.config/AutoLoader/AutoLoader.php");

/**
 * Class DB_Table
 * @package Indictus\Database\dbHandlers
 *
 * This class implements the methods for inserting/updating/deleting/selecting
 * rows for a specified table.
 */
abstract class DB_Table extends dbModel\DB_Model implements mH\tableQuery
{
    /**
     * @param CustomPDO $connection: A PDO connection to a database.
     *
     * This method sets the connection to the database for the specified object.
     */
    public function setConnection(CustomPDO $connection)
    {
        self::$connection = $connection;
    }

    /**
     * @return \Indictus\Database\dbHandlers\CustomPDO
     *
     * This method returns the current connection.
     */
    public static function getConnection()
    {
        return self::$connection;
    }

    /**
     * @param $table: The table where new row will be inserted.
     * @param array $columnNames: The column names of the table.
     * @param array $columnValues: The values of each column.
     * @return int: The return type.
     *
     * This method processes the insert of a row in a table.
     * Returns 0 if insertion was successful or 1 if insertion failed.
     */
    protected function process_insert($table, array $columnNames, array $columnValues)
    {
        /**
         * Creates the appropriate strings and arrays that will be used for the query.
         */
        $prepareQuery = new PrepareStatement($columnNames, $columnValues);

        /**
         * Get needed column fields in a string separated by commas.
         */
        $tableFields = $prepareQuery->getColumnFields();

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
        $insertQuery = "";
        $insertStmt = null;

        try {
            /**
             * Dynamically creating the query.
             */
            $insertQuery = "INSERT INTO {$table}({$tableFields}) VALUES({$namedParam})";

            /**
             * Prepared Statement and execution.
             */
            $insertStmt = $this->getConnection()->prepare($insertQuery);
            $insertStmt->execute($bindings);

            /**
             * Further check if insertion happened by checking
             * the number of affected rows.
             */
            if ($insertStmt->rowCount() == 0)
                throw new \PDOException("AFFECTED ROWS = 0");

            /**
             * Close stmt
             */
            $insertStmt = null;

        } catch(\PDOException $insertException) {
            $errorString = 'Insert Fail :: '.$insertQuery.PHP_EOL.
                'Table Fields given :: ('. $tableFields . ')' . PHP_EOL .
                'Named parameters :: ('. $namedParam . ')' . PHP_EOL.
                'Values given :: ('. implode(",", $bindings) . ')' . PHP_EOL.
                'Database Message :: '.$insertException->getMessage();
            $category = "INSERT_QUERIES";

            $errorHandler = new Errno\LogErrorHandler($errorString, $category);
            $errorHandler->createLogs();

            /**
             * Set the errorCode and errorInfo of the last failed query.
             */
            self::$errorCode = $insertStmt->errorCode();
            self::$errorInfo = $insertStmt->errorInfo();

            /**
             * Close stmt
             */
            $insertStmt = null;
            return -1;
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

    /**
     * @param $database: Database alias.
     * @param $table: Table name.
     * @return int: Number of table columns.
     */
    public function columnCount($database, $table)
    {
        //TODO: POSSIBLE GET ACCESS RETURN TO VERIFY IF EXISTS
        $dbAC = new AC\DBConfigure;
        $database = $dbAC->getAccess($database);
        //TODO: PREPARED STATEMENT, ERROR HANDLING
        $query = $this->getConnection()->query("
            SELECT COUNT(*) as columnCount 
            FROM information_schema.columns 
            WHERE TABLE_SCHEMA = '{$database['database']}'
            AND TABLE_NAME = '{$table}'")->fetch();
        return $query['columnCount'];
    }

    /**
     * @param $table: Table name.
     * @return int: Number of rows in table.
     */
    public function rowCount($table)
    {
        //TODO: PREPARED STATEMENT, ERROR HANDLING
        $query = $this->getConnection()->query("
            SELECT COUNT(*) as rowCount
            FROM {$table}")->fetch();
        return $query['rowCount'];
    }

    /**
     * @param $column: Column name.
     * @return int: Last inserted ID.
     */
    public function lastInsertId($column)
    {
        //TODO: PREPARED STATEMENT, ERROR HANDLING
        $queryParts = explode(".", $column);
        $query = $this->getConnection()->query("
            SELECT {$queryParts[1]} as lastID
            FROM  {$queryParts[0]}
            ORDER BY {$queryParts[1]} DESC
            LIMIT 1")->fetch();
        return $query['lastID'];
    }

    /**
     * @param int $errorCode
     *
     * This method sets the errorCode of last failed query.
     */
    public static function setErrorCode($errorCode)
    {
        self::$errorCode = $errorCode;
    }

    /**
     * @return int
     *
     * This method returns the errorCode of the last failed query.
     */
    public static function getErrorCode()
    {
        return self::$errorCode;
    }

    /**
     * @param string $errorInfo
     *
     * This method sets the errorInfo of the last failed query.
     */
    public static function setErrorInfo($errorInfo)
    {
        self::$errorInfo = $errorInfo;
    }

    /**
     * @return string
     *
     * This method returns the errorInfo of the last failed query.
     */
    public static function getErrorInfo()
    {
        return self::$errorInfo;
    }
}