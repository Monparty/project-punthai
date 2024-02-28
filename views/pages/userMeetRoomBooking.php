<?php 
include ("../../config/config.php");
session_start();

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM meetrooms INNER JOIN meetroom_bookings ON meetroom_bookings.meetroom_id = meetrooms.meetroom_id WHERE meetroom_bookings.user_id = $user_id";

$query = mysqli_query( $c, $sql );

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

foreach ($stmt as $i=>$fetch) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64[$i] = $fetch["meetroom_image"];

// แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
$meetroom_image = base64_decode($image_base64[$i]);

// แสดงผลรูปภาพ
$showimg[$i] = '<img src="data:$meetroom_image/png;base64,' . $image_base64[$i] . '" style="width: 70px; height: 70px; border-radius: 5px; object-fit: cover; border-radius: 5px;"/>';
}

include ("userMeetRoomBooking.html");
?>
