<?php
include_once "header.php";
include_once("config.php");
session_start();

$user = $_SESSION['user'];
$uid = $_SESSION['uid'];
$comment="";

if(!isset($uid))
{
header("location:login.php");
}

$query = "Select aid,comment,sec_to_time(now()-date) from comments where aid in (select aid from articles where uid=$uid) && (date > (Select lastlogin from members where uid=$uid)) order by aid desc, date desc";
$result = mysql_query($query);
while($row = mysql_fetch_array($result))
{
$t = explode(":",$row[2]);

if($t[0]>24) $ago = (int)$t[0]/'24'." hours";
else if($t[0]>0) $ago = $t[0]." hours";
else if($t[1]>0) $ago = $t[1]." minutes";
else $ago = $t[2]." seconds";

$comment .= "\"$row[1]\" - <i>$ago ago</i> <a href='comments.php?aid=$row[0]' target='_blank'>View</a><br/>";
}

if($comment=="") $comment = "<br/><p>There are no recent comments!!</p>";

mysql_query($query);

$str = <<< FORM
<div style="text-align:left">
<br/>
<p>Hi,<span style="color:orangered"> $user</style></p>
<p align="center" style="font-size: 1.4em">Welcome Back!!!<p><br/>

<p>Choose among the following options:</p><br/>
<div style="width:40%;float:left">
<ul style="list-style-type:square;color: orangered">
<li><a href="profile.php">View / Edit Profile.</a></li><br/>
<li><a href="articles.php">Add an Article</a></li><br/>
<li><a href="view.php">View all Articles</a></li><br/>
<li><a href="reset.php">Reset your Password</a></li><br/>
<li><a href="logout.php">Log Out</a></li><br/>
</ul>
</div>
<div id="commentbox">
<p><u>Recent Comments on your Posts:</u></p>
$comment
</div>
</div>
FORM;

echo $body.$str.$end;


?>
