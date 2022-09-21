<?php
//database host
$host = "localhost";
//database user
$user = "user";
//database password
$password = "password";
//database name
$dbname = "overwatch_forum";
//connecting to the database
$connection = mysqli_connect($host,$user,$password,$dbname);
//if connection is unsuccessful
if(!$connection){
    echo "connection error!";
}
?>