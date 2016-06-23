<?php
/*** CONFIG DATABASE ***/
require("db_config.php");

if(isset($_POST["selectedCountry"])){

    $selectedCountry = $_POST["selectedCountry"];

    $mysqli = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    $sqlQuery = "SELECT * FROM tbl_country WHERE id='$selectedCountry'";

    $result = $mysqli->query($sqlQuery);

    while($row = $result->fetch_array()){

        $id = $row['id'];        

    }
	
	if( $id == 80 ) {
		
		echo true;
		
	} else {
	
		echo false;
		
	}
}


