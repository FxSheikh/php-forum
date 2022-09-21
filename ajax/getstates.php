<?php
include("../includes/database.php");

if($_SERVER["REQUEST_METHOD"]=="GET"){
    //get variable sent via javascript
    $countrycode = $_GET["country"];
    
    $states_query = "SELECT sub_region_code,sub_region_name FROM 
    countries_subdivisions WHERE country_code='$countrycode'";
    $states_result = $connection->query($states_query);
    $states = array();
    if($states_result->num_rows > 0){
        while($row = $states_result->fetch_assoc()){
            $subregion = $row["sub_region_code"];
            $subregionname = filter_var($row["sub_region_name"],FILTER_SANITIZE_STRING,
            FILTER_FLAG_ENCODE_HIGH);
            $region = array("code"=>$subregion,"name"=>$subregionname);
            array_push($states,$region);
        }
    }
    echo json_encode($states);
}
?>