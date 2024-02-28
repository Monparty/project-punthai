<?php 
include("../../../config/config.php");
session_start();

$sql = " SELECT * FROM meetroom_bookings WHERE booking_status = 'ชำระเงินเรียบร้อย / รอตรวจสอบ'";
$query = mysqli_query( $c, $sql );

include ("bookingList.html");
?>