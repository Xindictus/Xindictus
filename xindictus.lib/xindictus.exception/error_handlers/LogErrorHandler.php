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

include_once(__DIR__ . "/../../xindictus.config/AutoLoader/AutoLoader.php");

class LogErrorHandler{

    /**
     * @param $errorString: The string created to be saved in the logs.
     * @param $log_fileName: The file name and the location it will be saved.
     */
    private $errorString;
    private $log_fileName;

    /**
     * @param $exception_message: The message caught from the exception.
     * @param $code_source: Depending where the exception came from, it will be relatively categorized.
     */
    function __construct($exception_message, $code_source){
        $app = new AC\AppConfigure;
        date_default_timezone_set($app->getParam('timezone'));
        $this->errorString = $this->createErrorLog($exception_message);
        $this->log_fileName = $this->createLogFileName($code_source);
    }

    /**
     * @param $main_error: The error caught from an exception.
     * @return string: Returns the final string that will be logged.
     */
    private function createErrorLog($main_error){
        $err_str = 'User: '. $_SERVER['REMOTE_ADDR'] . ' - ' . date("F j, Y, g:i a") . PHP_EOL.
            $main_error.PHP_EOL.
            str_repeat ('---------------------------------------', 2).PHP_EOL;
        return $err_str;
    }

    /**
     * @param $category: The category is part of the file name, in order to group error messages accordingly.
     * @return string: Returns the file location and filename along with the date the error occurred.
     */
    private function createLogFileName($category){
        if(strpos($category, 'QUERIES') !== false){
            return __DIR__ . '/error_logs/Queries/'.$category.'/'.$category.'_'.date("Y.n.j").'.log';
        } else{
            return __DIR__ . '/error_logs/'.$category.'/'.$category.'_'.date("Y.n.j").'.log';
        }
    }

    /**
     * Appends error message to the file specified.
     */
    function createLogs(){
        file_put_contents($this->log_fileName, $this->errorString, FILE_APPEND);
    }
}