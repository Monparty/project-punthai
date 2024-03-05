<?php 
include("../../../config/config.php");
session_start();

$sql = " SELECT * FROM meetroom_bookings";
$query = mysqli_query( $c, $sql );

include ("bookingList.html");
?>