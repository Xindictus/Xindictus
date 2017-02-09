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
 * Time: 06:53
 *
 ******************************************************************************/
namespace Indictus\General;

/**
 * Interface KeyCreator
 * @package Indictus\General
 */
interface KeyCreator
{
    /**
     * @param $user_id
     * @return mixed
     */
    function createNumKey($user_id);

    /**
     * @return mixed
     */
    function createStringKey();

    /**
     * @return mixed
     */
    function createMixedKey();
}