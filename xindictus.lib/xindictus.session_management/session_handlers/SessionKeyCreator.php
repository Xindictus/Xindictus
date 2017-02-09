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
 * Date: 18/12/2015
 * Time: 07:22
 *
 ******************************************************************************/
namespace Indictus\Session\SHandlers;

use Indictus\General as G;

/**
 * Require Autoloader.
 */
require_once __DIR__ . '/../../autoload.php';

abstract class SessionKeyCreator extends G\Cryptor implements G\KeyCreator
{
    protected $prefix = "0123456789";
    protected $suffix = "9876543210";

    /**
     * @param $user_id
     * @return string
     *
     * Takes a numeric string key and decrypts it.
     */
    public function createNumKey($user_id)
    {
        $prefix = str_shuffle($this->prefix);
        $suffix = str_shuffle($this->suffix);

        $key = "{$prefix}{$user_id}{$suffix}";

        //$final_key = parent::encryptIt($key);
        //return $final_key;
        return $key;
    }

    /**
     * @param $key
     * @return string
     *
     * Takes a numeric string key and decrypts it.
     */
    public function decryptNumKey($key)
    {
        //$decryptedKey = parent::decryptIt($key);
        //$noFix = substr($decryptedKey, strlen($this->prefix), -strlen($this->suffix));
        $noFix = substr($key, strlen($this->prefix), -strlen($this->suffix));

        return $noFix;
    }

    /**
     *
     */
    public function createStringKey()
    {
    }

    /**
     *
     */
    public function createMixedKey()
    {
    }
}