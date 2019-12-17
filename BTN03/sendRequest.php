<?php 
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: login.php');
    die();
}

if ((!empty($_GET['id'])) && (!empty($_GET['tt'])) )
{
    $target = $_GET['id'];
    if ($target != $currentUser['ID'])
    {
        sendRequest($currentUser['ID'],$target);
    }
    if($_GET['tt']==1)
    {
        $toUser=findUserById($target);
        sendEmailAddFr($toUser['Name'],$toUser['Email'],$currentUser['Name'],$currentUser['ID']);
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']); 