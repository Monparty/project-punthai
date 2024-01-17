<?php 
include ("../../config/config.php");
session_start();


$sql = " SELECT name, image, price, roomdesc FROM rooms";
$query = mysqli_query( $c, $sql );

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

while ($row = $stmt->fetch()) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64 = $row["image"];

// แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
$image = base64_decode($image_base64);

// แสดงผลรูปภาพ
$showimg = '<img src="data:$image/png;base64,' . $image_base64 . '" style="width: 100%; height: 180px; object-fit: cover; border-radius: 4px;"/>';
echo $showimg;

}
include ("roomList.html");
?>
