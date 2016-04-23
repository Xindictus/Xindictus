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
 * Date: 21/4/2016
 * Time: 20:30
 *
 ******************************************************************************/
namespace Indictus\Database\dbHandlers;

use Indictus\Config\AutoConfigure as AC;
use Indictus\Exception\ErHandlers as Errno;

include_once(__DIR__ . "/../../xindictus.config/AutoLoader/AutoLoader.php");

/**
 * Class CustomPDO
 * @package Indictus\Database\dbHandlers
 *
 * This class expands the constructor of PDO with further options
 * included in config.php.
 */
class CustomPDO extends \PDO
{
    /**
     * @var int $isConnected: 1 for connected, 0 for not connected
     */
    private $isConnected = 0;

    /**
     * Overriding PDO constructor
     * @param $dbAssociate(REQUIRED). It is used to define which database to use.
     */
    function __construct($dbAssociate){

        /**
         * Initialize $category with UNMATCHED,
         * for exceptions that are unable to handle.
         */
        $category = "UNMATCHED";

        /**
         * Parse the database configurations.
         */
        $config = new AC\DBConfigure;

        /**
         * Set PHP timezone.
         */
        $timezone = $config->getParam('timezone');
        date_default_timezone_set($timezone);

        /**
         * Check if $dbAssociate is set.
         * Check for database existence via an associated white list array. (CURRENTLY REMOVED)
         *
         * Throw an exception relevant to each code instance.
         */
        try {
            if(isset($dbAssociate) && !empty($dbAssociate)){

                /**
                 * Gets the connection parameters and flags.
                 */
                $configArray = $config->getAccess($dbAssociate);
                $flags = $config->getFlags();

                /**
                 * Create a new database and
                 * set the attributes of errors and
                 * emulated prepared statements.
                 */
                parent::__construct("{$configArray['driver']}:host={$configArray['host']};
                port={$configArray['port']};dbname={$configArray['database']};",
                    $configArray['username'],$configArray['password'], $flags);

                /**
                 * Set charset.
                 */
                $this->exec("SET CHARACTER SET utf8");

                /**
                 * Set SQL timezone.
                 */
                $this->exec("SET time_zone = '{$timezone}'");

                /**
                 * Update $isConnected value.
                 */
                $this->isConnected = 1;
            } else{
                $error_string = 'PDO CONSTRUCTOR ERROR'.PHP_EOL.
                    'Database Association given :: "'.$dbAssociate.'"';
                $category = "FalseDatabaseParameters";
                throw new \Exception($error_string);
            }
        } catch (\Exception $customPDOException) {

            /**
             * @param $error_string: Finalizing it.
             * Initialization and call of log error handler.
             */
            if(!isset($error_string) && empty($error_string)){
                $error_string = 'UNABLE TO CONNECT TO DATABASE'.PHP_EOL.
                    $customPDOException->getMessage();
                $category = "DatabaseConnection";
            }

            $err_handler = new Errno\LogErrorHandler($error_string, $category);
            $err_handler->createLogs();
        }
    }

    /**
     * @return int: Returns the status of the connection
     */
    public function isConnected()
    {
        return $this->isConnected;
    }
}