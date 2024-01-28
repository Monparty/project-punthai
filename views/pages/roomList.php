<?php 
include ("../../config/config.php");
session_start();


$sql = "SELECT * FROM rooms";
//$sql = "SELECT * FROM rooms WHERE booking_status = 'จอง'";
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
$showimg[$i] = '<img src="data:$image/png;base64,' . $image_base64[$i] . '" style="width: 200px; height: 180px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
}

include ("roomList.html");
?>
