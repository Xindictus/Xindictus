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
 * File: tableQuery.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 13/4/2016
 * Time: 06:29
 *
 ******************************************************************************/
namespace Indictus\Database\CRUD;

/**
 * Interface SimpleCRUD
 * @package Indictus\Database\CRUD
 *
 * Used to enforce CRUD methods, with simple names, and different from
 * the ones used by the framework.
 *
 */
interface SimpleCRUD
{
    /**
     * @return mixed
     *
     * Implements the insert method to a class
     */
    public function insert();

    /**
     * @return mixed
     *
     * Implements the update method to a class
     */
    public function update();

    /**
     * @return mixed
     *
     * Implements the delete method to a class
     */
    public function delete();

    /**
     * @return mixed
     *
     * Implements the select method to a class
     */
    public function select();
}