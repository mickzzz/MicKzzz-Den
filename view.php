<script type="text/javascript">
function view(str)
{
if(str=="select")
{
document.getElementById("article").innerHTML="Select a Category First";
return;
}
if(window.XMLHttpRequest)
	xmlhttp = new XMLHttpRequest();
else
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

xmlhttp.onreadystatechange = function()
	{
		if( xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("article").innerHTML = xmlhttp.responseText;
		}
	}
xmlhttp.open("GET","getarticle.php?category="+str,true);
xmlhttp.send();
}
</script>
<?php
session_start();

if(!isset($_SESSION['uid']))
{
header("location:login.php");
}

include_once("header.php");

$option = <<<LIST
<form>
<span style="float:left">
<select name="category" onchange="view(this.value)">
<option value="select" selected>Choose a Category</selected>
<option value="My">My Posts Only</option>
<option value="Entertainment">Entertainment</option>
<option value="News">News</option>
<option value="Sports">Sports</option>
<option value="Technology">Technology</option>
<option value="Miscellaneous">Miscellaneous</option>
<option value="All">All</option>
</select></span>
</form>
<br/>
<div align="left" id="article"></div>
LIST;

echo $body.$menu.$option.$end;
?>
