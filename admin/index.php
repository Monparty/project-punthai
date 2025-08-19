<?php 
require_once '../config/config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // รับข้อมูลจากฟอร์ม
    $username = $_POST["username"];
    $password = $_POST["password"];

    // ตรวจสอบว่า ชื่อผู้ใช้และรหัสผ่านถูกต้องหรือไม่
    $sql = "SELECT * FROM users WHERE username = :username AND position IN ('admin', 'employee')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    
    if ($stmt->rowCount() == 1) {
        $data = $stmt->fetch();
        $hashedPassword = $data['password'];

        if (password_verify($password, $hashedPassword)) {   
            $_SESSION["username"] = $data["username"];
            $_SESSION["name"] = $data["name"];
            $_SESSION["email"] = $data["email"];
            $_SESSION["user_id"] = $data["user_id"];
            $_SESSION["phone_number"] = $data["phone_number"] ?? "";

            //เปลี่ยนเส้นท่าไปยังหน้าหลัก
            echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "เข้าสู่ระบบสำเร็จ",  
                        type: "success"
                    }, function() {
                        window.location = "pages/dashboard/dashboard.php";
                    });
                    }, 1000);
                </script>';
            } else {
            //หากเข้าสู่ระบบไม่สำเร็จ
                echo '<script>
                            setTimeout(function() {
                            swal({
                                title: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง !!",  
                                text: "กรุณาลองใหม่อีกครั้ง",
                                type: "warning"
                            }, function() {
                                window.location = "index.php";
                            });
                        }, 1000);
                    </script>';
                }
    } else {
        //หากเข้าสู่ระบบไม่สำเร็จ
        echo '<script>
                    setTimeout(function() {
                    swal({
                        title: "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง !!",
                        text: "กรุณาลองใหม่อีกครั้ง",
                        type: "warning"
                    }, function() {
                        window.location = "index.php";
                    });
                }, 1000);
            </script>';
    }
}
include ("index.html");
?>

