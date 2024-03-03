<?php 
include("../../../config/config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST["username"];
  $email = $_POST["email"];
  $phone_number = $_POST["phone_number"];
  $password = $_POST["password"];
  $confirm_password = $_POST["confirm_password"];
  $gender = $_POST["gender"];
  $birth_date = $_POST["birth_date"];
  $address = $_POST["address"];
  $position = implode($_POST["position"]);
  $status = implode($_POST["status"]);

  // ตรวจสอบว่ารหัสผ่านตรงกัน
  if ($password != $confirm_password) {
    echo '<script>
            setTimeout(function() {
            swal({
                title: "รหัสผ่านไม่ตรงกัน !!",  
                text: "กรุณาระบุรหัสผ่านให้ตรงกัน",
                type: "warning"
            }, function() {
                window.location = "addUser.php";
            });
          }, 1000);
        </script>';
    exit();
  }

  // ตรวจสอบว่าชื่อผู้ใช้มีอยู่แล้ว
  $sql = "SELECT * FROM users WHERE username = :username";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":username", $username);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
            setTimeout(function() {
            swal({
                title: "ชื่อผู้ใช้นี้มีอยู่แล้ว !!",  
                text: "โปรดใช้ชื่ออื่น",
                type: "warning"
            }, function() {
                window.location = "addUser.php";
            });
          }, 1000);
        </script>';
    exit();
  }

  $sql = "SELECT * FROM users WHERE email = :email";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":email", $email);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
            setTimeout(function() {
            swal({
                title: "อีเมลนี้มีผู้ใช้งานแล้ว !!",  
                text: "โปรดใช้อีเมลอื่น",
                type: "warning"
            }, function() {
                window.location = "addUser.php";
            });
          }, 1000);
          </script>';
    exit();
  }

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  

  $sql = "INSERT INTO users (username, email, phone_number, password, position, gender, birth_date, address, status, create_at)
  VALUES (:username, :email, :phone_number, :hashedPassword, :position, :gender, :birth_date, :address, :status, CURRENT_TIMESTAMP)";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":username", $username);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":phone_number", $phone_number);
  $stmt->bindParam(":hashedPassword", $hashedPassword);
  $stmt->bindParam(":position", $position);
  $stmt->bindParam(":gender", $gender);
  $stmt->bindParam(":birth_date", $birth_date);
  $stmt->bindParam(":address", $address);
  $stmt->bindParam(":status", $status);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "บันทึกข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "userList.php";
        });
        }, 1000);
      </script>';
      
  } else {
    echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
  }
}

include ("addUser.html");
?>
