<?php 
include("../../../config/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST["name"];
  $roomdesc = $_POST["roomdesc"];
  $price = $_POST["price"];
  $roomabout = $_POST["roomabout"];
  $bed = $_POST["bed"];
  $amountpeople = $_POST["amountpeople"];
  $facility1 = isset($_POST['facility1']) ? $_POST['facility1'] : "";
  $facility2 = isset($_POST['facility2']) ? $_POST['facility2'] : "";
  $facility3 = isset($_POST['facility3']) ? $_POST['facility3'] : "";
  $facility4 = isset($_POST['facility4']) ? $_POST['facility4'] : "";
  $facility5 = isset($_POST['facility5']) ? $_POST['facility5'] : "";
  $facility6 = isset($_POST['facility6']) ? $_POST['facility6'] : "";
  $facility7 = isset($_POST['facility7']) ? $_POST['facility7'] : "";
  $facility8 = isset($_POST['facility8']) ? $_POST['facility8'] : "";
  $room_number = isset($_POST["room_number"]) ? implode(", ",$_POST["room_number"]) : "";
  $status = implode($_POST["status"]);
  $image = file_get_contents($_FILES["image"]["tmp_name"]);
  $image_base64 = base64_encode($image);
  if($_FILES["image2"]["tmp_name"]!=""){
      $image2 = file_get_contents($_FILES["image2"]["tmp_name"]);
      $image_base642 = base64_encode($image2);
  } else {
    $image_base642 = "";
  };
  if($_FILES["image3"]["tmp_name"]!=""){
      $image3 = file_get_contents($_FILES["image3"]["tmp_name"]);
      $image_base643 = base64_encode($image3);
  } else {
    $image_base643 = "";
  };
  if($_FILES["image4"]["tmp_name"]!=""){
      $image4 = file_get_contents($_FILES["image4"]["tmp_name"]);
      $image_base644 = base64_encode($image4);
  } else {
    $image_base644 = "";
  };
  if($_FILES["image5"]["tmp_name"]!=""){
      $image5 = file_get_contents($_FILES["image5"]["tmp_name"]);
      $image_base645 = base64_encode($image5);
  } else {
    $image_base645 = "";
  };

  $sql = "INSERT INTO rooms (name, roomdesc, price, roomabout,  bed, amountpeople, facility1, facility2, facility3, facility4, facility5, facility6, facility7, facility8, room_number, status, createAt, image, image2, image3, image4, image5)
  VALUES (:name, :roomdesc, :price, :roomabout, :bed, :amountpeople, :facility1, :facility2, :facility3, :facility4, :facility5, :facility6, :facility7, :facility8, :room_number, :status, CURRENT_TIMESTAMP, :image_base64, :image_base642, :image_base643, :image_base644, :image_base645)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":roomdesc", $roomdesc);
  $stmt->bindParam(":price", $price);
  $stmt->bindParam(":roomabout", $roomabout);
  $stmt->bindParam(":bed", $bed);
  $stmt->bindParam(":amountpeople", $amountpeople);
  $stmt->bindParam(":facility1", $facility1);
  $stmt->bindParam(":facility2", $facility2);
  $stmt->bindParam(":facility3", $facility3);
  $stmt->bindParam(":facility4", $facility4);
  $stmt->bindParam(":facility5", $facility5);
  $stmt->bindParam(":facility6", $facility6);
  $stmt->bindParam(":facility7", $facility7);
  $stmt->bindParam(":facility8", $facility8);
  $stmt->bindParam(":room_number", $room_number);
  $stmt->bindParam(":status", $status);
  $stmt->bindParam(":image_base64", $image_base64);
  $stmt->bindParam(":image_base642", $image_base642);
  $stmt->bindParam(":image_base643", $image_base643);
  $stmt->bindParam(":image_base644", $image_base644);
  $stmt->bindParam(":image_base645", $image_base645);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "roomList.php";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}
include ("addRoom.html");
?>
