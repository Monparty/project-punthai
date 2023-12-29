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
$facility = implode(",", $_POST["facility"]);
$highlight = implode(",", $_POST["highlight"]);
$status = implode(",", $_POST["status"]);

$sql = "INSERT INTO rooms (name, roomdesc, price, roomabout,  bed, amountpeople, facility, highlight, status, createAt)
VALUES (:name, :roomdesc, :price, :roomabout, :bed, :amountpeople, :facility, :highlight, :status, CURRENT_TIMESTAMP)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":name", $name);
$stmt->bindParam(":roomdesc", $roomdesc);
$stmt->bindParam(":price", $price);
$stmt->bindParam(":roomabout", $roomabout);
$stmt->bindParam(":bed", $bed);
$stmt->bindParam(":amountpeople", $amountpeople);
$stmt->bindParam(":facility", $facility);
$stmt->bindParam(":highlight", $highlight);
$stmt->bindParam(":status", $status);
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
