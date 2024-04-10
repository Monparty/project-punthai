<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$id = $_REQUEST['id'];
$sql = "SELECT * FROM facility_info WHERE id=$id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);

$stmt = $conn->prepare($sql);
$stmt->execute();


// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE facility_info SET name=:name, image_svg=:image_svg, status=:status, update_at=CURRENT_TIMESTAMP WHERE id=$id";
    
    $stmt = $conn->prepare($sql);
    $name = $_POST['name'];
    $image_svg = $_POST['image_svg'];
    $status = implode($_POST["status"]);

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":image_svg", $image_svg);
    $stmt->bindParam(":status", $status);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "แก้ไขข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "list.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("edit.html");
?>