<?php 
include("../../../config/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $meetroom_name = $_POST["meetroom_name"];
  $meetroom_desc = $_POST["meetroom_desc"];
  $meetroom_price = $_POST["meetroom_price"];
  $meetroom_about = $_POST["meetroom_about"];
  $floor = $_POST["floor"];
  $amountpeople = $_POST["amountpeople"];
  $facility1 = isset($_POST['facility1']) ? $_POST['facility1'] : "";
  $facility2 = isset($_POST['facility2']) ? $_POST['facility2'] : "";
  $facility3 = isset($_POST['facility3']) ? $_POST['facility3'] : "";
  $facility4 = isset($_POST['facility4']) ? $_POST['facility4'] : "";
  $facility5 = isset($_POST['facility5']) ? $_POST['facility5'] : "";
  $facility6 = isset($_POST['facility6']) ? $_POST['facility6'] : "";
  $facility7 = isset($_POST['facility7']) ? $_POST['facility7'] : "";
  $facility8 = isset($_POST['facility8']) ? $_POST['facility8'] : "";
  $facility9 = isset($_POST['facility9']) ? $_POST['facility9'] : "";
  $facility10 = isset($_POST['facility10']) ? $_POST['facility10'] : "";

  $status = implode($_POST["status"]);
  $meetroom_image = file_get_contents($_FILES["meetroom_image"]["tmp_name"]);
  $image_base64 = base64_encode($meetroom_image);

  $sql = "INSERT INTO meetrooms (meetroom_name, meetroom_desc, meetroom_price, meetroom_about, floor, amountpeople, facility1, facility2, facility3, facility4, facility5, facility6, facility7, facility8, facility9, facility10, status, create_at, meetroom_image)
  VALUES (:meetroom_name, :meetroom_desc, :meetroom_price, :meetroom_about, :floor, :amountpeople, :facility1, :facility2, :facility3, :facility4, :facility5, :facility6, :facility7, :facility8, :facility9, :facility10, :status, CURRENT_TIMESTAMP, :image_base64)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":meetroom_name", $meetroom_name);
  $stmt->bindParam(":meetroom_desc", $meetroom_desc);
  $stmt->bindParam(":meetroom_price", $meetroom_price);
  $stmt->bindParam(":meetroom_about", $meetroom_about);
  $stmt->bindParam(":floor", $floor);
  $stmt->bindParam(":amountpeople", $amountpeople);
  $stmt->bindParam(":facility1", $facility1);
  $stmt->bindParam(":facility2", $facility2);
  $stmt->bindParam(":facility3", $facility3);
  $stmt->bindParam(":facility4", $facility4);
  $stmt->bindParam(":facility5", $facility5);
  $stmt->bindParam(":facility6", $facility6);
  $stmt->bindParam(":facility7", $facility7);
  $stmt->bindParam(":facility8", $facility8);
  $stmt->bindParam(":facility9", $facility9);
  $stmt->bindParam(":facility10", $facility10);
  $stmt->bindParam(":status", $status);
  $stmt->bindParam(":image_base64", $image_base64);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "meetRoomList.php";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}
include ("addUser.html");
?>
