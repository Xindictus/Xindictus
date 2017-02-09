<?php
/******************************************************************************
 * Copyright (c) 2017 Konstantinos Vytiniotis, All rights reserved.
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
 * File: Validator.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 2/1/2017
 * Time: 06:17
 *
 ******************************************************************************/

namespace Indictus\Filtering;

/**
 * Class Validator
 * @package Indictus\Filtering
 *
 * A collection of validations and sanitizations using the filter_var method
 *
 */
class Validator
{
    protected $dataArray = array();

    public function sanitizeEmail($email)
    {
        return (!($this->dataArray[array_search($email, $this->dataArray)] =
                filter_var($email, FILTER_SANITIZE_EMAIL)) === false) ? 0 : -1;
    }

//    public function sanitizeFloat($float, array $sanitizationLevel = null)
//    {
//        FILTER_FLAG_ALLOW_FRACTION, FILTER_FLAG_ALLOW_THOUSAND, FILTER_FLAG_ALLOW_SCIENTIFIC
//    }

    public function sanitizeInteger($integer)
    {
        return (!($this->dataArray[array_search($integer, $this->dataArray)] =
                filter_var($integer, FILTER_SANITIZE_NUMBER_INT)) === false) ? 0 : -1;
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

    /**
     * @param null $integer : the integer for validation
     * @param null $max : the maximum value the integer must have
     * @return int : Checks whether the integer is less than or equal
     *               the minimum value provided. Returns 0 on success
     *               and -1 on failure.
     */
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

    /**
     * @param null $string : the string for validation
     * @param null $min : the minimum length of the string
     * @return int : Checks whether the string's length is greater than
     *               or equal than the minimum value provided. Returns 0 on
     *               success and -1 on failure.
     */
    public function isValidMinLen($string = null, $min = null)
    {
        return (!$string || !$min) ? -1 : ((strlen($string) >= $min) ? 0 : -1);
    }

    /**
     * @param null $integer : the integer for validation
     * @param null $min : the minimum value the integer must have
     * @return int : Checks whether the integer is greater than the
     *               minimum value provided. Returns 0 on success
     *               and -1 on failure.
     */
    public function isValidMinValue($integer = null, $min = null)
    {
        if (!$integer || !$min)
            return -1;

        $options = array(
            'options' => array(
                'min_range' => $min
            )
        );

        return (filter_var($integer, FILTER_VALIDATE_INT, $options) === false)
            ? -1 : 0;
    }

    /**
     * @param null $integer : the integer for validation
     * @param null $range : the min-max values
     * @return int : Checks whether the integer is within the appropriate
     *               values, returning 0 on success and -1 on failure.
     */
    public function isValidMinMaxValue($integer = null, $range = null)
    {
        if (!$integer || !$range)
            return -1;

        if (strpos($range, '-') !== false)
            $range = explode('-', $range);
        else
            return -1;

        $options = array(
            'options' => array(
                'min_range' => $range[0],
                'max_range' => $range[1]
            )
        );

        return (filter_var($integer, FILTER_VALIDATE_INT, $options) === false)
            ? -1 : 0;
    }

    /**
     * @param null $string : the string for validation
     * @param null $range : the min-max values of length
     * @return int : Checks whether the string is within the appropriate
     *               length, returning 0 on success and -1 on failure.
     */
    public function isValidMinMaxLen($string = null, $range = null)
    {
        if (!$string || !$range)
            return -1;

        if (strpos($range, '-') !== false)
            $range = explode('-', $range);
        else
            return -1;

        return (strlen($string) >= $range[0] && strlen($string) <= $range[1])
            ? 0 : -1;
    }

    /**
     * @param $data : the value we pass for validation
     * @param bool $zero : if the data is expected to be number 0
     * @return int : Functions checks whether data exists and is not empty.
     *               Returns 0 on success and -1 on failure.
     */
    public function isRequired($data, $zero = false)
    {
        return ($zero === false) ?
            ((isset($data) && !empty($data)) ? 0 : -1) :
            ((isset($data)) ? 0 : -1);
    }

    /**
     * @return array
     */
    public function getDataArray()
    {
        return $this->dataArray;
    }

    /**
     * @param array $dataArray
     */
    public function setDataArray($dataArray)
    {
        $this->dataArray = $dataArray;
    }
}