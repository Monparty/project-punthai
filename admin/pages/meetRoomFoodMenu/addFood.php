<?php 
include("../../../config/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $food_name = $_POST["food_name"];
  $food_price = $_POST["food_price"];
  $food_type = $_POST["food_type"];
  $food_detail = $_POST["food_detail"];
  $food_status = implode($_POST["food_status"]);
  $food_image = file_get_contents($_FILES["food_image"]["tmp_name"]);
  $image_base64 = base64_encode($food_image);

  $sql = "INSERT INTO meetroom_food (food_name, food_price, food_type, food_detail, food_status, create_at, food_image)
  VALUES (:food_name, :food_price, :food_type, :food_detail, :food_status, CURRENT_TIMESTAMP, :image_base64)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":food_name", $food_name);
  $stmt->bindParam(":food_price", $food_price);
  $stmt->bindParam(":food_type", $food_type);
  $stmt->bindParam(":food_detail", $food_detail);
  $stmt->bindParam(":food_status", $food_status);
  $stmt->bindParam(":image_base64", $image_base64);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "foodList.php";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}
include ("addFood.html");
?>
