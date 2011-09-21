<?php
include_once("config.php");
session_start();
$login = $_SESSION['login'];
$user = $_SESSION['user'];
$query = "Update members set lastlogin='$login' where username='$user'";
mysql_query($query);
mysql_close($con);
header('location:login.php');
session_destroy();
?>
