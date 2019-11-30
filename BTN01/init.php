<?php
/*DEBUG*/
$DEBUGGER = 1;
if ($DEBUGGER)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/*DetectPage*/
$CurrentPage = basename($_SERVER['PHP_SELF'],".php");

/*GMT+7*/
date_default_timezone_set('Asia/Ho_Chi_Minh');

/*current user*/
$currentUser = null;
session_start();
require_once 'function.php';
if (isset($_SESSION['userId'])) {
  $currentUser = findUserById($_SESSION['userId']);
}


