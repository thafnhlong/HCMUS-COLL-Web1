<?php
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: index.php');
    exit();
}

if (!empty($_GET['id']) && !empty($_GET['type']))
{
    header('Content-Disposition: attachment;');
    $id = $_GET['id'];
    if ($_GET['type'] == "avatar")
        echo getImageUser($id);
    else if($_GET['type'] == "coverimage")
        echo getCoverImage($id);
    else 
        echo getImagePost($id);
    
}

