<?php

include("../autoloader.php");

$categoryid = $_POST['category'];   // department id

$database_connection = new DataStorage();

$sql_posts_query = "SELECT * from posts WHERE post_category='$categoryid' and post_id>6";
    
$result_array = $database_connection->runSelectQuery($sql_posts_query);
    
// encoding array to json format
echo json_encode($result_array);

?>