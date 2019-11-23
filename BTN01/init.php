<?php
// Start session
session_start();
// Load core functions
require_once('./vendor/autoload.php');
require_once('config.php');
require_once('function.php');
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

/*echo 'TEST:';
var_dump($_SERVER);*/

/*current user*/
$currentUser = null;

if (isset($_SESSION['userId'])) {
  $currentUser = findUserById($_SESSION['userId']);
}


