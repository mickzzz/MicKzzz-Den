<script type="text/javascript">
function add_comment(article)
{
var comment = document.getElementById("comment").value;
comment = comment.replace(/^\s+|\s+$/g,"");
if (comment=="")
	alert("Enter a comment first!!!");
else {
	if(window.XMLHttpRequest)
		xmlhttp = new XMLHttpRequest();
	else
		xmlhttp = new ActiveObject("Microsoft.XMLHTTP");
	
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("latest").innerHTML += xmlhttp.responseText;
			document.getElementById("comment").value = "";
		}
	}
	xmlhttp.open("GET","add_comment.php?aid=" + article + "&comment=" + encodeURIComponent(comment),true);
	xmlhttp.send();
}
}
</script>



<?php
session_start();
include_once("header.php");
include_once("config.php");

if(!isset($_SESSION['uid']))
{
header("location:login.php");
}

$uid = $_SESSION['uid'];
$str = "";
$aid = $_GET['aid'];
#$self = $_SERVER['PHP_SELF']."?aid=".$aid;
$err = "";

$article = "select (select username from members where articles.uid = members.uid), head, body, DATE_FORMAT(date,'%M %e, %Y') AS date, DATE_FORMAT(date,'%r') AS time from articles where aid=$aid"; 
$article = mysql_query($article);

$row = mysql_fetch_row($article);
$str .= "<br/><span style='color:yellow'>Article Title: </span>".$row[1]."<br/>";
$str .= "<span style='color:yellow'>Posted By: </span>".$row[0]."<br/>";
$str .= "<span style='color:yellow'>Posted On: </span>".$row[3]."<span style='color:yellow'> at </span>".$row[4]."<br/>";
$str .= "<pre id='preset'>".$row[2]."</pre><br><hr/>";
$str .= "<div><span style='color:orangered;font-size:1.2em'>Comments for this Post:</span><br/>";

$comment = "select (select username from members where comments.uid = members.uid) as user, comment, DATE_FORMAT(date,'%M %e, %Y') AS date, DATE_FORMAT(date,'%r') AS time from comments where aid= $aid";
$comment = mysql_query($comment);
while($row = mysql_fetch_array($comment))
{
$str .= "<div><pre id='preset'>".$row[1]."</pre>";
$str .= "<span style='color:yellow;font-size:0.8em'>Posted By: </span>".$row[0]."  ";
$str .= "<span style='color:yellow;font-size:0.8em'>Posted On: </span>".$row[2]."<span style='color:yellow;font-size:0.8em'> at </span>".$row[3]."<br/></div>\n";
}

$new = <<<FORM
<div id="latest"></div><br/>
<span style='color:orangered'>Add a Comment:</span><br/>
<form>
<textarea rows='10' cols='50' id='comment'>
</textarea>
<br/>
<input type="button" value="ADD COMMENT" onclick="add_comment($aid)">
</form>
<br/>
FORM;

$str .= "</div>";


echo $body.$menu."<br/>";
echo "<span style='color:red'>".$err."</span>";
echo "<div id='comments' align='left'>".$str."\n".$new."<br/>"."</div>";
echo $end;

?>
