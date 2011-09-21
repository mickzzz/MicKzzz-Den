<script type=text/javascript>
function showUser(str)
{
if (str=="")
  {
  document.getElementById("avail").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest();
  }
else
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("avail").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getuser.php?q="+str,true);
xmlhttp.send();
}
</script>

<?php
include_once "header.php";
include_once("config.php");

$u="";$p="";$c="";$e="";$err="";

if($_POST['signup']=="SIGNUP")
{
$u = trim($_POST['uname']);
$p = trim($_POST['upass']);
$c = trim($_POST['ucon']);
$e = trim($_POST['umail']);

if($u=="") $err = "Enter Username!!";
else if($p=="") $err = "Enter Password!!";
else if($c=="") $err = "Confirm Your Password!!";
else if($c!=$p) $err = "Passwords do not Match!!";
else if($e=="") $err = "Enter Email-Id!!";
else if(!ctype_alnum($p)) 
$err =  "Password must contain numbers & digits only!!";
else if(!(strlen($p)>6)&&(strlen($p)<21))
$err = "Password must contain 7-20 characters!!";
else if(!preg_match('/[a-z]/',$p)) 
$err = "Password must contain at least one lower case character";
else if(!preg_match('/[0-9]/',$p))
$err = "Password must contain at least one digit";
else if(!filter_var($e,FILTER_VALIDATE_EMAIL))
$err = "Invalid E-Mail Address!!";
else if($_POST['rules']!= "1") $err = "Having any problem with our rules??";
else 
{
$query = "Insert Into members (username,password,email) values ('$u',sha('$p'),'$e')"; 
mysql_query($query) or die ("OOOOOPPPPSSSS!!!!!! Error creating new User");
session_start();
$_SESSION['user'] = $u;
header('Location: home.php');
}
}
elseif($_POST['cancel']=="CANCEL")
{
header('Location: login.php');
}


$self = $_SERVER['PHP_SELF'];
$reg_form = <<<REG_FORM
<div style="border: 2px dashed orange;width:380px"><pre>

<h2><b>SIGN UP FORM</b></h2>
<form method="post" onsubmit="return validate()" action="$self">
User Name:	<input type="text" name="uname" value="$u" onchange="showUser(this.value)">
		<span id="avail"></span>

Password: 	<input type="password" name="upass" value="$p"><span style="font-size: 0.8em;color:red">
		**Must be 7-20 characters long atleast
		one lower case letter and one digit</span>

Confirm:	<input type="password" name="ucon" value="$c">
		
E-Mail:		<input type="text" name="umail" value="$e">
		
<input type="checkbox" name="rules" value="1"> I have read and agree to the rules 
and regulations of MicKzzz-Den.


<input type="submit" name="signup" value="SIGNUP">	<input type="submit" name="cancel" value="CANCEL">
</form>
</pre>
REG_FORM;

echo $body;
echo $reg_form;
echo "<span style='color:red'>".$err."</span></div>";
echo $end;
?>
