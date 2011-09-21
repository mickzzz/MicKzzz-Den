<?php
session_start();
include_once("config.php");

$uid = $_SESSION['uid'];
$str = "";
$category = $_GET['category'];

if(!isset($_SESSION['uid']))
{
header("location:login.php");
}

if($category == "All")
{
$count = "Select COUNT(*) from articles";
$query = "select aid, (select username from members where articles.uid = members.uid) as user, head, body, DATE_FORMAT(date,'%M %e, %Y'), DATE_FORMAT(date,'%r') AS time from articles order by date desc"; 
}
else if($category == "My")
{
$count = "Select Count(*) from articles where uid='$uid'";
$query = "select aid, (select username from members where articles.uid = members.uid) as user, head, body, DATE_FORMAT(date,'%M %e, %Y'), DATE_FORMAT(date,'%r') AS time from articles where uid='".$uid."' order by date desc"; 
}
else
{
$count = "Select COUNT(*) from articles where category ='".$category."'";
$query = "select aid, (select username from members where articles.uid = members.uid) as user, head, body, DATE_FORMAT(date,'%M %e, %Y'), DATE_FORMAT(date,'%r') AS time from articles where category = '".$category."' order by date desc"; 
}
$count = mysql_query($count);
$result = mysql_query($query);

if($count == 0)
{
$str = "<div align='center'>There are no articles to show</div>";
}

while($row = mysql_fetch_array($result))
{
$str .= "<br/><span style='color:yellow'>Article Title: </span>".$row[2]."<br/>";
$str .= "<span style='color:yellow'>Posted By: </span>".$row[1]."<br/>";
$str .= "<span style='color:yellow'>Posted On: </span>".$row[4]."<span style='color:yellow'> at </span>".$row[5]."<br/>";
$str .= "<a href='comments.php?aid=$row[0]' style='float:right'>Show More</a>"."<br/>"."<hr/>";
}

echo $str;
?>
