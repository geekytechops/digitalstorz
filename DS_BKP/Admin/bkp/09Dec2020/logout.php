<?php

session_start();
//print_r($_SESSION);
session_destroy();
$_SESSION['session_username'] = '';
$_SESSION['session_password'] = '';
header('Location: ./index.php'); //Sessions Cleared
?>