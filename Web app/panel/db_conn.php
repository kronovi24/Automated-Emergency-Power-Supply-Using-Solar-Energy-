<?php  

$sname = "fdb32.awardspace.net";
$uname = "4134541_monitoring";
$password = "#iSl6Knw7XhUY3},";

$db_name = "4134541_monitoring";

$conn  = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}