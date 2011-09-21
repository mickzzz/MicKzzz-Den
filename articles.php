<?php
include_once("config.php");

$head = "";
$content = "";
session_start();

if(!isset($_SESSION['uid']))
{
header("location:login.php");
}

if($_POST['add']=="ADD ARTICLE")
{
$head = trim($_POST['head']);
$content = trim($_POST['content']);
$category = $_POST['category'];
$id = $_SESSION['uid'];

if($head == "") $error= "Enter a Header!!";
else if ($content == "") $error="Enter the Contents!!";
else {

$head = mysql_real_escape_string($head);
$content = mysql_real_escape_string($content);

$query = "Insert Into articles values ('null','$id','$head','$content',NOW(),'$category')"; 
mysql_query($query) or die ("OOOOOPPPPSSSS!!!!!! Article could not be saved");

$error = "Article Saved!!";
$head = "";
$content = "";
}
}
elseif($_POST['cancel']=="CANCEL")
{
header('location: home.php');
}

include_once "header.php";
$self = $_SERVER['PHP_SELF'];
$form = <<< FORM
<span class="heading">ADD AN ARTICLE</span>
<br/>
<form action="$self" method="post" onsubmit="return validate()">
<p>Enter the Article Header:<p>
<input type="text" name="head" size="60" maxlength="100" value="$head">
<p>Enter the Contents:</p>
<textarea name="content" rows="20" cols="60" value="$content"></textarea>
<br/>
<pre>Assign a Category:	<select name="category"><option value="Entertainment">Entertainment</option>
			<option value="News">News</option>
			<option value="Sports">Sports</option>
			<option value="Technology">Technology</option>
			<option value="Miscellaneous" selected>Miscellaneous</option>
			</select></pre>
<input type="submit" name="add" value="ADD ARTICLE"> &nbsp;&nbsp;&nbsp; <input type="submit" name="cancel" value="CANCEL">
</form> 
FORM;



echo $body.$menu."<br/><br/>".$form."<span style='color:red'>".$error."</span>".$end;
?>
