<?php
/**
 * Created by PhpStorm.
 * User: Kotsos
 * Date: 18/12/2015
 * Time: 07:44
 */

interface SessionManager{

    function startSession();
    function setSessionVariables();
    function destroySession();

}