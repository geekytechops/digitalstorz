<?php
session_start();
//print_r($_SESSION);
session_destroy();
$_SESSION['session_retail_username'] = '';
$_SESSION['session_retail_password'] = '';
header('Location: ./retail-login.php'); //Sessions Cleared
?>