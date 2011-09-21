<?php
session_start();
include_once("header.php");
include_once("config.php");

$uid = $_SESSION['uid'];
$self = $_SERVER['PHP_SELF'];
$err="";

if($_POST['submit']=="Change Password")
{
$op = trim($_POST['op']);
$np = trim($_POST['np']);
$cp = trim($_POST['cp']);

if($op=="") $err = "Enter Old Password";
else if($np=="") $err = "Enter New Password";
else if($cp=="") $err = "Enter Confirm Password";
else if(!ctype_alnum($np)) $err =  "Password must contain numbers & digits only!!";
else if(!(strlen($np)>6)&&(strlen($np)<21)) 
$err = "Password must contain 7-20 characters!!";
else if(!preg_match('/[a-z]/',$np)) 
$err = "Password must contain at least one lower case character";
else if(!preg_match('/[0-9]/',$np))
$err = "Password must contain at least one digit";
else if($np!=$cp) $err = "New and Confirm Passwords Do Not Match";
else
{
$query = "select * from members where uid = $uid && password = sha('$op')";

$result = mysql_query($query);
$row = mysql_fetch_row($result);
if(!$row)
$err = "Wrong Password Entered!!";
else
{
$query = "Update members set password = sha('$np') where uid = $uid && password = sha('$op')";
mysql_query($query);
$err = "Password Reset Done!!";
}
}
}

else if($_POST['cancel']=="Cancel")
{
header('location: home.php');
}

$str = <<< FORM
<br/>
<span class="heading">Reset your Password.</span>
<br/><br/>
<form method="post" action="$self">
<pre>
Old Password:		<input type="password" name="op" value="$op">
New Password:		<input type="password" name="np" value="$np">
Confirm Password:	<input type="password" name="cp" value="$cp">


<input type="submit" name="submit" value="Change Password">  <input type="submit" name="cancel" value="Cancel">
<br/><br/><span style="color:red;font-size: 0.8em" >
** Password must be 7-20 characters or digits.
Must contain atleast 1 lowercase alphabet and 1 digit.</span>


<span style="color:orangered">$err</span>
</pre>
</form>
FORM;

echo $body.$str.$end;
?>
