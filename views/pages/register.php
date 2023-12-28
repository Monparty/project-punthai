<?php 
require_once '../../config/config.php';
session_start();

// ตรวจสอบว่าฟอร์มถูกส่งหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {

// รับข้อมูลจากฟอร์ม
$username = $_POST["username"];
$email = $_POST["email"];
$phone_number = $_POST["phone_number"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

// ตรวจสอบว่ารหัสผ่านตรงกัน
if ($password != $confirm_password) {
  echo '<script>
            setTimeout(function() {
            swal({
                title: "รหัสผ่านไม่ตรงกัน !!",  
                text: "กรุณาระบุรหัสผ่านให้ตรงกัน",
                type: "warning"
            }, function() {
                window.location = "register.php";
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
                window.location = "register.php";
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
                window.location = "register.php";
            });
          }, 1000);
          </script>';
  exit();
}

// บันทึกข้อมูลผู้ใช้ใหม่ลงในฐานข้อมูล
$sql = "INSERT INTO users (username, email, phone_number,  password) VALUES (:username, :email, :phone_number, :password)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":username", $username);
$stmt->bindParam(":email", $email);
$stmt->bindParam(":phone_number", $phone_number);
$stmt->bindParam(":password", $password);
$stmt->execute();

// แจ้งให้ผู้ใช้ทราบว่าสมัครสมาชิกสำเร็จ
echo '<script>
          setTimeout(function() {
          swal({
              title: "สมัครสมาชิกสำเร็จ",  
              type: "success"
          }, function() {
              window.location = "login.php";
          });
          }, 1000);
        </script>';
}

include ("register.html");
?>

