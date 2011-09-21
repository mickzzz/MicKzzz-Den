<?php
include_once("config.php");

$q=$_GET["q"];

$query = "SELECT * FROM members WHERE username = '$q'";

$result = mysql_query($query);

if(mysql_fetch_row($result))
echo "<span style='color:red'>Username Not Available</span>";
else
echo "<span style='color:green'>Username Is Available</span>";

?>
