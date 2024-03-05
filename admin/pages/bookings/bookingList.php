<?php 
include("../../../config/config.php");
session_start();

$sql = " SELECT * FROM bookings";
$query = mysqli_query( $c, $sql );

include ("bookingList.html");
?>