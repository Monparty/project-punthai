<?php 
include("../../../config/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = $_POST["name"];
  $image_svg = $_POST["image_svg"];
  $status = implode($_POST["status"]);

  $sql = "INSERT INTO facility_info (name, image_svg, status, create_at)
  VALUES (:name, :image_svg, :status, CURRENT_TIMESTAMP)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":image_svg", $image_svg);
  $stmt->bindParam(":status", $status);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "list.php";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}
include ("add.html");
?>
