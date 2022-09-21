<?php

include("../autoloader.php");

$sql_country_query = "SELECT country_id, country_name from countries";
    
$database_connection = new DataStorage();
$result_array = $database_connection->runSelectQuery($sql_country_query);
    
// encoding array to json format
echo json_encode($result_array);

?>