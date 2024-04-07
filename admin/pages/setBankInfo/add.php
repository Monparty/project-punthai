<?php 
include("../../../config/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $bank_name = $_POST["bank_name"];
  $account_name = $_POST["account_name"];
  $account_number = $_POST["account_number"];
  $status = implode($_POST["status"]);
  $bank_image = file_get_contents($_FILES["bank_image"]["tmp_name"]);
  $image_base64 = base64_encode($bank_image);

  $sql = "INSERT INTO bank_info (bank_name, account_name, account_number, status, bank_image, create_at)
  VALUES (:bank_name, :account_name, :account_number, :status, :image_base64, CURRENT_TIMESTAMP)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":bank_name", $bank_name);
  $stmt->bindParam(":account_name", $account_name);
  $stmt->bindParam(":account_number", $account_number);
  $stmt->bindParam(":status", $status);
  $stmt->bindParam(":image_base64", $image_base64);
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
