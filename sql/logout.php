<?php 
session_start();
$_SESSION['user_id'] = '';
$_SESSION['name'] = '';
$_SESSION['role'] = '';

header("Location: ../");

?>