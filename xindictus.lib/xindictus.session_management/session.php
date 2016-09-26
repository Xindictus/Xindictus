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
 * File: session.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 2/6/2016
 * Time: 07:54
 *
 ******************************************************************************/

require_once __DIR__."/../xindictus.lib/xindictus.config/AutoLoader/AutoLoader.php";
/**
 * Session
 */
class Session {

    /**
     * Db Object
     */
    private $db;

    public function __construct(){
        // Instantiate new Database object
        $db = new Indictus\Database\dbHandlers\DatabaseConnection();
        $this->db = $db->startConnection('BusinessDays');
        ini_set('session.gc_maxlifetime', 10);

        // Set handler to overide SESSION
        session_set_save_handler(
            array($this, "_open"),
            array($this, "_close"),
            array($this, "_read"),
            array($this, "_write"),
            array($this, "_destroy"),
            array($this, "_gc")
        );

        // Start the session

        session_start();
    }

    /**
     * Open
     */
    public function _open(){
        // If successful

        if($this->db){
            // Return True
            return true;
        }
        // Return False
        return false;
    }

    /**
     * Close
     */
    public function _close(){

        // Close the database connection
        // If successful
        $db = new Indictus\Database\dbHandlers\DatabaseConnection();

        if($db->closeConnection($this->db) != -1){
            // Return True
            return true;
        }
        // Return False
        return false;
    }

    /**
     * Read
     */
    public function _read($id){
        // Set query
        $stmt = $this->db->prepare('SELECT data FROM sessions WHERE id = :id');

        // Bind the Id
        $stmt->bindParam(':id', $id);

        // Attempt execution
        // If successful
        if($stmt->execute()){
            // Save returned row
            $row = $stmt->fetch();
            // Return the data
            return $row['data'];
        }else{
            // Return an empty string
            return '';
        }
    }

    /**
     * Write
     */
    public function _write($id, $data){
        // Create time stamp
        $access = time();
        // Set query
        $stmt = $this->db->prepare('REPLACE INTO sessions VALUES (:id, :access, :data)');

        // Bind data
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':access', $access);
        $stmt->bindParam(':data', $data);

        // Attempt Execution
        // If successful
        if($stmt->execute()){
            // Return True
            return true;
        }

        // Return False
        return false;
    }

    /**
     * Destroy
     */
    public function _destroy($id){
        // Set query
        $stmt = $this->db->prepare('DELETE FROM sessions WHERE id = :id');

        // Bind data
        $stmt->bindParam(':id', $id);

        // Attempt execution
        // If successful
        if($stmt->execute()){
            // Return True
            return true;
        }

        // Return False
        return false;
    }

    /**
     * Garbage Collection
     */
    public function _gc($max){
        // Calculate what is to be deemed old
        $old = time() - $max;

        // Set query
        $stmt = $this->db->prepare('DELETE * FROM sessions WHERE access < :old');

        // Bind data
        $stmt->bindParam(':old', $old);

        // Attempt execution
        if($stmt->execute()){
            // Return True
            return true;
        }

        // Return False
        return false;
    }

    public function checkSession()
    {
        $maxLifeTime = ini_get('session.gc_maxlifetime');

        $old = time() - $maxLifeTime;

        echo $old."<br>";

        return $old;

    }
}

$obj = new Session();
//$status = $obj->_open();
//echo "Status = " . $status . "<br>";
//$obj->checkSession();
echo var_dump($_SESSION)."<br>";
//$obj->_destroy($_SESSION);

/**
 * START CRYPT
 */
$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

//echo 'SHA-256: ' . crypt('rasmuslerdorf', '$5$rounds=5000$bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3$') . "\n";
//$hashed_password = crypt($_SESSION, '$5$rounds=5000$'.$key.'$') . "\n";
//$hashed_password = crypt('rasmuslerdorf', '$5$rounds=5000$'.$key.'$') . "\n";

//$hashed_password = trim(preg_replace('/\s\s+/', '', $hashed_password));
echo $hashed_password."<br>";

//if (hash_equals($hashed_password, crypt("rasmuslerdorf", $hashed_password))) {
//    echo "Password verified!";
//}
/**
 * END CRYPT
 */
