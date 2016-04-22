<?php

//if (session_status() == PHP_SESSION_NONE) {
    session_name("GO!PanoramaSESSION");
    session_start();
//}

$login_flag = 0;
if( isset($_SESSION['user_key']) && isset($_SESSION['user_agent']) && isset($_SESSION['remote_ip'])){
    if($_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'] && $_SESSION['remote_ip'] == $_SERVER['REMOTE_ADDR']){
        $login_flag = 1;
        session_regenerate_id(true);
    }
}
//echo $login_flag."<br>";
//echo "SESAG:".$_SESSION['user_agent']."<br>SERVAG:".$_SERVER['HTTP_USER_AGENT']."<br>";
//echo "SESADDR:".$_SESSION['remote_ip']."<br>SERVADDR:".$_SERVER['REMOTE_ADDR']."<br>";

if($login_flag == 0) {
    session_unset();
    session_destroy();
    include_once(__DIR__.'/../../../views/sign_in_messages/signin_failure.php');
    exit;
}