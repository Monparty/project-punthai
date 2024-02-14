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

// ดึงชื่อ User มาแสดง
$user_id = $fetch["user_id"];
$sqlUser = "SELECT * FROM order_food INNER JOIN users ON users.user_id = order_food.user_id WHERE order_food.user_id = $user_id";
$resultUser = mysqli_query($c, $sqlUser);
$fetchUser = mysqli_fetch_array($resultUser);
extract($fetchUser);
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->execute();

foreach ($stmt as $i=>$fetch) {
  
  // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
  $image_base64[$i] = $fetch["order_slip"];

  // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
  $order_slip = base64_decode($image_base64[$i]);

  // แสดงผลรูปภาพ
  $showimg[$i] = '<img src="data:$order_slip/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: auto; object-fit: cover; border-radius: 4px;"/>';
}

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE order_food SET payment_remark=:payment_remark, order_status=:order_status, approve_at=CURRENT_TIMESTAMP WHERE order_id=$order_id";

    $order_status = "กำลังจัดเตรียมอาหาร";
    $payment_remark = $_POST["payment_remark"];

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":payment_remark", $payment_remark);
    $stmt->bindParam(":order_status", $order_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "ตรวจสอบข้อมูลการชำระเงินเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "orderFoodList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

if (isset($_REQUEST['cancel'])) {
    $sql = "UPDATE order_food SET payment_remark=:payment_remark, order_status=:order_status, approve_at=CURRENT_TIMESTAMP WHERE order_id=$order_id";

    $order_status = "ข้อมูลการชำระเงินไม่ถูกต้อง";
    $payment_remark = $_POST["payment_remark"];
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":payment_remark", $payment_remark);
    $stmt->bindParam(":order_status", $order_status);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "ตรวจสอบข้อมูลการชำระเงินเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "orderFoodList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("orderFoodManage.html");
?>
