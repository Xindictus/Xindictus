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

/**
 * Require AutoLoader
 */
require_once __DIR__ . "/../autoload.php";

// TODO: CHANGE CONSTRUCTOR
/**
 * Class ClassCreator
 * @package Indictus\General
 *
 * The Class responsible for creating all the classes - objects from the
 * specified database.
 */
class ClassCreator
{
    /**
     * @var string
     */
    private $newFile;

    /**
     * @var string
     */
    private $template;

    /**
     * @var bool
     */
    private $autoIncrement;

    /**
     * @var null
     */
    private $database;

    /**
     * @var string
     */
    private $className;

    /**
     * @var null
     */
    private $tableName;

    /**
     * @var array|null
     */
    private $tableFields;

    /**
     * @var string
     */
    private $namespace;
    /**
     * @var string
     */
    private $autoloadPath;

    /**
     * ClassCreator constructor.
     * @param null $database
     * @param string $alias
     * @param null $tableName
     * @param array|null $tableFields
     * @param bool $autoIncrement
     */
    public function __construct($database = null, $alias = "ALIAS", $tableName = null, array $tableFields = null, $autoIncrement = false)
    {
        //TODO: CHANGE DATABASE TO ALIAS
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
        $modelFLD = $app->getGlobalParam('models');

        $directory = "";

        if ($debug === "enabled") {
            $directory = __DIR__ . "/../xindictus.cache/{$alias}";
            $this->namespace = 'Indictus\Cache\\' . $alias;
        }

        if ($debug === "setup") {
            $directory = $modelFLD . "/{$alias}";
            $this->namespace = 'Project\Models\Bds';
            $this->autoloadPath = '/../../xindictus/xindictus.lib/autoload.php';
        }

        if (!file_exists($directory))
            mkdir($directory, 0777, true);

        $this->newFile = $directory . "/{$this->className}.php";
        $this->template = __DIR__ . "/../xindictus.model/ObjectTemplate.tpl";
        $this->autoIncrement = $autoIncrement;
    }

    /**
     * Constructs the Class file using a template file.
     */
    public function constructFile()
    {
        $app = new AC\AppConfigure();
        date_default_timezone_set($app->getParam('timezone'));

        if (file_exists($this->newFile))
            ftruncate(fopen($this->newFile, 'w'), 0);

        /**
         * Replace parts of the template with the corresponding pieces of the new class object.
         */
        if (file_exists($this->template)) {
            $template = file_get_contents($this->template);
            $template = str_replace("#NAMESPACE#", $this->namespace, $template);
            $template = str_replace("#AUTOLOAD_PATH#", $this->autoloadPath, $template);
            $template = str_replace("#CLASSNAME#", $this->className, $template);
            $template = str_replace("#DATE#", date("j/n/Y"), $template);
            $template = str_replace("#TIME#", date("H:i"), $template);
            $template = str_replace("#DATABASE#", "\"{$this->database}\"", $template);
            $template = str_replace("#TABLE_NAME#", "\"$this->tableName\"", $template);
            $template = str_replace("#TABLE_FIELDS#", "array('" . implode("','", $this->tableFields) . "')", $template);
            $template = str_replace("#PROPERTIES#", $this->constructProperties(), $template);
            $template = str_replace("#CONSTRUCTOR_PARAMETERS#", $this->constructConstParam(), $template);
            $template = str_replace("#CONSTRUCTOR_BODY#", $this->constructConstBody(), $template);
            $template = str_replace("#SETTERS#", $this->constructSetters(), $template);
            $template = str_replace("#GETTERS#", $this->constructGetters(), $template);

            /**
             * Start writing file to disk.
             */
            $handle = fopen($this->newFile, 'w') or die('Cannot open file:  ' . $this->newFile);

            fwrite($handle, $template);
            fclose($handle);
        }
    }

    /**
     * @return int|string
     *
     * Constructs the properties of the new class. Returns -1 on error.
     */
    private function constructProperties()
    {
        if ($this->tableFields == null)
            return -1;

        $properties = "";

        foreach ($this->tableFields as $field)
            $properties .= 'private $' . $field . ';' . PHP_EOL . "\t";

        return $properties;
    }

    /**
     * @return int|string
     *
     * Constructs the parameters of the constructor of our new class. Returns -1 on error.
     */
    private function constructConstParam()
    {
        if ($this->tableFields == null)
            return -1;

        $constructorParam = array();

        foreach ($this->tableFields as $field) {
            array_push($constructorParam, "$" . $field . " = null");
        }

        if ($this->autoIncrement === true)
            array_push($constructorParam, array_shift($constructorParam));

        $constructorParam = implode(", ", $constructorParam);

        return rtrim(trim($constructorParam), ',');
    }

    /**
     * @return int|string
     *
     * Constructs the main body of the constructor of our new class. Returns -1 on error.
     */
    private function constructConstBody()
    {
        if ($this->tableFields == null)
            return -1;

        $constructorBody = "";

        foreach ($this->tableFields as $field) {
            $constructorBody .= '$this->' . $field . " = $" .
                $field . ";" . PHP_EOL . "\t\t";
        }

        return trim($constructorBody);
    }

    /**
     * @return int|string
     *
     * Constructs the setter methods of our new class.
     */
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

        return $setters;
    }

    /**
     * @return int|string
     *
     * Constructs the getter methods of our new class.
     */
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

        return $getters;
    }
}