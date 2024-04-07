<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$id = $_REQUEST['id'];
$sql = "SELECT * FROM bank_info WHERE id=$id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();

foreach ($stmt as $fetch) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64 = $fetch["bank_image"];
$showimg = '<img src="data:$bank_image/png;base64,' . $image_base64 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
}

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE bank_info SET bank_name=:bank_name, account_name=:account_name, account_number=:account_number, status=:status, bank_image=:image_base64, update_at=CURRENT_TIMESTAMP WHERE id=$id";
    
    $stmt = $conn->prepare($sql);
    $bank_name = $_POST['bank_name'];
    $account_name = $_POST['account_name'];
    $account_number = $_POST['account_number'];
    $status = implode($_POST["status"]);

    if($_FILES["bank_image"]["tmp_name"]!=""){
      $bank_image = file_get_contents($_FILES["bank_image"]["tmp_name"]);
      $image_base64 = base64_encode($bank_image);
    } else {
      $image_base64 = $fetch["bank_image"];
    };

    $stmt->bindParam(":bank_name", $bank_name);
    $stmt->bindParam(":account_name", $account_name);
    $stmt->bindParam(":account_number", $account_number);
    $stmt->bindParam(":image_base64", $image_base64);
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