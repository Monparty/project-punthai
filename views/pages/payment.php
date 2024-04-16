<?php 
include ("../../config/config.php");
session_start();

$id = $_REQUEST['room_id'];
$sql = "SELECT * FROM rooms INNER JOIN bookings ON bookings.room_id = rooms.room_id WHERE rooms.room_id = $id ORDER BY bookings.booking_id DESC;";
$result = mysqli_query($c, $sql);
$fetch = mysqli_fetch_array($result);
extract($fetch);
$stmt = $conn->prepare($sql);
$stmt->execute();

$sql_bank = "SELECT * FROM bank_info";
$query_bank = mysqli_query( $c, $sql_bank);
// ใช้แสดงรูปภาพ
$stmt_bank = $conn->prepare($sql_bank);
$stmt_bank->execute();
$fetch_bank = mysqli_fetch_assoc($query_bank);

foreach ($stmt_bank as $i=>$fetch_bank) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64[$i] = $fetch_bank["bank_image"];

// แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
$bank_image = base64_decode($image_base64[$i]);

// แสดงผลรูปภาพ
$showimg_bank[$i] = '<img src="data:$bank_image/png;base64,' . $image_base64[$i] . '" style="width: 40px; height: 40px; border-radius: 5px; object-fit: cover; border-radius: 5px;"/>';
}


// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $user_id = $_SESSION["user_id"];
    $booking_id = $fetch['booking_id'];
    $sql = "UPDATE bookings SET slip_image=:image_base64, booking_status=:booking_status, upload_slip_at=CURRENT_TIMESTAMP WHERE booking_id=$booking_id";

    $stmt = $conn->prepare($sql);
    $room_id = $_POST["room_id"];
    $booking_status = $_POST["booking_status"];
    $slip_image = file_get_contents($_FILES["slip_image"]["tmp_name"]);
    $image_base64 = base64_encode($slip_image);

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
            window.location = "userBooking.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("payment.html");
?>
