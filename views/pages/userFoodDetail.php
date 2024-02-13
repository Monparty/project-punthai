<?php 
include ("../../config/config.php");
session_start();

$food_id = $_REQUEST['id'];
$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM foods WHERE food_id = $food_id";
$query = mysqli_query( $c, $sql);
// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

$sqlBooking = "SELECT * FROM bookings WHERE user_id = $user_id AND booking_status = 'เช็คอิน'";
$queryBooking = mysqli_query( $c, $sqlBooking);
$stmtBooking = $conn->prepare($sqlBooking);
$stmtBooking->execute();
$fetchBooking = mysqli_fetch_assoc($queryBooking);

foreach ($stmt as $i=>$fetch) {
  
  // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
  $image_base64[$i] = $fetch["food_image"];

  // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
  $food_image = base64_decode($image_base64[$i]);

  // แสดงผลรูปภาพ
  $showimg[$i] = '<img src="data:$food_image/png;base64,' . $image_base64[$i] . '" style="width: 420px; height: 390px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
}

// ส่วนบันทึกข้อมูลการสั่งอาหาร
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $food_id = $fetch["food_id"];
  $order_remark = isset($_POST["order_remark"]) ? $_POST["order_remark"] : "";
  $order_quantity = isset($_POST["order_quantity"]) ? $_POST["order_quantity"] : "";
  $room_number = isset($_POST["room_number"]) ? $_POST["room_number"] : "";
  $food_price = $fetch["food_price"];
  $sum_price = $order_quantity * $food_price;
  $order_status = "รอการชำระเงิน";
  
  $sql = "INSERT INTO order_food (user_id, food_id, order_remark, order_quantity, room_number, sum_price, order_status, order_date)
  VALUES (:user_id, :food_id, :order_remark, :order_quantity, :room_number, :sum_price, :order_status, CURRENT_TIMESTAMP)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":user_id", $user_id);
  $stmt->bindParam(":food_id", $food_id);
  $stmt->bindParam(":order_remark", $order_remark);
  $stmt->bindParam(":order_quantity", $order_quantity);
  $stmt->bindParam(":room_number", $room_number);
  $stmt->bindParam(":sum_price", $sum_price);
  $stmt->bindParam(":order_status", $order_status);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "สั่งอาหารเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "foodPayment.php?food_id=' . $food_id . '";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}


include ("userFoodDetail.html");
?>
