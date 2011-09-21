<?php
$hostname = "localhost";
$databasename = "MicKzzz-Den";
$username = "root";
$password = "123";

$con = mysql_connect("$hostname","$username","$password")
or die ("Could not connect to MySQL!!!");
mysql_select_db("$databasename",$con)
or die ("Unable to find the Database!!!");
?>
