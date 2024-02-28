<?php 
include("../../../config/config.php");
session_start();

$meetbooking_id = $_REQUEST['id'];
$sql = "SELECT * FROM meetroom_bookings INNER JOIN meetrooms ON meetrooms.meetroom_id = meetroom_bookings.meetroom_id WHERE meetroom_bookings.meetbooking_id = $meetbooking_id";
$result = mysqli_query($c, $sql);
$fetch = mysqli_fetch_array($result);
extract($fetch);
$stmt = $conn->prepare($sql);
$stmt->execute();



foreach ($stmt as $i=>$fetch) {
  
  // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
  $image_base64[$i] = $fetch["slip_image"];

  // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
  $image = base64_decode($image_base64[$i]);

  // แสดงผลรูปภาพ
  $showimg[$i] = '<img src="data:$image/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: auto; object-fit: cover; border-radius: 4px;"/>';
}

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE bookings SET remark=:remark, booking_status=:booking_status, approve_at=CURRENT_TIMESTAMP WHERE booking_id=$booking_id";

    $booking_status = "ชำระเงินเรียบร้อย";
    $remark = $_POST["remark"];

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":remark", $remark);
    $stmt->bindParam(":booking_status", $booking_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "ตรวจสอบข้อมูลการชำระเงินเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "bookingList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

if (isset($_REQUEST['cancel'])) {
    $sql = "UPDATE bookings SET remark=:remark, booking_status=:booking_status, approve_at=CURRENT_TIMESTAMP WHERE booking_id=$booking_id";

    $booking_status = "ข้อมูลการชำระเงินไม่ถูกต้อง";
    $remark = $_POST["remark"];
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":remark", $remark);
    $stmt->bindParam(":booking_status", $booking_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "ตรวจสอบข้อมูลการชำระเงินเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "bookingList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("bookingApprove.html");
?>
