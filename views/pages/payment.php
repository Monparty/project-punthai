<?php 
include ("../../config/config.php");
session_start();

$room_id = $_REQUEST['room_id'];
$sql = "SELECT * FROM rooms WHERE room_id=$room_id";
$query = mysqli_query( $c, $sql );
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE rooms SET slip_image=:image_base64, booking_status=:booking_status, upload_slip_at=CURRENT_TIMESTAMP WHERE room_id=$room_id";
    
    $stmt = $conn->prepare($sql);
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
