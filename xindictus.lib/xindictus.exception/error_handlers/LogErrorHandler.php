<?php
/******************************************************************************
 * Copyright (c) 2015 Konstantinos Vytiniotis, All rights reserved.
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
 * Date: 7/12/2015
 * Time: 07:55
 *
 ******************************************************************************/
namespace Indictus\Exception\ErHandlers;

use Indictus\Config\AutoConfigure as AC;

/**
 * Require Autoloader
 */
require_once __DIR__ . "/../../autoload.php";

/**
 * Class LogErrorHandler
 * @package Indictus\Exception\ErHandlers
 *
 * The class responsible for error reporting. Receives an error and category,
 * creates the .log file and place it on the appropriate folder.
 */
class LogErrorHandler
{
    //TODO: POSSIBLY DIVIDE FOLDERS MORE
    /**
     * @param string $errorString : The string created to be saved in the logs.
     */
    private $errorString;

    /**
     * @param string $log_fileName : The file name and the location it will be saved.
     */
    private $logFileName;

    /**
     * LogErrorHandler constructor.
     * @param $exceptionMessage : The message caught from the exception.
     * @param $codeSource : Depending where the exception came from, it will be relatively categorized.
     */
    function __construct($exceptionMessage, $codeSource)
    {
        $app = new AC\AppConfigure;
        date_default_timezone_set($app->getParam('timezone'));
        $this->errorString = $this->createErrorLog($exceptionMessage);
        $this->logFileName = $this->createLogFileName($codeSource);
    }

    /**
     * @param $mainError : The error caught from an exception.
     * @return string: Returns the final string that will be logged.
     */
    private function createErrorLog($mainError)
    {
        $errStr = 'User: ' . $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL .
            $mainError . PHP_EOL .
            str_repeat('«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»', 2) . PHP_EOL;
        return $errStr;
    }

    /**
     * @param $category : The category is part of the file name, in order to group error messages accordingly.
     * @return string: Returns the file location and filename along with the date the error occurred.
     */
    private function createLogFileName($category)
    {//TODO: CHANGE FOLDER CREATION
        if (!file_exists(__DIR__ . '/error_logs/Queries/' . $category))
            mkdir(__DIR__ . '/error_logs/Queries/' . $category, 0770, true);

        if (strpos($category, 'QUERIES') !== false)
            return __DIR__ . '/error_logs/Queries/' . $category . '/' . $category . '_' . date("Y.m.d") . '.log';
        else
            return __DIR__ . '/error_logs/' . $category . '/' . $category . '_' . date("Y.m.d") . '.log';
    }

    /**
     * Appends error message to the file specified.
     */
    function createLogs()
    {
        file_put_contents($this->logFileName, $this->errorString, FILE_APPEND);
    }
}