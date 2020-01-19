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

use Indictus\General as G;

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
     * @param null $userId
     * @param null $fullName
     */
    public function startSession($userId = null, $fullName = null)
    {
        $lifeTime = 14400;
        $name = 'BusinessDays2019';

        date_default_timezone_set('Europe/Athens');
        /* 4 HOURS */
        ini_set('session.gc_maxlifetime', 14400);
        ini_set('session.cookie_httponly', true);

        session_set_cookie_params(
            14400,
            '/',
            null,
//            '.pan-orama.org',
            false,
//            TRUE,
            true
        );

        session_name($name);

        if (session_start()) {
            setcookie($name, $name . time(), time() + $lifeTime, '/', null, false, true);
//            setcookie($name, $name . time(), time() + $lifeTime, '/', '.pan-orama.org', TRUE, TRUE);
            session_regenerate_id(true);
            $user_key = parent::createNumKey($userId);
            $_SESSION["user_key"] = $user_key;
            $_SESSION["fullName"] = $fullName;
            $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['remote_ip'] = $_SERVER['REMOTE_ADDR'];
        }
//        session_start();


    }

    public function checkSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_name("BusinessDays2019");
            session_start();
        }

        $loginFlag = -1;

        if (
            isset($_SESSION['user_key']) &&
            isset($_SESSION['user_agent']) &&
            isset($_SESSION['remote_ip']) &&
            isset($_SESSION['fullName'])
        ) {
//            if ($_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'] && $_SESSION['remote_ip'] == $_SERVER['REMOTE_ADDR']) {
            $loginFlag = 0;
//                session_regenerate_id(true);
//            }
        }

        return $loginFlag;
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
        if (session_status() == PHP_SESSION_NONE) {
            session_name("BusinessDays2019");
            session_start();
        }
        session_unset();
        session_destroy();
    }
}