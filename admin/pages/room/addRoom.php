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
$highlight1 = isset($_POST['highlight1']) ? $_POST['highlight1'] : "";
$highlight2 = isset($_POST['highlight2']) ? $_POST['highlight2'] : "";
$highlight3 = isset($_POST['highlight3']) ? $_POST['highlight3'] : "";
$highlight4 = isset($_POST['highlight4']) ? $_POST['highlight4'] : "";
$highlight5 = isset($_POST['highlight5']) ? $_POST['highlight5'] : "";
$highlight6 = isset($_POST['highlight6']) ? $_POST['highlight6'] : "";
$highlight7 = isset($_POST['highlight7']) ? $_POST['highlight7'] : "";
$highlight8 = isset($_POST['highlight8']) ? $_POST['highlight8'] : "";
$status = implode($_POST["status"]);
$image = $_FILES["image"]["tmp_name"];
$imgContent = file_get_contents($image);

$sql = "INSERT INTO rooms (name, roomdesc, price, roomabout,  bed, amountpeople, facility1, facility2, facility3, facility4, facility5, facility6, facility7, facility8, highlight1, highlight2, highlight3, highlight4, highlight5, highlight6, highlight7, highlight8, status, createAt, image)
VALUES (:name, :roomdesc, :price, :roomabout, :bed, :amountpeople, :facility1, :facility2, :facility3, :facility4, :facility5, :facility6, :facility7, :facility8, :highlight1, :highlight2, :highlight3, :highlight4, :highlight5, :highlight6, :highlight7, :highlight8, :status, CURRENT_TIMESTAMP, :imgContent)";

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
$stmt->bindParam(":highlight1", $highlight1);
$stmt->bindParam(":highlight2", $highlight2);
$stmt->bindParam(":highlight3", $highlight3);
$stmt->bindParam(":highlight4", $highlight4);
$stmt->bindParam(":highlight5", $highlight5);
$stmt->bindParam(":highlight6", $highlight6);
$stmt->bindParam(":highlight7", $highlight7);
$stmt->bindParam(":highlight8", $highlight8);
$stmt->bindParam(":status", $status);
$stmt->bindParam(":imgContent", $image);
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
