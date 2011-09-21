<?php

session_start();
include_once("config.php");

if(!isset($_SESSION['uid']))
{
header("location:login.php");
}

$uid = $_SESSION['uid'];
$user = $_SESSION['user'];
$comment = $_GET['comment'];
$comment = rawurldecode($comment);
$aid = $_GET['aid'];
$time = mktime();
$str= "";

$query = "INSERT INTO comments VALUES ('NULL','$aid','$uid','$comment', '".date("Y-m-d H:i:s",$time)."')";

$result = mysql_query($query);

$str .= "<pre id='preset'>".$comment."</pre>";
$str .= "<span style='color:yellow;font-size:0.8em'>Posted By: </span>".$user."  ";
$str .= "<span style='color:yellow;font-size:0.8em'>Posted On: </span>".date('F j, Y',$time)."<span style='color:yellow;font-size:0.8em'> at </span>".date('h:i:s A',$time)."<br/>";

echo $str;
?>
