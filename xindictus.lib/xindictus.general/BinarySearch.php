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


class BinarySearch
{
    /**
     * BinarySearch constructor.
     */
    public function __construct()
    {
    }

    public function binarySearch(array $a, $key, $sort = false)
    {
        $mid = 0;
        $L = 0;
        $R = sizeof($a) - 1;

        if ($sort)
            sort($a);

        var_dump($a);
        echo "<br><br>";

        $count = 0;
        while ($L <= $R) {
            $count++;
            $mid = (int)(($L+$R) / 2);
            echo $mid."<br>";
            if ($a[$mid] < $key)
                $L = $mid + 1;

            if ($a[$mid] > $key)
                $R = $mid - 1;

            if ($a[$mid] == $key)
                return $count;
        }

        return -1;
    }
}


$a = new BinarySearch();
$arr = [9, 4, 8, 3, 7, 2, 6, 1, 5];
echo $a->binarySearch($arr, 9, false);
echo "<br><br>";
var_dump($arr);
