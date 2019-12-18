<?php 
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: login.php');
    die();
}

if (!empty($_POST['postid']) && isset($_POST['privacy']))
{
    $target = $_POST['postid'];
    $privacy = $_POST['privacy'];
    updatePrivacy($target,$privacy,$currentUser['ID']);
}

header('Location: ' . $_SERVER['HTTP_REFERER']); 