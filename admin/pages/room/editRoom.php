<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$room_id = $_REQUEST['id'];
$sql = "SELECT * FROM rooms WHERE room_id=$room_id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();

// วนลูปเพื่อดึงข้อมูลรูปภาพ
foreach ($stmt as $fetch) {

    // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
    $image_base64 = $fetch["image"];
    $image_base642 = $fetch["image2"];
    $image_base643 = $fetch["image3"];
    $image_base644 = $fetch["image4"];
    $image_base645 = $fetch["image5"];

    // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
    $image = base64_decode($image_base64);
    $image2 = base64_decode($image_base642);
    $image3 = base64_decode($image_base643);
    $image4 = base64_decode($image_base644);
    $image5 = base64_decode($image_base645);

    // แสดงผลรูปภาพ
    $showimg = '<img src="data:$image/png;base64,' . $image_base64 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
    if ($fetch["image2"]!="") {
    $showimg2 = '<img src="data:$image2/png;base64,' . $image_base642 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
  } else {
    $showimg2 = '<img src="../../../imgs/noImage.png" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;">';
  }

  if ($fetch["image3"]!="") {
    $showimg3 = '<img src="data:$image3/png;base64,' . $image_base643 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
  } else {
    $showimg3 = '<img src="../../../imgs/noImage.png" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;">';
  }

  if ($fetch["image4"]!="") {
    $showimg4 = '<img src="data:$image4/png;base64,' . $image_base644 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
  } else {
    $showimg4 = '<img src="../../../imgs/noImage.png" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;">';
  }

  if ($fetch["image5"]!="") {
    $showimg5 = '<img src="data:$image5/png;base64,' . $image_base645 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
  } else {
    $showimg5 = '<img src="../../../imgs/noImage.png" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;">';
  }
}

$sql_room_type = "SELECT * FROM room_type WHERE status = 'Active'";
$query_room_type = mysqli_query( $c, $sql_room_type );

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE rooms SET name=:name, roomdesc=:roomdesc, price=:price, roomabout=:roomabout, bed=:bed, amountpeople=:amountpeople, facility1=:facility1, facility2=:facility2, facility3=:facility3, facility4=:facility4, facility5=:facility5, facility6=:facility6, facility7=:facility7, facility8=:facility8, status=:status, room_number=:room_number, image=:image_base64, image2=:image_base642, image3=:image_base643, image4=:image_base644, image5=:image_base645, updateAt=CURRENT_TIMESTAMP WHERE room_id=$room_id";
    
    $stmt = $conn->prepare($sql);
    $name = $_POST['name'];
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
    $status = implode($_POST["status"]);
    $room_number = $_POST["room_number"];

    if($_FILES["image"]["tmp_name"]!=""){
      $image = file_get_contents($_FILES["image"]["tmp_name"]);
      $image_base64 = base64_encode($image);
    } else {
      $image_base64 = $fetch["image"];
    };

    if($_FILES["image2"]["tmp_name"]!=""){
        $image2 = file_get_contents($_FILES["image2"]["tmp_name"]);
        $image_base642 = base64_encode($image2);
    } else {
      $image_base642 = $fetch["image2"];
    };
    if($_FILES["image3"]["tmp_name"]!=""){
        $image3 = file_get_contents($_FILES["image3"]["tmp_name"]);
        $image_base643 = base64_encode($image3);
    } else {
      $image_base643 = $fetch["image3"];
    };
    if($_FILES["image4"]["tmp_name"]!=""){
        $image4 = file_get_contents($_FILES["image4"]["tmp_name"]);
        $image_base644 = base64_encode($image4);
    } else {
      $image_base644 = $fetch["image4"];
    };
    if($_FILES["image5"]["tmp_name"]!=""){
        $image5 = file_get_contents($_FILES["image5"]["tmp_name"]);
        $image_base645 = base64_encode($image5);
    } else {
      $image_base645 = $fetch["image5"];
    };

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
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":room_number", $room_number);
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
            title: "แก้ไขข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "roomList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("editRoom.html");
?>