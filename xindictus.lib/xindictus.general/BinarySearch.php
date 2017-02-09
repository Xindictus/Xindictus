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
 * File: BinarySearch.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 5/12/2016
 * Time: 14:38
 *
 ******************************************************************************/
namespace Indictus\General;

/**
 * Class BinarySearch
 * @package Indictus\General
 *
 * A simple Binary Search Class for integer and string arrays
 *
 */
class BinarySearch
{
    /**
     * @param $array : the integer/string array
     * @param $key : the value we are searching
     * @return int : return position of element if search successful
     *               else -1 if not found
     */
    public function binarySearch($array, $key)
    {
        /**
         * @var $L : the starting position of the array
         * @var $R : the ending position of the array
         */
        $L = 0;
        $R = count($array) - 1;

        /**
         * Binary search needs a sorted array.
         */
        sort($array);

        $count = 0;

        while ($L <= $R) {

            $count++;
            $mid = (int)(($L + $R) / 2);

            if ($array[$mid] < $key)
                $L = $mid + 1;

            if ($array[$mid] > $key)
                $R = $mid - 1;

            if ($array[$mid] == $key)
                return $count;
        }

        return -1;
    }
}