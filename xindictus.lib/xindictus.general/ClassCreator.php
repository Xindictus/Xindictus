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

use Indictus\Config\AutoConfigure as AC;

require_once(__DIR__ . "/../xindictus.config/AutoLoader/AutoLoader.php");
// TODO: CHANGE CONSTRUCTOR
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
    private $setters;
    private $getters;

    public function __construct($database = null, $alias = "ALIAS", $tableName = null, array $tableFields = null, $autoIncrement = false)
    {
        $this->database = $database;
        $this->tableName = $tableName;

        $tableName = explode("_", $tableName);
        foreach ($tableName as &$part)
            $part = ucfirst($part);
        $this->className = implode("_", $tableName);
        unset($part);

        $this->tableFields = $tableFields;

        $app = new AC\AppConfigure();
        $debug = $app->getGlobalParam('debug');

        $directory = "";

        if ($debug === "enabled")
            $directory = __DIR__ . "/../xindictus.cache/{$alias}";

        if ($debug === "setup")
            $directory = __DIR__ . "/../xindictus.Classes/{$alias}";

        if (!file_exists($directory))
            mkdir($directory, 0777, true);

        $this->newFile = $directory . "/{$this->className}.php";
        $this->template = __DIR__ . "/../xindictus.model/ObjectTemplate.tpl";
        $this->autoIncrement = $autoIncrement;
    }

    private function constructProperties()
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

    private function constructConstParam()
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

    private function constructConstBody()
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

    private function constructSetters()
    {
        if ($this->tableFields == null)
            return -1;

        $setters = "";

        foreach ($this->tableFields as $field) {

            $setterName = explode('_', $field);
            foreach ($setterName as &$part) {
                $part = ucfirst($part);
            }
            $setterName = implode("", $setterName);
            unset($part);

            $function = "public function set{$setterName}($" . "{$field})" .
                PHP_EOL . "\t{" . PHP_EOL . "\t\t" .
                '$this->' . "{$field} = $" . "{$field};" . PHP_EOL .
                "\t\t" . 'return $this;' . PHP_EOL . "\t}";

            $setters .= $function . PHP_EOL . PHP_EOL . "\t";
        }
        $this->setters = $setters;
        return $this->setters;
    }

    private function constructGetters()
    {
        if ($this->tableFields == null)
            return -1;

        $getters = "";

        foreach ($this->tableFields as $field) {

            $getterName = explode('_', $field);
            foreach ($getterName as &$part) {
                $part = ucfirst($part);
            }
            $getterName = implode("", $getterName);
            unset($part);

            $function = "public function get{$getterName}()" .
                PHP_EOL . "\t{" . PHP_EOL . "\t\t" .
                'return $this->' . "{$field};" . PHP_EOL . "\t}";

            $getters .= $function . PHP_EOL . PHP_EOL . "\t";
        }
        $this->getters = $getters;
        return $this->getters;
    }

    public function constructFile()
    {
        $this->constructProperties();
        $this->constructConstParam();
        $this->constructConstBody();
        $this->constructSetters();
        $this->constructGetters();

        $app = new AC\AppConfigure();
        date_default_timezone_set($app->getParam('timezone'));

        if(file_exists($this->newFile))
            ftruncate(fopen($this->newFile, 'w'), 0);

        if (file_exists($this->template)) {
            $template = file_get_contents($this->template);
            $template = str_replace("#CLASSNAME#", $this->className, $template);
            $template = str_replace("#DATE#", date("j/n/Y"), $template);
            $template = str_replace("#TIME#", date("H:i"), $template);
            $template = str_replace("#DATABASE#", "\"{$this->database}\"", $template);
            $template = str_replace("#TABLE_NAME#", "\"$this->tableName\"", $template);
            $template = str_replace("#TABLE_FIELDS#", "array('".implode("','", $this->tableFields)."')", $template);
            $template = str_replace("#PROPERTIES#", $this->properties, $template);
            $template = str_replace("#CONSTRUCTOR_PARAMETERS#", $this->constructorParam, $template);
            $template = str_replace("#CONSTRUCTOR_BODY#", $this->constructorBody, $template);
            $template = str_replace("#SETTERS#", $this->setters, $template);
            $template = str_replace("#GETTERS#", $this->getters, $template);

            $handle = fopen($this->newFile, 'w') or die('Cannot open file:  '.$this->newFile);

            fwrite($handle, $template);
            fclose($handle);
        }
    }
}