<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$id = $_REQUEST['id'];
$sql = "SELECT * FROM rooms WHERE id=$id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);

// ใช้แสดงรูปภาพ
$stmt = $conn->prepare($sql);
$stmt->execute();

// วนลูปเพื่อดึงข้อมูลรูปภาพ
while ($row = $stmt->fetch()) {

    // แปลงข้อมูลรูปภาพจากฐานข้อมูลเป็นฐาน64
    $image_base64 = $row["image"];

    // แปลงข้อมูลรูปภาพจากฐาน64เป็นข้อมูลรูปภาพ
    $image = base64_decode($image_base64);

    // แสดงผลรูปภาพ
    $showimg = '<img src="data:$image/png;base64,' . $image_base64 . '" style="width: 100%; height: 300px; object-fit: cover; border-radius: 4px;"/>';
}

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $id = $_POST['id'];
    $sql = "UPDATE rooms SET name=:name, roomdesc=:roomdesc, price=:price, roomabout=:roomabout, bed=:bed, amountpeople=:amountpeople, facility1=:facility1, facility2=:facility2, facility3=:facility3, facility4=:facility4, facility5=:facility5, facility6=:facility6, facility7=:facility7, facility8=:facility8, highlight1=:highlight1, highlight2=:highlight2, highlight3=:highlight3, highlight4=:highlight4, highlight5=:highlight5, highlight6=:highlight6, highlight7=:highlight7, highlight8=:highlight8, status=:status, image=:image_base64, updateAt=CURRENT_TIMESTAMP WHERE id=$id";
    
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
    $highlight1 = isset($_POST['highlight1']) ? $_POST['highlight1'] : "";
    $highlight2 = isset($_POST['highlight2']) ? $_POST['highlight2'] : "";
    $highlight3 = isset($_POST['highlight3']) ? $_POST['highlight3'] : "";
    $highlight4 = isset($_POST['highlight4']) ? $_POST['highlight4'] : "";
    $highlight5 = isset($_POST['highlight5']) ? $_POST['highlight5'] : "";
    $highlight6 = isset($_POST['highlight6']) ? $_POST['highlight6'] : "";
    $highlight7 = isset($_POST['highlight7']) ? $_POST['highlight7'] : "";
    $highlight8 = isset($_POST['highlight8']) ? $_POST['highlight8'] : "";
    $status = implode($_POST["status"]);
    $image = file_get_contents($_FILES["image"]["tmp_name"]);
    $image_base64 = base64_encode($image);

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
    $stmt->bindParam(":image_base64", $image_base64);
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