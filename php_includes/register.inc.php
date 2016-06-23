<?php
function getCountry() {

    $mysqli = new mysqli("localhost", "root","", "eloyals");

    $country_list = "";

    $sqlQuery = "SELECT * FROM tbl_country";

    $result = $mysqli->query($sqlQuery);

    while($row = $result->fetch_array()){

        $id = $row['id'];
        $name = $row['name'];

        if ( $id == 80 ){
            $country_list .= '<option value="$id" selected>'.$name.'</option>';
        } else {
            $country_list .= '<option value="$id">'.$name.'</option>';
        }

    }

    return $country_list;
}

function getCounty() {

    $mysqli = new mysqli("localhost", "root","", "eloyals");

    $county_list = "";

    $sqlQuery = "SELECT * FROM tbl_county";

    $result = $mysqli->query($sqlQuery);

    while($row = $result->fetch_array()){

        $id = $row['id'];
        $name = $row['name'];

        if ( $id == 80 ){
            $county_list .= '<option value="$id" selected >'.$name.'</option>';
        } else {
            $county_list .= '<option value="$id">'.$name.'</option>';
        }

    }

    return $county_list;
}


function get_bDay() {

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
}

?>