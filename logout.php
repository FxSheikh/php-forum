<?php

session_start();
// unset user session variables
unset($_SESSION["admin_id"]);
unset($_SESSION["user_id"]);
unset($_SESSION["user_email"]);
unset($_SESSION["user_name"]);

// destroy the session
session_destroy(); 

// redirect the user to the login page
header('Location:login.php');

//$from = $_SERVER["HTTP_REFERER"];
//header("location:$from");

?>