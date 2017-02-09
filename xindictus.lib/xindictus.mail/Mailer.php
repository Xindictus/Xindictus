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
 * File: Mailer.php
 * User: Konstantinos Vytiniotis
 * Email: konst.vyti@hotmail.com
 * Date: 18/12/2016
 * Time: 13:22
 *
 ******************************************************************************/
namespace Indictus\Mail;

use Indictus\Config\AutoConfigure as AC;
use Indictus\Exception\ErHandlers as Errno;

/**
 * Require part of the PHPMailer lib
 */
require_once 'PHPMailerAutoload.php';
require_once 'class.phpmailer.php';
require_once 'class.smtp.php';

/**
 * Require AutoLoader
 */
require_once __DIR__ . '/../autoload.php';

/**
 * Class Mailer
 * @package Indictus\Mail
 *
 * A class responsible for sending mail implemented as a layer of abstraction
 * of PHPMailer.
 *
 * Currently has been configured to be with specific methods and thus not using
 * the full capabilities of PHPMailer.
 */
class Mailer
{
    /**
     * @var \PHPMailer
     *
     * The Object necessary for the mailing. (PHPMailer)
     */
    private $mailer;

    /**
     * Mailer constructor.
     *
     * Reads some basic settings from main library configuration file.
     */
    public function __construct()
    {
        /**
         * Load timezone.
         */
        $appConf = new AC\AppConfigure();
        date_default_timezone_set($appConf->getParam('timezone'));

        /**
         * Read mail configuration settings.
         */
        $mailConf = new AC\MailConfigure();

        /**
         * Create a new mail object.
         */
        $this->mailer = new \PHPMailer();

        /**
         * Set up email configuration.
         */
        $this->mailer->isSMTP();
        $this->mailer->SMTPDebug = $mailConf->getParam('SMTPDebug');
        $this->mailer->Debugoutput = $mailConf->getParam('Debugoutput');
        $this->mailer->SMTPAuth = $mailConf->getParam('SMTPAuth');
        $this->mailer->Host = $mailConf->getParam('Host');
        $this->mailer->Username = $mailConf->getParam('Username');
        $this->mailer->Password = $mailConf->getParam('Password');

        $this->mailer->From = $mailConf->getParam('Username');
        $this->mailer->FromName = $mailConf->getParam('FromName');
    }

    /**
     * @param string $emailAddress
     * @param string $recipientFullName
     * @return $this
     *
     * Adds a recipient with optionally his full name.
     */
    public function addRecipient($emailAddress = '', $recipientFullName = '')
    {
        $this->mailer->addAddress($emailAddress, $recipientFullName);

        return $this;
    }

    /**
     * @param string $subject
     * @return $this
     *
     * Adds a subject for the mail.
     */
    public function addSubject($subject = '')
    {
        $this->mailer->Subject = $subject;

        return $this;
    }

    /**
     * @param string $body
     * @return $this
     *
     * Adds the body of the message to the mail.
     */
    public function addBody($body = '')
    {
        $this->mailer->Body = $body;

        return $this;
    }

    /**
     * @param bool $flag
     * @return $this
     *
     * Sets whether the body of the message will be formatted in HTML.
     */
    public function setHTML($flag = false)
    {
        $this->mailer->isHTML($flag);

        return $this;
    }

    /**
     * @return int: Returns 0 on success, -1 on failure.
     *
     * Sends the message. On error, it creates the necessary logs.
     */
    public function mailSend()
    {
        if (!$this->mailer->send()) {

            $errorString = 'Error sending mail :: ' . $this->mailer->ErrorInfo;
            $category = "MAIL";

            $errorHandler = new Errno\LogErrorHandler($errorString, $category);
            $errorHandler->createLogs();

            return -1;
        }

        return 0;
    }
}