<?php 
session_start();
/*
    // บันทึก ข้อมูลเข้า DB
    $sql = "INSERT INTO users(username, email, phone_number, password) VALUE(:username, :email, :phone_number, :password)";
    $query = $conn->prepare($sql);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->bindParam(":phone_number", $phone_number, PDO::PARAM_STR);
    $query->bindParam(":password", $password, PDO::PARAM_STR);


    $username = "usasna na";
    $email = "nana@gmail.com";
    $phone_number ="192";
    $password = "na23445";

    $result = $query->execute();
    if ($result) {
        echo "<script>alert('เพิ่มข้อมูลเรียบร้อย')</script>";
    } else {
        echo "<script>alert('มีบางอย่างผิดพลาด')</script>";
    }
*/

/*
    // แสดง ข้อมูลจาก DB
    $sql = "SELECT * FROM users WHERE email = :email";
    $query = $conn->prepare($sql);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $email = "mon@gmail.com";
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        foreach ($result as $res) {
            echo $res->username . "<br>";
            echo $res->email . "<br>";
            echo $res->phone_number . "<br>";
            echo $res->password . "<br>";
        }
    }

*/


/*
    // Update ข้อมูล
    $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->bindParam(":id", $id, PDO::PARAM_STR);

    $username = "maii maii";
    $email = "maill@gmail.com";
    $id = 1;
    $query->execute();
    if ($query->rowCount() > 0) {
        echo "<script>alert('แก้ไขมูลเรียบร้อย')</script>";
    } else {
        echo "<script>alert('มีบางอย่างผิดพลาด')</script>";
    }
*/

/*
    $sql = "DELETE FROM users WHERE id = :id";
    $query = $conn->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_STR);
    $id = 3;
    $query->execute();
    if ($query->rowCount() > 0) {
        echo "<script>alert('ลบมูลเรียบร้อย')</script>";
    } else {
        echo "<script>alert('มีบางอย่างผิดพลาด')</script>";
    }
*/

    include ("homePage.html");
?>