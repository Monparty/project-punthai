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

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['checkIn'])) {
    $sql = "UPDATE meetroom_bookings SET remark_approve=:remark_approve, booking_status=:booking_status, real_start_date=CURRENT_TIMESTAMP WHERE meetbooking_id=$meetbooking_id";

    $booking_status = "เข้าใช้งานห้องประชุม";
    $remark_approve = $_POST["remark_approve"];

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":remark_approve", $remark_approve);
    $stmt->bindParam(":booking_status", $booking_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการเข้าใช้งานเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "checkInCheckOutList.php";
        });
        }, 1000);
        </script>';
    } else {
        echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

if (isset($_REQUEST['checkOut'])) {
    $sql = "UPDATE meetroom_bookings SET remark_approve=:remark_approve, booking_status=:booking_status, real_end_date=CURRENT_TIMESTAMP WHERE meetbooking_id=$meetbooking_id";

    $booking_status = "ใช้งานห้องประชุมเสร็จสิ้น";
    $remark_approve = $_POST["remark_approve"];

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":remark_approve", $remark_approve);
    $stmt->bindParam(":booking_status", $booking_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการใช้งานเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "checkInCheckOutList.php";
        });
        }, 1000);
        </script>';
    } else {
        echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include("checkInCheckOutManage.html");
