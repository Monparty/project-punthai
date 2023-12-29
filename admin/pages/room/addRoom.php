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

$facility = $_POST["facility"];
$facility_string = implode(",", $facility);

$highlight = $_POST["highlight"];
$highlight_string = implode(",", $highlight);

$status = $_POST["status"];
$status_string = implode(",", $status);


$sql = "INSERT INTO rooms (name, roomdesc, price, roomabout,  bed, amountpeople, facility, highlight, status) 
                    VALUES (:name, :roomdesc, :price, :roomabout, :bed, :amountpeople, :facility_string, :highlight_string, :status_string)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":name", $name);
$stmt->bindParam(":roomdesc", $roomdesc);
$stmt->bindParam(":price", $price);
$stmt->bindParam(":roomabout", $roomabout);
$stmt->bindParam(":bed", $bed);
/*
$stmt->bindParam(":amountpeople", $amountpeople);
$stmt->bindParam(":facility_string", $facility);
$stmt->bindParam(":highlight_string", $highlight);
$stmt->bindParam(":status_string", $status);
*/
$stmt->execute();

if ($stmt->rowCount() > 0) {
  echo "บันทึกข้อมูลสำเร็จ";
} else {
  echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
}

}
include ("addRoom.html");
?>
