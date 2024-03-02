<?php 
include("../../../config/config.php");
session_start();

$sql = "SELECT * FROM meetroom_bookings WHERE booking_status IN ('ชำระเงินเรียบร้อย', 'เข้าใช้งานห้องประชุม', 'ใช้งานห้องประชุมเสร็จสิ้น')";
$query = mysqli_query( $c, $sql );

include ("checkInCheckOutList.html");
?>