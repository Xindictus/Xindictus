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
 * File: PrepareStatementUpdate.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 17/12/2016
 * Time: 19:00
 *
 ******************************************************************************/

namespace Indictus\Database\dbHandlers;

/**
 * Class PrepareStatementUpdate
 * @package Indictus\Database\dbHandlers
 *
 * This class is used to create the arrays necessary for the prepared statements
 * of PDO for the UPDATE query.
 */
class PrepareStatementUpdate extends PrepareStatement
{
    /**
     * @var string
     *
     * The where clause that will be used in the UPDATE query.
     */
    private $whereClause = "";

    /**
     * @var string
     *
     * The update clause that will be used in the UPDATE query.
     */
    private $updateClause = "";

    /**
     * @var array|null
     *
     * The new values for the UPDATE query.
     */
    private $updateValues;

    /**
     * PrepareStatementUpdate constructor.
     * @param array|null $updateValues
     * @param array|null $updateRow
     */
    public function __construct($updateValues, $updateRow)
    {
        $this->updateValues = $updateValues;
        parent::__construct(array_keys($updateRow), array_values($updateRow));
    }

    /**
     * @return string
     *
     * Creation of the where clause.
     */
    public function getWhereClause()
    {
        if ($this->columnNames != null) {
            for ($i = 0; $i < count($this->columnNames); $i++) {
                if ($this->columnValues[$i] != "") {
                    if ($i != 0)
                        $this->whereClause .= " AND {$this->columnNames[$i]}=:{$this->columnNames[$i]}Where";
                    else
                        $this->whereClause .= "WHERE {$this->columnNames[$i]}=:{$this->columnNames[$i]}Where";
                }
            }
        }

        return $this->whereClause;
    }

    /**
     * @return string
     *
     * Creation of the string with the field's parameters that will be updated.
     */
    public function getUpdateParam()
    {
        /**
         * Unset all properties
         */
        unset($this->columnNames);
        unset($this->columnValues);
        unset($this->preparedNamedParameters);

        /**
         * Assign new values.
         */
        $this->columnNames = array_keys($this->updateValues);
        $this->columnValues = array_values($this->updateValues);
        $this->preparedNamedParameters = array();

        $this->getColumnFields();
        return $this->getPreparedNamedParameters();
    }

    /**
     * @return string
     *
     * Creation of the update clause.
     */
    public function getUpdateClause()
    {
        if ($this->columnNames != null)
            for ($i = 0; $i < count($this->columnNames); $i++)
                if ($this->columnValues[$i] != "")
                    $this->updateClause .= "{$this->columnNames[$i]}=:{$this->columnNames[$i]}, ";

        return rtrim($this->updateClause, ', ');
    }
}