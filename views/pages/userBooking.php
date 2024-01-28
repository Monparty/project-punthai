<?php 
include ("../../config/config.php");
session_start();

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM bookings, rooms WHERE booking_status = 'ชำระเงินเรียบร้อย / รอตรวจสอบ'";
$query = mysqli_query( $c, $sql );

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

foreach ($stmt as $i=>$fetch) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64[$i] = $fetch["image"];

// แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
$image = base64_decode($image_base64[$i]);

// แสดงผลรูปภาพ
$showimg[$i] = '<img src="data:$image/png;base64,' . $image_base64[$i] . '" style="width: 70px; height: 70px; border-radius: 5px; object-fit: cover; border-radius: 5px;"/>';
}

include ("userBooking.html");
?>
