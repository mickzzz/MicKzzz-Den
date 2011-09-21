<?php
include_once("header.php");
include_once("config.php");

$u="";$p="";$error ="";

if($_POST['signin']=="Sign In")
{
$u=trim($_POST['user']);
$p=trim($_POST['pass']);
if($u=="")
$error="Username not Entered!!";
elseif($p=="")
$error="Password not Entered!!";
else
{
$query = "SELECT * FROM members WHERE username='$u' && password=sha('$p')"; 
$result = mysql_query($query);

$row = mysql_fetch_row($result);
if(!$row)
$error="Wrong Username/Password Combination";
else
{
session_start();
$_SESSION['user'] = "$u";
$_SESSION['uid'] = $row[0];
$_SESSION['login'] = date("Y-m-d H:i:s");
header("Location: home.php");
}
}
}

$login = <<<LOGIN
<div id="login">
<form method="POST" action="login.php" onsubmit="return validate()">
<pre>
<fieldset><legend>LOGIN</legend>
 Username:	<input type="text" maxlength="16" name="user" value="$u">
		
 Password:	<input type="password" maxlength="16" name="pass">

<input type="submit" name="signin" value="Sign In">
<a href = "forgot.php">Forgot Password?</a>
<span style="color:red">$error</span></fieldset>
</pre></form>
</div>
<a href="signup.php" style="position:static"><img src="images/signup.png"/></a>
LOGIN;

echo $body;
echo $login;
echo $end; 
?>
