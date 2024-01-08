<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$id = $_REQUEST['id'];
$sql = "SELECT * FROM rooms WHERE id=$id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();

// วนลูปเพื่อดึงข้อมูลรูปภาพ
while ($row = $stmt->fetch()) {

    // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
    $image_base64 = $row["image"];

    // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
    $image = base64_decode($image_base64);

    // แสดงผลรูปภาพ
    $showimg = '<img src="data:$image/png;base64,' . $image_base64 . '" style="width: 100%; object-fit: cover; border-radius: 4px;"/>';
}

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $id = $_POST['id'];
    $sql = "UPDATE rooms SET name=:name WHERE id=$id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $name);
    $name = $_POST['name'];
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "แก้ไขข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "roomList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("editRoom.html");
?>