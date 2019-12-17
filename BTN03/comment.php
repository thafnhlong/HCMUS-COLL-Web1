<?php 
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: login.php');
    die();
}

if (isset($_POST['cmtsend']) && !empty($_POST['content']))
{
    $target = $_POST['postid'];
    $content = $_POST['content'];
    postComment($currentUser['ID'],$target,$content);
}

header('Location: ' . $_SERVER['HTTP_REFERER']); 