<?php

if (session_status() == PHP_SESSION_NONE) {
    session_name("GO!PanoramaSESSION");
    session_start();
}

session_unset();
session_destroy();

header('Location: ../../../views/index.php');
exit;
