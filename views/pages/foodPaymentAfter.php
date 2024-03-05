<?php 
include ("../../config/config.php");
session_start();

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $order_id = $_POST['order_id'];
    $sql = "UPDATE order_food SET order_slip=:image_base64, order_status=:order_status, payment_at=CURRENT_TIMESTAMP WHERE order_id=$order_id";

    $stmt = $conn->prepare($sql);

    $order_status = $_POST["order_status"];
    $order_slip = file_get_contents($_FILES["order_slip"]["tmp_name"]);
    $image_base64 = base64_encode($order_slip);

    $stmt->bindParam(":order_status", $order_status);
    $stmt->bindParam(":image_base64", $image_base64);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการชำระเงินสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "userFoodList.php";
        });
        }, 1000);
        </script>';
    } else {
        echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
    exit();
}

$order_id = $_GET['order_id'];
$food_id = $_GET['food_id'];
$sql = "SELECT * FROM foods, order_food WHERE order_id = $order_id AND foods.food_id = $food_id";
$result = mysqli_query($c, $sql);
$fetch = mysqli_fetch_array($result);
extract($fetch);
$stmt = $conn->prepare($sql);
$stmt->execute();

$order_quantity = $fetch['order_quantity'];
$food_price = $fetch['food_price'];
$sumPrice = $order_quantity * $food_price;

foreach ($stmt as $i=>$fetch) {
  
  // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
  $image_base64[$i] = $fetch["food_image"];

  // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
  $food_image = base64_decode($image_base64[$i]);

  // แสดงผลรูปภาพ
  $showimg[$i] = '<img src="data:$food_image/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: 180px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
}

include ("foodPaymentAfter.html");
?>
