<?php
include("../autoloader.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $categories = $_POST["categories"];
    $price = $_POST["price"];
    $products = new Products($categories,$price);
    $products->renderJSON();
}
// $products = new Products();
// $products->renderJSON();

?>