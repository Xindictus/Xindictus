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
 * File: PrepareStatementDelete.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 27/6/2016
 * Time: 02:38
 *
 ******************************************************************************/
namespace Indictus\Database\dbHandlers;

/**
 * Class PrepareStatementDelete
 * @package Indictus\Database\dbHandlers
 *
 * This class is used to create the arrays necessary for the prepared statements
 * of PDO for the DELETE query.
 */
class PrepareStatementDelete extends PrepareStatement
{
    /**
     * @var string
     *
     * The where clause that will be used in the DELETE query.
     */
    private $whereClause = "";

    /**
     * @return string
     *
     * Creation of the where clause
     */
    public function getWhereClause()
    {
        if ($this->columnNames != null) {
            for ($i = 0; $i < count($this->columnNames); $i++) {
                if ($this->columnValues[$i] != "") {
                    if ($i != 0)
                        $this->whereClause .= " AND {$this->columnNames[$i]}=:{$this->columnNames[$i]}";
                    else
                        $this->whereClause .= "WHERE {$this->columnNames[$i]}=:{$this->columnNames[$i]}";
                }
            }
        }

        return $this->whereClause;
    }
}