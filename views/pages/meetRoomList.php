<?php 
include ("../../config/config.php");
session_start();

$sql = "SELECT * FROM meetrooms WHERE status = 'Active'";
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
$showimg[$i] = '<img src="data:$meetroom_image/png;base64,' . $image_base64[$i] . '" style="width: 200px; height: 180px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
}

include ("meetRoomList.html");
?>
