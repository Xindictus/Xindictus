<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 18/12/2015
 * Time: 04:43
 */

include_once(__DIR__."/SessionManager.php");
include_once(__DIR__."/SessionKeyCreator.php");

class SessionManagerLite extends SessionKeyCreator implements SessionManager{

    private $panorama_user_id;

    /**
     * SessionManager constructor.
     * @param $panorama_user_id
     */
    public function __construct($panorama_user_id = NULL){
        $this->panorama_user_id = $panorama_user_id;
    }

    public function startSession(){
        session_name("GO!PanoramaSESSION");
        session_start();
        session_regenerate_id(true);
        $user_key = parent::createNumKey($this->panorama_user_id);
        $_SESSION["user_key"] = $user_key;
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['remote_ip'] = $_SERVER['REMOTE_ADDR'];
    }

    public function setSessionVariables()
    {
        // TODO: Implement setSessionVariables() method.
    }

    public function destroySession(){
        session_unset();
        session_destroy();
    }
}