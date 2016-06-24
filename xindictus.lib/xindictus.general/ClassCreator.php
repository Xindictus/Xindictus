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
 * File: ClassCreator.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 20/5/2016
 * Time: 21:50
 *
 ******************************************************************************/
namespace Indictus\General;

class ClassCreator
{
    private $newFile;
    private $template;
    private $autoIncrement;

    private $database;
    private $className;
    private $tableName;
    private $tableFields;
    private $properties;
    private $constructorParam;
    private $constructorBody;

    public function __construct($database = null, $tableName = null, array $tableFields = null, $autoIncrement = false)
    {
        $this->database = $database;
        $this->tableName = $tableName;

        $tableName = explode("_", $tableName);
        foreach ($tableName as &$part)
            $part = ucfirst($part);
        $this->className = implode("_", $tableName);

        $this->tableFields = $tableFields;
        $this->newFile = __DIR__ . "/../xindictus.cache/{$this->className}.php";
        $this->template = __DIR__ . "/../xindictus.model/ObjectTemplate.tpl";
        $this->autoIncrement = $autoIncrement;
    }

    public function constructProperties()
    {
        if ($this->tableFields == null)
            return -1;

        $properties = "";
        foreach ($this->tableFields as $field) {
            $properties .= 'private $' . $field . ';' . PHP_EOL . "\t";
        }
        $this->properties = $properties;
        return $this->properties;
    }

    public function constructConstParam()
    {
        if ($this->tableFields == null)
            return -1;

        $constructorParam = array();
        foreach ($this->tableFields as $field) {
            array_push($constructorParam, "$" . $field . " = null");
        }

        if ($this->autoIncrement === true) {
            $temp = array_shift($constructorParam);
            array_push($constructorParam, $temp);
        }
        
        $constructorParam = implode(", ", $constructorParam);

        $this->constructorParam = rtrim(trim($constructorParam), ',');
        return $this->constructorParam;
    }

    public function constructConstBody()
    {
        if ($this->tableFields == null)
            return -1;

        $constructorBody = "";
        foreach ($this->tableFields as $field) {
            $constructorBody .= '$this->' . $field . " = $" .
                $field . ";" . PHP_EOL . "\t\t";
        }
        $this->constructorBody = trim($constructorBody);
        return $this->constructorBody;
    }

    public function constructFile()
    {
        $this->constructProperties();
        $this->constructConstParam();
        $this->constructConstBody();

        if(file_exists($this->newFile))
            ftruncate(fopen($this->newFile, 'w'), 0);

        if (file_exists($this->template)) {
            $template = file_get_contents($this->template);
            $template = str_replace("#CLASSNAME#", $this->className, $template);
            $template = str_replace("#DATABASE#", "\"{$this->database}\"", $template);
            $template = str_replace("#TABLE_NAME#", "\"$this->tableName\"", $template);
            $template = str_replace("#TABLE_FIELDS#", "array('".implode("','", $this->tableFields)."')", $template);
            $template = str_replace("#PROPERTIES#", $this->properties, $template);
            $template = str_replace("#CONSTRUCTOR_PARAMETERS#", $this->constructorParam, $template);
            $template = str_replace("#CONSTRUCTOR_BODY#", $this->constructorBody, $template);

            $handle = fopen($this->newFile, 'w') or die('Cannot open file:  '.$this->newFile);

            fwrite($handle, $template);
            fclose($handle);
        }
    }
}