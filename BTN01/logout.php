<?php
ob_start();
require_once 'login.php';

unset($_SESSION['userId']);
header('Location: index.php');
