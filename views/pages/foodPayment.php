<?php 
include ("../../config/config.php");
session_start();

$food_id = $_GET['food_id'];
$sql = "SELECT * FROM foods INNER JOIN order_food ON order_food.food_id = foods.food_id WHERE foods.food_id = $food_id ORDER BY order_food.order_id DESC;";
$result = mysqli_query($c, $sql);
$fetch = mysqli_fetch_array($result);
extract($fetch);
$stmt = $conn->prepare($sql);
$stmt->execute();

foreach ($stmt as $i=>$fetch) {
  
  // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
  $image_base64[$i] = $fetch["food_image"];

  // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
  $food_image = base64_decode($image_base64[$i]);

  // แสดงผลรูปภาพ
  $showimg[$i] = '<img src="data:$food_image/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: 180px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
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

include ("foodPayment.html");
?>
