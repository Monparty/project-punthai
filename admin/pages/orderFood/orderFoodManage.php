<?php 
include("../../../config/config.php");
session_start();

$order_id = $_REQUEST['order_id'];
$sql = "SELECT * FROM order_food INNER JOIN foods ON foods.food_id = order_food.food_id WHERE order_food.order_id = $order_id";
$result = mysqli_query($c, $sql);
$fetch = mysqli_fetch_array($result);
extract($fetch);
$stmt = $conn->prepare($sql);
$stmt->execute();

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['checkIn'])) {
    $sql = "UPDATE bookings SET room_number=:room_number, car_number=:car_number, remark_check_in_out=:remark_check_in_out, booking_status=:booking_status, check_in_at=CURRENT_TIMESTAMP WHERE booking_id=$booking_id";

    $booking_status = "เช็คอิน";
    $remark_check_in_out = $_POST["remark_check_in_out"];
    $room_number = $_POST["room_number"];
    $car_number = $_POST["car_number"];

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":room_number", $room_number);
    $stmt->bindParam(":car_number", $car_number);
    $stmt->bindParam(":remark_check_in_out", $remark_check_in_out);
    $stmt->bindParam(":booking_status", $booking_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการเช็คอินเรียบร้อย",  
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
    $sql = "UPDATE bookings SET remark_check_in_out=:remark_check_in_out, booking_status=:booking_status, check_out_at=CURRENT_TIMESTAMP WHERE booking_id=$booking_id";

    $booking_status = "เช็คเอาท์";
    $remark_check_in_out = $_POST["remark_check_in_out"];
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":remark_check_in_out", $remark_check_in_out);
    $stmt->bindParam(":booking_status", $booking_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการเช็คเอาท์เรียบร้อย",  
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

include ("orderFoodManage.html");
?>
