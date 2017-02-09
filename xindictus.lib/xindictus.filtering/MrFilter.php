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
 * File: MrFilter.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 18/12/2016
 * Time: 12:36
 *
 ******************************************************************************/
namespace Indictus\Filtering;

/**
 * Require AutoLoader
 */
require_once __DIR__ . '/../autoload.php';

/**
 * Class MrFilter
 * @package Indictus\Filtering
 *
 * Extends Validator to implement an abstraction layer of filtering
 *
 */
class MrFilter extends Validator
{
    /**
     * @var string $settings : The file responsible for the validations' settings
     */
    private $settings = 'settings.php';

    /**
     * @var array|mixed $configuration : It will hold the settings return by the settings file
     */
    private $configurations = array();

    /**
     * @var array : The array will hold all the results along with successes and fails
     */
    private $resultArray = array();

    /**
     * MrFilter constructor.
     */
    public function __construct()
    {
        /**
         * Loads the settings for the validations
         */
        $this->configurations = include "{$this->settings}";
    }

    /**
     * @param array $dataArray : The array of values we are going to validate
     * @param array $validationArray : The validations to run on the data array
     * @return array : Returns the results of the validations ($this->resultArray)
     */
    public function isValidArray(array $dataArray = [], array $validationArray = [])
    {
        $this->resultArray['total'] = -1;

        if (!isset($dataArray) || empty($dataArray))
            return $this->resultArray;

        if (!isset($validationArray) || empty($validationArray))
            return $this->resultArray;

        $this->dataArray = $dataArray;
        $this->resultArray['results'] = array();

        $totalResult = 0;

        foreach ($validationArray as $key => $value) {

            $totalResultPerData = 0;

            $validations = explode('|', $value);

            foreach ($validations as $method) {

                $result = -1;
                $method = trim($method);

                if (strpos($method, ',') !== false) {

                    $methodParts = explode(',', $method);
                    $method = trim($methodParts[0]);
                    $param = trim($methodParts[1]);

                    if (array_key_exists($key, $this->dataArray))
                        if (method_exists($this, $this->translateMethod($method)))
                            $result = $this->{$this->translateMethod($method)}($this->dataArray[$key], $param);
                        else
                            $method = "undefined";
                } else {

                    if (array_key_exists($key, $this->dataArray))
                        if (method_exists($this, $this->translateMethod($method)))
                            $result = $this->{$this->translateMethod($method)}($this->dataArray[$key]);
                        else
                            $method = "undefined";

                }

                $totalResultPerData = ($result !== 0) ? $result : $totalResultPerData;

                $this->resultArray['results'][$key][$method] = $result;
            }

            $this->resultArray['results'][$key]['total'] = $totalResultPerData;

            $totalResult = ($totalResultPerData !== 0) ? $totalResultPerData : $totalResult;

        }

        $this->resultArray['total'] = $totalResult;

        $this->resultArray['data'] = $this->dataArray;

        return $this->resultArray;

    }

    /**
     * @param $alias : The alias given to the method
     * @return int|mixed : Returns -1 on failure, otherwise the method name
     */
    private function translateMethod($alias)
    {
        foreach ($this->configurations as $key => $value)
            if (is_array($value))
                foreach ($value as $innerKey => $innerValue)
                    if ($alias === $innerKey)
                        return $innerValue;

        return -1;
    }
}