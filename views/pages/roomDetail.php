<?php 
include ("../../config/config.php");
session_start();

$sql = "SELECT * FROM rooms, users";
$query = mysqli_query( $c, $sql );
// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);
echo $fetch["id"];

foreach ($stmt as $i=>$fetch) {

// แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
$image_base64[$i] = $fetch["image"];

// แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
$image = base64_decode($image_base64[$i]);

// แสดงผลรูปภาพ
$showimg[$i] = '<img src="data:$image/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: 310px; object-fit: cover; border-radius: 4px; transition: .3s;"/>';
}

// ส่วนบันทึกข้อมูลการจอง
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$use_id = $fetch["id"];
$booker_name = isset($_POST["booker_name"]) ? $_POST["booker_name"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
$booking_type = isset($_POST["booking_type"]) ? $_POST["booking_type"] : "";

$sql = "INSERT INTO bookings (booker_name, email, phone, booking_type, createAt)
VALUES (:booker_name, :email, :phone, :booking_type, CURRENT_TIMESTAMP)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":booker_name", $booker_name);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":phone", $phone);
$stmt->bindParam(":booking_type", $booking_type);
$stmt->execute();

if ($stmt->rowCount() > 0) {
  echo '<script>
      setTimeout(function() {
      swal({
          title: "บันทึกข้อมูลการจองสำเร็จ",  
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


include ("roomDetail.html");
?>