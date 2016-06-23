<?php
// Connect to database
$mysqli1 = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


// Get list of countries
$country_list = "";
$sqlQuery = "SELECT * FROM tbl_country";
$result = $mysqli1->query($sqlQuery);

while($row = $result->fetch_array()){

	$id = $row['id'];
	$name = $row['name'];

	$country_list .= '<option value="'.$id.'">'.$name.'</option>';
}


// Connect to database
$mysqli2 = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Get list of counties
$county_list = "";
$sqlQuery = "SELECT * FROM tbl_county";
$result = $mysqli2->query($sqlQuery);

while($row = $result->fetch_array()){

	$id = $row['id'];
	$name = $row['name'];

	$county_list .= '<option value="'.$id.'">'.$name.'</option>';


}

   // return $county_list;
//}
/*function get_bDay() {

    $day_list = "";

    $day_list .= '<option value="0"> -- </option>';

    for($i = 1; $i <= 31; $i++){
        $day_list .= '<option value="$i" >'.$i.'</option>';
    }

    return $day_list;
}

function get_bYear() {

    $year_list = "";

    $current_year = date("Y");

    $year_list .= '<option value="0" > -- </option>';

    for($i = $current_year - 100; $i <= $current_year - 10; $i++){
        $year_list .= '<option value="$i" >'.$i.'</option>';
    }

    return $year_list;
}*/
