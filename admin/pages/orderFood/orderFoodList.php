<?php 
include("../../../config/config.php");
session_start();

$sql = "SELECT * FROM order_food";
$query = mysqli_query( $c, $sql );

include ("orderFoodList.html");
?>