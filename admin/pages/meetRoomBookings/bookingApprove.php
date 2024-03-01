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

// คำนวณค่าอาหาร
$snack1 = 45;
$snack2 = 55;
$snack3 = 65;
$lunch1 = 55;
$lunch2 = 65;
$lunch3 = 235;
$buffet = 340;

$snack1_price = $fetch['snack1_amount'] * $snack1;
$snack2_price = $fetch['snack2_amount'] * $snack2;
$snack3_price = $fetch['snack3_amount'] * $snack3;

$lunch1_price = $fetch['lunch1_amount'] * $lunch1;
$lunch2_price = $fetch['lunch2_amount'] * $lunch2;
$lunch3_price = $fetch['lunch3_amount'] * $lunch3;

$buffet1_price = $fetch['buffet1_amount'] * $buffet;
$buffet2_price = $fetch['buffet2_amount'] * $buffet;
$buffet3_price = $fetch['buffet3_amount'] * $buffet;

if ($fetch['buffetset1']!='T'){
    $buffetset1 = 0;
} else {
    $buffetset1 = 6500;
}

if ($fetch['buffetset2']!='T'){
    $buffetset2 = 0;
} else {
    $buffetset2 = 12000;
}

if ($fetch['buffetset3']!='T'){
    $buffetset3 = 0;
} else {
    $buffetset3 = 22000;
}



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
    $sql = "UPDATE meetroom_bookings SET remark_approve=:remark_approve, booking_status=:booking_status, approve_at=CURRENT_TIMESTAMP WHERE meetbooking_id=$meetbooking_id";

    $booking_status = "ชำระเงินเรียบร้อย";
    $remark_approve = $_POST["remark_approve"];

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":remark_approve", $remark_approve);
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
    $sql = "UPDATE meetroom_bookings SET remark_approve=:remark_approve, booking_status=:booking_status, approve_at=CURRENT_TIMESTAMP WHERE meetbooking_id=$meetbooking_id";

    $booking_status = "ข้อมูลการชำระเงินไม่ถูกต้อง";
    $remark_approve = $_POST["remark_approve"];
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":remark_approve", $remark_approve);
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
