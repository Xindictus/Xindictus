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
 * File: CacheBlocker.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 5/12/2016
 * Time: 15:50
 *
 ******************************************************************************/
namespace Indictus\General;

/**
 * Class CacheBlocker
 * @package Indictus\General
 *
 * Use this class to insert security headers at the page load, as well as when
 * answering async requests.
 */
class CacheBlocker
{
    /**
     * A set of headers to stop browsers from caching the page.
     */
    public static function cacheBlock()
    {
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0"); // Proxies.
    }

    /**
     * A set of security headers, important to avoid a number of attacks.
     *
     * https://www.owasp.org/index.php/OWASP_Secure_Headers_Project#tab=Headers
     */
    public static function headers()
    {
        /* OWASP HEADERS */
        /**
         * protect websites against protocol downgrade attacks and cookie hijacking
         * https://www.owasp.org/index.php/List_of_useful_HTTP_headers#HTTP_Strict_Transport_Security_.28HSTS.29
         */
        header("Strict-Transport-Security: max-age=31536000 ; includeSubDomains");

        /**
         * protection of web applications against Clickjacking
         * https://www.owasp.org/index.php/List_of_useful_HTTP_headers#X-Frame-Options
         */
        header("X-Frame-Options: SAMEORIGIN");

        /**
         * enables the Cross-site scripting (XSS) filter in your browser
         * https://www.owasp.org/index.php/List_of_useful_HTTP_headers#X-XSS-Protection
         */
        header("X-XSS-Protection: 1; mode=block");

        /**
         * prevents the browser from interpreting files as something else than declared by the content type
         * https://www.owasp.org/index.php/List_of_useful_HTTP_headers#X-Content-Type-Options
         */
        header("X-Content-Type-Options: nosniff");

        /**
         * CSP prevents a wide range of attacks, including Cross-site scripting and other cross-site injections.
         * https://www.owasp.org/index.php/List_of_useful_HTTP_headers#Content-Security-Policy
         */
        // header("Content-Security-Policy: script-src 'self'");

        /**
         * No policy files are allowed anywhere on the target server, including this master policy file.
         * https://www.owasp.org/index.php/List_of_useful_HTTP_headers#X-Permitted-Cross-Domain-Policies
         */
        header("X-Permitted-Cross-Domain-Policies: none");
    }
}