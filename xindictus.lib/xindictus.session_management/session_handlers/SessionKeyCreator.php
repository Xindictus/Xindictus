<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 18/12/2015
 * Time: 07:22
 */

include_once(__DIR__ . "/../../xindictus.general/KeyCreator.php");
include_once(__DIR__ . "/../../xindictus.general/Cryptor.php");

abstract class SessionKeyCreator extends Cryptor implements KeyCreator{

    protected $prefix = "0123456789";
    protected $suffix = "9876543210";

    function createNumKey($panorama_user_id){
        $prefix = str_shuffle($this->prefix);
        $suffix = str_shuffle($this->suffix);

        $key = "$prefix$panorama_user_id$suffix";

//        $final_key = parent::encryptIt($key);
//        return $final_key;
        return $key;
    }

    function decryptNumKey($key){
//        $decryptedKey = parent::decryptIt($key);
//        $noFix = substr($decryptedKey, strlen($this->prefix), -strlen($this->suffix));
        $noFix = substr($key, strlen($this->prefix), -strlen($this->suffix));
        return $noFix;

    }

    function createStringKey(){}

    function createMixedKey(){}


}