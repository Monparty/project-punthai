<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$meetroom_id = $_REQUEST['id'];
$sql = "SELECT * FROM meetrooms WHERE meetroom_id=$meetroom_id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();

// วนลูปเพื่อดึงข้อมูลรูปภาพ
foreach ($stmt as $row) {

    // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
    $image_base64 = $row["meetroom_image"];

    // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
    $meetroom_image = base64_decode($image_base64);

    // แสดงผลรูปภาพ
    $showimg = '<img src="data:$meetroom_image/png;base64,' . $image_base64 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
}

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE meetrooms SET name=:name, roomdesc=:roomdesc, price=:price, roomabout=:roomabout, bed=:bed, amountpeople=:amountpeople, facility1=:facility1, facility2=:facility2, facility3=:facility3, facility4=:facility4, facility5=:facility5, facility6=:facility6, facility7=:facility7, facility8=:facility8, highlight1=:highlight1, highlight2=:highlight2, highlight3=:highlight3, highlight4=:highlight4, highlight5=:highlight5, highlight6=:highlight6, highlight7=:highlight7, highlight8=:highlight8, status=:status, image=:image_base64, updateAt=CURRENT_TIMESTAMP WHERE room_id=$room_id";
    
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
    $facility9 = isset($_POST['facility9']) ? $_POST['facility9'] : "";
    $facility10 = isset($_POST['facility10']) ? $_POST['facility10'] : "";

    $status = implode($_POST["status"]);
    if($_FILES["image"]["tmp_name"]){
        $image = file_get_contents($_FILES["image"]["tmp_name"]);
        $image_base64 = base64_encode($image);
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
    $stmt->bindParam(":facility9", $facility9);
    $stmt->bindParam(":facility10", $facility10);
    $stmt->bindParam(":status", $status);
    if($image_base64){
        $stmt->bindParam(":image_base64", $image_base64);
    };
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "แก้ไขข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "meetRoomList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("editMeetRoom.html");
?>