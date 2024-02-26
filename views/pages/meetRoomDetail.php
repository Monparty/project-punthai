<?php 
include ("../../config/config.php");
session_start();

$meetroom_id = $_REQUEST['meetroom_id'];
$sql = "SELECT * FROM users, meetrooms WHERE meetroom_id=$meetroom_id";
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
  $meetroom_id = $fetch["meetroom_id"];
  $booker_name = isset($_POST["booker_name"]) ? $_POST["booker_name"] : "";
  $email = isset($_POST["email"]) ? $_POST["email"] : "";
  $phone = isset($_POST["phone"]) ? $_POST["phone"] : "";
  $amountpeople = isset($_POST["amountpeople"]) ? $_POST["amountpeople"] : "";
  $meeting_topic = isset($_POST["meeting_topic"]) ? $_POST["meeting_topic"] : "";
  $start_date = isset($_POST["start_date"]) ? $_POST["start_date"] : "";
  $end_date = isset($_POST["end_date"]) ? $_POST["end_date"] : "";
  $catering = isset($_POST["catering"]) ? $_POST["catering"] : "";
  $catering_type = isset($_POST["catering_type"]) ? $_POST["catering_type"] : "";

  $snack1 = isset($_POST["snack1"]) ? $_POST["snack1"] : "";
  $snack1_amount = isset($_POST["snack1_amount"]) ? $_POST["snack1_amount"] : "";
  $snack2 = isset($_POST["snack2"]) ? $_POST["snack2"] : "";
  $snack2_amount = isset($_POST["snack2_amount"]) ? $_POST["snack2_amount"] : "";
  $snack3 = isset($_POST["snack3"]) ? $_POST["snack3"] : "";
  $snack3_amount = isset($_POST["snack3_amount"]) ? $_POST["snack3_amount"] : "";

  $lunch1 = isset($_POST["lunch1"]) ? $_POST["lunch1"] : "";
  $lunch1_amount = isset($_POST["lunch1_amount"]) ? $_POST["lunch1_amount"] : "";
  $lunch2 = isset($_POST["lunch2"]) ? $_POST["lunch2"] : "";
  $lunch2_amount = isset($_POST["lunch2_amount"]) ? $_POST["lunch2_amount"] : "";
  $lunch3 = isset($_POST["lunch3"]) ? $_POST["lunch3"] : "";
  $lunch3_amount = isset($_POST["lunch3_amount"]) ? $_POST["lunch3_amount"] : "";

  $buffet1 = isset($_POST["buffet1"]) ? $_POST["buffet1"] : "";
  $buffet2 = isset($_POST["buffet2"]) ? $_POST["buffet2"] : "";
  $buffet3 = isset($_POST["buffet3"]) ? $_POST["buffet3"] : "";
  $remark = isset($_POST["remark"]) ? $_POST["remark"] : "";

  $sql = "INSERT INTO meetroom_bookings (user_id, meetroom_id, booker_name, email, phone, amountpeople, meeting_topic, start_date, end_date, catering, catering_type, snack1, snack1_amount, snack2, snack2_amount, snack3, snack3_amount, lunch1, lunch1_amount, lunch2, lunch2_amount, lunch3, lunch3_amount, buffet1, buffet2, buffet3, remark, create_at)
  VALUES (:user_id, :meetroom_id, :booker_name, :email, :phone, :amountpeople, :meeting_topic, :start_date, :end_date, :catering, :catering_type, :snack1, :snack1_amount, :snack2, :snack2_amount, :snack3, :snack3_amount, :lunch1, :lunch1_amount, :lunch2, :lunch2_amount, :lunch3, :lunch3_amount, :buffet1, :buffet2, :buffet3, :remark, CURRENT_TIMESTAMP)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":user_id", $user_id);
  $stmt->bindParam(":meetroom_id", $meetroom_id);
  $stmt->bindParam(":booker_name", $booker_name);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":phone", $phone);
  $stmt->bindParam(":amountpeople", $amountpeople);
  $stmt->bindParam(":meeting_topic", $meeting_topic);
  $stmt->bindParam(":start_date", $start_date);
  $stmt->bindParam(":end_date", $end_date);
  $stmt->bindParam(":catering", $catering);
  $stmt->bindParam(":catering_type", $catering_type);

  $stmt->bindParam(":snack1", $snack1);
  $stmt->bindParam(":snack1_amount", $snack1_amount);
  $stmt->bindParam(":snack2", $snack2);
  $stmt->bindParam(":snack2_amount", $snack2_amount);
  $stmt->bindParam(":snack3", $snack3);
  $stmt->bindParam(":snack3_amount", $snack3_amount);

  $stmt->bindParam(":lunch1", $lunch1);
  $stmt->bindParam(":lunch1_amount", $lunch1_amount);
  $stmt->bindParam(":lunch2", $lunch2);
  $stmt->bindParam(":lunch2_amount", $lunch2_amount);
  $stmt->bindParam(":lunch3", $lunch3);
  $stmt->bindParam(":lunch3_amount", $lunch3_amount);

  $stmt->bindParam(":buffet1", $buffet1);
  $stmt->bindParam(":buffet2", $buffet2);
  $stmt->bindParam(":buffet3", $buffet3);
  $stmt->bindParam(":remark", $remark);
  $stmt->execute();


  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลการจองสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "meetRoomPayment.php";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}


include ("meetRoomDetail.html");
?>