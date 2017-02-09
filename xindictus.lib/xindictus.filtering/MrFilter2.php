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
 */
class MrFilter2
{
    private $settings = 'settings.php';
    private $configurations;
    private $resultArray = array();
    private $dataArray = array();

    public function __construct()
    {
    }

    public function isValidArray(array $dataArray = [], array $validationArray = [])
    {
        $this->resultArray['total'] = -1;

        if (!isset($dataArray) || empty($dataArray))
            return $this->resultArray;

        if (!isset($validationArray) || empty($validationArray))
            return $this->resultArray;

        $this->dataArray = $dataArray;
        $this->resultArray['results'] = array();

        $this->parseSettings();

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

    private function parseSettings()
    {
        $this->configurations = include "{$this->settings}";
    }

    private function translateMethod($alias)
    {
        foreach ($this->configurations as $key => $value)
            if (is_array($value))
                foreach ($value as $innerKey => $innerValue)
                    if ($alias === $innerKey)
                        return $innerValue;

        return -1;
    }

    public function sanitizeEmail($email)
    {
        return (!filter_var($email, FILTER_SANITIZE_EMAIL) === false) ? 0 : -1;
    }

    public function sanitizeFloat($float, array $sanitizationLevel = null)
    {
//        FILTER_FLAG_ALLOW_FRACTION, FILTER_FLAG_ALLOW_THOUSAND, FILTER_FLAG_ALLOW_SCIENTIFIC
    }

    public function sanitizeInteger($integer)
    {
        return (!filter_var($integer, FILTER_SANITIZE_NUMBER_INT) === false) ? 0 : -1;
    }

    public function sanitizeString($string, array $sanitizationLevel = null)
    {
        $flags = '';
//        $sanitizationLevel = ["strip_high"];
        if (is_array($sanitizationLevel)) {
            foreach ($sanitizationLevel as $key => $value)
                switch ($value) {
                    case "empty":
                        $flags .= FILTER_FLAG_EMPTY_STRING_NULL . ', ';
                        break;
                    case "quotes":
                        $flags .= FILTER_FLAG_NO_ENCODE_QUOTES . ', ';
                        break;
                    case "strip_low":
                        $flags .= FILTER_FLAG_STRIP_LOW . ', ';
                        break;
                    case "strip_high":
                        $flags .= FILTER_FLAG_STRIP_HIGH . ', ';
                        break;
                    case "strip_back":
                        $flags .= FILTER_FLAG_STRIP_BACKTICK . ', ';
                        break;
                    case "enc_low":
                        $flags .= FILTER_FLAG_ENCODE_LOW . ', ';
                        break;
                    case "enc_high":
                        $flags .= FILTER_FLAG_ENCODE_HIGH . ', ';
                        break;
                    case "enc_amp":
                        $flags .= FILTER_FLAG_ENCODE_AMP . ', ';
                        break;
                }

            $flags = rtrim($flags, ", ");
        }

        return (!($this->dataArray[array_search($string, $this->dataArray)] =
                filter_var($string, FILTER_SANITIZE_STRING, $flags)) === false) ? 0 : -1;
    }

    public function trimWhitespaces($value)
    {
        return ($this->dataArray[array_search($value, $this->dataArray)] = trim($value)) ? 0 : -1;
    }

    public function sanitizeURL($url)
    {
        return (!filter_var($url, FILTER_SANITIZE_URL) === false) ? 0 : -1;
    }

    public function isValidBoolean($boolean)
    {
        return (filter_var($boolean, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === null) ? -1 : 0;
    }

    public function isValidEmail($email)
    {
        return (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) ? 0 : -1;
    }

    public function isValidInteger($integer)
    {
        return (filter_var($integer, FILTER_VALIDATE_INT) === false) ? -1 : 0;
    }

    public function isValidIP($ip)
    {
        return (!filter_var($ip, FILTER_VALIDATE_IP) === false) ? 0 : -1;
    }

    public function isValidIPv4($ip)
    {
        return (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) ? 0 : -1;
    }

    public function isValidIPv6($ip)
    {
        return (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) ? 0 : -1;
    }

    public function isValidURL($url)
    {
        return (((!filter_var($url, FILTER_VALIDATE_URL) === false) ? 0 : -1) == 0) ? $url : false;
    }

    public function isValidAlphaNumeric($string)
    {
        return (!preg_match('/^[a-zA-Z0-9]+$/', $string) === false) ? 0 : -1;
    }

    public function isValidExactLen($string = null, $len = null)
    {
        return (!$string || !$len) ? -1 : ((strlen($string) === $len) ? 0 : -1);
    }

    public function isValidExactValue($number = null, $value = null)
    {
        if (!$number || !$value)
            return -1;

        $options = array(
            'options' => array(
                'min_range' => $value,
                'max_range' => $value
            )
        );

        return (filter_var($number, FILTER_VALIDATE_INT, $options) === false) ? -1 : 0;
    }

    public function isValidMaxLen($string = null, $max = null)
    {
        return (!$string || !$max) ? -1 : ((strlen($string) >= $max) ? 0 : -1);
    }

    public function isValidMaxValue($integer = null, $max = null)
    {
        if (!$integer || !$max)
            return -1;

        $options = array(
            'options' => array(
                'max_range' => $max
            )
        );

        return (filter_var($integer, FILTER_VALIDATE_INT, $options) === false) ? -1 : 0;
    }

    public function isValidMinLen($string = null, $min = null)
    {
        return (!$string || !$min) ? -1 : ((strlen($string) >= $min) ? 0 : -1);
    }

    public function isValidMinValue($integer = null, $min = null)
    {
        if (!$integer || !$min)
            return -1;

        $options = array(
            'options' => array(
                'min_range' => $min
            )
        );

        return (filter_var($integer, FILTER_VALIDATE_INT, $options) === false) ? -1 : 0;
    }

    public function isValidMinMaxValue($integer = null, $range = null)
    {
        if (!$integer || !$range)
            return -1;

        if (strpos($range, '-') !== false)
            $range = explode('-', $range);
        else
            return -1;

        $min = $range[0];
        $max = $range[1];

        $options = array(
            'options' => array(
                'min_range' => $min,
                'max_range' => $max
            )
        );

        return (filter_var($integer, FILTER_VALIDATE_INT, $options) === false) ? -1 : 0;
    }

    public function isValidMinMaxLen($string = null, $range = null)
    {
        if (!$string || !$range)
            return -1;

        if (strpos($range, '-') !== false)
            $range = explode('-', $range);
        else
            return -1;

        $min = $range[0];
        $max = $range[1];

        return (strlen($string) >= $min && strlen($string) <= $max) ? 0 : -1;
    }

//    public function isRequired(array $data = [], $alias = '', $zero = false)
    public function isRequired($data, $zero = false)
    {
//        return ($zero === false) ?
//            ((isset($data[$alias]) && !empty($data[$alias])) ? 0 : -1) :
//            ((isset($data[$alias])) ? 0 : -1);
        return ($zero === false) ?
            ((isset($data) && !empty($data)) ? 0 : -1) :
            ((isset($data)) ? 0 : -1);
    }
}