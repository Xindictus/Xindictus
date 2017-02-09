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
 * File: settings.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 21/12/2016
 * Time: 03:32
 *
 ******************************************************************************/

return [
    'resultLevels' => [
        /* RETURN TYPE MATCH */
        'single_digit' => 0,
        'array' => 1,
    ],

    'sanitizationRules' => [
        /* METHOD NAME MATCH */
        'email_san' => 'sanitizeEmail',
        'float_san' => 'sanitizeFloat',
        'int_san' => 'sanitizeInteger',
        'string_san' => 'sanitizeString',
        'trim' => 'trimWhitespaces',
        'url_san' => 'sanitizeURL'
    ],

    'validationRules' => [
        /* INTEGRATE FLAGS */
        /* METHOD NAME MATCH */
        'boolean' => 'isValidBoolean',
        'email' => 'isValidEmail',
        'float' => 'isValidFloat',
        'int' => 'isValidInteger',
        'ip' => 'isValidIP',
        'ipv4' => 'isValidIPv4',
        'ipv6' => 'isValidIPv6',
        'url' => 'isValidURL',
    ],


    'extraRules' => [
        'alpha_numeric' => 'isValidAlphaNumeric',
        //either alpha OR numeric values alpha_num
        // alpha_dash
        'exact_len' => 'isValidExactLen',
        'exact_val' => 'isValidExactValue',
        'max_len' => 'isValidMaxLen',
        'max_val' => 'isValidMaxValue',
        'min_len' => 'isValidMinLen',
        'min_val' => 'isValidMinValue',
        'min_max' => 'isValidMinMaxValue',
        'min_max_len' => 'isValidMinMaxLen',
        'required' => 'isRequired',
    ],


    'validationErrors' => [
        'email_san' => '',
        'float_san' => '',
        'int_san' => '',
        'string_san' => '',
        'trim' => '',
        'url_san' => '',
        'boolean' => '',
        'email' => '',
        'float' => '',
        'int' => '',
        'ip' => '',
        'ipv4' => '',
        'ipv6' => '',
        'url' => '',
        'alpha_numeric' => '',
        'exact_len' => '',
        'exact_val' => '',
        'max_len' => '',
        'max_val' => '',
        'min_len' => '',
        'min_max' => '',
        'min_max_len' => '',
        'required' => '',
    ]
];