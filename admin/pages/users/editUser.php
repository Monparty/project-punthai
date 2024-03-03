<?php 
include("../../../config/config.php");
session_start();

// ใช้สำหรับแสดงข้อมูลตาม ID ที่เลือกมา
$user_id = $_REQUEST['user_id'];
$sql = "SELECT * FROM users WHERE user_id=$user_id";
$result = mysqli_query($c, $sql);
$row = mysqli_fetch_array($result);
extract($row);
$stmt = $conn->prepare($sql);
$stmt->execute();

// ใช้สำหรับ Update ข้อมูลจะทำงานเมื่อกดปุ่ม update
if (isset($_REQUEST['update'])) {
    $sql = "UPDATE users SET username=:username, email=:email, phone_number=:phone_number, gender=:gender, birth_date=:birth_date, address=:address, position=:position, status=:status, update_at=CURRENT_TIMESTAMP WHERE user_id=$user_id";
    
    $stmt = $conn->prepare($sql);
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $confirm_password = $_POST["confirm_password"];
    $gender = $_POST["gender"];
    $birth_date = $_POST["birth_date"];
    $address = $_POST["address"];
    $position = implode($_POST["position"]);
    $status = implode($_POST["status"]);

    // ทำแก้ไขรหัสผ่านยังไม่ได้
    /*
    if($_POST["password"]){
        $password = $_POST["password"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    };
    */
    


    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone_number", $phone_number);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":birth_date", $birth_date);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":position", $position);
    $stmt->bindParam(":status", $status);
    /*
    if($hashedPassword){
        $stmt->bindParam(":hashedPassword", $hashedPassword);
    };
    */
    $stmt->execute();



    if ($stmt->rowCount() > 0) {
    echo '<script>
        setTimeout(function() {
        swal({
            title: "แก้ไขข้อมูลสำเร็จ",  
            type: "success"
        }, function() {
            window.location = "userList.php";
        });
        }, 1000);
        </script>';
    } else {
    echo "เกิดข้อผิดพลาดในการแก้ไขข้อมูล";
    }
}

include ("editUser.html");
?>