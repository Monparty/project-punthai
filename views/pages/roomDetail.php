<?php 
include ("../../config/config.php");
session_start();

$room_id = $_REQUEST['id'];
$sql = "SELECT * FROM users, rooms WHERE room_id=$room_id";
$query = mysqli_query( $c, $sql );
// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

foreach ($stmt as $i=>$fetch) {
  
  // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
  $image_base64[$i] = $fetch["image"];
  $image_base642[$i] = $fetch["image2"];
  $image_base643[$i] = $fetch["image3"];
  $image_base644[$i] = $fetch["image4"];
  $image_base645[$i] = $fetch["image5"];

  // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
  $image = base64_decode($image_base64[$i]);
  $image2 = base64_decode($image_base642[$i]);
  $image3 = base64_decode($image_base643[$i]);
  $image4 = base64_decode($image_base644[$i]);
  $image5 = base64_decode($image_base645[$i]);

  // แสดงผลรูปภาพ
  $showimg[$i] = '<img src="data:$image/png;base64,' . $image_base64[$i] . '" style="width: 100%; height: 310px; object-fit: cover; border-radius: 5px;"/>';

  if ($fetch["image2"]!="") {
    $showimg2[$i] = '<img src="data:$image2/png;base64,' . $image_base642[$i] . '" style="width: 200px; height: 150px; object-fit: cover; border-radius: 5px;"/>';
  } else {
    $showimg2[$i] = '<img src="../../imgs/noImage.png">';
  }

  if ($fetch["image3"]!="") {
    $showimg3[$i] = '<img src="data:$image3/png;base64,' . $image_base643[$i] . '" style="width: 200px; height: 150px; object-fit: cover; border-radius: 5px;"/>';
  } else {
    $showimg3[$i] = '<img src="../../imgs/noImage.png">';
  }

  if ($fetch["image4"]!="") {
    $showimg4[$i] = '<img src="data:$image4/png;base64,' . $image_base644[$i] . '" style="width: 200px; height: 150px; object-fit: cover; border-radius: 5px;"/>';
  } else {
    $showimg4[$i] = '<img src="../../imgs/noImage.png">';
  }

  if ($fetch["image5"]!="") {
    $showimg5[$i] = '<img src="data:$image5/png;base64,' . $image_base645[$i] . '" style="width: 200px; height: 150px; object-fit: cover; border-radius: 5px;"/>';
  } else {
    $showimg5[$i] = '<img src="../../imgs/noImage.png">';
  }
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
            window.location = "payment.php?room_id=' . $room_id . '";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}


include ("roomDetail.html");
?>