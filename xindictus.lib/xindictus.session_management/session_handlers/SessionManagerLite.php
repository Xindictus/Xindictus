<?php
/******************************************************************************
 * Copyright (c) 2015 Konstantinos Vytiniotis, All rights reserved.
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
 * File: index.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 18/12/2015
 * Time: 04:43
 *
 ******************************************************************************/
namespace Indictus\Session\SHandlers;

/**
 * Require Autoloader.
 */
require_once __DIR__ . '/../../autoload.php';

/**
 * Class SessionManagerLite
 * @package Indictus\Session\SHandlers
 */
class SessionManagerLite extends SessionKeyCreator implements SessionManager
{
    /**
     * @var null
     */
    private $panorama_user_id;

    /**
     * SessionManager constructor.
     * @param $panorama_user_id
     */
    public function __construct($panorama_user_id = NULL)
    {
        $this->panorama_user_id = $panorama_user_id;
    }

    /**
     *
     */
    public function startSession()
    {
        //$timeout
        ini_set('session.gc_maxlifetime', 1440);
        session_name("GO!PanoramaSESSION");
        session_start();
        session_regenerate_id(true);
        $user_key = parent::createNumKey($this->panorama_user_id);
        $_SESSION["user_key"] = $user_key;
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['remote_ip'] = $_SERVER['REMOTE_ADDR'];
    }

    /**
     *
     */
    public function setSessionVariables()
    {
        // TODO: Implement setSessionVariables() method.
    }

    /**
     *
     */
    public function destroySession()
    {
        session_unset();
        session_destroy();
    }
}