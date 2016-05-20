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
 * Date: 22/4/2016
 * Time: 10:48
 *
 ******************************************************************************/
namespace Indictus\Database\moreHandlers;

/**
 * Interface tableQuery
 * @package Indictus\Database\moreHandlers
 *
 * This interface provides a set useful methods concerning a database table.
 */
interface tableQuery
{
    /**
     * @param $database
     * @param $table
     * @return mixed
     *
     * Returns the number of table columns.
     */
    public function columnCount($database, $table);

    /**
     * @param $table
     * @return mixed
     *
     * Returns the count of rows of the specified table.
     */
    public function rowCount($table);

    /**
     * @param $column
     * @return mixed
     *
     * Returns the last inserted ID of specified column
     */
    public function lastInsertId($column);
}