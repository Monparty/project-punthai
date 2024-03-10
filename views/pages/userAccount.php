<?php
include("../../config/config.php");
session_start();

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM users WHERE user_id=$user_id";
$query = mysqli_query($c, $sql);
$stmt = $conn->prepare($sql);
$stmt->execute();
$fetch = mysqli_fetch_assoc($query);

// ส่วนบันทึกข้อมูล User
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sql = "UPDATE users SET name=:name, username=:username, email=:email, phone_number=:phone_number, gender=:gender, birth_date=:birth_date, address=:address, update_at=CURRENT_TIMESTAMP WHERE user_id=$user_id";

    $stmt = $conn->prepare($sql);
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $phone_number = isset($_POST["phone_number"]) ? $_POST["phone_number"] : "";
    $gender = $_POST["gender"];
    $birth_date = isset($_POST["birth_date"]) ? $_POST["birth_date"] : "";
    $address = isset($_POST["address"]) ? $_POST["address"] : "";

    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone_number", $phone_number);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":birth_date", $birth_date);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":address", $address);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo '<script>
        setTimeout(function() {
        swal({
            title: "อัพเดทข้อมูลบัญชีเรียบร้อย",  
            type: "success"
        }, function() {
            window.location = "userAccount.php";
        });
        }, 1000);
      </script>';
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
    }
}

include("userAccount.html");
