<?php
include_once('header.php');
include_once("config.php");

$self=$_SERVER['PHP_SELF'];

$str =<<< FORM
<form action="$self" method="POST" ><br/><br/>
<p>Enter Your Username and your new Password will be mailed to you.</p>
<br/>
<input type="text" name="uname">
<input type="submit" name="submit" value="Get Password">
</form>
FORM;

if($_POST['submit']=="Get Password")
{
$u = $_POST['uname'];

if($u=="") $err="Enter the Username First!!";
else
{
$query = "Select password,email from members where username='$u'";
$result=mysql_query($query);
$row = mysql_fetch_row($result);
if(!$row) $err = "User does not Exist!! <br/> Sure you entered correct Username?";

else
{
$newpass = substr($row[0],0,10);

$query ="Update members set password = sha('$newpass') where username='$u'";
mysql_query($query);

$to = $row[1];
$sub="New Password";
$msg="These are your new credentials for signing in: \n\n\n Username: $u \n Password: $newpass\n\n\nLogin here: http://localhost/blog/login.php";
$from="admin@MicKzzz-Den.com";
$headers="From:".$from;

mail($to,$sub,$msg,$headers);

$err = "<br/><br/>Your New Password has been mailed to you!!<br/>Kindly login using new password and reset your password!!<br/>P.S. - You may need to check your spam folder.<br/><br/><a href='login.php'>GO BACK</a>";
$str="";
}

}
}

echo $body.$str."<br/><span style='color:red'>".$err."</span>".$end;
?>
