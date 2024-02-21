<?php 
include ("../../config/config.php");
session_start();

$meetRoom_id = $_REQUEST['meetRoom_id'];
$sql = "SELECT * FROM users, meetrooms WHERE meetRoom_id=$meetRoom_id";
$query = mysqli_query( $c, $sql );
// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

foreach ($stmt as $i=>$fetch) {
  
  // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
  $image_base64[$i] = $fetch["meetroom_image"];

  // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
  $meetroom_image = base64_decode($image_base64[$i]);

  // แสดงผลรูปภาพ
  $showimg[$i] = '<img src="data:$meetroom_image/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: 310px; object-fit: cover; border-radius: 5px; transition: .3s;"/>';
}

// ส่วนบันทึกข้อมูลการจอง
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $user_id = $_SESSION["user_id"];
  $room_id = $fetch["room_id"];
  $booker_name = isset($_POST["booker_name"]) ? $_POST["booker_name"] : "";
  $email = isset($_POST["email"]) ? $_POST["email"] : "";
  $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
  $booking_type = isset($_POST["booking_type"]) ? $_POST["booking_type"] : "";
  $check_in_date = isset($_POST["check_in_date"]) ? $_POST["check_in_date"] : "";
  $check_out_date = isset($_POST["check_out_date"]) ? $_POST["check_out_date"] : "";
  $booking_type = isset($_POST["booking_type"]) ? $_POST["booking_type"] : "";

  $sql = "INSERT INTO bookings (user_id, room_id, booker_name, email, phone,check_in_date, check_out_date, booking_type, createAt)
  VALUES (:user_id, :room_id, :booker_name, :email, :phone, :check_in_date, :check_out_date, :booking_type, CURRENT_TIMESTAMP)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":user_id", $user_id);
  $stmt->bindParam(":room_id", $room_id);
  $stmt->bindParam(":booker_name", $booker_name);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":phone", $phone);
  $stmt->bindParam(":check_in_date", $check_in_date);
  $stmt->bindParam(":check_out_date", $check_out_date);
  $stmt->bindParam(":booking_type", $booking_type);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการจองสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "payment.php?meetRoom_id=' . $meetRoom_id . '";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}


include ("meerRoomDetail.html");
?>