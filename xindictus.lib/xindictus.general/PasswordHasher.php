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
 * File: PasswordHasher.php
 * Created by: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 20/2/2017
 * Time: 09:18
 *
 ******************************************************************************/
namespace Indictus\General;

class PasswordHasher
{
    public static function passHashing($password)
    {
        if (phpversion() >= '5.5.0') {
            $options = [
                'cost' => 10,
            ];
            return password_hash($password, PASSWORD_BCRYPT, $options);
        }

        return FALSE;
    }

    public static function passVerify($password, $hash)
    {
        if (phpversion() >= '5.5.0') {
            return password_verify($password, $hash) ? 0 : -1;
        }

        return -1;
    }
}