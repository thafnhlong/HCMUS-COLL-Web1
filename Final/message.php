<?php 
require_once("init.php");
require_once("function.php");

if(!$currentUser)
{
    header('Location: login.php');
    die();
}



include 'header.php'; 

sendMessageToID($currentUser['ID'],9,"hello");

var_dump(loadLastMessage($currentUser['ID']));

var_dump(loadMessageToID($currentUser['ID'],9));
?>
	
<?php 
include 'footer.php'; 