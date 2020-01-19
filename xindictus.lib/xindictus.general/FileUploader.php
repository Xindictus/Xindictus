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
 * File: FileUploader.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 9/11/2017
 * Time: 22:07
 *
 ******************************************************************************/

namespace Indictus\General;

/**
 * Require Autoloader
 */
require_once __DIR__ . "/../autoload.php";

class FileUploader
{
    const NO_EXEC_MODE = 0644;

    private $maxSize;
    private $inputName;
    private $targetDir;

    private $fileName;
    private $tmpFileName;
    private $fileSize;
    private $extension;

    /**
     * FileUploader constructor.
     */
    public function __construct()
    {
        $this->targetDir = '';
        $this->maxSize = 5;
    }

    public function checkFileIntegrity()
    {
        $this->fileName = basename($_FILES[$this->inputName]['name']);

        $fileType = $_FILES[$this->inputName]['type'];

        $this->extension = substr($this->fileName,
            strrpos($this->fileName, '.') + 1);

        $this->fileSize = $_FILES[$this->inputName]['size'];

        /**
         * Check MIME TYPE of file through its temp name
         */
        if (isset($_FILES[$this->inputName]['tmp_name'])) {

            $this->tmpFileName = $_FILES[$this->inputName]['tmp_name'];

            $fInfo = finfo_open(FILEINFO_MIME_TYPE);

            $mimeType = finfo_file($fInfo, $this->tmpFileName);

            finfo_close($fInfo);
        } else {
            return -1;
        }

        // CHECK ACTUAL MIME TYPE
        if ($fileType !== $mimeType || $mimeType !== 'application/pdf') {
            return -1;
        }

        // CHECK FOR POSSIBLE PHP EXTENSIONS
        if (strpos($this->fileName, 'php') !== false) {
            return -1;
        }

        // CHECK THE FILE EXTENSION
        if ($this->extension !== 'pdf') {
            return -1;
        }

        // CHECK FILE SIZE IN MB
        if ($this->bytesToMB($this->fileSize) > $this->maxSize) {
            return -1;
        }

        return 0;
    }

    public function upload()
    {
        $newName = round(microtime(true)) . mt_rand() . '.' . $this->extension;

        $fullPath = $this->targetDir . $newName;

        // IF NOT EXISTS -> CREATE FOLDER
        if (!is_dir($this->targetDir)) {
            mkdir($this->targetDir);
        }

        move_uploaded_file($this->tmpFileName, $fullPath);

        if (file_exists($fullPath)) {
            $this->setPermissions($fullPath);
        } else {
            return [];
        }

        return [
            'originalName' => $this->fileName,
            'newName' => $newName,
            'size' => $this->fileSize
        ];
    }

    private function setPermissions($fileName)
    {
        chmod($fileName, $this::NO_EXEC_MODE);
    }

    private function bytesToMB($bytes)
    {
        return $bytes / 1024 / 1024;
    }

    /**
     * @param mixed $inputName
     */
    public function setInputName($inputName)
    {
        $this->inputName = $inputName;
    }

    /**
     * @param string $targetDir
     */
    public function setTargetDir(string $targetDir)
    {
        $this->targetDir = $targetDir;
    }
}