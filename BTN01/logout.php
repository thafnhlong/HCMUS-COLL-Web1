<?php
ob_start();
require_once 'init.php';

unset($_SESSION['userId']);
header('Location: index.php');
