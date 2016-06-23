<?php
$db_connect = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
// Check the connection
if(mysqli_connect_errno()){
	echo mysqli_connect_error();
	//echo "Succesfull database connection !!!";	
	exit();
}else{
	//echo "Connection to database failed !!!";	
}
?>