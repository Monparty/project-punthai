<?php 
include("../../../config/config.php");
session_start();

$sql = "SELECT * FROM bookings WHERE booking_status IN ('ชำระเงินเรียบร้อย', 'เช็คอิน', 'เช็คเอาท์')";
$query = mysqli_query( $c, $sql );

include ("checkInCheckOutList.html");
?>