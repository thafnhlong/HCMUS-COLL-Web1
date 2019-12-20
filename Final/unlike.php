<?php 
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: login.php');
    die();
}

if (!empty($_GET['postid']))
{
    $target = $_GET['postid'];
    unlikePost($currentUser['ID'],$target);
}

header('Location: ' . $_SERVER['HTTP_REFERER']); 