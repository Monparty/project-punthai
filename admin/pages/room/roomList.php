<?php 
require_once '../../../config/config.php';
session_start();

$sql = " SELECT * FROM rooms";
$query = mysqli_query( $c, $sql );




include ("roomList.html");
?>
