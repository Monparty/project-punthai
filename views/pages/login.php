<?php 
require_once '../../config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // รับข้อมูลจากฟอร์ม
    $username = $_POST["username"];
    $password = $_POST["password"];

    // ตรวจสอบว่า ชื่อผู้ใช้และรหัสผ่านถูกต้องหรือไม่
    $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {

        //เข้าสู่ระบบสำเร็จ
        $_SESSION["username"] =  $username;
        $_SESSION["user_id"] = $stmt->fetch()["user_id"];

        //เปลี่ยนเส้นท่าไปยังหน้าหลัก
        echo '<script>
                setTimeout(function() {
                swal({
                    title: "เข้าสู่ระบบสำเร็จ",  
                    type: "success"
                }, function() {
                    window.location = "homepage.php";
                });
                }, 1000);
            </script>';
    } else {

        //หากเข้าสู่ระบบไม่สำเร็จ
        echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "ชื่อผู้ให้หรือรหัสผ่านไม่ถูกต้อง !!",  
                        text: "กรุณาลองใหม่อีกครั้ง",
                        type: "warning"
                    }, function() {
                        window.location = "login.php";
                    });
                }, 1000);
            </script>';
    }
}
include ("login.html");
?>

