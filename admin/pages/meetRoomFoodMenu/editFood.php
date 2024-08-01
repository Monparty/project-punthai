<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$id = $_REQUEST['id'];
$sql = "SELECT * FROM meetroom_food WHERE id=$id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();

// วนลูปเพื่อดึงข้อมูลรูปภาพ
foreach ($stmt as $row) {

    // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
    $image_base64 = $row["food_image"];

    // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
    $food_image = base64_decode($image_base64);

    // แสดงผลรูปภาพ
    $showimg = '<img src="data:$food_image/png;base64,' . $image_base64 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
}

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE foods SET food_name=:food_name, food_price=:food_price, food_type=:food_type, food_detail=:food_detail, food_status=:food_status, food_image=:image_base64, update_at=CURRENT_TIMESTAMP WHERE id=$id";
    
    $stmt = $conn->prepare($sql);
    $food_name = $_POST['food_name'];
    $food_price = $_POST["food_price"];
    $food_type = $_POST["food_type"];
    $food_detail = $_POST["food_detail"];
    $food_status = implode($_POST["food_status"]);
    if($_FILES["food_image"]["tmp_name"]){
        $food_image = file_get_contents($_FILES["food_image"]["tmp_name"]);
        $image_base64 = base64_encode($food_image);
    };

    $stmt->bindParam(":food_name", $food_name);
    $stmt->bindParam(":food_price", $food_price);
    $stmt->bindParam(":food_type", $food_type);
    $stmt->bindParam(":food_detail", $food_detail);
    $stmt->bindParam(":food_status", $food_status);
    if($image_base64){
        $stmt->bindParam(":image_base64", $image_base64);
    };
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "แก้ไขข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "foodList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("editFood.html");
?>