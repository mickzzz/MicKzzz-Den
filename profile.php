<link href="resources/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="resources/jquery.min.js"></script>
<script src="resources/jquery-ui.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("#datepicker").datepicker({changeYear: true,changeMonth: true});
    $("#datepicker").datepicker("option","yearRange",'1911:2011');
    $("#datepicker").datepicker();
  });
</script>
<script type="text/javascript">
function imageUpload(image)
{
var regexp = /\.jpg|\.gif|\.jpeg|\.png/i;
var filename = image.value;
if (filename.search(regexp) == -1) {
alert("File should be either jpg or gif or jpeg or png");
image.form.reset();
return false;
}
return true;
}
</script>

<?php
session_start();
include_once("header.php");
include_once("config.php");
$uid = $_SESSION['uid'];
$self = $_SERVER['PHP_SELF'];


if(!isset($uid))
{
header('location: home.php');
}


$err = "";
$query = "Select username,fullname,email,dob,sex,pic from members where uid=".$uid;
$result = mysql_query($query);
$row = mysql_fetch_row($result);
$l = $row[0];
$n = $row[1];
$e = $row[2];
$d = explode("-",$row[3]);
$dob = "$d[1]/$d[2]/$d[0]";
$s = $row[4];
$i = $row[5];

if($_POST['submit']=="Save")
{

	if($_FILES["image"]["name"] != "")
	{
		if($_FILES["image"]["size"] < 20000000)
		{
			$name = $uid.".".end(explode('.', $_FILES["image"]["name"]));
			$i = "images/user/".$name;
			if ($_FILES["images"]["error"]>0)
			{
				$err = $_FILES["images"]["error"];
				$i = "images/default.jpg";
			}

			else
				move_uploaded_file($_FILES["image"]["tmp_name"], "images/user/" . $name);
		}
		else
		{
			$err = "File Size Too Large!!!";
			$i = "images/default.jpg";
		}
	}
	
$l = $_POST['lname'];
$n = $_POST['fname'];
$e = $_POST['email'];
$dob = $_POST['dob'];
$d = explode("/",$dob);
$s = $_POST['sex'];


$query = "Update members set username='$l',fullname='$n',email='$e',dob='$d[2]-$d[0]-$d[1]',sex='$s',pic='$i' where uid=$uid";
mysql_query($query);
$err = "<span style='color: Red'>Profile Updated!!</span>";
}

else if($_POST['cancel']=="Go Back")
{
header("location:home.php");
}

if($s=='m') 
{ $male="checked"; $female=""; }
else 
{ $female="checked"; $male=""; }

$str = <<< FORM
<form name="details" method="post" enctype="multipart/form-data" action="$self">
<div id="left-div">
<pre>

Login Name:		<input type="text" name="lname" value="$l">

Full Name:		<input type="text" name="fname" value="$n">

Date Of Birth:		<input type="text" id="datepicker" name="dob" value="$dob">

Sex:			<input type="radio" name="sex" $male value="m">Male
			<input type="radio" name="sex" $female value="f">Female

E-Mail ID:		<input type="text" name="email" value="$e">


Upload Image:	<input type="file" name="image" id="image" onchange="return imageUpload(this);">


</pre>
</div>
<div id="right-div">
<pre>

<img src="$i" width="150px" height="175px" id="profile-pic"/>


<input type="submit" name="submit" value="Save"/>

<input type="submit" name="cancel" value="Go Back"/>

</pre>
</div>
</form>
FORM;

echo $body.$menu."<br/>";
echo $str.$err.$end;
?>
