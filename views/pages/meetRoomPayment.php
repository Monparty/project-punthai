<?php 
include ("../../config/config.php");
session_start();

$meetroom_id = $_REQUEST['meetroom_id'];
$sql = "SELECT * FROM meetrooms INNER JOIN meetroom_bookings ON meetroom_bookings.meetroom_id = meetrooms.meetroom_id WHERE meetrooms.meetroom_id = $meetroom_id ORDER BY meetroom_bookings.meetbooking_id DESC;";
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

$sumprice = $fetch['meetroom_price'] + $snack1_price + $snack2_price + $snack3_price + $lunch1_price + $lunch2_price + $lunch3_price + $buffet1_price + $buffet2_price + $buffet3_price + $buffetset1 + $buffetset2 + $buffetset3;

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $user_id = $_SESSION["user_id"];
    $meetbooking_id = $fetch['meetbooking_id'];
    $sql = "UPDATE meetroom_bookings SET slip_image=:image_base64, booking_status=:booking_status, sumprice=:sumprice, upload_slip_at=CURRENT_TIMESTAMP WHERE meetbooking_id=$meetbooking_id";

    $stmt = $conn->prepare($sql);
    $meetroom_id = $_POST["meetroom_id"];
    $sumprice = $sumprice;
    $booking_status = $_POST["booking_status"];
    $slip_image = file_get_contents($_FILES["slip_image"]["tmp_name"]);
    $image_base64 = base64_encode($slip_image);

    $stmt->bindParam(":sumprice", $sumprice);
    $stmt->bindParam(":booking_status", $booking_status);
    $stmt->bindParam(":image_base64", $image_base64);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการชำระเงินสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "userMeetRoomBooking.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("meetRoomPayment.html");
?>
