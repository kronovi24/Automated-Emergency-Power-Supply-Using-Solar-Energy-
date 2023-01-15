<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

		$sql = "SELECT * FROM `credentials` WHERE username='$uname' AND password='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['username'] == $uname && $row['password'] == $pass) {
            	$_SESSION['username'] = $row['username'];
            	$_SESSION['ID'] = $row['ID'];
            	header("Location: index.php");
		        exit();
            }else{
				header("Location:  login.php?error=Incorect User name or password");
		        exit();
			}
		}else{
			header("Location:  login.php?error=Incorect User name or password");
	        exit();
		}

	
}else{
	header("Location:  login.php");
	exit();
}


