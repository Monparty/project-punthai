<?php 
include ("../../config/config.php");
session_start();

$room_id = $_GET['room_id'];
$booking_id = $_GET['booking_id'];
$sql = "SELECT * FROM rooms, bookings WHERE booking_id = $booking_id AND rooms.room_id = $room_id;";
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
  $showimg[$i] = '<img src="data:$image/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: 310px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
}


include ("userBookingDetail.html");
?>
