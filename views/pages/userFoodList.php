<?php 
include ("../../config/config.php");
session_start();

$sql = "SELECT * FROM foods WHERE food_status = 'Active'";
$query = mysqli_query( $c, $sql );

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

foreach ($stmt as $i=>$fetch) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64[$i] = $fetch["food_image"];

// แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
$food_image = base64_decode($image_base64[$i]);

// แสดงผลรูปภาพ
$showimg[$i] = '<img src="data:$food_image/png;base64,' . $image_base64[$i] . '" style="width: 220px; height: 180px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
}

$user_id = $_SESSION["user_id"];
$sql_food_order = "SELECT * FROM foods INNER JOIN order_food ON order_food.food_id = foods.food_id WHERE order_food.user_id = $user_id";
$queryOrder = mysqli_query( $c, $sql_food_order );

// ใช้แสดงรูปภาพ
$stmtOrder = $conn->prepare($sql_food_order);
$stmtOrder->execute();
$fetchOrder = mysqli_fetch_assoc($queryOrder);

foreach ($stmtOrder as $i=>$fetchOrder) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64[$i] = $fetchOrder["food_image"];

// แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
$food_image = base64_decode($image_base64[$i]);

// แสดงผลรูปภาพ
$showimgOrder[$i] = '<img src="data:$food_image/png;base64,' . $image_base64[$i] . '" style="width: 50px; height: 50px; border-radius: 5px; object-fit: cover; border-radius: 5px;"/>';
}

include ("userFoodList.html");
?>
